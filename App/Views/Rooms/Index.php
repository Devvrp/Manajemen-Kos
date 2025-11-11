<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
        <a href="index.php?c=room&a=create">Tambah Kamar Baru</a>
    </div>
    <div class="card">
        <form action="index.php" method="GET">
            <input type="hidden" name="c" value="room">
            <input type="hidden" name="a" value="index">
            <div style="display: flex; gap: 15px;">
                <?php if (Auth::checkRole('superadmin')) : ?>
                <div style="flex: 1;">
                    <label>Filter Cabang:</label>
                    <select name="branch_id">
                        <option value="">Semua Cabang</option>
                        <?php foreach ($branches as $branch) : ?>
                            <option value="<?= $branch['branch_id'] ?>" <?= (isset($filters['branch_id']) && $filters['branch_id'] == $branch['branch_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($branch['nama_cabang']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>
                <div style="flex: 1;">
                    <label>Harga Maks:</label>
                    <input type="number" name="harga_max" value="<?= htmlspecialchars($filters['harga_max'] ?? '') ?>" placeholder="Misal: 500000">
                </div>
                <div style="flex: 1;">
                    <label>Fasilitas (Mengandung):</label>
                    <input type="text" name="fasilitas" value="<?= htmlspecialchars($filters['fasilitas'] ?? '') ?>" placeholder="Misal: AC">
                </div>
                <div style="align-self: flex-end;">
                    <button type="submit">Filter</button>
                    <a href="index.php?c=room&a=index" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
    </div>
    <table>
        <thead>
            <tr>
                <th>Nomor Kamar</th>
                <th>Tipe Kamar</th>
                <th>Harga Bulanan</th>
                <th>Fasilitas</th>
                <th>Status</th>
                <?php if (Auth::checkRole('superadmin')) : ?>
                    <th>Cabang</th>
                <?php endif; ?>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($rooms)) : ?>
                <tr>
                    <td colspan="7" style="text-align: center;">Belum ada data kamar.</td>
                </tr>
            <?php else : ?>
                <?php foreach ($rooms as $room) : ?>
                    <tr>
                        <td><?= htmlspecialchars($room['nomor_kamar']) ?></td>
                        <td><?= htmlspecialchars($room['tipe_kamar']) ?></td>
                        <td>Rp <?= number_format($room['harga_bulanan'], 0, ',', '.') ?></td>
                        <td><?= htmlspecialchars($room['fasilitas']) ?></td>
                        <td><?= htmlspecialchars($room['status']) ?></td>
                        <?php if (Auth::checkRole('superadmin')) : ?>
                            <td><?= htmlspecialchars($room['nama_cabang']) ?></td>
                        <?php endif; ?>
                        <td>
                            <a href="index.php?c=room&a=edit&id=<?= $room['room_id'] ?>" class="btn btn-warning">Edit</a>
                            <?php if (Auth::checkRole('superadmin')) : ?>
                            <form action="index.php?c=room&a=destroy" method="POST" style="display:inline;" onsubmit="return confirm('Anda yakin ingin menghapus kamar ini?');">
                                <input type="hidden" name="id" value="<?= $room['room_id'] ?>">
                                <button type="submit" class="btn-danger">Hapus</button>
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>