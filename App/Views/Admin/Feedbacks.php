<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Dari</th>
                <th>Email</th>
                <th>Subjek</th>
                <th>Isi Pesan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($feedbacks)) : ?>
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada kritik atau saran.</td>
                </tr>
            <?php else : ?>
                <?php foreach ($feedbacks as $feedback) : ?>
                    <tr>
                        <td><?= htmlspecialchars($feedback['created_at']) ?></td>
                        <td><?= htmlspecialchars($feedback['nama_lengkap']) ?></td>
                        <td><?= htmlspecialchars($feedback['email']) ?></td>
                        <td><?= htmlspecialchars($feedback['subjek']) ?></td>
                        <td><?= nl2br(htmlspecialchars($feedback['isi_pesan'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>