<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Murid</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    <style>
        /* Custom CSS agar tabel lebih rapi */
        table.dataTable {
            width: 100% !important;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center">Absensi Murid</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Form Absensi -->
        <div class="card p-3 mb-4">
            <form action="{{ route('absensi.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <label for="id_murid" class="form-label">Murid</label>
                        <div>
                            <input type="text" id="search_murid" class="form-control" placeholder="Ketik nama murid...">
                            <input type="hidden" name="id_murid" id="id_murid">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="id_mapel" class="form-label">Mata Pelajaran</label>
                        <select name="id_mapel" id="id_mapel" class="form-control" required>
                            <option value="">Pilih Mapel</option>
                            @foreach($mapel as $m)
                                <option value="{{ $m->id }}">{{ $m->nama_mapel }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <select name="keterangan" id="keterangan" class="form-control">
                            <option value="Offline">Offline</option>
                            <option value="Online">Online</option>
                            <option value="Ijin">Ijin</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Alfa">Tanpa Keterangan</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" id="tanggal" name="tanggal" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label for="jam" class="form-label">Jam</label>
                        <input type="time" id="jam" name="jam" class="form-control" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3 w-100">Simpan Absensi</button>
            </form>
        </div>

        <!-- Tabel Absensi -->
        <div class="card p-3">
            <h5 class="text-center">Data Absensi</h5>
            <table id="absensiTable" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Murid</th>
                        <th>Kelas</th>
                        <th>Mapel</th>
                        <th>Jam</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($absensi as $a)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $a->murid->nama }}</td>
                            <td>{{ $a->murid->kelas }}</td>
                            <td>{{ $a->mapel->nama_mapel }}</td>
                            <td>{{ $a->jam }}</td>
                            <td>{{ $a->tanggal }}</td>
                            <td>
                                @php
                                    $keterangan = trim($a->keterangan); // Menghilangkan spasi di awal & akhir

                                    $badgeClass = match($keterangan) {
                                        'Online' => 'bg-success',  // Hijau
                                        'Offline' => 'bg-secondary', // Abu-abu
                                        'Ijin' => 'bg-warning',  // Kuning
                                        'Sakit' => 'bg-danger', // Merah
                                        default => 'bg-dark' // Hitam untuk "Tanpa Keterangan"
                                    };

                                    // Jika keterangan adalah 'Alfa', ubah teks menjadi 'Tanpa Keterangan'
                                    $keteranganText = $keterangan === 'Alfa' ? 'Tanpa Keterangan' : $keterangan;
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $keteranganText }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let now = new Date();
            let today = now.toISOString().split('T')[0]; // Format YYYY-MM-DD
            let currentTime = now.toTimeString().split(' ')[0].slice(0,5); // Format HH:MM

            document.getElementById('tanggal').value = today;
            document.getElementById('jam').value = currentTime;
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <!-- Inisialisasi DataTables -->
    <script>
        $(document).ready(function() {
            $('#absensiTable').DataTable({
                "paging": true, // Aktifkan pagination
                "searching": true, // Aktifkan pencarian
                "ordering": true, // Aktifkan sorting
                "info": true, // Tampilkan informasi jumlah data
                "language": {
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                    "infoEmpty": "Tidak ada data tersedia",
                    "infoFiltered": "(disaring dari _MAX_ total data)",
                    "search": "Cari:",
                    "paginate": {
                        "first": "Awal",
                        "last": "Akhir",
                        "next": "Berikutnya",
                        "previous": "Sebelumnya"
                    }
                }
            });
        });
    </script>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(document).ready(function() {
        $("#search_murid").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('autocomplete.murid') }}",
                    data: {
                        term: request.term
                    },
                    dataType: "json",
                    success: function(data) {
                        response(data);
                    }
                });
            },
            minLength: 2, // Minimal karakter sebelum pencarian
            select: function(event, ui) {
                $("#search_murid").val(ui.item.label);
                $("#id_murid").val(ui.item.value); // Masukkan ID ke input hidden
                return false;
            }
        });
    });
</script>

</body>
</html>
