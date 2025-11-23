<div style="display: flex; justify-content: center; align-items: center; min-height: 70vh;">
    <div class="card" style="width: 100%; max-width: 420px; padding: 40px;">
        <div style="text-align: center; margin-bottom: 32px;">
            <h2 style="font-size: 24px; font-weight: 700; color: var(--dark); margin-bottom: 8px;">Selamat Datang</h2>
            <p style="color: var(--text-muted);">Masuk ke akun Manajemen Kos Anda</p>
        </div>
        <form action="index.php?c=auth&a=authenticate" method="POST">
            <div>
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" placeholder="nama@email.com" required autofocus>
            </div>
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                    <label for="password" style="margin-bottom: 0;">Password</label>
                </div>
                <input type="password" name="password" id="password" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn" style="width: 100%; padding: 12px; font-size: 16px; margin-top: 10px;">Masuk</button>
        </form>
        <div style="text-align: center; margin-top: 24px; font-size: 14px; color: var(--text-muted);">
            Belum memiliki akun? 
            <a href="index.php?c=auth&a=register" style="color: var(--primary); font-weight: 600; text-decoration: none;">Daftar Sekarang</a>
        </div>
    </div>
</div>