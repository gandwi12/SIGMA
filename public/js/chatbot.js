const chatForm = document.getElementById('chat-form');

if (chatForm) {

    chatForm.addEventListener('submit', async function (e) {

        e.preventDefault();

        const messageInput = document.getElementById('message');
        const message = messageInput.value.trim();

        if (!message) return;

        const chatBox = document.getElementById('chat-box');

        chatBox.innerHTML += `
            <div class="chat-user">
                <p class="font-bold text-[#be1622]">Kamu</p>
                <p class="mt-2">${message}</p>
            </div>
        `;

        messageInput.value = '';

        try {

            const response = await fetch('/asisten-gizi/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ message })
            });

            const data = await response.json();

            chatBox.innerHTML += `
                <div class="chat-bot">
                    <p class="font-bold">SIGMA AI</p>
                    <p class="mt-2">${data.reply}</p>
                </div>
            `;

            chatBox.scrollTop = chatBox.scrollHeight;

        } catch (error) {

            chatBox.innerHTML += `
                <div class="chat-bot">
                    <p class="font-bold">SIGMA AI</p>
                    <p class="mt-2">Terjadi kesalahan pada server.</p>
                </div>
            `;

        }

    });

}