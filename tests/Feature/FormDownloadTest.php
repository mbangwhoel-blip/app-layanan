<?php

namespace Tests\Feature;

use App\Models\DownloadableForm;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FormDownloadTest extends TestCase
{
    public function test_can_download_all_forms_by_id(): void
    {
        $forms = DownloadableForm::all();
        $this->assertNotEmpty($forms);

        foreach ($forms as $form) {
            $response = $this->get(route('formulir.download', $form->id));
            $response->assertStatus(200);
            $response->assertHeader('content-disposition');
            $this->assertTrue(Storage::disk('public')->exists($form->file_path));
        }
    }

    public function test_quick_download_routes(): void
    {
        $keys = ['sptjm', 'pengantar-desa', 'surat-tidak-mampu', 'reaktivasi-pbi', 'surat-medis'];

        foreach ($keys as $key) {
            $response = $this->get(route('formulir.quick-download', $key));
            $response->assertStatus(200);
            $response->assertHeader('content-disposition');
        }
    }

    public function test_homepage_contains_blanko_cta(): void
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);
        $response->assertSee('Membutuhkan format surat pernyataan tidak mampu atau format pengantar desa?');
        $response->assertSee('Unduh Formulir &amp; Blanko Resmi', false);
    }
}
