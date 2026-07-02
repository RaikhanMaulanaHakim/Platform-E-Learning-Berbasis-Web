# Tugas Besar Mata Kuliah Rekayasa Perangkat Lunak

# Kelompok 3

# Nama Anggota :

1. LADEN AHMADDINEJAD (240511054) 

2. RAIKHAN MAULANA HAKIM (240511060)

3. SHOFYAN ALGIFARI (240511162)

4. KIKI ANINDA (240511004)

5. MAHFUZH ZAHIR BAIHAQIE (240511069)

# Project Yang dibuat : Platform E-Learning Berbasis Web

# Platform E-Learning Berbasis Web

Platform pembelajaran digital (E-Learning) berbasis web yang dirancang untuk mengelola materi pembelajaran, pembagian tugas, dan proses penilaian secara terpusat. Sistem ini dibangun menggunakan arsitektur **PHP Native** dan dikembangkan dengan **Tailwind CSS** untuk menghasilkan antarmuka yang modern dan responsif.

Sistem ini memiliki dua peran pengguna, yaitu **Guru** (pengelola materi dan penilai tugas) dan **Murid** (peserta didik yang mengakses materi dan mengumpulkan tugas). Setiap peran memiliki halaman dan hak akses yang berbeda, yang dikendalikan melalui mekanisme session dan validasi role pada setiap halaman.

---

## Spesifikasi Teknologi

* **Sisi Klien (Frontend):** HTML5, Tailwind CSS v3
* **Sisi Server (Backend):** PHP 8.x Native (berbasis *session*, belum menggunakan framework seperti Laravel atau CodeIgniter)
* **Penyimpanan Data (Database):** MySQL
* **local development environment :** Laragon

---

## Fitur dan Kemampuan Sistem

### Hak Akses dan Aktivitas Guru

| Aktivitas | Deskripsi | Berkas Terkait |
|---|---|---|
| **Masuk ke Dashboard** | Setelah berhasil login, guru diarahkan ke halaman dashboard yang menampilkan statistik ringkas: jumlah murid, jumlah materi yang telah diunggah, jumlah tugas yang telah dibuat, serta jumlah tugas yang telah dikumpulkan murid. | `dashboard.php` |
| **Mengelola Materi Pembelajaran** | Guru dapat mengunggah berkas materi (misalnya PDF, DOCX, atau PPT) untuk kelas tertentu, sehingga materi tersebut dapat langsung diakses oleh murid pada kelas yang bersangkutan. | `materi.php`, `proses_materi.php` |
| **Membuat Tugas Baru** | Guru dapat membuat tugas baru lengkap dengan judul, deskripsi, kelas tujuan, batas waktu pengumpulan (*deadline*), dan lampiran berkas soal apabila diperlukan. | `tugas.php`, `proses_tugas.php` |
| **Memantau Pengumpulan Tugas** | Untuk setiap tugas, guru dapat melihat daftar murid yang telah maupun belum mengumpulkan jawaban, lengkap dengan berkas jawaban dan waktu pengumpulan. | `penilaian.php` |
| **Memberikan Penilaian** | Guru dapat memberikan nilai untuk setiap jawaban murid yang telah dikumpulkan. Status pengumpulan akan otomatis berubah dari "dikumpul" menjadi "dinilai". | `proses_nilai.php` |
| **Melihat Rekapitulasi Nilai** | Guru dapat melihat rekapitulasi nilai seluruh murid dari seluruh tugas yang pernah dibuat dalam satu tampilan, yang memudahkan proses pelaporan dan dokumentasi. | `rekap_nilai.php` |
| **Keluar Sistem (Logout)** | Mengakhiri sesi aktif dan menghapus data session pengguna. | `logout.php` |

### Hak Akses dan Aktivitas Murid

| Aktivitas | Deskripsi | Berkas Terkait |
|---|---|---|
| **Masuk ke Dashboard** | Murid login menggunakan akun yang telah terdaftar pada kelas tertentu (kelas 1 sampai 6), kemudian diarahkan ke halaman dashboard murid. | `dashboard.php` |
| **Mengakses Materi Kelas** | Murid hanya dapat melihat materi yang diunggah khusus untuk kelasnya, karena data difilter berdasarkan kelas yang tersimpan pada session. | `materi.php` |
| **Melihat Daftar Tugas** | Murid dapat melihat seluruh tugas yang ditujukan untuk kelasnya, lengkap dengan status pengumpulan (sudah/belum dikumpulkan) dan batas waktu pengerjaan. | `tugas.php` |
| **Mengerjakan dan Mengumpulkan Tugas** | Murid dapat mengunggah berkas jawaban langsung melalui halaman tugas sebelum batas waktu berakhir. | `kerjakan_tugas.php`, `proses_kumpul_tugas.php` |
| **Melihat Riwayat Tugas** | Terdapat halaman khusus untuk melihat seluruh tugas yang pernah dikumpulkan beserta status penilaiannya. | `tugas_saya.php` |
| **Melihat Nilai dan Jawaban yang Dikirim** | Setelah dinilai oleh guru, murid dapat membuka kembali jawaban yang telah dikirimkan sekaligus melihat nilai yang diberikan. | `lihat_jawaban.php` |
| **Keluar Sistem (Logout)** | Mengakhiri sesi aktif murid. | `logout.php` |

