<?php

namespace App\Livewire;

use App\Models\Faq;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Pertanyaan yang Sering Diajukan (FAQ) — SAPA SOSIAL')]
class FaqIndex extends Component
{
    public string $search = '';

    public string $category = 'semua';

    public function render(): View
    {
        $query = Faq::query()->where('is_active', true)->orderBy('sort_order');

        if (filled(trim($this->search))) {
            $keyword = '%'.trim($this->search).'%';
            $query->where(function ($q) use ($keyword) {
                $q->where('question', 'ilike', $keyword)
                    ->orWhere('answer', 'ilike', $keyword);
            });
        }

        $faqs = $query->get();

        return view('livewire.faq-index', [
            'faqs' => $faqs,
        ]);
    }
}
