<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-5">
    <div>
        <h2 class="fw-bold" style="font-family: 'Outfit', sans-serif;">Daftar Penelitian</h2>
        <p class="text-muted mb-0">Kelola semua karya penelitian Anda di sini.</p>
    </div>
    <a href="<?= base_url('dashboard/research/create') ?>" class="btn btn-primary rounded-pill px-4">
        <i class="fa-solid fa-plus me-2"></i> Buat Penelitian Baru
    </a>
</div>

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4 py-3 border-0">Judul Penelitian</th>
                    <th class="py-3 border-0">Status</th>
                    <th class="py-3 border-0">Views</th>
                    <th class="py-3 border-0">Tanggal</th>
                    <th class="py-3 border-0 text-end pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($researches as $item): ?>
                <tr>
                    <td class="ps-4 py-3">
                        <div class="d-flex align-items-center gap-3">
                            <img src="<?= base_url('uploads/research/' . ($item['cover_image'] ?? 'default.jpg')) ?>" class="rounded-3" style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <div class="fw-bold text-main"><?= esc(character_limiter($item['title'], 40)) ?></div>
                                <div class="text-muted small">ID: #<?= esc($item['id']) ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="py-3">
                        <?php 
                        $badge = 'bg-secondary';
                        if($item['status'] === 'published') $badge = 'bg-success';
                        if($item['status'] === 'pending') $badge = 'bg-warning';
                        if($item['status'] === 'rejected') $badge = 'bg-danger';
                        ?>
                        <span class="badge <?= $badge ?> bg-opacity-10 text-<?= str_replace('bg-', '', $badge) ?> rounded-pill px-3 py-2">
                            <?= ucfirst($item['status']) ?>
                        </span>
                    </td>
                    <td class="py-3 text-muted"><?= esc($item['views']) ?></td>
                    <td class="py-3 text-muted small"><?= date('d/m/Y', strtotime($item['created_at'])) ?></td>
                    <td class="py-3 text-end pe-4">
                        <div class="dropdown">
                            <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                <li><a class="dropdown-item" href="<?= base_url('dashboard/section/' . $item['id']) ?>"><i class="fa-solid fa-layer-group me-2"></i> Kelola Section</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('dashboard/research/edit/' . $item['id']) ?>"><i class="fa-solid fa-edit me-2"></i> Edit Detail</a></li>
                                <li><a class="dropdown-item text-danger" href="<?= base_url('dashboard/research/delete/' . $item['id']) ?>" onclick="return confirm('Hapus penelitian ini?')"><i class="fa-solid fa-trash me-2"></i> Hapus</a></li>
                                <?php if(session()->get('role') === 'superadmin' || session()->get('role') === 'admin'): ?>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><h6 class="dropdown-header">Moderasi</h6></li>
                                    <li>
                                        <form action="<?= base_url('dashboard/research/moderate/' . $item['id']) ?>" method="POST" class="d-inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="status" value="published">
                                            <button type="submit" class="dropdown-item text-success"><i class="fa-solid fa-check-circle me-2"></i> Approve</button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="<?= base_url('dashboard/research/moderate/' . $item['id']) ?>" method="POST" class="d-inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="dropdown-item text-danger"><i class="fa-solid fa-times-circle me-2"></i> Reject</button>
                                        </form>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    <?= $pager->links() ?>
</div>

<?= $this->endSection() ?>
