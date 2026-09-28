<?php

namespace App\Http\Controllers;

use App\Models\DownloadableForm;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FormDownloadController extends Controller
{
    /**
     * Download a form by its ID.
     */
    public function download(DownloadableForm $form): StreamedResponse|BinaryFileResponse
    {
        $this->ensureFileExists($form->file_path, $form->name);

        return Storage::disk('public')->download($form->file_path, $form->name);
    }

    /**
     * Quick download by key (e.g. sptjm, pengantar-desa, surat-tidak-mampu).
     */
    public function quickDownload(string $key): StreamedResponse|BinaryFileResponse
    {
        $formsMap = [
            'sptjm' => [
                'name' => 'Format Surat Pernyataan Tanggung Jawab Mutlak (SPTJM).docx',
                'file_path' => 'forms/format_sptjm_dtsen_blitar.docx',
            ],
            'pengantar-desa' => [
                'name' => 'Format Surat Pengantar Desa Pelayanan Sosial.pdf',
                'file_path' => 'forms/format_surat_pengantar_desa.pdf',
            ],
            'surat-tidak-mampu' => [
                'name' => 'Format Surat Pernyataan Tidak Mampu Mandiri.pdf',
                'file_path' => 'forms/format_surat_pernyataan_tidak_mampu.pdf',
            ],
            'reaktivasi-pbi' => [
                'name' => 'Formulir Pengajuan Reaktivasi Peserta PBI-JK.pdf',
                'file_path' => 'forms/formulir_reaktivasi_pbi_jk.pdf',
            ],
            'surat-medis' => [
                'name' => 'Format Surat Keterangan Medis Faskes Reaktivasi PBI.pdf',
                'file_path' => 'forms/format_surat_medis_faskes_pbi.pdf',
            ],
        ];

        if (! isset($formsMap[$key])) {
            return redirect()->route('formulir.index');
        }

        $formInfo = $formsMap[$key];
        $this->ensureFileExists($formInfo['file_path'], $formInfo['name']);

        return Storage::disk('public')->download($formInfo['file_path'], $formInfo['name']);
    }

    /**
     * Ensure the physical template file exists on disk, create official sample if missing.
     */
    private function ensureFileExists(string $filePath, string $name): void
    {
        if (Storage::disk('public')->exists($filePath)) {
            return;
        }

        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        if ($extension === 'docx') {
            $content = $this->generateRtfContent($name);
        } else {
            $content = $this->generatePdfContent($name);
        }

        Storage::disk('public')->put($filePath, $content);
    }

    /**
     * Generate standard official PDF document.
     */
    private function generatePdfContent(string $title): string
    {
        $lines = [
            'PEMERINTAH KABUPATEN BLITAR',
            'DINAS SOSIAL',
            'Jl. Raya Barat No. 1, Kanigoro, Kab. Blitar, Jawa Timur 66171 | Telp: (0342) 801123',
            '--------------------------------------------------------------------------------------------------',
            '',
            strtoupper($title),
            '',
            'Yang bertanda tangan di bawah ini:',
            'Nama Lengkap          : .................................................................................',
            'NIK (KTP)             : .................................................................................',
            'No. Kartu Keluarga    : .................................................................................',
            'Alamat Domisili       : RT ...... / RW ...... Desa/Kel. .................................................',
            'Kecamatan             : ................................................... Kab. Blitar',
            'No. Handphone / WA    : .................................................................................',
            '',
            'Dengan ini menyatakan dengan sesungguhnya bahwa:',
            '1. Data dan dokumen persyaratan yang diajukan adalah benar, sah, dan dapat dipertanggungjawabkan.',
            '2. Benar-benar membutuhkan pelayanan/bantuan sosial dari Pemerintah Kabupaten Blitar.',
            '3. Bersedia dilakukan verifikasi lapangan dan bersedia menerima sanksi apabila data terbukti palsu.',
            '',
            'Demikian surat pernyataan / formulir permohonan ini dibuat dengan penuh kesadaran.',
            '',
            '                                                          Blitar, ................................... 2026',
            'Mengetahui / Mengesahkan,                                 Pemohon / Yang Menyatakan,',
            'Kepala Desa / Lurah,                                      (Materai Rp 10.000)',
            '',
            '',
            '( ....................................... )               ( ....................................... )',
        ];

        $stream = 'BT /F1 14 Tf 50 800 Td ('.addcslashes($lines[0], '()\\').") Tj ET\n";
        $stream .= 'BT /F1 16 Tf 50 780 Td ('.addcslashes($lines[1], '()\\').") Tj ET\n";
        $stream .= 'BT /F1 8 Tf 50 765 Td ('.addcslashes($lines[2], '()\\').") Tj ET\n";
        $stream .= 'BT /F1 8 Tf 50 755 Td ('.addcslashes($lines[3], '()\\').") Tj ET\n";
        $stream .= 'BT /F1 12 Tf 50 730 Td ('.addcslashes($lines[5], '()\\').") Tj ET\n";

        $y = 700;
        for ($i = 7; $i < count($lines); $i++) {
            $stream .= 'BT /F1 10 Tf 50 '.$y.' Td ('.addcslashes($lines[$i], '()\\').") Tj ET\n";
            $y -= 16;
        }

        $length = strlen($stream);

        $pdf = "%PDF-1.4\n";
        $pdf .= "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n";
        $pdf .= "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n";
        $pdf .= "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >>\nendobj\n";
        $pdf .= "4 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n";
        $pdf .= "5 0 obj\n<< /Length ".$length." >>\nstream\n".$stream."endstream\nendobj\n";
        $pdf .= "xref\n0 6\n0000000000 65535 f \n0000000009 00000 n \n0000000058 00000 n \n0000000115 00000 n \n0000000224 00000 n \n0000000301 00000 n \n";
        $pdf .= "trailer\n<< /Size 6 /Root 1 0 R >>\nstartxref\n".(350 + $length)."\n%%EOF\n";

        return $pdf;
    }

    /**
     * Generate standard official RTF/DOCX document.
     */
    private function generateRtfContent(string $title): string
    {
        $cleanTitle = e($title);

        return "{\\rtf1\\ansi\\deff0\n".
            "{\\fonttbl{\\f0\\fswiss Arial;}}\n".
            "\\qc\\b\\fs26 PEMERINTAH KABUPATEN BLITAR\\par\n".
            "\\b\\fs28 DINAS SOSIAL\\par\n".
            "\\b0\\fs18 Jl. Raya Barat No. 1, Kanigoro, Kab. Blitar, Jawa Timur 66171\\par\n".
            "\\line\\line\\par\n".
            '\\b\\fs24 '.strtoupper($cleanTitle)."\\b0\\par\\line\\par\n".
            "\\ql\\fs20 Yang bertanda tangan di bawah ini:\\par\n".
            "Nama Lengkap          : ..........................................................................\\par\n".
            "NIK (KTP)             : ..........................................................................\\par\n".
            "No. Kartu Keluarga    : ..........................................................................\\par\n".
            "Alamat Domisili       : RT ...... / RW ...... Desa/Kel. ..........................................\\par\n".
            "Kecamatan             : .................................................... Kab. Blitar\\par\n".
            "No. Telepon / HP      : ..........................................................................\\par\\line\\par\n".
            "Dengan ini menyatakan dengan sebenarnya bahwa data dan berkas yang saya lampirkan adalah sah dan benar.\\par\\line\\par\n".
            "\\qr Blitar, ................................... 2026\\par\n".
            "\\qr Pemohon / Yang Membuat Pernyataan\\par\\line\\line\\line\n".
            "\\qr ( ........................................................ )\\par\n".
            '}';
    }
}