### Fitur Umum (Autentikasi)
* **Registrasi Akun** — Pengguna dapat mendaftarkan akun baru dan memilih peran sebagai Guru atau Murid. Password disimpan dalam bentuk terenkripsi menggunakan bcrypt (`password_hash`), bukan sebagai teks biasa.
* **Login** — Sistem memvalidasi kombinasi email dan password menggunakan `password_verify()`, kemudian mengarahkan pengguna ke dashboard sesuai perannya.
* **Proteksi Halaman** — Setiap halaman pada panel Guru maupun Murid melakukan pemeriksaan terhadap `$_SESSION['role']` di bagian awal berkas. Apabila peran tidak sesuai atau sesi belum aktif, pengguna akan diarahkan kembali ke halaman login, sehingga akses lintas peran (misalnya murid membuka halaman guru) dapat dicegah.

---

## Struktur Direktori Proyek
```text
elearning/
├── assets/                 # Berkas statis tambahan (CSS input & output Tailwind)
│   └── css/
│       ├── input.css
│       └── output.css
├── auth/                   # Modul autentikasi pengguna
│   ├── login.php
│   ├── logout.php
│   ├── proses_login.php
│   ├── proses_register.php
│   └── register.php
├── config/                 # Koneksi PHP
│   ├── koneksi.php
│   └── session.php
├── database/               # Berkas skema basis data
│   └── elearning.sql
├── guru/                   # Dashboard Guru
│   ├── dashboard.php
│   ├── materi.php
│   ├── penilaian.php
│   ├── proses_materi.php
│   ├── proses_nilai.php
│   ├── proses_tugas.php
│   ├── rekap_nilai.php
│   └── tugas.php
├── murid/                  # Dashboard Murid
│   ├── dashboard.php
│   ├── kerjakan_tugas.php
│   ├── lihat_jawaban.php
│   ├── materi.php
│   ├── proses_kumpul_tugas.php
│   ├── tugas_saya.php
│   └── tugas.php
└── uploads/                 # Tempat penyimpanan berkas dinamis yang diunggah
    ├── materi/
    ├── pengumpulan/
    └── tugas/
```

---

## Struktur Basis Data (Ringkas)

Sistem terdiri dari empat tabel utama dengan relasi sebagai berikut:

* `users` — Menyimpan data akun pengguna (Guru dan Murid dalam satu tabel yang sama, dibedakan melalui kolom `role`).
* `materi` — Menyimpan data materi yang diunggah oleh guru, memiliki relasi ke `id_guru` dan target `kelas`.
* `tugas` — Menyimpan data tugas yang dibuat oleh guru, mencakup informasi `deadline` dan target `kelas`.
* `pengumpulan` — Menyimpan jawaban yang dikumpulkan murid, memiliki relasi ke tabel `tugas` (`id_tugas`) dan `users` (`id_murid`), serta kolom `nilai` dan `status`.

Rincian lengkap struktur tabel dapat dilihat pada berkas `database/elearning.sql`.

---

## Akun Demo

Akun berikut telah tersedia secara otomatis setelah mengimpor `database/elearning.sql`, sehingga dapat langsung digunakan untuk keperluan pengujian tanpa perlu melakukan registrasi manual:

| Peran | Email             | Password  | Kelas |
|-------|-------------------|-----------|-------|
| Guru  | guru@gmail.com    | guru123   | -     |
| Murid | kelas1@gmail.com  | kelas1    | 1     |
| Murid | kelas2@gmail.com  | kelas2    | 2     |
| Murid | kelas3@gmail.com  | kelas3    | 3     |
| Murid | kelas4@gmail.com  | kelas4    | 4     |
| Murid | kelas5@gmail.com  | kelas5    | 5     |
| Murid | kelas6@gmail.com  | kelas6    | 6     |

