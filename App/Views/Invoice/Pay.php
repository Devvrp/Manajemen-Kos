<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
    </div>
    <h3>Detail Tagihan</h3>
    <p>Bulan: <?= htmlspecialchars($invoice['bulan_tagihan']) ?></p>
    <p>Total Tagihan: Rp <?= number_format($invoice['total_tagihan'], 0, ',', '.') ?></p>
    <p>Status: 
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
    </p>
    <hr>
    <p>Silakan lakukan pembayaran ke Rekening Mandiri 123456789 a/n Aliya Labibah.</p>
    <p>Setelah itu, upload bukti pembayaran Anda di bawah ini.</p>
    <form action="index.php?c=invoice&a=upload" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="invoice_id" value="<?= $invoice['invoice_id'] ?>">
        <div>
            <label>Upload Bukti Bayar (JPG, PNG, PDF - Max 2MB):</label>
            <input type="file" name="bukti_bayar" required>
        </div>
        <div>
            <button type="submit">Konfirmasi Pembayaran</button>
            <a href="index.php?c=invoice&a=index" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>