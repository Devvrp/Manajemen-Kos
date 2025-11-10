<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
    </div>
    <form action="index.php?c=announcement&a=store" method="POST">
        <div>
            <label>Judul:</label>
            <input type="text" name="judul" required>
        </div>
        <div>
            <label>Isi Pengumuman:</label>
            <textarea name="isi_pengumuman" rows="10" required></textarea>
        </div>
        <div>
            <button type="submit">Publikasikan</button>
            <a href="index.php?c=announcement&a=index" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>