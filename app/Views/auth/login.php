<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="py-5 min-vh-100 d-flex align-items-center">
    <div class="hero-gradient"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card border-0 shadow-lg glass p-4 p-md-5 animate-fade-in">
                    <div class="text-center mb-5">
                        <h2 class="fw-bold" style="font-family: 'Outfit', sans-serif;">Selamat Datang</h2>
                        <p class="text-muted">Masuk ke akun Akademika Anda</p>
                    </div>

                    <?php if(session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger border-0 small py-2"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <form action="<?= base_url('login') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Username</label>
                            <div class="input-group glass border rounded-3 p-1">
                                <span class="input-group-text bg-transparent border-0"><i class="fa-solid fa-user text-muted"></i></span>
                                <input type="text" name="username" class="form-control bg-transparent border-0" placeholder="Masukkan username" required value="<?= old('username') ?>">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Password</label>
                            <div class="input-group glass border rounded-3 p-1">
                                <span class="input-group-text bg-transparent border-0"><i class="fa-solid fa-lock text-muted"></i></span>
                                <input type="password" name="password" class="form-control bg-transparent border-0" placeholder="Masukkan password" required>
                            </div>
                        </div>
                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember">
                                <label class="form-check-label small text-muted" for="remember">Ingat saya</label>
                            </div>
                            <a href="#" class="small text-decoration-none">Lupa password?</a>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold">Masuk Sekarang</button>
                    </form>
                    
                    <div class="mt-5 text-center">
                        <p class="small text-muted mb-0">Belum punya akun? <a href="<?= base_url('register') ?>" class="fw-bold text-decoration-none">Daftar sebagai Peneliti</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
