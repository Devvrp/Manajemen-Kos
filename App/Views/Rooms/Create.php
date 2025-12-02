<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
    </div>
    <form action="index.php?c=room&a=store" method="POST">
        <?php if (Auth::checkRole('superadmin')) : ?>
        <div>
            <label>Cabang:</label>
            <select name="branch_id">
                <option value="">Pilih Cabang</option>
                <?php foreach ($branches as $branch) : ?>
                    <option value="<?= $branch['branch_id'] ?>" <?= (get_value('branch_id', $old) == $branch['branch_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($branch['nama_cabang']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?= get_error('branch_id', $errors) ?>
        </div>
        <?php endif; ?>
        <div>
            <label>Nomor Kamar:</label>
            <input type="text" name="nomor_kamar" value="<?= get_value('nomor_kamar', $old) ?>" required placeholder="Contoh: A-101">
            <?= get_error('nomor_kamar', $errors) ?>
        </div>
        <div style="margin-bottom: 30px; border-bottom: 1px solid var(--border-color); padding-bottom: 20px;">
            <label>Pilih Template Tipe Kamar (Opsi Cepat):</label>
            <select id="typeSelector" onchange="fillRoomData()">
                <option value="">Pilih Template</option>
                <?php foreach ($types as $type) : ?>
                    <option value="<?= htmlspecialchars($type['nama_tipe']) ?>" 
                            data-fasilitas="<?= htmlspecialchars($type['fasilitas_default']) ?>"
                            data-harga="<?= $type['harga_default'] ?>">
                        <?= htmlspecialchars($type['nama_tipe']) ?> (Rp <?= number_format($type['harga_default']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Nama Tipe Kamar:</label>
            <input type="text" name="tipe_kamar" id="tipe_kamar" value="<?= get_value('tipe_kamar', $old) ?>" required placeholder="Misal: VIP A">
        </div>
        <div>
            <label>Fasilitas:</label>
            <input type="text" name="fasilitas" id="fasilitas" value="<?= get_value('fasilitas', $old) ?>" placeholder="Fasilitas kamar...">
        </div>
        <div>
            <label>Harga Bulanan (Rp):</label>
            <input type="number" name="harga_bulanan" id="harga_bulanan" value="<?= get_value('harga_bulanan', $old) ?>" required>
            <?= get_error('harga_bulanan', $errors) ?>
        </div>
        <div>
            <button type="submit">Simpan</button>
            <a href="index.php?c=room&a=index" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<script>
function fillRoomData() {
    const selector = document.getElementById('typeSelector');
    const selectedOption = selector.options[selector.selectedIndex];
    if (selectedOption.value !== "") {
        const namaTipe = selectedOption.value;
        const fasilitas = selectedOption.getAttribute('data-fasilitas');
        const harga = selectedOption.getAttribute('data-harga');
        document.getElementById('tipe_kamar').value = namaTipe;
        document.getElementById('fasilitas').value = fasilitas;
        document.getElementById('harga_bulanan').value = harga;
    }
}
</script>