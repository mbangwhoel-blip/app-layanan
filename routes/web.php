<?php

use App\Http\Controllers\AdminMediaController;
use App\Http\Controllers\FormDownloadController;
use App\Livewire\ApplyDtsen;
use App\Livewire\ApplyGeneral;
use App\Livewire\ApplyPbi;
use App\Livewire\CreateComplaint;
use App\Livewire\FaqIndex;
use App\Livewire\FormDownloadIndex;
use App\Livewire\Home;
use App\Livewire\ServiceDetail;
use App\Livewire\ServiceList;
use App\Livewire\TicketSuccess;
use App\Livewire\TrackTicket;
use App\Livewire\VerifyCertificate;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — Portal Publik SAPA SOSIAL Kab. Blitar
|--------------------------------------------------------------------------
| Dibangun menggunakan Livewire v4 full-page components.
*/

// Named login redirect for authentication guards
Route::redirect('/login', '/admin/login')->name('login');

// Beranda Utama
Route::get('/', Home::class)->name('home');

// Informasi & Direktori Layanan
Route::get('/layanan', ServiceList::class)->name('services.index');

// Layanan Prioritas 1: Surat Keterangan DTSEN
Route::get('/layanan/dtsen', ServiceDetail::class)->defaults('slug', 'dtsen')->name('services.dtsen');
Route::get('/layanan/dtsen/ajukan', ApplyDtsen::class)->name('services.dtsen.apply');

// Layanan Prioritas 2: Reaktivasi KIS / PBI-JK
Route::get('/layanan/pbi-jk', ServiceDetail::class)->defaults('slug', 'pbi-jk')->name('services.pbi');
Route::get('/layanan/pbi-jk/ajukan', ApplyPbi::class)->name('services.pbi.apply');

// Layanan Prioritas 3: Pelayanan Rehabilitasi Sosial
Route::get('/layanan/rehabilitasi-sosial', ServiceDetail::class)->defaults('slug', 'rehabilitasi-sosial')->name('services.rehsos');
Route::get('/layanan/rehabilitasi-sosial/ajukan', ApplyGeneral::class)->name('services.rehsos.apply');

// Layanan Sosial Lainnya (Umum)
Route::get('/layanan/pengajuan/umum', ApplyGeneral::class)->name('services.general.apply');

// Detail Layanan Berdasarkan Slug
Route::get('/layanan/{slug}', ServiceDetail::class)->name('services.detail');

// Layanan 5: Pengaduan Sosial
Route::get('/pengaduan', CreateComplaint::class)->name('complaints.create');

// Pelacakan Tiket Layanan & Pengaduan
Route::get('/cek-status/{ticket?}', TrackTicket::class)->name('ticket.track');

// Halaman Sukses Terbit Tiket
Route::get('/tiket/{ticketNumber}/sukses', TicketSuccess::class)->name('ticket.success');

// Verifikasi Keaslian Surat (via QR atau Kode)
Route::get('/verifikasi/{code?}', VerifyCertificate::class)->name('certificate.verify');

// FAQ & Unduh Formulir
Route::get('/faq', FaqIndex::class)->name('faq.index');
Route::get('/formulir', FormDownloadIndex::class)->name('formulir.index');
Route::get('/formulir/unduh/{key}', [FormDownloadController::class, 'quickDownload'])->name('formulir.quick-download');
Route::get('/formulir/{form}/download', [FormDownloadController::class, 'download'])->name('formulir.download');

// Admin Media Viewing & Downloading (Private documents protected by auth)
Route::middleware(['auth'])->prefix('admin/media')->group(function () {
    Route::get('/complaints/{attachment}/view', [AdminMediaController::class, 'viewComplaintAttachment'])->name('admin.media.complaints.view');
    Route::get('/complaints/{attachment}/download', [AdminMediaController::class, 'downloadComplaintAttachment'])->name('admin.media.complaints.download');
    Route::get('/services/{document}/view', [AdminMediaController::class, 'viewServiceDocument'])->name('admin.media.services.view');
    Route::get('/services/{document}/download', [AdminMediaController::class, 'downloadServiceDocument'])->name('admin.media.services.download');
});
