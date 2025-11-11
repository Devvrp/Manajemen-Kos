<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
        <a href="index.php?c=user&a=recycleBin" class="btn btn-secondary">Recycle Bin</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Role</th>
                <th>Cabang (Jika Admin)</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?= htmlspecialchars($user['nama_lengkap']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['role']) ?></td>
                    <td><?= htmlspecialchars($user['nama_cabang'] ?? 'N/A') ?></td>
                    <td>
                        <a href="index.php?c=user&a=edit&id=<?= $user['user_id'] ?>" class="btn btn-warning">Edit</a>
                        <?php if ($user['user_id'] != Auth::userId()) : ?>
                            <form action="index.php?c=user&a=destroy" method="POST" style="display:inline;" onsubmit="return confirm('Anda yakin ingin menghapus user ini?');">
                                <input type="hidden" name="id" value="<?= $user['user_id'] ?>">
                                <button type="submit" class="btn-danger">Hapus</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>