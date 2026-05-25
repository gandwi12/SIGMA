<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Mitra SIGMA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#fbf5ef] min-h-screen flex items-center justify-center px-6">

<div class="w-full max-w-md bg-white rounded-[34px] p-10 shadow-2xl">
    <h1 class="text-4xl font-black text-[#be1622]">SIGMA</h1>
    <p class="text-gray-500 mt-2 font-bold tracking-[3px]">MITRA UMKM LOGIN</p>

    @if(session('error'))
        <div class="bg-red-100 text-red-700 rounded-2xl p-4 mt-6 font-bold">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('mitra.login.post') }}" method="POST" class="mt-8 space-y-5">
        @csrf

        <div>
            <label class="font-bold text-sm">Email</label>
            <input type="email" name="email"
                   class="w-full mt-3 bg-[#f6eee8] rounded-full px-7 py-5 outline-none"
                   placeholder="mitra@sigma.test">
        </div>

        <div>
            <label class="font-bold text-sm">Password</label>
            <input type="password" name="password"
                   class="w-full mt-3 bg-[#f6eee8] rounded-full px-7 py-5 outline-none"
                   placeholder="********">
        </div>

        <button class="w-full bg-[#be1622] text-white py-5 rounded-full font-black shadow-xl">
            Masuk Admin UMKM
        </button>
    </form>

    <a href="{{ route('home') }}" class="block text-center mt-7 text-gray-500 font-bold">
        ← Kembali ke Beranda
    </a>
</div>

</body>
</html>