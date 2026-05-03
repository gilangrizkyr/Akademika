<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="mb-5">
    <a href="<?= base_url('dashboard/research') ?>" class="btn btn-link text-decoration-none p-0 mb-3">
        <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Daftar
    </a>
    <h2 class="fw-bold" style="font-family: 'Outfit', sans-serif;">Edit Detail Penelitian</h2>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm p-4 p-md-5">
            <form action="<?= base_url('dashboard/research/update/' . $research['id']) ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="mb-4">
                    <label class="form-label fw-bold">Judul Penelitian</label>
                    <input type="text" name="title" class="form-control rounded-3 py-2" required value="<?= esc(old('title', $research['title'])) ?>">
                    <?php if(isset(session('errors')['title'])): ?>
                        <div class="text-danger small mt-1"><?= session('errors')['title'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Kategori</label>
                        <select name="category_id" class="form-select rounded-3 py-2" required>
                            <?php foreach($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= (old('category_id', $research['category_id']) == $cat['id']) ? 'selected' : '' ?>><?= esc($cat['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tipe Konten</label>
                        <select name="type" class="form-select rounded-3 py-2">
                            <option value="simple" <?= (old('type', $research['type']) == 'simple') ? 'selected' : '' ?>>Simple</option>
                            <option value="full" <?= (old('type', $research['type']) == 'full') ? 'selected' : '' ?>>Full</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Abstrak / Ringkasan</label>
                    <textarea name="abstract" class="form-control rounded-3" rows="4" required><?= old('abstract', $research['abstract']) ?></textarea>
                </div>

                <div class="mb-5">
                    <label class="form-label fw-bold">Ganti Cover Image (Opsional)</label>
                    <div class="mb-3">
                        <img src="<?= base_url('uploads/research/' . ($research['cover_image'] ?? 'default.jpg')) ?>" class="rounded-3 shadow-sm" style="height: 120px; width: 240px; object-fit: cover;">
                    </div>
                    <input type="file" name="cover_image" class="form-control rounded-3 py-2">
                    <div class="form-text small">Biarkan kosong jika tidak ingin mengubah cover.</div>
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-primary rounded-pill px-5">Simpan Perubahan</button>
                    <a href="<?= base_url('dashboard/research') ?>" class="btn btn-light rounded-pill px-5">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
