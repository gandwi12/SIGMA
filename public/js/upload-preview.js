const imageInputs = document.querySelectorAll('input[type="file"]');

imageInputs.forEach(input => {

    input.addEventListener('change', function (e) {

        const file = e.target.files[0];

        if (!file) return;

        let preview = document.getElementById('image-preview');

        if (!preview) {

            preview = document.createElement('img');
            preview.id = 'image-preview';
            preview.className = 'preview-image';

            input.parentElement.appendChild(preview);

        }

        preview.src = URL.createObjectURL(file);

    });

});