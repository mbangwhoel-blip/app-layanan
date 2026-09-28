# Prompt Google Stitch — Portal Publik SAPA SOSIAL

**SAPA SOSIAL — Satu Pintu Layanan Sosial Kabupaten Blitar**
Sumber: `PRD_SAPA_SOSIAL.md` · Cakupan: Portal Publik (`/`), bukan panel admin Filament.
Tool: https://stitch.withgoogle.com

---

## Cara Pakai

1. Jalankan **Prompt 1 (Beranda)** lebih dulu untuk mengunci gaya visual.
2. Untuk halaman 2 dan seterusnya, ganti `[Prompt Awalan]` dengan blok **Prompt Awalan** di bawah, lalu tempel prompt halaman setelahnya.
3. Satu prompt = satu layar. Jalankan di project Stitch yang sama agar warna, font, header, dan footer konsisten.
4. Gunakan mode **Mobile** lebih dulu, lalu buat varian **Desktop**.
5. Untuk revisi kecil, edit per elemen (mis. "Make the hero CTA larger"), jangan ulang seluruh prompt.

**Urutan pengerjaan yang disarankan (alur inti masyarakat):** 1 → 3 → 6 → 9 → 11 → 12 → 14 → 16, lalu halaman lainnya.

---

## Prompt Awalan

Tempel di depan setiap prompt halaman 2 dst. (menggantikan `[Prompt Awalan]`).

```
Using the exact same design system as the SAPA SOSIAL homepage (deep teal #0F766E primary, amber #F59E0B accent for main CTAs, off-white #F8FAFC background, white rounded-2xl cards with subtle shadows, Plus Jakarta Sans font, min 16px body text, 44px tap targets, WCAG AA contrast, Lucide-style line icons), and the same sticky header and footer, design the following page. Mobile-first and responsive. ALL UI TEXT IN INDONESIAN. Public portal of Dinas Sosial Kabupaten Blitar.
```

---

## 1. Beranda

```
Design a mobile-first, fully responsive web homepage for "SAPA SOSIAL — Satu Pintu Layanan Sosial Kabupaten Blitar", a public social-services portal run by Dinas Sosial Kabupaten Blitar, Indonesia. Users are ordinary citizens (many on mid-range phones, some elderly or low digital literacy), so the UI must be extremely clear, trustworthy, and easy to scan.

ALL UI TEXT MUST BE IN INDONESIAN.

Visual style: clean modern Indonesian government-service look, friendly but credible. Primary color deep teal (#0F766E), secondary warm amber accent (#F59E0B) for key calls to action, soft off-white background (#F8FAFC), white cards with rounded-2xl corners and subtle shadows. Font: Plus Jakarta Sans or Inter. Large readable body text (min 16px), generous spacing, high contrast (WCAG AA), large tap targets (min 44px). Simple line icons (Lucide/Heroicons style). No stock-photo clutter; use flat illustrations sparingly. Compatible with Tailwind CSS.

Sections, top to bottom:
1. Sticky header: logo placeholder + "SAPA SOSIAL" / "Dinas Sosial Kab. Blitar", nav (Beranda, Layanan, Pengaduan, Cek Status, Verifikasi Surat, FAQ), and a "Masuk" button. Collapses to hamburger on mobile.
2. Hero: headline "Satu Pintu Layanan Sosial Kabupaten Blitar", subheadline "Ajukan layanan, sampaikan pengaduan, dan pantau prosesnya online dengan nomor tiket." Two buttons: "Ajukan Layanan" (amber) and "Sampaikan Pengaduan" (outline). Below it a prominent search bar "Cari layanan, persyaratan, atau informasi…".
3. "Cek Status Tiket" quick card: inputs for Nomor Tiket (placeholder DTSEN-202610-00012) and 4 digit terakhir NIK/No. HP, button "Lacak".
4. "Layanan Prioritas" — 3 large cards with icon, short description, and "Ajukan" button: Surat Keterangan DTSEN (untuk SPMB, PIP, KIP Kuliah, bansos, kesehatan); Reaktivasi KIS/PBI-JK; Pelayanan Rehabilitasi Sosial. Plus a smaller row of cards: Layanan Sosial Lainnya, Pengaduan Sosial.
5. "Cara Kerja" — 4-step horizontal stepper: Pilih Layanan → Isi Formulir & Unggah Berkas → Dapatkan Nomor Tiket → Pantau Status.
6. "Cek Keaslian Surat" banner: input kode verifikasi + tombol scan QR, teks "Pastikan Surat Keterangan DTSEN Anda asli."
7. Info strip: jam pelayanan, alamat kantor, kontak, WhatsApp.
8. FAQ accordion (4 items) and "Unduh Formulir" list.
9. Footer: Dinas Sosial Kabupaten Blitar, links, copyright.
Include a small trust element: "Setiap tahap tercatat dan dapat ditelusuri".
```

