<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
    </div>
    <form action="index.php?c=announcement&a=update" method="POST">
        <input type="hidden" name="id" value="<?= $announcement['announcement_id'] ?>">
        <div>
            <label>Judul:</label>
            <input type="text" name="judul" value="<?= get_value('judul', $old) ?>" required>
            <?= get_error('judul', $errors) ?>
        </div>
        <div>
            <label>Target Cabang (Kosongkan = Semua Cabang):</label>
            <select name="branch_id">
                <option value="">Semua Cabang</option>
                <?php foreach ($branches as $branch) : ?>
                    <option value="<?= $branch['branch_id'] ?>" <?= (get_value('branch_id', $old) == $branch['branch_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($branch['nama_cabang']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Isi Pengumuman:</label>
            <textarea name="isi_pengumuman" rows="10" required><?= get_value('isi_pengumuman', $old) ?></textarea>
            <?= get_error('isi_pengumuman', $errors) ?>
        </div>
        <div>
            <button type="submit">Update</button>
            <a href="index.php?c=announcement&a=index" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>