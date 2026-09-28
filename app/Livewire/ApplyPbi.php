<?php

namespace App\Livewire;

use App\Enums\DocumentVerificationStatus;
use App\Enums\PbiReactivationReason;
use App\Enums\ServiceRequestStatus;
use App\Models\District;
use App\Models\PbiReactivation;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestDocument;
use App\Models\ServiceRequirement;
use App\Models\ServiceType;
use App\Models\StatusHistory;
use App\Models\Village;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Pengajuan Reaktivasi KIS / PBI-JK — SAPA SOSIAL')]
class ApplyPbi extends Component
{
    use WithFileUploads;

    public int $currentStep = 1;

    // Step 1: Data Peserta
    public string $participant_name = '';

    public string $participant_nik = '';

    public string $family_card_number = '';

    public string $bpjs_card_number = '';

    public ?string $deactivated_date = null;

    public string $address = '';

    public ?int $district_id = null;

    public ?int $village_id = null;

    public string $phone = '';

    // Step 2: Alasan Reaktivasi
    public string $reason = 'chronic';

    public ?string $health_facility_name = null;

    public ?string $health_letter_number = null;

    // Step 3: Unggah Berkas
    public $ktp_file = null;

    public $kk_file = null;

    public $bpjs_file = null;

    public $faskes_file = null;

    // Step 4: Persetujuan
    public bool $consent = false;

    public function updatedDistrictId(): void
    {
        $this->village_id = null;
    }

    public function isMedicalReason(): bool
    {
        return in_array($this->reason, ['chronic', 'catastrophic', 'emergency']);
    }

