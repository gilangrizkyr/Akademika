<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="mb-5">
    <h2 class="fw-bold" style="font-family: 'Outfit', sans-serif;">Pengaturan Website</h2>
    <p class="text-muted">Kelola informasi publik dan konfigurasi sistem.</p>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm p-4 p-md-5">
            <form action="<?= base_url('dashboard/settings/update') ?>" method="POST">
                <?= csrf_field() ?>
                
                <?php foreach($settings as $setting): ?>
                <div class="mb-4">
                    <label class="form-label fw-bold"><?= esc($setting['description']) ?></label>
                    <?php if(in_array($setting['key'], ['site_description'])): ?>
                        <textarea name="settings[<?= $setting['key'] ?>]" class="form-control glass border p-3" rows="3" required><?= esc($setting['value']) ?></textarea>
                    <?php else: ?>
                        <input type="text" name="settings[<?= $setting['key'] ?>]" class="form-control glass border py-3 px-3" value="<?= esc($setting['value']) ?>" required>
                    <?php endif; ?>
                    <div class="form-text small text-muted">Key: <code><?= esc($setting['key']) ?></code></div>
                </div>
                <?php endforeach; ?>

                <div class="mt-5">
                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-3 fw-bold"> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm glass p-4 mb-4">
            <h5 class="fw-bold mb-3"><i class="fa-solid fa-circle-info text-primary me-2"></i> Petunjuk</h5>
            <p class="text-muted small">Informasi yang Anda ubah di sini akan langsung berdampak pada tampilan publik website (Footer, Meta Title, dll).</p>
            <hr class="opacity-10">
            <div class="d-flex align-items-start gap-3">
                <i class="fa-solid fa-triangle-exclamation text-warning mt-1"></i>
                <p class="text-muted small mb-0">Pastikan nomor telepon dan email aktif untuk memudahkan pembaca menghubungi tim Akademika.</p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
