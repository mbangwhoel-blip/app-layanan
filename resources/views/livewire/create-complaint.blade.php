<div class="max-w-7xl mx-auto px-4 md:px-8 py-8 md:py-12 space-y-8">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs text-text-secondary">
        <a href="{{ route('home') }}" class="hover:text-primary-container transition-colors" wire:navigate>Beranda</a>
        <span class="text-text-muted">/</span>
        <span class="text-primary-container font-semibold">Pengaduan Sosial</span>
    </nav>

    <div class="space-y-1">
        <div class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-amber-600">
            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
            <span>Kanal Pengaduan Warga</span>
        </div>
        <h1 class="text-2xl md:text-3xl font-extrabold text-text-primary tracking-tight">
            Pengaduan & Laporan Masalah Sosial
        </h1>
        <p class="text-xs md:text-sm text-text-secondary leading-relaxed max-w-3xl">
            Sampaikan laporan terkait permasalahan sosial di lingkungan Anda, seperti warga terlantar, lansia sebatang kara, penyandang disabilitas butuh bantuan, atau ketidaktepatan sasaran bansos.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Form (Left 2 cols) -->
        <div class="lg:col-span-2">
            <form wire:submit="submit" class="bg-white rounded-3xl border border-border-subtle p-6 md:p-8 shadow-xs space-y-6">
                <!-- 1. Kategori Masalah -->
                <div class="space-y-3">
                    <label class="block text-xs font-bold text-text-primary">
                        1. Kategori Permasalahan Sosial <span class="text-status-danger">*</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        @foreach ($categories as $cat)
                            <label class="p-3.5 rounded-xl border-2 cursor-pointer transition-all flex items-center justify-between {{ $complaint_category_id == $cat->id ? 'border-primary-container bg-brand-teal-light/20 shadow-xs' : 'border-border-subtle bg-white hover:border-border-medium' }}">
                                <span class="text-xs font-bold {{ $complaint_category_id == $cat->id ? 'text-primary-container' : 'text-text-primary' }}">
                                    {{ $cat->name }}
                                </span>
                                <input wire:model.live="complaint_category_id"
                                       type="radio"
                                       name="cat"
                                       value="{{ $cat->id }}"
                                       class="w-4 h-4 text-primary-container border-border-medium focus:ring-primary-container">
                            </label>
                        @endforeach
                    </div>
                    @error('complaint_category_id')
                        <span class="text-xs text-status-danger block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- 2. Lokasi Kejadian -->
                <div class="space-y-3 pt-3 border-t border-border-subtle">
                    <label class="block text-xs font-bold text-text-primary flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-primary-container text-base">location_on</span>
                        <span>2. Lokasi Kejadian Masalah Sosial</span>
                    </label>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs md:text-sm">
                        <div class="space-y-1">
                            <label class="font-semibold text-text-primary">Kecamatan <span class="text-status-danger">*</span></label>
                            <select wire:model.live="district_id"
                                    class="w-full rounded-xl border border-border-medium p-2.5 focus:border-primary-container focus:ring-1 focus:ring-primary-container">
                                <option value="">-- Pilih Kecamatan --</option>
                                @foreach ($districts as $district)
                                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                                @endforeach
                            </select>
                            @error('district_id')
                                <span class="text-xs text-status-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="space-y-1">
                            <label class="font-semibold text-text-primary">Desa / Kelurahan <span class="text-status-danger">*</span></label>
                            <select wire:model="village_id"
                                    class="w-full rounded-xl border border-border-medium p-2.5 focus:border-primary-container focus:ring-1 focus:ring-primary-container"
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

                        <div class="space-y-1 sm:col-span-2">
                            <label class="font-semibold text-text-primary">Detail Alamat / Patokan Lokasi <span class="text-status-danger">*</span></label>
                            <input wire:model="location_detail"
                                   type="text"
                                   placeholder="Contoh: Depan Pasar Wlingi RT 02 RW 01, dekat pos ronda..."
                                   class="w-full rounded-xl border border-border-medium p-2.5 focus:border-primary-container focus:ring-1 focus:ring-primary-container">
                            @error('location_detail')
                                <span class="text-xs text-status-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- 3. Uraian Masalah -->
                <div class="space-y-2 pt-3 border-t border-border-subtle">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-bold text-text-primary">
                            3. Uraian Masalah yang Dilaporkan <span class="text-status-danger">*</span>
                        </label>
                        <span class="text-[11px] text-text-muted">{{ strlen($description) }} / 2000 karakter</span>
                    </div>
                    <textarea wire:model.live="description"
                              rows="5"
                              placeholder="Ceritakan kondisi permasalahan secara jelas: siapa yang bersangkutan, kondisi saat ini, kebutuhan mendesak yang diperlukan, dll..."
                              class="w-full rounded-xl border border-border-medium p-3 text-xs md:text-sm focus:border-primary-container focus:ring-1 focus:ring-primary-container"></textarea>
                    @error('description')
                        <span class="text-xs text-status-danger block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- 4. Unggah Foto / Dokumen Bukti -->
                <div class="space-y-2 pt-3 border-t border-border-subtle">
                    <label class="block text-xs font-bold text-text-primary flex items-center justify-between">
                        <span>4. Foto / Dokumen Pendukung (Opsional)</span>
                        <span class="text-[11px] text-text-muted font-normal">Maks. 5 MB per file (JPG, PNG, PDF)</span>
                    </label>

                    <div class="p-4 rounded-2xl border-2 border-dashed border-border-medium hover:border-primary-container transition-colors bg-surface-canvas text-center space-y-2">
                        <span class="material-symbols-outlined text-primary-container text-2xl">add_photo_alternate</span>
                        <p class="text-xs text-text-secondary">Foto lokasi kejadian atau kondisi warga sangat membantu percepatan verifikasi petugas lapangan.</p>
                        <input type="file" wire:model="attachments" multiple accept=".jpg,.jpeg,.png,.pdf" class="text-xs mx-auto block">
                        <div wire:loading wire:target="attachments" class="text-xs text-primary-container">Mengunggah file...</div>
                        @if (!empty($attachments))
                            <div class="text-xs text-status-success font-semibold pt-1">
                                {{ count($attachments) }} file terpilih
                            </div>
                        @endif
                    </div>
                </div>

                <!-- 5. Identitas Pelapor -->
                <div class="space-y-3 pt-3 border-t border-border-subtle">
                    <div class="space-y-0.5">
                        <label class="block text-xs font-bold text-text-primary">
                            5. Identitas Pelapor
                        </label>
                        <p class="text-[11px] text-text-muted">Data pelapor dijamin kerahasiaannya dan hanya digunakan petugas untuk konfirmasi.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs md:text-sm">
                        <div class="space-y-1">
                            <label class="font-semibold text-text-primary">Nama Lengkap Pelapor <span class="text-status-danger">*</span></label>
                            <input wire:model="reporter_name"
                                   type="text"
                                   placeholder="Nama Anda"
                                   class="w-full rounded-xl border border-border-medium p-2.5 focus:border-primary-container focus:ring-1 focus:ring-primary-container">
                            @error('reporter_name')
                                <span class="text-xs text-status-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="space-y-1">
                            <label class="font-semibold text-text-primary">Nomor WhatsApp / HP <span class="text-status-danger">*</span></label>
                            <input wire:model="reporter_phone"
                                   type="text"
                                   placeholder="Contoh: 081234567890"
                                   class="w-full rounded-xl border border-border-medium p-2.5 focus:border-primary-container focus:ring-1 focus:ring-primary-container">
                            @error('reporter_phone')
                                <span class="text-xs text-status-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Consent Checkbox & Submit -->
                <div class="space-y-4 pt-3 border-t border-border-subtle">
                    <div class="p-3.5 rounded-2xl bg-amber-50 border border-amber-200">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input wire:model="consent" type="checkbox" class="w-4 h-4 text-primary-container rounded border-amber-400 focus:ring-primary-container mt-0.5">
                            <span class="text-xs text-amber-950 leading-relaxed font-medium">
                                Saya menyatakan bahwa pengaduan ini disampaikan dengan itikad baik dan berdasarkan informasi yang dapat dipertanggungjawabkan kebenarannya.
                            </span>
                        </label>
                        @error('consent')
                            <span class="text-xs text-status-danger block pl-7">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit"
                            wire:loading.attr="disabled"
                            class="w-full sm:w-auto px-8 py-3 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-900 font-bold text-xs flex items-center justify-center gap-2 transition-colors shadow-sm focus:ring-4 focus:ring-amber-500/20">
                        <span wire:loading.remove wire:target="submit" class="material-symbols-outlined text-lg">send</span>
                        <span wire:loading wire:target="submit" class="material-symbols-outlined animate-spin text-lg">progress_activity</span>
                        <span wire:loading.remove wire:target="submit">Kirim Laporan Pengaduan</span>
                        <span wire:loading wire:target="submit">Mengirim Pengaduan...</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Sidebar Guidance (Right 1 col) -->
        <div class="space-y-6">
            <!-- Process Step Card -->
            <div class="bg-white rounded-3xl border border-border-subtle p-6 space-y-4 shadow-xs">
                <h3 class="font-bold text-sm text-text-primary flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary-container text-xl">route</span>
                    <span>Alur Penanganan Laporan</span>
                </h3>
                <div class="space-y-3 text-xs text-text-secondary border-l-2 border-teal-200 pl-4 ml-2">
                    <div class="relative">
                        <span class="font-bold text-text-primary block">1. Laporan Diterima</span>
                        <span>Sistem otomatis menerbitkan nomor tiket pengaduan resmi (ADU-...).</span>
                    </div>
                    <div class="relative">
                        <span class="font-bold text-text-primary block">2. Verifikasi Awal</span>
                        <span>Petugas memeriksa kejelasan lokasi dan permasalahan.</span>
                    </div>
                    <div class="relative">
                        <span class="font-bold text-text-primary block">3. Disposisi & Lapangan</span>
                        <span>Diteruskan ke bidang terkait / TKSK / Pendamping Rehsos di kecamatan.</span>
                    </div>
                    <div class="relative">
                        <span class="font-bold text-text-primary block">4. Penanganan & Selesai</span>
                        <span>Tindakan sosial dilakukan dan bukti penanganan dicatat.</span>
                    </div>
                </div>
            </div>

            <!-- Privacy Guarantee Card -->
            <div class="bg-brand-teal-light/20 rounded-3xl border border-teal-200 p-6 space-y-3">
                <div class="flex items-center gap-2 text-primary-container">
                    <span class="material-symbols-outlined text-xl">security</span>
                    <h3 class="font-bold text-sm text-text-primary">Jaminan Kerahasiaan</h3>
                </div>
                <p class="text-xs text-text-secondary leading-relaxed">
                    Identitas pelapor dilindungi dan tidak akan dipublikasikan ke pihak luar. Kami mengutamakan keamanan dan kenyamanan pelapor demi kepedulian sosial bersama.
                </p>
            </div>

            <!-- Emergency Contact -->
            <div class="bg-surface-canvas rounded-3xl border border-border-subtle p-6 space-y-3 text-xs">
                <h4 class="font-bold text-text-primary">Kondisi Darurat Nyawa?</h4>
                <p class="text-text-secondary">Jika memerlukan penanganan medis atau evakuasi darurat segera, hubungi Call Center Darurat Pemkab Blitar atau PSC 119.</p>
            </div>
        </div>
    </div>
</div>
