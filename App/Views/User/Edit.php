<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
    </div>
    <form action="index.php?c=user&a=update" method="POST">
        <input type="hidden" name="id" value="<?= $user['user_id'] ?>">
        <div>
            <label>Nama Lengkap:</label>
            <input type="text" name="nama_lengkap" value="<?= htmlspecialchars($user['nama_lengkap']) ?>" required>
        </div>
        <div>
            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
        <div>
            <label>Role:</label>
            <select name="role">
                <option value="penghuni" <?= $user['role'] == 'penghuni' ? 'selected' : '' ?>>Penghuni</option>
                <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="superadmin" <?= $user['role'] == 'superadmin' ? 'selected' : '' ?>>Superadmin</option>
            </select>
        </div>
        <div>
            <label>Status:</label>
            <select name="status">
                <option value="aktif" <?= $user['status'] == 'aktif' ? 'selected' : '' ?>>Aktif</o$user['status'] == 'banned' ? 'selected' : '' ?>>Banned</option>
            </select>
        </div>
        <div>
            <button type="submit">Update User</button>
            <a href="index.php?c=user&a=index" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>