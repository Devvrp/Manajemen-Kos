<div class="card" style="max-width: 500px; margin: 40px auto;">
    <div class="card-header">
        <h2><?= htmlspecialchars($title) ?></h2>
    </div>
    <form action="index.php?c=auth&a=authenticate" method="POST">
        <div>
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <button type="submit">Login</button>
        </div>
    </form>
    <p style="margin-top: 15px;">Belum punya akun? <a href="index.php?c=auth&a=register">Register di sini</a></p>
</div>