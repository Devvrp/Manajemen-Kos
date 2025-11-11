<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
    </div>
    <form action="index.php?c=room&a=store" method="POST">
        <?php if (Auth::checkRole('superadmin')) : ?>
        <div>
            <label>Cabang:</label>
            <select name="branch_id">
                <option value="">-- Pilih Cabang --</option>
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
            <button type="submit">Simpan</button>
            <a href="index.php?c=room&a=index" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>