    public function nextStep(): void
    {
        if ($this->currentStep === 1) {
            $this->validate([
                'participant_name' => 'required|string|min:3|max:150',
                'participant_nik' => 'required|digits:16',
                'family_card_number' => 'required|digits:16',
                'bpjs_card_number' => 'required|string|min:8|max:30',
                'deactivated_date' => 'nullable|date',
                'district_id' => 'required|exists:districts,id',
                'village_id' => 'required|exists:villages,id',
                'address' => 'required|string|min:5|max:255',
                'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|max:20',
            ], [
                'participant_name.required' => 'Nama lengkap peserta wajib diisi.',
                'participant_nik.required' => 'NIK peserta wajib diisi 16 digit.',
                'participant_nik.digits' => 'NIK harus berupa 16 angka.',
                'family_card_number.required' => 'Nomor KK wajib diisi 16 digit.',
                'family_card_number.digits' => 'Nomor KK harus berupa 16 angka.',
                'bpjs_card_number.required' => 'Nomor kartu BPJS/KIS wajib diisi.',
                'district_id.required' => 'Pilih kecamatan domisili.',
                'village_id.required' => 'Pilih desa/kelurahan domisili.',
                'address.required' => 'Alamat lengkap wajib diisi.',
                'phone.required' => 'Nomor WhatsApp / HP wajib diisi.',
            ]);
            $this->currentStep = 2;
        } elseif ($this->currentStep === 2) {
            $rules = [
                'reason' => 'required|string|in:chronic,catastrophic,emergency,newborn,other',
            ];

            if ($this->isMedicalReason()) {
                $rules['health_facility_name'] = 'required|string|max:150';
                $rules['health_letter_number'] = 'nullable|string|max:100';
            }

            $this->validate($rules, [
                'reason.required' => 'Pilih salah satu alasan reaktivasi.',
                'health_facility_name.required' => 'Nama fasilitas kesehatan wajib diisi untuk alasan medis.',
            ]);
            $this->currentStep = 3;
        } elseif ($this->currentStep === 3) {
            $rules = [
                'ktp_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'kk_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'bpjs_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            ];

            if ($this->isMedicalReason()) {
                $rules['faskes_file'] = 'required|file|mimes:jpg,jpeg,png,pdf|max:2048';
            } else {
                $rules['faskes_file'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048';
            }

            $this->validate($rules, [
                'ktp_file.required' => 'Dokumen KTP peserta wajib diunggah.',
                'kk_file.required' => 'Dokumen Kartu Keluarga wajib diunggah.',
                'bpjs_file.required' => 'Foto Kartu BPJS/KIS wajib diunggah.',
                'faskes_file.required' => 'Surat keterangan fasilitas kesehatan wajib diunggah untuk alasan medis.',
            ]);
            $this->currentStep = 4;
        }
    }

    public function prevStep(): void
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function goToStep(int $step): void
    {
        if ($step < $this->currentStep) {
            $this->currentStep = $step;
        }
    }

    public function submit(): mixed
    {
        $this->validate([
            'consent' => 'accepted',
        ], [
            'consent.accepted' => 'Anda harus menyetujui pernyataan kebenaran data.',
        ]);

        $serviceType = ServiceType::where('code', 'PBI')->firstOrFail();
        $isEmergency = ($this->reason === 'emergency');

        $ticketNumber = DB::transaction(function () use ($serviceType, $isEmergency) {
            // Create Service Request
            $request = ServiceRequest::create([
                'service_type_id' => $serviceType->id,
                'applicant_name' => trim($this->participant_name),
                'applicant_nik' => trim($this->participant_nik),
                'family_card_number' => trim($this->family_card_number),
                'address' => trim($this->address),
                'village_id' => $this->village_id,
                'phone' => trim($this->phone),
                'status' => ServiceRequestStatus::Submitted,
                'is_priority' => $isEmergency,
                'submitted_at' => now(),
            ]);

            // Create PBI Reactivation record
            PbiReactivation::create([
                'service_request_id' => $request->id,
                'participant_name' => trim($this->participant_name),
                'participant_nik' => trim($this->participant_nik),
                'bpjs_card_number' => trim($this->bpjs_card_number),
                'deactivated_date' => $this->deactivated_date,
                'reason' => $this->reason,
                'health_facility_name' => $this->health_facility_name,
                'health_letter_number' => $this->health_letter_number,
            ]);

            // Save documents
            $docsToStore = [
                ['file' => $this->ktp_file, 'name' => 'KTP'],
                ['file' => $this->kk_file, 'name' => 'KK'],
                ['file' => $this->bpjs_file, 'name' => 'Kartu BPJS/KIS'],
            ];

            if ($this->faskes_file) {
                $docsToStore[] = ['file' => $this->faskes_file, 'name' => 'Surat Keterangan Faskes'];
            }

            foreach ($docsToStore as $doc) {
                if ($doc['file']) {
                    $path = $doc['file']->store('documents/pbi', 'local');
                    $req = ServiceRequirement::where('service_type_id', $serviceType->id)
                        ->where('name', 'ilike', '%'.$doc['name'].'%')
                        ->first();

                    ServiceRequestDocument::create([
                        'service_request_id' => $request->id,
                        'service_requirement_id' => $req?->id,
                        'file_path' => $path,
                        'original_name' => $doc['file']->getClientOriginalName(),
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
                'notes' => $isEmergency
                    ? 'Pengajuan reaktivasi PBI-JK diterima (Kategori Prioritas Darurat Medis).'
                    : 'Pengajuan reaktivasi PBI-JK diterima secara online.',
                'created_at' => now(),
            ]);

            return $request->request_number;
        });

        session()->flash('ticket_number', $ticketNumber);

        return redirect()->route('ticket.success', ['ticketNumber' => $ticketNumber]);
    }

    public function render(): View
    {
        $districts = District::query()->orderBy('name')->get();
        $villages = $this->district_id
            ? Village::query()->where('district_id', $this->district_id)->orderBy('name')->get()
            : collect();

        $selectedDistrict = $this->district_id ? District::find($this->district_id) : null;
        $selectedVillage = $this->village_id ? Village::find($this->village_id) : null;
        $reasons = PbiReactivationReason::cases();

        return view('livewire.apply-pbi', [
            'districts' => $districts,
            'villages' => $villages,
            'selectedDistrict' => $selectedDistrict,
            'selectedVillage' => $selectedVillage,
            'reasons' => $reasons,
        ]);
    }
}
