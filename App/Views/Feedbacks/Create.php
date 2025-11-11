<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
    </div>
    <form action="index.php?c=feedback&a=store" method="POST">
        <div>
            <label>Subjek:</label>
            <input type="text" name="subjek" value="<?= get_value('subjek', $old) ?>" required>
            <?= get_error('subjek', $errors) ?>
        </div>
        <div>
            <label>Isi Pesan:</label>
            <textarea name="isi_pesan" rows="10" required><?= get_value('isi_pesan', $old) ?></textarea>
            <?= get_error('isi_pesan', $errors) ?>
        </div>
        <div>
            <button type="submit">Kirim</button>
            <a href="index.php?c=home&a=index" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>