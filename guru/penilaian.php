<?php
require_once '../config/koneksi.php';
require_once '../config/session.php';

/** @var mysqli $koneksi */

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'guru') {
    header("Location: ../auth/login.php");
    exit();
}

if (!isset($_GET['id_tugas']) || empty($_GET['id_tugas'])) {
    header("Location: tugas.php");
    exit();
}

$id_tugas   = mysqli_real_escape_string($koneksi, $_GET['id_tugas']);
$q_tugas    = mysqli_query($koneksi, "SELECT * FROM tugas WHERE id_tugas = '$id_tugas'");
$data_tugas = mysqli_fetch_assoc($q_tugas);

if (!$data_tugas) { header("Location: tugas.php"); exit(); }

$query = "SELECT pengumpulan.*, users.nama AS nama_murid
          FROM pengumpulan
          JOIN users ON pengumpulan.id_murid = users.id_user
          WHERE pengumpulan.id_tugas = '$id_tugas'
          ORDER BY users.nama ASC";

$hasil = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian Tugas - Guru</title>
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
        input[type=number]:focus { outline: none; box-shadow: 3px 3px 0px #0f172a; }
    </style>
</head>
<body class="bg-canvas-denim text-[#0f172a] antialiased min-h-screen pb-12 selection:bg-yellow-300">

    <div class="max-w-5xl mx-auto px-4 pt-4 md:pt-6">
        <nav class="bg-white border-4 border-[#0f172a] rounded-2xl px-4 md:px-6 py-3 md:py-4 flex justify-between items-center shadow-[5px_5px_0px_#0f172a]">
            <a href="tugas.php" class="group text-[11px] font-black uppercase bg-yellow-300 hover:bg-yellow-400 text-[#0f172a] px-3 py-2 rounded-xl border-2 border-[#0f172a] shadow-[2px_2px_0px_#0f172a] active:translate-x-[2px] active:translate-y-[2px] active:shadow-none transition-all flex items-center gap-1">
                <svg class="w-4 h-4 transform group-hover:-translate-x-1 bouncy-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                KEMBALI
            </a>
            <div class="text-xs font-black tracking-wide text-slate-700 bg-[#ffd32a] border-2 border-[#0f172a] px-3 py-1.5 rounded-xl">
                 PENILAIAN TUGAS
            </div>
        </nav>
    </div>

    <main class="max-w-5xl mx-auto px-4 mt-6 md:mt-8 space-y-6">

        <section class="relative bg-[#a8ff78] border-4 border-[#0f172a] rounded-[2rem] p-8 shadow-[6px_6px_0px_#0f172a]">
            <div class="absolute inset-0 bg-[linear-gradient(rgba(0,0,0,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(0,0,0,0.02)_1px,transparent_1px)] bg-[size:16px_16px] pointer-events-none"></div>
            <div class="z-10 relative">
                <span class="inline-block bg-white border-2 border-[#0f172a] text-[10px] font-black tracking-widest px-2.5 py-1 rounded-md uppercase shadow-[2px_2px_0px_#0f172a] mb-2">JAWABAN MASUK</span>
                <h1 class="text-xl md:text-3xl font-black uppercase text-[#0f172a] leading-tight"><?= htmlspecialchars($data_tugas['judul']); ?></h1>
                <div class="flex flex-wrap gap-3 mt-2">
                    <span class="text-[10px] font-black uppercase text-[#0f172a]/70">Kelas <?= htmlspecialchars($data_tugas['kelas']); ?></span>
                    <span class="text-[10px] font-black uppercase text-red-700">⏰ Deadline: <?= date('d M Y, H:i', strtotime($data_tugas['deadline'])); ?></span>
                </div>
            </div>
        </section>

        <div class="bg-white border-4 border-[#0f172a] rounded-[2rem] p-6 shadow-[5px_5px_0px_#0f172a]">

            <?php if (mysqli_num_rows($hasil) > 0):
                $no = 1;
                while ($row = mysqli_fetch_assoc($hasil)): ?>
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b-2 border-dashed border-slate-200 py-4 last:border-0 last:pb-0 first:pt-0">
                <div class="flex items-center gap-3">
                    <span class="font-pixel text-xl text-[#0c4cb4] shrink-0"><?= str_pad($no, 2, '0', STR_PAD_LEFT); ?></span>
                    <div>
                        <p class="font-black text-[#0f172a] text-sm uppercase"><?= htmlspecialchars($row['nama_murid']); ?></p>
                        <p class="text-slate-400 text-[10px] font-semibold"><?= date('d M Y, H:i', strtotime($row['waktu_kumpul'])); ?></p>
                    </div>
                </div>
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <a href="../uploads/pengumpulan/<?= htmlspecialchars($row['file_tugas']); ?>" target="_blank"
                        class="text-[10px] font-black uppercase bg-[#0c4cb4] text-white px-3 py-2 rounded-xl border-2 border-[#0f172a] shadow-[2px_2px_0px_#0f172a] hover:bg-[#0a3f96] active:shadow-none active:translate-x-[1px] active:translate-y-[1px] transition-all whitespace-nowrap">
                        Unduh
                    </a>
                    <form action="proses_nilai.php" method="POST" class="flex items-center gap-2">
                        <input type="hidden" name="id_pengumpulan" value="<?= $row['id_pengumpulan']; ?>">
                        <input type="number" name="nilai"
                               value="<?= htmlspecialchars($row['nilai'] ?? ''); ?>"
                               min="0" max="100" required
                               placeholder="0-100"
                               class="w-20 text-center border-2 border-[#0f172a] rounded-xl px-2 py-1.5 text-sm font-black bg-slate-50">
                        <button type="submit"
                            class="text-[10px] font-black uppercase bg-[#a8ff78] hover:bg-green-300 text-[#0f172a] px-3 py-2 rounded-xl border-2 border-[#0f172a] shadow-[2px_2px_0px_#0f172a] active:shadow-none active:translate-x-[1px] active:translate-y-[1px] transition-all whitespace-nowrap">
                            Simpan
                        </button>
                    </form>
                </div>
            </div>
            <?php $no++; endwhile;
            else: ?>
            <div class="text-center py-12">
                <p class="text-4xl mb-3">📭</p>
                <p class="font-black uppercase text-slate-400 text-sm">Belum ada murid yang mengumpulkan tugas ini.</p>
            </div>
            <?php endif; ?>
        </div>
    </main>

</body>
</html>
