<div class="card">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
        <a href="index.php?c=admin&a=feedbacks" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Tanggal Dihapus</th>
                <th>Dari</th>
                <th>Subjek</th>
                <th>Isi Pesan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($feedbacks)) : ?>
                <tr>
                    <td colspan="5" style="text-align: center;">Recycle bin kosong.</td>
                </tr>
            <?php else : ?>
                <?php foreach ($feedbacks as $feedback) : ?>
                    <tr>
                        <td><?= htmlspecialchars($feedback['deleted_at']) ?></td>
                        <td><?= htmlspecialchars($feedback['nama_lengkap']) ?></td>
                        <td><?= htmlspecialchars($feedback['subjek']) ?></td>
                        <td><?= nl2br(htmlspecialchars($feedback['isi_pesan'])) ?></td>
                        <td>
                            <a href="index.php?c=admin&a=restoreFeedback&id=<?= $feedback['feedback_id'] ?>" class="btn btn-success btn-sm" onclick="return confirm('Pulihkan feedback ini?');">
                                <i class="fas fa-undo"></i> Restore
                            </a>
                            <form action="index.php?c=admin&a=forceDeleteFeedback" method="POST" style="display:inline;" onsubmit="return confirm('PERINGATAN: Feedback akan dihapus permanen. Lanjutkan?');">
                                <input type="hidden" name="id" value="<?= $feedback['feedback_id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-times"></i> Hapus Permanen</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>