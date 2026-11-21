<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Novel Collection</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            background: #f3f6fb;
            font-family: Arial, sans-serif;
            color: #263449;
        }
        .navbar-custom {
            background: linear-gradient(100deg, #174ea6, #2878d0);
            padding: 20px 0;
            color: white;
        }
        .brand {
            font-size: 23px;
            font-weight: 800;
            letter-spacing: .5px;
        }
        .hero {
            background: linear-gradient(120deg, #e3efff, #e5f8ef);
            border-radius: 18px;
            padding: 30px;
            margin-top: 28px;
        }
        .hero h1 {
            font-weight: 800;
            color: #174ea6;
        }
        .panel {
            background: white;
            border: 0;
            border-radius: 16px;
            padding: 22px;
            box-shadow: 0 5px 22px rgba(30, 60, 100, .07);
            height: 100%;
        }
        .panel h5 {
            font-weight: 700;
        }
        .btn-blue {
            background: #2468c5;
            color: white;
        }
        .btn-blue:hover {
            background: #174ea6;
            color: white;
        }
        .btn-green {
            background: #15966b;
            color: white;
        }
        .btn-green:hover {
            background: #08764f;
            color: white;
        }
        .btn-orange {
            background: #f39a28;
            color: white;
        }
        .btn-orange:hover {
            background: #d77b0c;
            color: white;
        }
        .table thead th {
            background: #eaf1fc;
            color: #174ea6;
            padding: 14px;
            white-space: nowrap;
        }
        .table tbody td {
            padding: 13px;
            vertical-align: middle;
        }
        .novel-id {
            background: #e7f0ff;
            color: #2059a8;
            padding: 6px 10px;
            border-radius: 8px;
            font-weight: 700;
        }
        .price {
            color: #15966b;
            font-weight: 700;
        }
        .section-title {
            font-weight: 800;
            color: #203653;
        }
        footer {
            color: #8290a3;
            font-size: 13px;
            padding: 28px 0;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar-custom">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="brand">📚 Novel Collection</div>
            <span class="small">Library Management System</span>
        </div>
    </nav>

    <div class="container pb-4">

        <!-- Hero -->
        <div class="hero">
            <span class="badge text-bg-success mb-2">
                NOVEL MANAGEMENT
            </span>

            <h1>Kelola Koleksi Novelmu!</h1>

            <p class="mb-0">
                Platform sederhana untuk menyimpan, mengimpor,
                mengekspor, dan melihat koleksi novel favorit.
            </p>
        </div>

        <!-- Import Success -->
        @if(session('hasil_import'))
            <div class="alert alert-success mt-4">
                Import selesai!

                Berhasil:
                {{ session('hasil_import')['berhasil'] }}
                |
                Duplikat:
                {{ session('hasil_import')['duplikat'] }}
                |
                Tidak valid:
                {{ session('hasil_import')['tidak_valid'] }}
            </div>
        @endif

        <!-- Error Session -->
        @if(session('error'))
            <div class="alert alert-danger mt-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Validation Error -->
        @if($errors->any())
            <div class="alert alert-danger mt-4">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- Export & Import -->
        <div class="row g-4 mt-1">

            <!-- Export Data -->
            <div class="col-md-6">
                <div class="panel">

                    <div class="mb-3 fs-2">
                        📤
                    </div>

                    <h5>
                        Export Data
                    </h5>

                    <p class="text-secondary">
                        Unduh seluruh data koleksi novel ke dalam
                        file Excel atau PDF.
                    </p>

                    <div class="d-flex gap-2">

                        <!-- Download Excel -->
                        <a href="{{ route('novelcollection.export') }}"
                           class="btn btn-blue flex-fill">
                            Download Excel
                        </a>

                        <!-- Download PDF -->
                        <a href="{{ route('novelcollection.exportPdf') }}"
                           class="btn btn-danger flex-fill">
                            Download PDF
                        </a>
                    </div>
                </div>
            </div>

            <!-- Import Data -->
            <div class="col-md-6">
                <div class="panel">
                    <div class="mb-3 fs-2">
                        📥
                    </div>

                    <h5>
                        Import Data Excel
                    </h5>

                    <p class="text-secondary">
                        Tambahkan data novel melalui file Excel.
                    </p>
                    <form action="{{ route('novelcollection.import') }}"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf

                        <input type="file"
                               name="file_excel"
                               class="form-control mb-3"
                               accept=".xlsx,.xls,.csv"
                               required>

                        <button type="submit"
                                class="btn btn-green w-100">
                            Import Novel
                        </button>
                    </form>
                </div>
            </div>
        </div>


        <!-- Daftar Koleksi Novel -->
        <div class="panel mt-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                <div>
                    <h4 class="section-title mb-1">
                        📖 Daftar Koleksi Novel
                    </h4>
                    <p class="text-secondary mb-0">
                        Informasi novel yang tersimpan dalam database.
                    </p>
                </div>
                <span class="badge text-bg-warning mt-2">
                    Data Novel
                </span>
            </div>


            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>ID Novel</th>
                            <th>Waktu</th>
                            <th>Judul Novel</th>
                            <th>Harga</th>
                            <th>Kuantitas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksis as $index => $novel)

                            <tr>
                                <!-- Nomor -->
                                <td>
                                    {{ $transaksis->firstItem() + $index }}
                                </td>

                                <!-- ID Novel -->
                                <td>
                                    <span class="novel-id">
                                        {{ $novel->id_transaksi }}
                                    </span>
                                </td>

                                <!-- Waktu -->
                                <td>
                                    {{ \Carbon\Carbon::parse($novel->time)->format('d/m/Y H:i') }}
                                </td>

                                <!-- Judul Novel -->
                                <td class="fw-semibold">
                                    {{ $novel->namaBarang }}
                                </td>

                                <!-- Harga -->
                                <td class="price">
                                    Rp
                                    {{ number_format($novel->hargaBarang, 0, ',', '.') }}
                                </td>

                                <!-- Kuantitas -->
                                <td>
                                    <span class="badge text-bg-success">
                                        {{ $novel->kuantitas }} buku
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6"
                                    class="text-center text-secondary py-4">
                                    Belum ada data novel.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-end">
                {{ $transaksis->links('pagination::bootstrap-5') }}
            </div>

        </div>
        <!-- Footer -->
        <footer class="text-center">
            © 2026 Novel Collection · Laravel, PhpSpreadsheet & FPDF
        </footer>

    </div>

</body>
</html>