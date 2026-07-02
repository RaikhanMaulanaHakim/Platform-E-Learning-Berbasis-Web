<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - E-Learning</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DotGothic16&family=Plus+Jakarta+Sans:wght@700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/output.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .font-popin {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .bg-canvas-denim {
            background-color: #0c4cb4;
            background-image: linear-gradient(90deg, rgba(255, 255, 255, 0.09) 50%, transparent 50%),
                linear-gradient(rgba(255, 255, 255, 0.09) 50%, transparent 50%);
            background-size: 3px 3px;
        }

        input:focus,
        select:focus {
            outline: none;
            box-shadow: 3px 3px 0px #0f172a;
        }
    </style>
</head>

<body class="bg-canvas-denim min-h-screen flex items-center justify-center p-4 py-10 selection:bg-yellow-300">

    <div class="w-full max-w-md">

        <div class="text-center mb-6">
            <span class="font-popin text-5xl text-white tracking-tighter drop-shadow-lg">E-LEARNING</span>
            <p class="text-[#a8ff78] text-xs font-black uppercase tracking-widest mt-1">DAFTAR AKUN SISWA</p>
        </div>

        <div class="bg-white border-4 border-[#0f172a] rounded-[2rem] p-8 shadow-[8px_8px_0px_#0f172a]">

            <div class="text-center mb-6 ">
                <span class="inline-block bg-[#a8ff78] border-2 border-[#0f172a] text-[#0f172a] text-[10px] font-black tracking-widest px-3 py-1 rounded-md uppercase shadow-[2px_2px_0px_#0f172a] mb-3">
                    REGISTRASI SISWA
                </span>
                <h1 class="text-3xl font-black uppercase text-[#0f172a] leading-none">BUAT<br>AKUN BARU!</h1>
                <p class="text-slate-500 text-xs font-bold mt-2">Isi data diri kamu untuk mendaftarkan akun siswa.</p>
            </div>

            <form action="proses_register.php" method="POST" class="space-y-4">

                <div class="mb-4">
                    <label class="block text-xs font-black uppercase text-slate-500 mb-1">Daftar Sebagai:</label>
                    <div class="flex gap-4">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="role" value="murid" class="hidden" onchange="updateRoleUI()">
                            <div id="card-murid" class="role-card flex items-center justify-center gap-2 p-3 border-2 border-[#0f172a] rounded-xl bg-slate-50 transition-all shadow-[2px_2px_0px_#0f172a]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                </svg>
                                <span class="font-black text-sm">Murid</span>
                            </div>
                        </label>

                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="role" value="guru" class="hidden" onchange="updateRoleUI()">
                            <div id="card-guru" class="role-card flex items-center justify-center gap-2 p-3 border-2 border-[#0f172a] rounded-xl bg-slate-50 transition-all shadow-[2px_2px_0px_#0f172a]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span class="font-black text-sm">Guru</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="nama" required placeholder="Masukkan nama lengkap"
                        class="w-full px-4 py-3 border-2 border-[#0f172a] rounded-xl text-sm font-bold bg-slate-50 transition-all placeholder:text-slate-300">
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-700 mb-1.5">Email</label>
                    <input type="email" name="email" required placeholder="nama@email.com"
                        class="w-full px-4 py-3 border-2 border-[#0f172a] rounded-xl text-sm font-bold bg-slate-50 transition-all placeholder:text-slate-300">
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-700 mb-1.5">Password</label>
                    <input type="password" name="password" required placeholder="••••••••"
                        class="w-full px-4 py-3 border-2 border-[#0f172a] rounded-xl text-sm font-bold bg-slate-50 transition-all placeholder:text-slate-300">
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-700 mb-1.5">Kelas</label>
                    <select name="kelas" required
                        class="w-full px-4 py-3 border-2 border-[#0f172a] rounded-xl text-sm font-bold bg-slate-50 transition-all appearance-none">
                        <option value="">-- Pilih Kelas --</option>
                        <option value="1">Kelas 1</option>
                        <option value="2">Kelas 2</option>
                        <option value="3">Kelas 3</option>
                        <option value="4">Kelas 4</option>
                        <option value="5">Kelas 5</option>
                        <option value="6">Kelas 6</option>
                    </select>
                </div>

                <button type="submit" name="register"
                    class="w-full bg-[#a8ff78] hover:bg-[#90e860] text-[#0f172a] font-black uppercase py-3.5 rounded-xl border-2 border-[#0f172a] shadow-[4px_4px_0px_#0f172a] active:translate-x-1 active:translate-y-1 active:shadow-none transition-all text-sm tracking-wider mt-2">
                    DAFTAR SEKARANG
                </button>
            </form>

            <div class="mt-6 pt-5 border-t-2 border-dashed border-slate-200 text-center">
                <p class="text-xs font-bold text-slate-500">
                    Sudah punya akun?
                    <a href="login.php" class="text-[#0c4cb4] font-black hover:underline uppercase">Login di sini</a>
                </p>
            </div>
        </div>

        <p class="text-center text-[10px] text-white/40 mt-6 font-semibold uppercase tracking-widest">
            © 2026 E-Learning Studio Belajar Sekolah Dasar.
        </p>
    </div>

</body>
<script>
    function updateRoleUI() {
        const radios = document.getElementsByName('role');
        radios.forEach(radio => {
            const card = radio.nextElementSibling;
            if (radio.checked) {
                card.classList.add('bg-[#0c4cb4]', 'text-white');
                card.classList.remove('bg-slate-50');
            } else {
                card.classList.remove('bg-[#0c4cb4]', 'text-white');
                card.classList.add('bg-slate-50');
            }
        });
    }

    document.querySelector('input[value="murid"]').checked = true;
    updateRoleUI();
</script>

</html>