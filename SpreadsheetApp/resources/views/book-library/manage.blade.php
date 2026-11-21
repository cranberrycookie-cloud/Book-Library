<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Library Management System</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>
        body {
            background: #f3f6fb;
            font-family: Arial, sans-serif;
            color: #263449;
        }

        /* NAVBAR */
        .navbar-custom {
            background: linear-gradient(100deg, #174ea6, #2878d0);
            padding: 19px 0;
            color: white;
        }
        .brand {
            color: white;
            font-size: 23px;
            font-weight: 800;
            text-decoration: none;
        }
        .nav-link-custom {
            color: white;
            font-weight: 700;
            text-decoration: none;
            border: 1px solid rgba(255,255,255,.55);
            border-radius: 9px;
            padding: 9px 13px;
            transition: .2s;
        }

        .nav-link-custom:hover {
            background: rgba(255,255,255,.14);
            color: white;
        }

        /* HERO */

        .hero {
            background: linear-gradient(120deg, #e3efff, #e5f8ef);
            border-radius: 18px;
            padding: 27px;
            margin-top: 28px;
        }

        .hero h1 {
            font-weight: 800;
            color: #174ea6;
        }

        /* PANEL */

        .panel {
            background: white;
            border: 0;
            border-radius: 16px;
            padding: 22px;
            box-shadow: 0 5px 22px rgba(30,60,100,.07);
        }

        /* TABLE */

        .table thead th {
            background: #eaf1fc;
            color: #174ea6;
            padding: 13px;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 12px;
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

        /* STATUS */

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

        /* QTY */

        .qty-number {
            font-weight: 700;
            text-align: center;
            font-size: 16px;
        }

        .section-title {
            color: #203653;
            font-weight: 800;
        }

        /* FORM */

        .form-label {
            font-weight: 600;
        }

        /* ACTION BUTTON */

        .action-buttons {
            display: flex;
            gap: 7px;
            flex-wrap: wrap;
        }

        /* MODAL */

        .modal-dialog-scrollable .modal-content {
            max-height: calc(100vh - 2rem);
            display: flex;
            flex-direction: column;
        }

        .modal-dialog-scrollable .modal-header {
            flex-shrink: 0;
            background: white;
        }

        .modal-dialog-scrollable .modal-body {
            overflow-y: auto;
            flex: 1 1 auto;
        }

        .modal-dialog-scrollable .modal-footer {
            flex-shrink: 0;
            background: white;
        }

        .modal-content {
            border: 0;
            border-radius: 14px;
        }

        /* FOOTER */

        footer {
            color: #8290a3;
            font-size: 13px;
            padding: 28px 0;
        }

        /* RESPONSIVE */

        @media (max-width: 576px) {

            .brand {
                font-size: 18px;
            }

            .nav-link-custom {
                font-size: 12px;
                padding: 7px 9px;
            }

            .hero {
                padding: 20px;
            }

            .hero h1 {
                font-size: 25px;
            }

            .panel {
                padding: 15px;
            }

            .action-buttons {
                flex-direction: column;
            }

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

            <a href="{{ route('booklibrary.index') }}" class="nav-link-custom">
                ← Kembali ke Dashboard
            </a>

        </div>

    </nav>


    <div class="container pb-4">

        <!-- =================================================
             HERO
        ================================================== -->

        <div class="hero d-flex flex-wrap justify-content-between align-items-center gap-3">

            <div>

                <span class="badge text-bg-primary mb-2">
                    ADMINISTRASI KOLEKSI
                </span>

                <h1 class="mb-2">
                    Library Management System
                </h1>

                <p class="mb-0">
                    Tambah, perbarui, dan hapus informasi koleksi buku.
                </p>

            </div>

            <button
                type="button"
                class="btn btn-primary btn-lg"
                data-bs-toggle="modal"
                data-bs-target="#modalTambah">

                ＋ Tambah Buku

            </button>

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

                <strong>Data belum dapat disimpan. Periksa kembali:</strong>

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
             TABEL PENGELOLAAN BUKU
        ================================================== -->

        <div class="panel mt-4">

            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">

                <div>

                    <h4 class="section-title mb-1">
                        📚 Daftar Data Buku
                    </h4>

                    <p class="text-secondary mb-0">
                        Gunakan tombol Aksi untuk memperbarui atau menghapus data.
                    </p>

                </div>

                <span class="badge text-bg-primary">
                    {{ $books->total() }} koleksi
                </span>

            </div>


            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th>No.</th>
                            <th>ISBN</th>
                            <th>Judul Buku</th>
                            <th>Pengarang</th>
                            <th>Penerbit</th>
                            <th>Tahun Terbit</th>
                            <th>Keterangan</th>
                            <th class="text-center">Qty</th>
                            <th>Aksi</th>

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


                                <!-- JUDUL -->

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


                                <!-- QTY: TOTAL BUKU -->

                                <td class="qty-number">

                                    {{ (int) $book->jumlah_tersedia + (int) $book->jumlah_dipinjam }}

                                </td>


                                <!-- AKSI -->

                                <td>

                                    <div class="action-buttons">

                                        <!-- UPDATE -->

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-warning"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEdit{{ $book->id_transaksi }}">

                                            ✏️ Update

                                        </button>


                                        <!-- DELETE -->

                                        <form
                                            action="{{ route('booklibrary.destroy', $book->id_transaksi) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data buku ini?');">

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-danger">

                                                🗑️ Delete

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td
                                    colspan="9"
                                    class="text-center text-secondary py-4">

                                    Belum ada data buku.
                                    Klik Tambah Buku untuk memasukkan koleksi pertama.

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
             MODAL TAMBAH BUKU
        ================================================== -->

        <div class="modal fade" id="modalTambah" tabindex="-1">

            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

                <form
                    action="{{ route('booklibrary.store') }}"
                    method="POST"
                    class="modal-content">

                    @csrf


                    <!-- HEADER -->

                    <div class="modal-header">

                        <h5 class="modal-title">
                            ＋ Tambah Buku
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                        </button>

                    </div>


                    <!-- BODY -->

                    <div class="modal-body">

                        <div class="row g-3">


                            <!-- ISBN -->

                            <div class="col-md-6">

                                <label class="form-label">
                                    ISBN
                                </label>

                                <input
                                    type="text"
                                    name="isbn"
                                    class="form-control"
                                    placeholder="Contoh: 9786020324784"
                                    maxlength="20"
                                    required>

                            </div>


                            <!-- JUDUL BUKU -->

                            <div class="col-md-6">

                                <label class="form-label">
                                    Judul Buku
                                </label>

                                <input
                                    type="text"
                                    name="judul_buku"
                                    class="form-control"
                                    placeholder="Masukkan judul buku"
                                    required>

                            </div>


                            <!-- PENGARANG -->

                            <div class="col-md-6">

                                <label class="form-label">
                                    Pengarang
                                </label>

                                <input
                                    type="text"
                                    name="pengarang"
                                    class="form-control"
                                    placeholder="Masukkan nama pengarang">

                            </div>


                            <!-- PENERBIT -->

                            <div class="col-md-6">

                                <label class="form-label">
                                    Penerbit
                                </label>

                                <input
                                    type="text"
                                    name="penerbit"
                                    class="form-control"
                                    placeholder="Masukkan nama penerbit">

                            </div>


                            <!-- TAHUN TERBIT -->

                            <div class="col-md-6">

                                <label class="form-label">
                                    Tahun Terbit
                                </label>

                                <input
                                    type="number"
                                    name="tahun_terbit"
                                    class="form-control"
                                    min="1000"
                                    max="2100"
                                    placeholder="Contoh: 2024">

                            </div>


                            <!-- JUMLAH TERSEDIA -->

                            <div class="col-md-6">

                                <label class="form-label">
                                    Jumlah Tersedia
                                </label>

                                <input
                                    type="number"
                                    name="jumlah_tersedia"
                                    class="form-control"
                                    value="1"
                                    min="0"
                                    required>

                            </div>


                            <!-- JUMLAH DIPINJAM -->

                            <div class="col-md-6">

                                <label class="form-label">
                                    Jumlah Sedang Dipinjam
                                </label>

                                <input
                                    type="number"
                                    name="jumlah_dipinjam"
                                    class="form-control"
                                    value="0"
                                    min="0"
                                    required>

                            </div>

                        </div>


                        <small class="text-muted d-block mt-3">

                            Keterangan buku akan menyesuaikan otomatis
                            berdasarkan jumlah tersedia dan jumlah dipinjam.

                        </small>

                    </div>


                    <!-- FOOTER -->

                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">

                            Batal

                        </button>

                        <button
                            type="submit"
                            class="btn btn-primary">

                            Simpan Buku

                        </button>

                    </div>

                </form>

            </div>

        </div>


        <!-- =================================================
             MODAL UPDATE BUKU
        ================================================== -->

        @foreach($books as $book)

            <div
                class="modal fade"
                id="modalEdit{{ $book->id_transaksi }}"
                tabindex="-1">

                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

                    <form
                        action="{{ route('booklibrary.update', $book->id_transaksi) }}"
                        method="POST"
                        class="modal-content">

                        @csrf

                        @method('PUT')


                        <!-- HEADER -->

                        <div class="modal-header">

                            <h5 class="modal-title">
                                ✏️ Update Buku
                            </h5>

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal">
                            </button>

                        </div>


                        <!-- BODY -->

                        <div class="modal-body">

                            <div class="row g-3">


                                <!-- ISBN -->

                                <div class="col-md-6">

                                    <label class="form-label">
                                        ISBN
                                    </label>

                                    <input
                                        type="text"
                                        name="isbn"
                                        class="form-control"
                                        value="{{ $book->isbn }}"
                                        maxlength="20"
                                        required>

                                </div>


                                <!-- JUDUL BUKU -->

                                <div class="col-md-6">

                                    <label class="form-label">
                                        Judul Buku
                                    </label>

                                    <input
                                        type="text"
                                        name="judul_buku"
                                        class="form-control"
                                        value="{{ $book->namaBarang }}"
                                        required>

                                </div>


                                <!-- PENGARANG -->

                                <div class="col-md-6">

                                    <label class="form-label">
                                        Pengarang
                                    </label>

                                    <input
                                        type="text"
                                        name="pengarang"
                                        class="form-control"
                                        value="{{ $book->pengarang }}">

                                </div>


                                <!-- PENERBIT -->

                                <div class="col-md-6">

                                    <label class="form-label">
                                        Penerbit
                                    </label>

                                    <input
                                        type="text"
                                        name="penerbit"
                                        class="form-control"
                                        value="{{ $book->penerbit }}">

                                </div>


                                <!-- TAHUN TERBIT -->

                                <div class="col-md-6">

                                    <label class="form-label">
                                        Tahun Terbit
                                    </label>

                                    <input
                                        type="number"
                                        name="tahun_terbit"
                                        class="form-control"
                                        value="{{ $book->tahun_terbit }}"
                                        min="1000"
                                        max="2100">

                                </div>


                                <!-- JUMLAH TERSEDIA -->

                                <div class="col-md-6">

                                    <label class="form-label">
                                        Jumlah Tersedia
                                    </label>

                                    <input
                                        type="number"
                                        name="jumlah_tersedia"
                                        class="form-control"
                                        value="{{ $book->jumlah_tersedia }}"
                                        min="0"
                                        required>

                                </div>


                                <!-- JUMLAH DIPINJAM -->

                                <div class="col-md-6">

                                    <label class="form-label">
                                        Jumlah Sedang Dipinjam
                                    </label>

                                    <input
                                        type="number"
                                        name="jumlah_dipinjam"
                                        class="form-control"
                                        value="{{ $book->jumlah_dipinjam }}"
                                        min="0"
                                        required>

                                </div>

                            </div>

                        </div>


                        <!-- FOOTER -->

                        <div class="modal-footer">

                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">

                                Batal

                            </button>

                            <button
                                type="submit"
                                class="btn btn-primary">

                                Simpan Perubahan

                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach


        <!-- =================================================
             FOOTER
        ================================================== -->
        <footer class="text-center">
            © 2026 Book Library · Laravel, Kelompok 14.
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
