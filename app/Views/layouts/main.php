<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Akademika - Portal Penelitian Ilmiah') ?></title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= base_url() ?>" style="font-family: 'Outfit', sans-serif; font-size: 1.5rem;">
                <span class="text-primary">Akade</span>mika
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('search') ?>">Penelitian</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <button id="themeToggle" class="btn btn-link text-decoration-none text-main p-0">
                        <i class="fa-solid fa-moon fs-5"></i>
                    </button>
                    <?php if(session()->get('isLoggedIn')): ?>
                        <div class="dropdown">
                            <a class="btn btn-outline-primary dropdown-toggle rounded-pill" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-user-circle me-1"></i> <?= esc(session()->get('username')) ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                                <li><a class="dropdown-item" href="<?= base_url('dashboard') ?>"><i class="fa-solid fa-gauge me-2"></i> Dashboard</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>"><i class="fa-solid fa-sign-out-alt me-2"></i> Logout</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="<?= base_url('login') ?>" class="btn btn-outline-primary rounded-pill px-4">Login</a>
                        <a href="<?= base_url('login') ?>" class="btn btn-primary rounded-pill px-4">Mulai Meneliti</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main style="margin-top: 5rem;">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <footer class="py-5 mt-5 border-top bg-card">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">Akademika</h5>
                    <p class="text-muted">Platform portal penelitian dan edukasi ilmiah modern untuk mempublikasikan karya terbaik Anda.</p>
                </div>
                <div class="col-md-2 mb-4">
                    <h6 class="fw-bold mb-3">Navigasi</h6>
                    <ul class="list-unstyled text-muted">
                        <li><a href="<?= base_url() ?>" class="text-decoration-none text-muted">Beranda</a></li>
                        <li><a href="<?= base_url('search') ?>" class="text-decoration-none text-muted">Penelitian</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h6 class="fw-bold mb-3">Kontak</h6>
                    <ul class="list-unstyled text-muted">
                        <li>info@akademika.id</li>
                        <li>+62 812-3456-7890</li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4 text-md-end">
                    <h6 class="fw-bold mb-3">Ikuti Kami</h6>
                    <div class="d-flex justify-content-md-end gap-3">
                        <a href="#" class="text-primary fs-5"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#" class="text-primary fs-5"><i class="fa-brands fa-linkedin"></i></a>
                        <a href="#" class="text-primary fs-5"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4 opacity-10">
            <div class="text-center text-muted small">
                &copy; <?= date('Y') ?> Akademika Portal. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Theme Toggle Logic
        const themeToggle = document.getElementById('themeToggle');
        const html = document.documentElement;
        const icon = themeToggle.querySelector('i');

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

        function updateIcon(theme) {
            if (theme === 'dark') {
                icon.classList.replace('fa-moon', 'fa-sun');
            } else {
                icon.classList.replace('fa-sun', 'fa-moon');
            }
        }
    </script>
</body>
</html>
