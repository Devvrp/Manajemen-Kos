<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
    </div>
    <form action="index.php?c=room&a=update" method="POST">
        <input type="hidden" name="id" value="<?= $room['room_id'] ?>">
        <?php if (Auth::checkRole('superadmin')) : ?>
        <div>
            <label>Cabang:</label>
            <select name="branch_id" required>
                <option value="">Pilih Cabang</option>
                <?php foreach ($branches as $branch) : ?>
                    <option value="<?= $branch['branch_id'] ?>" <?= (get_value('branch_id', $old) == $branch['branch_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($branch['nama_cabang']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?= get_error('branch_id', $errors) ?>
        </div>
        <?php endif; ?>
        <div>
            <label>Nomor Kamar:</label>
            <input type="text" name="nomor_kamar" value="<?= get_value('nomor_kamar', $old) ?>" required>
            <?= get_error('nomor_kamar', $errors) ?>
        </div>
        <div>
            <label>Tipe Kamar:</label>
            <input type="text" name="tipe_kamar" value="<?= get_value('tipe_kamar', $old) ?>" placeholder="Misal: KM Dalam + AC">
        </div>
        <div>
            <label>Fasilitas:</label>
            <input type="text" name="fasilitas" value="<?= get_value('fasilitas', $old) ?>" placeholder="Misal: AC, WiFi, KM Dalam">
        </div>
        <div>
            <label>Harga Bulanan:</label>
            <input type="number" name="harga_bulanan" value="<?= get_value('harga_bulanan', $old) ?>" required>
            <?= get_error('harga_bulanan', $errors) ?>
        </div>
        <div>
            <label>Status:</label>
            <select name="status">
                <option value="tersedia" <?= get_value('status', $old) == 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                <option value="terisi" <?= get_value('status', $old) == 'terisi' ? 'selected' : '' ?>>Terisi</option>
                <option value="perbaikan" <?= get_value('status', $old) == 'perbaikan' ? 'selected' : '' ?>>Perbaikan</option>
            </select>
        </div>
        <div>
            <button type="submit">Update</button>
            <a href="index.php?c=room&a=index" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>