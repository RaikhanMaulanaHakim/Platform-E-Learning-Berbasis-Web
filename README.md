# Tugas Besar Mata Kuliah Rekayasa Perangkat Lunak

# Kelompok 3

# Nama Anggota :

1. LADEN AHMADDINEJAD (240511054)

2. RAIKHAN MAULANA HAKIM (240511060)

3. SHOFYAN ALGIFARI (240511162)

4. KIKI ANINDA (240511004)

5. MAHFUZH ZAHIR BAIHAQIE (240511069)

# Project Yang dibuat : Platform E-Learning Berbasis Web

# E-Learning Studio Belajar (Sekolah Dasar)

Platform pembelajaran digital (E-Learning) berbasis web yang dirancang khusus untuk jenjang Sekolah Dasar, guna mengelola materi pembelajaran, pembagian tugas, dan proses penilaian secara terpusat per kelas (Kelas 1–6). Sistem ini dibangun menggunakan arsitektur **PHP Native** dan dikembangkan dengan **Tailwind CSS** untuk menghasilkan antarmuka bergaya *neobrutalism* yang ceria, modern, dan responsif.

Sistem ini memiliki dua peran pengguna, yaitu **Guru** (pengelola materi dan penilai tugas) dan **Murid** (peserta didik yang mengakses materi dan mengumpulkan tugas). Setiap guru maupun murid terdaftar pada satu kelas tertentu (Kelas 1–6), sehingga seluruh data yang ditampilkan (murid, materi, tugas, dan nilai) selalu difilter sesuai kelas dan/atau akun pemiliknya melalui mekanisme session dan validasi role pada setiap halaman.

---

## Spesifikasi Teknologi

* **Sisi Klien (Frontend):** HTML5, Tailwind CSS v3
* **Sisi Server (Backend):** PHP 8.x Native (berbasis *session*, belum menggunakan framework seperti Laravel)
* **Penyimpanan Data (Database):** MySQL (`db_elearning`)
* **Local development environment:** Laragon

---

## Fitur dan Kemampuan Sistem

### Hak Akses dan Aktivitas Guru

| Aktivitas | Deskripsi | Berkas Terkait |
|---|---|---|
| **Masuk ke Dashboard** | Setelah berhasil login, guru diarahkan ke halaman dashboard yang menampilkan statistik ringkas: jumlah murid **pada kelas yang diampu**, jumlah materi yang telah diunggah oleh guru tersebut, jumlah tugas yang telah dibuat, serta jumlah tugas yang telah dikumpulkan murid. | `dashboard.php` |
| **Mengelola Materi Pembelajaran** | Guru dapat mengunggah berkas materi untuk kelas tertentu. Daftar materi yang ditampilkan hanya materi milik guru yang sedang login (`id_guru`). | `materi.php`, `proses_materi.php` |
| **Membuat Tugas Baru** | Guru dapat membuat tugas baru lengkap dengan judul, deskripsi, kelas tujuan, dan batas waktu pengumpulan (*deadline*). Daftar tugas yang ditampilkan hanya tugas milik guru yang sedang login. | `tugas.php`, `proses_tugas.php` |
| **Memantau Pengumpulan Tugas** | Untuk setiap tugas yang dibuatnya, guru dapat melihat daftar murid yang telah mengumpulkan jawaban, lengkap dengan berkas jawaban dan waktu pengumpulan. | `penilaian.php` |
| **Memberikan Penilaian** | Guru dapat memberikan nilai (angka) untuk setiap jawaban murid yang telah dikumpulkan pada tugas miliknya. | `proses_nilai.php` |
| **Melihat Rekapitulasi Nilai** | Guru dapat melihat rekapitulasi nilai seluruh murid dari seluruh tugas yang pernah ia buat dalam satu tampilan, yang memudahkan proses pelaporan dan dokumentasi. | `rekap_nilai.php` |
| **Keluar Sistem (Logout)** | Mengakhiri sesi aktif dan menghapus data session pengguna. | `logout.php` |

### Hak Akses dan Aktivitas Murid

| Aktivitas | Deskripsi | Berkas Terkait |
|---|---|---|
| **Masuk ke Dashboard** | Murid login menggunakan akun yang telah terdaftar pada kelas tertentu (Kelas 1 sampai 6), kemudian diarahkan ke halaman dashboard murid. | `dashboard.php` |
| **Mengakses Materi Kelas** | Murid hanya dapat melihat materi yang diunggah khusus untuk kelasnya, karena data difilter berdasarkan kelas yang tersimpan pada session. | `materi.php` |
| **Melihat Daftar Tugas** | Murid dapat melihat seluruh tugas yang ditujukan untuk kelasnya, lengkap dengan status pengumpulan (sudah/belum dikumpulkan) dan batas waktu pengerjaan. Sistem menolak pengumpulan jika sudah melewati *deadline*. | `tugas.php`, `kerjakan_tugas.php` |
| **Mengerjakan dan Mengumpulkan Tugas** | Murid dapat mengunggah berkas jawaban langsung melalui halaman tugas sebelum batas waktu berakhir. | `kerjakan_tugas.php`, `proses_kumpul_tugas.php` |
| **Melihat Riwayat Tugas** | Terdapat halaman khusus untuk melihat seluruh tugas yang pernah dikumpulkan murid beserta status penilaiannya. | `tugas_saya.php` |
| **Melihat Nilai dan Jawaban yang Dikirim** | Setelah dinilai oleh guru, murid dapat membuka kembali jawaban yang telah dikirimkan sekaligus melihat nilai yang diberikan. | `lihat_jawaban.php` |
| **Keluar Sistem (Logout)** | Mengakhiri sesi aktif murid. | `logout.php` |

