<div class="max-w-4xl mx-auto px-4 md:px-8 py-8 md:py-12 space-y-8">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs text-text-secondary">
        <a href="{{ route('home') }}" class="hover:text-primary-container transition-colors" wire:navigate>Beranda</a>
        <span class="text-text-muted">/</span>
        <a href="{{ route('services.index') }}" class="hover:text-primary-container transition-colors" wire:navigate>Layanan Sosial</a>
        <span class="text-text-muted">/</span>
        <span class="text-primary-container font-semibold">Pengajuan Layanan</span>
    </nav>

    <!-- Page Title -->
    <div class="space-y-1">
        <h1 class="text-2xl md:text-3xl font-extrabold text-text-primary tracking-tight">
            Formulir Pengajuan Layanan Sosial
        </h1>
        <p class="text-xs md:text-sm text-text-secondary leading-relaxed">
            Permohonan rekomendasi bantuan sosial, pelayanan rehabilitasi sosial, dan layanan kesejahteraan masyarakat lainnya.
        </p>
    </div>

    <form wire:submit="submit" class="space-y-6">
        <!-- 1. Pilihan Jenis Layanan -->
        <div class="bg-white rounded-3xl border border-border-subtle p-6 md:p-8 shadow-xs space-y-4">
            <div class="flex items-center gap-2 text-primary-container">
                <span class="material-symbols-outlined text-2xl">category</span>
                <h2 class="text-lg font-bold text-text-primary">1. Pilih Jenis Layanan Sosial</h2>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-text-primary">
                    Jenis Layanan <span class="text-status-danger">*</span>
                </label>
                <select wire:model.live="service_type_id"
                        class="w-full rounded-xl border border-border-medium p-3 text-sm focus:border-primary-container focus:ring-1 focus:ring-primary-container">
                    <option value="">-- Pilih Jenis Layanan --</option>
                    @foreach ($services as $srv)
                        <option value="{{ $srv->id }}">{{ $srv->name }} ({{ $srv->category ?? 'Layanan' }})</option>
                    @endforeach
                </select>
                @error('service_type_id')
                    <span class="text-xs text-status-danger">{{ $message }}</span>
                @enderror
            </div>

            @if ($selectedService)
                <div class="p-4 rounded-2xl bg-brand-teal-light/20 border border-teal-200 space-y-2 text-xs">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-primary-container text-sm">{{ $selectedService->name }}</span>
                        @if($selectedService->sla_days)
                            <span class="text-text-muted">Estimasi: {{ $selectedService->sla_days }} hari kerja</span>
                        @endif
                    </div>
                    <p class="text-text-secondary leading-relaxed">{{ $selectedService->description }}</p>
                </div>
            @endif
        </div>

        <!-- 2. Data Pemohon -->
        <div class="bg-white rounded-3xl border border-border-subtle p-6 md:p-8 shadow-xs space-y-4">
            <div class="flex items-center gap-2 text-primary-container">
                <span class="material-symbols-outlined text-2xl">person</span>
                <h2 class="text-lg font-bold text-text-primary">2. Identitas Pemohon</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs md:text-sm">
                <div class="space-y-1.5 md:col-span-2">
                    <label class="block font-bold text-text-primary">
                        Nama Lengkap Pemohon <span class="text-status-danger">*</span>
                    </label>
                    <input wire:model="applicant_name"
                           type="text"
                           placeholder="Nama sesuai KTP"
                           class="w-full rounded-xl border border-border-medium p-3 focus:border-primary-container focus:ring-1 focus:ring-primary-container">
                    @error('applicant_name')
                        <span class="text-xs text-status-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block font-bold text-text-primary">
                        NIK Pemohon (16 Digit) <span class="text-status-danger">*</span>
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

                <div class="space-y-1.5 md:col-span-2">
                    <label class="block font-bold text-text-primary">
                        Alamat Lengkap <span class="text-status-danger">*</span>
                    </label>
                    <input wire:model="address"
                           type="text"
                           placeholder="RT/RW, Dusun/Jalan"
                           class="w-full rounded-xl border border-border-medium p-3 focus:border-primary-container focus:ring-1 focus:ring-primary-container">
                    @error('address')
                        <span class="text-xs text-status-danger">{{ $message }}</span>
                    @enderror
                </div>

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

                <div class="space-y-1.5 md:col-span-2">
                    <label class="block font-bold text-text-primary">
                        Keterangan Kebutuhan / Permohonan <span class="text-status-danger">*</span>
                    </label>
                    <textarea wire:model="description"
                              rows="4"
                              placeholder="Jelaskan secara ringkas maksud permohonan atau kondisi warga yang membutuhkan bantuan/pelayanan..."
                              class="w-full rounded-xl border border-border-medium p-3 focus:border-primary-container focus:ring-1 focus:ring-primary-container"></textarea>
                    @error('description')
                        <span class="text-xs text-status-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- 3. Berkas Persyaratan -->
        @if ($selectedService && $selectedService->serviceRequirements->isNotEmpty())
            <div class="bg-white rounded-3xl border border-border-subtle p-6 md:p-8 shadow-xs space-y-4">
                <div class="flex items-center gap-2 text-primary-container">
                    <span class="material-symbols-outlined text-2xl">attach_file</span>
                    <h2 class="text-lg font-bold text-text-primary">3. Unggah Dokumen Persyaratan</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($selectedService->serviceRequirements as $req)
                        <div class="p-4 rounded-2xl border-2 border-dashed border-border-medium hover:border-primary-container transition-colors bg-surface-canvas text-center space-y-2">
                            <div class="w-10 h-10 rounded-full bg-brand-teal-light text-primary-container flex items-center justify-center mx-auto">
                                <span class="material-symbols-outlined text-xl">upload_file</span>
                            </div>
                            <div>
                                <span class="font-bold text-xs text-text-primary block">
                                    {{ $req->name }}
                                    @if($req->is_mandatory)
                                        <span class="text-status-danger">*</span>
                                    @else
                                        <span class="text-text-muted">(Opsional)</span>
                                    @endif
                                </span>
                                <span class="text-[11px] text-text-muted">Maks. 2 MB ({{ strtoupper($req->allowed_mimes ?? 'PDF, JPG, PNG') }})</span>
                            </div>
                            <input type="file" wire:model="documents.{{ $req->id }}" class="text-xs mx-auto block">
                            @if (!empty($documents[$req->id]))
                                <div class="text-xs text-status-success font-semibold flex items-center justify-center gap-1">
                                    <span class="material-symbols-outlined text-sm">check_circle</span>
                                    <span>File terunggah</span>
                                </div>
                            @endif
                            @error('documents.'.$req->id)
                                <span class="text-xs text-status-danger block">{{ $message }}</span>
                            @enderror
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Consent & Submit -->
        <div class="bg-white rounded-3xl border border-border-subtle p-6 md:p-8 shadow-xs space-y-5">
            <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 space-y-2">
                <label class="flex items-start gap-3 cursor-pointer">
                    <input wire:model="consent" type="checkbox" class="w-4 h-4 text-primary-container rounded border-amber-400 focus:ring-primary-container mt-0.5">
                    <span class="text-xs text-amber-950 leading-relaxed font-medium">
                        Saya menyatakan bahwa seluruh data dan dokumen yang saya sampaikan adalah benar untuk diproses sesuai ketentuan pelayanan Dinas Sosial Kabupaten Blitar.
                    </span>
                </label>
                @error('consent')
                    <span class="text-xs text-status-danger block pl-7">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit"
                    wire:loading.attr="disabled"
                    class="w-full sm:w-auto px-8 py-3 rounded-xl bg-primary-container hover:bg-brand-teal-dark text-white font-bold text-xs flex items-center justify-center gap-2 transition-colors shadow-xs">
                <span wire:loading.remove wire:target="submit" class="material-symbols-outlined text-lg">send</span>
                <span wire:loading wire:target="submit" class="material-symbols-outlined animate-spin text-lg">progress_activity</span>
                <span wire:loading.remove wire:target="submit">Kirim Permohonan Layanan</span>
                <span wire:loading wire:target="submit">Memproses Permohonan...</span>
            </button>
        </div>
    </form>
</div>
