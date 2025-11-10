<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
    </div>
    <h3>Detail Tagihan</h3>
    <p>Bulan: <?= htmlspecialchars($invoice['bulan_tagihan']) ?></p>
    <p>Total: Rp <?= number_format($invoice['total_tagihan'], 0, ',', '.') ?></p>
    <p>Status: <?= htmlspecialchars($invoice['status_pembayaran']) ?></p>
    <hr>
    <p>Silakan lakukan pembayaran ke Rekening XYZ 123456789 a/n Pemilik Kos.</p>
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