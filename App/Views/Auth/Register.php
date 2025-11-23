<div style="display: flex; justify-content: center; align-items: center; min-height: 80vh; padding: 20px 0;">
    <div class="card" style="width: 100%; max-width: 480px; padding: 40px;">
        <div style="text-align: center; margin-bottom: 32px;">
            <h2 style="font-size: 24px; font-weight: 700; color: var(--dark); margin-bottom: 8px;">Buat Akun Baru</h2>
            <p style="color: var(--text-muted);">Mulai kelola atau sewa kos dengan mudah</p>
        </div>
        <form action="index.php?c=auth&a=storeUser" method="POST">
            <div>
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" value="<?= get_value('nama_lengkap', $old) ?>" placeholder="Nama Lengkap Anda" required>
                <?= get_error('nama_lengkap', $errors) ?>
            </div>
            <div>
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" value="<?= get_value('email', $old) ?>" placeholder="nama@email.com" required>
                <?= get_error('email', $errors) ?>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                <div style="margin-bottom: 0;">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="••••••••" required>
                    <?= get_error('password', $errors) ?>
                </div>
                <div style="margin-bottom: 0;">
                    <label for="confirm_password">Konfirmasi</label>
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="••••••••" required>
                </div>
            </div>
            <button type="submit" class="btn" style="width: 100%; padding: 12px; font-size: 16px;">Daftar</button>
        </form>
        <div style="text-align: center; margin-top: 24px; font-size: 14px; color: var(--text-muted);">
            Sudah punya akun? 
            <a href="index.php?c=auth&a=login" style="color: var(--primary); font-weight: 600; text-decoration: none;">Login disini</a>
        </div>
    </div>
</div>