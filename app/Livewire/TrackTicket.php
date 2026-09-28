<?php

namespace App\Livewire;

use App\Enums\DocumentVerificationStatus;
use App\Enums\ServiceRequestStatus;
use App\Models\Complaint;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestDocument;
use App\Models\StatusHistory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Lacak Status Tiket — SAPA SOSIAL')]
class TrackTicket extends Component
{
    use WithFileUploads;

    #[Url(as: 'ticket')]
    public string $ticketNumber = '';

    #[Url(as: 'nik')]
    public string $nikLastDigits = '';

    public bool $hasSearched = false;

    public $revisionFile = null;

    public string $revisionNotes = '';

    public function mount(?string $ticket = null, ?string $nik = null): void
    {
        if ($ticket) {
            $this->ticketNumber = strtoupper(trim($ticket));
        }
        if ($nik) {
            $this->nikLastDigits = trim($nik);
        }

        if (filled($this->ticketNumber)) {
            $this->hasSearched = true;
        }
    }

    public function search(): void
    {
        $this->validate([
            'ticketNumber' => 'required|string|min:4',
            'nikLastDigits' => 'nullable|string|digits:4',
        ], [
            'ticketNumber.required' => 'Nomor tiket wajib diisi.',
            'ticketNumber.min' => 'Format nomor tiket tidak valid.',
            'nikLastDigits.digits' => 'Masukkan tepat 4 digit terakhir NIK atau No. HP.',
        ]);

        $this->ticketNumber = strtoupper(trim($this->ticketNumber));
        $this->hasSearched = true;
    }

    public function submitRevision(int $serviceRequestId): void
    {
        $this->validate([
            'revisionFile' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'revisionNotes' => 'nullable|string|max:500',
        ], [
            'revisionFile.required' => 'File perbaikan wajib dipilih.',
            'revisionFile.max' => 'Ukuran file maksimal 2 MB.',
        ]);

        $request = ServiceRequest::findOrFail($serviceRequestId);
        $path = $this->revisionFile->store('documents/revisions', 'local');

        // Add document
        ServiceRequestDocument::create([
            'service_request_id' => $request->id,
            'file_path' => $path,
            'original_name' => $this->revisionFile->getClientOriginalName(),
            'verification_status' => DocumentVerificationStatus::Pending,
            'notes' => 'Berkas perbaikan dari pemohon: '.$this->revisionNotes,
        ]);

        // Change status back to submitted
        $oldStatus = $request->status->value;
        $request->update([
            'status' => ServiceRequestStatus::Submitted,
        ]);

        StatusHistory::create([
            'statusable_type' => ServiceRequest::class,
            'statusable_id' => $request->id,
            'from_status' => $oldStatus,
            'to_status' => ServiceRequestStatus::Submitted->value,
            'notes' => 'Pemohon telah mengunggah perbaikan berkas: '.$this->revisionNotes,
            'created_at' => now(),
        ]);

        $this->revisionFile = null;
        $this->revisionNotes = '';
        session()->flash('success', 'Berkas perbaikan berhasil dikirimkan. Petugas akan segera memeriksa kembali permohonan Anda.');
    }

    public function render(): View
    {
        $serviceRequest = null;
        $complaint = null;

        if ($this->hasSearched && filled($this->ticketNumber)) {
            $serviceRequest = ServiceRequest::with([
                'serviceType',
                'village.district',
                'dtsenCertificate.dtsenPurpose',
                'pbiReactivation',
                'documents.requirement',
                'statusHistories' => fn ($q) => $q->latest(),
            ])
                ->where('request_number', $this->ticketNumber)
                ->first();

            if (! $serviceRequest) {
                $complaint = Complaint::with([
                    'complaintCategory',
                    'village.district',
                    'attachments',
                    'statusHistories' => fn ($q) => $q->latest(),
                ])
                    ->where('complaint_number', $this->ticketNumber)
                    ->first();
            }
        }

        return view('livewire.track-ticket', [
            'serviceRequest' => $serviceRequest,
            'complaint' => $complaint,
        ]);
    }
}
