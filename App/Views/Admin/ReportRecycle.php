<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
        <a href="index.php?c=admin&a=reports" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Tanggal Dihapus</th>
                <th>Pelapor</th>
                <th>Judul</th>
                <th>Status Terakhir</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($reports)) : ?>
                <tr>
                    <td colspan="5" style="text-align: center;">Recycle bin kosong.</td>
                </tr>
            <?php else : ?>
                <?php foreach ($reports as $report) : ?>
                    <tr>
                        <td><?= htmlspecialchars($report['deleted_at']) ?></td>
                        <td><?= htmlspecialchars($report['nama_lengkap']) ?></td>
                        <td><?= htmlspecialchars($report['judul_laporan']) ?></td>
                        <td><?= htmlspecialchars($report['status_laporan']) ?></td>
                        <td>
                            <a href="index.php?c=admin&a=restoreReport&id=<?= $report['request_id'] ?>" class="btn btn-success btn-sm" onclick="return confirm('Pulihkan laporan ini?');">
                                <i class="fas fa-undo"></i> Restore
                            </a>
                            <form action="index.php?c=admin&a=forceDeleteReport" method="POST" style="display:inline;" onsubmit="return confirm('PERINGATAN: Laporan akan dihapus permanen. Lanjutkan?');">
                                <input type="hidden" name="id" value="<?= $report['request_id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-times"></i> Hapus Permanen</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>