<?php
include '../config/session.php';

if (isset($_SESSION['role'])) {
    header($_SESSION['role'] === 'guru' ? "Location: ../guru/dashboard.php" : "Location: ../murid/dashboard.php");
    exit();
}

$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Learning</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DotGothic16&family=Plus+Jakarta+Sans:wght@700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/output.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-popin { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bg-canvas-denim {
            background-color: #0c4cb4;
            background-image: linear-gradient(90deg, rgba(255,255,255,0.09) 50%, transparent 50%),
                              linear-gradient(rgba(255,255,255,0.09) 50%, transparent 50%);
            background-size: 3px 3px;
        }
        input:focus { outline: none; box-shadow: 3px 3px 0px #0f172a; }
    </style>
</head>
<body class="bg-canvas-denim min-h-screen flex items-center justify-center p-4 selection:bg-yellow-300">

    <div class="w-full max-w-md">

        <div class="text-center mb-6">
            <span class="font-popin text-5xl text-white tracking-tighter drop-shadow-lg">E-LEARNING</span>
            <p class="text-[#a8ff78] text-xs font-black uppercase tracking-widest mt-1">STUDIO BELAJAR SEKOLAH DASAR</p>
        </div>

        <div class="bg-white border-4 border-[#0f172a] rounded-[2rem] p-8 shadow-[8px_8px_0px_#0f172a]">

            <div class="text-center mb-6">
                <span class="inline-block bg-[#a8ff78] border-2 border-[#0f172a] text-[#0f172a] text-[10px] font-black tracking-widest px-3 py-1 rounded-md uppercase shadow-[2px_2px_0px_#0f172a] mb-3">
                    MASUK AKUN
                </span>
                <h1 class="text-center text-3xl font-black uppercase text-[#0f172a] leading-none">SELAMAT<br>DATANG!</h1>
                <p class="text-center text-slate-500 text-xs font-bold mt-2">Masukkan email dan password Anda.</p>
            </div>

            <?php if ($error === 'salah'): ?>
            <div class="bg-red-100 border-2 border-red-600 rounded-xl px-4 py-2 mb-4 text-red-700 text-xs font-black uppercase">
                ❌ Email atau password salah!
            </div>
            <?php elseif ($error === 'notfound'): ?>
            <div class="bg-red-100 border-2 border-red-600 rounded-xl px-4 py-2 mb-4 text-red-700 text-xs font-black uppercase">
                ❌ Email tidak terdaftar!
            </div>
            <?php endif; ?>

            <form action="proses_login.php" method="POST" class="space-y-4">

                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-700 mb-1.5">Email</label>
                    <input type="email" name="email" required placeholder="contoh@email.com"
                        class="w-full px-4 py-3 border-2 border-[#0f172a] rounded-xl text-sm font-bold bg-slate-50 transition-all placeholder:text-slate-300">
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-700 mb-1.5">Password</label>
                    <input type="password" name="password" required placeholder="••••••••"
                        class="w-full px-4 py-3 border-2 border-[#0f172a] rounded-xl text-sm font-bold bg-slate-50 transition-all placeholder:text-slate-300">
                </div>

                <button type="submit" name="login"
                    class="w-full bg-[#0c4cb4] hover:bg-[#0a3f96] text-white font-black uppercase py-3.5 rounded-xl border-2 border-[#0f172a] shadow-[4px_4px_0px_#0f172a] active:translate-x-1 active:translate-y-1 active:shadow-none transition-all text-sm tracking-wider mt-2">
                    MASUK SEKARANG
                </button>
            </form>

            <div class="mt-6 pt-5 border-t-2 border-dashed border-slate-200 text-center">
                <p class="text-xs font-bold text-slate-500">
                    Belum punya akun?
                    <a href="register.php" class="text-[#0c4cb4] font-black hover:underline uppercase">Daftar di sini</a>
                </p>
            </div>
        </div>

        <p class="text-center text-[10px] text-white/40 mt-6 font-semibold uppercase tracking-widest">
            © 2026 E-Learning Studio Belajar Sekolah Dasar.
        </p>
    </div>

</body>
</html>
