<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
    </div>
    <form action="index.php?c=roomType&a=update" method="POST">
        <input type="hidden" name="id" value="<?= $type['type_id'] ?>">
        <div>
            <label>Nama Tipe Kamar:</label>
            <input type="text" name="nama_tipe" value="<?= get_value('nama_tipe', $old) ?>" required>
            <?= get_error('nama_tipe', $errors) ?>
        </div>
        <div>
            <label>Fasilitas Default:</label>
            <textarea name="fasilitas_default" rows="3"><?= get_value('fasilitas_default', $old) ?></textarea>
        </div>
        <div>
            <label>Harga Default (Rp):</label>
            <input type="number" name="harga_default" value="<?= get_value('harga_default', $old) ?>" required>
            <?= get_error('harga_default', $errors) ?>
        </div>
        <div>
            <button type="submit">Update</button>
            <a href="index.php?c=roomType&a=index" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>