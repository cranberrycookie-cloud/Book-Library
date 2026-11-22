<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

use Smalot\PdfParser\Parser;

use Throwable;
use RuntimeException;
use FPDF;

class BookLibraryController extends Controller
{
    // =====================================================
    // HELPER SORTING ASC / DESC
    // =====================================================

    private function getSortParams(Request $request): array
    {
        $allowedSorts = [
            'isbn',
            'namaBarang',
            'pengarang',
            'penerbit',
            'tahun_terbit',
            'jumlah_tersedia',
            'jumlah_dipinjam',
            'kuantitas',
            'time'
        ];

        $sort = in_array($request->get('sort'), $allowedSorts, true)
            ? $request->get('sort')
            : 'namaBarang';

        $direction = $request->get('direction') === 'desc' ? 'desc' : 'asc';

        return [$sort, $direction];
    }


    // =====================================================
    // DASHBOARD
    // =====================================================

    public function index(Request $request)
    {
        [$sort, $direction] = $this->getSortParams($request);

        $books = Transaksi::orderBy($sort, $direction)
            ->paginate(10)
            ->withQueryString();

        return view('book-library.index', compact('books', 'sort', 'direction'));
    }


    // =====================================================
    // HALAMAN MANAGEMENT
    // =====================================================

    public function manage(Request $request)
    {
        [$sort, $direction] = $this->getSortParams($request);

        $books = Transaksi::orderBy($sort, $direction)
            ->paginate(10)
            ->withQueryString();

        return view('book-library.manage', compact('books', 'sort', 'direction'));
    }


    // =====================================================
    // VALIDASI DATA BUKU
    // =====================================================

    private function validateBook(Request $request, ?Transaksi $book = null): array
    {
        $isbn = preg_replace(
            '/[\s-]+/',
            '',
            (string) $request->input('isbn', '')
        );

        $request->merge([
            'isbn' => $isbn
        ]);

        $isbnUnique = Rule::unique('transaksis', 'isbn');

        if ($book) {
            $isbnUnique->ignore(
                $book->id_transaksi,
                'id_transaksi'
            );
        }

        $validator = Validator::make($request->all(), [

            'isbn' => [
                'required',
                'string',
                'max:20',
                $isbnUnique
            ],

            'judul_buku' => 'required|string|max:255',
            'pengarang' => 'nullable|string|max:255',
            'penerbit' => 'nullable|string|max:255',
            'tahun_terbit' => 'nullable|integer|min:1000|max:2100',
            'jumlah_tersedia' => 'required|integer|min:0',
            'jumlah_dipinjam' => 'required|integer|min:0',

        ], [

            'isbn.required' => 'ISBN wajib diisi.',
            'isbn.unique' => 'ISBN sudah terdaftar.',
            'judul_buku.required' => 'Judul buku wajib diisi.',
            'jumlah_tersedia.required' => 'Jumlah tersedia wajib diisi.',
            'jumlah_dipinjam.required' => 'Jumlah dipinjam wajib diisi.',

        ]);

        $validator->after(function ($validator) use ($request) {

            $tersedia = (int) $request->jumlah_tersedia;
            $dipinjam = (int) $request->jumlah_dipinjam;

            if ($tersedia + $dipinjam < 1) {

                $validator->errors()->add(
                    'jumlah_tersedia',
                    'Total jumlah buku minimal 1.'
                );

            }

        });

        return $validator->validate();
    }


    // =====================================================
    // MENGHUBUNGKAN FORM DENGAN DATABASE
    // =====================================================

    private function mapBookData(array $data): array
    {
        $total = (int) $data['jumlah_tersedia']
               + (int) $data['jumlah_dipinjam'];

        return [

            'isbn' => $data['isbn'],

            'namaBarang' => $data['judul_buku'],

            'pengarang' => $data['pengarang'] ?? null,

            'penerbit' => $data['penerbit'] ?? null,

            'tahun_terbit' => $data['tahun_terbit'] ?? null,

            'jumlah_tersedia' => (int) $data['jumlah_tersedia'],

            'jumlah_dipinjam' => (int) $data['jumlah_dipinjam'],

            'kuantitas' => $total,

        ];
    }


