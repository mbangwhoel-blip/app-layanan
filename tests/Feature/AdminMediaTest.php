<?php

namespace Tests\Feature;

use App\Enums\ComplaintAttachmentType;
use App\Enums\ComplaintStatus;
use App\Models\Complaint;
use App\Models\ComplaintAttachment;
use App\Models\ComplaintCategory;
use App\Models\District;
use App\Models\User;
use App\Models\Village;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminMediaTest extends TestCase
{
    public function test_guest_cannot_access_admin_media(): void
    {
        $attachment = ComplaintAttachment::first();
        if (! $attachment) {
            $this->markTestSkipped('No complaint attachment available.');
        }

        $this->get(route('admin.media.complaints.view', $attachment->id))
            ->assertRedirect(route('filament.admin.auth.login'));

        $this->get(route('admin.media.complaints.download', $attachment->id))
            ->assertRedirect(route('filament.admin.auth.login'));
    }

    public function test_admin_can_view_and_download_complaint_attachment(): void
    {
        $admin = User::first() ?? User::factory()->create();

        // Ensure dummy file exists in storage/app/private/complaints
        Storage::disk('local')->put('complaints/test_proof.jpg', 'fake-image-content');

        $category = ComplaintCategory::firstOrCreate(['name' => 'Bansos']);
        $district = District::firstOrCreate(['code' => 'KEC01'], ['name' => 'Kecamatan']);
        $village = Village::firstOrCreate(['code' => 'DESA01'], ['district_id' => $district->id, 'name' => 'Desa']);

        $complaint = Complaint::create([
            'complaint_number' => 'ADU-MEDIA-TEST-'.bin2hex(random_bytes(3)),
            'complaint_category_id' => $category->id,
            'reporter_name' => 'Pelapor Media Test',
            'reporter_phone' => '08123456789',
            'village_id' => $village->id,
            'description' => 'Testing admin media access.',
            'status' => ComplaintStatus::Received,
        ]);

        $attachment = ComplaintAttachment::create([
            'complaint_id' => $complaint->id,
            'file_path' => 'complaints/test_proof.jpg',
            'type' => ComplaintAttachmentType::Photo,
            'original_name' => 'bukti_lapangan.jpg',
        ]);

        // Test View
        $responseView = $this->actingAs($admin)
            ->get(route('admin.media.complaints.view', $attachment->id));

        $responseView->assertStatus(200);
        $this->assertStringContainsString('inline', $responseView->headers->get('Content-Disposition') ?? '');

        // Test Download
        $responseDownload = $this->actingAs($admin)
            ->get(route('admin.media.complaints.download', $attachment->id));

        $responseDownload->assertStatus(200);
        $this->assertStringContainsString('attachment', $responseDownload->headers->get('Content-Disposition') ?? '');
    }
}
