<?php

namespace Tests\Feature;

use Tests\TestCase;

class FrontendRoutesTest extends TestCase
{
    public function test_home_page_renders_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('SAPA SOSIAL');
        $response->assertSee('Satu Pintu Layanan Sosial Kabupaten Blitar');
    }

    public function test_service_list_page_renders_successfully(): void
    {
        $response = $this->get('/layanan');
        $response->assertSee('Direktori Terpadu');
        $response->assertSee('Pusat Informasi');
    }

    public function test_dtsen_detail_page_renders_successfully(): void
    {
        $response = $this->get('/layanan/dtsen');
        $response->assertStatus(200);
        $response->assertSee('Surat Keterangan DTSEN');
    }

    public function test_dtsen_apply_page_renders_successfully(): void
    {
        $response = $this->get('/layanan/dtsen/ajukan');
        $response->assertStatus(200);
        $response->assertSee('Formulir Pengajuan — Surat Keterangan DTSEN');
    }

    public function test_pbi_detail_page_renders_successfully(): void
    {
        $response = $this->get('/layanan/pbi-jk');
        $response->assertStatus(200);
        $response->assertSee('Reaktivasi KIS');
    }

    public function test_pbi_apply_page_renders_successfully(): void
    {
        $response = $this->get('/layanan/pbi-jk/ajukan');
        $response->assertStatus(200);
        $response->assertSee('Pengajuan Reaktivasi KIS / PBI-JK');
    }

    public function test_complaint_page_renders_successfully(): void
    {
        $response = $this->get('/pengaduan');
        $response->assertStatus(200);
        $response->assertSee('Laporan Masalah Sosial');
    }

    public function test_ticket_track_page_renders_successfully(): void
    {
        $response = $this->get('/cek-status');
        $response->assertStatus(200);
        $response->assertSee('Lacak Status Tiket');
    }

    public function test_certificate_verify_page_renders_successfully(): void
    {
        $response = $this->get('/verifikasi');
        $response->assertStatus(200);
        $response->assertSee('Verifikasi Keaslian Surat Keterangan DTSEN');
    }

    public function test_faq_page_renders_successfully(): void
    {
        $response = $this->get('/faq');
        $response->assertStatus(200);
        $response->assertSee('Pertanyaan yang Sering Diajukan');
    }

    public function test_rehsos_detail_page_renders_successfully(): void
    {
        $response = $this->get('/layanan/rehabilitasi-sosial');
        $response->assertStatus(200);
        $response->assertSee('Rehabilitasi Sosial');
    }

    public function test_general_apply_page_renders_successfully(): void
    {
        $response = $this->get('/layanan/pengajuan/umum');
        $response->assertStatus(200);
        $response->assertSee('Formulir Pengajuan Layanan Sosial');
    }

    public function test_ticket_success_page_renders_successfully(): void
    {
        $response = $this->get('/tiket/DTSEN-2026-12345/sukses');
        $response->assertStatus(200);
        $response->assertSee('Pengajuan Berhasil Dikirim');
        $response->assertSee('DTSEN-2026-12345');
    }

    public function test_download_forms_page_renders_successfully(): void
    {
        $response = $this->get('/formulir');
        $response->assertStatus(200);
        $response->assertSee('Unduh Formulir');
    }
}
