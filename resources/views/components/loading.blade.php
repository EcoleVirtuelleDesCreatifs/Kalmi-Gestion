<div id="globalLoader" class="fixed inset-0 z-[9999] hidden flex-col items-center justify-center bg-black bg-opacity-60 backdrop-blur-sm">
    <div class="w-12 h-12 border-4 border-white border-t-indigo-600 rounded-full animate-spin"></div>
    <p class="mt-4 text-white font-medium text-lg">Chargement...</p>
</div>

<script>
    (function () {
        const loader = document.getElementById('globalLoader');

        function showLoader() {
            loader.classList.remove('hidden');
            loader.classList.add('flex');
        }

        window.showGlobalLoader = showLoader;

        window.addEventListener('beforeunload', showLoader);

        document.querySelectorAll('a[href], button[type="submit"]').forEach(function (el) {
            el.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (this.tagName.toLowerCase() === 'button') {
                    showLoader();
                    return;
                }
                if (href && href.length > 0 && !href.startsWith('#') && !href.startsWith('javascript:') && this.getAttribute('target') !== '_blank') {
                    showLoader();
                }
            });
        });
    })();
</script>
