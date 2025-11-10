<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Penghuni</th>
                <th>Kamar</th>
                <th>Total</th>
                <th>Bukti Bayar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($invoices)) : ?>
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada pembayaran yang perlu diverifikasi.</td>
                </tr>
            <?php else : ?>
                <?php foreach ($invoices as $invoice) : ?>
                    <tr>
                        <td><?= htmlspecialchars($invoice['bulan_tagihan']) ?></td>
                        <td><?= htmlspecialchars($invoice['nama_lengkap']) ?></td>
                        <td><?= htmlspecialchars($invoice['nomor_kamar']) ?></td>
                        <td>Rp <?= number_format($invoice['total_tagihan'], 0, ',', '.') ?></td>
                        <td>
                            <a href="Public/uploads/payments/<?= htmlspecialchars($invoice['file_bukti_bayar']) ?>" target="_blank" class="btn btn-secondary">Lihat Bukti</a>
                        </td>
                        <td>
                            <form action="index.php?c=admin&a=verifyPayment" method="POST" style="display:inline;">
                                <input type="hidden" name="invoice_id" value="<?= $invoice['invoice_id'] ?>">
                                <button type="submit" name="action" value="approve" class="btn-success">Setujui</button>
                            </form>
                            <form action="index.php?c=admin&a=verifyPayment" method="POST" style="display:inline;">
                                <input type="hidden" name="invoice_id" value="<?= $invoice['invoice_id'] ?>">
                                <button type="submit" name="action" value="reject" class="btn-danger">Tolak</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>