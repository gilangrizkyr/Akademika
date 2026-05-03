<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="mb-5">
    <a href="<?= base_url('dashboard/research') ?>" class="btn btn-link text-decoration-none p-0 mb-3">
        <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Penelitian
    </a>
    <h2 class="fw-bold" style="font-family: 'Outfit', sans-serif;">Kelola Konten: <?= esc(character_limiter($research['title'], 50)) ?></h2>
    <p class="text-muted">Tambahkan bagian teks, gambar, atau video untuk melengkapi publikasi Anda.</p>
</div>

<div class="row g-4">
    <!-- Form Tambah Section -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm glass p-4 sticky-sidebar" style="top: 2rem;">
            <h5 class="fw-bold mb-4">Tambah Bagian Baru</h5>
            <form action="<?= base_url('dashboard/section/store/' . $research['id']) ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Judul Bagian</label>
                    <input type="text" name="title" class="form-control rounded-3" placeholder="Contoh: Metodologi" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Konten (HTML/Rich Text)</label>
                    <textarea name="content" class="form-control rounded-3" rows="5" placeholder="Tuliskan isi bagian ini..." required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Gambar (Opsional)</label>
                    <input type="file" name="image" class="form-control rounded-3">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">YouTube URL (Opsional)</label>
                    <input type="url" name="youtube_url" class="form-control rounded-3" placeholder="https://youtube.com/watch?v=...">
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-bold">Urutan</label>
                    <input type="number" name="sort_order" class="form-control rounded-3" value="0">
                </div>
                <button type="submit" class="btn btn-primary w-100 rounded-pill">Tambah Bagian</button>
            </form>
        </div>
    </div>

    <!-- Daftar Section -->
    <div class="col-lg-8">
        <?php if(count($sections) > 0): ?>
            <div class="d-flex flex-column gap-4">
                <?php foreach($sections as $section): ?>
                <div class="card border-0 shadow-sm p-4 animate-fade-in">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-primary rounded-pill px-2"><?= esc($section['sort_order']) ?></span>
                            <h5 class="fw-bold mb-0"><?= esc($section['title']) ?></h5>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#editModal<?= esc($section['id']) ?>">Edit</button>
                            <a href="<?= base_url('dashboard/section/delete/' . $section['id']) ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Hapus bagian ini?')">Hapus</a>
                        </div>
                    </div>
                    <div class="text-muted mb-3"><?= character_limiter(strip_tags($section['content']), 200) ?></div>
                    <div class="d-flex gap-3">
                        <?php if($section['image']): ?>
                            <span class="badge bg-secondary-subtle text-secondary rounded-pill"><i class="fa-solid fa-image me-1"></i> Gambar Aktif</span>
                        <?php endif; ?>
                        <?php if($section['youtube_url']): ?>
                            <span class="badge bg-danger-subtle text-danger rounded-pill"><i class="fa-solid fa-video me-1"></i> Video Aktif</span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal<?= esc($section['id']) ?>" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content border-0 shadow rounded-4 p-3">
                            <div class="modal-header border-0">
                                <h5 class="modal-title fw-bold">Edit Bagian</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="<?= base_url('dashboard/section/update/' . $section['id']) ?>" method="POST" enctype="multipart/form-data">
                                <?= csrf_field() ?>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Judul Bagian</label>
                                        <input type="text" name="title" class="form-control rounded-3" value="<?= esc($section['title']) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Konten</label>
                                        <textarea name="content" class="form-control rounded-3" rows="8" required><?= $section['content'] ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Ganti Gambar (Opsional)</label>
                                        <input type="file" name="image" class="form-control rounded-3">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">YouTube URL (Opsional)</label>
                                        <input type="url" name="youtube_url" class="form-control rounded-3" value="<?= esc($section['youtube_url']) ?>">
                                    </div>
                                    <div class="mb-0">
                                        <label class="form-label small fw-bold">Urutan</label>
                                        <input type="number" name="sort_order" class="form-control rounded-3" value="<?= esc($section['sort_order']) ?>">
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="card border-0 shadow-sm p-5 text-center">
                <img src="https://illustrations.popsy.co/blue/work-from-home.svg" alt="Empty" style="height: 200px;" class="mb-4">
                <h4 class="fw-bold">Belum ada konten</h4>
                <p class="text-muted">Gunakan form di samping untuk menambahkan bagian pertama pada penelitian Anda.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
