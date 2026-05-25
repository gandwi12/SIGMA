const uploadInput = document.querySelector('input[name="foto"]');

if (uploadInput) {

    uploadInput.addEventListener('change', function (e) {

        const file = e.target.files[0];

        if (!file) return;

        const preview = document.getElementById('preview-image');

        if (preview) {

            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');

        }

    });

}