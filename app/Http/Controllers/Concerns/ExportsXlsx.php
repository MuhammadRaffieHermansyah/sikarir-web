<?php

namespace App\Http\Controllers\Concerns;

use RuntimeException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

/**
 * Membuat file Excel (.xlsx) berisi satu tabel rapi tanpa dependensi tambahan:
 * judul laporan, keterangan, header berwarna, border, baris selang-seling,
 * lebar kolom otomatis, header dibekukan, dan filter otomatis.
 */
trait ExportsXlsx
{
    /**
     * @param  list<string>  $header
     * @param  list<array<int, mixed>>  $rows
     */
    protected function xlsx(string $fileName, string $title, array $header, array $rows, ?string $keterangan = null): BinaryFileResponse
    {
        $path = tempnam(sys_get_temp_dir(), 'xlsx');
        $zip = new ZipArchive;

        if ($zip->open($path, ZipArchive::OVERWRITE) !== true) {
            throw new RuntimeException('Gagal membuat file Excel.');
        }

        $zip->addFromString('[Content_Types].xml', $this->xlsxContentTypes());
        $zip->addFromString('_rels/.rels', $this->xlsxRootRels());
        $zip->addFromString('xl/workbook.xml', $this->xlsxWorkbook($title));
        $zip->addFromString('xl/_rels/workbook.xml.rels', $this->xlsxWorkbookRels());
        $zip->addFromString('xl/styles.xml', $this->xlsxStyles());
        $zip->addFromString('xl/worksheets/sheet1.xml', $this->xlsxSheet($title, $header, $rows, $keterangan));
        $zip->close();

        return response()
            ->download($path, $fileName.'-'.now()->format('Ymd-His').'.xlsx', [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ])
            ->deleteFileAfterSend();
    }

    /**
     * @param  list<string>  $header
     * @param  list<array<int, mixed>>  $rows
     */
    private function xlsxSheet(string $title, array $header, array $rows, ?string $keterangan): string
    {
        $columnCount = count($header);
        $lastColumn = $this->xlsxColumn($columnCount);
        $headerRow = 4;
        $lastRow = $headerRow + max(count($rows), 1);

        $subtitle = 'UPT BLK Jember · Dicetak '.now()->format('d/m/Y H:i').' · '.count($rows).' data';
        if ($keterangan) {
            $subtitle .= ' · '.$keterangan;
        }

        $xml = '<row r="1" ht="24" customHeight="1">'.$this->xlsxCell('A1', $title, 1).'</row>';
        $xml .= '<row r="2">'.$this->xlsxCell('A2', $subtitle, 2).'</row>';

        $xml .= '<row r="'.$headerRow.'" ht="22" customHeight="1">';
        foreach ($header as $i => $label) {
            $xml .= $this->xlsxCell($this->xlsxColumn($i + 1).$headerRow, $label, 3);
        }
        $xml .= '</row>';

        foreach ($rows as $r => $row) {
            $rowNumber = $headerRow + $r + 1;
            $zebra = $r % 2 === 1;
            $xml .= '<row r="'.$rowNumber.'">';
            foreach (array_values($row) as $i => $value) {
                $isNumber = is_int($value) || is_float($value);
                $style = $isNumber ? ($zebra ? 7 : 6) : ($zebra ? 5 : 4);
                $xml .= $this->xlsxCell($this->xlsxColumn($i + 1).$rowNumber, $value ?? '-', $style);
            }
            $xml .= '</row>';
        }

        if ($rows === []) {
            $xml .= '<row r="'.$lastRow.'">'.$this->xlsxCell('A'.$lastRow, 'Belum ada data.', 4).'</row>';
        }

        $cols = '';
        foreach ($this->xlsxColumnWidths($header, $rows) as $i => $width) {
            $cols .= '<col min="'.($i + 1).'" max="'.($i + 1).'" width="'.$width.'" customWidth="1"/>';
        }

        $merges = '<mergeCell ref="A1:'.$lastColumn.'1"/><mergeCell ref="A2:'.$lastColumn.'2"/>';
        if ($rows === []) {
            $merges .= '<mergeCell ref="A'.$lastRow.':'.$lastColumn.$lastRow.'"/>';
        }

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            .'<sheetPr><pageSetUpPr fitToPage="1"/></sheetPr>'
            .'<dimension ref="A1:'.$lastColumn.$lastRow.'"/>'
            .'<sheetViews><sheetView workbookViewId="0" showGridLines="0">'
            .'<pane ySplit="'.$headerRow.'" topLeftCell="A'.($headerRow + 1).'" activePane="bottomLeft" state="frozen"/>'
            .'</sheetView></sheetViews>'
            .'<sheetFormatPr defaultRowHeight="18"/>'
            .'<cols>'.$cols.'</cols>'
            .'<sheetData>'.$xml.'</sheetData>'
            .($rows !== [] ? '<autoFilter ref="A'.$headerRow.':'.$lastColumn.$lastRow.'"/>' : '')
            .'<mergeCells count="'.substr_count($merges, '<mergeCell ').'">'.$merges.'</mergeCells>'
            .'<pageMargins left="0.4" right="0.4" top="0.5" bottom="0.5" header="0.3" footer="0.3"/>'
            .'<pageSetup paperSize="9" orientation="landscape" fitToWidth="1" fitToHeight="0"/>'
            .'</worksheet>';
    }

