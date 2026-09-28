<?php

namespace App\Livewire;

use App\Enums\ComplaintAttachmentType;
use App\Enums\ComplaintStatus;
use App\Models\Complaint;
use App\Models\ComplaintAttachment;
use App\Models\ComplaintCategory;
use App\Models\District;
use App\Models\StatusHistory;
use App\Models\Village;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Pengaduan Sosial — SAPA SOSIAL Kab. Blitar')]
class CreateComplaint extends Component
{
    use WithFileUploads;

    public ?int $complaint_category_id = null;

    public ?int $district_id = null;

    public ?int $village_id = null;

    public string $location_detail = '';

    public string $description = '';

    public string $reporter_name = '';

    public string $reporter_phone = '';

    /**
     * @var array<int, mixed>
     */
    public array $attachments = [];

    public bool $consent = false;

    public function mount(): void
    {
        $firstCat = ComplaintCategory::query()->where('is_active', true)->first();
        if ($firstCat) {
            $this->complaint_category_id = $firstCat->id;
        }
    }

    public function updatedDistrictId(): void
    {
        $this->village_id = null;
    }

    public function submit(): mixed
    {
        $this->validate([
            'complaint_category_id' => 'required|exists:complaint_categories,id',
            'district_id' => 'required|exists:districts,id',
            'village_id' => 'required|exists:villages,id',
            'location_detail' => 'required|string|min:5|max:255',
            'description' => 'required|string|min:15|max:2000',
            'reporter_name' => 'required|string|min:3|max:100',
            'reporter_phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|max:20',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,mp4|max:5120',
            'consent' => 'accepted',
        ], [
            'complaint_category_id.required' => 'Pilih kategori permasalahan sosial.',
            'district_id.required' => 'Pilih kecamatan lokasi kejadian.',
            'village_id.required' => 'Pilih desa/kelurahan lokasi kejadian.',
            'location_detail.required' => 'Jelaskan lokasi detail atau patokan tempat kejadian.',
            'description.required' => 'Jelaskan uraian permasalahan sosial minimal 15 karakter.',
            'reporter_name.required' => 'Nama pelapor wajib diisi.',
            'reporter_phone.required' => 'Nomor WhatsApp / HP pelapor wajib diisi.',
            'attachments.*.max' => 'Ukuran setiap lampiran maksimal 5 MB.',
            'consent.accepted' => 'Anda harus menyetujui pernyataan kebenaran laporan.',
        ]);

        $complaintNumber = DB::transaction(function () {
            $complaint = Complaint::create([
                'complaint_category_id' => $this->complaint_category_id,
                'reporter_name' => trim($this->reporter_name),
                'reporter_phone' => trim($this->reporter_phone),
                'location_detail' => trim($this->location_detail),
                'village_id' => $this->village_id,
                'description' => trim($this->description),
                'status' => ComplaintStatus::Received,
                'reported_at' => now(),
            ]);

            // Save attachments
            if (! empty($this->attachments)) {
                foreach ($this->attachments as $file) {
                    if ($file) {
                        $ext = strtolower($file->getClientOriginalExtension());
                        $type = in_array($ext, ['jpg', 'jpeg', 'png'])
                            ? ComplaintAttachmentType::Photo
                            : ComplaintAttachmentType::Document;

                        $path = $file->store('complaints', 'local');

                        ComplaintAttachment::create([
                            'complaint_id' => $complaint->id,
                            'file_path' => $path,
                            'type' => $type,
                            'original_name' => $file->getClientOriginalName(),
                        ]);
                    }
                }
            }

            // Status history
            StatusHistory::create([
                'statusable_type' => Complaint::class,
                'statusable_id' => $complaint->id,
                'from_status' => null,
                'to_status' => ComplaintStatus::Received->value,
                'notes' => 'Laporan pengaduan sosial berhasil dikirim oleh pelapor.',
                'created_at' => now(),
            ]);

            return $complaint->complaint_number;
        });

        session()->flash('ticket_number', $complaintNumber);

        return redirect()->route('ticket.success', ['ticketNumber' => $complaintNumber]);
    }

    public function render(): View
    {
        $categories = ComplaintCategory::query()->where('is_active', true)->get();
        $districts = District::query()->orderBy('name')->get();
        $villages = $this->district_id
            ? Village::query()->where('district_id', $this->district_id)->orderBy('name')->get()
            : collect();

        return view('livewire.create-complaint', [
            'categories' => $categories,
            'districts' => $districts,
            'villages' => $villages,
        ]);
    }
}
