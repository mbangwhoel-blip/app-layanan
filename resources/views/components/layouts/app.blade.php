<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SAPA SOSIAL — Satu Pintu Layanan Sosial Kabupaten Blitar. Ajukan layanan sosial, sampaikan pengaduan, dan pantau status permohonan Anda secara transparan.">
    <title>{{ $title ?? 'SAPA SOSIAL — Satu Pintu Layanan Sosial Kabupaten Blitar' }}</title>

    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Material Symbols Outlined -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body {
            font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
            background-color: #F8FAFC;
            color: #0F172A;
            -webkit-font-smoothing: antialiased;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            vertical-align: middle;
            line-height: 1;
        }
    </style>
</head>
<body class="bg-surface-canvas text-text-primary min-h-screen flex flex-col font-sans selection:bg-brand-teal-light selection:text-primary-container"
      x-data="{ mobileMenuOpen: false }">

    <!-- 1. STICKY TOP APP BAR -->
    <header class="bg-white/95 backdrop-blur-md border-b border-border-subtle shadow-xs sticky top-0 z-50 transition-colors duration-200">
        <div class="flex justify-between items-center w-full px-4 md:px-8 max-w-7xl mx-auto h-16">
            <!-- Brand & Leading Icon -->
            <a class="flex items-center gap-3 group focus:outline-none" href="{{ route('home') }}" wire:navigate>
                <div class="w-10 h-10 rounded-xl bg-brand-teal-light text-primary flex items-center justify-center shrink-0 shadow-xs group-hover:scale-105 transition-transform">
                    <span class="material-symbols-outlined text-2xl text-primary-container">account_balance</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-lg font-bold text-primary-container leading-tight">SAPA SOSIAL</span>
                    <span class="text-xs text-text-secondary tracking-wide">Dinas Sosial Kab. Blitar</span>
                </div>
            </a>

            <!-- Desktop Nav -->
            <nav class="hidden md:flex items-center gap-6">
                <a class="{{ request()->routeIs('home') ? 'text-primary-container font-bold border-b-2 border-primary-container pb-0.5' : 'text-text-secondary font-medium hover:text-primary-container' }} text-sm transition-colors"
                   href="{{ route('home') }}" wire:navigate>
                    Beranda
                </a>
                <a class="{{ request()->routeIs('services.*') ? 'text-primary-container font-bold border-b-2 border-primary-container pb-0.5' : 'text-text-secondary font-medium hover:text-primary-container' }} text-sm transition-colors"
                   href="{{ route('services.index') }}" wire:navigate>
                    Layanan
                </a>
                <a class="{{ request()->routeIs('complaints.*') ? 'text-primary-container font-bold border-b-2 border-primary-container pb-0.5' : 'text-text-secondary font-medium hover:text-primary-container' }} text-sm transition-colors"
                   href="{{ route('complaints.create') }}" wire:navigate>
                    Pengaduan
                </a>
                <a class="{{ request()->routeIs('ticket.*') ? 'text-primary-container font-bold border-b-2 border-primary-container pb-0.5' : 'text-text-secondary font-medium hover:text-primary-container' }} text-sm transition-colors"
                   href="{{ route('ticket.track') }}" wire:navigate>
                    Cek Status
                </a>
                <a class="{{ request()->routeIs('certificate.*') ? 'text-primary-container font-bold border-b-2 border-primary-container pb-0.5' : 'text-text-secondary font-medium hover:text-primary-container' }} text-sm transition-colors"
                   href="{{ route('certificate.verify') }}" wire:navigate>
                    Verifikasi Surat
                </a>
                <a class="{{ request()->routeIs('faq.*') ? 'text-primary-container font-bold border-b-2 border-primary-container pb-0.5' : 'text-text-secondary font-medium hover:text-primary-container' }} text-sm transition-colors"
                   href="{{ route('faq.index') }}" wire:navigate>
                    FAQ
                </a>
            </nav>

            <!-- Trailing Action -->
            <div class="flex items-center gap-3">
                <a class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-surface-subtle text-primary-container font-semibold text-sm hover:bg-brand-teal-light transition-colors"
                   href="{{ route('ticket.track') }}" wire:navigate>
                    <span class="material-symbols-outlined text-base">travel_explore</span>
                    <span>Lacak Tiket</span>
                </a>
                <a class="hidden sm:inline-flex items-center justify-center px-4 py-2 rounded-lg bg-primary-container text-white font-semibold text-sm hover:bg-brand-teal-dark transition-colors shadow-xs"
                   href="{{ url('/admin/login') }}">
                    <span>Masuk Petugas</span>
                </a>

                <!-- Mobile Hamburger Toggle -->
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                        type="button"
                        aria-label="Buka Menu"
                        class="md:hidden p-2 rounded-lg text-text-secondary hover:text-primary-container hover:bg-surface-subtle transition-colors focus:outline-none">
                    <span class="material-symbols-outlined text-2xl" x-show="!mobileMenuOpen">menu</span>
                    <span class="material-symbols-outlined text-2xl" x-show="mobileMenuOpen" style="display: none;">close</span>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Drawer -->
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden border-t border-border-subtle bg-white px-4 pt-3 pb-6 shadow-xl"
             style="display: none;">
            <div class="flex flex-col gap-2">
                <a class="px-3 py-2.5 rounded-lg {{ request()->routeIs('home') ? 'bg-brand-teal-light text-primary-container font-semibold' : 'text-text-secondary hover:bg-surface-subtle' }} text-sm"
                   href="{{ route('home') }}" @click="mobileMenuOpen = false" wire:navigate>
                    Beranda
                </a>
                <a class="px-3 py-2.5 rounded-lg {{ request()->routeIs('services.*') ? 'bg-brand-teal-light text-primary-container font-semibold' : 'text-text-secondary hover:bg-surface-subtle' }} text-sm"
                   href="{{ route('services.index') }}" @click="mobileMenuOpen = false" wire:navigate>
                    Layanan Sosial
                </a>
                <a class="px-3 py-2.5 rounded-lg {{ request()->routeIs('complaints.*') ? 'bg-brand-teal-light text-primary-container font-semibold' : 'text-text-secondary hover:bg-surface-subtle' }} text-sm"
                   href="{{ route('complaints.create') }}" @click="mobileMenuOpen = false" wire:navigate>
                    Pengaduan Sosial
                </a>
                <a class="px-3 py-2.5 rounded-lg {{ request()->routeIs('ticket.*') ? 'bg-brand-teal-light text-primary-container font-semibold' : 'text-text-secondary hover:bg-surface-subtle' }} text-sm"
                   href="{{ route('ticket.track') }}" @click="mobileMenuOpen = false" wire:navigate>
                    Cek Status Tiket
                </a>
                <a class="px-3 py-2.5 rounded-lg {{ request()->routeIs('certificate.*') ? 'bg-brand-teal-light text-primary-container font-semibold' : 'text-text-secondary hover:bg-surface-subtle' }} text-sm"
                   href="{{ route('certificate.verify') }}" @click="mobileMenuOpen = false" wire:navigate>
                    Verifikasi Surat
                </a>
                <a class="px-3 py-2.5 rounded-lg {{ request()->routeIs('faq.*') ? 'bg-brand-teal-light text-primary-container font-semibold' : 'text-text-secondary hover:bg-surface-subtle' }} text-sm"
                   href="{{ route('faq.index') }}" @click="mobileMenuOpen = false" wire:navigate>
                    FAQ
                </a>

                <div class="pt-3 border-t border-border-subtle flex flex-col gap-2">
                    <a class="w-full flex items-center justify-center gap-2 py-2.5 rounded-lg bg-surface-subtle text-primary-container font-semibold text-sm"
                       href="{{ route('ticket.track') }}" @click="mobileMenuOpen = false" wire:navigate>
                        <span class="material-symbols-outlined text-base">travel_explore</span>
                        <span>Lacak Status Tiket</span>
                    </a>
                    <a class="w-full py-2.5 rounded-lg bg-primary-container text-white font-semibold text-sm text-center"
                       href="{{ url('/admin/login') }}">
                        <span>Masuk Petugas / Admin</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Global Flash Alerts -->
    @if (session()->has('success'))
        <div class="max-w-7xl mx-auto px-4 md:px-8 mt-4 w-full">
            <div class="bg-status-success-light border border-status-success text-status-success px-4 py-3 rounded-xl flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-xl">check_circle</span>
                    <span class="text-sm font-semibold">{{ session('success') }}</span>
                </div>
                <button type="button" @click="$el.parentElement.remove()" class="text-status-success hover:opacity-75">
                    <span class="material-symbols-outlined text-lg">close</span>
                </button>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="max-w-7xl mx-auto px-4 md:px-8 mt-4 w-full">
            <div class="bg-status-danger-light border border-status-danger text-status-danger px-4 py-3 rounded-xl flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-xl">error</span>
                    <span class="text-sm font-semibold">{{ session('error') }}</span>
                </div>
                <button type="button" @click="$el.parentElement.remove()" class="text-status-danger hover:opacity-75">
                    <span class="material-symbols-outlined text-lg">close</span>
                </button>
            </div>
        </div>
    @endif

    <!-- MAIN BODY -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-border-subtle mt-16 text-text-secondary">
        <div class="max-w-7xl mx-auto px-4 md:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Col 1: Brand & Dinas Info -->
                <div class="space-y-4 md:col-span-1">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-brand-teal-light text-primary-container flex items-center justify-center font-bold">
                            <span class="material-symbols-outlined text-xl">account_balance</span>
                        </div>
                        <span class="font-bold text-base text-text-primary">SAPA SOSIAL</span>
                    </div>
                    <p class="text-xs leading-relaxed text-text-secondary">
                        Satu Pintu Layanan Sosial Dinas Sosial Pemerintah Kabupaten Blitar. Melayani masyarakat dengan transparan, akuntabel, dan terpercaya.
                    </p>
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-brand-teal-light text-primary-container text-xs font-semibold">
                        <span class="w-2 h-2 rounded-full bg-status-success animate-pulse"></span>
                        <span>Setiap Tahap Tercatat & Terlacak</span>
                    </div>
                </div>

                <!-- Col 2: Layanan Prioritas -->
                <div class="space-y-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-text-primary">Layanan Prioritas</h3>
                    <ul class="space-y-2 text-xs">
                        <li>
                            <a href="{{ route('services.dtsen') }}" class="hover:text-primary-container transition-colors" wire:navigate>
                                Surat Keterangan DTSEN
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('services.pbi') }}" class="hover:text-primary-container transition-colors" wire:navigate>
                                Reaktivasi KIS / PBI-JK
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('services.rehsos') }}" class="hover:text-primary-container transition-colors" wire:navigate>
                                Pelayanan Rehabilitasi Sosial
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('complaints.create') }}" class="hover:text-primary-container transition-colors" wire:navigate>
                                Pengaduan & Laporan Sosial
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Col 3: Informasi & Tautan -->
                <div class="space-y-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-text-primary">Akses Cepat</h3>
                    <ul class="space-y-2 text-xs">
                        <li>
                            <a href="{{ route('ticket.track') }}" class="hover:text-primary-container transition-colors" wire:navigate>
                                Cek Status Tiket Layanan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('certificate.verify') }}" class="hover:text-primary-container transition-colors" wire:navigate>
                                Verifikasi Keaslian Surat (QR)
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('faq.index') }}" class="hover:text-primary-container transition-colors" wire:navigate>
                                Pertanyaan Umum (FAQ)
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('formulir.index') }}" class="hover:text-primary-container transition-colors" wire:navigate>
                                Unduh Formulir Pelayanan
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/admin/login') }}" class="hover:text-primary-container transition-colors">
                                Portal Petugas & Admin
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Col 4: Kontak & Alamat -->
                <div class="space-y-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-text-primary">Kontak Dinas Sosial</h3>
                    <div class="space-y-2 text-xs">
                        <p class="flex items-start gap-2">
                            <span class="material-symbols-outlined text-sm text-text-muted mt-0.5">location_on</span>
                            <span>Jl. Raya Barat No. 1, Kanigoro, Kec. Kanigoro, Kabupaten Blitar, Jawa Timur 66171</span>
                        </p>
                        <p class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm text-text-muted">schedule</span>
                            <span>Senin – Jumat, 08.00 – 15.30 WIB</span>
                        </p>
                        <p class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm text-text-muted">phone</span>
                            <span>(0342) 801123</span>
                        </p>
                        <p class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm text-text-muted">chat</span>
                            <span>WhatsApp: 0812-3456-7890</span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="border-t border-border-subtle mt-10 pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-text-muted gap-4">
                <p>&copy; {{ date('Y') }} Dinas Sosial Kabupaten Blitar. Seluruh hak cipta dilindungi undang-undang.</p>
                <p class="flex items-center gap-1">
                    <span>Dikembangkan untuk kemaslahatan masyarakat Blitar</span>
                </p>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
