@extends('layouts.app')

@section('title', 'Asisten Gizi - SIGMA')

@section('content')
<section class="max-w-5xl mx-auto px-6 py-14">

    <div class="text-center">
        <p class="text-[#be1622] font-bold tracking-[4px]">
            AI NUTRITION ASSISTANT
        </p>

        <h1 class="text-5xl lg:text-6xl font-black mt-5">
            Asisten Gizi SIGMA
        </h1>

        <p class="text-gray-600 text-lg mt-6 max-w-2xl mx-auto leading-8">
            Tanyakan rekomendasi makanan sehat, tinggi protein, rendah kalori, atau menu hemat untuk mahasiswa.
        </p>
    </div>

    <div class="bg-[#f6eee8] rounded-[40px] p-8 mt-14">
        <div id="chat-box" class="space-y-5 max-h-[560px] overflow-y-auto pr-2">

            @forelse($histories as $chat)
                <div class="bg-white p-5 rounded-3xl shadow-sm">
                    <p class="font-bold text-[#be1622]">Kamu</p>
                    <p class="mt-2">{{ $chat->user_message }}</p>
                </div>

                <div class="bg-[#be1622] text-white p-5 rounded-3xl shadow-sm">
                    <p class="font-bold">SIGMA AI</p>
                    <p class="mt-2">{{ $chat->bot_reply }}</p>
                </div>
            @empty
                <div id="emptyChatInfo" class="bg-white p-8 rounded-3xl shadow-sm text-center">
                    <h3 class="text-2xl font-black">Mulai Chat Baru</h3>
                    <p class="text-gray-500 mt-2">
                        Chat akan otomatis bersih jika tidak ada aktivitas selama 5 menit.
                    </p>
                </div>
            @endforelse

        </div>

        <form id="chat-form" class="flex gap-4 mt-8">
            @csrf

            <input type="text"
                   id="message"
                   class="flex-1 px-8 py-5 rounded-full bg-white outline-none"
                   placeholder="Contoh: aku punya uang 10rb, bisa makan apa?"
                   autocomplete="off">

            <button id="sendBtn"
                    type="submit"
                    class="bg-[#be1622] text-white px-8 py-5 rounded-full font-black">
                Kirim
            </button>
        </form>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('chat-form');
    const input = document.getElementById('message');
    const box = document.getElementById('chat-box');
    const sendBtn = document.getElementById('sendBtn');

    let isSending = false;
    let inactivityTimer;

    function resetInactivityTimer() {
        clearTimeout(inactivityTimer);

        inactivityTimer = setTimeout(() => {
            box.innerHTML = `
                <div id="emptyChatInfo" class="bg-white p-8 rounded-3xl shadow-sm text-center">
                    <h3 class="text-2xl font-black">Chat Dimulai Ulang</h3>
                    <p class="text-gray-500 mt-2">
                        Karena tidak ada aktivitas selama 5 menit, percakapan sebelumnya disembunyikan.
                    </p>
                </div>
            `;
        }, 5 * 60 * 1000);
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text ?? '';
        return div.innerHTML;
    }

    function removeEmptyInfo() {
        const empty = document.getElementById('emptyChatInfo');
        if (empty) empty.remove();
    }

    function renderUser(message) {
        removeEmptyInfo();

        box.insertAdjacentHTML('beforeend', `
            <div class="bg-white p-5 rounded-3xl shadow-sm">
                <p class="font-bold text-[#be1622]">Kamu</p>
                <p class="mt-2">${escapeHtml(message)}</p>
            </div>
        `);
    }

    function renderBot(reply, menus = []) {
        let cards = '';

        if (menus.length > 0) {
            cards = `
                <div class="grid md:grid-cols-3 gap-4 mt-5">
                    ${menus.map(menu => `
                        <a href="${menu.url}"
                           class="block bg-white text-[#171717] rounded-[24px] overflow-hidden shadow-xl hover:scale-[1.02] transition">
                            <img src="${menu.image_url}"
                                 class="w-full h-[140px] object-cover bg-[#eee4dc]"
                                 alt="${escapeHtml(menu.nama)}">

                            <div class="p-4">
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-[11px] font-black">
                                    ${escapeHtml(menu.tag)}
                                </span>

                                <h3 class="font-black text-lg mt-3 leading-tight">
                                    ${escapeHtml(menu.nama)}
                                </h3>

                                <p class="text-[#be1622] font-black mt-2">
                                    ${menu.harga}
                                </p>

                                <div class="flex flex-wrap gap-2 text-[11px] text-gray-500 mt-3">
                                    <span>${menu.kalori} kcal</span>
                                    <span>${menu.protein}g protein</span>
                                    <span>${menu.lemak}g lemak</span>
                                </div>

                                <p class="text-[#be1622] font-black text-sm mt-4">
                                    Lihat Detail →
                                </p>
                            </div>
                        </a>
                    `).join('')}
                </div>
            `;
        }

        box.insertAdjacentHTML('beforeend', `
            <div class="space-y-4">
                <div class="bg-[#be1622] text-white p-5 rounded-3xl shadow-sm">
                    <p class="font-bold">SIGMA AI</p>
                    <p class="mt-2">${escapeHtml(reply)}</p>
                </div>
                ${cards}
            </div>
        `);
    }

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        if (isSending) return;

        const message = input.value.trim();
        if (!message) return;

        isSending = true;
        sendBtn.disabled = true;
        sendBtn.textContent = 'Mengirim...';

        renderUser(message);
        input.value = '';

        try {
            const response = await fetch("{{ route('chatbot.send') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message })
            });

            const data = await response.json();

            console.log('CHATBOT RESPONSE:', data);

            renderBot(data.reply || 'Maaf, saya belum bisa menjawab.', data.menus || []);

        } catch (error) {
            renderBot('Maaf, Asisten Gizi sedang gangguan. Coba lagi sebentar.', []);
        } finally {
            isSending = false;
            sendBtn.disabled = false;
            sendBtn.textContent = 'Kirim';

            box.scrollTop = box.scrollHeight;
            resetInactivityTimer();
        }
    });

    resetInactivityTimer();
    box.scrollTop = box.scrollHeight;
});
</script>
@endsection