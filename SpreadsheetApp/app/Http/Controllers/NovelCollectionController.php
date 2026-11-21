<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Carbon\Carbon;
use Throwable;
use FPDF;

class NovelCollectionController extends Controller
{
    // Menampilkan halaman Novel Collection
    public function index()
    {
        $transaksis = Transaksi::orderBy('id_transaksi')
            ->paginate(10);

        return view('transaksi.index', compact('transaksis'));
    }

    // Export data novel ke Excel
    public function export()
    {
        $transaksis = Transaksi::orderBy('id_transaksi')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle('Data Novel');

        // Header Excel
        $headers = [
            'ID Novel',
            'Waktu',
            'Judul Novel',
            'Harga',
            'Kuantitas'
        ];

        $sheet->fromArray($headers, null, 'A1');

        // Mengisi data novel
        $row = 2;

        foreach ($transaksis as $transaksi) {
            $sheet->fromArray([
                $transaksi->id_transaksi,
                $transaksi->time,
                $transaksi->namaBarang,
                $transaksi->hargaBarang,
                $transaksi->kuantitas
            ], null, 'A' . $row);

            $row++;
        }

        // Mengatur lebar kolom otomatis
        foreach (range('A', 'E') as $column) {
            $sheet->getColumnDimension($column)
                ->setAutoSize(true);
        }

        // Membuat file Excel
        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {

            // Membersihkan output buffer
            while (ob_get_level() > 0) {
                ob_end_clean();
            }

            $writer->save('php://output');

        }, 'Novel_Collection.xlsx', [
            'Content-Type' =>
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
    }
// Export data novel ke PDF
public function exportPdf()
{
    $transaksis = Transaksi::orderBy('id_transaksi')->get();

    $pdf = new FPDF('L', 'mm', 'A4');
    $pdf->AddPage();

    // Judul
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'NOVEL COLLECTION', 0, 1, 'C');

    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(0, 7, 'Daftar Koleksi Novel', 0, 1, 'C');

    $pdf->Ln(5);

    // Header tabel
    $pdf->SetFont('Arial', 'B', 10);

    $pdf->Cell(15, 10, 'No.', 1, 0, 'C');
    $pdf->Cell(35, 10, 'ID Novel', 1, 0, 'C');
    $pdf->Cell(45, 10, 'Waktu', 1, 0, 'C');
    $pdf->Cell(90, 10, 'Judul Novel', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Harga', 1, 0, 'C');
    $pdf->Cell(35, 10, 'Kuantitas', 1, 1, 'C');

    // Isi tabel
    $pdf->SetFont('Arial', '', 9);

    $no = 1;

    foreach ($transaksis as $transaksi) {

        $waktu = Carbon::parse($transaksi->time)
            ->format('d/m/Y H:i');

        $harga = 'Rp ' . number_format(
            $transaksi->hargaBarang,
            0,
            ',',
            '.'
        );

        $pdf->Cell(15, 8, $no, 1, 0, 'C');
        $pdf->Cell(35, 8, $transaksi->id_transaksi, 1, 0, 'C');
        $pdf->Cell(45, 8, $waktu, 1, 0, 'C');
        $pdf->Cell(90, 8, $transaksi->namaBarang, 1, 0, 'L');
        $pdf->Cell(40, 8, $harga, 1, 0, 'R');
        $pdf->Cell(35, 8, $transaksi->kuantitas . ' buku', 1, 1, 'C');

        $no++;
    }

    // Output PDF
    return response(
        $pdf->Output('S', 'Novel_Collection.pdf')
    )
    ->header('Content-Type', 'application/pdf')
    ->header(
        'Content-Disposition',
        'attachment; filename="Novel_Collection.pdf"'
    );
}
    // Import data novel dari Excel
    public function import(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        $berhasil = 0;
        $duplikat = 0;
        $tidakValid = 0;

        try {
            $spreadsheet = IOFactory::load(
                $request->file('file_excel')->getRealPath()
            );

            $sheet = $spreadsheet->getActiveSheet();

            $barisTerakhir = $sheet->getHighestRow();

            // Baris pertama adalah judul kolom
            for ($row = 2; $row <= $barisTerakhir; $row++) {

                $id = trim((string) $sheet->getCell('A' . $row)->getValue());
                $waktu = $sheet->getCell('B' . $row)->getValue();
                $nama = trim((string) $sheet->getCell('C' . $row)->getValue());
                $harga = $sheet->getCell('D' . $row)->getValue();
                $kuantitas = $sheet->getCell('E' . $row)->getValue();

                // Lewati baris kosong
                if ($id === '' && $nama === '') {
                    continue;
                }

                // Periksa kelengkapan data
                if (
                    $id === '' ||
                    $nama === '' ||
                    $waktu === null ||
                    $waktu === '' ||
                    !is_numeric($harga) ||
                    !is_numeric($kuantitas) ||
                    $kuantitas < 0
                ) {
                    $tidakValid++;
                    continue;
                }

                // Periksa ID yang sudah ada
                if (Transaksi::where('id_transaksi', $id)->exists()) {
                    $duplikat++;
                    continue;
                }

                // Mengubah tanggal Excel menjadi format database
                if (is_numeric($waktu)) {
                    $waktu = ExcelDate::excelToDateTimeObject($waktu);
                } else {
                    $waktu = Carbon::parse($waktu);
                }

                // Menyimpan data novel
                Transaksi::create([
                    'id_transaksi' => $id,
                    'time' => $waktu,
                    'namaBarang' => $nama,
                    'hargaBarang' => $harga,
                    'kuantitas' => $kuantitas
                ]);

                $berhasil++;
            }

            // Kembali ke halaman Novel Collection
            return redirect()->route('novelcollection.index')
                ->with('hasil_import', [
                    'berhasil' => $berhasil,
                    'duplikat' => $duplikat,
                    'tidak_valid' => $tidakValid
                ]);

        } catch (Throwable $e) {

            // Menampilkan pesan jika import gagal
            return redirect()->route('novelcollection.index')
                ->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }
}
