<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
    </div>
    <?php if (Auth::checkRole('penghuni')) : ?>
        <h3>Pengumuman Terbaru</h3>
        <?php if (empty($announcements)) : ?>
            <p>Belum ada pengumuman terbaru.</p>
        <?php else : ?>
            <?php foreach ($announcements as $announcement) : ?>
                <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; border-radius: 6px;">
                    <h4><?= htmlspecialchars($announcement['judul']) ?></h4>
                    <small>Diposting oleh: <?= htmlspecialchars($announcement['nama_lengkap']) ?> pada <?= htmlspecialchars($announcement['created_at']) ?></small>
                    <hr>
                    <p><?= nl2br(htmlspecialchars($announcement['isi_pengumuman'])) ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php else : ?>
        <p>Ini adalah halaman dashboard utama. Silakan pilih menu di navigasi.</p>
    <?php endif; ?>
</div>