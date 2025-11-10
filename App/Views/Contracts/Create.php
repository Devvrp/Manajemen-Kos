<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
    </div>
    <form action="index.php?c=contract&a=store" method="POST">
        <div>
            <label>Pilih Penghuni:</label>
            <select name="user_id" required>
                <option value="">-- Pilih Penghuni (yang belum punya kamar) --</option>
                <?php foreach ($tenants as $tenant) : ?>
                    <option value="<?= $tenant['user_id'] ?>"><?= htmlspecialchars($tenant['nama_lengkap']) ?> (<?= htmlspecialchars($tenant['email']) ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Pilih Kamar:</label>
            <select name="room_id" required>
                <option value="">-- Pilih Kamar (yang tersedia) --</option>
                <?php foreach ($rooms as $room) : ?>
                    <option value="<?= $room['room_id'] ?>"><?= htmlspecialchars($room['nomor_kamar']) ?> (Rp <?= number_format($room['harga_bulanan']) ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Tanggal Masuk:</label>
            <input type="date" name="tanggal_masuk" required>
        </div>
        <div>
            <button type="submit">Simpan Kontrak</button>
            <a href="index.php?c=contract&a=index" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>