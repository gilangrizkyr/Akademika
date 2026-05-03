<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-5">
    <div>
        <h2 class="fw-bold" style="font-family: 'Outfit', sans-serif;">Manajemen Tag</h2>
        <p class="text-muted mb-0">Kelola tag pencarian untuk metadata penelitian.</p>
    </div>
    <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addTagModal">
        <i class="fa-solid fa-plus me-2"></i> Tambah Tag
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
                            <th class="ps-4 py-3 border-0">Nama Tag</th>
                            <th class="py-3 border-0">Slug</th>
                            <th class="py-3 border-0 text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($tags as $tag): ?>
                        <tr>
                            <td class="ps-4 py-3">
                                <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-2">
                                    #<?= esc($tag['name']) ?>
                                </span>
                            </td>
                            <td class="py-3 text-muted"><code><?= esc($tag['slug']) ?></code></td>
                            <td class="py-3 text-end pe-4">
                                <button class="btn btn-link text-muted p-0 me-3" data-bs-toggle="modal" data-bs-target="#editTagModal<?= $tag['id'] ?>">
                                    <i class="fa-solid fa-edit"></i>
                                </button>
                                <a href="<?= base_url('dashboard/tags/delete/' . $tag['id']) ?>" class="btn btn-link text-danger p-0" onclick="return confirm('Hapus tag ini?')">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>

                        <!-- Edit Tag Modal -->
                        <div class="modal fade" id="editTagModal<?= $tag['id'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content border-0 shadow rounded-4 p-3">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title fw-bold">Edit Tag</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="<?= base_url('dashboard/tags/update/' . $tag['id']) ?>" method="POST">
                                        <?= csrf_field() ?>
                                        <div class="modal-body">
                                            <div class="mb-0">
                                                <label class="form-label small fw-bold">Nama Tag</label>
                                                <input type="text" name="name" class="form-control rounded-3" value="<?= esc($tag['name']) ?>" required>
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
                        
                        <?php if(empty($tags)): ?>
                        <tr>
                            <td colspan="3" class="text-center py-5">
                                <img src="<?= base_url('img/logonotfound.png') ?>" alt="Empty" style="height: 100px;" class="mb-3">
                                <p class="text-muted">Belum ada tag.</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Tag Modal -->
<div class="modal fade" id="addTagModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow rounded-4 p-3">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Tambah Tag Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('dashboard/tags/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-0">
                        <label class="form-label small fw-bold">Nama Tag</label>
                        <input type="text" name="name" class="form-control rounded-3" placeholder="Contoh: AI, Renewable Energy" required>
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
