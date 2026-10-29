<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Rekapitulasi Absensi - BLK SIKARIR</title>
  <style>
    body {
      font-family: 'Times New Roman', Times, serif;
      color: #111;
      background: #f8fafc;
      margin: 0;
      padding: 20px;
      font-size: 12pt;
    }

    .no-print {
      max-width: 850px;
      margin: 0 auto 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #ffffff;
      padding: 12px 20px;
      border-radius: 8px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
      font-family: Arial, sans-serif;
      font-size: 13px;
    }

    .btn {
      padding: 8px 16px;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
      border: none;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }
    .btn-primary { background: #065f46; color: white; }
    .btn-secondary { background: #e2e8f0; color: #334155; }

    .paper {
      background: #ffffff;
      max-width: 850px;
      margin: 0 auto;
      padding: 40px 50px;
      box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
      box-sizing: border-box;
    }

    /* KOP SURAT */
    .header-table {
      width: 100%;
      border-bottom: 3px double #000;
      padding-bottom: 12px;
      margin-bottom: 20px;
    }
    .header-logo {
      width: 80px;
      text-align: center;
      vertical-align: middle;
    }
    .header-logo img {
      width: 70px;
      height: auto;
    }
    .header-text {
      text-align: center;
      line-height: 1.25;
    }
    .header-text h3 { margin: 0; font-size: 13pt; font-weight: normal; text-transform: uppercase; }
    .header-text h2 { margin: 2px 0; font-size: 15pt; font-weight: bold; text-transform: uppercase; }
    .header-text h1 { margin: 2px 0; font-size: 16pt; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; }
    .header-text p { margin: 2px 0; font-size: 9pt; font-style: italic; }

    /* TITLE */
    .doc-title {
      text-align: center;
      margin: 18px 0 16px;
    }
    .doc-title h2 {
      margin: 0;
      font-size: 14pt;
      text-transform: uppercase;
      text-decoration: underline;
    }
    .doc-title span {
      font-size: 10pt;
      display: block;
      margin-top: 4px;
    }

    /* META INFO */
    .meta-table {
      width: 100%;
      margin-bottom: 18px;
      font-size: 11pt;
    }
    .meta-table td {
      padding: 3px 6px;
      vertical-align: top;
    }

    /* STATS SUMMARY BOX */
    .summary-grid {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 10px;
      margin-bottom: 20px;
      text-align: center;
      font-family: Arial, sans-serif;
    }
    .summary-box {
      border: 1px solid #cbd5e1;
      padding: 8px 4px;
      border-radius: 6px;
      background: #f8fafc;
    }
    .summary-box .val { font-size: 16pt; font-weight: bold; display: block; color: #0f172a; }
    .summary-box .lbl { font-size: 8pt; text-transform: uppercase; color: #64748b; font-weight: bold; }

    /* DATA TABLE */
    table.data-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 24px;
      font-size: 10pt;
    }
    table.data-table th, table.data-table td {
      border: 1px solid #000;
      padding: 6px 8px;
    }
    table.data-table th {
      background: #f1f5f9;
      text-align: center;
      font-weight: bold;
      text-transform: uppercase;
      font-size: 9pt;
    }
    table.data-table td.center { text-align: center; }
    table.data-table td.right { text-align: right; }

    /* SIGNATURES */
    .sign-table {
      width: 100%;
      margin-top: 36px;
      font-size: 11pt;
    }
    .sign-table td {
      width: 50%;
      text-align: center;
      vertical-align: top;
      padding: 10px;
    }
    .sign-space { height: 70px; }

    @media print {
      body { background: #fff; padding: 0; }
      .no-print { display: none !important; }
      .paper { box-shadow: none; padding: 20px 25px; max-width: 100%; }
      table.data-table th { background: #eee !important; -webkit-print-color-adjust: exact; }
    }
  </style>
</head>
<body>

  <!-- Tombol Aksi Non-Cetak -->
  <div class="no-print">
    <div>
      <strong>Mode Pratinjau Dokumen Cetak</strong> &bull; Siap dicetak langsung atau disimpan sebagai PDF.
    </div>
    <div style="display: flex; gap: 8px;">
      <a href="{{ route('absen.rekap', request()->query()) }}" class="btn btn-secondary">
        &larr; Kembali
      </a>
      <button onclick="window.print()" class="btn btn-primary">
        Cetak Dokumen / Simpan PDF
      </button>
    </div>
  </div>

  <div class="paper">
    <!-- KOP SURAT RESMI -->
    <table class="header-table">
      <tr>
        <td class="header-logo">
          <img src="{{ asset('images/logo_sikarir.png') }}" onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/b/b3/Logo_Kementerian_Ketenagakerjaan_Republik_Indonesia.png'" alt="Logo">
        </td>
        <td class="header-text">
          <h3>Kementerian Ketenagakerjaan Republik Indonesia</h3>
          <h2>Direktorat Jenderal Pembinaan Pelatihan Vokasi & Produktivitas</h2>
          <h1>Balai Pelatihan Vokasi & Produktivitas (BPVP)</h1>
          <p>Jl. Basuki Rahmat No. 203, Jember, Jawa Timur &bull; Telp: (0331) 338902 &bull; Website: kemnaker.go.id</p>
        </td>
      </tr>
    </table>

    <!-- JUDUL LAPORAN -->
    <div class="doc-title">
      <h2>Laporan Rekapitulasi Kehadiran Peserta Pelatihan</h2>
      <span>Periode Laporan: {{ request('tanggal_mulai') ? \Carbon\Carbon::parse(request('tanggal_mulai'))->format('d/m/Y') : 'Awal Batch' }} s/d {{ request('tanggal_selesai') ? \Carbon\Carbon::parse(request('tanggal_selesai'))->format('d/m/Y') : 'Selesai Batch' }}</span>
    </div>

    <!-- METADATA PELATIHAN -->
    <table class="meta-table">
      <tr>
        <td style="width: 25%;"><strong>Program Pelatihan</strong></td>
        <td style="width: 2%;">:</td>
        <td style="width: 40%;">{{ $selectedJadwal->pelatihan->nama_pelatihan ?? 'Seluruh Program Pelatihan' }}</td>
        <td style="width: 15%;"><strong>Ruangan</strong></td>
        <td style="width: 2%;">:</td>
        <td style="width: 16%;">{{ $selectedJadwal->ruanganWorkshop->nama_ruangan ?? ($selectedJadwal->tempat ?? 'Lab Komputer') }}</td>
      </tr>
      <tr>
        <td><strong>Instruktur Pembina</strong></td>
        <td>:</td>
        <td>{{ $selectedJadwal->instruktur->user->name ?? ($selectedJadwal->instruktur ?? 'Tim Instruktur BPVP') }}</td>
        <td><strong>Tanggal Cetak</strong></td>
        <td>:</td>
        <td>{{ date('d F Y') }}</td>
      </tr>
    </table>

    <!-- SUMMARY STATS -->
    <div class="summary-grid">
      <div class="summary-box">
        <span class="val">{{ $totalHadir }}</span>
        <span class="lbl">Hadir (Sesi)</span>
      </div>
      <div class="summary-box">
        <span class="val">{{ $totalIzin }}</span>
        <span class="lbl">Izin</span>
      </div>
      <div class="summary-box">
        <span class="val">{{ $totalSakit }}</span>
        <span class="lbl">Sakit</span>
      </div>
      <div class="summary-box">
        <span class="val">{{ $totalAlpha }}</span>
        <span class="lbl">Alpha</span>
      </div>
      <div class="summary-box">
        <span class="val" style="color: #065f46;">{{ $persenHadir }}%</span>
        <span class="lbl">Rata-rata Kehadiran</span>
      </div>
    </div>

    <!-- TABEL REKAPITULASI PER PESERTA -->
    <h4 style="margin: 0 0 8px 0; text-transform: uppercase; font-size: 11pt;">I. Rekapitulasi Kehadiran & Status Kelayakan Peserta</h4>
    <table class="data-table">
      <thead>
        <tr>
          <th style="width: 30px;">No</th>
          <th style="width: 110px;">No. Peserta</th>
          <th>Nama Lengkap Peserta</th>
          <th style="width: 50px;">Hadir</th>
          <th style="width: 45px;">Izin</th>
          <th style="width: 45px;">Sakit</th>
          <th style="width: 45px;">Alpha</th>
          <th style="width: 65px;">Total Sesi</th>
          <th style="width: 65px;">% Hadir</th>
          <th style="width: 110px;">Status</th>
        </tr>
      </thead>
      <tbody>
        @forelse($rekapPeserta as $index => $rp)
          <tr>
            <td class="center">{{ $loop->iteration }}</td>
            <td class="center" style="font-family: monospace;">{{ $rp->peserta->nomor_peserta ?? '-' }}</td>
            <td><strong>{{ $rp->peserta->user->name ?? '-' }}</strong></td>
            <td class="center font-bold">{{ $rp->hadir }}</td>
            <td class="center">{{ $rp->izin }}</td>
            <td class="center">{{ $rp->sakit }}</td>
            <td class="center">{{ $rp->alpha }}</td>
            <td class="center font-bold">{{ $rp->total }}</td>
            <td class="center font-bold" style="color: {{ $rp->persentase >= 80 ? '#065f46' : '#b91c1c' }};">
              {{ $rp->persentase }}%
            </td>
            <td class="center" style="font-size: 8.5pt; font-weight: bold;">
              {{ $rp->status_lulus }}
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="10" class="center">Belum ada rekaman data presensi untuk periode ini.</td>
          </tr>
        @endforelse
      </tbody>
    </table>

    <!-- LEMBAR PENGESAHAN / TANDA TANGAN -->
    <table class="sign-table">
      <tr>
        <td>
          Mengetahui,<br>
          <strong>Instruktur Pelatihan Vokasi</strong>
          <div class="sign-space"></div>
          <strong><u>{{ $selectedJadwal->instruktur->user->name ?? 'Instruktur Pembina' }}</u></strong><br>
          <span>NIP. 19850712 201101 1 004</span>
        </td>
        <td>
          Jember, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
          <strong>Kepala Balai Pelatihan Vokasi</strong>
          <div class="sign-space"></div>
          <strong><u>Drs. H. Bambang Soeprapto, M.M.</u></strong><br>
          <span>NIP. 19740315 199803 1 002</span>
        </td>
      </tr>
    </table>
  </div>

</body>
</html>

