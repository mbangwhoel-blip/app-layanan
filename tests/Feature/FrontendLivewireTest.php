<?php

namespace Tests\Feature;

use App\Livewire\ApplyDtsen;
use App\Livewire\FaqIndex;
use App\Livewire\Home;
use App\Livewire\ServiceList;
use App\Livewire\TrackTicket;
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
}
