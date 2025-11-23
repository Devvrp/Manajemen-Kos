<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
        <a href="index.php?c=announcement&a=index" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Judul</th>
                <th>Pembuat</th>
                <th>Tanggal Dihapus</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($announcements)) : ?>
                <tr>
                    <td colspan="4" style="text-align: center;">Recycle bin kosong.</td>
                </tr>
            <?php else : ?>
                <?php foreach ($announcements as $announcement) : ?>
                    <tr>
                        <td><?= htmlspecialchars($announcement['judul']) ?></td>
                        <td><?= htmlspecialchars($announcement['nama_lengkap']) ?></td>
                        <td><?= htmlspecialchars($announcement['deleted_at']) ?></td>
                        <td>
                            <a href="index.php?c=announcement&a=restore&id=<?= $announcement['announcement_id'] ?>" class="btn btn-success btn-sm" onclick="return confirm('Pulihkan pengumuman ini?');">
                                <i class="fas fa-undo"></i> Restore
                            </a>
                            <form action="index.php?c=announcement&a=forceDelete" method="POST" style="display:inline;" onsubmit="return confirm('PERINGATAN: Pengumuman akan dihapus permanen. Lanjutkan?');">
                                <input type="hidden" name="id" value="<?= $announcement['announcement_id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-times"></i> Hapus Permanen</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>