---

## 2. Daftar & Pencarian Informasi Layanan

```
[Prompt Awalan]

Page "Informasi Layanan". Page title and short intro. Search bar with keyword input. Category filter chips: Semua, DTSEN, KIS/PBI-JK, Rehabilitasi Sosial, Disabilitas, Lansia, Pengaduan. Grid of service/information cards (icon, title, 2-line description, category badge, "Lihat Detail" link). A section "Paling Sering Dicari" with keyword chips. Empty state for no results ("Informasi tidak ditemukan, coba kata kunci lain") with buttons to Pengajuan and Pengaduan. Pagination or "Muat lebih banyak".
```

---

## 3. Detail Layanan — Surat Keterangan DTSEN

```
[Prompt Awalan]

Service detail page "Surat Keterangan DTSEN". Breadcrumb (Beranda > Layanan > Surat Keterangan DTSEN). Hero card with short explanation: surat keterangan status Data Tunggal Sosial Ekonomi Nasional, dipakai untuk SPMB jalur afirmasi, PIP, KIP Kuliah, bansos, dan layanan kesehatan. Sections: Persyaratan (checklist: KTP, KK), Tujuan Penggunaan (chips), Alur Pelayanan (vertical timeline of 9 steps: pilih layanan, isi data & unggah berkas, tiket dibuat, pemeriksaan berkas, pengecekan data, draf surat, persetujuan pejabat, surat terbit dengan QR, unduh/ambil di kantor), Waktu Pelayanan, Lokasi, Kontak, Unduh Formulir (file list with version badge and download icon), FAQ accordion. Sticky bottom CTA bar on mobile: "Ajukan Sekarang". Side card on desktop with "Cek Status Tiket".
```

---

## 4. Detail Layanan — Reaktivasi KIS/PBI-JK

```
[Prompt Awalan]

Service detail page "Reaktivasi KIS/PBI-JK". Breadcrumb. Intro: fasilitasi pengaktifan kembali kepesertaan JKN-KIS PBI-JK yang dinonaktifkan. Sections: Alasan yang Dapat Diajukan (cards: penyakit kronis/katastropik, darurat medis, bayi baru lahir dari ibu peserta PBI, lainnya), a highlighted info card "Kasus darurat medis diprioritaskan", Persyaratan (KTP, KK, kartu BPJS/KIS, surat keterangan dari fasilitas kesehatan untuk alasan medis), Alur Pelayanan as a vertical timeline including tahap Dinsos, Kemensos, and BPJS Kesehatan (pemeriksaan berkas, verifikasi kelayakan, surat rekomendasi, diusulkan ke Kemensos, keputusan Kemensos, aktif kembali), Waktu Pelayanan, Kontak, FAQ. Sticky mobile CTA "Ajukan Reaktivasi".
```

---

## 5. Detail Layanan — Pelayanan Rehabilitasi Sosial

```
[Prompt Awalan]

Service detail page "Pelayanan Rehabilitasi Sosial". Empathetic, calm tone. Intro: layanan bagi lansia terlantar, penyandang disabilitas, ODGJ terlantar, anak, dan korban tindak kekerasan. Sections: Siapa yang Dapat Dilayani (category cards with icons), Cara Mengajukan (dua jalur: ajukan sendiri/keluarga, atau laporkan orang yang membutuhkan lewat pengaduan), Tahapan Pelayanan (timeline: penerimaan, assessment, rencana pelayanan, pelayanan langsung atau rujukan, monitoring, selesai), Jaminan Kerahasiaan Data (privacy card), Kontak Darurat, FAQ. Two CTAs: "Ajukan Layanan" and "Laporkan Kasus".
```

---

## 6. Formulir Pengajuan — Surat Keterangan DTSEN (multi-step)

```
[Prompt Awalan]

Multi-step form "Pengajuan Surat Keterangan DTSEN" with a progress stepper (4 steps).
Step 1 "Tujuan Penggunaan": radio cards (SPMB, PIP, KIP Kuliah, Bantuan Sosial, Kesehatan, Lainnya) with optional "Keterangan" text field when Lainnya is selected.
Step 2 "Data Pemohon": nama lengkap, NIK (16 digit, numeric), No. KK (16 digit), alamat, kecamatan dropdown, desa/kelurahan dropdown (dependent), No. HP.
Step 3 "Orang yang Diterangkan & Berkas": nama, NIK, hubungan dengan pemohon (dropdown: diri sendiri, anak, orang tua, lainnya); upload KTP and KK with drag-and-drop zones, file preview, allowed format/size hints, and remove button.
Step 4 "Tinjau & Kirim": read-only summary cards with "Ubah" links, consent checkbox, and button "Kirim Pengajuan".
Include inline validation states, helper text, "Kembali" and "Lanjut" buttons, and a sticky mobile action bar. Also show an optional banner "Diisi oleh operator desa/kecamatan?".
```

