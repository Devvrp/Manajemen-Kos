<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
    </div>
    <form action="index.php?c=user&a=update" method="POST">
        <input type="hidden" name="id" value="<?= $user['user_id'] ?>">
        <div>
            <label>Nama Lengkap:</label>
            <input type="text" name="nama_lengkap" value="<?= get_value('nama_lengkap', $old) ?>" required>
            <?= get_error('nama_lengkap', $errors) ?>
        </div>
        <div>
            <label>Email:</label>
            <input type="email" name="email" value="<?= get_value('email', $old) ?>" required>
            <?= get_error('email', $errors) ?>
        </div>
        <div>
            <label>Role:</label>
            <select name="role">
                <option value="penghuni" <?= get_value('role', $old) == 'penghuni' ? 'selected' : '' ?>>Penghuni</option>
                <option value="admin" <?= get_value('role', $old) == 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="superadmin" <?= get_value('role', $old) == 'superadmin' ? 'selected' : '' ?>>Superadmin</option>
            </select>
        </div>
        <div>
            <label>Cabang (Hanya jika role Admin):</label>
            <select name="branch_id">
                <option value="">Tidak Ada</option>
                <?php foreach ($branches as $branch) : ?>
                    <option value="<?= $branch['branch_id'] ?>" <?= (get_value('branch_id', $old) == $branch['branch_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($branch['nama_cabang']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <button type="submit">Update User</button>
            <a href="index.php?c=user&a=index" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>