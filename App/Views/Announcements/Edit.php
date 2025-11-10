<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
    </div>
    <form action="index.php?c=announcement&a=update" method="POST">
        <input type="hidden" name="id" value="<?= $announcement['announcement_id'] ?>">
        <div>
            <label>Judul:</label>
            <input type="text" name="judul" value="<?= htmlspecialchars($announcement['judul']) ?>" required>
        </div>
        <div>
            <label>Isi Pengumuman:</label>
            <textarea name="isi_pengumuman" rows="10" required><?= htmlspecialchars($announcement['isi_pengumuman']) ?></textarea>
        </div>
        <div>
            <button type="submit">Update</button>
            <a href="index.php?c=announcement&a=index" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>