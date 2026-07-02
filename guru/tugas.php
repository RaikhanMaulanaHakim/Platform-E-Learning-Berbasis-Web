<?php
include '../config/koneksi.php';
include '../config/session.php';

/** @var mysqli $koneksi */

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'guru') {
    header("Location: ../auth/login.php");
    exit();
}

$id_guru = $_SESSION['id_user'];
$query   = "SELECT * FROM tugas WHERE id_guru = '$id_guru' ORDER BY id_tugas DESC";
$tampil  = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Tugas - Guru</title>
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
        input:focus, select:focus, textarea:focus { outline: none; box-shadow: 3px 3px 0px #0f172a; }
    </style>
</head>
<body class="bg-canvas-denim text-[#0f172a] antialiased min-h-screen pb-12 selection:bg-yellow-300">

    <div class="max-w-6xl mx-auto px-4 pt-4 md:pt-6">
        <nav class="bg-white border-4 border-[#0f172a] rounded-2xl px-4 md:px-6 py-3 md:py-4 flex justify-between items-center shadow-[5px_5px_0px_#0f172a]">
            <a href="dashboard.php" class="group text-[11px] font-black uppercase bg-yellow-300 hover:bg-yellow-400 text-[#0f172a] px-3 py-2 rounded-xl border-2 border-[#0f172a] shadow-[2px_2px_0px_#0f172a] active:translate-x-[2px] active:translate-y-[2px] active:shadow-none transition-all flex items-center gap-1">
                <svg class="w-4 h-4 transform group-hover:-translate-x-1 bouncy-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                KEMBALI
            </a>
            <div class="text-xs font-black tracking-wide text-slate-700 bg-[#ffd32a] border-2 border-[#0f172a] px-3 py-1.5 rounded-xl">
                KELOLA TUGAS
            </div>
        </nav>
    </div>

    <main class="max-w-6xl mx-auto px-4 mt-6 md:mt-8 space-y-6">

        <section class="relative bg-[#a8ff78] border-4 border-[#0f172a] rounded-[2rem] p-8 shadow-[6px_6px_0px_#0f172a]">
            <div class="absolute inset-0 bg-[linear-gradient(rgba(0,0,0,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(0,0,0,0.02)_1px,transparent_1px)] bg-[size:16px_16px] pointer-events-none"></div>
            <div class="z-10 relative">
                <span class="inline-block bg-white border-2 border-[#0f172a] text-[10px] font-black tracking-widest px-2.5 py-1 rounded-md uppercase shadow-[2px_2px_0px_#0f172a] mb-2">PANEL TUGAS</span>
                <h1 class="text-2xl md:text-4xl font-black uppercase text-[#0f172a] leading-none">BUAT & KELOLA<br>TUGAS MURID</h1>
            </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="bg-white border-4 border-[#0f172a] rounded-[2rem] p-6 shadow-[5px_5px_0px_#0f172a] h-fit">
                <h3 class="text-base font-black uppercase text-[#0f172a] mb-5 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    Buat Tugas Baru
                </h3>

                <form action="proses_tugas.php" method="POST" class="space-y-4">
                    <input type="text" name="judul" required placeholder="Judul Tugas" class="w-full px-4 py-2.5 border-2 border-[#0f172a] rounded-xl text-sm font-bold bg-slate-50">
                    <textarea name="deskripsi" rows="4" required placeholder="Instruksi tugas..." class="w-full px-4 py-2.5 border-2 border-[#0f172a] rounded-xl text-sm font-bold bg-slate-50"></textarea>
                    <select name="kelas" required class="w-full px-4 py-2.5 border-2 border-[#0f172a] rounded-xl text-sm font-bold bg-slate-50"><option value="">-- Pilih Kelas --</option><?php for ($i = 1; $i <= 6; $i++): ?><option value="<?= $i ?>">Kelas <?= $i ?></option><?php endfor; ?></select>
                    <input type="datetime-local" name="deadline" required class="w-full px-4 py-2.5 border-2 border-[#0f172a] rounded-xl text-sm font-bold bg-slate-50">
                    <button type="submit" name="simpan_tugas" class="w-full bg-[#ffd32a] hover:bg-yellow-300 text-[#0f172a] font-black uppercase py-3 rounded-xl border-2 border-[#0f172a] shadow-[3px_3px_0px_#0f172a] transition-all text-sm">TERBITKAN</button>
                </form>
            </div>

            <div class="lg:col-span-2 space-y-4">
                <h3 class="text-base font-black uppercase text-white tracking-tight flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Tugas Yang Telah Dibuat
                </h3>

                <?php if (mysqli_num_rows($tampil) > 0):
                    $no = 1;
                    while ($data = mysqli_fetch_assoc($tampil)):
                ?>
                <div class="bg-white border-4 border-[#0f172a] rounded-[2rem] p-5 shadow-[5px_5px_0px_#0f172a]">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-start gap-3">
                            <span class="font-pixel text-2xl text-[#0c4cb4] shrink-0 mt-0.5"><?= str_pad($no, 2, '0', STR_PAD_LEFT); ?></span>
                            <div>
                                <h4 class="font-black text-[#0f172a] text-sm uppercase leading-tight"><?= htmlspecialchars($data['judul']); ?></h4>
                                <p class="text-red-600 text-[10px] font-black mt-1 uppercase">⏰ DEADLINE: <?= date('d M Y, H:i', strtotime($data['deadline'])); ?></p>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2 shrink-0">
                            <a href="penilaian.php?id_tugas=<?= $data['id_tugas']; ?>" class="text-[10px] font-black uppercase bg-[#0c4cb4] text-white px-3 py-1.5 rounded-lg border-2 border-[#0f172a] shadow-[2px_2px_0px_#0f172a] flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg> NILAI
                            </a>
                            <a href="proses_tugas.php?hapus=<?= $data['id_tugas']; ?>" onclick="return confirm('Yakin ingin menghapus tugas ini?')" class="text-[10px] font-black uppercase bg-[#ff4757] text-white px-3 py-1.5 rounded-lg border-2 border-[#0f172a] shadow-[2px_2px_0px_#0f172a] flex items-center gap-1 justify-center">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg> HAPUS
                            </a>
                        </div>
                    </div>
                </div>
                <?php $no++; endwhile;
                else: ?>
                <div class="bg-white border-4 border-[#0f172a] rounded-[2rem] p-8 text-center shadow-[5px_5px_0px_#0f172a]">
                    <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <p class="font-black uppercase text-slate-400 text-sm">Belum ada tugas dibuat.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>