<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Manajemen Kos' ?></title>
    <link rel="stylesheet" href="CSS/Style.css">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>Manajemen Kos</h2>
        </div>
        <nav class="sidebar-nav">
            <ul>
                <li><a href="index.php?c=home&a=index">Dashboard</a></li>
                <?php if (Auth::isLoggedIn()) : ?>
                    <?php if (Auth::checkRole('penghuni')) : ?>
                        <li><a href="index.php?c=invoice&a=index">Tagihan Saya</a></li>
                        <li><a href="index.php?c=maintenance&a=index">Lapor Kerusakan</a></li>
                        <li><a href="index.php?c=feedback&a=create">Kritik & Saran</a></li>
                    <?php endif; ?>
                    <?php if (Auth::checkRole(['admin', 'superadmin'])) : ?>
                        <li><a href="index.php?c=contract&a=index">Manajemen Kontrak</a></li>
                        <li><a href="index.php?c=room&a=index">Manajemen Kamar</a></li>
                        <li><a href="index.php?c=admin&a=reports">Laporan Kerusakan</a></li>
                        <li><a href="index.php?c=admin&a=payments">Verifikasi Pembayaran</a></li>
                        <li><a href="index.php?c=announcement&a=index">Pengumuman</a></li>
                        <li><a href="index.php?c=admin&a=feedbacks">Kritik & Saran</a></li>
                        <li><a href="index.php?c=admin&a=generateInvoices" onclick="return confirm('Yakin ingin generate tagihan bulan ini?')">Generate Tagihan</a></li>
                    <?php endif; ?>
                    <?php if (Auth::checkRole('superadmin')) : ?>
                        <li><a href="index.php?c=branch&a=index">Manajemen Cabang</a></li>
                        <li><a href="index.php?c=user&a=index">Manajemen User</a></li>
                        <li><a href="index.php?c=admin&a=logs">Log Aktivitas</a></li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
    <div class="main-content">
        <header class="top-header">
            <div class="header-title">
                <h1><?= $title ?? 'Dashboard' ?></h1>
            </div>
            <div class="user-info">
                <?php if (Auth::isLoggedIn()) : ?>
                    <span>Halo, <?= htmlspecialchars(Auth::userName()) ?>!</span>
                    <a href="index.php?c=auth&a=logout" class="btn btn-logout">Logout</a>
                <?php else : ?>
                    <a href="index.php?c=auth&a=login" class="btn">Login</a>
                    <a href="index.php?c=auth&a=register" class="btn btn-primary">Register</a>
                <?php endif; ?>
            </div>
        </header>
        <main class="content-area">
            <?php if (!empty($flashes)) : ?>
                <div class="flashes">
                    <?php foreach ($flashes as $flash) : ?>
                        <div class="flash-message <?= htmlspecialchars($flash['type']) ?>">
                            <?= htmlspecialchars($flash['message']) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php
            function get_error($field, $errors) {
                if (isset($errors[$field])) {
                    return '<span class="form-error">' . htmlspecialchars($errors[$field]) . '</span>';
                }
                return '';
            }
            function get_value($field, $old) {
                return htmlspecialchars($old[$field] ?? '');
            }
            ?>