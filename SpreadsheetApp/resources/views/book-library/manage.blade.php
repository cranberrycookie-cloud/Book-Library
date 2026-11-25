<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Management System · Glaciary</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>
        @font-face {
            font-family: 'Surgena';
            src:
                url('{{ asset('fonts/Surgena.woff2') }}') format('woff2'),
                url('{{ asset('fonts/Surgena.ttf') }}') format('truetype'),
                url('{{ asset('fonts/Surgena-SemiBold.ttf') }}') format('truetype');
            font-weight: 400 700;
            font-style: normal;
            font-display: swap;
        }

        :root {
            --font-surgena: 'Surgena', 'Segoe UI', Arial, sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background:
                radial-gradient(circle at 18% 12%, rgba(37, 99, 235, 0.24), transparent 45%),
                radial-gradient(circle at 82% 28%, rgba(29, 78, 216, 0.18), transparent 48%),
                #050811;
            font-family: var(--font-surgena);
            color: #eef4ff;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .top-bar {
            background: rgba(13, 20, 38, 0.68);
            backdrop-filter: blur(18px) saturate(160%);
            -webkit-backdrop-filter: blur(18px) saturate(160%);
            border-bottom: 1px solid rgba(147, 197, 253, 0.22);
            box-shadow: 0 12px 34px rgba(2, 6, 18, 0.45);
            padding: 14px 0;
        }

        .manage-brand {
            font-family: var(--font-surgena);
        }

        .panel {
            background: rgba(14, 23, 45, 0.68);
            backdrop-filter: blur(16px) saturate(145%);
            -webkit-backdrop-filter: blur(16px) saturate(145%);
            border: 1px solid rgba(147, 197, 253, 0.20);
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 14px 34px rgba(2, 6, 18, 0.50);
        }

        .form-control,
        .form-select {
            background-color: rgba(10, 17, 34, 0.78);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(147, 197, 253, 0.22);
            color: #f8fafc;
            border-radius: 12px;
        }

        .form-control::placeholder {
            color: #7b90b2;
        }

        .form-control:focus,
        .form-select:focus {
            background-color: rgba(14, 23, 45, 0.92);
            border-color: #60a5fa;
            color: #ffffff;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.22);
        }

        .form-select option {
            background-color: #0d152a;
            color: #f8fafc;
        }

        .custom-file-picker-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 10px 14px;
            border-radius: 12px;
            background: rgba(10, 17, 34, 0.72);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(147, 197, 253, 0.24);
            color: #dbeafe;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s ease, border-color .2s ease, color .2s ease, transform .15s ease;
        }

        .custom-file-picker-btn:hover {
            background: rgba(37, 99, 235, 0.22);
            border-color: rgba(96, 165, 250, 0.55);
            color: #ffffff;
            transform: translateY(-1px);
        }

        .custom-file-picker-btn .file-spark {
            color: #60a5fa;
            font-weight: 800;
        }

        .badge.text-bg-primary {
            background-color: rgba(37, 99, 235, 0.24) !important;
            color: #93c5fd !important;
            border: 1px solid rgba(96, 165, 250, 0.36);
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: 1px solid rgba(147, 197, 253, 0.30);
            box-shadow: 0 6px 18px rgba(37, 99, 235, 0.28);
        }

        .btn-primary:hover {
            filter: brightness(1.08);
        }

        .icon-action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 999px;
            padding: 0;
        }

        .table {
            --bs-table-bg: transparent;
            --bs-table-color: #e2eeff;
            --bs-table-hover-bg: rgba(59, 130, 246, 0.12);
            --bs-table-hover-color: #ffffff;
            --bs-table-border-color: rgba(147, 197, 253, 0.16);
        }

        .table thead th {
            background: rgba(20, 34, 66, 0.88);
            color: #93c5fd;
            padding: 12px 14px;
            white-space: nowrap;
            border-bottom: 1px solid rgba(147, 197, 253, 0.24);
        }

        .sort-link {
            color: #93c5fd;
            text-decoration: none;
        }

        .sort-link:hover {
            color: #ffffff;
            text-decoration: underline;
        }

        .modal-content.glass-modal {
            background: rgba(12, 20, 38, 0.94);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            color: #ffffff;
            border: 1px solid rgba(147, 197, 253, 0.24);
        }

        .modal-content.glass-modal .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }
    </style>
