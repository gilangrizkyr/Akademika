<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Akademika - Portal Penelitian Ilmiah') ?></title>
    <meta name="description" content="<?= esc($meta_description ?? get_setting('site_description', 'Platform portal penelitian dan edukasi ilmiah modern.')) ?>">
    <meta name="keywords" content="penelitian, jurnal, ilmiah, akademika, riset, publikasi">
    <meta name="author" content="Akademika Team">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= current_url() ?>">
    <meta property="og:title" content="<?= esc($title ?? 'Akademika') ?>">
    <meta property="og:description" content="<?= esc($meta_description ?? 'Platform portal penelitian modern.') ?>">
    <meta property="og:image" content="<?= esc($meta_image ?? base_url('img/og-image.jpg')) ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?= current_url() ?>">
    <meta property="twitter:title" content="<?= esc($title ?? 'Akademika') ?>">
    <meta property="twitter:description" content="<?= esc($meta_description ?? 'Platform portal penelitian modern.') ?>">
    <meta property="twitter:image" content="<?= esc($meta_image ?? base_url('img/og-image.jpg')) ?>">

    <!-- Structured Data -->
    <?php if(isset($schema)): ?>
    <script type="application/ld+json">
        <?= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) ?>
    </script>
    <?php endif; ?>

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
    
    <meta name="X-CSRF-TOKEN" content="<?= csrf_hash() ?>">
    <meta name="base-url" content="<?= base_url() ?>">
</head>
<body>

    <!-- Navbar -->
    <?php 
        $current_url = rtrim(current_url(), '/');
        $base_url = rtrim(base_url(), '/');
    ?>
    <nav class="navbar navbar-expand-lg fixed-top shadow-none">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="<?= base_url() ?>" style="font-family: 'Outfit', sans-serif;">
                <div class="bg-primary rounded-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                    <i class="fa-solid fa-graduation-cap text-white fs-6"></i>
                </div>
                <span class="fs-4 tracking-tight"><?= esc(get_setting('site_name', 'Akademika')) ?></span>
            </a>
            
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto gap-2">
                    <li class="nav-item">
                        <a class="nav-link <?= $current_url == $base_url ? 'active' : '' ?>" href="<?= base_url() ?>">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= str_contains($current_url, 'search') ? 'active' : '' ?>" href="<?= base_url('search') ?>">Eksplorasi</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Kategori</a>
                        <ul class="dropdown-menu border-0 shadow-lg rounded-4 p-2 mt-2">
                            <?php 
                            $db = \Config\Database::connect();
                            $categories = $db->table('categories')->limit(5)->get()->getResultArray();
                            foreach($categories as $cat):
                            ?>
                            <li><a class="dropdown-item rounded-3" href="<?= base_url('search?q=' . $cat['name']) ?>"><?= esc($cat['name']) ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center gap-2">
                    <!-- Theme Toggle -->
                    <div id="themeToggle" class="me-2" title="Ganti Tema">
                        <i class="fa-solid fa-moon"></i>
                    </div>

                    <?php if(session()->get('isLoggedIn')): ?>
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center gap-2 text-decoration-none" data-bs-toggle="dropdown">
                                <img src="https://ui-avatars.com/api/?name=<?= session()->get('username') ?>&background=random" class="avatar-sm" alt="Avatar">
                                <div class="d-none d-sm-block">
                                    <div class="fw-bold text-main small" style="line-height: 1;"><?= session()->get('username') ?></div>
                                    <div class="text-muted extra-small"><?= ucfirst(session()->get('role')) ?></div>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 p-2 mt-3">
                                <li><a class="dropdown-item rounded-3" href="<?= base_url('dashboard') ?>"><i class="fa-solid fa-gauge-high me-2"></i> Dashboard</a></li>
                                <li><a class="dropdown-item rounded-3" href="<?= base_url('dashboard/research/create') ?>"><i class="fa-solid fa-plus me-2"></i> Tulis Penelitian</a></li>
                                <li><hr class="dropdown-divider opacity-10"></li>
                                <li><a class="dropdown-item rounded-3 text-danger" href="<?= base_url('logout') ?>"><i class="fa-solid fa-right-from-bracket me-2"></i> Keluar</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="<?= base_url('login') ?>" class="btn btn-link text-decoration-none text-main fw-bold">Masuk</a>
                        <a href="<?= base_url('register') ?>" class="btn btn-primary rounded-pill px-4 shadow-sm">Daftar</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main style="margin-top: 100px; min-height: 80vh;">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-5 mb-5">
                <div class="col-lg-4">
                    <a class="navbar-brand fw-bold d-flex align-items-center gap-2 mb-4" href="<?= base_url() ?>" style="font-family: 'Outfit', sans-serif;">
                        <div class="bg-primary rounded-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                            <i class="fa-solid fa-graduation-cap text-white fs-6"></i>
                        </div>
                        <span class="fs-4 tracking-tight"><?= esc(get_setting('site_name', 'Akademika')) ?></span>
                    </a>
                    <p class="text-muted mb-4 pe-lg-5"><?= esc(get_setting('site_description', 'Platform publikasi karya ilmiah dan penelitian modern.')) ?></p>
                    <div class="d-flex gap-3">
                        <a href="<?= esc(get_setting('twitter', '#')) ?>" class="social-icon"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="<?= esc(get_setting('linkedin', '#')) ?>" class="social-icon"><i class="fa-brands fa-linkedin"></i></a>
                        <a href="<?= esc(get_setting('instagram', '#')) ?>" class="social-icon"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-6 col-lg-2">
                    <h6 class="fw-bold mb-4">Navigasi</h6>
                    <a href="<?= base_url() ?>" class="footer-link">Beranda</a>
                    <a href="<?= base_url('search') ?>" class="footer-link">Eksplorasi</a>
                    <a href="<?= base_url('register') ?>" class="footer-link">Mulai Meneliti</a>
                    <a href="<?= base_url('dashboard') ?>" class="footer-link">Panel Admin</a>
                </div>
                <div class="col-6 col-lg-2">
                    <h6 class="fw-bold mb-4">Pusat Bantuan</h6>
                    <a href="#" class="footer-link">Tentang Akademika</a>
                    <a href="#" class="footer-link">Syarat & Ketentuan</a>
                    <a href="#" class="footer-link">Kebijakan Privasi</a>
                    <a href="#" class="footer-link">Kontak Kami</a>
                </div>
                <div class="col-lg-4">
                    <h6 class="fw-bold mb-4">Hubungi Kami</h6>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <div class="extra-small text-muted">Email Support</div>
                            <div class="fw-bold small"><?= esc(get_setting('contact_email', 'support@akademika.id')) ?></div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <div class="extra-small text-muted">WhatsApp Hotline</div>
                            <div class="fw-bold small"><?= esc(get_setting('contact_phone', '+62 812-3456-7890')) ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pt-4 border-top border-opacity-10 text-center text-md-start">
                <p class="text-muted small mb-0">&copy; <?= date('Y') ?> <?= esc(get_setting('footer_copyright', 'Akademika Research. All rights reserved.')) ?></p>
            </div>
        </div>
    </footer>

    <!-- Back to Top -->
    <button id="backToTop" title="Kembali ke Atas">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

    <div id="toast-container" class="toast-container"></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar Scroll Effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
    <script src="<?= base_url('js/app.js') ?>"></script>
</body>
</html>
