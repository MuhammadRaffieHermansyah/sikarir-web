<!DOCTYPE html>
<html>
<head>
    <title>Ruangan Workshop</title>
</head>
<body>

    <h1>Master Ruangan Workshop</h1>

    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <a href="{{ route('ruangan-workshop.create') }}">
        Tambah Ruangan
    </a>

    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Ruangan</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($ruanganWorkshops as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_ruangan }}</td>
                    <td>
                        <a href="{{ route('ruangan-workshop.edit', $item->id) }}"
                        class="text-blue-600 hover:text-blue-800">
                        Edit
                    </a>
                    <form action="{{ route('ruangan-workshop.destroy', $item->id) }}"
                    method="POST"
                    class="inline"
                    onsubmit="return confirm('Yakin ingin menghapus ruangan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                    </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>