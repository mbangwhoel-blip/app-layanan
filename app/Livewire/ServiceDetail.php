<?php

namespace App\Livewire;

use App\Models\InformationPage;
use App\Models\ServiceType;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

class ServiceDetail extends Component
{
    public string $slug;

    public function mount(string $slug): void
    {
        $this->slug = $slug;
    }

    public function render(): View
    {
        // Try to match ServiceType first
        $serviceType = null;
        if (in_array($this->slug, ['dtsen', 'surat-keterangan-dtsen'])) {
            $serviceType = ServiceType::with('serviceRequirements')->where('code', 'DTSEN')->first();
        } elseif (in_array($this->slug, ['pbi', 'pbi-jk', 'reaktivasi-kis-pbi-jk'])) {
            $serviceType = ServiceType::with('serviceRequirements')->where('code', 'PBI')->first();
        } elseif (in_array($this->slug, ['rehsos', 'rehabilitasi-sosial', 'pelayanan-rehabilitasi-sosial'])) {
            $serviceType = ServiceType::with('serviceRequirements')->where('code', 'REHSOS_REQ')->first();
        } else {
            $serviceType = ServiceType::with('serviceRequirements')->where('code', strtoupper($this->slug))->first();
        }

        // Also check InformationPage
        $infoPage = InformationPage::with(['faqs', 'downloadableForms'])
            ->where('slug', $this->slug)
            ->first();

        if (! $infoPage && $serviceType) {
            $infoPage = InformationPage::with(['faqs', 'downloadableForms'])
                ->where('service_type_id', $serviceType->id)
                ->first();
        }

        // Determine title
        $title = $serviceType?->name ?? $infoPage?->title ?? 'Detail Layanan Sosial';

        return view('livewire.service-detail', [
            'serviceType' => $serviceType,
            'infoPage' => $infoPage,
            'title' => $title,
        ])->title($title.' — SAPA SOSIAL Kab. Blitar');
    }
}
