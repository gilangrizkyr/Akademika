<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Header Detail -->
<section id="research-detail-id" data-id="<?= $research['id'] ?>" class="pt-6 pb-5 bg-alt">
    <div class="container animate-fade-in">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none">Beranda</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('search') ?>" class="text-decoration-none">Eksplorasi</a></li>
                <li class="breadcrumb-item active text-truncate" style="max-width: 250px;" aria-current="page"><?= esc($research['title']) ?></li>
            </ol>
        </nav>
        
        <div class="row g-4 align-items-end">
            <div class="col-lg-8">
                <span class="badge badge-primary-modern rounded-pill mb-3"><?= esc($research['category_name'] ?? 'General') ?></span>
                <h1 class="display-4 fw-bold mb-4 tracking-tight" style="font-family: 'Outfit', sans-serif; line-height: 1.2;"><?= esc($research['title']) ?></h1>
                
                <div class="d-flex align-items-center gap-4 py-2">
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name=Peneliti+Akademika&background=random" class="avatar-sm rounded-circle" alt="Author">
                        <div>
                            <div class="fw-bold text-main small">Peneliti Akademika</div>
                            <div class="text-muted extra-small"><?= date('d M Y', strtotime($research['created_at'])) ?></div>
                        </div>
                    </div>
                    <div class="vr opacity-10 d-none d-sm-block"></div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-eye text-muted small"></i>
                        <span class="text-muted small"><?= number_format($research['views']) ?> Views</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="d-flex gap-2 justify-content-lg-end mb-2">
                    <?php if($isBookmarked): ?>
                        <button id="bookmark-toggle-btn" data-id="<?= $research['id'] ?>" class="btn btn-primary rounded-pill px-4 shadow-sm"><i class="fa-solid fa-bookmark me-2"></i> Tersimpan</button>
                    <?php else: ?>
                        <button id="bookmark-toggle-btn" data-id="<?= $research['id'] ?>" class="btn btn-outline-primary rounded-pill px-4"><i class="fa-regular fa-bookmark me-2"></i> Simpan</button>
                    <?php endif; ?>
                    <button class="btn btn-outline-primary rounded-pill px-4"><i class="fa-solid fa-share-nodes me-2"></i> Bagikan</button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Content Detail -->
