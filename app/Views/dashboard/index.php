<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="mb-5">
    <h2 class="fw-bold" style="font-family: 'Outfit', sans-serif;">Ringkasan Dashboard</h2>
    <p class="text-muted">Selamat datang kembali, <?= session()->get('username') ?>. Berikut adalah statistik Anda hari ini.</p>
</div>

<div class="row g-4 mb-5">
    <?php if(session()->get('role') === 'superadmin' || session()->get('role') === 'admin'): ?>
        <div class="col-md-4">
            <div class="card p-4 border-0 shadow-sm glass">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-4 bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="fa-solid fa-microscope fs-3"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0"><?= $total_research ?></h4>
                        <p class="text-muted mb-0">Total Penelitian</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 border-0 shadow-sm glass">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-4 bg-warning-subtle text-warning d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="fa-solid fa-clock fs-3"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0"><?= $pending_research ?></h4>
                        <p class="text-muted mb-0">Perlu Moderasi</p>
                    </div>
                </div>
            </div>
        </div>
        <?php if(session()->get('role') === 'superadmin'): ?>
        <div class="col-md-4">
            <div class="card p-4 border-0 shadow-sm glass">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-4 bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="fa-solid fa-users fs-3"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0"><?= $total_users ?></h4>
                        <p class="text-muted mb-0">Total Pengguna</p>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="col-md-6">
            <div class="card p-4 border-0 shadow-sm glass">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-4 bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="fa-solid fa-file-invoice fs-3"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0"><?= $my_research ?></h4>
                        <p class="text-muted mb-0">Karya Saya</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-4 border-0 shadow-sm glass">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-4 bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="fa-solid fa-check-circle fs-3"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0"><?= $my_published ?></h4>
                        <p class="text-muted mb-0">Sudah Publikasi</p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm p-4">
            <h5 class="fw-bold mb-4">Aktivitas Terakhir</h5>
            <div class="text-center py-5">
                <p class="text-muted">Belum ada aktivitas baru untuk ditampilkan.</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm glass p-4 h-100">
            <h5 class="fw-bold mb-4">Informasi Akun</h5>
            <div class="mb-3">
                <label class="small text-muted d-block">Username</label>
                <span class="fw-bold"><?= session()->get('username') ?></span>
            </div>
            <div class="mb-3">
                <label class="small text-muted d-block">Role</label>
                <span class="badge bg-primary-subtle text-primary rounded-pill"><?= ucfirst(session()->get('role')) ?></span>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
