<?php

namespace App\Livewire;

use App\Models\DownloadableForm;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Unduh Formulir Pelayanan — SAPA SOSIAL')]
class FormDownloadIndex extends Component
{
    public string $search = '';

    public function render(): View
    {
        $query = DownloadableForm::query()->where('is_current', true);

        if (filled(trim($this->search))) {
            $keyword = '%'.trim($this->search).'%';
            $query->where('name', 'ilike', $keyword);
        }

        $forms = $query->get();

        return view('livewire.form-download-index', [
            'forms' => $forms,
        ]);
    }
}
