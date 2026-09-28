<?php

namespace App\Livewire;

use App\Enums\DocumentVerificationStatus;
use App\Enums\ServiceRequestStatus;
use App\Models\District;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestDocument;
use App\Models\ServiceType;
use App\Models\StatusHistory;
use App\Models\Village;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Pengajuan Layanan Sosial — SAPA SOSIAL')]
class ApplyGeneral extends Component
{
    use WithFileUploads;

    #[Url]
    public ?int $service_type_id = null;

    public string $applicant_name = '';

    public string $applicant_nik = '';

    public string $family_card_number = '';

    public string $address = '';

    public ?int $district_id = null;

    public ?int $village_id = null;

    public string $phone = '';

    public string $description = '';

    /**
     * @var array<int, mixed>
     */
    public array $documents = [];

    public bool $consent = false;

    public function mount(?int $service = null): void
    {
        if ($service) {
            $this->service_type_id = $service;
        } elseif (! $this->service_type_id) {
            $first = ServiceType::query()
                ->where('is_active', true)
                ->whereNotIn('code', ['DTSEN', 'PBI'])
                ->first();
            $this->service_type_id = $first?->id;
        }
    }

    public function updatedDistrictId(): void
    {
        $this->village_id = null;
    }

    public function submit(): mixed
    {
        $this->validate([
            'service_type_id' => 'required|exists:service_types,id',
            'applicant_name' => 'required|string|min:3|max:150',
            'applicant_nik' => 'required|digits:16',
            'family_card_number' => 'required|digits:16',
            'address' => 'required|string|min:5|max:255',
            'district_id' => 'required|exists:districts,id',
            'village_id' => 'required|exists:villages,id',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|max:20',
            'description' => 'required|string|min:10|max:1000',
            'consent' => 'accepted',
        ], [
            'service_type_id.required' => 'Pilih jenis layanan sosial.',
            'applicant_name.required' => 'Nama lengkap pemohon wajib diisi.',
            'applicant_nik.required' => 'NIK pemohon wajib 16 digit angka.',
            'family_card_number.required' => 'Nomor KK pemohon wajib 16 digit angka.',
            'address.required' => 'Alamat lengkap wajib diisi.',
            'district_id.required' => 'Pilih kecamatan domisili.',
            'village_id.required' => 'Pilih desa/kelurahan domisili.',
            'phone.required' => 'Nomor WhatsApp / HP wajib diisi.',
            'description.required' => 'Jelaskan permohonan atau kebutuhan Anda secara ringkas.',
            'consent.accepted' => 'Anda harus menyetujui pernyataan kebenaran data.',
        ]);

        $serviceType = ServiceType::with('serviceRequirements')->findOrFail($this->service_type_id);

        // Validate mandatory documents
        foreach ($serviceType->serviceRequirements as $req) {
            if ($req->is_mandatory && empty($this->documents[$req->id])) {
                $this->addError('documents.'.$req->id, 'Dokumen "'.$req->name.'" wajib diunggah.');

                return null;
            }
        }

        $ticketNumber = DB::transaction(function () use ($serviceType) {
            $request = ServiceRequest::create([
                'service_type_id' => $serviceType->id,
                'applicant_name' => trim($this->applicant_name),
                'applicant_nik' => trim($this->applicant_nik),
                'family_card_number' => trim($this->family_card_number),
                'address' => trim($this->address),
                'village_id' => $this->village_id,
                'phone' => trim($this->phone),
                'officer_notes' => trim($this->description),
                'status' => ServiceRequestStatus::Submitted,
                'submitted_at' => now(),
            ]);

            // Save documents
            foreach ($this->documents as $reqId => $file) {
                if ($file) {
                    $path = $file->store('documents/general', 'local');
                    ServiceRequestDocument::create([
                        'service_request_id' => $request->id,
                        'service_requirement_id' => $reqId,
                        'file_path' => $path,
                        'original_name' => $file->getClientOriginalName(),
                        'verification_status' => DocumentVerificationStatus::Pending,
                    ]);
                }
            }

            // Status history
            StatusHistory::create([
                'statusable_type' => ServiceRequest::class,
                'statusable_id' => $request->id,
                'from_status' => null,
                'to_status' => ServiceRequestStatus::Submitted->value,
                'notes' => 'Pengajuan layanan "'.$serviceType->name.'" berhasil dikirim oleh pemohon.',
                'created_at' => now(),
            ]);

            return $request->request_number;
        });

        session()->flash('ticket_number', $ticketNumber);

        return redirect()->route('ticket.success', ['ticketNumber' => $ticketNumber]);
    }

    public function render(): View
    {
        $services = ServiceType::query()
            ->where('is_active', true)
            ->get();

        $selectedService = $this->service_type_id
            ? ServiceType::with('serviceRequirements')->find($this->service_type_id)
            : null;

        $districts = District::query()->orderBy('name')->get();
        $villages = $this->district_id
            ? Village::query()->where('district_id', $this->district_id)->orderBy('name')->get()
            : collect();

        return view('livewire.apply-general', [
            'services' => $services,
            'selectedService' => $selectedService,
            'districts' => $districts,
            'villages' => $villages,
        ]);
    }
}
