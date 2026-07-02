<?php
include '../config/session.php';
include '../config/koneksi.php';

/** @var mysqli $koneksi */

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'murid') {
    header("Location: ../auth/login.php");
    exit();
}

$nama_panggilan = strtoupper(explode(' ', trim($_SESSION['nama']))[0]);
$kelas_murid    = mysqli_real_escape_string($koneksi, $_SESSION['kelas']);

$query  = "SELECT * FROM materi WHERE kelas = '$kelas_murid' ORDER BY id_materi DESC";
$result = mysqli_query($koneksi, $query);
$jumlah_materi = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materi Pelajaran - E-Learning</title>

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
            <div class="space-y-2 md:space-y-3 max-w-xl z-10 relative">
                <span class="inline-block bg-white border-2 border-[#0f172a] text-[#0f172a] text-[9px] md:text-[10px] font-black tracking-widest px-2.5 py-1 rounded-md uppercase shadow-[2px_2px_0px_#0f172a]">
                    ARSIP MATERI
                </span>
                <h1 class="text-2xl sm:text-3xl md:text-5xl font-black tracking-tight text-[#0f172a] uppercase leading-none">
                    DAFTAR MODUL<br>& BACAAN SISWA
                </h1>
                <p class="text-slate-800 text-xs md:text-sm font-bold leading-relaxed pt-1">
                    Berikut adalah daftar materi pembelajaran untuk kelas Anda. Klik tombol unduh untuk membuka dokumen.
                </p>
            </div>
        </section>

        <?php if ($jumlah_materi > 0): ?>

            <section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 md:gap-8">
                <?php $index = 1;
                while ($materi = mysqli_fetch_assoc($result)):
                    $nomor = str_pad($index, 2, '0', STR_PAD_LEFT);
                ?>
                    <div class="group bg-white border-4 border-[#0f172a] p-6 rounded-[2rem] shadow-[5px_5px_0px_#0f172a] hover:shadow-[10px_10px_0px_#a8ff78] hover:bg-[#f8fafc] transition-all hover:-translate-x-2 hover:-translate-y-2 flex flex-col justify-between min-h-[300px] bouncy-bounce">
                        <div>
                            <div class="flex justify-between items-start gap-2">
                                <span class="inline-block text-[10px] font-black tracking-wide uppercase bg-blue-100 text-[#0c4cb4] border-2 border-[#0f172a] px-2.5 py-1 rounded-lg shadow-[2px_2px_0px_#0f172a]">
                                    KELAS <?= htmlspecialchars($materi['kelas']); ?>
                                </span>
                                <span class="font-pixel text-3xl md:text-4xl text-[#0c4cb4] group-hover:text-emerald-600 group-hover:scale-125 block bouncy-bounce tracking-tighter">
                                    <?= $nomor; ?>
                                </span>
                            </div>

                            <h2 class="text-lg md:text-xl font-black text-[#0f172a] mt-6 tracking-tight uppercase leading-snug">
                                <?= htmlspecialchars($materi['judul']); ?>
                            </h2>

                            <p class="text-slate-400 text-[10px] font-black uppercase mt-1 tracking-wider">
                                <?php
                                if (!empty($materi['tgl_upload'])) {

                                    echo date('d-m-Y', strtotime($materi['tgl_upload']));
                                } else {
                                    echo "Tanggal tidak tersedia";
                                }
                                ?>
                            </p>

                            <?php if (!empty($materi['deskripsi'])): ?>
                                <p class="text-slate-500 text-xs font-bold mt-3 leading-relaxed line-clamp-3">
                                    <?= htmlspecialchars($materi['deskripsi']); ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <div class="mt-6 pt-4 border-t-2 border-dashed border-slate-200">
                            <a href="../uploads/materi/<?= htmlspecialchars($materi['file']); ?>"
                                target="_blank"
                                class="w-full text-center inline-block text-xs font-black uppercase bg-[#0c4cb4] hover:bg-[#0a3f96] text-white py-3 rounded-xl border-2 border-[#0f172a] shadow-[3px_3px_0px_#0f172a] active:translate-x-[2px] active:translate-y-[2px] active:shadow-none transition-all">
                                📄 Unduh Materi
                            </a>
                        </div>
                    </div>
                <?php $index++;
                endwhile; ?>
            </section>

        <?php else: ?>
            <!-- Kosong -->
            <section class="bg-white border-4 border-[#0f172a] rounded-[2rem] p-8 text-center shadow-[6px_6px_0px_#0f172a] max-w-2xl mx-auto">
                <div class="w-16 h-16 bg-amber-100 border-2 border-[#0f172a] rounded-2xl flex items-center justify-center mx-auto shadow-[3px_3px_0px_#0f172a] mb-6">
                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h2 class="text-xl md:text-2xl font-black text-[#0f172a] uppercase tracking-tight">Belum Ada Materi</h2>
                <p class="text-slate-500 text-xs md:text-sm font-bold mt-2 leading-relaxed max-w-md mx-auto">
                    Guru belum mengunggah materi untuk kelas <?= htmlspecialchars($_SESSION['kelas']); ?>. Periksa kembali nanti.
                </p>
            </section>
        <?php endif; ?>

    </main>

</body>

</html>