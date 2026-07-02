<?php
include '../config/koneksi.php';
include '../config/session.php';

/** @var mysqli $koneksi */

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'guru') {
    header("Location: ../auth/login.php");
    exit();
}

$total_murid   = mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(*) FROM users WHERE role='murid'"))[0];
$total_materi  = mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(*) FROM materi WHERE id_guru='" . $_SESSION['id_user'] . "'"))[0];
$total_tugas   = mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(*) FROM tugas WHERE id_guru='" . $_SESSION['id_user'] . "'"))[0];
$tugas_masuk   = mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(*) FROM pengumpulan p JOIN tugas t ON p.id_tugas=t.id_tugas WHERE t.id_guru='" . $_SESSION['id_user'] . "'"))[0];

$nama_panggilan = strtoupper(explode(' ', trim($_SESSION['nama']))[0]);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - E-Learning</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DotGothic16&family=Plus+Jakarta+Sans:wght@700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/output.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .font-pixel {
            font-family: 'DotGothic16', sans-serif;
        }

        .bg-canvas-denim {
            background-color: #0c4cb4;
            background-image: linear-gradient(90deg, rgba(255, 255, 255, 0.09) 50%, transparent 50%),
                linear-gradient(rgba(255, 255, 255, 0.09) 50%, transparent 50%);
            background-size: 3px 3px;
        }

        .bouncy-bounce {
            transition: all 0.4s cubic-bezier(0.68, -0.60, 0.32, 1.60);
        }
    </style>
</head>

<body class="bg-canvas-denim text-[#0f172a] antialiased min-h-screen pb-12 selection:bg-yellow-300">

<div class="max-w-5xl mx-auto px-4 pt-4 md:pt-6">
    <nav class="bg-white border-4 border-[#0f172a] rounded-2xl p-4 flex flex-wrap items-center justify-between shadow-[5px_5px_0px_#0f172a]">
        
        <div class="flex items-center">
            <div class="bg-blue-600 text-white font-900 px-4 py-2 rounded-xl border-2 border-[#0f172a] shadow-[2px_2px_0px_#0f172a] text-sm tracking-tight uppercase">
                E-LEARNING
            </div>
        </div>

        <div class="flex items-center gap-3">
            <div class="hidden sm:block text-right">
                <p class="text-[10px] font-900 uppercase text-slate-400">login sebagai</p>
                <p class="text-xs font-900 text-[#0f172a]"><?= htmlspecialchars($_SESSION['nama']); ?></p>
            </div>
            <a href="../auth/logout.php" class="font-900 uppercase bg-[#ff4757] hover:bg-rose-600 text-white px-4 py-2 rounded-xl border-2 border-[#0f172a] shadow-[2px_2px_0px_#0f172a] text-xs transition-all active:translate-x-[2px] active:translate-y-[2px]">
                Keluar
            </a>
        </div>
    </nav>
