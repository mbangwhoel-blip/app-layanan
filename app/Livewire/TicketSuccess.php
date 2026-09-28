<?php

namespace App\Livewire;

use App\Models\Complaint;
use App\Models\ServiceRequest;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Pengajuan Berhasil — SAPA SOSIAL')]
class TicketSuccess extends Component
{
    public string $ticketNumber;

    public function mount(string $ticketNumber): void
    {
        $this->ticketNumber = $ticketNumber;
    }

    public function render(): View
    {
        $serviceRequest = ServiceRequest::with(['serviceType', 'village.district'])
            ->where('request_number', $this->ticketNumber)
            ->first();

        $complaint = null;
        if (! $serviceRequest) {
            $complaint = Complaint::with(['complaintCategory', 'village.district'])
                ->where('complaint_number', $this->ticketNumber)
                ->first();
        }

        return view('livewire.ticket-success', [
            'serviceRequest' => $serviceRequest,
            'complaint' => $complaint,
            'ticketNumber' => $this->ticketNumber,
        ]);
    }
}
