<div class="card" style="max-width: 500px; margin: 40px auto;">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
    </div>
    <form action="index.php?c=auth&a=storeUser" method="POST">
        <div>
            <label>Nama Lengkap:</label>
            <input type="text" name="nama_lengkap" value="<?= get_value('nama_lengkap', $old) ?>">
            <?= get_error('nama_lengkap', $errors) ?>
        </div>
        <div>
            <label>Email:</label>
            <input type="email" name="email" value="<?= get_value('email', $old) ?>">
            <?= get_error('email', $errors) ?>
        </div>
        <div>
            <label>Password:</label>
            <input type="password" name="password">
            <?= get_error('password', $errors) ?>
        </div>
        <div>
            <label>Konfirmasi Password:</label>
            <input type="password" name="confirm_password">
        </div>
        <div>
            <button type="submit">Register</button>
        </div>
    </form>
    <p style="margin-top: 15px;">Sudah punya akun? <a href="index.php?c=auth&a=login">Login di sini</a></p>
</div>