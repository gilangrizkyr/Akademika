<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Hero Detail -->
<section class="py-5 position-relative overflow-hidden">
    <div class="container animate-fade-in">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail Penelitian</li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bold mb-4" style="font-family: 'Outfit', sans-serif;"><?= esc($research['title']) ?></h1>
                <p class="lead text-muted mb-4"><?= $research['abstract'] ?></p>
                <div class="d-flex align-items-center gap-3 mb-5">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div>
                        <div class="fw-bold">Peneliti Akademika</div>
                        <div class="text-muted small">Dipublikasi pada <?= date('d M Y', strtotime($research['created_at'])) ?></div>
                    </div>
                </div>
                <div class="d-flex gap-3">
                    <button class="btn btn-primary rounded-pill px-4"><i class="fa-solid fa-bookmark me-2"></i> Simpan</button>
                    <button class="btn btn-outline-primary rounded-pill px-4"><i class="fa-solid fa-share-nodes me-2"></i> Bagikan</button>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="<?= base_url('uploads/research/' . ($research['cover_image'] ?? 'default.jpg')) ?>" class="img-fluid rounded-4 shadow-lg w-100" style="max-height: 500px; object-fit: cover;" alt="<?= esc($research['title']) ?>">
            </div>
        </div>
    </div>
</section>

<!-- Content Sections -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <?php foreach($sections as $index => $section): ?>
                <div id="section-<?= $section['id'] ?>" class="mb-5 animate-fade-in" style="animation-delay: <?= $index * 0.1 ?>s;">
                    <h2 class="fw-bold mb-4" style="font-family: 'Outfit', sans-serif;"><?= esc($section['title']) ?></h2>
                    <div class="section-content text-main mb-4">
                        <?= $section['content'] ?>
                    </div>
                    
                    <?php if($section['image']): ?>
                    <div class="mb-4">
                        <img src="<?= base_url('uploads/research/' . esc($section['image'])) ?>" class="img-fluid rounded-4 shadow-sm w-100" alt="<?= esc($section['title']) ?>">
                    </div>
                    <?php endif; ?>

                    <?php if($section['youtube_url']): ?>
                    <div class="mb-4 ratio ratio-16x9">
                        <iframe src="<?= $section['youtube_url'] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen class="rounded-4 shadow-sm"></iframe>
                    </div>
                    <?php endif; ?>
                    
                    <hr class="my-5 opacity-10">
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Sticky Sidebar Nav -->
            <div class="col-lg-4 d-none d-lg-block">
                <div class="sticky-sidebar">
                    <div class="card border-0 shadow-sm glass p-4">
                        <h5 class="fw-bold mb-4">Daftar Isi</h5>
                        <ul class="nav flex-column gap-2">
                            <?php foreach($sections as $section): ?>
                            <li class="nav-item">
                                <a class="nav-link p-0 text-muted" href="#section-<?= $section['id'] ?>">
                                    <i class="fa-solid fa-chevron-right me-2 small text-primary"></i> <?= esc($section['title']) ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Smooth Scroll for sidebar
    document.querySelectorAll('.sticky-sidebar a').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
</script>

<?= $this->endSection() ?>
