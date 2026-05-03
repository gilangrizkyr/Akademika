<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-5">
    <div>
        <h2 class="fw-bold" style="font-family: 'Outfit', sans-serif;">Manajemen Pengguna</h2>
        <p class="text-muted mb-0">Kelola akses dan peran pengguna dalam sistem.</p>
    </div>
    <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addUserModal">
        <i class="fa-solid fa-user-plus me-2"></i> Tambah Pengguna
    </button>
</div>

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4 py-3 border-0">Username</th>
                    <th class="py-3 border-0">Email</th>
                    <th class="py-3 border-0">Role</th>
                    <th class="py-3 border-0">Status</th>
                    <th class="py-3 border-0 text-end pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user): ?>
                <tr>
                    <td class="ps-4 py-3 fw-bold text-main"><?= esc($user['username']) ?></td>
                    <td class="py-3 text-muted"><?= esc($user['email']) ?></td>
                    <td class="py-3">
                        <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                            <?= ucfirst($user['role']) ?>
                        </span>
                    </td>
                    <td class="py-3">
                        <span class="badge <?= $user['status'] === 'active' ? 'bg-success' : 'bg-danger' ?> bg-opacity-10 text-<?= $user['status'] === 'active' ? 'success' : 'danger' ?> rounded-pill px-3 py-2">
                            <?= ucfirst($user['status']) ?>
                        </span>
                    </td>
                    <td class="py-3 text-end pe-4">
                        <button class="btn btn-link text-muted p-0 me-3" data-bs-toggle="modal" data-bs-target="#editUserModal<?= $user['id'] ?>">
                            <i class="fa-solid fa-edit"></i>
                        </button>
                        <?php if($user['role'] !== 'superadmin'): ?>
                        <a href="<?= base_url('dashboard/users/delete/' . $user['id']) ?>" class="btn btn-link text-danger p-0" onclick="return confirm('Hapus pengguna ini?')">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                        <?php endif; ?>
                    </td>
                </tr>

                <!-- Edit User Modal -->
                <div class="modal fade" id="editUserModal<?= $user['id'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content border-0 shadow rounded-4 p-3">
                            <div class="modal-header border-0">
                                <h5 class="modal-title fw-bold">Edit Pengguna</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="<?= base_url('dashboard/users/update/' . $user['id']) ?>" method="POST">
                                <?= csrf_field() ?>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Username</label>
                                        <input type="text" name="username" class="form-control rounded-3" value="<?= $user['username'] ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Email</label>
                                        <input type="email" name="email" class="form-control rounded-3" value="<?= $user['email'] ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Role</label>
                                        <select name="role" class="form-select rounded-3">
                                            <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                                            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                            <option value="superadmin" <?= $user['role'] === 'superadmin' ? 'selected' : '' ?>>Superadmin</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Status</label>
                                        <select name="status" class="form-select rounded-3">
                                            <option value="active" <?= $user['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                                            <option value="suspended" <?= $user['status'] === 'suspended' ? 'selected' : '' ?>>Suspended</option>
                                        </select>
                                    </div>
                                    <div class="mb-0">
                                        <label class="form-label small fw-bold">Ganti Password (Kosongkan jika tidak diubah)</label>
                                        <input type="password" name="password" class="form-control rounded-3" placeholder="********">
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
            </tbody>
        </table>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow rounded-4 p-3">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Tambah Pengguna Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('dashboard/users/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Username</label>
                        <input type="text" name="username" class="form-control rounded-3" placeholder="username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email</label>
                        <input type="email" name="email" class="form-control rounded-3" placeholder="email@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Role</label>
                        <select name="role" class="form-select rounded-3">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                            <option value="superadmin">Superadmin</option>
                        </select>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold">Password</label>
                        <input type="password" name="password" class="form-control rounded-3" placeholder="********" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Tambah Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="mt-4">
    <?= $pager->links() ?>
</div>

<?= $this->endSection() ?>
