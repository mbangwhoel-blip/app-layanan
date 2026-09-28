<div class="max-w-7xl mx-auto px-4 md:px-8 py-8 md:py-12 space-y-8">
    @php
        $serviceCode = $serviceType?->code ?? ($slug === 'dtsen' ? 'DTSEN' : ($slug === 'pbi-jk' ? 'PBI' : 'GENERIC'));
        $applyRoute = match($serviceCode) {
            'DTSEN' => route('services.dtsen.apply'),
            'PBI' => route('services.pbi.apply'),
            'REHSOS_REQ' => route('services.rehsos.apply'),
            default => route('services.general.apply', ['service' => $serviceType?->id]),
        };
    @endphp

    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-xs text-text-secondary">
        <a href="{{ route('home') }}" class="hover:text-primary-container transition-colors" wire:navigate>Beranda</a>
        <span class="text-text-muted">/</span>
        <a href="{{ route('services.index') }}" class="hover:text-primary-container transition-colors" wire:navigate>Layanan Sosial</a>
        <span class="text-text-muted">/</span>
        <span class="text-primary-container font-semibold truncate">{{ $title }}</span>
    </nav>

    <!-- Main Grid: Content + Sidebar -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content (Left 2 cols) -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Hero Card -->
            <div class="bg-white rounded-3xl border border-border-subtle p-6 md:p-8 space-y-6 shadow-xs relative overflow-hidden">
                <div class="flex items-start justify-between gap-4">
                    <div class="w-14 h-14 rounded-2xl {{ $serviceType?->icon_box_classes ?? ($infoPage?->icon_box_classes ?? 'bg-brand-teal-light text-primary-container') }} flex items-center justify-center shrink-0 shadow-2xs">
                        <span class="material-symbols-outlined text-3xl">
                            {{ $serviceType?->icon ?? ($infoPage?->icon ?? 'assignment') }}
                        </span>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $serviceType?->category_badge_classes ?? ($infoPage?->category_badge_classes ?? 'bg-teal-50 text-teal-800 border-teal-200') }}">
                        {{ $serviceType?->category ?? ($infoPage?->category_label ?? 'Layanan Publik') }}
                    </span>
                </div>

                <div class="space-y-2">
                    <h1 class="text-2xl md:text-3xl font-extrabold text-text-primary tracking-tight">
                        {{ $title }}
                    </h1>
                    <p class="text-xs md:text-sm text-text-secondary leading-relaxed">
                        {{ $serviceType?->description ?? $infoPage?->description }}
                    </p>
                </div>

                <!-- Highlight badges -->
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 pt-2 text-xs">
                    <div class="p-3 rounded-xl bg-surface-canvas border border-border-subtle">
                        <span class="text-text-muted block text-[11px]">Waktu Penyelesaian</span>
                        <span class="font-bold text-text-primary">
                            {{ $serviceType?->sla_days ? $serviceType->sla_days . ' Hari Kerja' : ($infoPage?->service_hours ?? '1-3 Hari Kerja') }}
                        </span>
                    </div>
                    <div class="p-3 rounded-xl bg-surface-canvas border border-border-subtle">
                        <span class="text-text-muted block text-[11px]">Biaya Pelayanan</span>
                        <span class="font-bold text-status-success">GRATIS (Rp 0)</span>
                    </div>
                    <div class="p-3 rounded-xl bg-surface-canvas border border-border-subtle col-span-2 sm:col-span-1">
                        <span class="text-text-muted block text-[11px]">Format Output</span>
                        <span class="font-bold text-text-primary">Surat Resmi + QR</span>
                    </div>
                </div>

                <!-- CTA Button -->
                <div class="pt-2">
                    <a href="{{ $applyRoute }}" wire:navigate
                       class="w-full sm:w-auto px-8 py-3.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-900 font-bold text-sm inline-flex items-center justify-center gap-2 shadow-sm transition-all focus:ring-4 focus:ring-amber-500/20">
                        <span class="material-symbols-outlined text-xl">add_circle</span>
                        <span>Ajukan Permohonan Sekarang</span>
                    </a>
                </div>
            </div>

            <!-- Section 1: Persyaratan Berkas -->
            <div class="bg-white rounded-3xl border border-border-subtle p-6 md:p-8 space-y-5 shadow-xs">
                <div class="flex items-center gap-2 text-primary-container">
                    <span class="material-symbols-outlined text-2xl">checklist</span>
                    <h2 class="text-lg font-bold text-text-primary">Persyaratan Dokumen</h2>
                </div>

                @if($serviceType && $serviceType->serviceRequirements->isNotEmpty())
                    <ul class="space-y-3 text-xs md:text-sm">
                        @foreach ($serviceType->serviceRequirements as $req)
                            <li class="flex items-start gap-3 p-3.5 rounded-xl bg-surface-canvas border border-border-subtle">
                                <span class="material-symbols-outlined text-status-success text-xl shrink-0 mt-0.5">check_circle</span>
                                <div class="space-y-0.5">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-text-primary">{{ $req->name }}</span>
                                        @if($req->is_mandatory)
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-100 text-rose-700">Wajib</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600">Opsional</span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-text-secondary">
                                        Format file yang diterima: {{ strtoupper($req->allowed_mimes ?? 'PDF, JPG, PNG') }} (maks. 2 MB)
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @elseif($infoPage && $infoPage->requirements)
                    <div class="p-4 rounded-2xl bg-surface-canvas border border-border-subtle text-xs md:text-sm leading-relaxed text-text-secondary whitespace-pre-line">
                        {!! nl2br(e($infoPage->requirements)) !!}
                    </div>
                @else
                    <ul class="space-y-3 text-xs md:text-sm">
                        <li class="flex items-start gap-3 p-3.5 rounded-xl bg-surface-canvas border border-border-subtle">
                            <span class="material-symbols-outlined text-status-success text-xl shrink-0 mt-0.5">check_circle</span>
                            <div>
                                <span class="font-bold text-text-primary">Kartu Tanda Penduduk (KTP) Asli / Foto</span>
                                <p class="text-xs text-text-secondary">KTP pemohon yang masih berlaku (atau Surat Keterangan Kependudukan).</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3 p-3.5 rounded-xl bg-surface-canvas border border-border-subtle">
                            <span class="material-symbols-outlined text-status-success text-xl shrink-0 mt-0.5">check_circle</span>
                            <div>
                                <span class="font-bold text-text-primary">Kartu Keluarga (KK)</span>
                                <p class="text-xs text-text-secondary">KK domisili Kabupaten Blitar yang memuat nama pemohon atau orang yang diterangkan.</p>
                            </div>
                        </li>
                    </ul>
                @endif
            </div>

            <!-- Section 2: Alur Pelayanan (Timeline) -->
            <div class="bg-white rounded-3xl border border-border-subtle p-6 md:p-8 space-y-6 shadow-xs">
                <div class="flex items-center gap-2 text-primary-container">
                    <span class="material-symbols-outlined text-2xl">route</span>
                    <h2 class="text-lg font-bold text-text-primary">Tahapan & Alur Pelayanan</h2>
                </div>

                <div class="relative border-l-2 border-teal-200 ml-4 pl-6 space-y-6 text-xs md:text-sm">
                    @if($serviceCode === 'DTSEN')
                        <div class="relative">
                            <span class="absolute -left-[31px] top-0 w-6 h-6 rounded-full bg-brand-teal-light border-2 border-primary-container text-primary-container font-bold text-xs flex items-center justify-center">1</span>
                            <h4 class="font-bold text-text-primary">Pengajuan Online & Pilih Tujuan</h4>
                            <p class="text-xs text-text-secondary mt-1">Pemohon mengisi formulir online dan memilih tujuan penggunaan (SPMB afirmasi, PIP, KIP Kuliah, bansos, atau kesehatan).</p>
                        </div>
                        <div class="relative">
                            <span class="absolute -left-[31px] top-0 w-6 h-6 rounded-full bg-brand-teal-light border-2 border-primary-container text-primary-container font-bold text-xs flex items-center justify-center">2</span>
                            <h4 class="font-bold text-text-primary">Penerbitan Nomor Tiket</h4>
                            <p class="text-xs text-text-secondary mt-1">Sistem menerbitkan nomor tiket unik (mis. DTSEN-202610-00012) untuk memantau proses berkas secara transparan.</p>
                        </div>
                        <div class="relative">
                            <span class="absolute -left-[31px] top-0 w-6 h-6 rounded-full bg-brand-teal-light border-2 border-primary-container text-primary-container font-bold text-xs flex items-center justify-center">3</span>
                            <h4 class="font-bold text-text-primary">Pemeriksaan Berkas & Verifikasi SIKS-NG</h4>
                            <p class="text-xs text-text-secondary mt-1">Petugas Dinsos memeriksa kelengkapan KTP & KK, lalu mengecek status data pemohon di aplikasi SIKS-NG (terdaftar dan nilai desil).</p>
                        </div>
                        <div class="relative">
                            <span class="absolute -left-[31px] top-0 w-6 h-6 rounded-full bg-brand-teal-light border-2 border-primary-container text-primary-container font-bold text-xs flex items-center justify-center">4</span>
                            <h4 class="font-bold text-text-primary">Persetujuan Berjenjang (Paraf & Tanda Tangan)</h4>
                            <p class="text-xs text-text-secondary mt-1">Draf surat diteliti oleh Kepala Bidang dan disetujui/ditandatangani oleh Kepala Dinas Sosial Kabupaten Blitar.</p>
                        </div>
                        <div class="relative">
                            <span class="absolute -left-[31px] top-0 w-6 h-6 rounded-full bg-brand-teal-light border-2 border-primary-container text-primary-container font-bold text-xs flex items-center justify-center">5</span>
                            <h4 class="font-bold text-text-primary">Penerbitan Surat dengan QR Code</h4>
                            <p class="text-xs text-text-secondary mt-1">Surat diterbitkan otomatis dalam format PDF resmi bertanda QR Code verifikasi. Pemohon dapat mengunduhnya langsung.</p>
                        </div>
                    @elseif($serviceCode === 'PBI')
                        <div class="relative">
                            <span class="absolute -left-[31px] top-0 w-6 h-6 rounded-full bg-brand-teal-light border-2 border-primary-container text-primary-container font-bold text-xs flex items-center justify-center">1</span>
                            <h4 class="font-bold text-text-primary">Pengajuan Data Peserta & Unggah Dokumen</h4>
                            <p class="text-xs text-text-secondary mt-1">Mengisi nomor kartu BPJS/KIS, alasan reaktivasi, serta mengunggah KTP, KK, kartu BPJS, dan surat keterangan faskes bila alasan medis.</p>
                        </div>
                        <div class="relative">
                            <span class="absolute -left-[31px] top-0 w-6 h-6 rounded-full bg-brand-teal-light border-2 border-primary-container text-primary-container font-bold text-xs flex items-center justify-center">2</span>
                            <h4 class="font-bold text-text-primary">Verifikasi Kelayakan</h4>
                            <p class="text-xs text-text-secondary mt-1">Petugas memeriksa kriteria desil dan status kepesertaan. Kasus darurat medis langsung diprioritaskan.</p>
                        </div>
                        <div class="relative">
                            <span class="absolute -left-[31px] top-0 w-6 h-6 rounded-full bg-brand-teal-light border-2 border-primary-container text-primary-container font-bold text-xs flex items-center justify-center">3</span>
                            <h4 class="font-bold text-text-primary">Penerbitan Rekomendasi & Input SIKS-NG</h4>
                            <p class="text-xs text-text-secondary mt-1">Surat rekomendasi disetujui pejabat, kemudian diinput petugas ke sistem SIKS-NG Kemensos RI.</p>
                        </div>
                        <div class="relative">
                            <span class="absolute -left-[31px] top-0 w-6 h-6 rounded-full bg-brand-teal-light border-2 border-primary-container text-primary-container font-bold text-xs flex items-center justify-center">4</span>
                            <h4 class="font-bold text-text-primary">Keputusan Kemensos & Reaktivasi BPJS</h4>
                            <p class="text-xs text-text-secondary mt-1">Dinas memantau persetujuan Kemensos hingga status kepesertaan aktif kembali di BPJS Kesehatan.</p>
                        </div>
                    @else
                        <div class="relative">
                            <span class="absolute -left-[31px] top-0 w-6 h-6 rounded-full bg-brand-teal-light border-2 border-primary-container text-primary-container font-bold text-xs flex items-center justify-center">1</span>
                            <h4 class="font-bold text-text-primary">Pengajuan & Penerimaan Kasus</h4>
                            <p class="text-xs text-text-secondary mt-1">Laporan diterima dan dicatat ke dalam sistem dengan nomor tiket resmi.</p>
                        </div>
                        <div class="relative">
                            <span class="absolute -left-[31px] top-0 w-6 h-6 rounded-full bg-brand-teal-light border-2 border-primary-container text-primary-container font-bold text-xs flex items-center justify-center">2</span>
                            <h4 class="font-bold text-text-primary">Assessment Lapangan & Rencana Pelayanan</h4>
                            <p class="text-xs text-text-secondary mt-1">Petugas melakukan asesmen kebutuhan spesifik dan merumuskan rencana tindakan atau rujukan.</p>
                        </div>
                        <div class="relative">
                            <span class="absolute -left-[31px] top-0 w-6 h-6 rounded-full bg-brand-teal-light border-2 border-primary-container text-primary-container font-bold text-xs flex items-center justify-center">3</span>
                            <h4 class="font-bold text-text-primary">Pelaksanaan Pelayanan & Monitoring</h4>
                            <p class="text-xs text-text-secondary mt-1">Pemberian bantuan langsung, bimbingan, atau rujukan ke panti/balai rehabilitasi hingga selesai.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Section 3: FAQ Terkait (Jika ada) -->
            @if($infoPage && $infoPage->faqs->isNotEmpty())
                <div class="bg-white rounded-3xl border border-border-subtle p-6 md:p-8 space-y-4 shadow-xs" x-data="{ active: null }">
                    <div class="flex items-center gap-2 text-primary-container">
                        <span class="material-symbols-outlined text-2xl">help</span>
                        <h2 class="text-lg font-bold text-text-primary">Pertanyaan Seputar Layanan Ini</h2>
                    </div>

                    <div class="space-y-3 pt-2">
                        @foreach ($infoPage->faqs as $idx => $faq)
                            <div class="rounded-xl border border-border-subtle overflow-hidden">
                                <button @click="active = active === {{ $idx }} ? null : {{ $idx }}"
                                        class="w-full px-4 py-3 text-left flex items-center justify-between gap-4 font-bold text-xs md:text-sm text-text-primary hover:text-primary-container transition-colors">
                                    <span>{{ $faq->question }}</span>
                                    <span class="material-symbols-outlined text-text-muted transition-transform"
                                          :class="{ 'rotate-180': active === {{ $idx }} }">expand_more</span>
                                </button>
                                <div x-show="active === {{ $idx }}" x-collapse
                                     class="px-4 pb-3 text-xs text-text-secondary leading-relaxed border-t border-border-subtle pt-2"
                                     style="display: none;">
                                    {!! nl2br(e($faq->answer)) !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Section 4: Format Blanko & Dokumen Unduhan Resmi -->
            @if($infoPage && $infoPage->downloadableForms && $infoPage->downloadableForms->isNotEmpty())
                <div class="bg-white rounded-3xl border border-border-subtle p-6 md:p-8 space-y-4 shadow-xs">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2 text-primary-container">
                            <span class="material-symbols-outlined text-2xl">download</span>
                            <h2 class="text-lg font-bold text-text-primary">Format Dokumen &amp; Blanko Resmi</h2>
                        </div>
                        <p class="text-xs text-text-secondary">
                            Unduh formulir atau surat pernyataan yang diperlukan sebagai lampiran pengajuan layanan ini.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                        @foreach($infoPage->downloadableForms as $f)
                            <div class="p-4 rounded-xl bg-surface-canvas border border-border-subtle flex items-start justify-between gap-3">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-brand-teal-light text-primary-container flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-2xl">description</span>
                                    </div>
                                    <div>
                                        <p class="font-bold text-xs text-text-primary">{{ $f->name }}</p>
                                        <p class="text-[11px] text-text-secondary">Dokumen Resmi Dinsos Kab. Blitar</p>
                                        <span class="inline-block mt-1 text-[10px] font-semibold text-text-muted">Versi {{ $f->version ?? 'Terbaru' }}</span>
                                    </div>
                                </div>
                                <a href="{{ route('formulir.download', $f->id) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-white hover:bg-surface-subtle text-primary-container border border-border-medium text-xs font-semibold transition-colors shrink-0">
                                    <span class="material-symbols-outlined text-base">download</span>
                                    <span>Unduh</span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Right Sidebar (1 col) -->
        <div class="space-y-6">
            <!-- Sidebar Card 1: Fast Action -->
            <div class="bg-white rounded-3xl border border-border-subtle p-6 space-y-4 shadow-xs">
                <h3 class="font-bold text-sm text-text-primary">Mulai Pengajuan</h3>
                <p class="text-xs text-text-secondary leading-relaxed">
                    Pastikan Anda telah menyiapkan foto/scan KTP dan Kartu Keluarga sebelum melanjutkan pengisian formulir.
                </p>
                <a href="{{ $applyRoute }}" wire:navigate
                   class="w-full py-3 px-4 rounded-xl bg-primary-container hover:bg-brand-teal-dark text-white font-bold text-xs text-center block transition-colors shadow-xs">
                    Isi Formulir Online
                </a>
            </div>

            <!-- Sidebar Card 2: Lacak Status -->
            <div class="bg-white rounded-3xl border border-border-subtle p-6 space-y-4 shadow-xs">
                <div class="flex items-center gap-2 text-primary-container">
                    <span class="material-symbols-outlined text-xl">travel_explore</span>
                    <h3 class="font-bold text-sm text-text-primary">Sudah Punya Tiket?</h3>
                </div>
                <p class="text-xs text-text-secondary leading-relaxed">
                    Cek perkembangan berkas Anda kapan saja secara real-time melalui halaman pelacakan status.
                </p>
                <a href="{{ route('ticket.track') }}" wire:navigate
                   class="w-full py-2.5 px-4 rounded-xl bg-surface-subtle hover:bg-brand-teal-light text-primary-container font-semibold text-xs text-center block transition-colors">
                    Lacak Status Tiket
                </a>
            </div>

            <!-- Sidebar Card 3: Kontak & Jam Layanan -->
            <div class="bg-surface-canvas rounded-3xl border border-border-subtle p-6 space-y-4">
                <h3 class="font-bold text-sm text-text-primary">Butuh Informasi Tambahan?</h3>
                <div class="space-y-2.5 text-xs text-text-secondary">
                    <div class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-sm text-primary-container mt-0.5">location_on</span>
                        <span>Dinas Sosial Kabupaten Blitar, Kanigoro, Jawa Timur</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm text-primary-container">schedule</span>
                        <span>Senin - Jumat, 08:00 - 15:30 WIB</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm text-primary-container">chat</span>
                        <a href="https://wa.me/6281234567890" target="_blank" class="hover:underline text-primary-container font-semibold">
                            WhatsApp: 0812-3456-7890
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
