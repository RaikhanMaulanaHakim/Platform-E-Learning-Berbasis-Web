<?php
date_default_timezone_set('Asia/Jakarta');
include '../config/session.php';
include '../config/koneksi.php';

/** @var mysqli $koneksi */

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'murid') {
    header("Location: ../auth/login.php");
    exit();
}

$id_murid    = $_SESSION['id_user'];
$kelas_murid = mysqli_real_escape_string($koneksi, $_SESSION['kelas']);

$query = "SELECT tugas.*,
                 (SELECT COUNT(*) FROM pengumpulan
                  WHERE pengumpulan.id_tugas = tugas.id_tugas
                  AND pengumpulan.id_murid = '$id_murid') AS sudah_kumpul
          FROM tugas
          WHERE CAST(kelas AS CHAR) = '$kelas_murid'
          ORDER BY id_tugas DESC";

$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tugas - E-Learning</title>

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

    <main class="max-w-5xl mx-auto px-4 mt-6 md:mt-8 space-y-6 md:space-y-8">

        <section class="bg-[#a8ff78] border-4 border-[#0f172a] rounded-[2rem] p-6 md:p-10 shadow-[6px_6px_0px_#0f172a] relative overflow-hidden">
            <div class="absolute inset-0 bg-[linear-gradient(rgba(0,0,0,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(0,0,0,0.02)_1px,transparent_1px)] bg-[size:16px_16px] pointer-events-none"></div>
            <div class="space-y-2 z-10 relative">
                <span class="inline-block bg-white border-2 border-[#0f172a] text-[#0f172a] text-[9px] font-black tracking-widest px-2.5 py-1 rounded-md uppercase shadow-[2px_2px_0px_#0f172a]">
                    TUGAS HARIAN
                </span>
                <h1 class="text-2xl sm:text-3xl md:text-5xl font-black tracking-tight text-[#0f172a] uppercase leading-none">
                    DAFTAR TUGAS<br>KELAS <?= htmlspecialchars($_SESSION['kelas']); ?>
                </h1>
                <p class="text-slate-800 text-xs md:text-sm font-bold pt-1">
                    Selesaikan setiap tugas sebelum batas waktu. Klik tombol untuk mengerjakan atau melihat jawaban.
                </p>
            </div>
        </section>

        <?php if ($result && mysqli_num_rows($result) > 0): ?>

        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            <?php $no = 1; while ($t = mysqli_fetch_assoc($result)):
                $id     = $t['id_tugas'];
                $judul  = $t['judul'];
                $batas  = $t['deadline'];
                $desk   = $t['deskripsi'];
                $status = $t['sudah_kumpul'] > 0;
                $expired = strtotime($batas) < time();
                $nomor  = str_pad($no, 2, '0', STR_PAD_LEFT);
            ?>
            <div class="bg-white border-4 border-[#0f172a] p-6 rounded-[2rem] shadow-[5px_5px_0px_#0f172a] flex flex-col justify-between min-h-[280px]">
                <div>
                    <div class="flex justify-between items-start">
                        <span class="inline-block
                            <?= $status ? 'bg-green-100 text-green-700' : ($expired ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-[#0c4cb4]'); ?>
                            border-2 border-[#0f172a] text-[10px] font-black uppercase px-2.5 py-1 rounded-lg shadow-[2px_2px_0px_#0f172a]">
                            <?= $status ? '✅ Terkumpul' : ($expired ? '❌ Kadaluarsa' : '📌 Aktif'); ?>
                        </span>
                        <span class="font-pixel text-3xl text-[#0c4cb4] tracking-tighter"><?= $nomor; ?></span>
                    </div>

                    <h2 class="text-lg font-black text-[#0f172a] mt-4 uppercase leading-snug">
                        <?= htmlspecialchars($judul); ?>
                    </h2>

                    <p class="text-red-600 text-[10px] font-bold mt-2 uppercase tracking-wider">
                        ⏰ <?= date('d M Y, H:i', strtotime($batas)); ?> WIB
                    </p>

                    <?php if (!empty($desk)): ?>
                    <p class="text-gray-500 text-xs mt-3 leading-relaxed line-clamp-2">
                        <?= htmlspecialchars($desk); ?>
                    </p>
                    <?php endif; ?>
                </div>

                <div class="mt-5 pt-4 border-t-2 border-dashed border-slate-200">
                    <?php if ($status): ?>
                        <a href="lihat_jawaban.php?id=<?= $id ?>"
                           class="block text-center text-xs font-black uppercase bg-green-500 hover:bg-green-600 text-white py-3 rounded-xl border-2 border-[#0f172a] shadow-[3px_3px_0px_#0f172a] active:translate-x-[1px] active:translate-y-[1px] active:shadow-none transition-all">
                            ✅ LIHAT JAWABAN
                        </a>
                    <?php elseif ($expired): ?>
                        <span class="block text-center text-xs font-black uppercase bg-gray-200 text-gray-500 py-3 rounded-xl border-2 border-[#0f172a]">
                            ❌ WAKTU HABIS
                        </span>
                    <?php else: ?>
                        <a href="kerjakan_tugas.php?id=<?= $id ?>"
                           class="block text-center text-xs font-black uppercase bg-[#0c4cb4] hover:bg-[#0a3f96] text-white py-3 rounded-xl border-2 border-[#0f172a] shadow-[3px_3px_0px_#0f172a] active:translate-x-[1px] active:translate-y-[1px] active:shadow-none transition-all">
                            🚀 KERJAKAN TUGAS
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php $no++; endwhile; ?>
        </section>

        <?php else: ?>
        <!-- Kosong -->
        <section class="bg-white border-4 border-[#0f172a] rounded-[2rem] p-8 text-center shadow-[6px_6px_0px_#0f172a] max-w-2xl mx-auto">
            <p class="text-5xl mb-4">🎉</p>
            <h2 class="text-xl font-black text-[#0f172a] uppercase">Tidak Ada Tugas Saat Ini</h2>
            <p class="text-slate-500 text-sm font-bold mt-2">Guru belum memberikan tugas untuk kelas <?= htmlspecialchars($_SESSION['kelas']); ?>.</p>
        </section>
        <?php endif; ?>

    </main>

</body>
</html>