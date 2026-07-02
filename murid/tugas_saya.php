<?php
include '../config/koneksi.php';
include '../config/session.php';

/** @var mysqli $koneksi */

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'murid') {
    header("Location: ../auth/login.php");
    exit();
}

$id_murid = $_SESSION['id_user'];

$query = "SELECT pengumpulan.*, tugas.judul AS judul_tugas, tugas.deadline
          FROM pengumpulan
          JOIN tugas ON pengumpulan.id_tugas = tugas.id_tugas
          WHERE pengumpulan.id_murid = '$id_murid'
          ORDER BY pengumpulan.waktu_kumpul DESC";

$hasil = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat & Nilai - E-Learning</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DotGothic16&family=Plus+Jakarta+Sans:wght@700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/output.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-pixel { font-family: 'DotGothic16', sans-serif; }
        .bg-canvas-denim {
            background-color: #0c4cb4;
            background-image: linear-gradient(90deg, rgba(255,255,255,0.09) 50%, transparent 50%),
                              linear-gradient(rgba(255,255,255,0.09) 50%, transparent 50%);
            background-size: 3px 3px;
        }
        .bouncy-bounce { transition: all 0.4s cubic-bezier(0.68,-0.60,0.32,1.60); }
    </style>
</head>

<body class="bg-canvas-denim text-[#0f172a] antialiased min-h-screen pb-12 selection:bg-yellow-300">

    <div class="max-w-5xl mx-auto px-4 pt-4 md:pt-6">
        <nav class="bg-white border-4 border-[#0f172a] rounded-2xl px-4 md:px-6 py-3 md:py-4 flex justify-between items-center shadow-[5px_5px_0px_#0f172a]">
            <a href="dashboard.php" class="group text-[11px] md:text-xs font-black uppercase bg-yellow-300 hover:bg-yellow-400 text-[#0f172a] px-3 md:px-4 py-2 rounded-xl border-2 border-[#0f172a] shadow-[2px_2px_0px_#0f172a] active:translate-x-[2px] active:translate-y-[2px] active:shadow-none transition-all flex items-center gap-1">
                <svg class="w-4 h-4 transform group-hover:-translate-x-1 bouncy-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>KEMBALI</span>
            </a>
            <div class="text-[11px] md:text-xs font-black tracking-wide text-slate-700 bg-slate-50 border-2 border-[#0f172a] px-3 md:px-4 py-2 rounded-xl">
                KELAS: <span class="text-[#0c4cb4]"><?= htmlspecialchars($_SESSION['kelas']); ?></span>
            </div>
        </nav>
    </div>

    <main class="max-w-5xl mx-auto px-4 mt-6 md:mt-8 space-y-6">

        <section class="bg-[#a8ff78] border-4 border-[#0f172a] rounded-[2rem] p-6 md:p-10 shadow-[6px_6px_0px_#0f172a] relative overflow-hidden">
            <div class="absolute inset-0 bg-[linear-gradient(rgba(0,0,0,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(0,0,0,0.02)_1px,transparent_1px)] bg-[size:16px_16px] pointer-events-none"></div>
            <div class="space-y-2 z-10 relative">
                <span class="inline-block bg-white border-2 border-[#0f172a] text-[#0f172a] text-[9px] font-black tracking-widest px-2.5 py-1 rounded-md uppercase shadow-[2px_2px_0px_#0f172a]">
                    EVALUASI NILAI
                </span>
                <h1 class="text-2xl sm:text-3xl md:text-5xl font-black tracking-tight text-[#0f172a] uppercase leading-none">
                    RIWAYAT &<br>NILAI SAYA
                </h1>
                <p class="text-slate-800 text-xs md:text-sm font-bold pt-1">
                    Berikut adalah semua tugas yang sudah kamu kumpulkan beserta nilainya.
                </p>
            </div>
        </section>

        <?php if (mysqli_num_rows($hasil) > 0): ?>

        <section class="space-y-4">
            <?php $no = 1; while ($row = mysqli_fetch_assoc($hasil)): ?>
            <div class="bg-white border-4 border-[#0f172a] rounded-[1.5rem] p-5 shadow-[5px_5px_0px_#0f172a] flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex items-start gap-4">
                    <span class="font-pixel text-3xl text-[#0c4cb4] shrink-0 mt-1"><?= str_pad($no, 2, '0', STR_PAD_LEFT); ?></span>
                    <div>
                        <h3 class="font-black text-[#0f172a] uppercase text-sm leading-tight">
                            <?= htmlspecialchars($row['judul_tugas']); ?>
                        </h3>
                        <p class="text-slate-400 text-[10px] font-semibold uppercase mt-1 tracking-wider">
                            Dikumpulkan: <?= date('d M Y, H:i', strtotime($row['waktu_kumpul'])); ?>
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3 shrink-0">
                    <?php if ($row['nilai'] !== null): ?>
                        <div class="text-center border-2 border-[#0f172a] rounded-xl px-4 py-2 shadow-[2px_2px_0px_#0f172a]
                            <?= $row['nilai'] >= 75 ? 'bg-emerald-100' : ($row['nilai'] >= 60 ? 'bg-yellow-100' : 'bg-red-100'); ?>">
                            <p class="text-[10px] font-black uppercase text-slate-500">Nilai</p>
                            <p class="text-2xl font-black <?= $row['nilai'] >= 75 ? 'text-emerald-600' : ($row['nilai'] >= 60 ? 'text-yellow-600' : 'text-red-600'); ?>">
                                <?= $row['nilai']; ?>
                            </p>
                        </div>
                    <?php else: ?>
                        <span class="bg-amber-100 text-amber-700 border-2 border-[#0f172a] text-[10px] font-black uppercase px-3 py-2 rounded-xl shadow-[2px_2px_0px_#0f172a]">
                        Belum Dinilai
                        </span>
                    <?php endif; ?>

                    <a href="lihat_jawaban.php?id=<?= $row['id_tugas']; ?>"
                       class="ml-auto bg-[#0c4cb4] hover:bg-[#0a3f96] text-white text-[10px] font-black uppercase px-3 py-2 rounded-xl border-2 border-[#0f172a] shadow-[2px_2px_0px_#0f172a] active:translate-x-[1px] active:translate-y-[1px] active:shadow-none transition-all">
                        Lihat →
                    </a>
                </div>
            </div>
            <?php $no++; endwhile; ?>
        </section>

        <?php else: ?>
        <!-- Kosong -->
        <section class="bg-white border-4 border-[#0f172a] rounded-[2rem] p-8 text-center shadow-[6px_6px_0px_#0f172a]">
            <p class="text-5xl mb-4">📭</p>
            <h2 class="text-xl font-black text-[#0f172a] uppercase">Belum Ada Tugas Dikumpulkan</h2>
            <p class="text-slate-500 text-sm font-bold mt-2">Pergi ke menu Tugas Siswa dan kumpulkan tugasmu!</p>
            <a href="tugas.php" class="mt-6 inline-block bg-[#0c4cb4] text-white font-black uppercase text-xs px-6 py-3 rounded-xl border-2 border-[#0f172a] shadow-[3px_3px_0px_#0f172a] hover:bg-[#0a3f96] transition-all">
                Lihat Tugas →
            </a>
        </section>
        <?php endif; ?>

    </main>

</body>
</html>