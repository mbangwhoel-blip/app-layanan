<div class="max-w-7xl mx-auto px-4 md:px-8 py-8 md:py-12 space-y-8">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs text-text-secondary">
        <a href="{{ route('home') }}" class="hover:text-primary-container transition-colors" wire:navigate>Beranda</a>
        <span class="text-text-muted">/</span>
        <span class="text-primary-container font-semibold">Informasi & Direktori Layanan</span>
    </nav>

    <!-- Page Header & Search -->
    <div class="space-y-4">
        <div class="space-y-1">
            <div class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-primary-container">
                <span class="w-1.5 h-1.5 rounded-full bg-primary-container"></span>
                <span>Direktori Terpadu</span>
            </div>
            <h1 class="text-2xl md:text-4xl font-extrabold text-text-primary tracking-tight">
                Pusat Informasi & Layanan Sosial
            </h1>
            <p class="text-xs md:text-sm text-text-secondary max-w-3xl leading-relaxed">
                Temukan informasi lengkap mengenai persyaratan, alur pelayanan, waktu penyelesaian (SLA), serta formulir pengajuan layanan sosial di lingkungan Pemerintah Kabupaten Blitar.
            </p>
        </div>

        <!-- Search Bar -->
        <div class="bg-white p-2 rounded-2xl border border-border-medium shadow-sm flex items-center gap-2">
            <span class="material-symbols-outlined text-text-muted ml-2">search</span>
            <input wire:model.live.debounce.300ms="search"
                   type="text"
                   placeholder="Cari berdasarkan nama layanan, kata kunci, atau persyaratan (mis. DTSEN, KIS, Disabilitas)..."
                   class="w-full border-0 focus:ring-0 text-text-primary placeholder:text-text-muted text-sm bg-transparent p-1.5">
            @if(filled($search))
                <button wire:click="$set('search', '')" class="text-text-muted hover:text-text-primary p-1">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            @endif
        </div>

        <!-- Category Filter Chips -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 custom-scroll text-xs">
            <button wire:click="setCategory('semua')"
                    type="button"
                    class="px-4 py-2 rounded-full font-semibold shrink-0 transition-colors {{ $category === 'semua' ? 'bg-primary-container text-white shadow-xs' : 'bg-white border border-border-subtle text-text-secondary hover:border-primary-container hover:text-primary-container' }}">
                Semua Layanan
            </button>
            <button wire:click="setCategory('dtsen')"
                    type="button"
                    class="px-4 py-2 rounded-full font-semibold shrink-0 transition-colors {{ $category === 'dtsen' ? 'bg-primary-container text-white shadow-xs' : 'bg-white border border-border-subtle text-text-secondary hover:border-primary-container hover:text-primary-container' }}">
                Surat DTSEN
            </button>
            <button wire:click="setCategory('pbi')"
                    type="button"
                    class="px-4 py-2 rounded-full font-semibold shrink-0 transition-colors {{ $category === 'pbi' ? 'bg-primary-container text-white shadow-xs' : 'bg-white border border-border-subtle text-text-secondary hover:border-primary-container hover:text-primary-container' }}">
                KIS / PBI-JK
            </button>
            <button wire:click="setCategory('rehabilitasi')"
                    type="button"
                    class="px-4 py-2 rounded-full font-semibold shrink-0 transition-colors {{ $category === 'rehabilitasi' ? 'bg-primary-container text-white shadow-xs' : 'bg-white border border-border-subtle text-text-secondary hover:border-primary-container hover:text-primary-container' }}">
                Rehabilitasi Sosial
            </button>
            <button wire:click="setCategory('disabilitas')"
                    type="button"
                    class="px-4 py-2 rounded-full font-semibold shrink-0 transition-colors {{ $category === 'disabilitas' ? 'bg-primary-container text-white shadow-xs' : 'bg-white border border-border-subtle text-text-secondary hover:border-primary-container hover:text-primary-container' }}">
                Disabilitas
            </button>
            <button wire:click="setCategory('lansia')"
                    type="button"
                    class="px-4 py-2 rounded-full font-semibold shrink-0 transition-colors {{ $category === 'lansia' ? 'bg-primary-container text-white shadow-xs' : 'bg-white border border-border-subtle text-text-secondary hover:border-primary-container hover:text-primary-container' }}">
                Lansia
            </button>
            <button wire:click="setCategory('pengaduan')"
                    type="button"
                    class="px-4 py-2 rounded-full font-semibold shrink-0 transition-colors {{ $category === 'pengaduan' ? 'bg-primary-container text-white shadow-xs' : 'bg-white border border-border-subtle text-text-secondary hover:border-primary-container hover:text-primary-container' }}">
                Pengaduan Sosial
            </button>
        </div>
    </div>

    <!-- Services Grid -->
    <div class="space-y-6">
        @php
            $hasResults = ($services->isNotEmpty() || $infoPages->isNotEmpty());
        @endphp

        @if($hasResults)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Priority Services (from ServiceType) -->
                @foreach ($services as $service)
                    @php
                        $slug = match($service->code) {
                            'DTSEN' => 'dtsen',
                            'PBI' => 'pbi-jk',
                            'REHSOS_REQ' => 'rehabilitasi-sosial',
                            default => \Illuminate\Support\Str::slug($service->name),
                        };
                        $applyRoute = match($service->code) {
                            'DTSEN' => route('services.dtsen.apply'),
                            'PBI' => route('services.pbi.apply'),
                            'REHSOS_REQ' => route('services.rehsos.apply'),
                            default => route('services.general.apply', ['service' => $service->id]),
                        };
                    @endphp
                    <div class="bg-white rounded-2xl border border-border-subtle p-6 hover:shadow-md transition-all flex flex-col justify-between group">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="w-12 h-12 rounded-xl bg-brand-teal-light text-primary-container flex items-center justify-center font-bold">
                                    <span class="material-symbols-outlined text-2xl">
                                        {{ $service->code === 'DTSEN' ? 'assignment' : ($service->code === 'PBI' ? 'health_and_safety' : 'volunteer_activism') }}
                                    </span>
                                </div>
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-teal-50 text-teal-800 border border-teal-200">
                                    {{ $service->category ?? 'Layanan Utama' }}
                                </span>
                            </div>

                            <div>
                                <h3 class="font-bold text-base text-text-primary group-hover:text-primary-container transition-colors">
                                    {{ $service->name }}
                                </h3>
                                <p class="text-xs text-text-secondary mt-1.5 line-clamp-3 leading-relaxed">
                                    {{ $service->description }}
                                </p>
                            </div>

                            @if($service->sla_days)
                                <div class="flex items-center gap-1.5 text-xs text-text-muted pt-2 border-t border-border-subtle">
                                    <span class="material-symbols-outlined text-sm">timer</span>
                                    <span>Estimasi proses: {{ $service->sla_days }} hari kerja</span>
                                </div>
                            @endif
                        </div>

                        <div class="pt-6 flex items-center gap-2">
                            <a href="{{ $applyRoute }}" wire:navigate
                               class="flex-1 py-2 px-3 rounded-xl bg-primary-container hover:bg-brand-teal-dark text-white font-semibold text-xs text-center transition-colors">
                                Ajukan Layanan
                            </a>
                            <a href="{{ route('services.detail', ['slug' => $slug]) }}" wire:navigate
                               class="py-2 px-3 rounded-xl border border-border-medium hover:bg-surface-subtle text-text-primary font-semibold text-xs text-center transition-colors">
                                Info Detail
                            </a>
                        </div>
                    </div>
                @endforeach

                <!-- Information Pages (from InformationPage) -->
                @foreach ($infoPages as $info)
                    <div class="bg-white rounded-2xl border border-border-subtle p-6 hover:shadow-md transition-all flex flex-col justify-between group">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center font-bold">
                                    <span class="material-symbols-outlined text-2xl">info</span>
                                </div>
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-50 text-blue-800 border border-blue-200 uppercase">
                                    {{ $info->category }}
                                </span>
                            </div>

                            <div>
                                <h3 class="font-bold text-base text-text-primary group-hover:text-primary-container transition-colors">
                                    {{ $info->title }}
                                </h3>
                                <p class="text-xs text-text-secondary mt-1.5 line-clamp-3 leading-relaxed">
                                    {{ $info->description }}
                                </p>
                            </div>

                            @if($info->service_hours)
                                <div class="flex items-center gap-1.5 text-xs text-text-muted pt-2 border-t border-border-subtle">
                                    <span class="material-symbols-outlined text-sm">schedule</span>
                                    <span>{{ $info->service_hours }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="pt-6">
                            <a href="{{ route('services.detail', ['slug' => $info->slug]) }}" wire:navigate
                               class="w-full block py-2 px-4 rounded-xl border border-border-medium hover:bg-surface-subtle text-primary-container font-semibold text-xs text-center transition-colors">
                                Baca Panduan Lengkap & Syarat
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-2xl border border-border-subtle p-12 text-center max-w-xl mx-auto space-y-4 shadow-xs">
                <div class="w-16 h-16 rounded-full bg-surface-subtle text-text-muted flex items-center justify-center mx-auto">
                    <span class="material-symbols-outlined text-3xl">search_off</span>
                </div>
                <h3 class="text-lg font-bold text-text-primary">
                    Informasi Tidak Ditemukan
                </h3>
                <p class="text-xs text-text-secondary leading-relaxed">
                    Kami tidak menemukan layanan atau informasi yang sesuai dengan kata kunci "<span class="font-semibold text-text-primary">{{ $search }}</span>". Coba gunakan kata kunci lain atau pilih kategori di atas.
                </p>
                <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3">
                    <button wire:click="$set('search', '')" class="w-full sm:w-auto px-4 py-2 rounded-xl bg-surface-subtle text-text-primary text-xs font-semibold hover:bg-border-subtle transition-colors">
                        Reset Pencarian
                    </button>
                    <a href="{{ route('complaints.create') }}" wire:navigate class="w-full sm:w-auto px-4 py-2 rounded-xl bg-primary-container text-white text-xs font-semibold hover:bg-brand-teal-dark transition-colors">
                        Sampaikan Pengaduan
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Quick Help Banner -->
    <div class="bg-gradient-to-r from-teal-50 to-white rounded-2xl border border-teal-200 p-6 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-4 text-center sm:text-left">
            <div class="w-12 h-12 rounded-xl bg-brand-teal-light text-primary-container flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-2xl">help</span>
            </div>
            <div>
                <h4 class="font-bold text-sm text-text-primary">Tidak Menemukan Layanan yang Dicari?</h4>
                <p class="text-xs text-text-secondary">Anda dapat mengajukan permohonan umum atau berkonsultasi langsung dengan petugas kami via WhatsApp.</p>
            </div>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <a href="https://wa.me/6281234567890" target="_blank"
               class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center gap-1.5 transition-colors">
                <span class="material-symbols-outlined text-base">chat</span>
                <span>Chat Petugas</span>
            </a>
            <a href="{{ route('services.general.apply') }}" wire:navigate
               class="px-4 py-2.5 rounded-xl bg-white border border-border-medium hover:bg-surface-subtle text-primary-container font-semibold text-xs transition-colors">
                Pengajuan Umum
            </a>
        </div>
    </div>
</div>