</div>

    <main class="max-w-5xl mx-auto px-4 mt-6 md:mt-8 space-y-6 md:space-y-8">

        <section class="bg-[#a8ff78] border-4 border-[#0f172a] rounded-[2rem] p-6 md:p-10 shadow-[6px_6px_0px_#0f172a] relative overflow-hidden flex flex-col justify-between items-start">
            <div class="absolute inset-0 bg-[linear-gradient(rgba(0,0,0,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(0,0,0,0.02)_1px,transparent_1px)] bg-[size:16px_16px] pointer-events-none"></div>

            <div class="space-y-2 md:space-y-3 max-w-xl z-10">
                <span class="inline-block bg-white border-2 border-[#0f172a] text-[#0f172a] text-[9px] md:text-[10px] font-900 tracking-widest px-2.5 py-1 rounded-md uppercase shadow-[2px_2px_0px_#0f172a]">
                    MENU UTAMA GURU
                </span>
                <h1 class="text-2xl sm:text-3xl md:text-5xl font-900 tracking-tight text-[#0f172a] uppercase leading-none">
                    KELOLA AKTIVITAS <br>PEMBELAJARAN
                </h1>
                <p class="text-slate-800 text-xs md:text-sm font-700 leading-relaxed pt-1">
                    Pantau statistik kelas, unggah modul materi terbaru, kelola penugasan siswa, dan rekapitulasi nilai dengan mudah di sini.
                </p>
            </div>
        </section>

        <section class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            <div class="bg-blue-100 border-4 border-[#0f172a] p-4 md:p-5 rounded-2xl shadow-[4px_4px_0px_#0f172a] flex flex-col justify-between">
                <span class="text-[9px] md:text-[10px] font-900 uppercase tracking-widest text-[#0f172a]">Total Murid</span>
                <span class="font-pixel text-4xl md:text-5xl text-[#0c4cb4] mt-2 block"><?= $total_murid; ?></span>
            </div>
            <div class="bg-emerald-100 border-4 border-[#0f172a] p-4 md:p-5 rounded-2xl shadow-[4px_4px_0px_#0f172a] flex flex-col justify-between">
                <span class="text-[9px] md:text-[10px] font-900 uppercase tracking-widest text-[#0f172a]">Materi Dibuat</span>
                <span class="font-pixel text-4xl md:text-5xl text-emerald-600 mt-2 block"><?= $total_materi; ?></span>
            </div>
            <div class="bg-amber-100 border-4 border-[#0f172a] p-4 md:p-5 rounded-2xl shadow-[4px_4px_0px_#0f172a] flex flex-col justify-between">
                <span class="text-[9px] md:text-[10px] font-900 uppercase tracking-widest text-[#0f172a]">Tugas Dibuat</span>
                <span class="font-pixel text-4xl md:text-5xl text-amber-600 mt-2 block"><?= $total_tugas; ?></span>
            </div>
            <div class="bg-rose-100 border-4 border-[#0f172a] p-4 md:p-5 rounded-2xl shadow-[4px_4px_0px_#0f172a] flex flex-col justify-between">
                <span class="text-[9px] md:text-[10px] font-900 uppercase tracking-widest text-[#0f172a]">Tugas Masuk</span>
                <span class="font-pixel text-4xl md:text-5xl text-rose-600 mt-2 block"><?= $tugas_masuk; ?></span>
            </div>
        </section>

        <section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 md:gap-8">

            <a href="materi.php" class="group bg-white border-4 border-[#0f172a] p-6 md:p-8 rounded-[2rem] shadow-[5px_5px_0px_#0f172a] hover:shadow-[10px_10px_0px_#a8ff78] hover:bg-[#f8fafc] transition-all hover:-translate-x-2 hover:-translate-y-2 active:translate-x-0 active:translate-y-0 flex flex-col justify-between min-h-[260px] md:min-h-[310px] bouncy-bounce">
                <div>
                    <div class="flex justify-between items-start">
                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl bg-blue-50 border-2 md:border-3 border-[#0f172a] flex items-center justify-center shadow-[2px_2px_0px_#0f172a] group-hover:rotate-12 group-hover:bg-white bouncy-bounce">
                            <svg class="w-6 h-6 text-[#0c4cb4]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <span class="font-pixel text-3xl md:text-4xl text-[#0c4cb4] group-hover:text-emerald-600 group-hover:scale-125 block bouncy-bounce tracking-tighter">01</span>
                    </div>

                    <h2 class="text-xl md:text-2xl font-900 text-[#0f172a] mt-6 md:mt-8 tracking-tight uppercase">Kelola Materi</h2>
                    <p class="text-slate-500 text-xs font-700 mt-2 leading-relaxed">
                        Unggah modul, bahan bacaan, dan referensi belajar agar dapat diakses oleh siswa di kelas.
                    </p>
                </div>
                <div class="mt-6 flex items-center gap-2 text-xs font-900 text-[#0c4cb4] group-hover:text-emerald-700 tracking-widest uppercase transition-colors">
                    <span>Buka Manajer</span>
                    <svg class="w-4 h-4 transform group-hover:translate-x-2 bouncy-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </div>
            </a>

            <a href="tugas.php" class="group bg-white border-4 border-[#0f172a] p-6 md:p-8 rounded-[2rem] shadow-[5px_5px_0px_#0f172a] hover:shadow-[10px_10px_0px_#a8ff78] hover:bg-[#f8fafc] transition-all hover:-translate-x-2 hover:-translate-y-2 active:translate-x-0 active:translate-y-0 flex flex-col justify-between min-h-[260px] md:min-h-[310px] bouncy-bounce">
                <div>
                    <div class="flex justify-between items-start">
                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl bg-amber-50 border-2 md:border-3 border-[#0f172a] flex items-center justify-center shadow-[2px_2px_0px_#0f172a] group-hover:rotate-12 group-hover:bg-white bouncy-bounce">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <span class="font-pixel text-3xl md:text-4xl text-[#0c4cb4] group-hover:text-emerald-600 group-hover:scale-125 block bouncy-bounce tracking-tighter">02</span>
                    </div>

                    <h2 class="text-xl md:text-2xl font-900 text-[#0f172a] mt-6 md:mt-8 tracking-tight uppercase">Kelola Tugas</h2>
                    <p class="text-slate-500 text-xs font-700 mt-2 leading-relaxed">
                        Buat penugasan baru, atur batas waktu (deadline), dan pantau daftar murid yang sudah mengumpulkan.
                    </p>
                </div>
                <div class="mt-6 flex items-center gap-2 text-xs font-900 text-[#0c4cb4] group-hover:text-emerald-700 tracking-widest uppercase transition-colors">
                    <span>Buka Manajer</span>
                    <svg class="w-4 h-4 transform group-hover:translate-x-2 bouncy-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </div>
            </a>

            <a href="rekap_nilai.php" class="group bg-white border-4 border-[#0f172a] p-6 md:p-8 rounded-[2rem] shadow-[5px_5px_0px_#0f172a] hover:shadow-[10px_10px_0px_#a8ff78] hover:bg-[#f8fafc] transition-all hover:-translate-x-2 hover:-translate-y-2 active:translate-x-0 active:translate-y-0 flex flex-col justify-between min-h-[260px] md:min-h-[310px] bouncy-bounce sm:col-span-2 md:col-span-1">
                <div>
                    <div class="flex justify-between items-start">
                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl bg-emerald-50 border-2 md:border-3 border-[#0f172a] flex items-center justify-center shadow-[2px_2px_0px_#0f172a] group-hover:rotate-12 group-hover:bg-white bouncy-bounce">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <span class="font-pixel text-3xl md:text-4xl text-[#0c4cb4] group-hover:text-emerald-600 group-hover:scale-125 block bouncy-bounce tracking-tighter">03</span>
                    </div>

                    <h2 class="text-xl md:text-2xl font-900 text-[#0f172a] mt-6 md:mt-8 tracking-tight uppercase">Rekap Nilai</h2>
                    <p class="text-slate-500 text-xs font-700 mt-2 leading-relaxed">
                        Lihat rekapitulasi nilai seluruh siswa, berikan evaluasi, dan kelola arsip penilaian kelas.
                    </p>
                </div>
                <div class="mt-6 flex items-center gap-2 text-xs font-900 text-[#0c4cb4] group-hover:text-emerald-700 tracking-widest uppercase transition-colors">
                    <span>Buka Rekapitulasi</span>
                    <svg class="w-4 h-4 transform group-hover:translate-x-2 bouncy-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </div>
            </a>

        </section>
    </main>

</body>

</html>