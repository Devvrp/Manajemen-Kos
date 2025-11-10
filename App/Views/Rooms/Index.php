<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
        <a href="index.php?c=room&a=create">Tambah Kamar Baru</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Nomor Kamar</th>
                <th>Tipe Kamar</th>
                <th>Harga Bulanan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($rooms)) : ?>
                <tr>
                    <td colspan="5" style="text-align: center;">Belum ada data kamar.</td>
                </tr>
            <?php else : ?>
                <?php foreach ($rooms as $room) : ?>
                    <tr>
                        <td><?= htmlspecialchars($room['nomor_kamar']) ?></td>
                        <td><?= htmlspecialchars($room['tipe_kamar']) ?></td>
                        <td>Rp <?= number_format($room['harga_bulanan'], 0, ',', '.') ?></td>
                        <td><?= htmlspecialchars($room['status']) ?></td>
                        <td>
                            <a href="index.php?c=room&a=edit&id=<?= $room['room_id'] ?>" class="btn btn-warning">Edit</a>
                            <form action="index.php?c=room&a=destroy" method="POST" style="display:inline;" onsubmit="return confirm('Anda yakin ingin menghapus kamar ini?');">
                                <input type="hidden" name="id" value="<?= $room['room_id'] ?>">
                                <button type="submit" class="btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>