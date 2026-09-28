<?php

namespace App\Http\Controllers;

use App\Models\ComplaintAttachment;
use App\Models\ServiceRequestDocument;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AdminMediaController extends Controller
{
    /**
     * Resolve the absolute path to a stored file across private and public disks.
     */
    protected function resolveFilePath(?string $relativePath): ?string
    {
        if (empty($relativePath)) {
            return null;
        }

        $cleanPath = ltrim($relativePath, '/\\');

        // Check storage/app/private first
        $privatePath = storage_path('app/private/'.$cleanPath);
        if (file_exists($privatePath) && ! is_dir($privatePath)) {
            return $privatePath;
        }

        // Check storage/app/public
        $publicPath = storage_path('app/public/'.$cleanPath);
        if (file_exists($publicPath) && ! is_dir($publicPath)) {
            return $publicPath;
        }

        // Check storage/app (standard root)
        $appPath = storage_path('app/'.$cleanPath);
        if (file_exists($appPath) && ! is_dir($appPath)) {
            return $appPath;
        }

        return null;
    }

    /**
     * Display a complaint attachment inline (photo or PDF preview).
     */
    public function viewComplaintAttachment(ComplaintAttachment $attachment): BinaryFileResponse
    {
        $filePath = $this->resolveFilePath($attachment->file_path);
        abort_unless($filePath, 404, 'Berkas fisik bukti aduan tidak ditemukan di server.');

        $mime = mime_content_type($filePath) ?: 'application/octet-stream';
        $filename = $attachment->original_name ?: basename($filePath);

        return response()->file($filePath, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="'.addslashes($filename).'"',
        ]);
    }

    /**
     * Download a complaint attachment as an attachment.
     */
    public function downloadComplaintAttachment(ComplaintAttachment $attachment): BinaryFileResponse
    {
        $filePath = $this->resolveFilePath($attachment->file_path);
        abort_unless($filePath, 404, 'Berkas fisik bukti aduan tidak ditemukan di server.');

        $filename = $attachment->original_name ?: basename($filePath);

        return response()->download($filePath, $filename);
    }

    /**
     * Display a service request document inline (KTP, KK, Faskes, etc.).
     */
    public function viewServiceDocument(ServiceRequestDocument $document): BinaryFileResponse
    {
        $filePath = $this->resolveFilePath($document->file_path);
        abort_unless($filePath, 404, 'Berkas fisik dokumen pemohon tidak ditemukan di server.');

        $mime = mime_content_type($filePath) ?: 'application/octet-stream';
        $filename = $document->original_name ?: basename($filePath);

        return response()->file($filePath, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="'.addslashes($filename).'"',
        ]);
    }

    /**
     * Download a service request document as an attachment.
     */
    public function downloadServiceDocument(ServiceRequestDocument $document): BinaryFileResponse
    {
        $filePath = $this->resolveFilePath($document->file_path);
        abort_unless($filePath, 404, 'Berkas fisik dokumen pemohon tidak ditemukan di server.');

        $filename = $document->original_name ?: basename($filePath);

        return response()->download($filePath, $filename);
    }
}
