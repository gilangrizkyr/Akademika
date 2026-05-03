<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-5">
    <div>
        <h2 class="fw-bold" style="font-family: 'Outfit', sans-serif;">Manajemen Kategori</h2>
        <p class="text-muted mb-0">Kelola kategori penelitian untuk klasifikasi data.</p>
    </div>
    <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
        <i class="fa-solid fa-plus me-2"></i> Tambah Kategori
    </button>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 border-0">Nama Kategori</th>
                            <th class="py-3 border-0">Slug</th>
                            <th class="py-3 border-0 text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($categories as $cat): ?>
                        <tr>
                            <td class="ps-4 py-3 fw-bold text-main"><?= esc($cat['name']) ?></td>
                            <td class="py-3 text-muted"><code><?= esc($cat['slug']) ?></code></td>
                            <td class="py-3 text-end pe-4">
                                <button class="btn btn-link text-muted p-0 me-3" data-bs-toggle="modal" data-bs-target="#editCategoryModal<?= $cat['id'] ?>">
                                    <i class="fa-solid fa-edit"></i>
                                </button>
                                <a href="<?= base_url('dashboard/categories/delete/' . $cat['id']) ?>" class="btn btn-link text-danger p-0" onclick="return confirm('Hapus kategori ini?')">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>

                        <!-- Edit Category Modal -->
                        <div class="modal fade" id="editCategoryModal<?= $cat['id'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content border-0 shadow rounded-4 p-3">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title fw-bold">Edit Kategori</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="<?= base_url('dashboard/categories/update/' . $cat['id']) ?>" method="POST">
                                        <?= csrf_field() ?>
                                        <div class="modal-body">
                                            <div class="mb-0">
                                                <label class="form-label small fw-bold">Nama Kategori</label>
                                                <input type="text" name="name" class="form-control rounded-3" value="<?= esc($cat['name']) ?>" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        
                        <?php if(empty($categories)): ?>
                        <tr>
                            <td colspan="3" class="text-center py-5">
                                <img src="<?= base_url('img/logonotfound.png') ?>" alt="Empty" style="height: 100px;" class="mb-3">
                                <p class="text-muted">Belum ada kategori.</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow rounded-4 p-3">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('dashboard/categories/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-0">
                        <label class="form-label small fw-bold">Nama Kategori</label>
                        <input type="text" name="name" class="form-control rounded-3" placeholder="Contoh: Energi Terbarukan" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
