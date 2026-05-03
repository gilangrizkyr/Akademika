// Global Config from Meta Tags
const config = {
    csrf: document.querySelector('meta[name="X-CSRF-TOKEN"]')?.content,
    baseUrl: document.querySelector('meta[name="base-url"]')?.content
};

document.addEventListener('DOMContentLoaded', () => {
    // 1. ASYNC VIEW INCREMENT
    const researchDetail = document.getElementById('research-detail-id');
    if (researchDetail) {
        const id = researchDetail.dataset.id;
        fetch(`${config.baseUrl}/api/research/view/${id}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': config.csrf
            }
        });
    }

    // 2. BOOKMARK TOGGLE
    const bookmarkBtn = document.getElementById('bookmark-toggle-btn');
    if (bookmarkBtn) {
        bookmarkBtn.addEventListener('click', async (e) => {
            e.preventDefault();
            const id = bookmarkBtn.dataset.id;
            
            try {
                const response = await fetch(`${config.baseUrl}/api/bookmark/toggle/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': config.csrf
                    }
                });
                const result = await response.json();
                
                if (result.status === 'success') {
                    const icon = bookmarkBtn.querySelector('i');
                    if (result.action === 'added') {
                        icon.classList.replace('fa-regular', 'fa-solid');
                        bookmarkBtn.classList.replace('btn-outline-primary', 'btn-primary');
                        bookmarkBtn.innerHTML = '<i class="fa-solid fa-bookmark me-2"></i> Tersimpan';
                    } else {
                        icon.classList.replace('fa-solid', 'fa-regular');
                        bookmarkBtn.classList.replace('btn-primary', 'btn-outline-primary');
                        bookmarkBtn.innerHTML = '<i class="fa-regular fa-bookmark me-2"></i> Simpan';
                    }
                } else if (result.message) {
                    alert(result.message);
                }
            } catch (err) {
                console.error('Bookmark error:', err);
            }
        });
    }

    // 3. LIVE SEARCH
    const searchInput = document.getElementById('live-search-input');
    const searchResults = document.getElementById('search-results-container');
    
    if (searchInput && searchResults) {
        let timeout = null;
        searchInput.addEventListener('input', (e) => {
            clearTimeout(timeout);
            timeout = setTimeout(async () => {
                const q = e.target.value;
                if (q.length < 2) return;

                const response = await fetch(`${config.baseUrl}/search?q=${encodeURIComponent(q)}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const result = await response.json();
                
                if (result.status === 'success') {
                    searchResults.innerHTML = '';
                    if (result.data.length === 0) {
                        searchResults.innerHTML = `
                            <div class="col-12 text-center py-5">
                                <img src="${config.baseUrl}/img/logonotfound.png" alt="Not found" style="height: 150px;" class="mb-4">
                                <h3 class="fw-bold">Tidak ada hasil ditemukan</h3>
                            </div>
                        `;
                    } else {
                        result.data.forEach(item => {
                            searchResults.innerHTML += `
                                <div class="col-md-4">
                                    <div class="card h-100 shadow-sm border-0 animate-fade-in">
                                        <img src="${config.baseUrl}/uploads/research/${item.cover_image || 'default.jpg'}" class="card-img-top" style="height: 200px; object-fit: cover;">
                                        <div class="card-body p-4">
                                            <div class="mb-2">
                                                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 small">${item.category_name || 'General'}</span>
                                            </div>
                                            <h5 class="card-title fw-bold mb-3">
                                                <a href="${config.baseUrl}/research/${item.slug}" class="text-decoration-none text-main">${item.title}</a>
                                            </h5>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-muted small"><i class="fa-solid fa-eye me-1"></i> ${item.views}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                    }
                }
            }, 300);
        });
    }

    // Theme Toggle Logic (Preserved)
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
        const html = document.documentElement;
        const icon = themeToggle.querySelector('i');

        const updateIcon = (theme) => {
            if (icon) {
                if (theme === 'dark') {
                    icon.classList.replace('fa-moon', 'fa-sun');
                } else {
                    icon.classList.replace('fa-sun', 'fa-moon');
                }
            }
        };

        const savedTheme = localStorage.getItem('theme') || 'light';
        html.setAttribute('data-bs-theme', savedTheme);
        updateIcon(savedTheme);

        themeToggle.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            html.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateIcon(newTheme);
        });
    }

    // Sidebar Toggle (Preserved)
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });
    }

    // Smooth Scroll (Preserved)
    document.querySelectorAll('.sticky-sidebar a').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const target = document.querySelector(targetId);
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
});
