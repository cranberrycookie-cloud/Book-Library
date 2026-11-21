<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Book Library</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>
        body {
            background: #f3f6fb;
            font-family: Arial, sans-serif;
            color: #263449;
        }

        .navbar-custom {
            background: linear-gradient(100deg, #174ea6, #2878d0);
            padding: 19px 0;
            color: white;
        }

        .brand {
            color: white;
            font-size: 23px;
            font-weight: 800;
            letter-spacing: .4px;
            text-decoration: none;
        }

        .management-link {
            color: white;
            font-weight: 700;
            text-decoration: none;
            border: 1px solid rgba(255,255,255,.55);
            border-radius: 9px;
            padding: 9px 13px;
            transition: .2s;
        }

        .management-link:hover {
            color: white;
            background: rgba(255,255,255,.14);
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

        .isbn-label {
            display: inline-block;
            background: #e7f0ff;
            color: #2059a8;
            padding: 6px 9px;
            border-radius: 8px;
            font-weight: 700;
            white-space: nowrap;
        }

        .section-title {
            font-weight: 800;
            color: #203653;
        }

        .status-list {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 6px;
            min-width: 155px;
        }

        .status-list .badge {
            font-size: 12px;
            padding: 7px 10px;
            white-space: nowrap;
        }

        .qty-number {
            font-weight: 700;
            color: #263449;
            text-align: center;
            font-size: 16px;
        }

        footer {
            color: #8290a3;
            font-size: 13px;
            padding: 28px 0;
        }
    </style>
</head>

<body>

    <!-- =====================================================
         NAVBAR
    ====================================================== -->

    <nav class="navbar-custom">
        <div class="container d-flex justify-content-between align-items-center gap-3">

            <a href="{{ route('booklibrary.index') }}" class="brand">
                📚 Book Library
            </a>

            <a href="{{ route('booklibrary.manage') }}" class="management-link">
                Library Management System ↗
            </a>

        </div>
    </nav>


    <div class="container pb-4">

        <!-- =================================================
             HERO
        ================================================== -->

        <div class="hero">

            <span class="badge text-bg-success mb-2">
                BOOK LIBRARY
            </span>

            <h1>
                Daftar Koleksi Buku
            </h1>

            <p class="mb-0">
                Selamat datang di Book Library. Di sini kamu dapat
                melihat informasi koleksi buku, keterangan
                ketersediaan, dan jumlah buku.
            </p>

            <p class="mb-0 mt-2 small">
                Untuk menambah, memperbarui, atau menghapus data buku,
                klik tulisan
                <strong>Library Management System</strong>
                di bagian atas.
            </p>

        </div>


        <!-- =================================================
             SUCCESS MESSAGE
        ================================================== -->

        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show mt-4">

                {{ session('success') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        <!-- =================================================
             IMPORT SUCCESS
        ================================================== -->

        @if(session('hasil_import'))

            <div class="alert alert-success alert-dismissible fade show mt-4">

                <strong>Import selesai!</strong>
                <br>

                Berhasil:
                {{ session('hasil_import')['berhasil'] }}

                |

                Duplikat:
                {{ session('hasil_import')['duplikat'] }}

                |

                Tidak valid:
                {{ session('hasil_import')['tidak_valid'] }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        <!-- =================================================
             ERROR MESSAGE
        ================================================== -->

        @if(session('error'))

            <div class="alert alert-danger alert-dismissible fade show mt-4">

                {{ session('error') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        <!-- =================================================
             VALIDATION ERROR
        ================================================== -->

        @if($errors->any())

            <div class="alert alert-danger mt-4">

                <strong>Terdapat kesalahan:</strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        <!-- =================================================
             EXPORT EXCEL / EXPORT PDF / IMPORT EXCEL & PDF
        ================================================== -->

        <div class="row g-4 mt-1">


            <!-- EXPORT EXCEL -->

            <div class="col-md-4">

                <div class="panel">

                    <div class="mb-3 fs-2">
                        📊
                    </div>

                    <h5>
                        Export Excel
                    </h5>

                    <p class="text-secondary">
                        Unduh seluruh data koleksi buku
                        dalam format Excel.
                    </p>

                    <a
                        href="{{ route('booklibrary.export') }}"
                        class="btn btn-blue w-100">

                        Download Excel

                    </a>

                </div>

            </div>


            <!-- EXPORT PDF -->

            <div class="col-md-4">

                <div class="panel">

                    <div class="mb-3 fs-2">
                        📄
                    </div>

                    <h5>
                        Export PDF
                    </h5>

                    <p class="text-secondary">
                        Unduh daftar koleksi buku
                        dalam format PDF.
                    </p>

                    <a
                        href="{{ route('booklibrary.exportPdf') }}"
                        class="btn btn-orange w-100">

                        Download PDF

                    </a>

                </div>

            </div>


            <!-- IMPORT EXCEL / PDF -->

            <div class="col-md-4">

                <div class="panel">

                    <div class="mb-3 fs-2">
                        📥
                    </div>

                    <h5>
                        Import Excel / PDF
                    </h5>

                    <p class="text-secondary">
                        Tambahkan beberapa data buku sekaligus
                        menggunakan file Excel atau PDF.
                    </p>

                    <form
                        action="{{ route('booklibrary.import') }}"
                        method="POST"
                        enctype="multipart/form-data">

                        @csrf

                        <input
                            type="file"
                            name="file_excel"
                            class="form-control mb-3"
                            accept=".xlsx,.xls,.csv,.pdf"
                            required>

                        <button
                            type="submit"
                            class="btn btn-green w-100">

                            Import Buku

                        </button>

                    </form>

                    <small class="text-muted d-block mt-3">
                        Format yang didukung:
                        XLSX, XLS, CSV, dan PDF.
                    </small>

                    <small class="text-muted d-block mt-2">
                        Khusus PDF, gunakan format data dengan
                        pemisah tanda | antar kolom.
                    </small>

                    <a
                        href="{{ asset('template_import_buku.csv') }}"
                        class="small d-block mt-2"
                        download>

                        Unduh Template Import CSV

                    </a>

                </div>

            </div>

        </div>


        <!-- =================================================
             DAFTAR KOLEKSI BUKU
        ================================================== -->

        <div class="panel mt-4">

            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">

                <div>

                    <h4 class="section-title mb-1">
                        📖 Daftar Koleksi Buku
                    </h4>

                    <p class="text-secondary mb-0">
                        Informasi buku yang tersimpan
                        di database Book Library.
                    </p>

                </div>

                <span class="badge text-bg-primary mt-2">
                    {{ $books->total() }} koleksi
                </span>

            </div>


            <!-- =================================================
                 TABLE
            ================================================== -->

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th>
                                No.
                            </th>

                            <th>
                                ISBN
                            </th>

                            <th>
                                Judul Buku
                            </th>

                            <th>
                                Pengarang
                            </th>

                            <th>
                                Penerbit
                            </th>

                            <th>
                                Tahun Terbit
                            </th>

                            <th>
                                Keterangan
                            </th>

                            <th class="text-center">
                                Qty
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($books as $index => $book)

                            <tr>

                                <!-- NO -->

                                <td>
                                    {{ $books->firstItem() + $index }}
                                </td>


                                <!-- ISBN -->

                                <td>

                                    @if($book->isbn)

                                        <span class="isbn-label">
                                            {{ $book->isbn }}
                                        </span>

                                    @else

                                        <span class="text-muted">
                                            -
                                        </span>

                                    @endif

                                </td>


                                <!-- JUDUL BUKU -->

                                <td class="fw-semibold">
                                    {{ $book->namaBarang }}
                                </td>


                                <!-- PENGARANG -->

                                <td>
                                    {{ $book->pengarang ?: '-' }}
                                </td>


                                <!-- PENERBIT -->

                                <td>
                                    {{ $book->penerbit ?: '-' }}
                                </td>


                                <!-- TAHUN TERBIT -->

                                <td>
                                    {{ $book->tahun_terbit ?: '-' }}
                                </td>


                                <!-- KETERANGAN DENGAN JUMLAH -->

                                <td>

                                    <div class="status-list">

                                        @if((int) $book->jumlah_tersedia > 0)

                                            <span class="badge text-bg-success">
                                                Tersedia:
                                                {{ (int) $book->jumlah_tersedia }}
                                                buku
                                            </span>

                                        @endif


                                        @if((int) $book->jumlah_dipinjam > 0)

                                            <span class="badge text-bg-warning">
                                                Sedang Dipinjam:
                                                {{ (int) $book->jumlah_dipinjam }}
                                                buku
                                            </span>

                                        @endif


                                        @if(
                                            (int) $book->jumlah_tersedia === 0 &&
                                            (int) $book->jumlah_dipinjam === 0
                                        )

                                            <span class="badge text-bg-secondary">
                                                Stok Kosong
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <!-- QTY: TOTAL BUKU SAJA -->
                                <td class="qty-number">
                                    {{ (int) $book->jumlah_tersedia + (int) $book->jumlah_dipinjam }}
                                </td>
                            </tr>


                        @empty

                            <tr>
                                <td
                                    colspan="8"
                                    class="text-center text-secondary py-4">

                                    Belum ada data buku.
                                    Tambahkan data melalui halaman
                                    Library Management System.

                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- =================================================
                 PAGINATION
            ================================================== -->
            <div class="d-flex justify-content-end">
                {{ $books->links('pagination::bootstrap-5') }}
            </div>
        </div>

        <!-- =================================================
             FOOTER
        ================================================== -->
        <footer class="text-center">
            © 2026 Book Library ·
            Laravel, Kelompok 14.
        </footer>
    </div>

    <!-- =====================================================
         BOOTSTRAP JAVASCRIPT
    ====================================================== -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>
</body>
</html>
