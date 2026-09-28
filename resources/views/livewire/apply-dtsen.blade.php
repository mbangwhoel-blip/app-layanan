<div class="max-w-4xl mx-auto px-4 md:px-8 py-8 md:py-12 space-y-8">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs text-text-secondary">
        <a href="{{ route('home') }}" class="hover:text-primary-container transition-colors" wire:navigate>Beranda</a>
        <span class="text-text-muted">/</span>
        <a href="{{ route('services.dtsen') }}" class="hover:text-primary-container transition-colors" wire:navigate>Surat Keterangan DTSEN</a>
        <span class="text-text-muted">/</span>
        <span class="text-primary-container font-semibold">Formulir Pengajuan</span>
    </nav>

    <!-- Page Title -->
    <div class="space-y-1">
        <h1 class="text-2xl md:text-3xl font-extrabold text-text-primary tracking-tight">
            Formulir Pengajuan — Surat Keterangan DTSEN
        </h1>
        <p class="text-xs md:text-sm text-text-secondary leading-relaxed">
            Surat Keterangan Terdaftar Data Tunggal Sosial Ekonomi Nasional (DTSEN) untuk keperluan SPMB, beasiswa PIP/KIP, bansos, dan kesehatan.
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
                    <span class="text-xs font-semibold text-text-primary truncate">Tujuan Surat</span>
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
                    <span class="text-xs font-semibold text-text-primary truncate">Data Pemohon</span>
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
                    <span class="text-xs font-semibold text-text-primary truncate">Subjek & Berkas</span>
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

    <!-- FORM WORKFLOW STEPS -->
    <div class="bg-white rounded-3xl border border-border-subtle p-6 md:p-8 shadow-xs space-y-6">

        <!-- ==================== STEP 1: TUJUAN PENGGUNAAN ==================== -->
        @if ($currentStep === 1)
            <div class="space-y-6">
                <div class="border-b border-border-subtle pb-4">
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-brand-teal-light text-primary-container">
                        Langkah 1 dari 4
                    </span>
                    <h2 class="text-xl font-bold text-text-primary mt-2">
                        Pilih Tujuan Penggunaan Surat Keterangan
                    </h2>
                    <p class="text-xs text-text-secondary mt-1">
                        Pilih peruntukan surat yang sesuai. Batas desil DTSEN yang berlaku ditentukan berdasarkan tujuan penggunaan.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3.5">
                    @foreach ($purposes as $purpose)
                        <label class="relative flex flex-col p-4 rounded-2xl border-2 cursor-pointer transition-all {{ $dtsen_purpose_id == $purpose->id ? 'border-primary-container bg-brand-teal-light/20 shadow-xs' : 'border-border-subtle bg-white hover:border-border-medium' }}">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-bold text-sm {{ $dtsen_purpose_id == $purpose->id ? 'text-primary-container' : 'text-text-primary' }}">
                                    {{ $purpose->name }}
                                </span>
                                <input wire:model.live="dtsen_purpose_id"
                                       type="radio"
                                       name="purpose"
                                       value="{{ $purpose->id }}"
                                       class="w-4 h-4 text-primary-container border-border-medium focus:ring-primary-container">
                            </div>
                            <span class="text-xs text-text-secondary mt-auto">
                                @if($purpose->max_decile)
                                    Batas maksimal desil: <span class="font-bold text-text-primary">Desil {{ $purpose->max_decile }}</span>
                                @else
                                    Masa berlaku: {{ $purpose->validity_days ?? 30 }} hari
                                @endif
                            </span>
                        </label>
                    @endforeach
                </div>
                @error('dtsen_purpose_id')
                    <span class="text-xs text-status-danger block">{{ $message }}</span>
                @enderror

                <!-- Keterangan Tambahan -->
                <div class="space-y-1.5 pt-2">
                    <label class="block text-xs font-bold text-text-primary">
                        Keterangan Tambahan Tujuan (Opsional)
                    </label>
                    <textarea wire:model="purpose_description"
                              rows="3"
                              placeholder="Misal: Persyaratan pendaftaran SPMB jalur afirmasi di SMAN 1 Talun / KIP Kuliah di Universitas Brawijaya"
                              class="w-full rounded-xl border border-border-medium p-3 text-xs md:text-sm focus:border-primary-container focus:ring-1 focus:ring-primary-container"></textarea>
                    <span class="text-[11px] text-text-muted">Jelaskan nama sekolah, kampus, atau instansi penerima bila diperlukan.</span>
                </div>
            </div>
        @endif

        <!-- ==================== STEP 2: DATA PEMOHON ==================== -->
        @if ($currentStep === 2)
            <div class="space-y-6">
                <div class="border-b border-border-subtle pb-4">
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-brand-teal-light text-primary-container">
                        Langkah 2 dari 4
                    </span>
                    <h2 class="text-xl font-bold text-text-primary mt-2">
                        Data Identitas Pemohon
                    </h2>
                    <p class="text-xs text-text-secondary mt-1">
                        Masukkan data pemohon sesuai Kartu Tanda Penduduk (KTP) dan Kartu Keluarga (KK).
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs md:text-sm">
                    <!-- Nama Pemohon -->
                    <div class="space-y-1.5 md:col-span-2">
                        <label class="block font-bold text-text-primary">
                            Nama Lengkap Pemohon <span class="text-status-danger">*</span>
                        </label>
                        <input wire:model="applicant_name"
                               type="text"
                               placeholder="Nama lengkap sesuai KTP"
                               class="w-full rounded-xl border border-border-medium p-3 focus:border-primary-container focus:ring-1 focus:ring-primary-container">
                        @error('applicant_name')
                            <span class="text-xs text-status-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- NIK Pemohon -->
                    <div class="space-y-1.5">
                        <label class="block font-bold text-text-primary">
                            Nomor Induk Kependudukan (NIK 16 Digit) <span class="text-status-danger">*</span>
                        </label>
                        <input wire:model="applicant_nik"
                               type="text"
                               maxlength="16"
                               placeholder="3505xxxxxxxxxxxx"
                               class="w-full rounded-xl border border-border-medium p-3 font-mono tracking-wider focus:border-primary-container focus:ring-1 focus:ring-primary-container">
                        @error('applicant_nik')
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
                               placeholder="Contoh: RT 02 RW 01 Dusun Krajan"
                               class="w-full rounded-xl border border-border-medium p-3 focus:border-primary-container focus:ring-1 focus:ring-primary-container">
                        @error('address')
                            <span class="text-xs text-status-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- No HP/WhatsApp -->
                    <div class="space-y-1.5 md:col-span-2">
                        <label class="block font-bold text-text-primary">
                            Nomor WhatsApp / HP Aktif <span class="text-status-danger">*</span>
                        </label>
                        <input wire:model="phone"
                               type="text"
                               placeholder="Contoh: 081234567890"
                               class="w-full rounded-xl border border-border-medium p-3 focus:border-primary-container focus:ring-1 focus:ring-primary-container">
                        <span class="text-[11px] text-text-muted">Nomor ini digunakan untuk konfirmasi dan pengiriman informasi tiket.</span>
                        @error('phone')
                            <span class="text-xs text-status-danger block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        @endif

        <!-- ==================== STEP 3: ORANG YANG DITERANGKAN & BERKAS ==================== -->
        @if ($currentStep === 3)
            <div class="space-y-6">
                <div class="border-b border-border-subtle pb-4">
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-brand-teal-light text-primary-container">
                        Langkah 3 dari 4
                    </span>
                    <h2 class="text-xl font-bold text-text-primary mt-2">
                        Orang yang Diterangkan & Berkas Persyaratan
                    </h2>
                    <p class="text-xs text-text-secondary mt-1">
                        Tentukan untuk siapa surat ini diterbitkan dan unggah berkas KTP serta Kartu Keluarga.
                    </p>
                </div>

                <!-- Radio Pilihan Subjek -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-text-primary">
                        Siapa yang diterangkan dalam surat ini? <span class="text-status-danger">*</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <label class="p-3.5 rounded-xl border-2 cursor-pointer transition-all {{ $subject_type === 'diri_sendiri' ? 'border-primary-container bg-brand-teal-light/20' : 'border-border-subtle bg-white' }}">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-xs text-text-primary">Diri Sendiri</span>
                                <input wire:model.live="subject_type" type="radio" value="diri_sendiri" class="text-primary-container">
                            </div>
                            <span class="text-[11px] text-text-secondary block mt-1">Pemohon adalah orang yang diterangkan.</span>
                        </label>

                        <label class="p-3.5 rounded-xl border-2 cursor-pointer transition-all {{ $subject_type === 'keluarga_kk' ? 'border-primary-container bg-brand-teal-light/20' : 'border-border-subtle bg-white' }}">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-xs text-text-primary">Anggota Keluarga (1 KK)</span>
                                <input wire:model.live="subject_type" type="radio" value="keluarga_kk" class="text-primary-container">
                            </div>
                            <span class="text-[11px] text-text-secondary block mt-1">Anak kandung, pasangan, atau orang tua.</span>
                        </label>

                        <label class="p-3.5 rounded-xl border-2 cursor-pointer transition-all {{ $subject_type === 'orang_lain' ? 'border-primary-container bg-brand-teal-light/20' : 'border-border-subtle bg-white' }}">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-xs text-text-primary">Orang Lain / Kuasa</span>
                                <input wire:model.live="subject_type" type="radio" value="orang_lain" class="text-primary-container">
                            </div>
                            <span class="text-[11px] text-text-secondary block mt-1">Warga binaan, kerabat jauh, atau kuasa.</span>
                        </label>
                    </div>
                </div>

                <!-- Input Subjek -->
                <div class="p-4 rounded-2xl bg-surface-canvas border border-border-subtle space-y-4">
                    <h3 class="font-bold text-xs text-text-primary flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-primary-container text-base">badge</span>
                        <span>Identitas Warga yang Diterangkan</span>
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs md:text-sm">
                        <div class="space-y-1.5">
                            <label class="block font-bold text-text-primary">
                                Nama Lengkap yang Diterangkan <span class="text-status-danger">*</span>
                            </label>
                            <input wire:model="subject_name"
                                   type="text"
                                   placeholder="Nama lengkap sesuai KTP/KIA/Akta"
                                   class="w-full rounded-xl border border-border-medium p-3 bg-white focus:border-primary-container focus:ring-1 focus:ring-primary-container">
                            @error('subject_name')
                                <span class="text-xs text-status-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="block font-bold text-text-primary">
                                NIK yang Diterangkan <span class="text-status-danger">*</span>
                            </label>
                            <input wire:model="subject_nik"
                                   type="text"
                                   maxlength="16"
                                   placeholder="NIK 16 digit"
                                   class="w-full rounded-xl border border-border-medium p-3 bg-white font-mono tracking-wider focus:border-primary-container focus:ring-1 focus:ring-primary-container">
                            @error('subject_nik')
                                <span class="text-xs text-status-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="space-y-1.5 md:col-span-2">
                            <label class="block font-bold text-text-primary">
                                Hubungan dengan Pemohon <span class="text-status-danger">*</span>
                            </label>
                            <input wire:model="relationship_to_applicant"
                                   type="text"
                                   placeholder="Misal: Diri Sendiri, Anak Kandung, Orang Tua, Cucu"
                                   class="w-full rounded-xl border border-border-medium p-3 bg-white focus:border-primary-container focus:ring-1 focus:ring-primary-container">
                            @error('relationship_to_applicant')
                                <span class="text-xs text-status-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Unggah Berkas: KTP & KK -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                    <!-- KTP Upload -->
                    <div class="p-4 rounded-2xl border-2 border-dashed border-border-medium hover:border-primary-container transition-colors bg-surface-canvas text-center space-y-2">
                        <div class="w-10 h-10 rounded-full bg-brand-teal-light text-primary-container flex items-center justify-center mx-auto">
                            <span class="material-symbols-outlined text-xl">upload_file</span>
                        </div>
                        <div>
                            <span class="font-bold text-xs text-text-primary block">Unggah Foto / Scan KTP <span class="text-status-danger">*</span></span>
                            <span class="text-[11px] text-text-muted">JPG, PNG, atau PDF (maks. 2 MB)</span>
                        </div>
                        <input type="file" wire:model="ktp_file" accept=".jpg,.jpeg,.png,.pdf" class="text-xs mx-auto block">
                        <div wire:loading wire:target="ktp_file" class="text-xs text-primary-container">Mengunggah...</div>
                        @if ($ktp_file)
                            <div class="flex items-center justify-center gap-1.5 text-xs text-status-success font-semibold">
                                <span class="material-symbols-outlined text-sm">check_circle</span>
                                <span>{{ $ktp_file->getClientOriginalName() }}</span>
                            </div>
                        @endif
                        @error('ktp_file')
                            <span class="text-xs text-status-danger block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- KK Upload -->
                    <div class="p-4 rounded-2xl border-2 border-dashed border-border-medium hover:border-primary-container transition-colors bg-surface-canvas text-center space-y-2">
                        <div class="w-10 h-10 rounded-full bg-brand-teal-light text-primary-container flex items-center justify-center mx-auto">
                            <span class="material-symbols-outlined text-xl">upload_file</span>
                        </div>
                        <div>
                            <span class="font-bold text-xs text-text-primary block">Unggah Foto / Scan KK <span class="text-status-danger">*</span></span>
                            <span class="text-[11px] text-text-muted">JPG, PNG, atau PDF (maks. 2 MB)</span>
                        </div>
                        <input type="file" wire:model="kk_file" accept=".jpg,.jpeg,.png,.pdf" class="text-xs mx-auto block">
                        <div wire:loading wire:target="kk_file" class="text-xs text-primary-container">Mengunggah...</div>
                        @if ($kk_file)
                            <div class="flex items-center justify-center gap-1.5 text-xs text-status-success font-semibold">
                                <span class="material-symbols-outlined text-sm">check_circle</span>
                                <span>{{ $kk_file->getClientOriginalName() }}</span>
                            </div>
                        @endif
                        @error('kk_file')
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
                        Periksa kembali data dan berkas yang telah Anda isi sebelum mengirim permohonan.
                    </p>
                </div>

                <!-- Review Section 1: Tujuan -->
                <div class="p-4 rounded-2xl bg-surface-canvas border border-border-subtle flex items-start justify-between">
                    <div class="space-y-1">
                        <span class="text-[11px] font-bold text-text-muted uppercase tracking-wider block">Tujuan Penggunaan</span>
                        <h4 class="font-bold text-sm text-text-primary">{{ $selectedPurpose?->name ?? 'Surat Keterangan DTSEN' }}</h4>
                        @if($purpose_description)
                            <p class="text-xs text-text-secondary">{{ $purpose_description }}</p>
                        @endif
                    </div>
                    <button wire:click="goToStep(1)" type="button" class="text-xs font-bold text-primary-container hover:underline">
                        Ubah
                    </button>
                </div>

                <!-- Review Section 2: Data Pemohon -->
                <div class="p-4 rounded-2xl bg-surface-canvas border border-border-subtle flex items-start justify-between">
                    <div class="space-y-1">
                        <span class="text-[11px] font-bold text-text-muted uppercase tracking-wider block">Data Pemohon</span>
                        <h4 class="font-bold text-sm text-text-primary">{{ $applicant_name }} (NIK: {{ $applicant_nik }})</h4>
                        <p class="text-xs text-text-secondary">No. KK: {{ $family_card_number }} &bull; HP: {{ $phone }}</p>
                        <p class="text-xs text-text-secondary">Alamat: {{ $address }}, Ds. {{ $selectedVillage?->name }}, Kec. {{ $selectedDistrict?->name }}</p>
                    </div>
                    <button wire:click="goToStep(2)" type="button" class="text-xs font-bold text-primary-container hover:underline">
                        Ubah
                    </button>
                </div>

                <!-- Review Section 3: Subjek & Berkas -->
                <div class="p-4 rounded-2xl bg-surface-canvas border border-border-subtle flex items-start justify-between">
                    <div class="space-y-1">
                        <span class="text-[11px] font-bold text-text-muted uppercase tracking-wider block">Orang yang Diterangkan & Berkas</span>
                        <h4 class="font-bold text-sm text-text-primary">{{ $subject_name }} (Hubungan: {{ $relationship_to_applicant }})</h4>
                        <p class="text-xs text-text-secondary">NIK: {{ $subject_nik }}</p>
                        <div class="flex items-center gap-4 text-xs text-status-success pt-1 font-semibold">
                            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">check</span> KTP terunggah</span>
                            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">check</span> KK terunggah</span>
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
                            Saya menyatakan dengan sadar bahwa seluruh data dan dokumen yang saya unggah adalah benar dan sah. Saya bersedia dituntut secara hukum apabila memberikan keterangan palsu.
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
                    <span wire:loading.remove wire:target="submit">Kirim Pengajuan Sekarang</span>
                    <span wire:loading wire:target="submit">Memproses Permohonan...</span>
                </button>
            @endif
        </div>
    </div>
</div>
