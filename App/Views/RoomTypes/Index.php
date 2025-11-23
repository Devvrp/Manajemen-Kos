<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
        <a href="index.php?c=roomType&a=create">Tambah Tipe Baru</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Nama Tipe</th>
                <th>Fasilitas Default</th>
                <th>Harga Default</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($types)) : ?>
                <tr>
                    <td colspan="4" style="text-align: center;">Belum ada data tipe kamar.</td>
                </tr>
            <?php else : ?>
                <?php foreach ($types as $t) : ?>
                <tr>
                    <td><?= htmlspecialchars($t['nama_tipe']) ?></td>
                    <td><?= htmlspecialchars($t['fasilitas_default']) ?></td>
                    <td>Rp <?= number_format($t['harga_default'], 0, ',', '.') ?></td>
                    <td>
                        <a href="index.php?c=roomType&a=edit&id=<?= $t['type_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <form action="index.php?c=roomType&a=destroy" method="POST" style="display:inline;" onsubmit="return confirm('Hapus tipe ini?');">
                            <input type="hidden" name="id" value="<?= $t['type_id'] ?>">
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>