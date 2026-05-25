@extends('layouts.admin')

@section('title', 'Approval UMKM - SIGMA')

@section('content')
<div class="mb-10">
    <h1 class="text-4xl font-black">Approval UMKM</h1>
    <p class="text-gray-600 text-lg mt-2">
        Kelola status UMKM yang terdaftar di SIGMA.
    </p>
</div>

<div class="bg-[#f6eee8] rounded-[34px] overflow-hidden">
    <table class="w-full">
        <thead class="bg-[#eee4dc]">
            <tr class="text-left">
                <th class="p-6">UMKM</th>
                <th class="p-6">Kategori</th>
                <th class="p-6">WhatsApp</th>
                <th class="p-6">Status</th>
                <th class="p-6">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($umkms as $umkm)
                <tr class="border-b border-[#e3d8cf]">
                    <td class="p-6 font-black">
                        {{ $umkm->nama_usaha }}
                    </td>

                    <td class="p-6">
                        {{ $umkm->kategori }}
                    </td>

                    <td class="p-6">
                        {{ $umkm->whatsapp }}
                    </td>

                    <td class="p-6">
                        @if($umkm->status === 'pending')
                            <span class="bg-yellow-100 text-yellow-700 px-5 py-2 rounded-full font-black text-sm">
                                Pending
                            </span>
                        @elseif($umkm->status === 'Aktif')
                            <span class="bg-green-100 text-green-700 px-5 py-2 rounded-full font-black text-sm">
                                Aktif
                            </span>
                        @elseif($umkm->status === 'Nonaktif')
                            <span class="bg-gray-200 text-gray-700 px-5 py-2 rounded-full font-black text-sm">
                                Nonaktif
                            </span>
                        @else
                            <span class="bg-red-100 text-red-700 px-5 py-2 rounded-full font-black text-sm">
                                Rejected
                            </span>
                        @endif
                    </td>

                    <td class="p-6">
                        <div class="flex flex-wrap gap-3 items-center">
                            <a href="{{ route('admin.umkm.show', $umkm->id) }}"
                               class="text-[#be1622] font-black">
                                Review →
                            </a>

                            @if($umkm->status === 'pending' || $umkm->status === 'rejected' || $umkm->status === 'Nonaktif')
                                <form action="{{ route('admin.umkm.activate', $umkm->id) }}"
                                      method="POST"
                                      class="confirm-action"
                                      data-title="Aktifkan UMKM?"
                                      data-message="UMKM ini akan tampil kembali di halaman publik SIGMA.">
                                    @csrf
                                    <button type="submit"
                                            class="bg-green-600 text-white px-5 py-2 rounded-full font-black text-sm">
                                        Aktifkan
                                    </button>
                                </form>
                            @endif

                            @if($umkm->status === 'Aktif')
                                <form action="{{ route('admin.umkm.deactivate', $umkm->id) }}"
                                      method="POST"
                                      class="confirm-action"
                                      data-title="Nonaktifkan UMKM?"
                                      data-message="UMKM ini akan disembunyikan dari halaman publik SIGMA. Menu miliknya juga tidak akan direkomendasikan.">
                                    @csrf
                                    <button type="submit"
                                            class="bg-gray-900 text-white px-5 py-2 rounded-full font-black text-sm hover:bg-[#be1622] transition">
                                        Nonaktifkan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-10 text-center text-gray-500">
                        Belum ada UMKM terdaftar.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div id="confirmModal"
     class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50 px-6">
    <div class="bg-white rounded-[36px] p-9 w-full max-w-[460px] shadow-2xl scale-95 opacity-0 transition-all duration-200"
         id="confirmCard">

        <div class="w-16 h-16 bg-red-100 text-[#be1622] rounded-full flex items-center justify-center text-3xl mb-6">
            !
        </div>

        <h2 id="confirmTitle" class="text-3xl font-black">
            Konfirmasi Aksi
        </h2>

        <p id="confirmMessage" class="text-gray-600 leading-7 mt-4">
            Apakah Anda yakin ingin melanjutkan?
        </p>

        <div class="flex gap-4 mt-9">
            <button type="button"
                    id="cancelConfirm"
                    class="flex-1 bg-[#e8e1dc] text-[#171717] rounded-full py-4 font-black">
                Batal
            </button>

            <button type="button"
                    id="yesConfirm"
                    class="flex-1 bg-[#be1622] text-white rounded-full py-4 font-black shadow-xl">
                Ya, Lanjutkan
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let selectedForm = null;

const modal = document.getElementById('confirmModal');
const card = document.getElementById('confirmCard');
const title = document.getElementById('confirmTitle');
const message = document.getElementById('confirmMessage');
const cancelBtn = document.getElementById('cancelConfirm');
const yesBtn = document.getElementById('yesConfirm');

document.querySelectorAll('.confirm-action').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        selectedForm = this;
        title.innerText = this.dataset.title || 'Konfirmasi Aksi';
        message.innerText = this.dataset.message || 'Apakah Anda yakin ingin melanjutkan?';

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        setTimeout(() => {
            card.classList.remove('scale-95', 'opacity-0');
            card.classList.add('scale-100', 'opacity-100');
        }, 10);
    });
});

cancelBtn.addEventListener('click', function() {
    closeConfirmModal();
});

modal.addEventListener('click', function(e) {
    if (e.target === modal) {
        closeConfirmModal();
    }
});

yesBtn.addEventListener('click', function() {
    if (selectedForm) {
        yesBtn.innerText = 'Memproses...';
        yesBtn.disabled = true;
        selectedForm.submit();
    }
});

function closeConfirmModal() {
    selectedForm = null;

    card.classList.add('scale-95', 'opacity-0');
    card.classList.remove('scale-100', 'opacity-100');

    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        yesBtn.innerText = 'Ya, Lanjutkan';
        yesBtn.disabled = false;
    }, 180);
}
</script>
@endpush