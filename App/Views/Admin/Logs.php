<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>Timestamp</th>
                <th>Aktor</th>
                <th>Deskripsi Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($logs)) : ?>
                <tr>
                    <td colspan="3" style="text-align: center;">Tidak ada aktivitas tercatat.</td>
                </tr>
            <?php else : ?>
                <?php foreach ($logs as $log) : ?>
                    <tr>
                        <td><?= htmlspecialchars($log['timestamp']) ?></td>
                        <td><?= htmlspecialchars($log['nama_lengkap']) ?> (ID: <?= $log['user_id'] ?>)</td>
                        <td><?= htmlspecialchars($log['action_description']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>