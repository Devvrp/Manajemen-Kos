<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
    </div>
    <form action="index.php?c=maintenance&a=store" method="POST">
        <div>
            <label>Judul Laporan:</label>
            <input type="text" name="judul_laporan" value="<?= get_value('judul_laporan', $old) ?>" required placeholder="Misal: AC tidak dingin">
            <?= get_error('judul_laporan', $errors) ?>
        </div>
        <div>
            <label>Deskripsi Kerusakan:</label>
            <textarea name="deskripsi_kerusakan" rows="5" placeholder="Jelaskan detail kerusakannya..."><?= get_value('deskripsi_kerusakan', $old) ?></textarea>
        </div>
        <div>
            <button type="submit">Kirim Laporan</button>
            <a href="index.php?c=maintenance&a=index" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>