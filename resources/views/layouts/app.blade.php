<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'SIGMA')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/sigma.css') }}">
</head>

<body class="bg-[#fbf5ef] text-[#171717]">

<header class="w-full px-8 lg:px-12 xl:px-16 py-6 flex items-center justify-between">
    <a href="{{ route('home') }}" class="text-3xl font-black text-[#be1622]">
        SIGMA
    </a>

    <nav class="hidden md:flex items-center gap-12 font-semibold text-sm">
        <a href="{{ route('home') }}"
           class="{{ request()->routeIs('home') ? 'text-[#be1622] underline underline-offset-8' : 'text-[#171717]' }}">
            Beranda
        </a>

        <a href="{{ route('menu.index') }}"
           class="{{ request()->routeIs('menu.*') ? 'text-[#be1622] underline underline-offset-8' : 'text-[#171717]' }}">
            Cari Makan
        </a>

        <a href="{{ route('umkm.create') }}"
           class="{{ request()->routeIs('umkm.create') ? 'text-[#be1622] underline underline-offset-8' : 'text-[#171717]' }}">
            Daftar UMKM
        </a>

        <a href="{{ route('chatbot.index') }}"
           class="{{ request()->routeIs('chatbot.*') ? 'text-[#be1622] underline underline-offset-8' : 'text-[#171717]' }}">
            Asisten Gizi
        </a>
    </nav>

    <div class="flex items-center gap-3">
        <button type="button"
                class="w-11 h-11 rounded-full bg-[#f6eee8] grid place-items-center">
            🔔
        </button>

        @guest
            <a href="{{ route('login') }}"
               class="bg-[#be1622] text-white px-6 py-3 rounded-full font-black shadow-lg">
                Masuk
            </a>
        @else
            <div class="relative">
                <button type="button"
                        id="userMenuBtn"
                        class="w-11 h-11 rounded-full bg-[#be1622] text-white font-black">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </button>

                <div id="userDropdown"
                     class="hidden absolute right-0 mt-4 w-[260px] bg-white rounded-[24px] shadow-2xl p-5 z-50">
                    <p class="font-black">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="text-xs text-gray-500 mt-1">
                        {{ auth()->user()->email }}
                    </p>

                    <div class="border-t my-4"></div>

                    @if(auth()->user()->role === 'admin_sigma')
                        <a href="{{ route('admin.dashboard') }}"
                           class="block px-4 py-3 rounded-2xl font-bold hover:bg-[#f6eee8]">
                            Dashboard Admin
                        </a>
                    @elseif(auth()->user()->role === 'mitra')
                        <a href="{{ route('mitra.dashboard') }}"
                           class="block px-4 py-3 rounded-2xl font-bold hover:bg-[#f6eee8]">
                            Dashboard Mitra
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="mt-2">
                        @csrf

                        <button type="submit"
                                class="w-full text-left px-4 py-3 rounded-2xl font-bold text-[#be1622] hover:bg-red-50">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        @endguest
    </div>
</header>

<main>
    @yield('content')
</main>

<footer class="px-8 lg:px-12 xl:px-16 py-10 bg-[#f6eee8] mt-20 text-gray-600">
    <div class="flex flex-col md:flex-row justify-between gap-4">
        <p class="font-black text-[#be1622]">SIGMA</p>
        <p class="text-sm">© 2024 SIGMA - Solusi Irit dan Gizi Maksimal.</p>
    </div>
</footer>

@stack('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('userMenuBtn');
    const dropdown = document.getElementById('userDropdown');

    if (btn && dropdown) {
        btn.addEventListener('click', function (event) {
            event.stopPropagation();
            dropdown.classList.toggle('hidden');
        });

        dropdown.addEventListener('click', function (event) {
            event.stopPropagation();
        });

        document.addEventListener('click', function () {
            dropdown.classList.add('hidden');
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                dropdown.classList.add('hidden');
            }
        });
    }
});
</script>
</body>
</html>