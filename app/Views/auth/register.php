<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="py-5 min-vh-100 d-flex align-items-center">
    <div class="hero-gradient"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-lg glass p-4 p-md-5 animate-fade-in">
                    <div class="text-center mb-5">
                        <h2 class="fw-bold" style="font-family: 'Outfit', sans-serif;">Daftar Peneliti</h2>
                        <p class="text-muted">Bergabunglah dengan komunitas peneliti Akademika</p>
                    </div>

                    <form action="<?= base_url('register') ?>" method="POST">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label small fw-bold">Username</label>
                                <div class="input-group glass border rounded-3 p-1 <?= isset(session('errors')['username']) ? 'border-danger' : '' ?>">
                                    <span class="input-group-text bg-transparent border-0"><i class="fa-solid fa-user text-muted"></i></span>
                                    <input type="text" name="username" class="form-control bg-transparent border-0" placeholder="Username" required value="<?= old('username') ?>">
                                </div>
                                <?php if(isset(session('errors')['username'])): ?>
                                    <div class="text-danger small mt-1"><?= session('errors')['username'] ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <label class="form-label small fw-bold">Email</label>
                                <div class="input-group glass border rounded-3 p-1 <?= isset(session('errors')['email']) ? 'border-danger' : '' ?>">
                                    <span class="input-group-text bg-transparent border-0"><i class="fa-solid fa-envelope text-muted"></i></span>
                                    <input type="email" name="email" class="form-control bg-transparent border-0" placeholder="Email" required value="<?= old('email') ?>">
                                </div>
                                <?php if(isset(session('errors')['email'])): ?>
                                    <div class="text-danger small mt-1"><?= session('errors')['email'] ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">Password</label>
                            <div class="input-group glass border rounded-3 p-1 <?= isset(session('errors')['password']) ? 'border-danger' : '' ?>">
                                <span class="input-group-text bg-transparent border-0"><i class="fa-solid fa-lock text-muted"></i></span>
                                <input type="password" name="password" class="form-control bg-transparent border-0" placeholder="Minimal 8 karakter" required>
                            </div>
                            <?php if(isset(session('errors')['password'])): ?>
                                <div class="text-danger small mt-1"><?= session('errors')['password'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">Konfirmasi Password</label>
                            <div class="input-group glass border rounded-3 p-1 <?= isset(session('errors')['password_confirm']) ? 'border-danger' : '' ?>">
                                <span class="input-group-text bg-transparent border-0"><i class="fa-solid fa-check-double text-muted"></i></span>
                                <input type="password" name="password_confirm" class="form-control bg-transparent border-0" placeholder="Ulangi password" required>
                            </div>
                            <?php if(isset(session('errors')['password_confirm'])): ?>
                                <div class="text-danger small mt-1"><?= session('errors')['password_confirm'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label small text-muted" for="terms">
                                    Saya setuju dengan <a href="#" class="text-decoration-none">Syarat & Ketentuan</a>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold">Daftar Sekarang</button>
                    </form>
                    
                    <div class="mt-5 text-center">
                        <p class="small text-muted mb-0">Sudah punya akun? <a href="<?= base_url('login') ?>" class="fw-bold text-decoration-none">Login di sini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
