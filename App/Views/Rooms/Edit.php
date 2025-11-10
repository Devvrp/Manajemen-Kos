<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
    </div>
    <form action="index.php?c=room&a=update" method="POST">
        <input type="hidden" name="id" value="<?= $room['room_id'] ?>">
        <div>
            <label>Nomor Kamar:</label>
            <input type="text" name="nomor_kamar" value="<?= htmlspecialchars($room['nomor_kamar']) ?>" required>
        </div>
        <div>
            <label>Tipe Kamar:</label>
            <input type="text" name="tipe_kamar" value="<?= htmlspecialchars($room['tipe_kamar']) ?>" placeholder="Misal: KM Dalam + AC">
        </div>
        <div>
            <label>Harga Bulanan:</label>
            <input type="number" name="harga_bulanan" value="<?= htmlspecialchars($room['harga_bulanan']) ?>" required>
        </div>
        <div>
            <label>Status:</label>
            <select name="status">
                <option value="tersedia" <?= $room['status'] == 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                <option value="terisi" <?= $room['status'] == 'terisi' ? 'selected' : '' ?>>Terisi</option>
                <option value="perbaikan" <?= $room['status'] == 'perbaikan' ? 'selected' : '' ?>>Perbaikan</option>
            </select>
        </div>
        <div>
            <button type="submit">Update</button>
            <a href="index.php?c=room&a=index" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>