    // =====================================================
    // MEMBUAT ID BUKU
    // =====================================================

    private function generateBookId(): string
    {
        do {

            $id = 'BK' . Str::upper(Str::random(16));

        } while (
            Transaksi::where('id_transaksi', $id)->exists()
        );

        return $id;
    }


    // =====================================================
    // STATUS BUKU
    // =====================================================

    private function statusText(Transaksi $book): string
    {
        $status = [];

        if ((int) $book->jumlah_tersedia > 0) {
            $status[] = 'Tersedia';
        }

        if ((int) $book->jumlah_dipinjam > 0) {
            $status[] = 'Sedang Dipinjam';
        }

        if (empty($status)) {
            return 'Stok Kosong';
        }

        return implode(', ', $status);
    }


    // =====================================================
    // TOTAL QTY
    // =====================================================

    private function quantityTotal(Transaksi $book): int
    {
        return (int) $book->jumlah_tersedia
             + (int) $book->jumlah_dipinjam;
    }


    // =====================================================
    // TAMBAH BUKU
    // =====================================================

    public function store(Request $request)
    {
        $data = $this->validateBook($request);

        Transaksi::create(array_merge([

            'id_transaksi' => $this->generateBookId(),

            'time' => now(),

        ], $this->mapBookData($data)));

        return redirect()
            ->route('booklibrary.manage')
            ->with('success', 'Data buku berhasil ditambahkan.');
    }


    // =====================================================
    // UPDATE BUKU
    // =====================================================

    public function update(Request $request, string $id)
    {
        $book = Transaksi::findOrFail($id);

        $data = $this->validateBook($request, $book);

        $book->update(
            $this->mapBookData($data)
        );

        return redirect()
            ->route('booklibrary.manage')
            ->with('success', 'Data buku berhasil diperbarui.');
    }


    // =====================================================
    // DELETE BUKU
    // =====================================================

    public function destroy(string $id)
    {
        $book = Transaksi::findOrFail($id);

        $book->delete();

        return redirect()
            ->route('booklibrary.manage')
            ->with('success', 'Data buku berhasil dihapus.');
    }


    // =====================================================
    // EXPORT EXCEL
    // =====================================================

