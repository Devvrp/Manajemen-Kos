<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
        <a href="index.php?c=maintenance&a=create">Buat Laporan Baru</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Tanggal Lapor</th>
                <th>Kamar</th>
                <th>Judul Laporan</th>
                <th>Deskripsi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($reports)) : ?>
                <tr>
                    <td colspan="5" style="text-align: center;">Anda belum memiliki laporan.</td>
                </tr>
            <?php else : ?>
                <?php foreach ($reports as $report) : ?>
                    <tr>
                        <td><?= htmlspecialchars($report['tanggal_lapor']) ?></td>
                        <td><?= htmlspecialchars($report['nomor_kamar']) ?></td>
                        <td><?= htmlspecialchars($report['judul_laporan']) ?></td>
                        <td><?= nl2br(htmlspecialchars($report['deskripsi_kerusakan'])) ?></td>
                        <td><?= htmlspecialchars($report['status_laporan']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>