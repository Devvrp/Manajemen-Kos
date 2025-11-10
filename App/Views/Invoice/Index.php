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
                        <td><?= htmlspecialchars($invoice['status_pembayaran']) ?></td>
                        <td>
                            <?php if ($invoice['status_pembayaran'] == 'belum_bayar') : ?>
                                <a href="index.php?c=invoice&a=pay&id=<?= $invoice['invoice_id'] ?>" class="btn">Bayar</a>
                            <?php elseif ($invoice['status_pembayaran'] == 'menunggu_verifikasi') : ?>
                                Menunggu Verifikasi
                            <?php elseif ($invoice['status_pembayaran'] == 'lunas') : ?>
                                <span style="color: green;">Lunas</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>