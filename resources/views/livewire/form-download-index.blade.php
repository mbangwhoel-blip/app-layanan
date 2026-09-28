<div class="max-w-4xl mx-auto px-4 md:px-8 py-8 md:py-12 space-y-8">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs text-text-secondary">
        <a href="{{ route('home') }}" class="hover:text-primary-container transition-colors" wire:navigate>Beranda</a>
        <span class="text-text-muted">/</span>
        <span class="text-primary-container font-semibold">Unduh Formulir</span>
    </nav>

    <!-- Header & Search -->
    <div class="space-y-4">
        <div class="space-y-1">
            <div class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-primary-container">
                <span class="material-symbols-outlined text-base">download_for_offline</span>
                <span>Dokumen Pelayanan</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-text-primary tracking-tight">
                Unduh Formulir & Format Dokumen Resmi
            </h1>
            <p class="text-xs md:text-sm text-text-secondary leading-relaxed">
                Unduh template surat pernyataan, format surat permohonan, dan formulir pendaftaran layanan Dinas Sosial Kabupaten Blitar yang sah dan berlaku.
            </p>
        </div>

        <div class="bg-white p-2 rounded-2xl border border-border-medium shadow-sm flex items-center gap-2">
            <span class="material-symbols-outlined text-text-muted ml-2">search</span>
            <input wire:model.live.debounce.300ms="search"
                   type="text"
                   placeholder="Cari formulir..."
                   class="w-full border-0 focus:ring-0 text-text-primary placeholder:text-text-muted text-sm bg-transparent p-1.5">
            @if(filled($search))
                <button wire:click="$set('search', '')" class="text-text-muted hover:text-text-primary p-1">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            @endif
        </div>
    </div>

    <!-- Forms List -->
    <div class="space-y-3">
        @forelse ($forms as $form)
            <div class="bg-white rounded-2xl border border-border-subtle p-5 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-brand-teal-light text-primary-container flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-2xl">description</span>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-sm text-text-primary">{{ $form->name }}</h3>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">Versi {{ $form->version ?? 'Terbaru' }}</span>
                        </div>
                        <span class="text-xs text-text-muted block mt-0.5">Dokumen Resmi Dinas Sosial Kabupaten Blitar</span>
                    </div>
                </div>

                <a href="{{ $form->file_path ? asset('storage/'.$form->file_path) : '#' }}"
                   target="_blank"
                   class="px-5 py-2.5 rounded-xl bg-primary-container hover:bg-brand-teal-dark text-white font-semibold text-xs flex items-center justify-center gap-1.5 transition-colors shrink-0">
                    <span class="material-symbols-outlined text-base">download</span>
                    <span>Unduh Dokumen</span>
                </a>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-border-subtle p-8 text-center text-xs text-text-muted">
                Tidak ada formulir yang sesuai dengan pencarian.
            </div>
        @endforelse
    </div>
</div>