### Fitur Umum (Autentikasi)
* **Registrasi Akun** — Pengguna dapat mendaftarkan akun baru, memilih peran sebagai **Guru** atau **Murid**, serta memilih kelas (Kelas 1–6) yang diampu/diikuti. Password disimpan dalam bentuk terenkripsi menggunakan bcrypt (`password_hash`), bukan sebagai teks biasa.
* **Login** — Sistem memvalidasi kombinasi email dan password menggunakan `password_verify()`, kemudian mengarahkan pengguna ke dashboard sesuai perannya (guru/murid).
* **Proteksi Halaman** — Setiap halaman pada panel Guru maupun Murid melakukan pemeriksaan terhadap `$_SESSION['role']` di bagian awal berkas. Apabila peran tidak sesuai atau sesi belum aktif, pengguna akan diarahkan kembali ke halaman login, sehingga akses lintas peran (misalnya murid membuka halaman guru) dapat dicegah.

---

## Struktur Direktori Proyek
```text
elearning/
├── assets/
│   ├── css/
│      ├── input.css        # Berkas sumber Tailwind
│      └── output.css       # Hasil kompilasi Tailwind (npm run build)
├── auth/                    # autentikasi pengguna
│   ├── login.php
│   ├── logout.php
│   ├── proses_login.php
│   ├── proses_register.php
│   └── register.php
├── config/                  # Koneksi PHP
│   ├── koneksi.php
│   └── session.php
├── database/                 # Berkas skema basis data (database)
│   └── db_elearning.sql
├── guru/                    # Dashboard Guru
│   ├── dashboard.php
│   ├── materi.php
│   ├── penilaian.php
│   ├── proses_materi.php
│   ├── proses_nilai.php
│   ├── proses_tugas.php
│   ├── rekap_nilai.php
│   └── tugas.php
├── murid/                   # Dashboard Murid
│   ├── dashboard.php
│   ├── kerjakan_tugas.php
│   ├── lihat_jawaban.php
│   ├── materi.php
│   ├── proses_kumpul_tugas.php
│   ├── tugas_saya.php
│   └── tugas.php
├── uploads/                  # Tempat penyimpanan berkas dinamis yang diunggah
│   ├── materi/
│   ├── pengumpulan/
│   └── tugas/
├── index.php                 # Redirect otomatis ke auth/login.php
├── package.json               # Dependensi & skrip build Tailwind CSS
└── tailwind.config.js
```

---

## Struktur Basis Data (DataBase)

Sistem terdiri dari empat tabel utama dengan relasi sebagai berikut:

* `users` — Menyimpan data akun pengguna (Guru dan Murid dalam satu tabel yang sama, dibedakan melalui kolom `role`). Kolom `kelas` diisi untuk **kedua** peran: pada murid menandai kelas yang diikuti, pada guru menandai kelas yang diampu.
* `materi` — Menyimpan data materi yang diunggah oleh guru, memiliki relasi ke `id_guru` dan target `kelas`.
* `tugas` — Menyimpan data tugas yang dibuat oleh guru, mencakup informasi `deadline` dan target `kelas`.
* `pengumpulan` — Menyimpan jawaban yang dikumpulkan murid, memiliki relasi ke tabel `tugas` (`id_tugas`) dan `users` (`id_murid`), serta kolom `nilai` dan `status`.

Rincian lengkap struktur tabel dapat dilihat pada berkas `database/db_elearning.sql`.

---

## Cara Menjalankan (Local Development)

1. Clone/salin folder proyek ke direktori `www` (Laragon)
2. Buat database MySQL bernama `db_elearning`, lalu impor berkas `database/db_elearning.sql`.
3. Sesuaikan kredensial koneksi database pada `config/koneksi.php` bila diperlukan (default: host `localhost`, user `root`, tanpa password).
4. Install dependensi Tailwind dan build CSS:
   ```bash
   npm install
   npm run build     # sekali build
   # atau
   npm run watch      # build otomatis saat ada perubahan
   ```
5. Jalankan Laragon/Apache, lalu akses proyek melalui browser (contoh: `http://elearning.test` atau `http://localhost/elearning`). Halaman `index.php` akan otomatis mengarahkan ke `auth/login.php`.

---

## Akun Demo

File `database/db_elearning.sql` sudah menyertakan beberapa akun contoh untuk setiap kelas (Kelas 1–6), baik untuk peran Guru maupun Murid. Setelah diimpor, akun-akun tersebut bisa langsung dipakai untuk login tanpa proses registrasi tambahan.

| Peran | Email                      | Kelas | mengajar kelas  | Password           |
|-------|--------------------------- |-------|-----------------|--------------------|
| Murid | kelas1@gmail.com           | 1     | -               | kelas1             |               
| Murid | kelas2@gmail.com           | 2     | -               | kelas2             |
| Murid | kelas3@gmail.com           | 3     | -               | kelas3             | 
| Murid | kelas4@gmail.com           | 4     | -               | kelas4             |
| Murid | kelas5@gmail.com           | 5     | -               | kelas5             |
| Murid | kelas6@gmail.com           | 6     | -               | kelas6             |
| Guru  | gurukelas1@gmail.com       | -     | 1               | GRkelas1           |
| Guru  | gurukelas2@gmail.com       | -     | 2               | GRkelas2           |
| Guru  | gurukelas3@gmail.com       | -     | 3               | GRkelas3           |
| Guru  | gurukelas4@gmail.com       | -     | 4               | GRkelas4           |
| Guru  | gurukelas5@gmail.com       | -     | 5               | GRkelas5           |
| Guru  | gurukelas6@gmail.com       | -     | 6               | GRkelas6           |
