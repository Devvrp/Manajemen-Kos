<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>Tanggal Lapor</th>
                <th>Pelapor</th>
                <th>Kamar</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($reports)) : ?>
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada laporan kerusakan.</td>
                </tr>
            <?php else : ?>
                <?php foreach ($reports as $report) : ?>
                    <tr>
                        <td><?= htmlspecialchars($report['tanggal_lapor']) ?></td>
                        <td><?= htmlspecialchars($report['nama_lengkap']) ?></td>
                        <td><?= htmlspecialchars($report['nomor_kamar']) ?></td>
                        <td><?= htmlspecialchars($report['judul_laporan']) ?></td>
                        <td><?= nl2br(htmlspecialchars($report['deskripsi_kerusakan'])) ?></td>
                        <td><?= htmlspecialchars($report['status_laporan']) ?></td>
                        <td>
                            <form action="index.php?c=admin&a=updateReportStatus" method="POST">
                                <input type="hidden" name="request_id" value="<?= $report['request_id'] ?>">
                                <select name="status">
                                    <option value="dilaporkan" <?= $report['status_laporan'] == 'dilaporkan' ? 'selected' : '' ?>>Dilaporkan</option>
                                    <option value="dikerjakan" <?= $report['status_laporan'] == 'dikerjakan' ? 'selected' : '' ?>>Dikerjakan</option>
                                    <option value="selesai" <?= $report['status_laporan'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                                </select>
                                <button type="submit">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>