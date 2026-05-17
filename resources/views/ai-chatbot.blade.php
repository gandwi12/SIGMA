<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;family=Inter:wght@400;500;600&amp;family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .fill-icon {
            font-variation-settings: 'FILL' 1;
        }
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, .font-display {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #e6e2dd;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #d9d4cf;
        }
        /* Loader Animation */
        .typing-loader span {
            display: inline-block;
            width: 5px;
            height: 5px;
            background-color: #b51822;
            border-radius: 50%;
            margin: 0 2px;
            animation: bounce 1.4s infinite ease-in-out both;
        }
        .typing-loader span:nth-child(1) { animation-delay: -0.32s; }
        .typing-loader span:nth-child(2) { animation-delay: -0.16s; }
        @keyframes bounce {
            0%, 80%, 100% { transform: scale(0); }
            40% { transform: scale(1); }
        }
    </style>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "tertiary-fixed-dim": "#6fd6dd",
                        "primary-fixed-dim": "#ffb3ad",
                        "on-secondary-fixed-variant": "#3d4759",
                        "tertiary-fixed": "#8cf2fa",
                        "on-secondary-container": "#596376",
                        "surface-dim": "#ded9d4",
                        "on-primary": "#ffffff",
                        "surface-container": "#f2ede8",
                        "on-tertiary-fixed-variant": "#004f53",
                        "error-container": "#ffdad6",
                        "surface-variant": "#e6e2dd",
                        "on-tertiary": "#ffffff",
                        "inverse-surface": "#32302d",
                        "on-tertiary-fixed": "#002022",
                        "on-primary-container": "#fffbff",
                        "primary-fixed": "#ffdad7",
                        "inverse-primary": "#ffb3ad",
                        "on-secondary-fixed": "#121c2c",
                        "on-primary-fixed": "#410004",
                        "on-background": "#1d1b19",
                        "on-error-container": "#93000a",
                        "outline": "#8f6f6d",
                        "surface-bright": "#fef8f3",
                        "surface-container-low": "#f8f3ee",
                        "surface": "#fef8f3",
                        "on-error": "#ffffff",
                        "outline-variant": "#e4beba",
                        "surface-tint": "#b91c24",
                        "primary": "#b51822",
                        "secondary-fixed": "#d9e3f9",
                        "on-surface": "#1d1b19",
                        "primary-container": "#d93537",
                        "on-surface-variant": "#5b403e",
                        "background": "#fef8f3",
                        "inverse-on-surface": "#f5f0eb",
                        "on-tertiary-container": "#f4ffff",
                        "secondary-container": "#d6e0f6",
                        "on-primary-fixed-variant": "#930013",
                        "on-secondary": "#ffffff",
                        "error": "#ba1a1a",
                        "tertiary-container": "#008188",
                        "tertiary": "#00666c",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-highest": "#e6e2dd",
                        "surface-container-high": "#ece7e2",
                        "secondary": "#555f71",
                        "secondary-fixed-dim": "#bdc7dc"
                    },
                    "borderRadius": {
                        "DEFAULT": "1rem",
                        "lg": "2rem",
                        "xl": "3rem",
                        "full": "9999px"
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-surface text-on-surface h-screen flex flex-col overflow-hidden">
<!-- Top Navigation Bar -->
<header class="fixed top-0 w-full z-50 bg-[#fef8f3]/80 backdrop-blur-md">
<div class="flex justify-between items-center px-8 py-4 max-w-7xl mx-auto">
<div class="text-2xl font-black text-[#b51822] tracking-tighter font-display">SIGMA</div>
<nav class="hidden md:flex gap-8 items-center font-display font-bold tracking-tight">
<a class="text-stone-600 hover:text-[#b51822] transition-colors duration-300" href="/ai/chatbot">Asisten Gizi</a>
<a class="text-stone-600 hover:text-[#b51822] transition-colors duration-300" href="/ai/scanner">Scanner Kalori</a>
</nav>
<div class="flex items-center gap-4">
<button class="text-stone-600 p-2">
<span class="material-symbols-outlined">account_circle</span>
</button>
</div>
</div>
</header>
<main class="flex flex-1 pt-20 overflow-hidden">
<!-- Sidebar: Chat History -->
<aside class="hidden lg:flex flex-col w-80 bg-surface-container-low border-r border-surface-container-highest/10 p-6">
<div class="flex items-center justify-between mb-8">
<h2 class="font-display font-bold text-lg text-on-surface">Riwayat Chat</h2>
<button class="p-2 bg-surface-container-highest rounded-full hover:bg-surface-variant transition-colors" id="btn-new-chat">
<span class="material-symbols-outlined text-primary">add</span>
</button>
</div>
<div class="space-y-3 flex-1 overflow-y-auto" id="session-list">
    <!-- Sessions will be loaded here -->
    <div class="animate-pulse space-y-4">
        <div class="h-12 bg-surface-container rounded-lg w-full"></div>
        <div class="h-12 bg-surface-container rounded-lg w-full"></div>
    </div>
</div>
</aside>

<!-- Main Chat Area -->
<section class="flex-1 flex flex-col bg-surface relative">
<!-- Chat Header -->
<div class="px-8 py-4 bg-surface-container-low/50 backdrop-blur flex items-center gap-4 border-b border-surface-container-highest/10">
<div class="w-10 h-10 rounded-full bg-gradient-to-tr from-primary to-primary-container flex items-center justify-center text-white shadow-lg shadow-primary/20">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
</div>
<div>
<h1 class="font-display font-extrabold text-on-surface leading-tight" id="active-session-title">Asisten Gizi SIGMA</h1>
<p class="text-xs text-primary font-semibold flex items-center gap-1">
<span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                        Didukung oleh Gemini AI
                    </p>
</div>
</div>
<!-- Messages Canvas -->
<div class="flex-1 overflow-y-auto p-8 space-y-8" id="chat-box">
    
    <!-- AI Welcome Message -->
    <div class="flex flex-col items-start" id="welcome-message">
        <div class="max-w-[90%] md:max-w-[75%] space-y-4">
            <div class="flex gap-4 items-start">
                <div class="w-8 h-8 rounded-full bg-surface-container-highest flex-shrink-0 flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-sm">auto_awesome</span>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-2xl rounded-tl-none border border-surface-container-highest/30 shadow-sm">
                    <p class="text-[15px] text-on-surface leading-relaxed">Halo! Saya Asisten Gizi SIGMA. Ingin mencari rekomendasi makanan UMKM hari ini? Silakan beritahu saya preferensi atau budget Anda.</p>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- Input Area -->
<div class="p-6 md:px-12 md:pb-12 bg-surface/80 backdrop-blur-md">
<div class="max-w-4xl mx-auto relative group">
<div class="absolute inset-0 bg-primary/5 rounded-full blur-xl group-focus-within:bg-primary/10 transition-all"></div>
<div class="relative bg-surface-container-lowest border border-surface-container-highest/50 rounded-full flex items-center px-6 py-3 shadow-xl shadow-stone-900/5 focus-within:ring-2 focus-within:ring-primary/20 transition-all">
<span class="material-symbols-outlined text-primary-container mr-4 fill-icon">auto_awesome</span>
<input id="chat-input" class="flex-1 bg-transparent border-none focus:ring-0 text-sm md:text-base text-on-surface placeholder:text-on-surface-variant/50" placeholder="Tanya tentang nutrisi atau cari menu hemat..." type="text" autocomplete="off"/>
<div class="flex gap-2">
<button id="btn-send-chat" class="bg-primary text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-primary-container transition-all shadow-lg shadow-primary/30">
<span class="material-symbols-outlined text-xl">send</span>
</button>
</div>
</div>
<p class="text-center text-[10px] mt-4 text-on-surface-variant font-medium">Asisten Gizi SIGMA dapat memberikan informasi yang tidak akurat. Verifikasi info penting kepada ahli gizi.</p>
</div>
</div>
</section>
</main>

<script>
    const chatBox = document.getElementById('chat-box');
    const chatInput = document.getElementById('chat-input');
    const btnSendChat = document.getElementById('btn-send-chat');
    const sessionList = document.getElementById('session-list');
    const btnNewChat = document.getElementById('btn-new-chat');
    const activeSessionTitle = document.getElementById('active-session-title');
    const welcomeMessage = document.getElementById('welcome-message');

    let activeSessionId = null;

    // Load sessions on startup
    window.addEventListener('load', loadSessions);

    btnNewChat.addEventListener('click', () => {
        activeSessionId = null;
        chatBox.innerHTML = '';
        chatBox.appendChild(welcomeMessage);
        activeSessionTitle.innerText = "Sesi Chat Baru";
        loadSessions(); // refresh highlight
    });

    async function loadSessions() {
        try {
            const res = await fetch('/chat/sessions');
            const sessions = await res.json();
            
            sessionList.innerHTML = '';
            sessions.forEach(session => {
                const isActive = activeSessionId == session.id;
                const div = document.createElement('div');
                div.className = `p-4 rounded-lg cursor-pointer transition-colors ${isActive ? 'bg-surface-container-highest border-l-4 border-primary' : 'hover:bg-surface-container'}`;
                div.innerHTML = `
                    <p class="font-semibold text-sm truncate">${session.title || 'Chat Tanpa Judul'}</p>
                    <p class="text-xs text-on-surface-variant mt-1">${new Date(session.created_at).toLocaleDateString('id-ID')}</p>
                `;
                div.onclick = () => loadSessionMessages(session.id, session.title);
                sessionList.appendChild(div);
            });
        } catch (e) { console.error("Load sessions failed", e); }
    }

    async function loadSessionMessages(id, title) {
        activeSessionId = id;
        activeSessionTitle.innerText = title || "Asisten Gizi SIGMA";
        chatBox.innerHTML = '<div class="flex justify-center p-10"><div class="typing-loader"><span></span><span></span><span></span></div></div>';
        loadSessions(); // refresh highlight

        try {
            const res = await fetch(`/chat/sessions/${id}`);
            const data = await res.json();
            chatBox.innerHTML = '';
            
            data.messages.forEach(msg => {
                if (msg.role === 'user') {
                    appendUserMessage(msg.content, false);
                } else {
                    appendAIMessage(msg.content, msg.recommendation_data || [], false);
                }
            });
        } catch (e) { console.error("Load messages failed", e); }
    }

    function appendUserMessage(text, scroll = true) {
        const div = document.createElement('div');
        div.className = "flex flex-col items-end mb-8";
        div.innerHTML = `
            <div class="max-w-[80%] md:max-w-[60%] bg-primary text-white p-5 rounded-t-2xl rounded-bl-2xl shadow-lg shadow-primary/10">
                <p class="text-[15px] leading-relaxed">${text}</p>
            </div>
            <span class="text-[10px] mt-2 text-on-surface-variant font-medium">Terkirim</span>
        `;
        chatBox.appendChild(div);
        if (scroll) chatBox.scrollTop = chatBox.scrollHeight;
    }

    function appendAIMessage(text, recommendations = [], scroll = true, isError = false) {
        const id = 'ai-msg-' + Date.now();
        let html = `
            <div id="${id}" class="flex flex-col items-start mb-8">
                <div class="max-w-[90%] md:max-w-[75%] space-y-4">
                    <div class="flex gap-4 items-start">
                        <div class="w-8 h-8 rounded-full bg-surface-container-highest flex-shrink-0 flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary text-sm">auto_awesome</span>
                        </div>
                        <div class="bg-surface-container-lowest p-6 rounded-2xl rounded-tl-none border ${isError ? 'border-red-500/50' : 'border-surface-container-highest/30'} shadow-sm w-full">
                            <p class="text-[15px] text-on-surface leading-relaxed ${isError ? 'text-red-600 font-medium' : ''}">${text}</p>
        `;

        if (recommendations && recommendations.length > 0) {
            html += `<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">`;
            recommendations.forEach(item => {
                const img = item.image_url ? item.image_url : 'https://via.placeholder.com/150';
                html += `
                <div class="group relative overflow-hidden bg-surface-container-low rounded-lg p-3 transition-all hover:bg-surface-container">
                    <div class="aspect-square w-full rounded-md overflow-hidden mb-3">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="${img}"/>
                    </div>
                    <h4 class="font-display font-bold text-sm text-primary">${item.name}</h4>
                    <p class="text-xs text-on-surface-variant mt-1">${item.description}</p>
                    <div class="mt-2 flex justify-between items-center">
                        <span class="text-sm font-black text-on-surface">Rp${item.price.toLocaleString('id-ID')}</span>
                        <span class="px-2 py-0.5 bg-secondary-container text-on-secondary-container text-[10px] rounded-full font-bold">${item.calories} kcal</span>
                    </div>
                </div>
                `;
            });
            html += `</div>`;
        }

        html += `
                        </div>
                    </div>
                </div>
            </div>
        `;

        const div = document.createElement('div');
        div.innerHTML = html;
        chatBox.appendChild(div.firstElementChild);
        if (scroll) chatBox.scrollTop = chatBox.scrollHeight;
    }

    function appendTypingIndicator() {
        const id = 'typing-' + Date.now();
        const html = `
            <div id="${id}" class="flex flex-col items-start">
                <div class="flex gap-4 items-center">
                    <div class="w-8 h-8 rounded-full bg-surface-container-highest flex-shrink-0 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-sm">auto_awesome</span>
                    </div>
                    <div class="bg-surface-container-lowest p-4 rounded-2xl rounded-tl-none border border-surface-container-highest/30 shadow-sm">
                        <div class="typing-loader">
                            <span></span><span></span><span></span>
                        </div>
                    </div>
                </div>
            </div>
        `;
        const div = document.createElement('div');
        div.innerHTML = html;
        chatBox.appendChild(div.firstElementChild);
        chatBox.scrollTop = chatBox.scrollHeight;
        return id;
    }

    chatInput.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            btnSendChat.click();
        }
    });

    btnSendChat.addEventListener('click', async () => {
        const message = chatInput.value.trim();
        if (!message) return;

        appendUserMessage(message);
        chatInput.value = '';
        
        const typingId = appendTypingIndicator();

        try {
            const response = await fetch('/chatbot', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ 
                    message: message,
                    session_id: activeSessionId
                })
            });
            const data = await response.json();
            
            document.getElementById(typingId).remove();
            
            // update session id if it was a new chat
            if (!activeSessionId && data.session_id) {
                activeSessionId = data.session_id;
                loadSessions();
            }

            let replyText = data.reply;
            if (data.error) {
                replyText += `<br><br><span class="text-xs font-mono text-red-400">DEBUG: ${data.error}</span>`;
            }
            
            appendAIMessage(replyText, data.recommendations, true, !!data.error);
        } catch (error) {
            if (document.getElementById(typingId)) document.getElementById(typingId).remove();
            appendAIMessage('Maaf, terjadi kesalahan pada sistem jaringan.', [], true, true);
        }
    });
</script>
</body>
</html>