    public function export()
    {
        $books = Transaksi::orderBy('namaBarang')->get();

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle('Data Buku');

        $headers = [
            'No.',
            'ISBN',
            'Judul Buku',
            'Pengarang',
            'Penerbit',
            'Tahun Terbit',
            'Keterangan',
            'Qty'
        ];

        $sheet->fromArray($headers, null, 'A1');

        $row = 2;

        foreach ($books as $index => $book) {

            $sheet->fromArray([

                $index + 1,
                $book->isbn,
                $book->namaBarang,
                $book->pengarang,
                $book->penerbit,
                $book->tahun_terbit,
                $this->statusText($book),
                $this->quantityTotal($book)

            ], null, 'A' . $row);

            $row++;

        }

        foreach (range('A', 'H') as $column) {

            $sheet->getColumnDimension($column)
                ->setAutoSize(true);

        }

        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {

            while (ob_get_level() > 0) {
                ob_end_clean();
            }

            $writer->save('php://output');

        }, 'Book_Library.xlsx');
    }


    // =====================================================
    // EXPORT PDF
    // =====================================================

    public function exportPdf()
    {
        $books = Transaksi::orderBy('namaBarang')->get();

        $pdf = new FPDF('L', 'mm', 'A4');

        $pdf->SetMargins(10, 10, 10);

        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 16);

        $pdf->Cell(0, 10, 'BOOK LIBRARY', 0, 1, 'C');

        $pdf->SetFont('Arial', '', 10);

        $pdf->Cell(0, 7, 'Daftar Koleksi Buku', 0, 1, 'C');

        $pdf->Ln(4);

        $widths = [10, 31, 54, 37, 40, 17, 44, 44];

        $headers = [
            'No.',
            'ISBN',
            'Judul Buku',
            'Pengarang',
            'Penerbit',
            'Tahun',
            'Keterangan',
            'Qty'
        ];

        $pdf->SetFont('Arial', 'B', 8);

        foreach ($headers as $index => $header) {

            $pdf->Cell(
                $widths[$index],
                9,
                $header,
                1,
                0,
                'C'
            );

        }

        $pdf->Ln();

        $pdf->SetFont('Arial', '', 7);

        foreach ($books as $index => $book) {

            $values = [

                (string) ($index + 1),
                $book->isbn ?? '-',
                $book->namaBarang,
                $book->pengarang ?? '-',
                $book->penerbit ?? '-',
                (string) ($book->tahun_terbit ?? '-'),
                $this->statusText($book),
                (string) $this->quantityTotal($book)

            ];

            foreach ($values as $column => $value) {

                $pdf->Cell(

                    $widths[$column],
                    8,
                    $this->pdfText($value),
                    1,
                    0,
                    'C'

                );

            }

            $pdf->Ln();

        }

        return response(
            $pdf->Output('S', 'Book_Library.pdf')
        )
        ->header('Content-Type', 'application/pdf')
        ->header(
            'Content-Disposition',
            'attachment; filename="Book_Library.pdf"'
        );
    }


    // =====================================================
    // FORMAT TEKS PDF
    // =====================================================

    private function pdfText(string $text): string
    {
        if (function_exists('iconv')) {

            $converted = iconv(
                'UTF-8',
                'Windows-1252//TRANSLIT//IGNORE',
                $text
            );

            if ($converted !== false) {
                return $converted;
            }

        }

        return $text;
    }


    // =====================================================
    // MEMBACA DATA DARI EXCEL
    // =====================================================

    private function readExcelRows(string $path): array
    {
        $spreadsheet = IOFactory::load($path);

        $sheet = $spreadsheet->getActiveSheet();

        $lastRow = $sheet->getHighestRow();

        $rows = [];

        for ($row = 2; $row <= $lastRow; $row++) {

            $rows[] = [

                'isbn' => $sheet->getCell('A' . $row)->getFormattedValue(),

                'judul_buku' => $sheet->getCell('B' . $row)->getFormattedValue(),

                'pengarang' => $sheet->getCell('C' . $row)->getFormattedValue(),

                'penerbit' => $sheet->getCell('D' . $row)->getFormattedValue(),

                'tahun_terbit' => $sheet->getCell('E' . $row)->getFormattedValue(),

                'jumlah_tersedia' => $sheet->getCell('F' . $row)->getFormattedValue(),

                'jumlah_dipinjam' => $sheet->getCell('G' . $row)->getFormattedValue(),

            ];

        }

        return $rows;
    }


    // =====================================================
    // MEMBACA DATA DARI PDF
    // =====================================================

    private function readPdfRows(string $path): array
    {
        $parser = new Parser();

        $document = $parser->parseFile($path);

        $text = $document->getText();

        if (trim($text) === '') {

            throw new RuntimeException(
                'PDF tidak memiliki teks yang dapat dibaca.'
            );

        }

        $lines = preg_split('/\R/u', $text);

        $rows = [];

        $buffer = '';

        foreach ($lines as $line) {

            $line = trim(
                str_replace("\xC2\xA0", ' ', $line)
            );

            if ($line === '') {
                continue;
            }

            // Menggabungkan baris jika teks PDF terpotong
            $buffer = trim($buffer . ' ' . $line);

            // Setiap data harus mempunyai 6 pemisah |
            if (substr_count($buffer, '|') < 6) {
                continue;
            }

            if (substr_count($buffer, '|') > 6) {

                $buffer = '';

                continue;

            }

            $columns = array_map(
                'trim',
                explode('|', $buffer)
            );

            $buffer = '';

            if (count($columns) !== 7) {
                continue;
            }

            /// Melewati baris judul/header dan keterangan format
            if (
                strtolower($columns[0]) === 'isbn' ||
                str_starts_with(strtolower($columns[0]), 'format:')
            ) {
                continue;
            }

            $rows[] = [

                'isbn' => $columns[0],

                'judul_buku' => $columns[1],

                'pengarang' => $columns[2],

                'penerbit' => $columns[3],

                'tahun_terbit' => $columns[4],

                'jumlah_tersedia' => $columns[5],

                'jumlah_dipinjam' => $columns[6],

            ];

        }

        return $rows;
    }


    // =====================================================
    // VALIDASI BARIS HASIL IMPORT
    // =====================================================

    private function normalizeImportedRow(array $row): ?array
    {
        $isbn = preg_replace(
            '/[\s-]+/',
            '',
            (string) ($row['isbn'] ?? '')
        );

        $judul = trim(
            (string) ($row['judul_buku'] ?? '')
        );

        $pengarang = trim(
            (string) ($row['pengarang'] ?? '')
        );

        $penerbit = trim(
            (string) ($row['penerbit'] ?? '')
        );

        $tahun = trim(
            (string) ($row['tahun_terbit'] ?? '')
        );

        $tersedia = trim(
            (string) ($row['jumlah_tersedia'] ?? '')
        );

        $dipinjam = trim(
            (string) ($row['jumlah_dipinjam'] ?? '')
        );

        // ISBN harus 10 atau 13 digit
        if (!preg_match('/^(?:\d{10}|\d{13})$/', $isbn)) {
            return null;
        }

        if ($judul === '') {
            return null;
        }

        // Validasi tahun
        if ($tahun !== '') {

            if (
                !preg_match('/^\d{4}$/', $tahun) ||
                (int) $tahun < 1000 ||
                (int) $tahun > 2100
            ) {
                return null;
            }

        }

        // Validasi jumlah tersedia
        if (
            !preg_match('/^\d+$/', $tersedia)
        ) {
            return null;
        }

        // Validasi jumlah dipinjam
        if (
            !preg_match('/^\d+$/', $dipinjam)
        ) {
            return null;
        }

        $tersedia = (int) $tersedia;

        $dipinjam = (int) $dipinjam;

        if ($tersedia + $dipinjam < 1) {
            return null;
        }

        return [

            'isbn' => $isbn,

            'judul_buku' => $judul,

            'pengarang' => $pengarang !== ''
                ? $pengarang
                : null,

            'penerbit' => $penerbit !== ''
                ? $penerbit
                : null,

            'tahun_terbit' => $tahun !== ''
                ? (int) $tahun
                : null,

            'jumlah_tersedia' => $tersedia,

            'jumlah_dipinjam' => $dipinjam,

        ];
    }


    // =====================================================
    // IMPORT EXCEL DAN PDF
    // =====================================================

    public function import(Request $request)
    {
        $request->validate([

            'file_excel' => 'required|file|mimes:xlsx,xls,csv,pdf|max:10240',

        ]);

        $berhasil = 0;

        $duplikat = 0;

        $tidakValid = 0;

        try {

            $file = $request->file('file_excel');

            $extension = strtolower(
                $file->getClientOriginalExtension()
            );

            // Membaca PDF
            if ($extension === 'pdf') {

                $rows = $this->readPdfRows(
                    $file->getRealPath()
                );

            }

            // Membaca Excel / CSV
            else {

                $rows = $this->readExcelRows(
                    $file->getRealPath()
                );

            }

            if (empty($rows)) {

                return redirect()
                    ->route('booklibrary.index')
                    ->with(
                        'error',
                        'Tidak ditemukan data buku. Periksa format file yang diimpor.'
                    );

            }

            foreach ($rows as $row) {

                $data = $this->normalizeImportedRow($row);

                // Data tidak valid
                if ($data === null) {

                    $tidakValid++;

                    continue;

                }

                // ISBN sudah tersedia
                if (
                    Transaksi::where('isbn', $data['isbn'])->exists()
                ) {

                    $duplikat++;

                    continue;

                }

                // Menyimpan buku
                Transaksi::create(array_merge(

                    [

                        'id_transaksi' => $this->generateBookId(),

                        'time' => now(),

                    ],

                    $this->mapBookData($data)
                ));
                $berhasil++;
            }

            return redirect()
                ->route('booklibrary.index')
                ->with('hasil_import', [
                    'berhasil' => $berhasil,
                    'duplikat' => $duplikat,
                    'tidak_valid' => $tidakValid,
                ]);

        } catch (Throwable $e) {
            report($e);
            return redirect()
                ->route('booklibrary.index')
                ->with(
                    'error',
                    'Import gagal. Pastikan format PDF atau Excel sudah benar. Detail: ' . $e->getMessage()
                );
        }
    }

}