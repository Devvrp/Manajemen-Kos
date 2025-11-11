<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
    </div>
    <form action="index.php?c=branch&a=update" method="POST">
        <input type="hidden" name="id" value="<?= $branch['branch_id'] ?>">
        <div>
            <label>Nama Cabang:</label>
            <input type="text" name="nama_cabang" value="<?= get_value('nama_cabang', $old) ?>" required>
            <?= get_error('nama_cabang', $errors) ?>
        </div>
        <div>
            <label>Alamat Cabang:</label>
            <textarea name="alamat_cabang"><?= get_value('alamat_cabang', $old) ?></textarea>
        </div>
        <div>
            <button type="submit">Update</button>
            <a href="index.php?c=branch&a=index" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>