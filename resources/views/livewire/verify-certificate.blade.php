<div class="max-w-4xl mx-auto px-4 md:px-8 py-8 md:py-12 space-y-8">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs text-text-secondary">
        <a href="{{ route('home') }}" class="hover:text-primary-container transition-colors" wire:navigate>Beranda</a>
        <span class="text-text-muted">/</span>
        <span class="text-primary-container font-semibold">Verifikasi Keaslian Surat</span>
    </nav>

    <!-- Header & Verification Input -->
    <div class="bg-white rounded-3xl border border-border-subtle p-6 md:p-8 shadow-xs space-y-6 text-center max-w-2xl mx-auto">
        <div class="w-16 h-16 rounded-2xl bg-brand-teal-light text-primary-container flex items-center justify-center mx-auto shadow-xs">
            <span class="material-symbols-outlined text-3xl">qr_code_scanner</span>
        </div>

        <div class="space-y-1">
            <h1 class="text-2xl font-extrabold text-text-primary tracking-tight">
                Verifikasi Keaslian Surat Keterangan DTSEN
            </h1>
            <p class="text-xs text-text-secondary leading-relaxed">
                Ketik kode verifikasi yang tertera di bawah QR Code pada lembar surat untuk memvalidasi keabsahan dokumen.
            </p>
        </div>

        <form wire:submit="check" class="space-y-3">
            <div class="relative">
                <input wire:model="code"
                       type="text"
                       placeholder="Contoh: VRF-202610-A9B8C"
                       class="w-full text-center px-4 py-3 rounded-2xl border-2 border-border-medium focus:border-primary-container focus:ring-2 focus:ring-primary-container font-mono text-base tracking-widest uppercase">
            </div>
            @error('code')
                <span class="text-xs text-status-danger block">{{ $message }}</span>
            @enderror

            <button type="submit"
                    wire:loading.attr="disabled"
                    class="w-full py-3 rounded-xl bg-primary-container hover:bg-brand-teal-dark text-white font-bold text-xs flex items-center justify-center gap-2 transition-colors shadow-xs">
                <span wire:loading.remove wire:target="check" class="material-symbols-outlined text-lg">verified</span>
                <span wire:loading wire:target="check" class="material-symbols-outlined animate-spin text-lg">progress_activity</span>
                <span>Periksa Keabsahan Dokumen</span>
            </button>
        </form>

        <p class="text-[11px] text-text-muted">
            Layanan ini dapat diakses bebas oleh sekolah, kampus, faskes, atau instansi lain tanpa memerlukan akun login.
        </p>
    </div>

    <!-- VERIFICATION RESULT FRAMES -->
    @if ($hasChecked)
        @if ($isValid && $certificate)
            <!-- Frame 1: VALID -->
            <div class="bg-white rounded-3xl border-2 border-status-success p-6 md:p-8 shadow-lg max-w-2xl mx-auto space-y-6 animate-fade-in">
                <div class="flex items-center gap-3 pb-4 border-b border-border-subtle">
                    <div class="w-12 h-12 rounded-full bg-status-success-light text-status-success flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-3xl">verified</span>
                    </div>
                    <div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-status-success text-white">
                            SURAT ASLI & SAH TERDAFTAR
                        </span>
                        <h2 class="text-lg font-bold text-text-primary mt-1">Dokumen Resmi Dinas Sosial Kab. Blitar</h2>
                    </div>
                </div>

                <div class="space-y-3 text-xs md:text-sm">
                    <div class="flex items-center justify-between pb-2 border-b border-border-subtle">
                        <span class="text-text-muted">Nomor Surat</span>
                        <span class="font-bold text-text-primary font-mono">{{ $certificate->certificate_number }}</span>
                    </div>
                    <div class="flex items-center justify-between pb-2 border-b border-border-subtle">
                        <span class="text-text-muted">Nama yang Diterangkan</span>
                        <span class="font-bold text-text-primary">{{ $certificate->subject_name }}</span>
                    </div>
                    <div class="flex items-center justify-between pb-2 border-b border-border-subtle">
                        <span class="text-text-muted">Tujuan Penggunaan</span>
                        <span class="font-bold text-text-primary">{{ $certificate->dtsenPurpose?->name ?? 'Keperluan Pendidikan/Sosial' }}</span>
                    </div>
                    <div class="flex items-center justify-between pb-2 border-b border-border-subtle">
                        <span class="text-text-muted">Tanggal Diterbitkan</span>
                        <span class="font-bold text-text-primary">{{ $certificate->issued_at?->translatedFormat('d F Y') ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between pb-2 border-b border-border-subtle">
                        <span class="text-text-muted">Masa Berlaku Hingga</span>
                        <span class="font-bold text-status-success">
                            {{ $certificate->valid_until ? $certificate->valid_until->translatedFormat('d F Y') : 'Sesuai Ketentuan' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-text-muted">Pejabat Penandatangan</span>
                        <span class="font-bold text-text-primary">
                            {{ $certificate->signer?->name ?? 'Kepala Dinas Sosial Kabupaten Blitar' }}
                        </span>
                    </div>
                </div>

                <div class="p-3.5 rounded-xl bg-surface-canvas text-[11px] text-text-muted text-center leading-relaxed">
                    Sesuai prinsip perlindungan data pribadi (UU PDP), rincian NIK dan desil DTSEN privat tidak ditampilkan pada halaman publik ini.
                </div>
            </div>

        @elseif ($isExpired && $certificate)
            <!-- Frame 2: KEDALUWARSA -->
            <div class="bg-white rounded-3xl border-2 border-amber-500 p-6 md:p-8 shadow-lg max-w-2xl mx-auto space-y-5">
                <div class="flex items-center gap-3 pb-4 border-b border-border-subtle">
                    <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-3xl">event_busy</span>
                    </div>
                    <div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-500 text-white">
                            SURAT KEDALUWARSA
                        </span>
                        <h2 class="text-lg font-bold text-text-primary mt-1">Masa Berlaku Surat Telah Habis</h2>
                    </div>
                </div>

                <p class="text-xs text-text-secondary leading-relaxed">
                    Dokumen dengan nomor <span class="font-mono font-bold">{{ $certificate->certificate_number }}</span> tercatat pernah diterbitkan, namun masa berlakunya telah berakhir pada <span class="font-bold">{{ $certificate->valid_until?->translatedFormat('d F Y') }}</span>.
                </p>

                <div class="pt-2 flex items-center justify-center">
                    <a href="{{ route('services.dtsen.apply') }}" wire:navigate
                       class="px-6 py-2.5 rounded-xl bg-primary-container text-white text-xs font-semibold hover:bg-brand-teal-dark transition-colors">
                        Ajukan Surat Keterangan Baru
                    </a>
                </div>
            </div>

        @else
            <!-- Frame 3: TIDAK VALID -->
            <div class="bg-white rounded-3xl border-2 border-rose-400 p-6 md:p-8 shadow-lg max-w-2xl mx-auto space-y-4 text-center">
                <div class="w-14 h-14 rounded-full bg-rose-100 text-status-danger flex items-center justify-center mx-auto">
                    <span class="material-symbols-outlined text-3xl">cancel</span>
                </div>

                <div class="space-y-1">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-status-danger text-white">
                        DOKUMEN TIDAK VALID
                    </span>
                    <h2 class="text-lg font-bold text-text-primary mt-2">Kode Verifikasi Tidak Ditemukan</h2>
                    <p class="text-xs text-text-secondary max-w-md mx-auto leading-relaxed">
                        Kode "<span class="font-mono font-bold text-text-primary">{{ $code }}</span>" tidak terdaftar pada basis data penerbitan resmi Dinas Sosial Kabupaten Blitar. Waspadai pemalsuan dokumen.
                    </p>
                </div>

                <div class="pt-3">
                    <p class="text-xs text-text-muted">
                        Bila Anda menduga ada kesalahan, silakan hubungi Dinas Sosial Kabupaten Blitar di nomor <strong>(0342) 801123</strong>.
                    </p>
                </div>
            </div>
        @endif
    @endif
</div>
