<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Dashboard - Akademika') ?></title>
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
    <style>
        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background-color: var(--bg-card);
            border-right: 1px solid var(--border-color);
            padding: 2rem 1.5rem;
            z-index: 1000;
        }
        .main-content {
            margin-left: 280px;
            padding: 2rem;
            min-height: 100vh;
        }
        .nav-link-dashboard {
            padding: 0.8rem 1rem;
            border-radius: 0.75rem;
            color: var(--text-muted);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.5rem;
            transition: all 0.2s ease;
        }
        .nav-link-dashboard:hover, .nav-link-dashboard.active {
            background-color: rgba(37, 99, 235, 0.1);
            color: var(--primary);
        }
        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s ease; }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>

    <!-- Mobile Header -->
    <header class="d-lg-none bg-card border-bottom p-3 sticky-top">
        <div class="d-flex justify-content-between align-items-center">
            <a class="fw-bold fs-4 text-decoration-none" href="<?= base_url() ?>">
                <span class="text-primary">Akade</span>mika
            </a>
            <button class="btn btn-outline-primary border-0" id="sidebarToggle">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="mb-5 px-2">
            <a class="fw-bold fs-3 text-decoration-none" href="<?= base_url() ?>">
                <span class="text-primary">Akade</span>mika
            </a>
        </div>

        <nav>
            <div class="text-uppercase small fw-bold text-muted mb-3 px-2">Main</div>
            <a href="<?= base_url('dashboard') ?>" class="nav-link-dashboard <?= (url_is('dashboard') ? 'active' : '') ?>">
                <i class="fa-solid fa-chart-line"></i> Dashboard
            </a>
            <a href="<?= base_url('dashboard/research') ?>" class="nav-link-dashboard <?= (url_is('dashboard/research*') ? 'active' : '') ?>">
                <i class="fa-solid fa-microscope"></i> Penelitian
            </a>

            <?php if(session()->get('role') === 'superadmin'): ?>
            <div class="text-uppercase small fw-bold text-muted mt-4 mb-3 px-2">Admin</div>
            <a href="<?= base_url('dashboard/users') ?>" class="nav-link-dashboard <?= (url_is('dashboard/users*') ? 'active' : '') ?>">
                <i class="fa-solid fa-users"></i> Users
            </a>
            <?php endif; ?>

            <div class="text-uppercase small fw-bold text-muted mt-4 mb-3 px-2">Account</div>
            <button id="themeToggle" class="nav-link-dashboard border-0 bg-transparent w-100 text-start">
                <i class="fa-solid fa-moon"></i> Theme Mode
            </button>
            <a href="<?= base_url('logout') ?>" class="nav-link-dashboard text-danger">
                <i class="fa-solid fa-sign-out-alt"></i> Logout
            </a>
        </nav>

        <div class="position-absolute bottom-0 start-0 w-100 p-4 border-top">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div>
                    <div class="fw-bold small"><?= esc(session()->get('username')) ?></div>
                    <div class="text-muted" style="font-size: 0.75rem;"><?= esc(ucfirst(session()->get('role'))) ?></div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container-fluid p-0">
            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i> <?= esc(session()->getFlashdata('success')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-2"></i> <?= esc(session()->getFlashdata('error')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar Toggle
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('show');
            });
        }

        // Theme Toggle Logic
        const themeToggle = document.getElementById('themeToggle');
        const html = document.documentElement;
        const themeIcon = themeToggle.querySelector('i');

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
                themeIcon.classList.replace('fa-moon', 'fa-sun');
            } else {
                themeIcon.classList.replace('fa-sun', 'fa-moon');
            }
        }
    </script>
</body>
</html>
