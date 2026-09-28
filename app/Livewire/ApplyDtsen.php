<?php

namespace App\Livewire;

use App\Enums\DocumentVerificationStatus;
use App\Enums\ServiceRequestStatus;
use App\Models\District;
use App\Models\DtsenCertificate;
use App\Models\DtsenPurpose;
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

#[Title('Pengajuan Surat Keterangan DTSEN — SAPA SOSIAL')]
class ApplyDtsen extends Component
{
    use WithFileUploads;

    public int $currentStep = 1;

    // Step 1: Tujuan Penggunaan
    public ?int $dtsen_purpose_id = null;

    public ?string $purpose_description = null;

    // Step 2: Data Pemohon
    public string $applicant_name = '';

    public string $applicant_nik = '';

    public string $family_card_number = '';

    public string $address = '';

    public ?int $district_id = null;

    public ?int $village_id = null;

    public string $phone = '';

    // Step 3: Orang yang Diterangkan & Berkas
    public string $subject_type = 'diri_sendiri';

    public string $subject_name = '';

    public string $subject_nik = '';

    public string $relationship_to_applicant = 'Diri Sendiri';

    public $ktp_file = null;

    public $kk_file = null;

    // Step 4: Persetujuan
    public bool $consent = false;

    public function mount(): void
    {
        // Select first active purpose by default
        $firstPurpose = DtsenPurpose::query()->where('is_active', true)->first();
        if ($firstPurpose) {
            $this->dtsen_purpose_id = $firstPurpose->id;
        }
    }

    public function updatedDistrictId(): void
    {
        $this->village_id = null;
    }

    public function updatedSubjectType(string $val): void
    {
        if ($val === 'diri_sendiri') {
            $this->subject_name = $this->applicant_name;
            $this->subject_nik = $this->applicant_nik;
            $this->relationship_to_applicant = 'Diri Sendiri';
        } elseif ($val === 'keluarga_kk') {
            $this->relationship_to_applicant = 'Anak Kandung';
            if ($this->subject_name === $this->applicant_name) {
                $this->subject_name = '';
                $this->subject_nik = '';
            }
        } else {
            $this->relationship_to_applicant = 'Kuasa / Lainnya';
        }
    }

