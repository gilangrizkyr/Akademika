// Global Config from Meta Tags
const config = {
    csrf: document.querySelector('meta[name="X-CSRF-TOKEN"]')?.content,
    baseUrl: document.querySelector('meta[name="base-url"]')?.content
};

// 1. NOTIFICATION SYSTEM (Toast)
function showToast(message, type = 'info') {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = `toast-custom toast-${type}`;
    
    const icon = type === 'success' ? 'fa-circle-check' : (type === 'error' ? 'fa-circle-xmark' : 'fa-circle-info');
    
    toast.innerHTML = `
        <i class="fa-solid ${icon}"></i>
        <div class="toast-content">${message}</div>
    `;

    container.appendChild(toast);
    
    // Trigger animation
    setTimeout(() => toast.classList.add('show'), 10);
    
    // Auto remove
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 400);
    }, 4000);
}

document.addEventListener('DOMContentLoaded', () => {
    // 2. OPTIMIZED ASYNC VIEW INCREMENT (Avoid Double Count)
    const researchDetail = document.getElementById('research-detail-id');
    if (researchDetail) {
        const id = researchDetail.dataset.id;
        const storageKey = `viewed_res_${id}`;
        
        // Only count if not viewed in last 24h
        const lastViewed = localStorage.getItem(storageKey);
        const now = new Date().getTime();
        
        if (!lastViewed || (now - lastViewed > 24 * 60 * 60 * 1000)) {
            fetch(`${config.baseUrl}/api/research/view/${id}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': config.csrf
                }
            }).then(response => {
                if (response.ok) {
                    localStorage.setItem(storageKey, now.toString());
                }
            }).catch(err => console.error('View increment error:', err));
        }
    }

    // 3. BOOKMARK TOGGLE (with Toast & Error Handling)
    const bookmarkBtn = document.getElementById('bookmark-toggle-btn');
    if (bookmarkBtn) {
        bookmarkBtn.addEventListener('click', async (e) => {
            e.preventDefault();
            const id = bookmarkBtn.dataset.id;
            
            bookmarkBtn.disabled = true; // Prevent double clicks
            
            try {
                const response = await fetch(`${config.baseUrl}/api/bookmark/toggle/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': config.csrf
                    }
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const result = await response.json();
                
                if (result.status === 'success') {
                    const icon = bookmarkBtn.querySelector('i');
                    if (result.action === 'added') {
                        icon.classList.replace('fa-regular', 'fa-solid');
                        bookmarkBtn.classList.replace('btn-outline-primary', 'btn-primary');
                        bookmarkBtn.innerHTML = '<i class="fa-solid fa-bookmark me-2"></i> Tersimpan';
                        showToast(result.message, 'success');
                    } else {
                        icon.classList.replace('fa-solid', 'fa-regular');
                        bookmarkBtn.classList.replace('btn-primary', 'btn-outline-primary');
                        bookmarkBtn.innerHTML = '<i class="fa-regular fa-bookmark me-2"></i> Simpan';
                        showToast(result.message, 'info');
                    }
                } else {
                    showToast(result.message || 'Terjadi kesalahan.', 'error');
                }
            } catch (err) {
                console.error('Bookmark error:', err);
                showToast('Gagal memproses bookmark. Periksa koneksi Anda.', 'error');
            } finally {
                bookmarkBtn.disabled = false;
            }
        });
    }

    // 4. LIVE SEARCH (with Debounce & Error Handling)
    const searchInput = document.getElementById('live-search-input');
    const searchResults = document.getElementById('search-results-container');
    
    if (searchInput && searchResults) {
        let debounceTimeout = null;
        searchInput.addEventListener('input', (e) => {
            clearTimeout(debounceTimeout);
            const q = e.target.value.trim();
            
            if (q.length === 0) {
                // Optionally clear or show default
                return;
            }

            debounceTimeout = setTimeout(async () => {
                if (q.length < 2) return;

                try {
                    const response = await fetch(`${config.baseUrl}/search?q=${encodeURIComponent(q)}`, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    
                    if (!response.ok) throw new Error('Search failed');
                    
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
                } catch (err) {
                    console.error('Search error:', err);
                    // Don't show toast for live search to avoid annoyance, just log
                }
            }, 500); // Debounce 500ms
        });
    }

    // Theme Toggle Logic (Preserved)
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
        const html = document.documentElement;
        const themeIcon = themeToggle.querySelector('i');

        const updateIcon = (theme) => {
            if (themeIcon) {
                if (theme === 'dark') {
                    themeIcon.classList.replace('fa-moon', 'fa-sun');
                } else {
                    themeIcon.classList.replace('fa-sun', 'fa-moon');
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

    // 5. BACK TO TOP BUTTON
    const backToTop = document.getElementById('backToTop');
    if (backToTop) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });

        backToTop.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
});