---

## 7. Formulir Pengajuan — Reaktivasi KIS/PBI-JK (multi-step)

```
[Prompt Awalan]

Multi-step form "Pengajuan Reaktivasi KIS/PBI-JK" with a progress stepper (4 steps).
Step 1 "Data Peserta": nama peserta, NIK, No. KK, nomor kartu BPJS/KIS, perkiraan tanggal nonaktif (date picker), alamat, kecamatan, desa/kelurahan, No. HP pemohon.
Step 2 "Alasan Reaktivasi": radio cards (Penyakit kronis/katastropik, Kondisi darurat medis, Bayi baru lahir dari ibu peserta PBI, Lainnya). When "darurat medis" is chosen show a red-tinted note "Pengajuan Anda akan diprioritaskan". Fields nama fasilitas kesehatan and nomor surat keterangan faskes for medical reasons.
Step 3 "Unggah Berkas": KTP, KK, kartu BPJS/KIS, surat keterangan faskes (marked "Wajib untuk alasan medis") with drag-and-drop and previews.
Step 4 "Tinjau & Kirim": summary, consent checkbox, "Kirim Pengajuan".
Validation states, helper text, sticky mobile action bar.
```

---

## 8. Formulir Pengajuan — Layanan Sosial Lainnya

```
[Prompt Awalan]

Form "Pengajuan Layanan Sosial Lainnya". First a dropdown "Pilih Jenis Layanan"; after selection, the form dynamically shows a "Persyaratan" checklist card for that service and the matching upload fields. Fields: nama, NIK, No. KK, alamat, kecamatan, desa/kelurahan, No. HP, keterangan kebutuhan (textarea), upload dokumen persyaratan. Show a state before service selection (empty prompt illustration) and after selection. Button "Kirim Pengajuan".
```

---

## 9. Halaman Sukses — Tiket Terbit

```
[Prompt Awalan]

Success confirmation page after a service request is submitted. Large green check icon, heading "Pengajuan Berhasil Dikirim", prominent ticket number card "DTSEN-202610-00012" with copy button, a note: "Simpan nomor tiket ini. Gunakan bersama 4 digit terakhir NIK/No. HP untuk memantau status." Summary of layanan and tanggal pengajuan, estimated next step ("Berkas Anda akan diperiksa petugas"). Buttons: "Lacak Status" (primary), "Unduh Bukti Pengajuan", "Kembali ke Beranda".
```

---

## 10. Cek Status Tiket — Form

```
[Prompt Awalan]

Page "Cek Status Tiket". Centered card with two inputs: Nomor Tiket (placeholder DTSEN-202610-00012, with format hint per layanan: DTSEN, PBI, ADU, RHS) and 4 digit terakhir NIK/No. HP, button "Lacak Status". Show an error state ("Nomor tiket tidak ditemukan atau data tidak sesuai") and a help card "Lupa nomor tiket?" with contact info.
```

---

## 11. Cek Status Tiket — Hasil Pelacakan

```
[Prompt Awalan]

Ticket tracking result page. Top summary card: ticket number, service name, tanggal pengajuan, current status badge, estimated info. Main content: vertical timeline of status history with dates and officer notes; completed steps green, current step teal with pulsing dot, upcoming steps gray. Use a Reaktivasi PBI-JK ticket as example: Diajukan, Pemeriksaan Berkas, Verifikasi Kelayakan, Menunggu Persetujuan, Surat Rekomendasi Terbit, Diusulkan ke Kemensos, Disetujui Kemensos, Aktif Kembali. Include a yellow alert card "Perlu Perbaikan Berkas" with the officer's note and "Unggah Perbaikan" button, and a download button "Unduh Surat" shown when the letter is issued. Sidebar card "Butuh bantuan?" with contact.
```

---

## 12. Formulir Pengaduan Sosial

```
[Prompt Awalan]

Form page "Pengaduan Sosial". Fields: kategori masalah (selectable chips), lokasi kejadian (kecamatan, desa/kelurahan, detail alamat), deskripsi permasalahan (textarea with character counter), optional upload foto/dokumen (thumbnail grid, max files hint), nama pelapor, No. HP. Button "Kirim Laporan". Side card on desktop explaining the process: Diterima, Verifikasi, Disposisi, Penanganan, Selesai. Privacy reassurance note. Short info that laporan dapat diteruskan menjadi kasus rehabilitasi sosial bila diperlukan.
```

---

## 13. Halaman Sukses — Pengaduan Terkirim

