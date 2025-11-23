<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
    </div>
    <form action="index.php?c=roomType&a=store" method="POST">
        <div>
            <label>Nama Tipe Kamar:</label>
            <input type="text" name="nama_tipe" value="<?= get_value('nama_tipe', $old) ?>" required placeholder="Contoh: VIP, Standard AC">
            <?= get_error('nama_tipe', $errors) ?>
        </div>
        <div>
            <label>Fasilitas Default:</label>
            <textarea name="fasilitas_default" rows="3" placeholder="Contoh: Kasur Queen, AC, TV, WiFi"><?= get_value('fasilitas_default', $old) ?></textarea>
        </div>
        <div>
            <label>Harga Default (Rp):</label>
            <input type="number" name="harga_default" value="<?= get_value('harga_default', $old) ?>" required placeholder="Contoh: 1500000">
            <?= get_error('harga_default', $errors) ?>
        </div>
        <div>
            <button type="submit">Simpan</button>
            <a href="index.php?c=roomType&a=index" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>