<div>
    <!-- 2. HERO SECTION -->
    <section class="relative overflow-hidden pt-10 pb-16 md:py-20 bg-gradient-to-b from-white via-surface-canvas to-surface-canvas border-b border-border-subtle">
        <!-- Atmospheric Civic Motif -->
        <div class="absolute -right-24 -top-24 w-96 h-96 rounded-full bg-brand-teal-light/40 blur-3xl pointer-events-none"></div>
        <div class="absolute -left-20 top-1/2 w-80 h-80 rounded-full bg-brand-amber-light/30 blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 md:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto space-y-4">
                <!-- Official Civic Badge -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-brand-teal-light border border-teal-200 text-primary-container text-xs font-semibold shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-status-success animate-pulse"></span>
                    <span>Portal Resmi Layanan Sosial Pemkab Blitar</span>
                </div>

                <!-- Headline -->
                <h1 class="text-3xl md:text-5xl font-extrabold text-text-primary tracking-tight leading-tight">
                    Satu Pintu Layanan Sosial Kabupaten Blitar
                </h1>

                <!-- Subheadline -->
                <p class="text-base md:text-lg text-text-secondary leading-relaxed max-w-2xl mx-auto">
                    Ajukan layanan, sampaikan pengaduan, dan pantau prosesnya secara online dengan nomor tiket resmi. Mudah, transparan, dan tanpa pungutan biaya.
                </p>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-2">
                    <a href="#layanan-prioritas"
                       class="w-full sm:w-auto min-h-[48px] px-6 py-3 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-900 font-bold text-sm flex items-center justify-center gap-2 shadow-sm transition-all focus:ring-4 focus:ring-amber-500/20">
                        <span class="material-symbols-outlined text-xl">add_circle</span>
                        <span>Ajukan Layanan</span>
                    </a>
                    <a href="{{ route('complaints.create') }}" wire:navigate
                       class="w-full sm:w-auto min-h-[48px] px-6 py-3 rounded-xl border-2 border-primary-container text-primary-container hover:bg-brand-teal-light/50 font-bold text-sm flex items-center justify-center gap-2 transition-all">
                        <span class="material-symbols-outlined text-xl">rate_review</span>
                        <span>Sampaikan Pengaduan</span>
                    </a>
                </div>

                <!-- Search Bar Container -->
                <div class="pt-6 max-w-2xl mx-auto">
                    <form wire:submit="searchServices" class="bg-white p-2 rounded-2xl border border-border-medium shadow-md flex flex-col sm:flex-row items-stretch gap-2">
                        <div class="flex items-center gap-2 px-3 flex-1">
                            <span class="material-symbols-outlined text-text-muted">search</span>
                            <input wire:model="search"
                                   type="text"
                                   class="w-full border-0 focus:ring-0 text-text-primary placeholder:text-text-muted text-sm p-1 bg-transparent"
                                   placeholder="Cari layanan, persyaratan, atau informasi...">
                        </div>
                        <button type="submit"
                                class="min-h-[44px] px-5 py-2.5 rounded-xl bg-primary-container hover:bg-brand-teal-dark text-white font-semibold text-sm flex items-center justify-center gap-1.5 transition-colors">
                            <span>Temukan</span>
                        </button>
                    </form>

                    <!-- Filter Chip Suggestions -->
                    <div class="flex items-center flex-wrap gap-2 pt-3 justify-center text-xs">
                        <span class="text-text-muted">Pencarian Populer:</span>
                        <a href="{{ route('services.dtsen') }}" wire:navigate class="px-3 py-1 rounded-full bg-white border border-border-subtle hover:border-primary-container text-text-secondary hover:text-primary-container transition-colors">
                            Surat DTSEN
                        </a>
                        <a href="{{ route('services.pbi') }}" wire:navigate class="px-3 py-1 rounded-full bg-white border border-border-subtle hover:border-primary-container text-text-secondary hover:text-primary-container transition-colors">
                            Reaktivasi BPJS/KIS
                        </a>
                        <a href="{{ route('services.rehsos') }}" wire:navigate class="px-3 py-1 rounded-full bg-white border border-border-subtle hover:border-primary-container text-text-secondary hover:text-primary-container transition-colors">
                            Rehabilitasi Sosial
                        </a>
                        <a href="{{ route('complaints.create') }}" wire:navigate class="px-3 py-1 rounded-full bg-white border border-border-subtle hover:border-primary-container text-text-secondary hover:text-primary-container transition-colors">
                            Pengaduan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. QUICK TICKET TRACK CARD SECTION -->
    <section class="max-w-7xl mx-auto px-4 md:px-8 -mt-8 relative z-20">
        <div class="bg-white rounded-2xl border border-border-subtle shadow-lg p-6 md:p-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="space-y-1 text-center md:text-left">
                    <div class="flex items-center justify-center md:justify-start gap-2 text-primary-container">
                        <span class="material-symbols-outlined text-2xl">travel_explore</span>
                        <h2 class="text-lg font-bold text-text-primary">Lacak Perkembangan Pengajuan / Pengaduan</h2>
                    </div>
                    <p class="text-xs text-text-secondary">
                        Masukkan nomor tiket untuk memantau status secara langsung tanpa perlu login.
                    </p>
                </div>

                <form wire:submit="quickTrack" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full md:w-auto">
                    <div class="relative">
                        <input wire:model="quickTicketNumber"
                               type="text"
                               placeholder="Nomor Tiket (mis. DTSEN-202610-00001)"
                               class="w-full sm:w-64 px-4 py-2.5 rounded-xl border border-border-medium focus:border-primary-container focus:ring-1 focus:ring-primary-container text-sm">
                        @error('quickTicketNumber')
                            <span class="absolute -bottom-5 left-1 text-[11px] text-status-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="relative">
                        <input wire:model="quickNik"
                               type="text"
                               maxlength="4"
                               placeholder="4 digit NIK/HP (opsional)"
                               class="w-full sm:w-48 px-4 py-2.5 rounded-xl border border-border-medium focus:border-primary-container focus:ring-1 focus:ring-primary-container text-sm">
                    </div>

                    <button type="submit"
                            class="px-6 py-2.5 rounded-xl bg-primary-container hover:bg-brand-teal-dark text-white font-semibold text-sm flex items-center justify-center gap-1.5 transition-colors shadow-xs">
                        <span class="material-symbols-outlined text-lg">search</span>
                        <span>Lacak Status</span>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- 4. LAYANAN PRIORITAS SECTION -->
    <section id="layanan-prioritas" class="max-w-7xl mx-auto px-4 md:px-8 py-16">
        <div class="space-y-3 mb-10 text-center md:text-left">
            <div class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-primary-container">
                <span class="w-1.5 h-1.5 rounded-full bg-primary-container"></span>
                <span>Prioritas Pelayanan Terpadu</span>
            </div>
            <h2 class="text-2xl md:text-3xl font-extrabold text-text-primary">
                Tiga Layanan Utama Terintegrasi
            </h2>
            <p class="text-sm text-text-secondary max-w-2xl">
                Layanan sosial yang paling sering diakses masyarakat Kabupaten Blitar kini dapat diajukan secara digital dengan kepastian waktu dan tahapan yang transparan.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Card 1: Surat Keterangan DTSEN -->
            <div class="bg-white rounded-2xl border border-border-subtle p-6 hover:shadow-lg transition-all flex flex-col justify-between group">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center group-hover:scale-105 transition-transform">
                            <span class="material-symbols-outlined text-2xl">assignment</span>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                            Prioritas 1
                        </span>
                    </div>

                    <h3 class="text-lg font-bold text-text-primary group-hover:text-primary-container transition-colors">
                        Surat Keterangan DTSEN
                    </h3>

                    <p class="text-xs text-text-secondary leading-relaxed">
                        Penerbitan surat keterangan peringkat desil Data Tunggal Sosial Ekonomi Nasional (DTSEN) untuk SPMB afirmasi, beasiswa PIP, KIP Kuliah, bansos, dan kesehatan.
                    </p>

                    <div class="border-t border-border-subtle pt-3 space-y-1.5 text-xs text-text-muted">
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm text-status-success">check_circle</span>
                            <span>Syarat: KTP & Kartu Keluarga (KK)</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm text-status-success">verified</span>
                            <span>Dilengkapi QR Code verifikasi keaslian</span>
                        </div>
                    </div>
                </div>

                <div class="pt-6 flex items-center gap-2">
                    <a href="{{ route('services.dtsen.apply') }}" wire:navigate
                       class="flex-1 py-2.5 px-4 rounded-xl bg-primary-container hover:bg-brand-teal-dark text-white font-semibold text-xs text-center transition-colors">
                        Ajukan Sekarang
                    </a>
                    <a href="{{ route('services.dtsen') }}" wire:navigate
                       class="py-2.5 px-3 rounded-xl border border-border-medium hover:bg-surface-subtle text-text-primary font-semibold text-xs text-center transition-colors">
                        Detail
                    </a>
                </div>
            </div>

            <!-- Card 2: Reaktivasi KIS / PBI-JK -->
            <div class="bg-white rounded-2xl border border-border-subtle p-6 hover:shadow-lg transition-all flex flex-col justify-between group">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center group-hover:scale-105 transition-transform">
                            <span class="material-symbols-outlined text-2xl">health_and_safety</span>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                            Prioritas 2
                        </span>
                    </div>

                    <h3 class="text-lg font-bold text-text-primary group-hover:text-primary-container transition-colors">
                        Reaktivasi KIS / PBI-JK
                    </h3>

                    <p class="text-xs text-text-secondary leading-relaxed">
                        Fasilitasi pengaktifan kembali kepesertaan JKN-KIS PBI-JK nonaktif bagi warga berpenyakit kronis, katastropik, kondisi darurat medis, atau bayi baru lahir.
                    </p>

                    <div class="border-t border-border-subtle pt-3 space-y-1.5 text-xs text-text-muted">
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm text-amber-600">emergency</span>
                            <span class="text-amber-800 font-semibold">Darurat medis diprioritaskan</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm text-status-success">sync_alt</span>
                            <span>Terhubung verifikasi Dinsos & Kemensos</span>
                        </div>
                    </div>
                </div>

                <div class="pt-6 flex items-center gap-2">
                    <a href="{{ route('services.pbi.apply') }}" wire:navigate
                       class="flex-1 py-2.5 px-4 rounded-xl bg-primary-container hover:bg-brand-teal-dark text-white font-semibold text-xs text-center transition-colors">
                        Ajukan Sekarang
                    </a>
                    <a href="{{ route('services.pbi') }}" wire:navigate
                       class="py-2.5 px-3 rounded-xl border border-border-medium hover:bg-surface-subtle text-text-primary font-semibold text-xs text-center transition-colors">
                        Detail
                    </a>
                </div>
            </div>

            <!-- Card 3: Pelayanan Rehabilitasi Sosial -->
            <div class="bg-white rounded-2xl border border-border-subtle p-6 hover:shadow-lg transition-all flex flex-col justify-between group">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center group-hover:scale-105 transition-transform">
                            <span class="material-symbols-outlined text-2xl">volunteer_activism</span>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                            Prioritas 3
                        </span>
                    </div>

                    <h3 class="text-lg font-bold text-text-primary group-hover:text-primary-container transition-colors">
                        Pelayanan Rehabilitasi Sosial
                    </h3>

                    <p class="text-xs text-text-secondary leading-relaxed">
                        Penanganan dan perlindungan bagi lansia terlantar, penyandang disabilitas, ODGJ terlantar, anak terlantar, serta korban tindak kekerasan.
                    </p>

                    <div class="border-t border-border-subtle pt-3 space-y-1.5 text-xs text-text-muted">
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm text-status-success">groups</span>
                            <span>Pelayanan langsung & rujukan panti/balai</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm text-status-success">lock</span>
                            <span>Jaminan kerahasiaan identitas klien</span>
                        </div>
                    </div>
                </div>

                <div class="pt-6 flex items-center gap-2">
                    <a href="{{ route('services.rehsos.apply') }}" wire:navigate
                       class="flex-1 py-2.5 px-4 rounded-xl bg-primary-container hover:bg-brand-teal-dark text-white font-semibold text-xs text-center transition-colors">
                        Ajukan Kasus
                    </a>
                    <a href="{{ route('services.rehsos') }}" wire:navigate
                       class="py-2.5 px-3 rounded-xl border border-border-medium hover:bg-surface-subtle text-text-primary font-semibold text-xs text-center transition-colors">
                        Detail
                    </a>
                </div>
            </div>
        </div>

        <!-- Secondary Row: Layanan Sosial Lainnya & Pengaduan -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <div class="bg-gradient-to-r from-teal-50/50 to-white rounded-2xl border border-teal-100 p-6 flex items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-teal-100 text-primary-container flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-2xl">folder_shared</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-text-primary">Layanan Sosial Lainnya</h4>
                        <p class="text-xs text-text-secondary">Rekomendasi bantuan sosial insidentil, surat keterangan umum, dan permohonan lainnya.</p>
                    </div>
                </div>
                <a href="{{ route('services.general.apply') }}" wire:navigate
                   class="px-4 py-2 rounded-xl bg-white border border-border-medium hover:bg-surface-subtle text-xs font-semibold text-primary-container shrink-0 transition-colors">
                    Pilih Layanan
                </a>
            </div>

            <div class="bg-gradient-to-r from-amber-50/50 to-white rounded-2xl border border-amber-100 p-6 flex items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-2xl">report_problem</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-text-primary">Pengaduan & Laporan Masalah Sosial</h4>
                        <p class="text-xs text-text-secondary">Laporkan warga yang butuh bantuan darurat, PMKS terlantar, atau ketidaktepatan sasaran bansos.</p>
                    </div>
                </div>
                <a href="{{ route('complaints.create') }}" wire:navigate
                   class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-900 text-xs font-bold shrink-0 transition-colors">
                    Buat Laporan
                </a>
            </div>
        </div>
    </section>

    <!-- 5. CARA KERJA SECTION -->
    <section class="bg-white border-y border-border-subtle py-16">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <div class="text-center max-w-2xl mx-auto space-y-2 mb-12">
                <div class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-primary-container">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary-container"></span>
                    <span>Alur Pelayanan Digital</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold text-text-primary">
                    Bagaimana SAPA SOSIAL Bekerja?
                </h2>
                <p class="text-xs text-text-secondary">
                    Hanya 4 langkah mudah untuk mendapatkan pelayanan sosial resmi tanpa antre di kantor dinas.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                <!-- Step 1 -->
                <div class="relative p-6 rounded-2xl bg-surface-canvas border border-border-subtle text-center space-y-3">
                    <div class="w-12 h-12 rounded-full bg-brand-teal-light text-primary-container font-extrabold text-lg flex items-center justify-center mx-auto">
                        1
                    </div>
                    <h3 class="font-bold text-sm text-text-primary">Pilih Layanan</h3>
                    <p class="text-xs text-text-secondary leading-relaxed">
                        Tentukan jenis layanan sosial yang Anda butuhkan dan pelajari persyaratan berkasnya.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="relative p-6 rounded-2xl bg-surface-canvas border border-border-subtle text-center space-y-3">
                    <div class="w-12 h-12 rounded-full bg-brand-teal-light text-primary-container font-extrabold text-lg flex items-center justify-center mx-auto">
                        2
                    </div>
                    <h3 class="font-bold text-sm text-text-primary">Isi Form & Berkas</h3>
                    <p class="text-xs text-text-secondary leading-relaxed">
                        Lengkapi formulir online dan unggah foto/dokumen persyaratan melalui HP atau komputer.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="relative p-6 rounded-2xl bg-surface-canvas border border-border-subtle text-center space-y-3">
                    <div class="w-12 h-12 rounded-full bg-brand-teal-light text-primary-container font-extrabold text-lg flex items-center justify-center mx-auto">
                        3
                    </div>
                    <h3 class="font-bold text-sm text-text-primary">Dapat Nomor Tiket</h3>
                    <p class="text-xs text-text-secondary leading-relaxed">
                        Sistem langsung menerbitkan nomor tiket resmi sebagai tanda bukti pengajuan Anda.
                    </p>
                </div>

                <!-- Step 4 -->
                <div class="relative p-6 rounded-2xl bg-surface-canvas border border-border-subtle text-center space-y-3">
                    <div class="w-12 h-12 rounded-full bg-brand-teal-light text-primary-container font-extrabold text-lg flex items-center justify-center mx-auto">
                        4
                    </div>
                    <h3 class="font-bold text-sm text-text-primary">Pantau & Unduh</h3>
                    <p class="text-xs text-text-secondary leading-relaxed">
                        Lacak posisi berkas secara real-time hingga surat/rekomendasi terbit dan dapat diunduh.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. CEK KEASLIAN SURAT BANNER -->
    <section class="max-w-7xl mx-auto px-4 md:px-8 py-16">
        <div class="bg-gradient-to-r from-primary-container to-brand-teal-dark rounded-3xl p-8 md:p-12 text-white shadow-xl relative overflow-hidden">
            <div class="absolute right-0 top-0 w-80 h-80 rounded-full bg-white/5 blur-2xl pointer-events-none"></div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center relative z-10">
                <div class="space-y-3">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-xs font-semibold">
                        <span class="material-symbols-outlined text-sm text-amber-300">verified_user</span>
                        <span>Verifikasi Dokumen Resmi</span>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-extrabold">
                        Pastikan Surat Keterangan DTSEN Anda Asli
                    </h2>
                    <p class="text-xs text-teal-100 leading-relaxed max-w-lg">
                        Surat Keterangan yang diterbitkan Dinas Sosial Kabupaten Blitar dilengkapi kode verifikasi dan QR Code resmi. Lembaga sekolah, kampus, dan instansi dapat memverifikasi keabsahannya seketika.
                    </p>
                </div>

                <div>
                    <form wire:submit="quickVerify" class="bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/20 space-y-3">
                        <label class="block text-xs font-semibold text-teal-50">
                            Masukkan Kode Verifikasi dari Surat:
                        </label>
                        <div class="flex items-center gap-2">
                            <input wire:model="verifyCode"
                                   type="text"
                                   placeholder="Contoh: VRF-202610-A9B8C"
                                   class="flex-1 px-4 py-2.5 rounded-xl bg-white text-text-primary text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 uppercase font-mono">
                            <button type="submit"
                                    class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-900 font-bold text-xs shrink-0 transition-colors shadow-sm">
                                Cek Keaslian
                            </button>
                        </div>
                        @error('verifyCode')
                            <span class="text-xs text-amber-300 block">{{ $message }}</span>
                        @enderror
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. INFO STRIP: JAM & KONTAK -->
    <section class="bg-surface-canvas border-b border-border-subtle py-8">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 text-xs">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-brand-teal-light text-primary-container flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-xl">schedule</span>
                    </div>
                    <div>
                        <span class="font-bold text-text-primary block">Jam Pelayanan</span>
                        <span class="text-text-secondary">Senin - Jumat: 08.00 - 15.30 WIB</span>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-brand-teal-light text-primary-container flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-xl">location_on</span>
                    </div>
                    <div>
                        <span class="font-bold text-text-primary block">Alamat Kantor</span>
                        <span class="text-text-secondary">Kanigoro, Kab. Blitar</span>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-brand-teal-light text-primary-container flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-xl">call</span>
                    </div>
                    <div>
                        <span class="font-bold text-text-primary block">Telepon Kantor</span>
                        <span class="text-text-secondary">(0342) 801123</span>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-brand-teal-light text-primary-container flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-xl">chat</span>
                    </div>
                    <div>
                        <span class="font-bold text-text-primary block">Konsultasi WhatsApp</span>
                        <span class="text-text-secondary">0812-3456-7890</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 8. FAQ ACCORDION & UNDUH FORMULIR -->
    <section class="max-w-7xl mx-auto px-4 md:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- FAQ Accordion -->
            <div class="lg:col-span-2 space-y-6">
                <div class="space-y-1">
                    <div class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-primary-container">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary-container"></span>
                        <span>Bantuan & Panduan</span>
                    </div>
                    <h2 class="text-2xl font-extrabold text-text-primary">
                        Pertanyaan yang Sering Diajukan
                    </h2>
                </div>

                <div class="space-y-3" x-data="{ active: null }">
                    @forelse ($faqs as $index => $faq)
                        <div class="bg-white rounded-xl border border-border-subtle overflow-hidden">
                            <button @click="active = active === {{ $index }} ? null : {{ $index }}"
                                    class="w-full px-5 py-4 text-left flex items-center justify-between gap-4 font-bold text-sm text-text-primary hover:text-primary-container transition-colors">
                                <span>{{ $faq->question }}</span>
                                <span class="material-symbols-outlined text-text-muted transition-transform"
                                      :class="{ 'rotate-180': active === {{ $index }} }">expand_more</span>
                            </button>
                            <div x-show="active === {{ $index }}"
                                 x-collapse
                                 class="px-5 pb-4 text-xs text-text-secondary leading-relaxed border-t border-border-subtle pt-3"
                                 style="display: none;">
                                {!! nl2br(e($faq->answer)) !!}
                            </div>
                        </div>
                    @empty
                        <div class="p-6 bg-white rounded-xl text-center text-xs text-text-muted">
                            Belum ada FAQ yang dipublikasikan.
                        </div>
                    @endforelse
                </div>

                <div>
                    <a href="{{ route('faq.index') }}" wire:navigate
                       class="inline-flex items-center gap-1.5 text-xs font-bold text-primary-container hover:underline">
                        <span>Lihat Semua Pertanyaan & Jawaban</span>
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>

                <!-- Download Blanko CTA Link (From Mockup) -->
                <div class="mt-6 text-center bg-white p-4 rounded-xl border border-dashed border-border-medium">
                    <p class="text-xs md:text-sm text-text-secondary">
                        Membutuhkan format surat pernyataan tidak mampu atau format pengantar desa?
                        <a href="{{ route('formulir.index') }}" wire:navigate
                           class="inline-flex items-center gap-1 text-primary-container hover:text-brand-teal-dark font-bold ml-1 transition-colors">
                            <span>Unduh Formulir &amp; Blanko Resmi</span>
                            <span class="material-symbols-outlined text-base">download</span>
                        </a>
                    </p>
                </div>
            </div>

            <!-- Downloadable Forms Widget -->
            <div class="space-y-6">
                <div class="space-y-1">
                    <div class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-primary-container">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary-container"></span>
                        <span>Dokumen Resmi</span>
                    </div>
                    <h2 class="text-xl font-extrabold text-text-primary">
                        Unduh Formulir Pelayanan
                    </h2>
                </div>

                <div class="bg-white rounded-2xl border border-border-subtle p-5 space-y-3 shadow-xs">
                    @forelse ($forms as $form)
                        <div class="p-3 rounded-xl bg-surface-canvas border border-border-subtle flex items-center justify-between gap-3">
                            <div class="flex items-center gap-2.5 overflow-hidden">
                                <span class="material-symbols-outlined text-primary-container text-xl shrink-0">description</span>
                                <div class="truncate">
                                    <span class="font-bold text-xs text-text-primary block truncate">{{ $form->name }}</span>
                                    <span class="text-[11px] text-text-muted">Versi {{ $form->version ?? 'Terbaru' }}</span>
                                </div>
                            </div>
                            <a href="{{ route('formulir.download', $form->id) }}"
                               class="p-2 rounded-lg bg-white border border-border-medium hover:bg-brand-teal-light text-primary-container shrink-0 transition-colors"
                               title="Unduh Formulir">
                                <span class="material-symbols-outlined text-base">download</span>
                            </a>
                        </div>
                    @empty
                        <p class="text-xs text-text-muted text-center py-4">Belum ada formulir unduhan.</p>
                    @endforelse

                    <div class="pt-2">
                        <a href="{{ route('formulir.index') }}" wire:navigate
                           class="w-full py-2.5 px-4 rounded-xl bg-surface-subtle hover:bg-brand-teal-light text-primary-container font-semibold text-xs text-center block transition-colors">
                            Lihat Semua Formulir
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
