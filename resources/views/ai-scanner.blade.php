<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;family=Inter:wght@400;500;600&amp;family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
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
            },
            "fontFamily": {
                    "headline": ["Plus Jakarta Sans"],
                    "display": ["Plus Jakarta Sans"],
                    "body": ["Inter"],
                    "label": ["Inter"]
            }
          }
        }
      }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .tonal-transition { transition: background-color 0.3s ease; }
        .no-border { border: none !important; }
        .scanner-line {
            height: 2px;
            background: linear-gradient(90deg, transparent, #b51822, transparent);
            box-shadow: 0 0 15px #b51822;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            display: none;
        }
        @keyframes scan {
            from { top: 0; }
            to { top: 100%; }
        }
        .scanning .scanner-line {
            display: block;
            animation: scan 2s linear infinite;
        }
    </style>
</head>
<body class="bg-surface font-body text-on-surface">
<!-- TopNavBar -->
<nav class="fixed top-0 w-full z-50 bg-[#fef8f3]/80 backdrop-blur-md tonal-transition">
<div class="flex justify-between items-center px-8 py-4 max-w-7xl mx-auto">
<div class="text-2xl font-black text-[#b51822] tracking-tighter font-headline">SIGMA</div>
<div class="hidden md:flex items-center space-x-8 font-headline font-bold tracking-tight">
<a class="text-stone-600 hover:text-[#b51822] transition-colors duration-300" href="/ai/chatbot">Asisten Gizi</a>
<a class="text-stone-600 hover:text-[#b51822] transition-colors duration-300" href="/ai/scanner">Scanner Kalori</a>
</div>
<div class="flex items-center gap-4">
<button class="material-symbols-outlined text-[#b51822] p-2 hover:bg-surface-container rounded-full transition-all">account_circle</button>
</div>
</div>
</nav>

<main class="pt-24 pb-20 px-4 md:px-8 max-w-7xl mx-auto">
<!-- Editorial Header -->
<header class="mb-12">
<h1 class="font-display text-4xl md:text-6xl font-extrabold tracking-tight text-on-surface mb-4">
                Nutrisi dalam <span class="text-primary italic">Satu Lensa.</span>
</h1>
<p class="text-on-surface-variant text-lg max-w-2xl font-medium leading-relaxed">
                Gunakan AI Scanner kami untuk mendeteksi kalori dan kandungan nutrisi makanan Anda secara instan. Editorial nutrisi yang akurat untuk gaya hidup sehat mahasiswa.
            </p>
</header>

<!-- Scanner Section -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start mb-16">
<!-- Left: Viewfinder Area -->
<div class="lg:col-span-7 relative group" id="viewfinder-container">
    <div class="relative aspect-[4/3] rounded-xl overflow-hidden bg-surface-container-highest ring-8 ring-surface-container shadow-2xl cursor-pointer" id="drop-zone">
        <!-- Preview Image -->
        <img class="w-full h-full object-cover transition-all duration-700" id="image-preview" src="https://via.placeholder.com/800x600?text=Klik+untuk+Upload+Foto+Makanan" />
        
        <!-- Viewfinder Overlays -->
        <div class="absolute inset-0 border-[2px] border-white/20 m-6 rounded-lg pointer-events-none">
            <div class="absolute top-0 left-0 w-8 h-8 border-t-4 border-l-4 border-primary rounded-tl-lg"></div>
            <div class="absolute top-0 right-0 w-8 h-8 border-t-4 border-r-4 border-primary rounded-tr-lg"></div>
            <div class="absolute bottom-0 left-0 w-8 h-8 border-b-4 border-l-4 border-primary rounded-bl-lg"></div>
            <div class="absolute bottom-0 right-0 w-8 h-8 border-b-4 border-r-4 border-primary rounded-br-lg"></div>
        </div>
        
        <!-- Scanning Line -->
        <div class="scanner-line opacity-70"></div>
    </div>
    
    <input type="file" id="file-input" class="hidden" accept="image/*">
    
    <div class="mt-6 flex flex-wrap gap-4">
        <button id="btn-browse" class="flex-1 bg-surface-container-highest text-primary font-headline font-bold py-4 rounded-full transition-all hover:bg-surface-variant shadow-lg flex items-center justify-center gap-2">
            <span class="material-symbols-outlined">upload_file</span>
            Pilih Foto
        </button>
        <button id="btn-scan" class="flex-1 bg-primary text-on-primary font-headline font-bold py-4 rounded-full transition-all hover:bg-primary-container shadow-lg disabled:opacity-50 disabled:cursor-not-allowed" disabled>
            Mulai Scan AI
        </button>
    </div>
</div>

<!-- Right: Results Panel -->
<div class="lg:col-span-5 flex flex-col gap-6">
    <div class="bg-surface-container-lowest p-8 rounded-lg shadow-sm border border-surface-container-highest/30 min-h-[400px] flex flex-col justify-center" id="results-panel">
        <div class="text-center py-10" id="empty-state">
            <span class="material-symbols-outlined text-surface-variant text-6xl mb-4">analytics</span>
            <p class="text-on-surface-variant font-medium">Upload foto makanan untuk melihat<br>analisis gizi mendalam dari SIGMA AI.</p>
        </div>

        <div id="result-content" class="hidden">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <span class="text-xs font-bold font-headline uppercase tracking-[0.2em] text-primary block mb-2">Hasil Analisis AI</span>
                    <h2 class="text-3xl font-display font-extrabold text-on-surface" id="res-food-name">...</h2>
                </div>
                <div class="bg-primary-container text-on-primary-container px-4 py-2 rounded-xl text-center">
                    <span class="block text-2xl font-black" id="res-calories">0</span>
                    <span class="text-[10px] font-bold uppercase tracking-wider">kcal</span>
                </div>
            </div>

            <div class="space-y-6 mb-8">
                <!-- Data Statis Dummy disembunyikan, kita pakai data dinamis -->
                <p class="text-sm text-on-surface-variant italic mb-4" id="res-description"></p>
                <div class="p-4 bg-surface-container-low rounded-xl text-xs font-bold text-on-surface-variant">
                    Confidence Level: <span id="res-confidence" class="text-primary">0%</span>
                </div>
            </div>

            <button onclick="location.reload()" class="w-full flex items-center justify-center gap-2 text-primary font-bold py-2 hover:underline decoration-2 underline-offset-4">
                <span class="material-symbols-outlined text-base">refresh</span>
                Scan Ulang
            </button>
        </div>
    </div>

    <!-- Nutrition Tip Chip -->
    <div class="bg-secondary-container text-on-secondary-container p-6 rounded-lg flex gap-4 items-start border-0">
        <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">info</span>
        <div>
            <p class="font-bold text-sm mb-1">Tips Nutrisi SIGMA</p>
            <p class="text-xs leading-relaxed opacity-90 font-medium">Gunakan foto yang terang dan fokus pada makanan agar AI dapat mendeteksi kalori dengan akurasi maksimal.</p>
        </div>
    </div>
</div>
</div>
</main>

<script>
    const fileInput = document.getElementById('file-input');
    const dropZone = document.getElementById('drop-zone');
    const imagePreview = document.getElementById('image-preview');
    const btnBrowse = document.getElementById('btn-browse');
    const btnScan = document.getElementById('btn-scan');
    const viewfinder = document.getElementById('viewfinder-container');
    
    const resultContent = document.getElementById('result-content');
    const emptyState = document.getElementById('empty-state');
    const resFoodName = document.getElementById('res-food-name');
    const resCalories = document.getElementById('res-calories');
    const resDescription = document.getElementById('res-description');
    const resConfidence = document.getElementById('res-confidence');

    btnBrowse.addEventListener('click', () => fileInput.click());
    dropZone.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                btnScan.disabled = false;
            }
            reader.readAsDataURL(file);
        }
    });

    btnScan.addEventListener('click', async () => {
        const file = fileInput.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('food_image', file);
        
        // Start Animation
        viewfinder.classList.add('scanning');
        btnScan.disabled = true;
        btnScan.innerText = 'Menganalisis...';

        try {
            const response = await fetch('/scanner', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });
            const data = await response.json();
            
            viewfinder.classList.remove('scanning');
            
            if (response.ok && data.success) {
                emptyState.classList.add('hidden');
                resultContent.classList.remove('hidden');
                
                resFoodName.innerText = data.food_name;
                resCalories.innerText = data.estimated_calories.split(' ')[0]; // Ambil angka saja
                resDescription.innerText = data.description;
                resConfidence.innerText = data.confidence;

                // Smooth scroll to results on mobile
                if (window.innerWidth < 1024) {
                    document.getElementById('results-panel').scrollIntoView({ behavior: 'smooth' });
                }
            } else {
                alert(data.message || 'Gagal mendeteksi gambar.');
                btnScan.disabled = false;
                btnScan.innerText = 'Mulai Scan AI';
            }
        } catch (error) {
            viewfinder.classList.remove('scanning');
            alert('Terjadi kesalahan jaringan.');
            btnScan.disabled = false;
            btnScan.innerText = 'Mulai Scan AI';
        }
    });
</script>
</body>
</html>
