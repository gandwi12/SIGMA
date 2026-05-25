<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register Mitra SIGMA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#fbf5ef] min-h-screen flex items-center justify-center px-6">

<div class="w-full max-w-lg bg-white rounded-[34px] p-10 shadow-2xl">
    <h1 class="text-4xl font-black text-[#be1622]">SIGMA</h1>
    <p class="text-gray-500 mt-2 font-bold tracking-[3px]">
        REGISTER MITRA UMKM
    </p>

    @if(session('error'))
        <div class="bg-red-100 text-red-700 rounded-2xl p-4 mt-6 font-bold">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('register.post') }}" method="POST" class="mt-8 space-y-5">
        @csrf

        <div>
            <label class="font-bold text-sm">Pilih UMKM yang Sudah Di-ACC</label>
            <select name="umkm_id"
                    class="w-full mt-3 bg-[#f6eee8] rounded-full px-7 py-5 outline-none">
                <option value="">Pilih UMKM</option>

                @foreach($umkms as $umkm)
                    <option value="{{ $umkm->id }}">
                        {{ $umkm->nama_usaha }} - {{ $umkm->kategori }}
                    </option>
                @endforeach
            </select>

            @if($umkms->count() == 0)
                <p class="text-sm text-red-600 font-bold mt-3">
                    Belum ada UMKM aktif yang bisa dibuatkan akun.
                </p>
            @endif
        </div>

        <div>
            <label class="font-bold text-sm">Nama Admin UMKM</label>
            <input type="text"
                   name="name"
                   value="{{ old('name') }}"
                   class="w-full mt-3 bg-[#f6eee8] rounded-full px-7 py-5 outline-none"
                   placeholder="Contoh: Admin Warung Salsabila">
        </div>

        <div>
            <label class="font-bold text-sm">Email</label>
            <input type="email"
                   name="email"
                   value="{{ old('email') }}"
                   class="w-full mt-3 bg-[#f6eee8] rounded-full px-7 py-5 outline-none"
                   placeholder="mitra@sigma.test">
        </div>

        <div>
            <label class="font-bold text-sm">Password</label>
            <input type="password"
                   name="password"
                   class="w-full mt-3 bg-[#f6eee8] rounded-full px-7 py-5 outline-none"
                   placeholder="Minimal 6 karakter">
        </div>

        <div>
            <label class="font-bold text-sm">Konfirmasi Password</label>
            <input type="password"
                   name="password_confirmation"
                   class="w-full mt-3 bg-[#f6eee8] rounded-full px-7 py-5 outline-none"
                   placeholder="Ulangi password">
        </div>

        <button class="w-full bg-[#be1622] text-white py-5 rounded-full font-black shadow-xl">
            Daftar Mitra
        </button>
    </form>

    <div class="text-center mt-7 space-y-3">
        <a href="{{ route('login') }}" class="block text-[#be1622] font-black">
            Sudah punya akun? Login
        </a>

        <a href="{{ route('home') }}" class="block text-gray-500 font-bold">
            ← Kembali ke Beranda
        </a>
    </div>
</div>

</body>
</html>