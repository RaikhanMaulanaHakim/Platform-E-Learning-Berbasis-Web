<?php
include __DIR__ . '/../config/session.php';
include __DIR__ . '/../config/koneksi.php';

/** @var mysqli $koneksi */

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'murid') {
    header("Location: ../auth/login.php");
    exit();
}

$id_tugas = intval($_GET['id'] ?? 0);
$id_murid = $_SESSION['id_user'];

if ($id_tugas === 0) {
    header("Location: tugas.php");
    exit();
}

$sql   = "SELECT p.*, t.judul, t.deadline
          FROM pengumpulan p
          JOIN tugas t ON p.id_tugas = t.id_tugas
          WHERE p.id_tugas = '$id_tugas' AND p.id_murid = '$id_murid'";
$query = mysqli_query($koneksi, $sql);
$data  = mysqli_fetch_assoc($query);

if (!$data) {
    header("Location: kerjakan_tugas.php?id=$id_tugas");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Jawaban - E-Learning</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/output.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bg-canvas-denim {
            background-color: #0c4cb4;
            background-image: linear-gradient(90deg, rgba(255,255,255,0.09) 50%, transparent 50%),
                              linear-gradient(rgba(255,255,255,0.09) 50%, transparent 50%);
            background-size: 3px 3px;
        }
    </style>
</head>

<body class="bg-canvas-denim min-h-screen p-4 md:p-8 flex items-center justify-center">

    <div class="w-full max-w-2xl">
        <div class="bg-white border-4 border-[#0f172a] rounded-[2rem] p-6 md:p-8 shadow-[8px_8px_0px_#0f172a]">

            <a href="tugas.php" class="text-xs font-black uppercase tracking-wider text-slate-500 hover:text-[#0c4cb4] mb-6 block transition-colors">
                ← Kembali ke Daftar Tugas
            </a>

            <div class="mb-6">
                <span class="inline-block bg-green-100 text-green-700 border-2 border-[#0f172a] text-[10px] font-black uppercase px-2.5 py-1 rounded-lg mb-3 shadow-[2px_2px_0px_#0f172a]">
                    ✅ SUDAH DIKUMPULKAN
                </span>
                <h1 class="text-2xl font-black uppercase text-[#0f172a] leading-tight">
                    <?= htmlspecialchars($data['judul']); ?>
                </h1>
                <p class="text-gray-500 text-xs mt-2">
                    Dikumpulkan pada: <strong><?= date('d M Y, H:i', strtotime($data['waktu_kumpul'])); ?></strong>
                </p>
            </div>

            <div class="bg-slate-50 border-2 border-[#0f172a] rounded-2xl p-4 mb-6 shadow-[3px_3px_0px_#0f172a]">
                <p class="text-xs font-black uppercase tracking-widest text-slate-500 mb-2">File Jawaban</p>
                <p class="text-sm font-bold text-gray-700 break-all"><?= htmlspecialchars($data['file_tugas']); ?></p>
                <a href="../uploads/pengumpulan/<?= htmlspecialchars($data['file_tugas']); ?>"
                   target="_blank"
                   class="mt-3 inline-block text-xs font-black uppercase bg-[#0c4cb4] text-white px-4 py-2 rounded-xl border-2 border-[#0f172a] shadow-[2px_2px_0px_#0f172a] hover:bg-[#0a3f96] transition-all">
                    📄 Lihat / Unduh File
                </a>
            </div>

            <div class="border-2 border-[#0f172a] rounded-2xl p-4 shadow-[3px_3px_0px_#0f172a]
                        <?= $data['nilai'] !== null ? 'bg-emerald-50' : 'bg-amber-50'; ?>">
                <p class="text-xs font-black uppercase tracking-widest text-slate-500 mb-1">Nilai</p>
                <?php if ($data['nilai'] !== null): ?>
                    <p class="text-4xl font-black text-emerald-600"><?= htmlspecialchars($data['nilai']); ?><span class="text-xl text-slate-400">/100</span></p>
                <?php else: ?>
                    <p class="text-lg font-black text-amber-600">Menunggu Penilaian Guru ⏳</p>
                    <p class="text-xs text-slate-400 mt-1">Guru belum memberikan nilai. Periksa kembali nanti.</p>
                <?php endif; ?>
            </div>

            <p class="text-center text-[10px] text-slate-400 mt-6 font-semibold uppercase">
                Untuk mengubah jawaban, hubungi guru kelas.
            </p>

        </div>
    </div>

</body>
</html>