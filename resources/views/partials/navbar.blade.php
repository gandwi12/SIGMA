<nav class="w-full px-8 lg:px-12 xl:px-16 py-7 flex justify-between items-center">
    <a href="{{ route('home') }}" class="text-2xl font-black text-[#be1622]">
        SIGMA
    </a>

    <div class="hidden md:flex gap-10 text-sm font-medium absolute left-1/2 -translate-x-1/2">
        <a href="{{ route('home') }}"
           class="{{ request()->routeIs('home') ? 'text-[#be1622] border-b border-[#be1622]' : 'text-gray-700' }}">
            Beranda
        </a>

        <a href="{{ route('menu.index') }}"
           class="{{ request()->routeIs('menu.index') || request()->routeIs('menu.show') ? 'text-[#be1622] border-b border-[#be1622]' : 'text-gray-700' }}">
            Cari Makan
        </a>

        <a href="{{ route('umkm.create') }}"
           class="{{ request()->routeIs('umkm.create') ? 'text-[#be1622] border-b border-[#be1622]' : 'text-gray-700' }}">
            Daftar UMKM
        </a>

        <a href="{{ route('chatbot.index') }}"
           class="{{ request()->routeIs('chatbot.index') ? 'text-[#be1622] border-b border-[#be1622]' : 'text-gray-700' }}">
            Asisten Gizi
        </a>
    </div>

    <div class="flex gap-4 items-center">
        <span class="w-10 h-10 rounded-full bg-[#f0e6df] flex items-center justify-center">
            🔔
        </span>

        <span class="w-10 h-10 rounded-full bg-[#be1622] text-white flex items-center justify-center font-bold">
            U
        </span>
    </div>
</nav>