<section class="py-6">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <!-- Cover Image -->
                <div class="mb-5">
                    <img src="<?= base_url('uploads/research/' . ($research['cover_image'] ?? 'default.jpg')) ?>" 
                         class="img-fluid rounded-5 shadow-sm w-100" 
                         style="max-height: 500px; object-fit: cover;" 
                         alt="<?= esc($research['title']) ?>"
                         loading="lazy">
                </div>

                <!-- Abstract -->
                <div class="mb-5 p-4 rounded-4 glass border-primary border-opacity-10 bg-primary bg-opacity-10">
                    <h5 class="fw-bold mb-3"><i class="fa-solid fa-quote-left text-primary me-2"></i> Abstrak</h5>
                    <p class="lead text-main mb-0 fst-italic" style="line-height: 1.8; font-size: 1.15rem;">
                        <?= $research['abstract'] ?>
                    </p>
                </div>

                <!-- Sections -->
                <?php foreach($sections as $index => $section): ?>
                <div id="section-<?= $section['id'] ?>" class="mb-5 animate-fade-in" style="animation-delay: <?= $index * 0.1 ?>s;">
                    <h3 class="fw-bold mb-4 tracking-tight" style="font-family: 'Outfit', sans-serif;"><?= esc($section['title']) ?></h3>
                    
                    <div class="section-content text-main mb-4" style="font-size: 1.125rem; line-height: 1.9;">
                        <?= $section['content'] ?>
                    </div>
                    
                    <?php if($section['image']): ?>
                    <div class="mb-4 content-image-wrapper animate-fade-in">
                        <img src="<?= base_url('uploads/research/' . esc($section['image'])) ?>" 
                             class="img-fluid rounded-4 w-100" 
                             alt="<?= esc($section['title']) ?>"
                             loading="lazy">
                        <div class="p-2 text-center text-muted extra-small fst-italic"><?= esc($section['title']) ?></div>
                    </div>
                    <?php endif; ?>

                    <?php if($section['youtube_url']): ?>
                    <div class="mb-4 ratio ratio-16x9">
                        <iframe src="<?= $section['youtube_url'] ?>" 
                                title="YouTube video player" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                allowfullscreen 
                                class="rounded-4 shadow-sm"
                                loading="lazy"></iframe>
                    </div>
                    <?php endif; ?>
                    
                    <?php if($index < count($sections) - 1): ?>
                    <div class="my-5 d-flex align-items-center gap-3">
                        <hr class="flex-grow-1 opacity-5">
                        <div class="bg-primary bg-opacity-10 p-1 rounded-circle"></div>
                        <hr class="flex-grow-1 opacity-5">
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>

                <!-- Related Research -->
                <?php if(!empty($related)): ?>
                <div class="mt-6 pt-5 border-top border-opacity-5">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="bg-primary bg-opacity-10 p-2 rounded-3 text-primary">
                            <i class="fa-solid fa-lightbulb"></i>
                        </div>
                        <h4 class="fw-bold mb-0" style="font-family: 'Outfit', sans-serif;">Rekomendasi untuk Anda</h4>
                    </div>
                    <div class="row g-4">
                        <?php foreach($related as $rel): ?>
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm border-0 animate-fade-in">
                                <div class="overflow-hidden">
                                    <img src="<?= base_url('uploads/research/' . ($rel['cover_image'] ?? 'default.jpg')) ?>" class="card-img-top" alt="<?= esc($rel['title']) ?>" style="height: 150px; object-fit: cover;">
                                </div>
                                <div class="card-body p-3">
                                    <h6 class="fw-bold mb-2">
                                        <a href="<?= base_url('research/' . esc($rel['slug'])) ?>" class="text-decoration-none text-main stretched-link"><?= esc(character_limiter($rel['title'], 50)) ?></a>
                                    </h6>
                                    <div class="text-muted extra-small"><i class="fa-solid fa-eye me-1"></i> <?= $rel['views'] ?> views</div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Sticky Sidebar Nav -->
            <div class="col-lg-4 d-none d-lg-block">
                <div class="sticky-sidebar">
                    <div class="card border-0 sidebar-glass p-4 rounded-5">
                        <h6 class="fw-bold mb-4 text-muted text-uppercase small tracking-widest">Struktur Penelitian</h6>
                        <div class="nav flex-column gap-3">
                            <?php foreach($sections as $section): ?>
                            <a class="nav-link p-0 text-main fw-medium d-flex align-items-start gap-3 section-nav-link" href="#section-<?= $section['id'] ?>">
                                <span class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; min-width: 24px; font-size: 0.7rem;">
                                    <i class="fa-solid fa-check"></i>
                                </span>
                                <span><?= esc($section['title']) ?></span>
                            </a>
                            <?php endforeach; ?>
                        </div>
                        
                        <hr class="my-4 opacity-5">
                        
                        <div class="p-3 bg-primary bg-opacity-10 rounded-4 text-center">
                            <p class="small text-muted mb-3">Bagikan penelitian ini untuk mendukung penyebaran ilmu pengetahuan.</p>
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-primary btn-sm rounded-circle" style="width: 35px; height: 35px;"><i class="fa-brands fa-facebook-f"></i></button>
                                <button class="btn btn-info btn-sm rounded-circle text-white" style="width: 35px; height: 35px;"><i class="fa-brands fa-twitter"></i></button>
                                <button class="btn btn-success btn-sm rounded-circle" style="width: 35px; height: 35px;"><i class="fa-brands fa-whatsapp"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .section-nav-link {
        transition: all 0.3s ease;
        opacity: 0.7;
    }
    .section-nav-link:hover {
        opacity: 1;
        transform: translateX(5px);
    }
</style>

<script>
    // Smooth Scroll for sidebar
    document.querySelectorAll('.section-nav-link').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            const offset = 100;
            const bodyRect = document.body.getBoundingClientRect().top;
            const elementRect = target.getBoundingClientRect().top;
            const elementPosition = elementRect - bodyRect;
            const offsetPosition = elementPosition - offset;

            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        });
    });
</script>

<?= $this->endSection() ?>

