<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
    </div>
    <form action="index.php?c=room&a=store" method="POST">
        <div>
            <label>Nomor Kamar:</label>
            <input type="text" name="nomor_kamar" required>
        </div>
        <div>
            <label>Tipe Kamar:</label>
            <input type="text" name="tipe_kamar" placeholder="Misal: KM Dalam + AC">
        </div>
        <div>
            <label>Harga Bulanan:</label>
            <input type="number" name="harga_bulanan" required>
        </div>
        <div>
            <button type="submit">Simpan</button>
            <a href="index.php?c=room&a=index" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>