<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
        <a href="index.php?c=announcement&a=create">Buat Pengumuman Baru</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Judul</th>
                <th>Pembuat</th>
                <th>Cabang Target</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($announcements)) : ?>
                <tr>
                    <td colspan="5" style="text-align: center;">Belum ada pengumuman.</td>
                </tr>
            <?php else : ?>
                <?php foreach ($announcements as $announcement) : ?>
                    <tr>
                        <td><?= htmlspecialchars($announcement['created_at']) ?></td>
                        <td><?= htmlspecialchars($announcement['judul']) ?></td>
                        <td><?= htmlspecialchars($announcement['nama_lengkap']) ?></td>
                        <td><?= htmlspecialchars($announcement['nama_cabang'] ?? 'Semua Cabang') ?></td>
                        <td>
                            <a href="index.php?c=announcement&a=edit&id=<?= $announcement['announcement_id'] ?>" class="btn btn-warning">Edit</a>
                            <form action="index.php?c=announcement&a=destroy" method="POST" style="display:inline;" onsubmit="return confirm('Anda yakin ingin menghapus pengumuman ini?');">
                                <input type="hidden" name="id" value="<?= $announcement['announcement_id'] ?>">
                                <button type="submit" class="btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>