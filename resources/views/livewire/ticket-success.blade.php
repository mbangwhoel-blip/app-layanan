<div class="max-w-3xl mx-auto px-4 md:px-8 py-12 md:py-16 space-y-8" x-data="{ copied: false }">
    <!-- Success Banner Card -->
    <div class="bg-white rounded-3xl border border-border-subtle p-8 md:p-12 text-center shadow-lg space-y-6 relative overflow-hidden">
        <!-- Atmospheric soft pulse -->
        <div class="absolute -top-16 left-1/2 -translate-x-1/2 w-48 h-48 bg-emerald-100 rounded-full blur-3xl pointer-events-none"></div>

        <!-- Success Icon -->
        <div class="relative z-10 w-20 h-20 rounded-full bg-status-success-light text-status-success flex items-center justify-center mx-auto shadow-xs">
            <span class="material-symbols-outlined text-5xl">check_circle</span>
        </div>

        <div class="space-y-2 relative z-10">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                <span class="w-2 h-2 rounded-full bg-status-success animate-pulse"></span>
                <span>Berkas Telah Masuk ke Sistem</span>
            </span>
            <h1 class="text-2xl md:text-3xl font-extrabold text-text-primary tracking-tight">
                {{ $complaint ? 'Laporan Pengaduan Berhasil Dikirim!' : 'Pengajuan Berhasil Dikirim!' }}
            </h1>
            <p class="text-xs md:text-sm text-text-secondary max-w-lg mx-auto leading-relaxed">
                Terima kasih. Permohonan Anda telah terdaftar resmi di sistem SAPA SOSIAL Dinas Sosial Pemerintah Kabupaten Blitar.
            </p>
        </div>

        <!-- Ticket Number Prominent Display -->
        <div class="ticket-pattern border-2 border-primary-container/30 rounded-2xl p-6 relative z-10 max-w-md mx-auto shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-text-muted block mb-1">
                Nomor Tiket Resmi Anda
            </span>
            <div class="flex items-center justify-center gap-3">
                <span class="font-mono text-2xl md:text-3xl font-extrabold text-primary-container tracking-wider">
                    {{ $ticketNumber }}
                </span>
                <button @click="navigator.clipboard.writeText('{{ $ticketNumber }}'); copied = true; setTimeout(() => copied = false, 2500)"
                        type="button"
                        class="p-2 rounded-xl bg-surface-subtle hover:bg-brand-teal-light text-primary-container transition-colors shadow-xs"
                        title="Salin Nomor Tiket">
                    <span class="material-symbols-outlined text-lg" x-show="!copied">content_copy</span>
                    <span class="material-symbols-outlined text-lg text-status-success" x-show="copied" style="display: none;">check</span>
                </button>
            </div>
            <span class="text-[11px] text-status-success font-semibold block mt-1" x-show="copied" style="display: none;">
                Nomor tiket berhasil disalin ke clipboard!
            </span>
            <p class="text-[11px] text-text-secondary mt-2">
                Simpan nomor tiket ini untuk memantau status berkas Anda kapan saja tanpa perlu login.
            </p>
        </div>

        <!-- Summary Details Card -->
        <div class="bg-surface-canvas rounded-2xl border border-border-subtle p-5 text-left space-y-3 text-xs md:text-sm max-w-md mx-auto relative z-10">
            <div class="flex items-center justify-between pb-2 border-b border-border-subtle">
                <span class="text-text-muted">Layanan / Subjek</span>
                <span class="font-bold text-text-primary text-right truncate max-w-[200px]">
                    {{ $serviceRequest?->serviceType?->name ?? ($complaint?->complaintCategory?->name ?? 'Layanan Sosial') }}
                </span>
            </div>
            <div class="flex items-center justify-between pb-2 border-b border-border-subtle">
                <span class="text-text-muted">Nama Pemohon / Pelapor</span>
                <span class="font-bold text-text-primary">
                    {{ $serviceRequest?->applicant_name ?? ($complaint?->reporter_name ?? '-') }}
                </span>
            </div>
            <div class="flex items-center justify-between pb-2 border-b border-border-subtle">
                <span class="text-text-muted">Tanggal Pengajuan</span>
                <span class="font-bold text-text-primary">
                    {{ now()->translatedFormat('d F Y, H:i') }} WIB
                </span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-text-muted">Tahap Selanjutnya</span>
                <span class="font-semibold text-primary-container">
                    Pemeriksaan berkas oleh petugas Dinsos
                </span>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-3 relative z-10">
            <a href="{{ route('ticket.track', ['ticket' => $ticketNumber]) }}" wire:navigate
               class="w-full sm:w-auto px-8 py-3 rounded-xl bg-primary-container hover:bg-brand-teal-dark text-white font-bold text-xs flex items-center justify-center gap-2 transition-colors shadow-xs">
                <span class="material-symbols-outlined text-lg">travel_explore</span>
                <span>Lacak Status Sekarang</span>
            </a>
            <a href="{{ route('home') }}" wire:navigate
               class="w-full sm:w-auto px-6 py-3 rounded-xl border border-border-medium hover:bg-surface-subtle text-text-primary font-bold text-xs text-center transition-colors">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
