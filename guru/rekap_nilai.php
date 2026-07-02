<?php
include '../config/koneksi.php';
include '../config/session.php';

/** @var mysqli $koneksi */

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'guru') {
    header("Location: ../auth/login.php");
    exit();
}

$id_guru = $_SESSION['id_user'];

$query = "SELECT users.nama AS nama_murid, users.kelas, tugas.judul AS judul_tugas,
                 pengumpulan.waktu_kumpul, pengumpulan.nilai
          FROM pengumpulan
          JOIN users ON pengumpulan.id_murid = users.id_user
          JOIN tugas ON pengumpulan.id_tugas = tugas.id_tugas
          WHERE tugas.id_guru = '$id_guru'
          ORDER BY users.nama ASC, tugas.judul ASC";

$hasil = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Nilai - Guru</title>
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
            <a href="dashboard.php" class="group text-[11px] font-black uppercase bg-yellow-300 hover:bg-yellow-400 text-[#0f172a] px-3 py-2 rounded-xl border-2 border-[#0f172a] shadow-[2px_2px_0px_#0f172a] active:translate-x-[2px] active:translate-y-[2px] active:shadow-none transition-all flex items-center gap-1">
                <svg class="w-4 h-4 transform group-hover:-translate-x-1 bouncy-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                KEMBALI
            </a>
            <div class="text-xs font-black tracking-wide text-slate-700 bg-[#ffd32a] border-2 border-[#0f172a] px-3 py-1.5 rounded-xl">
                REKAP NILAI
            </div>
        </nav>
    </div>

    <main class="max-w-5xl mx-auto px-4 mt-6 md:mt-8 space-y-6">

        <section class="relative bg-[#a8ff78] border-4 border-[#0f172a] rounded-[2rem] p-8 shadow-[6px_6px_0px_#0f172a]">
            <div class="absolute inset-0 bg-[linear-gradient(rgba(0,0,0,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(0,0,0,0.02)_1px,transparent_1px)] bg-[size:16px_16px] pointer-events-none"></div>
            <div class="z-10 relative">
                <span class="inline-block bg-white border-2 border-[#0f172a] text-[10px] font-black tracking-widest px-2.5 py-1 rounded-md uppercase shadow-[2px_2px_0px_#0f172a] mb-2">EVALUASI</span>
                <h1 class="text-2xl md:text-4xl font-black uppercase text-[#0f172a] leading-none">REKAP NILAI<br>SELURUH MURID</h1>
                <p class="text-[#0f172a]/70 text-xs font-bold mt-2">Daftar nilai dari semua pengumpulan tugas yang sudah dinilai.</p>
            </div>
        </section>

        <div class="bg-white border-4 border-[#0f172a] rounded-[2rem] p-6 shadow-[5px_5px_0px_#0f172a]">

            <?php if (mysqli_num_rows($hasil) > 0):
                $no = 1;
                while ($row = mysqli_fetch_assoc($hasil)): ?>
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 border-b-2 border-dashed border-slate-200 py-4 last:border-0 last:pb-0 first:pt-0">
                <div class="flex items-center gap-3">
                    <span class="font-pixel text-xl text-[#0c4cb4] shrink-0"><?= str_pad($no, 2, '0', STR_PAD_LEFT); ?></span>
                    <div>
                        <p class="font-black text-[#0f172a] text-sm uppercase"><?= htmlspecialchars($row['nama_murid']); ?></p>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span class="inline-block bg-[#ffd32a] border border-[#0f172a] text-[10px] font-black uppercase px-2 py-0.5 rounded-md">Kelas <?= htmlspecialchars($row['kelas']); ?></span>
                            <span class="text-[10px] text-slate-400 font-semibold"><?= htmlspecialchars($row['judul_tugas']); ?></span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <span class="text-[10px] text-slate-400 font-semibold"><?= date('d M Y', strtotime($row['waktu_kumpul'])); ?></span>
                    <?php if ($row['nilai'] !== null): ?>
                        <div class="border-2 border-[#0f172a] rounded-xl px-4 py-2 shadow-[2px_2px_0px_#0f172a] text-center
                            <?= $row['nilai'] >= 75 ? 'bg-[#a8ff78]' : ($row['nilai'] >= 60 ? 'bg-[#ffd32a]' : 'bg-red-100'); ?>">
                            <p class="font-black text-xl text-[#0f172a]"><?= $row['nilai']; ?></p>
                        </div>
                    <?php else: ?>
                        <span class="bg-slate-100 border-2 border-slate-300 text-slate-400 text-[10px] font-black uppercase px-3 py-2 rounded-xl">
                            BELUM DINILAI
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            <?php $no++; endwhile;
            else: ?>
            <div class="text-center py-12">
                <p class="text-4xl mb-3"><svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></p>
                <p class="font-black uppercase text-slate-400 text-sm">Belum ada pengumpulan tugas.</p>
            </div>
            <?php endif; ?>
        </div>
    </main>

</body>
</html>
