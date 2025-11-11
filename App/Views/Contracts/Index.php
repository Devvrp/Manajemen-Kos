<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
        <a href="index.php?c=contract&a=create">Buat Kontrak Baru</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Nama Penghuni</th>
                <th>Nomor Kamar</th>
                <?php if (Auth::checkRole('superadmin')) : ?>
                    <th>Cabang</th>
                <?php endif; ?>
                <th>Tanggal Masuk</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($contracts)) : ?>
                <tr>
                    <td colspan="5" style="text-align: center;">Belum ada kontrak aktif.</td>
                </tr>
            <?php else : ?>
                <?php foreach ($contracts as $contract) : ?>
                    <tr>
                        <td><?= htmlspecialchars($contract['nama_lengkap']) ?></td>
                        <td><?= htmlspecialchars($contract['nomor_kamar']) ?></td>
                        <?php if (Auth::checkRole('superadmin')) : ?>
                            <td><?= htmlspecialchars($contract['nama_cabang']) ?></td>
                        <?php endif; ?>
                        <td><?= htmlspecialchars($contract['tanggal_masuk']) ?></td>
                        <td>
                            <form action="index.php?c=contract&a=end" method="POST" style="display:inline;" onsubmit="return confirm('Anda yakin ingin menyelesaikan kontrak ini? Kamar akan dikosongkan.');">
                                <input type="hidden" name="contract_id" value="<?= $contract['contract_id'] ?>">
                                <button type="submit" class="btn-warning">Selesaikan Kontrak</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>