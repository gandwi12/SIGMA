<aside class="w-72 bg-white min-h-screen p-8 shadow-sm hidden lg:block">
    <a href="{{ route('home') }}" class="text-3xl font-black text-[#be1622]">
        SIGMA
    </a>

    <p class="text-xs tracking-[4px] text-gray-400 mt-2">
        ADMIN PORTAL
    </p>

    <nav class="mt-14 space-y-4">

        <a href="{{ route('menu.admin') }}"
           class="flex items-center gap-3 p-4 rounded-2xl font-bold
           {{ request()->routeIs('menu.admin') ? 'bg-[#be1622] text-white shadow-xl' : 'text-gray-600 hover:bg-[#f6eee8]' }}">
            <span>🍽</span>
            <span>Kelola Menu</span>
        </a>

        <a href="{{ route('menu.create') }}"
           class="flex items-center gap-3 p-4 rounded-2xl font-bold
           {{ request()->routeIs('menu.create') ? 'bg-[#be1622] text-white shadow-xl' : 'text-gray-600 hover:bg-[#f6eee8]' }}">
            <span>➕</span>
            <span>Tambah Menu</span>
        </a>

        <a href="{{ route('umkm.create') }}"
           class="flex items-center gap-3 p-4 rounded-2xl font-bold text-gray-600 hover:bg-[#f6eee8]">
            <span>🏪</span>
            <span>Daftar UMKM</span>
        </a>

        <a href="{{ route('home') }}"
           class="flex items-center gap-3 p-4 rounded-2xl font-bold text-gray-600 hover:bg-[#f6eee8]">
            <span>🏠</span>
            <span>Kembali ke Web</span>
        </a>

    </nav>
</aside>