    private function xlsxCell(string $ref, mixed $value, int $style): string
    {
        if (is_int($value) || is_float($value)) {
            return '<c r="'.$ref.'" s="'.$style.'"><v>'.$value.'</v></c>';
        }

        // Disimpan sebagai teks biasa (bukan rumus), jadi aman dari formula injection.
        $text = preg_replace('/[^\x{9}\x{A}\x{D}\x{20}-\x{D7FF}\x{E000}-\x{FFFD}]/u', '', (string) $value);

        return '<c r="'.$ref.'" s="'.$style.'" t="inlineStr"><is><t xml:space="preserve">'
            .htmlspecialchars($text, ENT_XML1 | ENT_QUOTES, 'UTF-8').'</t></is></c>';
    }

    /**
     * @param  list<string>  $header
     * @param  list<array<int, mixed>>  $rows
     * @return list<float>
     */
    private function xlsxColumnWidths(array $header, array $rows): array
    {
        $widths = [];
        foreach ($header as $i => $label) {
            $longest = mb_strlen($label);
            foreach ($rows as $row) {
                $lines = explode("\n", (string) (array_values($row)[$i] ?? ''));
                $longest = max($longest, ...array_map('mb_strlen', $lines));
            }
            $widths[] = (float) min(max($longest + 3, 6), 45);
        }

        return $widths;
    }

    private function xlsxColumn(int $index): string
    {
        $name = '';
        while ($index > 0) {
            $mod = ($index - 1) % 26;
            $name = chr(65 + $mod).$name;
            $index = intdiv($index - 1, 26);
        }

        return $name;
    }

    private function xlsxStyles(): string
    {
        $border = '<left style="thin"><color rgb="FFC9D6D0"/></left><right style="thin"><color rgb="FFC9D6D0"/></right>'
            .'<top style="thin"><color rgb="FFC9D6D0"/></top><bottom style="thin"><color rgb="FFC9D6D0"/></bottom><diagonal/>';

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            .'<fonts count="4">'
            .'<font><sz val="11"/><name val="Calibri"/></font>'
            .'<font><b/><sz val="14"/><color rgb="FF0D4335"/><name val="Calibri"/></font>'
            .'<font><i/><sz val="10"/><color rgb="FF666666"/><name val="Calibri"/></font>'
            .'<font><b/><sz val="11"/><color rgb="FFFFFFFF"/><name val="Calibri"/></font>'
            .'</fonts>'
            .'<fills count="4">'
            .'<fill><patternFill patternType="none"/></fill>'
            .'<fill><patternFill patternType="gray125"/></fill>'
            .'<fill><patternFill patternType="solid"><fgColor rgb="FF0D4335"/><bgColor indexed="64"/></patternFill></fill>'
            .'<fill><patternFill patternType="solid"><fgColor rgb="FFEEF5F2"/><bgColor indexed="64"/></patternFill></fill>'
            .'</fills>'
            .'<borders count="2"><border><left/><right/><top/><bottom/><diagonal/></border><border>'.$border.'</border></borders>'
            .'<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'
            .'<cellXfs count="8">'
            .'<xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/>'
            .'<xf numFmtId="0" fontId="1" fillId="0" borderId="0" xfId="0" applyFont="1"><alignment vertical="center"/></xf>'
            .'<xf numFmtId="0" fontId="2" fillId="0" borderId="0" xfId="0" applyFont="1"/>'
            .'<xf numFmtId="0" fontId="3" fillId="2" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center" wrapText="1"/></xf>'
            .'<xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0" applyBorder="1" applyAlignment="1"><alignment vertical="top" wrapText="1"/></xf>'
            .'<xf numFmtId="0" fontId="0" fillId="3" borderId="1" xfId="0" applyFill="1" applyBorder="1" applyAlignment="1"><alignment vertical="top" wrapText="1"/></xf>'
            .'<xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="top"/></xf>'
            .'<xf numFmtId="0" fontId="0" fillId="3" borderId="1" xfId="0" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="top"/></xf>'
            .'</cellXfs>'
            .'<cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles>'
            .'</styleSheet>';
    }

    private function xlsxWorkbook(string $title): string
    {
        $sheetName = htmlspecialchars(mb_substr(str_replace(['\\', '/', '?', '*', '[', ']', ':'], '', $title), 0, 31), ENT_XML1 | ENT_QUOTES, 'UTF-8');

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            .'<sheets><sheet name="'.$sheetName.'" sheetId="1" r:id="rId1"/></sheets>'
            .'</workbook>';
    }

    private function xlsxWorkbookRels(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            .'<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'
            .'<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>'
            .'</Relationships>';
    }

    private function xlsxRootRels(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            .'<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
            .'</Relationships>';
    }

    private function xlsxContentTypes(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            .'<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
            .'<Default Extension="xml" ContentType="application/xml"/>'
            .'<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
            .'<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
            .'<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>'
            .'</Types>';
    }
}
