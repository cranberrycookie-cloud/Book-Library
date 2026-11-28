<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanBuku;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BookLibraryController extends Controller
{
    private function isValidAdmin(string $email, string $password): bool
    {
        $allowedEmail = strtolower(trim((string) env('GLACIARY_ADMIN_EMAIL', '')));
        $allowedHash  = (string) env('GLACIARY_ADMIN_PASSWORD_HASH', '');

        if ($allowedEmail === '' || $allowedHash === '') {
            return false;
        }

        $inputEmail = strtolower(trim($email));

        if (!hash_equals($allowedEmail, $inputEmail)) {
            return false;
        }

        // Mendukung hash bcrypt/argon ($2y$...) sekaligus fallback jika suatu saat diisi teks biasa
        if (str_starts_with($allowedHash, '$2y$') || str_starts_with($allowedHash, '$2a$') || str_starts_with($allowedHash, '$2b$') || str_starts_with($allowedHash, '$argon2')) {
            return Hash::check($password, $allowedHash);
        }

        return hash_equals($allowedHash, $password);
    }

    public function index(Request $request)
    {
        $userGmail = session('user_gmail');
        $userName = session('user_name');

        // Hanya mengambil data peminjaman milik akun Gmail yang sedang login
        $myLoans = $userGmail
            ? PeminjamanBuku::where('gmail_peminjam', $userGmail)
                ->orderByDesc('created_at')
                ->get()
            : collect();

        return view('book-library.index', compact('userGmail', 'userName', 'myLoans'));
    }

    public function userLogin(Request $request)
    {
        $validated = $request->validate([
            'gmail' => ['required', 'email', 'regex:/@gmail\.com$/i'],
            'nama' => ['required', 'string', 'max:120'],
        ], [
            'gmail.regex' => 'Gunakan alamat email berakhiran @gmail.com.',
        ]);

        session([
            'user_gmail' => strtolower(trim($validated['gmail'])),
            'user_name' => trim($validated['nama']),
        ]);

        return redirect()->route('booklibrary.index')
            ->with('success', 'Berhasil masuk sebagai ' . session('user_gmail'));
    }

    public function userLogout()
    {
        session()->forget(['user_gmail', 'user_name']);
        return redirect()->route('booklibrary.index')
            ->with('success', 'Anda telah keluar dari akun Gmail.');
    }

    public function storeBorrow(Request $request)
    {
        $userGmail = session('user_gmail');
        if (!$userGmail) {
            return redirect()->route('booklibrary.index')
                ->with('error', 'Silakan login dengan akun Gmail terlebih dahulu sebelum meminjam buku.');
        }

        $validated = $request->validate([
            'nama_peminjam' => ['required', 'string', 'max:120'],
            'judul_buku' => ['required', 'string', 'max:255'],
            'isbn' => ['nullable', 'string', 'max:50'],
            'pengarang' => ['nullable', 'string', 'max:255'],
            'penerbit' => ['nullable', 'string', 'max:255'],
            'tahun_terbit' => ['nullable', 'string', 'max:10'],
            'cover_url' => ['nullable', 'string', 'max:1000'],
            'jumlah_buku' => ['required', 'integer', 'min:1', 'max:10'],
            'tanggal_pinjam' => ['required', 'date'],
            'durasi_hari' => ['required', 'integer', 'min:1', 'max:60'],
            'catatan' => ['nullable', 'string', 'max:255'],
        ]);

        $tglPinjam = Carbon::parse($validated['tanggal_pinjam']);
        $tglKembali = $tglPinjam->copy()->addDays((int) $validated['durasi_hari']);

        PeminjamanBuku::create([
            'gmail_peminjam' => $userGmail,
            'nama_peminjam' => $validated['nama_peminjam'],
            'judul_buku' => $validated['judul_buku'],
            'isbn' => $validated['isbn'] ?? null,
            'pengarang' => $validated['pengarang'] ?? null,
            'penerbit' => $validated['penerbit'] ?? null,
            'tahun_terbit' => $validated['tahun_terbit'] ?? null,
            'cover_url' => $validated['cover_url'] ?? null,
            'jumlah_buku' => (int) $validated['jumlah_buku'],
            'tanggal_pinjam' => $tglPinjam->toDateString(),
            'durasi_hari' => (int) $validated['durasi_hari'],
            'tanggal_kembali' => $tglKembali->toDateString(),
            'catatan' => $validated['catatan'] ?? null,
            'status' => 'Dipinjam',
        ]);

        return redirect()->route('booklibrary.index')
            ->with('success', 'Peminjaman "' . $validated['judul_buku'] . '" berhasil dicatat ke database.');
    }

    public function returnBorrow($id)
    {
        $userGmail = session('user_gmail');
        $loan = PeminjamanBuku::where('id', $id)
            ->where('gmail_peminjam', $userGmail)
            ->firstOrFail();

        $loan->update(['status' => 'Dikembalikan']);

        return redirect()->route('booklibrary.index')
            ->with('success', 'Buku "' . $loan->judul_buku . '" telah ditandai dikembalikan.');
    }

    // =========================================================
    // HALAMAN TERPISAH: MANAGEMENT SYSTEM
    // =========================================================
    public function manage(Request $request)
    {
        $isAdmin = (bool) session('is_library_admin', false);
        $adminEmail = session('library_admin_email');

        $search = trim((string) $request->get('q', ''));
        $allowedSorts = ['gmail_peminjam', 'nama_peminjam', 'judul_buku', 'tanggal_pinjam', 'tanggal_kembali', 'status', 'jumlah_buku'];
        $sort = in_array($request->get('sort'), $allowedSorts, true) ? $request->get('sort') : 'created_at';
        $direction = $request->get('direction') === 'asc' ? 'asc' : 'desc';

        $loansQuery = PeminjamanBuku::query();

        if ($search !== '') {
            $loansQuery->where(function ($query) use ($search) {
                $like = '%' . $search . '%';
                $query->where('gmail_peminjam', 'like', $like)
                    ->orWhere('nama_peminjam', 'like', $like)
                    ->orWhere('judul_buku', 'like', $like)
                    ->orWhere('catatan', 'like', $like)
                    ->orWhere('status', 'like', $like);
            });
        }

        $loans = $loansQuery->orderBy($sort, $direction)->paginate(10)->withQueryString();

        // Data Chart 1: Status Peminjaman (Dipinjam vs Dikembalikan)
        $dipinjamTotal = (int) PeminjamanBuku::where('status', 'Dipinjam')->sum('jumlah_buku');
        $dikembalikanTotal = (int) PeminjamanBuku::where('status', 'Dikembalikan')->sum('jumlah_buku');
        $statusChart = [
            'labels' => ['Sedang Dipinjam', 'Sudah Dikembalikan'],
            'values' => [$dipinjamTotal, $dikembalikanTotal],
        ];

        // Data Chart 2: Jumlah Peminjaman per Akun Gmail
        $perGmail = PeminjamanBuku::selectRaw('gmail_peminjam, SUM(jumlah_buku) as total')
            ->groupBy('gmail_peminjam')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        $borrowerChart = [
            'labels' => $perGmail->pluck('gmail_peminjam')->toArray(),
            'values' => $perGmail->pluck('total')->map(fn ($v) => (int) $v)->toArray(),
        ];

        return view('book-library.manage', compact(
            'isAdmin',
            'adminEmail',
            'loans',
            'search',
            'sort',
            'direction',
            'statusChart',
            'borrowerChart'
        ));
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $email = strtolower(trim((string) $request->input('email')));
        $password = (string) $request->input('password');

        if (!$this->isValidAdmin($email, $password)) {
            return redirect()->route('booklibrary.manage')
                ->with('error', 'Akun pengelola tidak terdaftar atau kata sandi salah.');
        }

        session([
            'is_library_admin' => true,
            'library_admin_email' => $email,
        ]);

        return redirect()->route('booklibrary.manage')
            ->with('success', 'Berhasil masuk ke Management System.');
    }

    public function adminLogout()
    {
        session()->forget(['is_library_admin', 'library_admin_email']);
        return redirect()->route('booklibrary.manage');
    }

    public function updateLoan(Request $request, $id)
    {
        abort_unless(session('is_library_admin'), 403);

        $validated = $request->validate([
            'gmail_peminjam' => ['required', 'email', 'max:150'],
            'nama_peminjam' => ['required', 'string', 'max:120'],
            'judul_buku' => ['required', 'string', 'max:255'],
            'jumlah_buku' => ['required', 'integer', 'min:1', 'max:50'],
            'tanggal_pinjam' => ['required', 'date'],
            'durasi_hari' => ['required', 'integer', 'min:1', 'max:365'],
            'status' => ['required', 'in:Dipinjam,Dikembalikan'],
            'catatan' => ['nullable', 'string', 'max:255'],
        ]);

        $loan = PeminjamanBuku::findOrFail($id);

        $tglPinjam = Carbon::parse($validated['tanggal_pinjam']);
        $durasi = (int) $validated['durasi_hari'];
        $tglKembali = $tglPinjam->copy()->addDays($durasi);

        $loan->update([
            'gmail_peminjam' => strtolower(trim($validated['gmail_peminjam'])),
            'nama_peminjam' => trim($validated['nama_peminjam']),
            'judul_buku' => trim($validated['judul_buku']),
            'jumlah_buku' => (int) $validated['jumlah_buku'],
            'tanggal_pinjam' => $tglPinjam->toDateString(),
            'durasi_hari' => $durasi,
            'tanggal_kembali' => $tglKembali->toDateString(),
            'status' => $validated['status'],
            'catatan' => $validated['catatan'] ?? null,
        ]);

        return redirect()->route('booklibrary.manage')
            ->with('success', 'Data peminjaman "' . $loan->judul_buku . '" berhasil diperbarui.');
    }

    public function destroyLoan($id)
    {
        abort_unless(session('is_library_admin'), 403);

        $loan = PeminjamanBuku::findOrFail($id);
        $judul = $loan->judul_buku;
        $loan->delete();

        return redirect()->route('booklibrary.manage')
            ->with('success', 'Data peminjaman "' . $judul . '" berhasil dihapus.');
    }

    // =========================================================
    // EXPORT EXCEL (DATA PEMINJAMAN DATABASE)
    // =========================================================
    public function exportExcel()
    {
        abort_unless(session('is_library_admin'), 403);

        $loans = PeminjamanBuku::orderByDesc('created_at')->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Peminjaman Buku');

        $headers = ['No', 'Gmail Peminjam', 'Nama Peminjam', 'Judul Buku', 'ISBN', 'Qty', 'Tanggal Pinjam', 'Tanggal Kembali', 'Durasi (Hari)', 'Status', 'Catatan'];
        $sheet->fromArray($headers, null, 'A1');

        $row = 2;
        foreach ($loans as $idx => $loan) {
            $sheet->fromArray([
                $idx + 1,
                $loan->gmail_peminjam,
                $loan->nama_peminjam,
                $loan->judul_buku,
                $loan->isbn ?: '-',
                $loan->jumlah_buku,
                $loan->tanggal_pinjam->format('Y-m-d'),
                $loan->tanggal_kembali->format('Y-m-d'),
                $loan->durasi_hari,
                $loan->status,
                $loan->catatan ?: '-',
            ], null, 'A' . $row++);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'laporan_peminjaman_buku_' . date('Ymd_His') . '.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    // =========================================================
    // EXPORT PDF VIA FPDF (DATA PEMINJAMAN DATABASE)
    // =========================================================
    public function exportPdf()
    {
        abort_unless(session('is_library_admin'), 403);

        $loans = PeminjamanBuku::orderByDesc('created_at')->get();

        $pdf = new \FPDF('L', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Laporan Data Peminjaman Book Library', 0, 1, 'C');
        $pdf->Ln(2);

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(10, 8, 'No', 1);
        $pdf->Cell(55, 8, 'Gmail Peminjam', 1);
        $pdf->Cell(42, 8, 'Nama Peminjam', 1);
        $pdf->Cell(72, 8, 'Judul Buku', 1);
        $pdf->Cell(14, 8, 'Qty', 1, 0, 'C');
        $pdf->Cell(52, 8, 'Rentang Waktu', 1);
        $pdf->Cell(30, 8, 'Status', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 8.5);
        foreach ($loans as $idx => $loan) {
            $rentang = $loan->tanggal_pinjam->format('d/m/Y') . ' - ' . $loan->tanggal_kembali->format('d/m/Y');
            $pdf->Cell(10, 7, $idx + 1, 1);
            $pdf->Cell(55, 7, substr($loan->gmail_peminjam, 0, 32), 1);
            $pdf->Cell(42, 7, substr($loan->nama_peminjam, 0, 24), 1);
            $pdf->Cell(72, 7, substr($loan->judul_buku, 0, 42), 1);
            $pdf->Cell(14, 7, $loan->jumlah_buku, 1, 0, 'C');
            $pdf->Cell(52, 7, $rentang, 1);
            $pdf->Cell(30, 7, $loan->status, 1, 1, 'C');
        }

        return response($pdf->Output('S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="laporan_peminjaman_buku.pdf"',
        ]);
    }

    // =========================================================
    // IMPORT EXCEL / CSV (DATA PEMINJAMAN KE DATABASE)
    // =========================================================
    public function importExcel(Request $request)
    {
        abort_unless(session('is_library_admin'), 403);

        $request->validate([
            'file_excel' => ['required', 'file', 'mimes:xlsx,xls,csv'],
        ]);

        $spreadsheet = IOFactory::load($request->file('file_excel')->getRealPath());
        $rows = $spreadsheet->getActiveSheet()->toArray();

        $berhasil = 0;
        $tidakValid = 0;

        foreach (array_slice($rows, 1) as $row) {
            $gmail = strtolower(trim((string) ($row[0] ?? '')));
            $nama = trim((string) ($row[1] ?? ''));
            $judul = trim((string) ($row[2] ?? ''));
            $qty = max(1, (int) ($row[3] ?? 1));
            $tglPinjam = trim((string) ($row[4] ?? date('Y-m-d')));
            $durasi = max(1, (int) ($row[5] ?? 7));
            $status = in_array(trim((string) ($row[6] ?? '')), ['Dipinjam', 'Dikembalikan'], true)
                ? trim((string) $row[6])
                : 'Dipinjam';

            if (!filter_var($gmail, FILTER_VALIDATE_EMAIL) || $nama === '' || $judul === '') {
                $tidakValid++;
                continue;
            }

            $start = Carbon::parse($tglPinjam);
            PeminjamanBuku::create([
                'gmail_peminjam' => $gmail,
                'nama_peminjam' => $nama,
                'judul_buku' => $judul,
                'jumlah_buku' => $qty,
                'tanggal_pinjam' => $start->toDateString(),
                'durasi_hari' => $durasi,
                'tanggal_kembali' => $start->copy()->addDays($durasi)->toDateString(),
                'status' => $status,
            ]);
            $berhasil++;
        }

        return redirect()->route('booklibrary.manage')->with('hasil_import', [
            'berhasil' => $berhasil,
            'tidak_valid' => $tidakValid,
        ]);
    }

    // =========================================================
    // OPEN LIBRARY API SEARCH
    // =========================================================
    public function searchApi(Request $request)
    {
        $q = trim((string) $request->query('q', 'Atomic Habits'));
        $response = Http::timeout(10)->get('https://openLibrary.org/search.json', [
            'q' => $q,
            'limit' => 8,
        ]);

        if (!$response->ok()) {
            return response()->json(['items' => []], 502);
        }

        $docs = $response->json('docs', []);
        $items = collect($docs)->map(function ($doc) {
            $coverId = $doc['cover_i'] ?? null;
            return [
                'judul_buku' => $doc['title'] ?? 'Tanpa Judul',
                'pengarang' => isset($doc['author_name'][0]) ? $doc['author_name'][0] : 'Penulis Tidak Diketahui',
                'penerbit' => isset($doc['publisher'][0]) ? $doc['publisher'][0] : 'Penerbit Umum',
                'tahun_terbit' => isset($doc['first_publish_year']) ? (string) $doc['first_publish_year'] : '',
                'isbn' => isset($doc['isbn'][0]) ? $doc['isbn'][0] : '',
                'cover_url' => $coverId ? "https://covers.openlibrary.org/b/id/{$coverId}-L.jpg" : '',
            ];
        })->values();

        return response()->json(['items' => $items]);
    }
}