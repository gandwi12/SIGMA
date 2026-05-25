document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('filterForm');
    const priceRange = document.getElementById('priceRange');
    const priceText = document.getElementById('priceText');
    const categoryInput = document.getElementById('categoryInput');
    const chips = document.querySelectorAll('.nutrisi-chip');
    const distanceSelect = document.getElementById('distanceSelect');

    const openFilter = document.getElementById('openFilter');
    const closeFilter = document.getElementById('closeFilter');
    const filterPanel = document.getElementById('filterPanel');

    function updateRangeColor() {
        if (!priceRange) return;

        const min = Number(priceRange.min);
        const max = Number(priceRange.max);
        const val = Number(priceRange.value);
        const percent = ((val - min) / (max - min)) * 100;

        priceRange.style.background =
            `linear-gradient(to right, #be1622 0%, #be1622 ${percent}%, #d8d0ca ${percent}%, #d8d0ca 100%)`;

        if (priceText) {
            priceText.textContent = Math.round(val / 1000) + 'rb';
        }
    }

    if (priceRange && form) {
        updateRangeColor();

        priceRange.addEventListener('input', function () {
            updateRangeColor();
        });

        priceRange.addEventListener('change', function () {
            form.submit();
        });
    }

    if (distanceSelect && form) {
        distanceSelect.addEventListener('change', function () {
            form.submit();
        });
    }

    chips.forEach(chip => {
        chip.addEventListener('click', function () {
            chips.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            categoryInput.value = this.dataset.category;
            form.submit();
        });
    });

    if (openFilter && closeFilter && filterPanel) {
        openFilter.addEventListener('click', function () {
            filterPanel.classList.add('show');
        });

        closeFilter.addEventListener('click', function () {
            filterPanel.classList.remove('show');
        });

        filterPanel.addEventListener('click', function (e) {
            if (e.target === filterPanel) {
                filterPanel.classList.remove('show');
            }
        });
    }
});