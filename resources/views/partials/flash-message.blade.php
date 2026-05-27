@if(session('success'))
    <div id="flashMessage"
         class="fixed top-6 left-1/2 -translate-x-1/2 z-[9999] bg-green-100 border border-green-300 text-green-800 px-8 py-4 rounded-2xl shadow-xl font-bold">
        {{ session('success') }}
    </div>

    <script>
        setTimeout(() => {
            const flash = document.getElementById('flashMessage');
            if (flash) {
                flash.style.transition = '0.4s';
                flash.style.opacity = '0';
                flash.style.transform = 'translate(-50%, -10px)';
                setTimeout(() => flash.remove(), 400);
            }
        }, 2500);
    </script>
@endif

@if(session('error'))
    <div id="flashMessage"
         class="fixed top-6 left-1/2 -translate-x-1/2 z-[9999] bg-red-100 border border-red-300 text-red-800 px-8 py-4 rounded-2xl shadow-xl font-bold">
        {{ session('error') }}
    </div>

    <script>
        setTimeout(() => {
            const flash = document.getElementById('flashMessageError');
            if (flash) {
                flash.style.transition = '0.4s';
                flash.style.opacity = '0';
                flash.style.transform = 'translate(-50%, -10px)';
                setTimeout(() => flash.remove(), 400);
            }
        }, 2500);
    </script>
@endif

@if($errors->any())
    <div id="flashMessageValidation"
         class="fixed top-6 left-1/2 -translate-x-1/2 z-[9999] bg-red-100 border border-red-300 text-red-800 px-8 py-4 rounded-2xl shadow-xl font-bold">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>

    <script>
        setTimeout(() => {
            const flash = document.getElementById('flashMessageValidation');
            if (flash) {
                flash.style.transition = '0.4s';
                flash.style.opacity = '0';
                flash.style.transform = 'translate(-50%, -10px)';
                setTimeout(() => flash.remove(), 400);
            }
        }, 3500);
    </script>
@endif