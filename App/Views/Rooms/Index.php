<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
        <div style="display: flex; gap: 10px;">
            <?php if (Auth::checkRole('superadmin')) : ?>
                <a href="index.php?c=room&a=recycleBin" class="btn btn-secondary">
                    <i class="fas fa-trash-restore"></i> Recycle Bin
                </a>
            <?php endif; ?>
            <a href="index.php?c=room&a=create" class="btn">
                <i class="fas fa-plus"></i> Tambah Kamar
            </a>
        </div>
    </div>
    <div class="card" style="box-shadow: none; border: 1px solid var(--border); margin-bottom: 20px; background: #F8FAFC;">
        <form action="index.php" method="GET" style="margin: 0;">
            <input type="hidden" name="c" value="room">
            <input type="hidden" name="a" value="index">
            <div style="display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap;">
                <?php if (Auth::checkRole('superadmin')) : ?>
                <div style="flex: 1; min-width: 200px;">
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
                <div style="flex: 1; min-width: 150px;">
                    <label>Harga Maks:</label>
                    <input type="number" name="harga_max" value="<?= htmlspecialchars($filters['harga_max'] ?? '') ?>" placeholder="Contoh : 500000">
                </div>
                <div style="flex: 1; min-width: 150px;">
                    <label>Fasilitas (Mengandung):</label>
                    <input type="text" name="fasilitas" value="<?= htmlspecialchars($filters['fasilitas'] ?? '') ?>" placeholder="Contoh : AC">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Filter</button>
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
                        <td>
                            <?php if($room['status'] == 'tersedia'): ?>
                                <span style="color: var(--success); font-weight: 600;">Tersedia</span>
                            <?php elseif($room['status'] == 'terisi'): ?>
                                <span style="color: var(--primary); font-weight: 600;">Terisi</span>
                            <?php else: ?>
                                <span style="color: var(--danger); font-weight: 600;">Perbaikan</span>
                            <?php endif; ?>
                        </td>
                        <?php if (Auth::checkRole('superadmin')) : ?>
                            <td><?= htmlspecialchars($room['nama_cabang']) ?></td>
                        <?php endif; ?>
                        <td>
                            <a href="index.php?c=room&a=edit&id=<?= $room['room_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <form action="index.php?c=room&a=destroy" method="POST" style="display:inline;" onsubmit="return confirm('Anda yakin ingin menghapus kamar ini?');">
                                <input type="hidden" name="id" value="<?= $room['room_id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>