</head>

<body>

    <header class="top-bar mb-4">
        <div class="container d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <a href="{{ route('booklibrary.index') }}" class="text-white text-decoration-none fw-bold fs-5 manage-brand">
                    Glaciary
                </a>
                <span class="badge text-bg-warning text-dark ms-2">Management System</span>
            </div>

            <div class="d-flex align-items-center gap-2">
                @if($isAdmin)
                    <span class="small text-info fw-semibold">{{ $adminEmail }}</span>
                    <form action="{{ route('booklibrary.manage.logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                            Logout
                        </button>
                    </form>
                @endif
                <a href="{{ route('booklibrary.index') }}" class="btn btn-sm btn-outline-light rounded-pill px-3">
                    ← Kembali ke Halaman Utama
                </a>
            </div>
        </div>
    </header>

    <main class="container pb-5">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('hasil_import'))
            <div class="alert alert-success alert-dismissible fade show mb-4">
                <strong>Import selesai!</strong>
                Berhasil: {{ session('hasil_import')['berhasil'] }}
                | Tidak valid: {{ session('hasil_import')['tidak_valid'] }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(!$isAdmin)
            <div class="panel mx-auto mt-5" style="max-width: 480px;">
                <span class="badge text-bg-warning text-dark mb-2">RESTRICTED ACCESS</span>
                <h4 class="fw-bold text-white mb-1">Login Management System</h4>
                <p class="text-secondary small mb-3">
                    Halaman ini khusus untuk pengelola perpustakaan. Masuk dengan akun Gmail khusus yang terdaftar.
                </p>

                <div class="p-3 rounded-4 mb-3 small" style="background: rgba(14, 23, 45, 0.72); backdrop-filter: blur(12px); border: 1px solid rgba(147, 197, 253, 0.24);">
                    <div class="text-secondary">Akun Gmail Dummy Pengelola:</div>
                    <div>Email: <strong class="text-white">admin.perpus@gmail.com</strong></div>
                    <div>Password: <strong class="text-white">AdminLib#2026</strong></div>
                    <button type="button" class="btn btn-sm btn-outline-info mt-2" id="fillDummyAdminBtn">
                        Isi Otomatis Akun Dummy
                    </button>
                </div>

                <form action="{{ route('booklibrary.manage.login') }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-12">
                        <label class="form-label small fw-bold text-secondary">Email Pengelola</label>
                        <input type="email" name="email" id="adminEmailField" class="form-control" placeholder="admin.perpus@gmail.com" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold text-secondary">Kata Sandi</label>
                        <input type="password" name="password" id="adminPassField" class="form-control" placeholder="Masukkan kata sandi" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                            Masuk ke Dashboard Management
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="panel h-100">
                        <h5 class="fw-bold text-white">Export Excel</h5>
                        <p class="text-secondary small">Unduh seluruh data peminjaman buku masyarakat dalam format XLSX.</p>
                        <a href="{{ route('booklibrary.export') }}" class="btn btn-primary w-100 fw-semibold">
                            Download Excel Peminjaman
                        </a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel h-100">
                        <h5 class="fw-bold text-white">Export PDF (FPDF)</h5>
                        <p class="text-secondary small">Unduh laporan rekap peminjaman buku dalam format PDF.</p>
                        <a href="{{ route('booklibrary.exportPdf') }}" class="btn btn-warning text-dark w-100 fw-semibold">
                            Download PDF Peminjaman
                        </a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel h-100">
                        <h5 class="fw-bold text-white">Import Data Peminjaman</h5>
                        <p class="text-secondary small">Kolom: Gmail | Nama | Judul Buku | Qty | Tgl Pinjam | Durasi | Status</p>
                        <form action="{{ route('booklibrary.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" id="importFileInput" name="file_excel" class="d-none" accept=".xlsx,.xls,.csv" required>
                            <label for="importFileInput" class="custom-file-picker-btn mb-2" id="importFileLabel">
                                <span class="file-spark">✦</span>
                                <span id="importFileNameText">Pilih File Excel / CSV...</span>
                            </label>
                            <button type="submit" class="btn btn-success w-100 fw-semibold">
                                Import Excel / CSV
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-lg-5">
                    <div class="panel h-100">
                        <h5 class="fw-bold text-white mb-1">Status Peminjaman Buku</h5>
                        <p class="text-secondary small mb-3">Perbandingan buku sedang dipinjam dan sudah dikembalikan.</p>
                        <div style="position: relative; height: 250px;">
                            <canvas id="loanStatusChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="panel h-100">
                        <h5 class="fw-bold text-white mb-1">Total Buku Dipinjam per Akun Gmail</h5>
                        <p class="text-secondary small mb-3">Distribusi jumlah buku yang dipinjam oleh masing-masing pengguna Gmail.</p>
                        <div style="position: relative; height: 250px;">
                            <canvas id="loanPerGmailChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel" id="database-peminjaman-panel">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
                    <div>
                        <h4 class="fw-bold text-white mb-1">Database Peminjaman Buku Masyarakat</h4>
                        <p class="text-secondary small mb-0">Seluruh data peminjaman yang masuk melalui akun Gmail pengunjung.</p>
                    </div>

                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <form id="tableSearchForm" action="{{ route('booklibrary.manage') }}" method="GET" class="d-flex align-items-center gap-2">
                            <input type="hidden" name="sort" value="{{ $sort }}">
                            <input type="hidden" name="direction" value="{{ $direction }}">
                            <input
                                type="text"
                                name="q"
                                id="tableSearchInput"
                                value="{{ $search ?? '' }}"
                                class="form-control form-control-sm rounded-pill px-3"
                                style="min-width: 220px;"
                                placeholder="Cari gmail, nama, judul, status...">
                            <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3">
                                Cari
                            </button>
                            @if(!empty($search))
                                <a
                                    href="{{ route('booklibrary.manage', ['sort' => $sort, 'direction' => $direction]) }}"
                                    class="btn btn-sm btn-outline-light rounded-pill px-3 keep-scroll-link">
                                    Reset
                                </a>
                            @endif
                        </form>
                        <span class="badge text-bg-primary">{{ $loans->total() }} transaksi</span>
                    </div>
                </div>

                @php
                    $sortLink = function (string $col, string $label) use ($sort, $direction) {
                        $nextDir = ($sort === $col && $direction === 'asc') ? 'desc' : 'asc';
                        $arrow = $sort === $col ? ($direction === 'asc' ? ' ▲' : ' ▼') : '';
                        $url = request()->fullUrlWithQuery(['sort' => $col, 'direction' => $nextDir, 'page' => 1]);
                        return "<a href=\"{$url}\" class=\"sort-link keep-scroll-link\">{$label}{$arrow}</a>";
                    };
                @endphp

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>{!! $sortLink('gmail_peminjam', 'Akun Gmail') !!}</th>
                                <th>{!! $sortLink('nama_peminjam', 'Nama Peminjam') !!}</th>
                                <th>{!! $sortLink('judul_buku', 'Judul Buku') !!}</th>
                                <th class="text-center">{!! $sortLink('jumlah_buku', 'Qty') !!}</th>
                                <th>{!! $sortLink('tanggal_pinjam', 'Rentang Waktu Peminjaman') !!}</th>
                                <th>{!! $sortLink('status', 'Status') !!}</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($loans as $idx => $loan)
                                @php $loanId = $loan->id ?? $loan->getKey(); @endphp
                                <tr>
                                    <td>{{ $loans->firstItem() + $idx }}</td>
                                    <td class="text-info fw-semibold">{{ $loan->gmail_peminjam }}</td>
                                    <td>{{ $loan->nama_peminjam }}</td>
                                    <td class="fw-semibold text-white">
                                        {{ $loan->judul_buku }}
                                        @if($loan->catatan)
                                            <div class="small text-secondary fw-normal">{{ $loan->catatan }}</div>
                                        @endif
                                    </td>
                                    <td class="text-center fw-bold">{{ $loan->jumlah_buku }}</td>
                                    <td class="small">
                                        {{ optional($loan->tanggal_pinjam)->format('d M Y') ?? '-' }} – {{ optional($loan->tanggal_kembali)->format('d M Y') ?? '-' }}
                                        <span class="text-secondary">({{ $loan->durasi_hari ?? 7 }} hari)</span>
                                    </td>
                                    <td>
                                        @if($loan->status === 'Dipinjam')
                                            <span class="badge text-bg-warning text-dark">Dipinjam</span>
                                        @else
                                            <span class="badge text-bg-success">Dikembalikan</span>
                                        @endif
                                    </td>
                                    <td class="text-end text-nowrap">
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-info icon-action-btn me-1 edit-loan-btn"
                                            title="Edit"
                                            aria-label="Edit"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editLoanModal"
                                            data-id="{{ $loanId }}"
                                            data-gmail="{{ $loan->gmail_peminjam }}"
                                            data-nama="{{ $loan->nama_peminjam }}"
                                            data-judul="{{ $loan->judul_buku }}"
                                            data-qty="{{ $loan->jumlah_buku }}"
                                            data-tgl-pinjam="{{ optional($loan->tanggal_pinjam)->format('Y-m-d') }}"
                                            data-durasi="{{ $loan->durasi_hari ?? 7 }}"
                                            data-status="{{ $loan->status }}"
                                            data-catatan="{{ $loan->catatan ?? '' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M12 20h9"></path>
                                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                            </svg>
                                        </button>

                                        <form
                                            action="{{ route('booklibrary.manage.destroy', $loanId) }}"
                                            method="POST"
                                            class="d-inline delete-loan-form"
                                            onsubmit="return confirm('Yakin ingin menghapus data peminjaman ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger icon-action-btn" title="Hapus" aria-label="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                                                    <path d="M10 11v6"></path>
                                                    <path d="M14 11v6"></path>
                                                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-secondary py-4">
                                        @if(!empty($search))
                                            Tidak ada data peminjaman yang cocok dengan kata kunci "<strong>{{ $search }}</strong>".
                                        @else
                                            Belum ada data peminjaman buku di database.
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end">
                    {{ $loans->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif

    </main>

    @if($isAdmin)
        <div class="modal fade" id="editLoanModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content glass-modal rounded-4">
                    <div class="modal-header border-secondary border-opacity-25">
                        <h5 class="modal-title fw-bold">Edit Data Peminjaman</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <form id="editLoanForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="modal-body row g-3">
                            <div class="col-12">
                                <label class="form-label small fw-bold text-secondary">Akun Gmail</label>
                                <input type="email" name="gmail_peminjam" id="editGmailInput" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-secondary">Nama Peminjam</label>
                                <input type="text" name="nama_peminjam" id="editNamaInput" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-secondary">Judul Buku</label>
                                <input type="text" name="judul_buku" id="editJudulInput" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-secondary">Jumlah (Qty)</label>
                                <input type="number" name="jumlah_buku" id="editQtyInput" class="form-control" min="1" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-secondary">Tanggal Pinjam</label>
                                <input type="date" name="tanggal_pinjam" id="editTglPinjamInput" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-secondary">Durasi (Hari)</label>
                                <input type="number" name="durasi_hari" id="editDurasiInput" class="form-control" min="1" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-secondary">Status</label>
                                <select name="status" id="editStatusInput" class="form-select">
                                    <option value="Dipinjam">Dipinjam</option>
                                    <option value="Dikembalikan">Dikembalikan</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-secondary">Catatan</label>
                                <input type="text" name="catatan" id="editCatatanInput" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer border-secondary border-opacity-25">
                            <button type="button" class="btn btn-sm btn-outline-light rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-sm btn-primary rounded-pill px-4 fw-bold">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <script>
        (function () {
            const SCROLL_KEY = 'booklibrary_manage_scroll_y';

            function saveCurrentScroll() {
                try {
                    sessionStorage.setItem(SCROLL_KEY, String(window.scrollY || window.pageYOffset || 0));
                } catch (_) {}
            }

            // Kembalikan posisi scroll setelah reload/redirect
            try {
                const savedY = sessionStorage.getItem(SCROLL_KEY);
                if (savedY !== null) {
                    sessionStorage.removeItem(SCROLL_KEY);
                    const targetY = parseInt(savedY, 10);
                    if (!Number.isNaN(targetY) && targetY > 0) {
                        requestAnimationFrame(() => {
                            window.scrollTo({ top: targetY, behavior: 'instant' });
                        });
                    }
                }
            } catch (_) {}

            // Simpan posisi scroll saat submit search, edit, hapus, atau klik sort/pagination
            document.getElementById('tableSearchForm')?.addEventListener('submit', saveCurrentScroll);
            document.getElementById('editLoanForm')?.addEventListener('submit', saveCurrentScroll);
            document.querySelectorAll('.delete-loan-form').forEach((form) => {
                form.addEventListener('submit', function () {
                    saveCurrentScroll();
                });
            });
            document.querySelectorAll('.keep-scroll-link, .pagination a.page-link').forEach((link) => {
                link.addEventListener('click', saveCurrentScroll);
            });
        })();

        document.getElementById('fillDummyAdminBtn')?.addEventListener('click', function () {
            document.getElementById('adminEmailField').value = 'admin.perpus@gmail.com';
            document.getElementById('adminPassField').value = 'AdminLib#2026';
        });

        const importFileInput = document.getElementById('importFileInput');
        const importFileNameText = document.getElementById('importFileNameText');
        importFileInput?.addEventListener('change', function () {
            const file = this.files?.[0];
            if (importFileNameText) {
                importFileNameText.textContent = file ? file.name : 'Pilih File Excel / CSV...';
            }
        });

        @if($isAdmin)
            const updateUrlTemplate = @json(route('booklibrary.manage.update', ['id' => '__ID__']));
            document.querySelectorAll('.edit-loan-btn').forEach((btn) => {
                btn.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const form = document.getElementById('editLoanForm');
                    if (form) {
                        form.action = updateUrlTemplate.replace('__ID__', encodeURIComponent(id));
                    }
                    document.getElementById('editGmailInput').value = this.getAttribute('data-gmail') || '';
                    document.getElementById('editNamaInput').value = this.getAttribute('data-nama') || '';
                    document.getElementById('editJudulInput').value = this.getAttribute('data-judul') || '';
                    document.getElementById('editQtyInput').value = this.getAttribute('data-qty') || 1;
                    document.getElementById('editTglPinjamInput').value = this.getAttribute('data-tgl-pinjam') || '';
                    document.getElementById('editDurasiInput').value = this.getAttribute('data-durasi') || 7;
                    document.getElementById('editStatusInput').value = this.getAttribute('data-status') || 'Dipinjam';
                    document.getElementById('editCatatanInput').value = this.getAttribute('data-catatan') || '';
                });
            });

            const statusChartData = @json($statusChart);
            const borrowerChartData = @json($borrowerChart);

            const statusCtx = document.getElementById('loanStatusChart');
            if (statusCtx) {
                new Chart(statusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: statusChartData.labels,
                        datasets: [{
                            data: statusChartData.values,
                            backgroundColor: ['#f59e0b', '#10b981'],
                            borderColor: '#0e172d',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'bottom', labels: { color: '#cbd5e1' } }
                        }
                    }
                });
            }

            const borrowerCtx = document.getElementById('loanPerGmailChart');
            if (borrowerCtx) {
                new Chart(borrowerCtx, {
                    type: 'bar',
                    data: {
                        labels: borrowerChartData.labels.length ? borrowerChartData.labels : ['Belum Ada Data'],
                        datasets: [{
                            label: 'Jumlah Buku Dipinjam',
                            data: borrowerChartData.values.length ? borrowerChartData.values : [0],
                            backgroundColor: '#3b82f6',
                            borderRadius: 8,
                            maxBarThickness: 44
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: { ticks: { color: '#94a3b8' }, grid: { color: 'rgba(147,197,253,0.08)' } },
                            y: { beginAtZero: true, ticks: { precision: 0, color: '#94a3b8' }, grid: { color: 'rgba(147,197,253,0.10)' } }
                        },
                        plugins: { legend: { display: false } }
                    }
                });
            }
        @endif
    </script>
</body>
</html>