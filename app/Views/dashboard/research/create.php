<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="mb-5">
    <a href="<?= base_url('dashboard/research') ?>" class="btn btn-link text-decoration-none p-0 mb-3">
        <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Daftar
    </a>
    <h2 class="fw-bold" style="font-family: 'Outfit', sans-serif;">Buat Penelitian Baru</h2>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm p-4 p-md-5">
            <form action="<?= base_url('dashboard/research/store') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="mb-4">
                    <label class="form-label fw-bold">Judul Penelitian</label>
                    <input type="text" name="title" class="form-control rounded-3 py-2" placeholder="Masukkan judul penelitian" required value="<?= old('title') ?>">
                    <?php if(isset(session('errors')['title'])): ?>
                        <div class="text-danger small mt-1"><?= session('errors')['title'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Kategori</label>
                        <select name="category_id" class="form-select rounded-3 py-2" required>
                            <option value="">Pilih Kategori</option>
                            <?php foreach($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= old('category_id') == $cat['id'] ? 'selected' : '' ?>><?= $cat['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tipe Konten</label>
                        <select name="type" class="form-select rounded-3 py-2">
                            <option value="simple" <?= old('type') == 'simple' ? 'selected' : '' ?>>Simple (Teks & Gambar)</option>
                            <option value="full" <?= old('type') == 'full' ? 'selected' : '' ?>>Full (Eksperimen Interaktif)</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Abstrak / Ringkasan</label>
                    <textarea name="abstract" class="form-control rounded-3" rows="4" placeholder="Tuliskan ringkasan singkat penelitian Anda..." required><?= old('abstract') ?></textarea>
                    <?php if(isset(session('errors')['abstract'])): ?>
                        <div class="text-danger small mt-1"><?= session('errors')['abstract'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-5">
                    <label class="form-label fw-bold">Cover Image</label>
                    <div class="input-group">
                        <input type="file" name="cover_image" class="form-control rounded-3 py-2" required>
                    </div>
                    <div class="form-text">Format: JPG, PNG. Max: 2MB. Dimensi ideal: 1200x600px.</div>
                    <?php if(isset(session('errors')['cover_image'])): ?>
                        <div class="text-danger small mt-1"><?= session('errors')['cover_image'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-primary rounded-pill px-5">Simpan & Lanjut</button>
                    <a href="<?= base_url('dashboard/research') ?>" class="btn btn-light rounded-pill px-5">Batal</a>
                </div>
            </form>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm glass p-4">
            <h5 class="fw-bold mb-3"><i class="fa-solid fa-info-circle me-2 text-primary"></i> Tips Menulis</h5>
            <ul class="small text-muted ps-3">
                <li class="mb-2">Gunakan judul yang menarik dan deskriptif.</li>
                <li class="mb-2">Abstrak sebaiknya menjelaskan latar belakang dan tujuan utama.</li>
                <li class="mb-2">Pilih gambar cover berkualitas tinggi untuk menarik pembaca.</li>
                <li>Setelah menyimpan, Anda dapat menambahkan bagian-bagian (sections) untuk isi penelitian.</li>
            </ul>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
