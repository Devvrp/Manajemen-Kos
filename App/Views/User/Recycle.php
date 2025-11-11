<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
        <a href="index.php?c=user&a=index" class="btn btn-secondary">Kembali ke Daftar User</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Tanggal Dihapus</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($users)) : ?>
                <tr>
                    <td colspan="4" style="text-align: center;">Recycle bin kosong.</td>
                </tr>
            <?php else : ?>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?= htmlspecialchars($user['nama_lengkap']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['deleted_at']) ?></td>
                        <td>
                            <a href="index.php?c=user&a=restore&id=<?= $user['user_id'] ?>" class="btn btn-success" onclick="return confirm('Yakin pulihkan user ini?');">Restore</a>
                            <form action="index.php?c=user&a=forceDelete" method="POST" style="display:inline;" onsubmit="return confirm('PERINGATAN: User akan dihapus permanen. Anda yakin?');">
                                <input type="hidden" name="id" value="<?= $user['user_id'] ?>">
                                <button type="submit" class="btn-danger">Hapus Permanen</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>