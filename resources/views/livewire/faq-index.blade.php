<div class="max-w-4xl mx-auto px-4 md:px-8 py-8 md:py-12 space-y-8">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs text-text-secondary">
        <a href="{{ route('home') }}" class="hover:text-primary-container transition-colors" wire:navigate>Beranda</a>
        <span class="text-text-muted">/</span>
        <span class="text-primary-container font-semibold">Tanya Jawab (FAQ)</span>
    </nav>

    <!-- Header & Search -->
    <div class="space-y-4">
        <div class="space-y-1">
            <div class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-primary-container">
                <span class="material-symbols-outlined text-base">help</span>
                <span>Pusat Bantuan</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-text-primary tracking-tight">
                Pertanyaan yang Sering Diajukan
            </h1>
            <p class="text-xs md:text-sm text-text-secondary leading-relaxed">
                Jawaban seputar pengajuan Surat Keterangan DTSEN, Reaktivasi JKN-KIS PBI, perlindungan rehabilitasi sosial, dan tata cara pelacakan tiket.
            </p>
        </div>

        <div class="bg-white p-2 rounded-2xl border border-border-medium shadow-sm flex items-center gap-2">
            <span class="material-symbols-outlined text-text-muted ml-2">search</span>
            <input wire:model.live.debounce.300ms="search"
                   type="text"
                   placeholder="Cari pertanyaan atau kata kunci bantuan..."
                   class="w-full border-0 focus:ring-0 text-text-primary placeholder:text-text-muted text-sm bg-transparent p-1.5">
            @if(filled($search))
                <button wire:click="$set('search', '')" class="text-text-muted hover:text-text-primary p-1">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            @endif
        </div>
    </div>

    <!-- FAQ Accordion List -->
    <div class="space-y-3" x-data="{ active: null }">
        @forelse ($faqs as $index => $faq)
            <div class="bg-white rounded-2xl border border-border-subtle overflow-hidden shadow-xs">
                <button @click="active = active === {{ $index }} ? null : {{ $index }}"
                        type="button"
                        class="w-full px-6 py-4 text-left flex items-center justify-between gap-4 font-bold text-sm text-text-primary hover:text-primary-container transition-colors">
                    <span>{{ $faq->question }}</span>
                    <span class="material-symbols-outlined text-text-muted transition-transform shrink-0"
                          :class="{ 'rotate-180': active === {{ $index }} }">expand_more</span>
                </button>
                <div x-show="active === {{ $index }}"
                     x-collapse
                     class="px-6 pb-5 text-xs md:text-sm text-text-secondary leading-relaxed border-t border-border-subtle pt-3"
                     style="display: none;">
                    {!! nl2br(e($faq->answer)) !!}
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-border-subtle p-8 text-center text-xs text-text-muted">
                Tidak ada pertanyaan yang sesuai dengan kata kunci pencarian.
            </div>
        @endforelse
    </div>

    <!-- Contact Banner -->
    <div class="bg-gradient-to-r from-teal-50 to-white rounded-3xl border border-teal-200 p-6 md:p-8 flex flex-col sm:flex-row items-center justify-between gap-6">
        <div class="space-y-1 text-center sm:text-left">
            <h3 class="font-bold text-base text-text-primary">Belum Menemukan Jawaban?</h3>
            <p class="text-xs text-text-secondary">Petugas pelayanan Dinas Sosial Kabupaten Blitar siap membantu Anda melalui layanan konsultasi WhatsApp.</p>
        </div>
        <a href="https://wa.me/6281234567890" target="_blank"
           class="px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center gap-2 transition-colors shadow-xs shrink-0">
            <span class="material-symbols-outlined text-lg">chat</span>
            <span>Hubungi WhatsApp Pelayanan</span>
        </a>
    </div>
</div>
