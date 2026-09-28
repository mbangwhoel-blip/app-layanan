<div class="max-w-4xl mx-auto px-4 md:px-8 py-8 md:py-12 space-y-8">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs text-text-secondary">
        <a href="{{ route('home') }}" class="hover:text-primary-container transition-colors" wire:navigate>Beranda</a>
        <span class="text-text-muted">/</span>
        <a href="{{ route('services.pbi') }}" class="hover:text-primary-container transition-colors" wire:navigate>Reaktivasi KIS / PBI-JK</a>
        <span class="text-text-muted">/</span>
        <span class="text-primary-container font-semibold">Formulir Pengajuan</span>
    </nav>

    <!-- Page Title -->
    <div class="space-y-1">
        <h1 class="text-2xl md:text-3xl font-extrabold text-text-primary tracking-tight">
            Pengajuan Reaktivasi KIS / PBI-JK
        </h1>
        <p class="text-xs md:text-sm text-text-secondary leading-relaxed">
            Fasilitasi pengaktifan kembali kepesertaan JKN-KIS Penerima Bantuan Iuran Jaminan Kesehatan (PBI-JK) yang dinonaktifkan.
        </p>
    </div>

    <!-- Stepper Navigation -->
    <div class="bg-white rounded-2xl border border-border-subtle p-4 md:p-6 shadow-xs">
        <ol class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-2 relative">
            <!-- Step 1 -->
            <li class="flex items-center gap-3 relative cursor-pointer" wire:click="goToStep(1)">
                <div class="w-9 h-9 rounded-full flex items-center justify-center shrink-0 font-bold text-xs shadow-xs @if($currentStep > 1) bg-status-success text-white @elseif($currentStep === 1) bg-primary-container text-white ring-4 ring-brand-teal-light @else bg-surface-subtle text-text-secondary border border-border-medium @endif">
                    @if($currentStep > 1)
                        <span class="material-symbols-outlined text-lg">check</span>
                    @else
                        1
                    @endif
                </div>
                <div class="flex flex-col">
                    <span class="text-[11px] font-bold {{ $currentStep >= 1 ? 'text-primary-container' : 'text-text-muted' }}">Langkah 1</span>
                    <span class="text-xs font-semibold text-text-primary truncate">Data Peserta</span>
                </div>
            </li>

            <!-- Step 2 -->
            <li class="flex items-center gap-3 relative cursor-pointer" wire:click="goToStep(2)">
                <div class="w-9 h-9 rounded-full flex items-center justify-center shrink-0 font-bold text-xs shadow-xs @if($currentStep > 2) bg-status-success text-white @elseif($currentStep === 2) bg-primary-container text-white ring-4 ring-brand-teal-light @else bg-surface-subtle text-text-secondary border border-border-medium @endif">
                    @if($currentStep > 2)
                        <span class="material-symbols-outlined text-lg">check</span>
                    @else
                        2
                    @endif
                </div>
                <div class="flex flex-col">
                    <span class="text-[11px] font-bold {{ $currentStep >= 2 ? 'text-primary-container' : 'text-text-muted' }}">Langkah 2</span>
                    <span class="text-xs font-semibold text-text-primary truncate">Alasan Reaktivasi</span>
                </div>
            </li>

            <!-- Step 3 -->
            <li class="flex items-center gap-3 relative cursor-pointer" wire:click="goToStep(3)">
                <div class="w-9 h-9 rounded-full flex items-center justify-center shrink-0 font-bold text-xs shadow-xs @if($currentStep > 3) bg-status-success text-white @elseif($currentStep === 3) bg-primary-container text-white ring-4 ring-brand-teal-light @else bg-surface-subtle text-text-secondary border border-border-medium @endif">
                    @if($currentStep > 3)
                        <span class="material-symbols-outlined text-lg">check</span>
                    @else
                        3
                    @endif
                </div>
                <div class="flex flex-col">
                    <span class="text-[11px] font-bold {{ $currentStep >= 3 ? 'text-primary-container' : 'text-text-muted' }}">Langkah 3</span>
                    <span class="text-xs font-semibold text-text-primary truncate">Unggah Dokumen</span>
                </div>
            </li>

            <!-- Step 4 -->
            <li class="flex items-center gap-3 relative">
                <div class="w-9 h-9 rounded-full flex items-center justify-center shrink-0 font-bold text-xs shadow-xs @if($currentStep === 4) bg-primary-container text-white ring-4 ring-brand-teal-light @else bg-surface-subtle text-text-secondary border border-border-medium @endif">
                    4
                </div>
                <div class="flex flex-col">
                    <span class="text-[11px] font-bold {{ $currentStep === 4 ? 'text-primary-container' : 'text-text-muted' }}">Langkah 4</span>
                    <span class="text-xs font-semibold text-text-primary truncate">Tinjau & Kirim</span>
                </div>
            </li>
        </ol>
    </div>

    <!-- FORM WORKFLOW CANVAS -->
    <div class="bg-white rounded-3xl border border-border-subtle p-6 md:p-8 shadow-xs space-y-6">

        <!-- ==================== STEP 1: DATA PESERTA ==================== -->
        @if ($currentStep === 1)
            <div class="space-y-6">
                <div class="border-b border-border-subtle pb-4">
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-brand-teal-light text-primary-container">
                        Langkah 1 dari 4
                    </span>
                    <h2 class="text-xl font-bold text-text-primary mt-2">
                        Data Identitas Peserta JKN-KIS
                    </h2>
                    <p class="text-xs text-text-secondary mt-1">
                        Masukkan data identitas sesuai KTP, KK, dan nomor kartu BPJS Kesehatan yang dinonaktifkan.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs md:text-sm">
                    <!-- Nama Peserta -->
                    <div class="space-y-1.5 md:col-span-2">
                        <label class="block font-bold text-text-primary">
                            Nama Lengkap Peserta (Sesuai KTP/Kartu BPJS) <span class="text-status-danger">*</span>
                        </label>
                        <input wire:model="participant_name"
                               type="text"
                               placeholder="Nama lengkap peserta"
                               class="w-full rounded-xl border border-border-medium p-3 focus:border-primary-container focus:ring-1 focus:ring-primary-container">
                        @error('participant_name')
                            <span class="text-xs text-status-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- NIK Peserta -->
                    <div class="space-y-1.5">
                        <label class="block font-bold text-text-primary">
                            NIK Peserta (16 Digit) <span class="text-status-danger">*</span>
                        </label>
                        <input wire:model="participant_nik"
                               type="text"
                               maxlength="16"
                               placeholder="3505xxxxxxxxxxxx"
                               class="w-full rounded-xl border border-border-medium p-3 font-mono tracking-wider focus:border-primary-container focus:ring-1 focus:ring-primary-container">
                        @error('participant_nik')
                            <span class="text-xs text-status-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- No KK -->
                    <div class="space-y-1.5">
                        <label class="block font-bold text-text-primary">
                            Nomor Kartu Keluarga (KK 16 Digit) <span class="text-status-danger">*</span>
                        </label>
                        <input wire:model="family_card_number"
                               type="text"
                               maxlength="16"
                               placeholder="3505xxxxxxxxxxxx"
                               class="w-full rounded-xl border border-border-medium p-3 font-mono tracking-wider focus:border-primary-container focus:ring-1 focus:ring-primary-container">
                        @error('family_card_number')
                            <span class="text-xs text-status-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Nomor Kartu BPJS/KIS -->
                    <div class="space-y-1.5">
                        <label class="block font-bold text-text-primary">
                            Nomor Kartu BPJS / KIS <span class="text-status-danger">*</span>
                        </label>
                        <input wire:model="bpjs_card_number"
                               type="text"
                               placeholder="Contoh: 0001234567890"
                               class="w-full rounded-xl border border-border-medium p-3 font-mono tracking-wider focus:border-primary-container focus:ring-1 focus:ring-primary-container">
                        @error('bpjs_card_number')
                            <span class="text-xs text-status-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Perkiraan Tanggal Nonaktif -->
                    <div class="space-y-1.5">
                        <label class="block font-bold text-text-primary">
                            Perkiraan Tanggal Nonaktif (Bila diketahui)
                        </label>
                        <input wire:model="deactivated_date"
                               type="date"
                               class="w-full rounded-xl border border-border-medium p-3 focus:border-primary-container focus:ring-1 focus:ring-primary-container">
                        @error('deactivated_date')
                            <span class="text-xs text-status-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Kecamatan -->
                    <div class="space-y-1.5">
                        <label class="block font-bold text-text-primary">
                            Kecamatan Domisili (Kab. Blitar) <span class="text-status-danger">*</span>
                        </label>
                        <select wire:model.live="district_id"
                                class="w-full rounded-xl border border-border-medium p-3 focus:border-primary-container focus:ring-1 focus:ring-primary-container">
                            <option value="">-- Pilih Kecamatan --</option>
                            @foreach ($districts as $district)
                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                            @endforeach
                        </select>
                        @error('district_id')
                            <span class="text-xs text-status-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Desa/Kelurahan -->
                    <div class="space-y-1.5">
                        <label class="block font-bold text-text-primary">
                            Desa / Kelurahan <span class="text-status-danger">*</span>
                        </label>
                        <select wire:model="village_id"
                                class="w-full rounded-xl border border-border-medium p-3 focus:border-primary-container focus:ring-1 focus:ring-primary-container"
                                {{ empty($villages) ? 'disabled' : '' }}>
                            <option value="">-- Pilih Desa/Kelurahan --</option>
                            @foreach ($villages as $village)
                                <option value="{{ $village->id }}">{{ $village->name }}</option>
                            @endforeach
                        </select>
                        @error('village_id')
                            <span class="text-xs text-status-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Alamat Lengkap -->
                    <div class="space-y-1.5 md:col-span-2">
                        <label class="block font-bold text-text-primary">
                            Alamat Lengkap (RT/RW, Dusun/Jalan) <span class="text-status-danger">*</span>
                        </label>
                        <input wire:model="address"
                               type="text"
                               placeholder="Contoh: RT 01 RW 03 Dusun Banggle"
                               class="w-full rounded-xl border border-border-medium p-3 focus:border-primary-container focus:ring-1 focus:ring-primary-container">
                        @error('address')
                            <span class="text-xs text-status-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- No HP -->
                    <div class="space-y-1.5 md:col-span-2">
                        <label class="block font-bold text-text-primary">
                            Nomor WhatsApp / HP Aktif <span class="text-status-danger">*</span>
                        </label>
                        <input wire:model="phone"
                               type="text"
                               placeholder="Contoh: 081234567890"
                               class="w-full rounded-xl border border-border-medium p-3 focus:border-primary-container focus:ring-1 focus:ring-primary-container">
                        @error('phone')
                            <span class="text-xs text-status-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        @endif

        <!-- ==================== STEP 2: ALASAN REAKTIVASI ==================== -->
        @if ($currentStep === 2)
            <div class="space-y-6">
                <div class="border-b border-border-subtle pb-4">
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-brand-teal-light text-primary-container">
                        Langkah 2 dari 4
                    </span>
                    <h2 class="text-xl font-bold text-text-primary mt-2">
                        Alasan Permohonan Reaktivasi
                    </h2>
                    <p class="text-xs text-text-secondary mt-1">
                        Pilih kondisi yang mendasari kebutuhan pengaktifan kembali kartu BPJS/KIS.
                    </p>
                </div>

                <!-- Emergency Notice Alert (If Emergency selected) -->
                @if ($reason === 'emergency')
                    <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 flex items-start gap-3 text-rose-900">
                        <span class="material-symbols-outlined text-rose-600 text-2xl shrink-0 mt-0.5">e911_emergency</span>
                        <div class="space-y-0.5 text-xs">
                            <span class="font-bold block text-sm">Kasus Prioritas Darurat Medis!</span>
                            <p class="leading-relaxed">Pengajuan dengan alasan darurat medis akan ditandai prioritas dan langsung ditindaklanjuti oleh petugas piket pelayanan Dinsos.</p>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    @foreach ($reasons as $r)
                        <label class="relative flex flex-col p-4 rounded-2xl border-2 cursor-pointer transition-all {{ $reason === $r->value ? ($r->value === 'emergency' ? 'border-rose-500 bg-rose-50/50' : 'border-primary-container bg-brand-teal-light/20 shadow-xs') : 'border-border-subtle bg-white hover:border-border-medium' }}">
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="font-bold text-sm {{ $reason === $r->value ? ($r->value === 'emergency' ? 'text-rose-700' : 'text-primary-container') : 'text-text-primary' }}">
                                    {{ $r->label() }}
                                </span>
                                <input wire:model.live="reason"
                                       type="radio"
                                       name="reason_opt"
                                       value="{{ $r->value }}"
                                       class="w-4 h-4 text-primary-container border-border-medium focus:ring-primary-container">
                            </div>
                            <span class="text-xs text-text-secondary">
                                @if($r->value === 'emergency')
                                    Sedang rawat inap di Rumah Sakit atau butuh tindakan darurat.
                                @elseif($r->value === 'chronic')
                                    Memerlukan kontrol rutin obat hipertensi, diabetes, jantung, dll.
                                @elseif($r->value === 'catastrophic')
                                    Kanker, gagal ginjal (hemodialisis), stroke, thalasemia, dll.
                                @elseif($r->value === 'newborn')
                                    Bayi baru lahir dari ibu kandung peserta aktif PBI-JK.
                                @else
                                    Alasan administrasi atau sosial lainnya.
                                @endif
                            </span>
                        </label>
                    @endforeach
                </div>

                <!-- Fields for Medical Reasons -->
                @if ($this->isMedicalReason())
                    <div class="p-4 rounded-2xl bg-surface-canvas border border-border-subtle space-y-4">
                        <h3 class="font-bold text-xs text-text-primary flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-primary-container text-base">local_hospital</span>
                            <span>Informasi Fasilitas Kesehatan</span>
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs md:text-sm">
                            <div class="space-y-1.5">
                                <label class="block font-bold text-text-primary">
                                    Nama Fasilitas Kesehatan (RS / Puskesmas) <span class="text-status-danger">*</span>
                                </label>
                                <input wire:model="health_facility_name"
                                       type="text"
                                       placeholder="Misal: RSUD Ngudi Waluyo Wlingi"
                                       class="w-full rounded-xl border border-border-medium p-3 bg-white focus:border-primary-container focus:ring-1 focus:ring-primary-container">
                                @error('health_facility_name')
                                    <span class="text-xs text-status-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="space-y-1.5">
                                <label class="block font-bold text-text-primary">
                                    Nomor Surat Keterangan Dokter/Faskes (Bila ada)
                                </label>
                                <input wire:model="health_letter_number"
                                       type="text"
                                       placeholder="Nomor surat keterangan rawat/rujukan"
                                       class="w-full rounded-xl border border-border-medium p-3 bg-white focus:border-primary-container focus:ring-1 focus:ring-primary-container">
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <!-- ==================== STEP 3: UNGGAH BERKAS ==================== -->
        @if ($currentStep === 3)
            <div class="space-y-6">
                <div class="border-b border-border-subtle pb-4">
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-brand-teal-light text-primary-container">
                        Langkah 3 dari 4
                    </span>
                    <h2 class="text-xl font-bold text-text-primary mt-2">
                        Unggah Berkas Persyaratan
                    </h2>
                    <p class="text-xs text-text-secondary mt-1">
                        Lampirkan dokumen bukti identitas dan dokumen medis dalam format JPG, PNG, atau PDF (maks. 2 MB per file).
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- KTP Upload -->
                    <div class="p-4 rounded-2xl border-2 border-dashed border-border-medium hover:border-primary-container transition-colors bg-surface-canvas text-center space-y-2">
                        <div class="w-10 h-10 rounded-full bg-brand-teal-light text-primary-container flex items-center justify-center mx-auto">
                    <!-- KTP Upload -->
                    <div class="p-4 rounded-2xl border-2 border-dashed border-border-medium hover:border-primary-container transition-colors bg-surface-canvas text-center space-y-2.5">
                        <label for="pbi_ktp_file" class="cursor-pointer block space-y-2">
                            <div class="w-12 h-12 rounded-xl bg-teal-50 border border-teal-200/80 text-primary-container flex items-center justify-center mx-auto shadow-xs hover:scale-105 transition-transform">
                                <span class="material-symbols-outlined text-2xl">badge</span>
                            </div>
                            <div>
                                <span class="font-bold text-xs text-text-primary block">Foto / Scan KTP Peserta <span class="text-status-danger">*</span></span>
                                <span class="text-[11px] text-text-muted">JPG, PNG, atau PDF</span>
                            </div>
                            <div class="pt-1">
                                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-primary-container text-white text-xs font-bold hover:bg-brand-teal-dark transition-colors shadow-2xs">
                                    <span class="material-symbols-outlined text-base">upload_file</span>
                                    <span>Pilih Berkas KTP</span>
                                </span>
                            </div>
                            <input id="pbi_ktp_file" type="file" wire:model="ktp_file" accept=".jpg,.jpeg,.png,.pdf" class="sr-only">
                        </label>
                        <div wire:loading wire:target="ktp_file" class="text-xs text-primary-container font-semibold animate-pulse">Mengunggah...</div>
                        @if ($ktp_file)
                            <div class="flex items-center justify-center gap-1.5 text-xs text-status-success font-semibold pt-1">
                                <span class="material-symbols-outlined text-sm">check_circle</span>
                                <span class="truncate max-w-[200px]">{{ $ktp_file->getClientOriginalName() }}</span>
                            </div>
                        @endif
                        @error('ktp_file')
                            <span class="text-xs text-status-danger block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- KK Upload -->
                    <div class="p-4 rounded-2xl border-2 border-dashed border-border-medium hover:border-primary-container transition-colors bg-surface-canvas text-center space-y-2.5">
                        <label for="pbi_kk_file" class="cursor-pointer block space-y-2">
                            <div class="w-12 h-12 rounded-xl bg-teal-50 border border-teal-200/80 text-primary-container flex items-center justify-center mx-auto shadow-xs hover:scale-105 transition-transform">
                                <span class="material-symbols-outlined text-2xl">family_restroom</span>
                            </div>
                            <div>
                                <span class="font-bold text-xs text-text-primary block">Foto / Scan Kartu Keluarga <span class="text-status-danger">*</span></span>
                                <span class="text-[11px] text-text-muted">JPG, PNG, atau PDF</span>
                            </div>
                            <div class="pt-1">
                                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-primary-container text-white text-xs font-bold hover:bg-brand-teal-dark transition-colors shadow-2xs">
                                    <span class="material-symbols-outlined text-base">upload_file</span>
                                    <span>Pilih Berkas KK</span>
                                </span>
                            </div>
                            <input id="pbi_kk_file" type="file" wire:model="kk_file" accept=".jpg,.jpeg,.png,.pdf" class="sr-only">
                        </label>
                        <div wire:loading wire:target="kk_file" class="text-xs text-primary-container font-semibold animate-pulse">Mengunggah...</div>
                        @if ($kk_file)
                            <div class="flex items-center justify-center gap-1.5 text-xs text-status-success font-semibold pt-1">
                                <span class="material-symbols-outlined text-sm">check_circle</span>
                                <span class="truncate max-w-[200px]">{{ $kk_file->getClientOriginalName() }}</span>
                            </div>
                        @endif
                        @error('kk_file')
                            <span class="text-xs text-status-danger block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- BPJS/KIS Card Upload -->
                    <div class="p-4 rounded-2xl border-2 border-dashed border-border-medium hover:border-primary-container transition-colors bg-surface-canvas text-center space-y-2.5">
                        <label for="pbi_bpjs_file" class="cursor-pointer block space-y-2">
                            <div class="w-12 h-12 rounded-xl bg-teal-50 border border-teal-200/80 text-primary-container flex items-center justify-center mx-auto shadow-xs hover:scale-105 transition-transform">
                                <span class="material-symbols-outlined text-2xl">credit_card</span>
                            </div>
                            <div>
                                <span class="font-bold text-xs text-text-primary block">Foto Kartu BPJS / KIS <span class="text-status-danger">*</span></span>
                                <span class="text-[11px] text-text-muted">Kartu fisik atau screenshot JKN Mobile</span>
                            </div>
                            <div class="pt-1">
                                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-primary-container text-white text-xs font-bold hover:bg-brand-teal-dark transition-colors shadow-2xs">
                                    <span class="material-symbols-outlined text-base">upload_file</span>
                                    <span>Pilih Berkas BPJS</span>
                                </span>
                            </div>
                            <input id="pbi_bpjs_file" type="file" wire:model="bpjs_file" accept=".jpg,.jpeg,.png,.pdf" class="sr-only">
                        </label>
                        <div wire:loading wire:target="bpjs_file" class="text-xs text-primary-container font-semibold animate-pulse">Mengunggah...</div>
                        @if ($bpjs_file)
                            <div class="flex items-center justify-center gap-1.5 text-xs text-status-success font-semibold pt-1">
                                <span class="material-symbols-outlined text-sm">check_circle</span>
                                <span class="truncate max-w-[200px]">{{ $bpjs_file->getClientOriginalName() }}</span>
                            </div>
                        @endif
                        @error('bpjs_file')
                            <span class="text-xs text-status-danger block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Faskes Letter Upload (Mandatory for medical reasons) -->
                    <div class="p-4 rounded-2xl border-2 border-dashed border-border-medium hover:border-primary-container transition-colors bg-surface-canvas text-center space-y-2.5">
                        <label for="pbi_faskes_file" class="cursor-pointer block space-y-2">
                            <div class="w-12 h-12 rounded-xl bg-teal-50 border border-teal-200/80 text-primary-container flex items-center justify-center mx-auto shadow-xs hover:scale-105 transition-transform">
                                <span class="material-symbols-outlined text-2xl">medical_services</span>
                            </div>
                            <div>
                                <span class="font-bold text-xs text-text-primary block">
                                    Surat Keterangan Faskes / Dokter
                                    @if($this->isMedicalReason())
                                        <span class="text-status-danger">*</span>
                                    @else
                                        <span class="text-text-muted">(Opsional)</span>
                                    @endif
                                </span>
                                <span class="text-[11px] text-text-muted">Surat rawat inap, kontrol, atau diagnosa dokter</span>
                            </div>
                            <div class="pt-1">
                                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-primary-container text-white text-xs font-bold hover:bg-brand-teal-dark transition-colors shadow-2xs">
                                    <span class="material-symbols-outlined text-base">upload_file</span>
                                    <span>Pilih Berkas Medis</span>
                                </span>
                            </div>
                            <input id="pbi_faskes_file" type="file" wire:model="faskes_file" accept=".jpg,.jpeg,.png,.pdf" class="sr-only">
                        </label>
                        <div wire:loading wire:target="faskes_file" class="text-xs text-primary-container font-semibold animate-pulse">Mengunggah...</div>
                        @if ($faskes_file)
                            <div class="flex items-center justify-center gap-1.5 text-xs text-status-success font-semibold pt-1">
                                <span class="material-symbols-outlined text-sm">check_circle</span>
                                <span class="truncate max-w-[200px]">{{ $faskes_file->getClientOriginalName() }}</span>
                            </div>
                        @endif
                        @error('faskes_file')
                            <span class="text-xs text-status-danger block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        @endif

        <!-- ==================== STEP 4: TINJAU & KIRIM ==================== -->
        @if ($currentStep === 4)
            <div class="space-y-6">
                <div class="border-b border-border-subtle pb-4">
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-brand-teal-light text-primary-container">
                        Langkah 4 dari 4
                    </span>
                    <h2 class="text-xl font-bold text-text-primary mt-2">
                        Tinjau Data & Kirim Pengajuan
                    </h2>
                    <p class="text-xs text-text-secondary mt-1">
                        Periksa kelengkapan data peserta dan dokumen sebelum mengirimkan usulan reaktivasi.
                    </p>
                </div>

                <!-- Review Section 1: Data Peserta -->
                <div class="p-4 rounded-2xl bg-surface-canvas border border-border-subtle flex items-start justify-between">
                    <div class="space-y-1">
                        <span class="text-[11px] font-bold text-text-muted uppercase tracking-wider block">Data Peserta</span>
                        <h4 class="font-bold text-sm text-text-primary">{{ $participant_name }} (NIK: {{ $participant_nik }})</h4>
                        <p class="text-xs text-text-secondary">No. BPJS/KIS: <span class="font-mono font-bold">{{ $bpjs_card_number }}</span> &bull; No. KK: {{ $family_card_number }}</p>
                        <p class="text-xs text-text-secondary">Alamat: {{ $address }}, Ds. {{ $selectedVillage?->name }}, Kec. {{ $selectedDistrict?->name }}</p>
                        <p class="text-xs text-text-secondary">No. HP: {{ $phone }}</p>
                    </div>
                    <button wire:click="goToStep(1)" type="button" class="text-xs font-bold text-primary-container hover:underline">
                        Ubah
                    </button>
                </div>

                <!-- Review Section 2: Alasan Reaktivasi -->
                <div class="p-4 rounded-2xl bg-surface-canvas border border-border-subtle flex items-start justify-between">
                    <div class="space-y-1">
                        <span class="text-[11px] font-bold text-text-muted uppercase tracking-wider block">Alasan Pengajuan</span>
                        <div class="flex items-center gap-2">
                            <h4 class="font-bold text-sm text-text-primary">
                                {{ \App\Enums\PbiReactivationReason::tryFrom($reason)?->label() ?? $reason }}
                            </h4>
                            @if ($reason === 'emergency')
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-100 text-rose-700 animate-pulse">Prioritas Darurat</span>
                            @endif
                        </div>
                        @if($health_facility_name)
                            <p class="text-xs text-text-secondary">Faskes: {{ $health_facility_name }} {{ $health_letter_number ? '(No. Surat: '.$health_letter_number.')' : '' }}</p>
                        @endif
                    </div>
                    <button wire:click="goToStep(2)" type="button" class="text-xs font-bold text-primary-container hover:underline">
                        Ubah
                    </button>
                </div>

                <!-- Review Section 3: Berkas -->
                <div class="p-4 rounded-2xl bg-surface-canvas border border-border-subtle flex items-start justify-between">
                    <div class="space-y-1">
                        <span class="text-[11px] font-bold text-text-muted uppercase tracking-wider block">Dokumen Berkas</span>
                        <div class="flex flex-wrap items-center gap-3 text-xs text-status-success font-semibold pt-1">
                            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">check</span> KTP</span>
                            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">check</span> KK</span>
                            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">check</span> Kartu BPJS</span>
                            @if($faskes_file)
                                <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">check</span> Surat Medis Faskes</span>
                            @endif
                        </div>
                    </div>
                    <button wire:click="goToStep(3)" type="button" class="text-xs font-bold text-primary-container hover:underline">
                        Ubah
                    </button>
                </div>

                <!-- Consent Checkbox -->
                <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 space-y-2">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input wire:model="consent" type="checkbox" class="w-4 h-4 text-primary-container rounded border-amber-400 focus:ring-primary-container mt-0.5">
                        <span class="text-xs text-amber-950 leading-relaxed font-medium">
                            Saya menyatakan bahwa data kepesertaan dan dokumen yang diunggah adalah benar milik peserta yang bersangkutan. Saya bersedia mengikuti ketentuan verifikasi kelayakan yang berlaku di Dinas Sosial dan Kementerian Sosial RI.
                        </span>
                    </label>
                    @error('consent')
                        <span class="text-xs text-status-danger block pl-7">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        @endif

        <!-- Action Buttons Bar -->
        <div class="flex items-center justify-between pt-6 border-t border-border-subtle">
            @if ($currentStep > 1)
                <button wire:click="prevStep"
                        type="button"
                        class="px-5 py-2.5 rounded-xl border border-border-medium hover:bg-surface-subtle text-text-primary font-bold text-xs flex items-center gap-1.5 transition-colors">
                    <span class="material-symbols-outlined text-base">arrow_back</span>
                    <span>Kembali</span>
                </button>
            @else
                <div></div>
            @endif

            @if ($currentStep < 4)
                <button wire:click="nextStep"
                        type="button"
                        class="px-6 py-2.5 rounded-xl bg-primary-container hover:bg-brand-teal-dark text-white font-bold text-xs flex items-center gap-1.5 transition-colors shadow-xs">
                    <span>Lanjutkan</span>
                    <span class="material-symbols-outlined text-base">arrow_forward</span>
                </button>
            @else
                <button wire:click="submit"
                        wire:loading.attr="disabled"
                        type="button"
                        class="px-8 py-3 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-900 font-bold text-xs flex items-center gap-2 transition-colors shadow-sm focus:ring-4 focus:ring-amber-500/20">
                    <span wire:loading.remove wire:target="submit" class="material-symbols-outlined text-lg">send</span>
                    <span wire:loading wire:target="submit" class="material-symbols-outlined animate-spin text-lg">progress_activity</span>
                    <span wire:loading.remove wire:target="submit">Kirim Pengajuan Reaktivasi</span>
                    <span wire:loading wire:target="submit">Memproses Permohonan...</span>
                </button>
            @endif
        </div>
    </div>
</div>
