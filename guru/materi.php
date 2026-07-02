<?php
include '../config/koneksi.php';
include '../config/session.php';

/** @var mysqli $koneksi */

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'guru') {
    header("Location: ../auth/login.php");
    exit();
}

$id_guru = $_SESSION['id_user'];
$query   = "SELECT * FROM materi WHERE id_guru = '$id_guru' ORDER BY id_materi DESC";
$tampil  = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Materi - Guru</title>
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
    </style>
</head>
<body class="bg-canvas-denim text-[#0f172a] antialiased min-h-screen pb-12">

    <div class="max-w-6xl mx-auto px-4 pt-6">
        <nav class="bg-white border-4 border-[#0f172a] rounded-2xl px-6 py-4 flex justify-between items-center shadow-[5px_5px_0px_#0f172a]">
            <a href="dashboard.php" class="text-[11px] font-black uppercase bg-yellow-300 hover:bg-yellow-400 px-4 py-2 rounded-xl border-2 border-[#0f172a] shadow-[2px_2px_0px_#0f172a] transition-all duration-200 hover:-translate-y-1 hover:shadow-[4px_4px_0px_#0f172a] flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                KEMBALI
            </a>
            <div class="text-xs font-black tracking-wide bg-[#ffd32a] border-2 border-[#0f172a] px-4 py-2 rounded-xl">KELOLA MATERI</div>
        </nav>
    </div>

    <main class="max-w-6xl mx-auto px-4 mt-8 space-y-6">
        <section class="relative bg-[#a8ff78] border-4 border-[#0f172a] rounded-[2rem] p-8 shadow-[6px_6px_0px_#0f172a]">
            <div class="absolute inset-0 bg-[linear-gradient(rgba(0,0,0,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(0,0,0,0.02)_1px,transparent_1px)] bg-[size:16px_16px] pointer-events-none"></div>
            <div class="z-10 relative">
                <span class="inline-block bg-white border-2 border-[#0f172a] text-[10px] font-black tracking-widest px-2.5 py-1 rounded-md uppercase shadow-[2px_2px_0px_#0f172a] mb-2">PANEL MATERI</span>
                <h1 class="text-2xl md:text-4xl font-black uppercase text-[#0f172a] leading-none">BUAT & KELOLA<br>MATERI PELAJARAN</h1>
                <p class="text-[#0f172a]/70 text-xs font-bold mt-2">Upload materi pelajaran baru, lihat daftar materi, dan kelola konten belajar.</p>
            </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="bg-white border-4 border-[#0f172a] rounded-[2rem] p-6 shadow-[5px_5px_0px_#0f172a] h-fit">
                <h3 class="text-base font-black uppercase mb-5 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg> Tambah Materi
                </h3>
                <form action="proses_materi.php" method="POST" enctype="multipart/form-data" class="space-y-4">
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-600 mb-1">Judul Materi</label>
                        <input type="text" name="judul" required class="w-full px-4 py-2 border-2 border-[#0f172a] rounded-xl text-sm font-bold bg-slate-50 transition-all duration-200 hover:shadow-[2px_2px_0px_#0f172a] focus:shadow-[2px_2px_0px_#0f172a] outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-600 mb-1">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" required class="w-full px-4 py-2 border-2 border-[#0f172a] rounded-xl text-sm font-bold bg-slate-50 transition-all duration-200 hover:shadow-[2px_2px_0px_#0f172a] focus:shadow-[2px_2px_0px_#0f172a] outline-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-600 mb-1">Untuk Kelas</label>
                        <select name="kelas" required class="w-full px-4 py-2 border-2 border-[#0f172a] rounded-xl text-sm font-bold bg-slate-50 transition-all duration-200 hover:shadow-[2px_2px_0px_#0f172a] focus:shadow-[2px_2px_0px_#0f172a] outline-none">
                            <option value="">-- Pilih Kelas --</option>
                            <?php for ($i = 1; $i <= 6; $i++): ?><option value="<?= $i ?>">Kelas <?= $i ?></option><?php endfor; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-600 mb-1">File</label>
                        <input type="file" name="file_materi" required class="w-full text-xs border-2 border-[#0f172a] rounded-xl p-2 bg-slate-50 transition-all duration-200 hover:shadow-[2px_2px_0px_#0f172a] outline-none">
                    </div>
                    <button type="submit" name="simpan" class="w-full bg-[#0c4cb4] text-white font-black uppercase py-3 rounded-xl border-2 border-[#0f172a] shadow-[3px_3px_0px_#0f172a] text-sm transition-all duration-200 hover:-translate-y-1 hover:shadow-[5px_5px_0px_#0f172a]">UPLOAD MATERI</button>
                </form>
            </div>

            <div class="bg-white border-4 border-[#0f172a] rounded-[2rem] p-6 shadow-[5px_5px_0px_#0f172a] lg:col-span-2">
                <h3 class="text-base font-black uppercase mb-5 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Daftar Materi
                </h3>
                
                <div class="space-y-3">
                    <?php if (mysqli_num_rows($tampil) > 0): 
                        $no = 1; 
                        while ($data = mysqli_fetch_assoc($tampil)): 
                    ?>
                    <div class="flex items-center justify-between gap-4 bg-slate-50 border-2 border-[#0f172a] rounded-2xl p-4 shadow-[2px_2px_0px_#0f172a] transition-all duration-200 hover:-translate-y-1 hover:shadow-[4px_4px_0px_#0f172a]">
                        <div class="flex items-center gap-3">
                            <span class="font-pixel text-xl text-[#0c4cb4]"><?= str_pad($no, 2, '0', STR_PAD_LEFT); ?></span>
                            <div>
                                <p class="font-black text-sm uppercase"><?= htmlspecialchars($data['judul']); ?></p>
                                <span class="text-[10px] text-slate-500 font-bold"><?= htmlspecialchars($data['deskripsi']); ?></span>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="../uploads/materi/<?= htmlspecialchars($data['file']); ?>" target="_blank" class="bg-[#0c4cb4] text-white p-2 rounded-lg border-2 border-[#0f172a] transition-all duration-200 hover:-translate-y-1 hover:shadow-[4px_4px_0px_#0f172a]">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>Lihat
                            </a>
                            <a href="proses_materi.php?hapus=<?= $data['id_materi']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus materi ini?')" class="bg-[#ff4757] text-white p-2 rounded-lg border-2 border-[#0f172a] transition-all duration-200 hover:-translate-y-1 hover:shadow-[4px_4px_0px_#0f172a]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>Hapus
                            </a>
                        </div>
                    </div>
                    <?php $no++; endwhile; ?>
                    <?php else: ?>
                    <div class="text-center py-10 border-2 border-dashed border-slate-300 rounded-2xl">
                        <p class="font-black text-slate-400 text-sm">Belum ada materi.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
</body>
</html>