<?php

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
