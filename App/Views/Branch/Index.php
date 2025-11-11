<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
        <a href="index.php?c=branch&a=create">Tambah Cabang Baru</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Nama Cabang</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($branches)) : ?>
                <tr>
                    <td colspan="3" style="text-align: center;">Belum ada data cabang.</td>
                </tr>
            <?php else : ?>
                <?php foreach ($branches as $branch) : ?>
                    <tr>
                        <td><?= htmlspecialchars($branch['nama_cabang']) ?></td>
                        <td><?= htmlspecialchars($branch['alamat_cabang']) ?></td>
                        <td>
                            <a href="index.php?c=branch&a=edit&id=<?= $branch['branch_id'] ?>" class="btn btn-warning">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>