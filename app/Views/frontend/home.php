<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section class="hero-section text-center">
    <div class="hero-gradient"></div>
    <div class="container animate-fade-in">
        <h1 class="display-3 fw-bold mb-4" style="font-family: 'Outfit', sans-serif;">Pusat Pengetahuan <span class="text-primary">Masa Depan</span></h1>
        <p class="lead text-muted mb-5 mx-auto" style="max-width: 700px;">Jelajahi, pelajari, dan berkontribusi dalam dunia ilmu pengetahuan melalui platform penelitian yang interaktif dan modern.</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="<?= base_url('search') ?>" class="btn btn-primary btn-lg rounded-pill px-5 shadow-lg">Jelajahi Penelitian</a>
            <a href="<?= base_url('register') ?>" class="btn btn-outline-primary btn-lg rounded-pill px-5">Mulai Meneliti</a>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="section-py">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-6 col-md-3">
                <div class="p-4 rounded-4 stats-card">
                    <i class="fa-solid fa-book-open text-primary stats-icon" style="color: var(--bs-primary) !important;"></i>
                    <h2 class="fw-bold text-main mb-0"><span class="text-primary"><?= number_format($stats['research']) ?></span></h2>
                    <p class="text-muted extra-small mb-0">Penelitian</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-4 rounded-4 stats-card">
                    <i class="fa-solid fa-users text-primary stats-icon" style="color: var(--bs-primary) !important;"></i>
                    <h2 class="fw-bold text-main mb-0"><span class="text-primary"><?= number_format($stats['views']) ?></span></h2>
                    <p class="text-muted extra-small mb-0">Pembaca</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-4 rounded-4 stats-card">
                    <i class="fa-solid fa-layer-group text-primary stats-icon"></i>
                    <h2 class="fw-bold text-main mb-0"><span class="text-primary"><?= number_format($stats['categories']) ?></span></h2>
                    <p class="text-muted extra-small mb-0">Kategori</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-4 rounded-4 stats-card">
                    <i class="fa-solid fa-user-graduate text-primary stats-icon"></i>
                    <h2 class="fw-bold text-main mb-0"><span class="text-primary"><?= number_format($stats['researchers']) ?></span></h2>
                    <p class="text-muted extra-small mb-0">Peneliti</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Latest Research -->
<section class="section-py bg-alt">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <h2 class="fw-bold h1" style="font-family: 'Outfit', sans-serif;">Penelitian Terbaru</h2>
                <p class="text-muted mb-0">Update terbaru dari para peneliti kami.</p>
            </div>
            <a href="<?= base_url('search') ?>" class="btn btn-link text-decoration-none fw-bold">Lihat Semua <i class="fa-solid fa-arrow-right ms-2"></i></a>
        </div>
        
        <div class="row g-4">
            <?php if(empty($latest)): ?>
                <div class="col-12 text-center py-5">
                    <img src="<?= base_url('img/logonotfound.png') ?>" alt="Not found" style="height: 120px;" class="mb-3 opacity-50">
                    <p class="text-muted">Belum ada penelitian terbaru.</p>
                </div>
            <?php else: ?>
                <?php foreach($latest as $index => $item): ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0 animate-fade-in <?= $index === 0 ? 'featured-card' : '' ?>">
                        <div class="overflow-hidden">
                            <img src="<?= base_url('uploads/research/' . ($item['cover_image'] ?? 'default.jpg')) ?>" class="card-img-top" alt="<?= esc($item['title']) ?>" style="height: 200px; object-fit: cover;">
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <span class="badge badge-primary-modern rounded-pill small"><?= esc($item['category_name'] ?? 'General') ?></span>
                                <?php if($index === 0): ?>
                                    <span class="ms-1 badge bg-warning text-dark rounded-pill extra-small"><i class="fa-solid fa-star me-1"></i> Utama</span>
                                <?php endif; ?>
                            </div>
                            <h5 class="card-title fw-bold mb-3">
                                <a href="<?= base_url('research/' . esc($item['slug'])) ?>" class="text-decoration-none text-main"><?= esc($item['title']) ?></a>
                            </h5>
                            <p class="card-text text-muted small mb-4"><?= esc(character_limiter($item['abstract'], 120)) ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-eye text-muted small"></i>
                                    <span class="text-muted extra-small"><?= esc($item['views']) ?> views</span>
                                </div>
                                <span class="text-muted extra-small"><?= date('d M Y', strtotime($item['created_at'])) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Popular Section -->
<section class="section-py">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-md-6">
                <h2 class="fw-bold h1" style="font-family: 'Outfit', sans-serif;">Paling Populer</h2>
                <p class="text-muted">Karya yang paling banyak menarik perhatian pembaca.</p>
            </div>
        </div>
        
        <div class="row g-4">
            <?php if(empty($popular)): ?>
                <div class="col-12 text-center py-5">
                    <img src="<?= base_url('img/logonotfound.png') ?>" alt="Not found" style="height: 120px;" class="mb-3 opacity-50">
                    <p class="text-muted">Belum ada penelitian populer.</p>
                </div>
            <?php else: ?>
                <?php foreach($popular as $item): ?>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm overflow-hidden h-100 animate-fade-in">
                        <div class="row g-0 h-100">
                            <div class="col-sm-4 overflow-hidden">
                                <img src="<?= base_url('uploads/research/' . ($item['cover_image'] ?? 'default.jpg')) ?>" class="card-img-top h-100 w-100" style="object-fit: cover; min-height: 150px;" alt="<?= esc($item['title']) ?>">
                            </div>
                            <div class="col-sm-8">
                                <div class="card-body p-4 h-100 d-flex flex-column justify-content-center">
                                    <div class="mb-2">
                                        <span class="badge badge-primary-modern rounded-pill extra-small"><?= esc($item['category_name'] ?? 'General') ?></span>
                                    </div>
                                    <h5 class="fw-bold mb-2">
                                        <a href="<?= base_url('research/' . esc($item['slug'])) ?>" class="text-decoration-none text-main"><?= esc($item['title']) ?></a>
                                    </h5>
                                    <p class="text-muted small mb-0"><?= esc(character_limiter($item['abstract'], 100)) ?></p>
                                    <div class="mt-3 d-flex align-items-center gap-3">
                                        <span class="text-muted extra-small"><i class="fa-solid fa-eye me-1"></i> <?= esc($item['views']) ?></span>
                                        <span class="text-muted extra-small"><i class="fa-solid fa-calendar me-1"></i> <?= date('d M Y', strtotime($item['created_at'])) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
