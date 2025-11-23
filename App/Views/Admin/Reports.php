<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
        <a href="index.php?c=admin&a=reportRecycleBin" class="btn btn-secondary btn-sm">
            <i class="fas fa-trash-restore"></i> Recycle Bin
        </a>
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
                        <td>
                            <?php
                            $statusClass = '';
                            if ($report['status_laporan'] == 'dilaporkan') $statusClass = 'color: var(--danger); font-weight: 600;';
                            elseif ($report['status_laporan'] == 'dikerjakan') $statusClass = 'color: var(--warning); font-weight: 600;';
                            elseif ($report['status_laporan'] == 'selesai') $statusClass = 'color: var(--success); font-weight: 600;';
                            ?>
                            <span style="<?= $statusClass ?>"><?= ucfirst(htmlspecialchars($report['status_laporan'])) ?></span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px; align-items: center;">
                                <form action="index.php?c=admin&a=updateReportStatus" method="POST" style="display: flex; gap: 5px;">
                                    <input type="hidden" name="request_id" value="<?= $report['request_id'] ?>">
                                    <select name="status" style="padding: 6px; border-radius: 4px; border: 1px solid var(--border); font-size: 13px; cursor: pointer; min-width: 110px;">
                                        <option value="dilaporkan" <?= $report['status_laporan'] == 'dilaporkan' ? 'selected' : '' ?>>Dilaporkan</option>
                                        <option value="dikerjakan" <?= $report['status_laporan'] == 'dikerjakan' ? 'selected' : '' ?>>Dikerjakan</option>
                                        <option value="selesai" <?= $report['status_laporan'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                </form>
                                <form action="index.php?c=admin&a=destroyReport" method="POST" onsubmit="return confirm('Pindahkan ke Recycle Bin?');" style="margin: 0;">
                                    <input type="hidden" name="request_id" value="<?= $report['request_id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>