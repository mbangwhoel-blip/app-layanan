<?php

namespace App\Livewire;

use App\Models\DownloadableForm;
use App\Models\Faq;
use App\Models\InformationPage;
use App\Models\ServiceType;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('SAPA SOSIAL — Satu Pintu Layanan Sosial Kabupaten Blitar')]
class Home extends Component
{
    public string $search = '';

    public string $quickTicketNumber = '';

    public string $quickNik = '';

    public string $verifyCode = '';

    public function searchServices(): mixed
    {
        if (filled(trim($this->search))) {
            return redirect()->route('services.index', ['search' => trim($this->search)]);
        }

        return redirect()->route('services.index');
    }

    public function quickTrack(): mixed
    {
        $this->validate([
            'quickTicketNumber' => 'required|string|min:5',
            'quickNik' => 'nullable|string|min:4',
        ], [
            'quickTicketNumber.required' => 'Nomor tiket wajib diisi.',
            'quickTicketNumber.min' => 'Format nomor tiket tidak valid.',
        ]);

        return redirect()->route('ticket.track', [
            'ticket' => strtoupper(trim($this->quickTicketNumber)),
            'nik' => trim($this->quickNik),
        ]);
    }

    public function quickVerify(): mixed
    {
        $this->validate([
            'verifyCode' => 'required|string|min:4',
        ], [
            'verifyCode.required' => 'Kode verifikasi wajib diisi.',
        ]);

        return redirect()->route('certificate.verify', [
            'code' => strtoupper(trim($this->verifyCode)),
        ]);
    }

    public function render(): View
    {
        $services = ServiceType::query()
            ->where('is_active', true)
            ->get();

        $infoPages = InformationPage::query()
            ->where('publish_status', 'published')
            ->latest('published_at')
            ->take(6)
            ->get();

        $faqs = Faq::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->take(5)
            ->get();

        $forms = DownloadableForm::query()
            ->where('is_current', true)
            ->take(4)
            ->get();

        return view('livewire.home', [
            'services' => $services,
            'infoPages' => $infoPages,
            'faqs' => $faqs,
            'forms' => $forms,
        ]);
    }
}
