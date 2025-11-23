<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
        <a href="index.php?c=room&a=index" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Tanggal Dihapus</th>
                <th>Nomor Kamar</th>
                <th>Cabang</th>
                <th>Status Terakhir</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($rooms)) : ?>
                <tr>
                    <td colspan="5" style="text-align: center;">Recycle bin kosong.</td>
                </tr>
            <?php else : ?>
                <?php foreach ($rooms as $room) : ?>
                    <tr>
                        <td><?= htmlspecialchars($room['deleted_at']) ?></td>
                        <td><?= htmlspecialchars($room['nomor_kamar']) ?></td>
                        <td><?= htmlspecialchars($room['nama_cabang']) ?></td>
                        <td><?= htmlspecialchars($room['status']) ?></td>
                        <td>
                            <a href="index.php?c=room&a=restore&id=<?= $room['room_id'] ?>" class="btn btn-success btn-sm" onclick="return confirm('Pulihkan kamar ini?');">
                                <i class="fas fa-undo"></i> Restore
                            </a>
                            <form action="index.php?c=room&a=forceDelete" method="POST" style="display:inline;" onsubmit="return confirm('PERINGATAN: Kamar akan dihapus permanen. Lanjutkan?');">
                                <input type="hidden" name="id" value="<?= $room['room_id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-times"></i> Hapus Permanen</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>