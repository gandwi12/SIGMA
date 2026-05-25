@extends('layouts.app')

@section('content')
<section class="max-w-5xl mx-auto px-6 py-14">

    <div class="text-center">

        <p class="text-[#be1622] font-bold tracking-[4px]">
            AI FOOD SCANNER
        </p>

        <h1 class="text-5xl lg:text-6xl font-black mt-5">
            Scanner Kalori
        </h1>

        <p class="text-gray-600 text-lg mt-6 max-w-2xl mx-auto leading-8">
            Upload foto makanan dan biarkan AI memperkirakan nama makanan serta jumlah kalorinya.
        </p>

    </div>

    <div class="bg-[#f6eee8] rounded-[40px] p-10 mt-14">

        <form action="{{ route('scanner.scan') }}"
              method="POST"
              enctype="multipart/form-data"
              class="text-center">

            @csrf

            <div class="border-2 border-dashed border-[#be1622] rounded-[35px] p-14 bg-white">

                <img src="{{ asset('images/icons/upload.svg') }}"
                     class="w-20 mx-auto">

                <h3 class="text-2xl font-black mt-6">
                    Upload Foto Makanan
                </h3>

                <p class="text-gray-500 mt-3">
                    JPG, PNG maksimal 5MB
                </p>

                <input type="file"
                       name="foto"
                       class="mt-8">

            </div>

            <button class="bg-[#be1622] text-white px-10 py-5 rounded-full font-black mt-10 shadow-xl">
                Scan Sekarang
            </button>

        </form>

    </div>

</section>

<section class="max-w-7xl mx-auto px-6 pb-20">

    <h2 class="text-4xl font-black mb-10">
        Hasil Scanner
    </h2>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

        @foreach($results as $result)

            <div class="bg-[#f6eee8] rounded-[30px] overflow-hidden">

                <img src="{{ asset('storage/'.$result->foto) }}"
                     class="h-60 w-full object-cover">

                <div class="p-6">

                    <div class="flex justify-between items-center">
                        <h3 class="text-2xl font-black">
                            {{ $result->nama_makanan }}
                        </h3>

                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-bold">
                            {{ $result->confidence }}
                        </span>
                    </div>

                    <p class="text-[#be1622] font-black mt-5 text-xl">
                        {{ $result->estimasi_kalori }}
                    </p>

                    <p class="text-gray-600 mt-4 leading-7">
                        {{ $result->deskripsi }}
                    </p>

                </div>

            </div>

        @endforeach

    </div>

</section>
@endsection