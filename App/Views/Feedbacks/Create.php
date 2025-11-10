<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
    </div>
    <form action="index.php?c=feedback&a=store" method="POST">
        <div>
            <label>Subjek:</label>
            <input type="text" name="subjek" required>
        </div>
        <div>
            <label>Isi Pesan:</label>
            <textarea name="isi_pesan" rows="10" required></textarea>
        </div>
        <div>
            <button type="submit">Kirim</button>
            <a href="index.php?c=home&a=index" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>