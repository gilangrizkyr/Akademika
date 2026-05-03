<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        <!-- Search Header -->
        <div class="mb-5 text-center">
            <h1 class="fw-bold mb-4" style="font-family: 'Outfit', sans-serif;">Jelajahi Penelitian</h1>
            <form action="<?= base_url('search') ?>" method="GET" class="mx-auto" style="max-width: 600px;">
                <div class="input-group glass rounded-pill p-1 shadow-sm">
                    <span class="input-group-text bg-transparent border-0 ps-4">
                        <i class="fa-solid fa-magnifying-glass text-muted"></i>
                    </span>
                    <input type="text" id="live-search-input" name="q" class="form-control bg-transparent border-0 py-3" placeholder="Cari judul, abstrak, atau konten..." value="<?= esc($keyword) ?>">
                    <button class="btn btn-primary rounded-pill px-4" type="submit">Cari</button>
                </div>
            </form>
            <?php if($keyword): ?>
                <p class="mt-3 text-muted">Menampilkan hasil untuk: <strong>"<?= esc($keyword) ?>"</strong></p>
            <?php endif; ?>
        </div>

        <!-- Results -->
        <div id="search-results-container" class="row g-4">
            <?php if(count($researches) > 0): ?>
                <?php foreach($researches as $item): ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0 animate-fade-in">
                        <img src="<?= base_url('uploads/research/' . ($item['cover_image'] ?? 'default.jpg')) ?>" class="card-img-top" alt="<?= esc($item['title']) ?>" style="height: 200px; object-fit: cover;">
                        <div class="card-body p-4">
                            <div class="mb-2">
                                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 small"><?= esc($item['category_name'] ?? 'General') ?></span>
                            </div>
                            <h5 class="card-title fw-bold mb-3">
                                <a href="<?= base_url('research/' . esc($item['slug'])) ?>" class="text-decoration-none text-main"><?= esc($item['title']) ?></a>
                            </h5>
                            <p class="card-text text-muted small mb-4"><?= esc(character_limiter($item['abstract'], 120)) ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small"><i class="fa-solid fa-eye me-1"></i> <?= esc($item['views']) ?></span>
                                <span class="text-muted small"><?= date('d M Y', strtotime($item['created_at'])) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <img src="<?= base_url('img/logonotfound.png') ?>" alt="Not found" style="height: 200px;" class="mb-4">
                    <h3 class="fw-bold">Tidak ada hasil ditemukan</h3>
                    <p class="text-muted">Coba kata kunci lain atau jelajahi kategori kami.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <div class="mt-5 d-flex justify-content-center">
            <?= $pager->links() ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
