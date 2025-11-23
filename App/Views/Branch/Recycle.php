<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
        <a href="index.php?c=branch&a=index" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Nama Cabang</th>
                <th>Alamat</th>
                <th>Tanggal Dihapus</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($branches)) : ?>
                <tr>
                    <td colspan="4" style="text-align: center;">Recycle bin kosong.</td>
                </tr>
            <?php else : ?>
                <?php foreach ($branches as $branch) : ?>
                    <tr>
                        <td><?= htmlspecialchars($branch['nama_cabang']) ?></td>
                        <td><?= htmlspecialchars($branch['alamat_cabang']) ?></td>
                        <td><?= htmlspecialchars($branch['deleted_at']) ?></td>
                        <td>
                            <a href="index.php?c=branch&a=restore&id=<?= $branch['branch_id'] ?>" class="btn btn-success btn-sm" onclick="return confirm('Pulihkan cabang ini?');">
                                <i class="fas fa-undo"></i> Restore
                            </a>
                            <form action="index.php?c=branch&a=forceDelete" method="POST" style="display:inline;" onsubmit="return confirm('PERINGATAN: Cabang akan dihapus permanen. Lanjutkan?');">
                                <input type="hidden" name="id" value="<?= $branch['branch_id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-times"></i> Hapus Permanen</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>