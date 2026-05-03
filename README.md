# 🧪 Akademika - Research & Education Portal

**Akademika** adalah platform portal penelitian dan edukasi ilmiah modern yang dirancang untuk memfasilitasi peneliti dalam mempublikasikan karya mereka secara interaktif. Bukan sekadar repository PDF, Akademika memungkinkan penyajian konten penelitian yang kaya dengan teks, gambar, dan video YouTube.

![Akademika Logo](public/img/logonotfound.png)

## ✨ Fitur Utama

### 🌐 Akses Publik
- **Landing Page Interaktif**: Menampilkan penelitian terbaru dan terpopuler dengan desain modern.
- **Pencarian Canggih**: Fitur pencarian dengan **Live Search** (asynchronous) untuk menemukan topik penelitian dengan cepat.
- **Halaman Detail Karya**: Struktur penelitian berbasis *sections* yang mendukung rich content, gambar, dan embed video YouTube.
- **Responsif**: Antarmuka yang dioptimalkan untuk perangkat mobile maupun desktop.

### 🔐 Fitur Peneliti (User)
- **Dashboard Personal**: Statistik karya dan aktivitas terakhir.
- **Manajemen Penelitian**: Membuat, mengedit, dan menghapus penelitian sendiri.
- **Struktur Konten (Sections)**: Mengatur urutan konten penelitian dengan fleksibel.
- **Bookmark System**: Menyimpan penelitian favorit untuk dibaca nanti (Asynchronous toggle).

### 🛠️ Fitur Administrasi (Superadmin & Admin)
- **Moderasi Konten**: Menyetujui atau menolak pendaftaran penelitian baru untuk menjaga kualitas.
- **Manajemen Pengguna**: Mengelola akun, peran (Superadmin, Admin, Researcher), dan status pengguna.
- **Pengaturan Website**: Mengelola informasi footer, email kontak, dan metadata situs secara dinamis melalui dashboard.
- **Database Backup**: Fitur ekspor basis data sekali klik untuk keamanan data.

---

## 🛡️ Keamanan & Arsitektur

Aplikasi ini dibangun dengan standar **Production-Ready** menggunakan CodeIgniter 4:

1. **Hardened HTML Sanitization**: Menggunakan parser DOM berbasis server untuk membersihkan konten Rich Text dari ancaman XSS (Cross-Site Scripting).
2. **Content Security Policy (CSP)**: Kebijakan ketat yang melarang *inline scripts* dan membatasi sumber resource (scripts, images, iframes) hanya dari domain terpercaya.
3. **Rate Limiting (Throttling)**: Melindungi endpoint krusial (Login, Register, Search, Store) dari serangan Brute Force dan Spam.
4. **Data Ownership**: Validasi ketat untuk memastikan pengguna hanya dapat memodifikasi data milik mereka sendiri.
5. **Secure Headers**: Implementasi `X-Frame-Options`, `X-Content-Type-Options`, dan `Referrer-Policy`.
6. **CSRF Protection**: Aktif secara global untuk seluruh form dan permintaan asynchronous (fetch).

---

## 🚀 Instalasi

### Prasyarat
- PHP 8.1+ (dengan extension: `intl`, `mbstring`, `gd`, `mysqli`)
- MySQL 5.7+ / MariaDB
- Composer

### Langkah-langkah
1. **Clone Repository**
   ```bash
   git clone <repository-url>
   cd Akademika
   ```

2. **Instal Dependensi**
   ```bash
   composer install
   ```

3. **Konfigurasi Environment**
   Salin file `.env.example` menjadi `.env` dan sesuaikan pengaturan database Anda:
   ```ini
   database.default.hostname = localhost
   database.default.database = akademika_db
   database.default.username = root
   database.default.password = GilangRizky
   ```

4. **Migrasi & Seeding**
   Jalankan perintah berikut untuk menyiapkan struktur tabel dan data awal:
   ```bash
   php spark migrate
   php spark db:seed MainSeeder
   ```

5. **Jalankan Server Lokal**
   ```bash
   php spark serve
   ```

---

## 👥 Kredensial Default
Silakan gunakan akun berikut untuk pengujian awal:
- **Superadmin**: `superadmin` / `620a608e807d272a`
- **Admin**: `admin` / `0d04a1c43ebf6f55`
- **Researcher**: `researcher` / `3bf3dc1a29c8b08d`

---

## 📄 Lisensi
Aplikasi ini dirilis di bawah [MIT License](LICENSE).

---
*Dibuat dengan ❤️ untuk kemajuan Ilmu Pengetahuan.*
