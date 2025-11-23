<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Manajemen Kos' ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="CSS/Style.css">
</head>
<body>
    <?php if (Auth::isLoggedIn()) : ?>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>Manajemen Kos</h2>
        </div>
        <nav class="sidebar-nav">
            <ul>
                <li><a href="index.php?c=home&a=index"><i class="fas fa-chart-line" style="margin-right: 10px;"></i> Dashboard</a></li>
                <?php if (Auth::checkRole('penghuni')) : ?>
                    <li><a href="index.php?c=invoice&a=index"><i class="fas fa-file-invoice-dollar" style="margin-right: 10px;"></i> Tagihan Saya</a></li>
                    <li><a href="index.php?c=maintenance&a=index"><i class="fas fa-tools" style="margin-right: 10px;"></i> Lapor Kerusakan</a></li>
                    <li><a href="index.php?c=feedback&a=create"><i class="fas fa-comment-dots" style="margin-right: 10px;"></i> Kritik & Saran</a></li>
                <?php endif; ?>
                <?php if (Auth::checkRole(['admin', 'superadmin'])) : ?>
                    <li><a href="index.php?c=contract&a=index"><i class="fas fa-file-contract" style="margin-right: 10px;"></i> Manajemen Kontrak</a></li>
                    <li><a href="index.php?c=room&a=index"><i class="fas fa-door-open" style="margin-right: 10px;"></i> Manajemen Kamar</a></li>
                    <li><a href="index.php?c=admin&a=reports"><i class="fas fa-wrench" style="margin-right: 10px;"></i> Laporan Kerusakan</a></li>
                    <li><a href="index.php?c=admin&a=payments"><i class="fas fa-money-check-alt" style="margin-right: 10px;"></i> Verifikasi Pembayaran</a></li>
                    <li><a href="index.php?c=announcement&a=index"><i class="fas fa-bullhorn" style="margin-right: 10px;"></i> Pengumuman</a></li>
                    <li><a href="index.php?c=admin&a=feedbacks"><i class="fas fa-inbox" style="margin-right: 10px;"></i> Kritik & Saran</a></li>
                    <li><a href="index.php?c=admin&a=generateInvoices" onclick="return confirm('Yakin ingin generate tagihan bulan ini?')"><i class="fas fa-sync-alt" style="margin-right: 10px;"></i> Generate Tagihan</a></li>
                <?php endif; ?>
                <?php if (Auth::checkRole('superadmin')) : ?>
                    <li><a href="index.php?c=branch&a=index"><i class="fas fa-building" style="margin-right: 10px;"></i> Manajemen Cabang</a></li>
                    <li><a href="index.php?c=roomType&a=index"><i class="fas fa-bed" style="margin-right: 10px;"></i> Master Tipe Kamar</a></li>
                    <li><a href="index.php?c=user&a=index"><i class="fas fa-users" style="margin-right: 10px;"></i> Manajemen User</a></li>
                    <li><a href="index.php?c=admin&a=logs"><i class="fas fa-history" style="margin-right: 10px;"></i> Log Aktivitas</a></li>
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
                <span>Halo, <?= htmlspecialchars(Auth::userName()) ?>!</span>
                <a href="index.php?c=auth&a=logout" class="btn btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </header>
        <main class="content-area">
    <?php else : ?>
    <div class="guest-layout">
        <main class="guest-content">
    <?php endif; ?>
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