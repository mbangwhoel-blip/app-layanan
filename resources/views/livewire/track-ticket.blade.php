<div class="max-w-4xl mx-auto px-4 md:px-8 py-8 md:py-12 space-y-8">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs text-text-secondary">
        <a href="{{ route('home') }}" class="hover:text-primary-container transition-colors" wire:navigate>Beranda</a>
        <span class="text-text-muted">/</span>
        <span class="text-primary-container font-semibold">Lacak Status Tiket</span>
    </nav>

    <!-- Search Card -->
    <div class="bg-white rounded-3xl border border-border-subtle p-6 md:p-8 shadow-xs space-y-6">
        <div class="space-y-1">
            <div class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-primary-container">
                <span class="material-symbols-outlined text-base">travel_explore</span>
                <span>Pelacakan Online</span>
            </div>
            <h1 class="text-2xl font-extrabold text-text-primary tracking-tight">
                Cek Perkembangan Layanan & Pengaduan
            </h1>
            <p class="text-xs text-text-secondary leading-relaxed">
                Pantau proses verifikasi, disposisi, dan penyelesaian permohonan sosial Anda secara transparan.
            </p>
        </div>

        <form wire:submit="search" class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-end">
            <div class="sm:col-span-2 space-y-1">
                <label class="block text-xs font-bold text-text-primary">
                    Nomor Tiket Resmi <span class="text-status-danger">*</span>
                </label>
                <input wire:model="ticketNumber"
                       type="text"
                       placeholder="Contoh: DTSEN-202610-00012 atau ADU-202610-00004"
                       class="w-full rounded-xl border border-border-medium p-3 text-xs md:text-sm font-mono tracking-wider uppercase focus:border-primary-container focus:ring-1 focus:ring-primary-container">
                @error('ticketNumber')
                    <span class="text-xs text-status-danger block">{{ $message }}</span>
                @enderror
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-text-primary">
                    4 Digit NIK / HP (Opsional)
                </label>
                <input wire:model="nikLastDigits"
                       type="text"
                       maxlength="4"
                       placeholder="4 digit terakhir"
                       class="w-full rounded-xl border border-border-medium p-3 text-xs md:text-sm font-mono focus:border-primary-container focus:ring-1 focus:ring-primary-container">
            </div>

            <div class="sm:col-span-3">
                <button type="submit"
                        wire:loading.attr="disabled"
                        class="w-full sm:w-auto px-8 py-3 rounded-xl bg-primary-container hover:bg-brand-teal-dark text-white font-bold text-xs flex items-center justify-center gap-2 transition-colors shadow-xs">
                    <span wire:loading.remove wire:target="search" class="material-symbols-outlined text-lg">search</span>
                    <span wire:loading wire:target="search" class="material-symbols-outlined animate-spin text-lg">progress_activity</span>
                    <span>Lacak Status Tiket</span>
                </button>
            </div>
        </form>
    </div>

    <!-- TRACKING RESULT -->
    @if ($hasSearched)
        @if ($serviceRequest)
            <!-- Service Request Result -->
            <div class="space-y-6">
                <!-- Top Summary Card -->
                <div class="bg-white rounded-3xl border border-border-subtle p-6 md:p-8 shadow-xs space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-border-subtle pb-6">
                        <div class="space-y-1">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-text-muted">Nomor Tiket</span>
                            <div class="flex items-center gap-2">
                                <h2 class="text-2xl font-extrabold text-primary-container font-mono">{{ $serviceRequest->request_number }}</h2>
                                @if($serviceRequest->is_priority)
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-700 animate-pulse">Prioritas</span>
                                @endif
                            </div>
                        </div>

                        <div>
                            @php
                                $statusEnum = $serviceRequest->status;
                                $badgeClass = match($statusEnum) {
                                    \App\Enums\ServiceRequestStatus::Submitted => 'bg-amber-100 text-amber-800 border-amber-300',
                                    \App\Enums\ServiceRequestStatus::DocumentCheck,
                                    \App\Enums\ServiceRequestStatus::Verification,
                                    \App\Enums\ServiceRequestStatus::EligibilityVerification,
                                    \App\Enums\ServiceRequestStatus::DataVerification => 'bg-blue-100 text-blue-800 border-blue-300',
                                    \App\Enums\ServiceRequestStatus::RevisionRequested => 'bg-amber-100 text-amber-900 border-amber-400 font-bold',
                                    \App\Enums\ServiceRequestStatus::AwaitingApproval => 'bg-purple-100 text-purple-800 border-purple-300',
                                    \App\Enums\ServiceRequestStatus::Issued,
                                    \App\Enums\ServiceRequestStatus::RecommendationIssued,
                                    \App\Enums\ServiceRequestStatus::Completed => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                                    \App\Enums\ServiceRequestStatus::Rejected => 'bg-rose-100 text-rose-800 border-rose-300',
                                    default => 'bg-slate-100 text-slate-800 border-slate-300',
                                };
                            @endphp
                            <span class="px-3.5 py-1.5 rounded-full text-xs font-bold border {{ $badgeClass }} inline-flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-current"></span>
                                <span>{{ $statusEnum->label() }}</span>
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-xs">
                        <div>
                            <span class="text-text-muted block">Jenis Layanan</span>
                            <span class="font-bold text-text-primary">{{ $serviceRequest->serviceType->name }}</span>
                        </div>
                        <div>
                            <span class="text-text-muted block">Nama Pemohon</span>
                            <span class="font-bold text-text-primary">{{ $serviceRequest->applicant_name }}</span>
                        </div>
                        <div>
                            <span class="text-text-muted block">Domisili</span>
                            <span class="font-bold text-text-primary">Ds. {{ $serviceRequest->village?->name }}, Kec. {{ $serviceRequest->village?->district?->name }}</span>
                        </div>
                        <div>
                            <span class="text-text-muted block">Tanggal Diajukan</span>
                            <span class="font-bold text-text-primary">{{ $serviceRequest->submitted_at?->translatedFormat('d M Y, H:i') ?? '-' }} WIB</span>
                        </div>
                    </div>
                </div>

                <!-- Alert Revision Requested (If Any) -->
                @if ($serviceRequest->status === \App\Enums\ServiceRequestStatus::RevisionRequested)
                    <div class="bg-amber-50 rounded-3xl border border-amber-300 p-6 md:p-8 space-y-4">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-amber-700 text-2xl shrink-0 mt-0.5">warning</span>
                            <div class="space-y-1">
                                <h3 class="font-bold text-sm text-amber-950">Perhatian: Permintaan Perbaikan Berkas dari Petugas</h3>
                                <p class="text-xs text-amber-900 leading-relaxed">
                                    Catatan Petugas: "<span class="font-semibold">{{ $serviceRequest->officer_notes ?? 'Silakan unggah ulang dokumen yang lebih jelas.' }}</span>"
                                </p>
                            </div>
                        </div>

                        <!-- Upload Revision Form -->
                        <form wire:submit="submitRevision({{ $serviceRequest->id }})" class="p-4 rounded-2xl bg-white border border-amber-200 space-y-3 text-xs">
                            <label class="block font-bold text-text-primary">
                                Unggah Berkas Perbaikan (Maks. 2 MB):
                            </label>
                            <input type="file" wire:model="revisionFile" class="block w-full">
                            @error('revisionFile')
                                <span class="text-status-danger block">{{ $message }}</span>
                            @enderror

                            <input wire:model="revisionNotes"
                                   type="text"
                                   placeholder="Catatan perbaikan Anda (opsional)"
                                   class="w-full rounded-xl border border-border-medium p-2.5">

                            <button type="submit"
                                    class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-900 font-bold transition-colors shadow-xs">
                                Kirim Berkas Perbaikan
                            </button>
                        </form>
                    </div>
                @endif

                <!-- Issued Document Card (If DTSEN Certificate Issued) -->
                @if ($serviceRequest->dtsenCertificate && $serviceRequest->dtsenCertificate->certificate_number)
                    <div class="bg-gradient-to-r from-teal-50 to-white rounded-3xl border border-teal-200 p-6 md:p-8 space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-2xl">verified</span>
                            </div>
                            <div>
                                <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-700">Surat Keterangan Resmi Telah Terbit</span>
                                <h3 class="font-extrabold text-base text-text-primary">
                                    Nomor Surat: {{ $serviceRequest->dtsenCertificate->certificate_number }}
                                </h3>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl bg-white border border-teal-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 text-xs">
                            <div class="space-y-1">
                                <span class="text-text-muted block">Kode Verifikasi QR:</span>
                                <span class="font-mono font-bold text-sm text-primary-container">{{ $serviceRequest->dtsenCertificate->verification_code }}</span>
                                <span class="text-text-muted block mt-1">
                                    Masa berlaku: {{ $serviceRequest->dtsenCertificate->valid_until ? $serviceRequest->dtsenCertificate->valid_until->translatedFormat('d F Y') : 'Sesuai ketentuan' }}
                                </span>
                            </div>

                            <div class="flex items-center gap-2">
                                <a href="{{ route('certificate.verify', ['code' => $serviceRequest->dtsenCertificate->verification_code]) }}" wire:navigate
                                   class="px-4 py-2 rounded-xl bg-surface-subtle hover:bg-brand-teal-light text-primary-container font-semibold transition-colors">
                                    Cek Keaslian (QR)
                                </a>
                                @if($serviceRequest->dtsenCertificate->file_path)
                                    <a href="{{ asset('storage/'.$serviceRequest->dtsenCertificate->file_path) }}" target="_blank"
                                       class="px-4 py-2 rounded-xl bg-primary-container hover:bg-brand-teal-dark text-white font-bold transition-colors">
                                        Unduh PDF
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- PBI Status Card (If PBI Reactivation) -->
                @if ($serviceRequest->pbiReactivation)
                    <div class="bg-white rounded-3xl border border-border-subtle p-6 space-y-3 text-xs">
                        <h3 class="font-bold text-sm text-text-primary flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary-container text-base">health_and_safety</span>
                            <span>Detail Status Reaktivasi JKN-KIS</span>
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div class="p-3 rounded-xl bg-surface-canvas border border-border-subtle">
                                <span class="text-text-muted block">Nomor BPJS/KIS</span>
                                <span class="font-mono font-bold">{{ $serviceRequest->pbiReactivation->bpjs_card_number }}</span>
                            </div>
                            <div class="p-3 rounded-xl bg-surface-canvas border border-border-subtle">
                                <span class="text-text-muted block">Surat Rekomendasi Dinsos</span>
                                <span class="font-bold">{{ $serviceRequest->pbiReactivation->recommendation_number ?? 'Dalam Proses' }}</span>
                            </div>
                            <div class="p-3 rounded-xl bg-surface-canvas border border-border-subtle">
                                <span class="text-text-muted block">Status Usulan Kemensos</span>
                                <span class="font-bold capitalize">{{ $serviceRequest->pbiReactivation->ministry_decision ?? 'Belum Diusulkan' }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Status History Timeline -->
                <div class="bg-white rounded-3xl border border-border-subtle p-6 md:p-8 space-y-6 shadow-xs">
                    <h3 class="font-bold text-sm text-text-primary flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary-container text-xl">history</span>
                        <span>Riwayat Penanganan Berkas</span>
                    </h3>

                    <div class="relative border-l-2 border-teal-200 ml-4 pl-6 space-y-6 text-xs">
                        @forelse ($serviceRequest->statusHistories as $history)
                            <div class="relative">
                                <span class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-primary-container ring-4 ring-brand-teal-light"></span>
                                <div class="space-y-0.5">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-text-primary text-xs md:text-sm">
                                            {{ \App\Enums\ServiceRequestStatus::tryFrom($history->to_status)?->label() ?? $history->to_status }}
                                        </span>
                                        <span class="text-[11px] text-text-muted">{{ $history->created_at->translatedFormat('d M Y, H:i') }} WIB</span>
                                    </div>
                                    @if($history->notes)
                                        <p class="text-xs text-text-secondary leading-relaxed bg-surface-canvas p-2.5 rounded-xl border border-border-subtle mt-1.5">
                                            {{ $history->notes }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-text-muted">Belum ada riwayat status tercatat.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        @elseif ($complaint)
            <!-- Complaint Result -->
            <div class="space-y-6">
                <!-- Top Summary Card -->
                <div class="bg-white rounded-3xl border border-border-subtle p-6 md:p-8 shadow-xs space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-border-subtle pb-6">
                        <div class="space-y-1">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-text-muted">Nomor Pengaduan</span>
                            <h2 class="text-2xl font-extrabold text-amber-600 font-mono">{{ $complaint->complaint_number }}</h2>
                        </div>

                        <div>
                            @php
                                $cBadgeClass = match($complaint->status) {
                                    \App\Enums\ComplaintStatus::Received => 'bg-amber-100 text-amber-800 border-amber-300',
                                    \App\Enums\ComplaintStatus::Verification,
                                    \App\Enums\ComplaintStatus::Dispatched,
                                    \App\Enums\ComplaintStatus::InHandling => 'bg-blue-100 text-blue-800 border-blue-300',
                                    \App\Enums\ComplaintStatus::Resolved => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                                    default => 'bg-rose-100 text-rose-800 border-rose-300',
                                };
                            @endphp
                            <span class="px-3.5 py-1.5 rounded-full text-xs font-bold border {{ $cBadgeClass }} inline-flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-current"></span>
                                <span>{{ $complaint->status->label() }}</span>
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-xs">
                        <div>
                            <span class="text-text-muted block">Kategori Masalah</span>
                            <span class="font-bold text-text-primary">{{ $complaint->complaintCategory?->name }}</span>
                        </div>
                        <div>
                            <span class="text-text-muted block">Nama Pelapor</span>
                            <span class="font-bold text-text-primary">{{ $complaint->reporter_name }}</span>
                        </div>
                        <div>
                            <span class="text-text-muted block">Lokasi Kejadian</span>
                            <span class="font-bold text-text-primary">Ds. {{ $complaint->village?->name }}, Kec. {{ $complaint->village?->district?->name }}</span>
                        </div>
                        <div>
                            <span class="text-text-muted block">Waktu Laporan</span>
                            <span class="font-bold text-text-primary">{{ $complaint->reported_at?->translatedFormat('d M Y, H:i') ?? '-' }} WIB</span>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-border-subtle text-xs space-y-1">
                        <span class="text-text-muted block font-semibold">Uraian Laporan:</span>
                        <p class="text-text-secondary leading-relaxed bg-surface-canvas p-3 rounded-xl border border-border-subtle">
                            {{ $complaint->description }}
                        </p>
                    </div>

                    @if($complaint->action_taken)
                        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-xs space-y-1">
                            <span class="font-bold text-emerald-800 block">Tindakan / Hasil Penanganan:</span>
                            <p class="text-emerald-950 leading-relaxed">{{ $complaint->action_taken }}</p>
                        </div>
                    @endif
                </div>

                <!-- Complaint Status History Timeline -->
                <div class="bg-white rounded-3xl border border-border-subtle p-6 md:p-8 space-y-6 shadow-xs">
                    <h3 class="font-bold text-sm text-text-primary flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary-container text-xl">history</span>
                        <span>Riwayat Penanganan Pengaduan</span>
                    </h3>

                    <div class="relative border-l-2 border-amber-200 ml-4 pl-6 space-y-6 text-xs">
                        @forelse ($complaint->statusHistories as $history)
                            <div class="relative">
                                <span class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-amber-500 ring-4 ring-amber-100"></span>
                                <div class="space-y-0.5">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-text-primary text-xs md:text-sm">
                                            {{ \App\Enums\ComplaintStatus::tryFrom($history->to_status)?->label() ?? $history->to_status }}
                                        </span>
                                        <span class="text-[11px] text-text-muted">{{ $history->created_at->translatedFormat('d M Y, H:i') }} WIB</span>
                                    </div>
                                    @if($history->notes)
                                        <p class="text-xs text-text-secondary leading-relaxed bg-surface-canvas p-2.5 rounded-xl border border-border-subtle mt-1.5">
                                            {{ $history->notes }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-text-muted">Belum ada riwayat penanganan tercatat.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        @else
            <!-- Not Found State -->
            <div class="bg-white rounded-3xl border border-border-subtle p-12 text-center max-w-xl mx-auto space-y-4 shadow-xs">
                <div class="w-16 h-16 rounded-full bg-rose-50 text-status-danger flex items-center justify-center mx-auto">
                    <span class="material-symbols-outlined text-3xl">sentiment_dissatisfied</span>
                </div>
                <h3 class="text-lg font-bold text-text-primary">
                    Nomor Tiket Tidak Ditemukan
                </h3>
                <p class="text-xs text-text-secondary leading-relaxed">
                    Sistem tidak menemukan berkas dengan nomor tiket "<span class="font-mono font-bold text-text-primary">{{ $ticketNumber }}</span>". Pastikan penulisan huruf besar dan tanda hubung sudah sesuai format resmi (contoh: <span class="font-mono font-semibold">DTSEN-202610-00012</span> atau <span class="font-mono font-semibold">ADU-202610-00004</span>).
                </p>
                <div class="pt-2">
                    <a href="{{ route('home') }}" wire:navigate class="px-6 py-2.5 rounded-xl bg-surface-subtle text-primary-container text-xs font-semibold hover:bg-brand-teal-light transition-colors">
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        @endif
    @endif
</div>
