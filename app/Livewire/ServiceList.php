<?php

namespace App\Livewire;

use App\Models\InformationPage;
use App\Models\ServiceType;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Title('Informasi Layanan Sosial — SAPA SOSIAL Kab. Blitar')]
class ServiceList extends Component
{
    #[Url]
    public string $search = '';

    #[Url]
    public string $category = 'semua';

    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    public function render(): View
    {
        $servicesQuery = ServiceType::query()->where('is_active', true);
        $infoPagesQuery = InformationPage::query()->where('publish_status', 'published');

        if (filled(trim($this->search))) {
            $keyword = '%'.trim($this->search).'%';
            $servicesQuery->where(function ($q) use ($keyword) {
                $q->where('name', 'ilike', $keyword)
                    ->orWhere('description', 'ilike', $keyword);
            });

            $infoPagesQuery->where(function ($q) use ($keyword) {
                $q->where('title', 'ilike', $keyword)
                    ->orWhere('description', 'ilike', $keyword)
                    ->orWhere('requirements', 'ilike', $keyword);
            });
        }

        if ($this->category !== 'semua') {
            if ($this->category === 'dtsen') {
                $servicesQuery->where('code', 'DTSEN');
                $infoPagesQuery->where(function ($q) {
                    $q->where('slug', 'like', '%dtsen%')->orWhere('category', 'program');
                });
            } elseif ($this->category === 'pbi') {
                $servicesQuery->where('code', 'PBI');
                $infoPagesQuery->where(function ($q) {
                    $q->where('slug', 'like', '%pbi%')->orWhere('slug', 'like', '%kis%');
                });
            } elseif ($this->category === 'rehabilitasi') {
                $servicesQuery->where('code', 'REHSOS_REQ');
                $infoPagesQuery->where('category', 'rehabilitation');
            } elseif ($this->category === 'disabilitas') {
                $infoPagesQuery->where('category', 'disability');
                $servicesQuery->whereRaw('1=0');
            } elseif ($this->category === 'lansia') {
                $infoPagesQuery->where('category', 'elderly');
                $servicesQuery->whereRaw('1=0');
            } elseif ($this->category === 'pengaduan') {
                $infoPagesQuery->where('category', 'complaint');
                $servicesQuery->whereRaw('1=0');
            }
        }

        $services = $servicesQuery->get();
        $infoPages = $infoPagesQuery->get();

        return view('livewire.service-list', [
            'services' => $services,
            'infoPages' => $infoPages,
        ]);
    }
}
