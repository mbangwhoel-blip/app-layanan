<?php

namespace Tests\Feature;

use App\Enums\ComplaintStatus;
use App\Livewire\ApplyDtsen;
use App\Livewire\FaqIndex;
use App\Livewire\Home;
use App\Livewire\ServiceList;
use App\Livewire\TrackTicket;
use App\Models\Complaint;
use App\Models\ComplaintCategory;
use App\Models\District;
use App\Models\Village;
use Livewire\Livewire;
use Tests\TestCase;

class FrontendLivewireTest extends TestCase
{
    public function test_home_component_renders(): void
    {
        Livewire::test(Home::class)
            ->assertStatus(200)
            ->assertSee('SAPA SOSIAL');
    }

    public function test_service_list_search_filters_results(): void
    {
        Livewire::test(ServiceList::class)
            ->set('search', 'DTSEN')
            ->assertStatus(200)
            ->assertSee('DTSEN');
    }

    public function test_faq_search_filters(): void
    {
        Livewire::test(FaqIndex::class)
            ->set('search', 'DTSEN')
            ->assertStatus(200)
            ->assertSee('DTSEN');
    }

    public function test_track_ticket_not_found(): void
    {
        Livewire::test(TrackTicket::class)
            ->set('ticketNumber', 'SRV-NOTFOUND-999')
            ->call('search')
            ->assertStatus(200)
            ->assertSee('Tiket Tidak Ditemukan');
    }

    public function test_apply_dtsen_step1_validation(): void
    {
        Livewire::test(ApplyDtsen::class)
            ->set('dtsen_purpose_id', null)
            ->call('nextStep')
            ->assertHasErrors(['dtsen_purpose_id']);
    }

    public function test_ticket_success_with_complaint(): void
    {
        $category = ComplaintCategory::firstOrCreate(['name' => 'Bansos Kesejahteraan']);
        $district = District::firstOrCreate(['code' => 'TEST01'], ['name' => 'Kecamatan Test']);
        $village = Village::firstOrCreate(['code' => 'TEST0101'], ['district_id' => $district->id, 'name' => 'Desa Test']);

        $ticketNo = strtoupper('ADU-TEST-'.bin2hex(random_bytes(4)));
        $complaint = Complaint::create([
            'complaint_number' => $ticketNo,
            'complaint_category_id' => $category->id,
            'reporter_name' => 'Budi Santoso',
            'reporter_phone' => '081234567890',
            'village_id' => $village->id,
            'description' => 'Laporan uji coba pengaduan sosial.',
            'status' => ComplaintStatus::Received,
        ]);

        $this->get(route('ticket.success', ['ticketNumber' => $complaint->complaint_number]))
            ->assertStatus(200)
            ->assertSee($complaint->complaint_number)
            ->assertSee('Bansos Kesejahteraan');

        Livewire::test(TrackTicket::class)
            ->set('ticketNumber', $complaint->complaint_number)
            ->call('search')
            ->assertStatus(200)
            ->assertSee($complaint->complaint_number)
            ->assertSee('Bansos Kesejahteraan');
    }
}
