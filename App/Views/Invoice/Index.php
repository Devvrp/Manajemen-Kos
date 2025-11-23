<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>Bulan Tagihan</th>
                <th>Total Tagihan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($invoices)) : ?>
                <tr>
                    <td colspan="4" style="text-align: center;">Anda belum memiliki tagihan.</td>
                </tr>
            <?php else : ?>
                <?php foreach ($invoices as $invoice) : ?>
                    <tr>
                        <td><?= htmlspecialchars($invoice['bulan_tagihan']) ?></td>
                        <td>Rp <?= number_format($invoice['total_tagihan'], 0, ',', '.') ?></td>
                        <td>
                            <?php
                            $statusLabel = '';
                            $statusColor = '';
                            switch ($invoice['status_pembayaran']) {
                                case 'belum_bayar':
                                    $statusLabel = 'Belum Membayar';
                                    $statusColor = 'color: var(--danger); font-weight: 600;';
                                    break;
                                case 'menunggu_verifikasi':
                                    $statusLabel = 'Menunggu Verifikasi';
                                    $statusColor = 'color: var(--warning); font-weight: 600;';
                                    break;
                                case 'lunas':
                                    $statusLabel = 'Lunas';
                                    $statusColor = 'color: var(--success); font-weight: 600;';
                                    break;
                                default:
                                    $statusLabel = htmlspecialchars($invoice['status_pembayaran']);
                            }
                            ?>
                            <span style="<?= $statusColor ?>"><?= $statusLabel ?></span>
                        </td>
                        <td>
                            <?php if ($invoice['status_pembayaran'] == 'belum_bayar') : ?>
                                <a href="index.php?c=invoice&a=pay&id=<?= $invoice['invoice_id'] ?>" class="btn btn-sm">Bayar</a>
                            <?php elseif ($invoice['status_pembayaran'] == 'menunggu_verifikasi') : ?>
                                <span style="color: var(--text-muted); font-size: 13px;">Sedang diproses...</span>
                            <?php elseif ($invoice['status_pembayaran'] == 'lunas') : ?>
                                <span style="color: var(--success);"><i class="fas fa-check-circle"></i> Selesai</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>