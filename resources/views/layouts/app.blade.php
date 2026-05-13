<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGMA – Solusi Irit dan Gizi Maksimal</title>
    <meta name="description" content="Kurasi digital makanan mahasiswa. Menemukan hidangan lezat dan bergizi di sekitar kampus tanpa menguras dompet.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'sigma':      '#cf1c26',
                        'sigma-dark': '#a81520',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        * { font-family: 'Inter', sans-serif; }

        /* Range slider - merah track */
        input[type="range"] {
            -webkit-appearance: none; appearance: none;
            height: 5px; border-radius: 999px; outline: none; cursor: pointer;
        }
        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none; appearance: none;
            width: 20px; height: 20px; border-radius: 50%;
            background: white; border: 2.5px solid #cf1c26;
            cursor: pointer; box-shadow: 0 2px 8px rgba(207,28,38,.25);
        }
        input[type="range"]::-moz-range-thumb {
            width: 20px; height: 20px; border-radius: 50%;
            background: white; border: 2.5px solid #cf1c26;
            cursor: pointer; box-shadow: 0 2px 8px rgba(207,28,38,.25);
        }

        .line-clamp-2 { display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
        .line-clamp-3 { display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden; }

        @keyframes fadeUp { from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)} }
        .fade-up { animation: fadeUp .5s ease forwards; }
    </style>
</head>
<body class="bg-[#faf9f6] text-gray-900 antialiased">

    <!-- NAVBAR -->
    <nav class="sticky top-0 z-50 bg-white/85 backdrop-blur-md border-b border-gray-100 shadow-sm">
        <div class="w-full max-w-[1400px] mx-auto px-6 lg:px-16 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-sigma font-black text-2xl tracking-tight shrink-0">SIGMA</a>
            <div class="hidden md:flex items-center gap-10 text-sm font-semibold text-gray-500">
                <a href="{{ route('home') }}"
                   class="{{ request()->routeIs('home') ? 'text-sigma border-b-2 border-sigma pb-0.5' : 'hover:text-sigma transition-colors' }}">
                   Beranda
                </a>
                <a href="{{ route('cari-makan') }}"
                   class="{{ request()->routeIs('cari-makan') || request()->routeIs('menu.detail') ? 'text-sigma border-b-2 border-sigma pb-0.5' : 'hover:text-sigma transition-colors' }}">
                   Cari Makan
                </a>
                <a href="#section-umkm"
                   class="hover:text-sigma transition-colors">
                   Daftar UMKM
                </a>
            </div>
            <div class="flex items-center gap-3 text-gray-400">
                <button class="hover:text-sigma transition-colors p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                </button>
                <button class="hover:text-sigma transition-colors p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 1 0-16 0"/></svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <main class="w-full max-w-[1400px] mx-auto px-6 lg:px-16">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="w-full max-w-[1400px] mx-auto px-6 lg:px-16 mt-16 py-10 border-t border-gray-200">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <p class="font-black text-sigma text-lg tracking-tight mb-1">SIGMA</p>
                <p class="text-xs text-gray-400">© 2024 SIGMA – Solusi Irit dan Gizi Maksimal. Kurasi Digital Mahasiswa.</p>
            </div>
            <div class="flex gap-8 text-xs text-gray-400">
                <a href="#" class="hover:text-gray-600 transition-colors">Tentang Kami</a>
                <a href="#" class="hover:text-gray-600 transition-colors">Kebijakan Privasi</a>
                <a href="#" class="hover:text-gray-600 transition-colors">Syarat & Ketentuan</a>
                <a href="#" class="hover:text-gray-600 transition-colors">Bantuan</a>
            </div>
        </div>
    </footer>

</body>
</html>
