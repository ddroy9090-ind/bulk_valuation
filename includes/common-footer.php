<div id="popup" class="popup">
    <div>
        <h6>Report downloaded</h6>
        <p>Downloaded report for 789 Pine St, Chicago, IL 60601</p>
    </div>
    <button onclick="hidePopup()">&times;</button>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const sidebar = document.getElementById('sidebar');
    const menuBtn = document.getElementById('menuBtn');
    const closeBtn = document.getElementById('closeBtn');
    const userMenu = document.getElementById('userMenu');
    const dropdownMenu = document.getElementById('dropdownMenu');

    // ✅ Function to set initial state based on screen size
    function setInitialSidebar() {
        if (window.innerWidth <= 768) {
            // Mobile: Sidebar collapsed by default (icons only)
            sidebar.classList.add('collapsed');
            sidebar.classList.remove('expanded');
            menuBtn.classList.remove('hide');
            closeBtn.classList.add('hide');
        } else {
            // Desktop: Sidebar expanded by default
            sidebar.classList.add('expanded');
            sidebar.classList.remove('collapsed');
            menuBtn.classList.add('hide');
            closeBtn.classList.remove('hide');
        }
    }

    // ✅ Toggle open/close
    menuBtn.addEventListener('click', () => {
        sidebar.classList.add('expanded');
        sidebar.classList.remove('collapsed');
        menuBtn.classList.add('hide');
        closeBtn.classList.remove('hide');
    });

    closeBtn.addEventListener('click', () => {
        sidebar.classList.remove('expanded');
        sidebar.classList.add('collapsed');
        closeBtn.classList.add('hide');
        menuBtn.classList.remove('hide');
    });

    // ✅ Dropdown toggle
    userMenu.addEventListener('click', () => {
        dropdownMenu.classList.toggle('show');
    });

    // ✅ Close dropdown if clicked outside
    document.addEventListener('click', (e) => {
        if (!userMenu.contains(e.target)) {
            dropdownMenu.classList.remove('show');
        }
    });

    // ✅ On window resize, reset sidebar properly
    window.addEventListener('resize', setInitialSidebar);

    // ✅ Initial call
    setInitialSidebar();
</script>

<!-- JS for Progress Bar -->
<script>
    const fileInput = document.getElementById("fileUpload");
    const progressContainer = document.getElementById("progressContainer");
    const progressBar = document.getElementById("progressBar");

    fileInput.addEventListener("change", function () {
        if (fileInput.files.length > 0) {
            progressContainer.style.display = "block"; // show progress bar
            let progress = 0;

            // fake progress simulation (you can replace with real AJAX upload)
            let interval = setInterval(() => {
                progress += 10;
                progressBar.style.width = progress + "%";
                progressBar.innerText = progress + "%";
                progressBar.setAttribute("aria-valuenow", progress);

                if (progress >= 100) {
                    clearInterval(interval);
                    progressBar.innerText = "Upload Complete!";
                }
            }, 300);
        }
    });
</script>

<script>
    const downloadBtn = document.getElementById('downloadAllBtn');
    const downloadProgressContainer = document.getElementById('downloadProgressContainer');
    const downloadProgressBar = document.getElementById('downloadProgressBar');

    downloadBtn?.addEventListener('click', () => {
        downloadProgressContainer.style.display = 'block';
        let progress = 0;

        const interval = setInterval(() => {
            progress = Math.min(progress + 10, 95);
            downloadProgressBar.style.width = progress + '%';
            downloadProgressBar.innerText = progress + '%';
            downloadProgressBar.setAttribute('aria-valuenow', progress);
        }, 300);

        fetch('download-all.php')
            .then(response => response.blob())
            .then(blob => {
                clearInterval(interval);
                downloadProgressBar.style.width = '100%';
                downloadProgressBar.innerText = '100%';
                downloadProgressBar.setAttribute('aria-valuenow', 100);

                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'reports.pdf';
                document.body.appendChild(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(url);

                setTimeout(() => {
                    downloadProgressContainer.style.display = 'none';
                    downloadProgressBar.style.width = '0%';
                    downloadProgressBar.innerText = '0%';
                    downloadProgressBar.setAttribute('aria-valuenow', 0);
                }, 2000);
            });
    });
</script>

<script>
    // URL-aware active state for sidebar
    (function () {
        const sidebar = document.querySelector('.cms-layout .sidebar');
        const items = sidebar.querySelectorAll('li');
        const links = sidebar.querySelectorAll('li a[href]');

        // Normalize to filename (handles /path/, ?query, #hash)
        const fileOf = (path) => {
            const p = path.split('?')[0].split('#')[0];
            const last = p.substring(p.lastIndexOf('/') + 1);
            return last || 'index.php'; // treat "/" as index.php
        };

        function setActiveFromUrl() {
            const current = fileOf(location.pathname);
            let matched = false;

            items.forEach(li => li.classList.remove('active'));

            links.forEach(link => {
                const linkFile = fileOf(new URL(link.getAttribute('href'), location.origin).pathname);
                if (linkFile === current) {
                    link.closest('li')?.classList.add('active');
                    matched = true;
                }
            });

            // Fallback: if nothing matched, keep first li active
            if (!matched && items.length) items[0].classList.add('active');
        }

        // Immediate visual feedback on click (before navigation)
        links.forEach(link => {
            link.addEventListener('click', () => {
                items.forEach(li => li.classList.remove('active'));
                link.closest('li')?.classList.add('active');
            });
        });

        setActiveFromUrl();
    })();
</script>



<script>
    function showPopup() {
        const popup = document.getElementById("popup");
        popup.classList.add("show");

        // Auto hide after 5s
        setTimeout(() => {
            hidePopup();
        }, 20000);
    }

    function hidePopup() {
        document.getElementById("popup").classList.remove("show");
    }
</script>


</body>

</html>