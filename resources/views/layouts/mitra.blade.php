<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Mitra SIGMA')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/sigma.css') }}">
</head>

<body class="bg-[#fbf5ef] text-[#171717]">

<div class="flex min-h-screen">

    <aside class="w-[280px] bg-white px-8 py-10 fixed left-0 top-0 bottom-0 shadow-sm">
        <a href="{{ route('mitra.dashboard') }}">
            <h1 class="text-3xl font-black text-[#be1622]">SIGMA</h1>
        </a>

        <p class="tracking-[4px] text-gray-400 text-sm mt-2">
            MITRA UMKM
        </p>

        <nav class="mt-14 space-y-4">
            <a href="{{ url('/') }}"
               class="flex items-center gap-4 px-5 py-4 rounded-2xl font-bold transition
               {{ request()->routeIs('home') ? 'bg-[#df3038] text-white shadow-xl' : 'text-gray-700 hover:bg-[#f6eee8]' }}">
                🏠 Beranda
            </a>

            <a href="{{ route('mitra.dashboard') }}"
               class="flex items-center gap-4 px-5 py-4 rounded-2xl font-bold transition
               {{ request()->routeIs('mitra.dashboard') ? 'bg-[#df3038] text-white shadow-xl' : 'text-gray-700 hover:bg-[#f6eee8]' }}">
                ▦ Dashboard
            </a>

            <a href="{{ route('mitra.profile') }}"
               class="flex items-center gap-4 px-5 py-4 rounded-2xl font-bold transition
               {{ request()->routeIs('mitra.profile') ? 'bg-[#df3038] text-white shadow-xl' : 'text-gray-700 hover:bg-[#f6eee8]' }}">
                🏪 Profil UMKM
            </a>

            <a href="{{ route('mitra.menu.index') }}"
               class="flex items-center gap-4 px-5 py-4 rounded-2xl font-bold transition
               {{ request()->routeIs('mitra.menu.*') ? 'bg-[#df3038] text-white shadow-xl' : 'text-gray-700 hover:bg-[#f6eee8]' }}">
                🍴 Kelola Menu
            </a>

            <a href="{{ route('mitra.analytics') }}"
               class="flex items-center gap-4 px-5 py-4 rounded-2xl font-bold transition
               {{ request()->routeIs('mitra.analytics') ? 'bg-[#df3038] text-white shadow-xl' : 'text-gray-700 hover:bg-[#f6eee8]' }}">
                ▣ Analitik
            </a>
        </nav>

        <div class="absolute bottom-8 left-8 right-8 space-y-4">
            <div class="bg-[#f6eee8] rounded-[28px] p-5">
                <h4 class="font-black">
                    {{ auth()->user()->name ?? 'Admin UMKM' }}
                </h4>
                <p class="text-xs text-gray-500">
                    Admin UMKM
                </p>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                        class="w-full bg-[#171717] text-white rounded-full py-4 font-black hover:bg-[#be1622] transition">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="ml-[280px] flex-1 p-12 min-h-screen">
        @include('partials.flash-message')
        @yield('content')
    </main>

</div>

</body>
</html>