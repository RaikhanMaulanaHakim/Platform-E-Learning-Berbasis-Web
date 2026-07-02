<?php
include_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/koneksi.php';

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

$sql   = "SELECT * FROM tugas WHERE id_tugas = '$id_tugas'";
$query = mysqli_query($koneksi, $sql);
$tugas = mysqli_fetch_assoc($query);

if (!$tugas) {
    header("Location: tugas.php");
    exit();
}

$cek = mysqli_query($koneksi, "SELECT id_pengumpulan FROM pengumpulan WHERE id_tugas='$id_tugas' AND id_murid='$id_murid'");
if (mysqli_num_rows($cek) > 0) {
    header("Location: lihat_jawaban.php?id=$id_tugas");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kerjakan Tugas - E-Learning</title>

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

            <a href="tugas.php" class="text-xs font-black uppercase tracking-wider text-slate-500 hover:text-[#0c4cb4] mb-6 block flex items-center gap-1 transition-colors">
                ← Kembali ke Daftar Tugas
            </a>

            <div class="mb-6">
                <span class="inline-block bg-blue-100 text-[#0c4cb4] border-2 border-[#0f172a] text-[10px] font-black uppercase px-2.5 py-1 rounded-lg mb-3">
                    Kelas <?= htmlspecialchars($tugas['kelas']); ?>
                </span>
                <h1 class="text-2xl font-black uppercase text-[#0f172a] leading-tight">
                    <?= htmlspecialchars($tugas['judul']); ?>
                </h1>
                <p class="text-red-600 text-xs font-bold mt-2">
                    ⏰ Deadline: <?= date('d M Y, H:i', strtotime($tugas['deadline'])); ?> WIB
                </p>
                <?php if (!empty($tugas['deskripsi'])): ?>
                <p class="text-gray-600 text-sm mt-3 leading-relaxed border-l-4 border-[#0c4cb4] pl-3">
                    <?= nl2br(htmlspecialchars($tugas['deskripsi'])); ?>
                </p>
                <?php endif; ?>
            </div>

            <div class="border-t-2 border-dashed border-slate-200 pt-6">
                <h2 class="text-sm font-black uppercase tracking-widest text-slate-700 mb-4">Upload Jawaban</h2>

                <form action="proses_kumpul_tugas.php" method="POST" enctype="multipart/form-data" class="space-y-4">
                    <input type="hidden" name="id_tugas" value="<?= $id_tugas ?>">
                    <input type="hidden" name="kumpul_tugas" value="1">

                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-600 mb-2">
                            Pilih File Jawaban <span class="text-slate-400 normal-case font-semibold">(PDF, DOC, DOCX, ZIP, RAR)</span>
                        </label>
                        <input type="file" name="file_jawaban"
                               accept=".pdf,.doc,.docx,.zip,.rar"
                               required
                               class="w-full text-sm border-2 border-[#0f172a] rounded-xl p-3 bg-slate-50 cursor-pointer file:mr-3 file:py-1.5 file:px-4 file:rounded-lg file:border-2 file:border-[#0f172a] file:text-xs file:font-black file:bg-yellow-300 file:text-[#0f172a] hover:file:bg-yellow-400 file:cursor-pointer">
                    </div>

                    <button type="submit"
                        class="w-full bg-[#0c4cb4] hover:bg-[#0a3f96] text-white font-black uppercase py-3.5 rounded-xl border-2 border-[#0f172a] shadow-[4px_4px_0px_#0f172a] active:translate-x-1 active:translate-y-1 active:shadow-none transition-all text-sm tracking-wider">
                        KIRIM JAWABAN
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>