    public function nextStep(): void
    {
        if ($this->currentStep === 1) {
            $this->validate([
                'dtsen_purpose_id' => 'required|exists:dtsen_purposes,id',
                'purpose_description' => 'nullable|string|max:500',
            ], [
                'dtsen_purpose_id.required' => 'Pilih salah satu tujuan penggunaan surat.',
            ]);
            $this->currentStep = 2;
        } elseif ($this->currentStep === 2) {
            $this->validate([
                'applicant_name' => 'required|string|min:3|max:150',
                'applicant_nik' => 'required|digits:16',
                'family_card_number' => 'required|digits:16',
                'address' => 'required|string|min:5|max:255',
                'district_id' => 'required|exists:districts,id',
                'village_id' => 'required|exists:villages,id',
                'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|max:20',
            ], [
                'applicant_name.required' => 'Nama lengkap pemohon wajib diisi.',
                'applicant_nik.required' => 'NIK pemohon wajib diisi 16 digit.',
                'applicant_nik.digits' => 'NIK harus tepat 16 angka.',
                'family_card_number.required' => 'Nomor KK wajib diisi 16 digit.',
                'family_card_number.digits' => 'Nomor KK harus tepat 16 angka.',
                'address.required' => 'Alamat domisili wajib diisi.',
                'district_id.required' => 'Pilih kecamatan domisili.',
                'village_id.required' => 'Pilih desa/kelurahan domisili.',
                'phone.required' => 'Nomor WhatsApp / HP aktif wajib diisi.',
            ]);

            // Sync subject if diri_sendiri
            if ($this->subject_type === 'diri_sendiri') {
                $this->subject_name = $this->applicant_name;
                $this->subject_nik = $this->applicant_nik;
                $this->relationship_to_applicant = 'Diri Sendiri';
            }

            $this->currentStep = 3;
        } elseif ($this->currentStep === 3) {
            $this->validate([
                'subject_name' => 'required|string|min:3|max:150',
                'subject_nik' => 'required|digits:16',
                'relationship_to_applicant' => 'required|string|max:50',
                'ktp_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'kk_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            ], [
                'subject_name.required' => 'Nama orang yang diterangkan wajib diisi.',
                'subject_nik.required' => 'NIK orang yang diterangkan wajib diisi.',
                'subject_nik.digits' => 'NIK orang yang diterangkan harus 16 digit angka.',
                'ktp_file.required' => 'Dokumen KTP wajib diunggah.',
                'ktp_file.mimes' => 'Format KTP harus JPG, PNG, atau PDF.',
                'ktp_file.max' => 'Ukuran file KTP maksimal 2 MB.',
                'kk_file.required' => 'Dokumen Kartu Keluarga (KK) wajib diunggah.',
                'kk_file.mimes' => 'Format KK harus JPG, PNG, atau PDF.',
                'kk_file.max' => 'Ukuran file KK maksimal 2 MB.',
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

        $serviceType = ServiceType::where('code', 'DTSEN')->firstOrFail();

        $ticketNumber = DB::transaction(function () use ($serviceType) {
            // Create Service Request
            $request = ServiceRequest::create([
                'service_type_id' => $serviceType->id,
                'applicant_name' => trim($this->applicant_name),
                'applicant_nik' => trim($this->applicant_nik),
                'family_card_number' => trim($this->family_card_number),
                'address' => trim($this->address),
                'village_id' => $this->village_id,
                'phone' => trim($this->phone),
                'status' => ServiceRequestStatus::Submitted,
                'submitted_at' => now(),
            ]);

            // Create DTSEN Certificate record
            DtsenCertificate::create([
                'service_request_id' => $request->id,
                'dtsen_purpose_id' => $this->dtsen_purpose_id,
                'purpose_description' => $this->purpose_description,
                'subject_name' => trim($this->subject_name),
                'subject_nik' => trim($this->subject_nik),
                'relationship_to_applicant' => trim($this->relationship_to_applicant),
                'is_registered' => false,
            ]);

            // Save documents
            $ktpReq = ServiceRequirement::where('service_type_id', $serviceType->id)
                ->where('name', 'ilike', '%ktp%')
                ->first();
            $kkReq = ServiceRequirement::where('service_type_id', $serviceType->id)
                ->where('name', 'ilike', '%kk%')
                ->first();

            $ktpPath = $this->ktp_file->store('documents/ktp', 'local');
            $kkPath = $this->kk_file->store('documents/kk', 'local');

            ServiceRequestDocument::create([
                'service_request_id' => $request->id,
                'service_requirement_id' => $ktpReq?->id,
                'file_path' => $ktpPath,
                'original_name' => $this->ktp_file->getClientOriginalName(),
                'verification_status' => DocumentVerificationStatus::Pending,
            ]);

            ServiceRequestDocument::create([
                'service_request_id' => $request->id,
                'service_requirement_id' => $kkReq?->id,
                'file_path' => $kkPath,
                'original_name' => $this->kk_file->getClientOriginalName(),
                'verification_status' => DocumentVerificationStatus::Pending,
            ]);

            // Status history
            StatusHistory::create([
                'statusable_type' => ServiceRequest::class,
                'statusable_id' => $request->id,
                'from_status' => null,
                'to_status' => ServiceRequestStatus::Submitted->value,
                'notes' => 'Pengajuan berhasil dikirim secara mandiri oleh pemohon.',
                'created_at' => now(),
            ]);

            return $request->request_number;
        });

        session()->flash('ticket_number', $ticketNumber);

        return redirect()->route('ticket.success', ['ticketNumber' => $ticketNumber]);
    }

    public function render(): View
    {
        $purposes = DtsenPurpose::query()->where('is_active', true)->get();
        $districts = District::query()->orderBy('name')->get();
        $villages = $this->district_id
            ? Village::query()->where('district_id', $this->district_id)->orderBy('name')->get()
            : collect();

        $selectedPurpose = $this->dtsen_purpose_id
            ? DtsenPurpose::find($this->dtsen_purpose_id)
            : null;

        $selectedDistrict = $this->district_id ? District::find($this->district_id) : null;
        $selectedVillage = $this->village_id ? Village::find($this->village_id) : null;

        return view('livewire.apply-dtsen', [
            'purposes' => $purposes,
            'districts' => $districts,
            'villages' => $villages,
            'selectedPurpose' => $selectedPurpose,
            'selectedDistrict' => $selectedDistrict,
            'selectedVillage' => $selectedVillage,
        ]);
    }
}