```
[Prompt Awalan]

Success page after complaint submission. Check icon, heading "Laporan Anda Telah Diterima", ticket number "ADU-202610-00004" with copy button, note on how to track it, short process explanation (Verifikasi awal → Disposisi → Penanganan). Buttons: "Lacak Laporan", "Buat Laporan Lain", "Kembali ke Beranda".
```

---

## 14. Verifikasi Keaslian Surat

```
[Prompt Awalan]

Public page "Verifikasi Keaslian Surat". Centered card with input "Kode Verifikasi" and a "Scan QR" button. Show both result states as separate frames: (1) VALID — green card with nomor surat, nama yang diterangkan, tujuan penggunaan, tanggal terbit, masa berlaku, nama dan jabatan penandatangan; (2) TIDAK VALID atau KEDALUWARSA — red card with explanation and advice to contact Dinas Sosial. Do not display NIK or other sensitive data. Small footnote explaining that this page reads the QR on the surat.
```

---

## 15. Masuk / Daftar Akun Masyarakat

```
[Prompt Awalan]

Authentication pages for citizens. Frame 1 "Masuk": No. HP/NIK and password fields, "Lupa kata sandi?", button "Masuk", divider, and link "Belum punya akun? Daftar". Frame 2 "Daftar Akun": nama lengkap, NIK, No. HP, kata sandi, konfirmasi kata sandi, consent checkbox, button "Daftar". Add a side note: "Tanpa akun, Anda tetap bisa cek status dengan nomor tiket." Clean centered layout, simple illustration on desktop.
```

---

## 16. Akun Saya — Riwayat Pengajuan & Pengaduan

```
[Prompt Awalan]

Logged-in citizen dashboard "Akun Saya". Greeting, quick action buttons "Ajukan Layanan Baru" and "Buat Pengaduan". Status filter tabs: Semua, Diproses, Perlu Perbaikan, Selesai. Table of tickets on desktop (nomor tiket, layanan, tanggal, status badge, "Detail" button), rendered as stacked cards on mobile. Highlight tickets that need revision. Profile side card with name and edit profile link.
```

---

## 17. Detail Tiket (dari Akun Saya)

```
[Prompt Awalan]

Ticket detail page for a logged-in citizen. Header with ticket number, layanan, status badge. Tabs: Ringkasan, Berkas, Riwayat Status. Ringkasan shows submitted data (with NIK masked). Berkas lists uploaded documents with status (Lengkap / Perlu Perbaikan) and re-upload button. Riwayat Status shows vertical timeline. When the surat is issued, show a highlighted card with "Unduh Surat" and QR verification code.
```

---

## 18. FAQ

```
[Prompt Awalan]

Page "Pertanyaan yang Sering Diajukan". Search bar, category tabs (Umum, DTSEN, KIS/PBI-JK, Rehabilitasi Sosial, Pengaduan, Akun & Tiket), accordion list of Q&A, and a bottom card "Belum menemukan jawaban?" with contact options (telepon, WhatsApp, alamat kantor).
```

---

## 19. Unduh Formulir

```
[Prompt Awalan]

Page "Unduh Formulir". Search and category filter. List of downloadable forms as cards: nama formulir, layanan terkait, format (PDF/DOCX), ukuran, badge "Versi Terbaru" with tanggal berlaku, download button. Note that only the current valid version is shown.
```

---

## 20. Kontak & Lokasi

```
[Prompt Awalan]

Page "Kontak & Lokasi Layanan". Cards for alamat Dinas Sosial Kabupaten Blitar, jam pelayanan (Senin–Jumat), telepon, WhatsApp, email. Embedded map placeholder, plus a section listing layanan di Kecamatan/Desa/Puskesos with a search by kecamatan. Button "Petunjuk Arah".
```

---

## 21. Halaman Error (404 / Maintenance)

```
[Prompt Awalan]

Two small frames. Frame 1: 404 page "Halaman Tidak Ditemukan" with friendly illustration and buttons "Kembali ke Beranda" and "Cek Status Tiket". Frame 2: maintenance page "Sistem Sedang Dalam Pemeliharaan" with estimated return time and contact information.
```

---

## Catatan Implementasi

- Hasil Stitch dapat diekspor ke HTML/Tailwind atau Figma, dan cocok dijadikan acuan markup untuk komponen **Livewire v4 + Tailwind CSS v4** pada portal publik.
- Nomor tiket pada contoh mengikuti format PRD: `{kode layanan}-YYYYMM-NNNNN` (DTSEN, PBI), `ADU-…` (pengaduan), `RHS-…` (rehabilitasi).
- Warna dan logo hanyalah placeholder; sesuaikan dengan identitas visual resmi Pemkab Blitar bila tersedia.
