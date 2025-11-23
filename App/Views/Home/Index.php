<style>
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    .stat-card {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        display: flex;
        flex-direction: column;
        transition: transform 0.2s;
        position: relative;
        overflow: hidden;
    }
    .stat-card:hover {
        transform: translateY(-2px);
    }
    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: var(--dark);
        margin: 10px 0 5px 0;
    }
    .stat-label {
        color: var(--text-muted);
        font-size: 14px;
        font-weight: 500;
    }
    .stat-icon {
        font-size: 24px;
        margin-bottom: 10px;
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
    }
    .welcome-banner {
        background: #fff;
        border-radius: 12px;
        padding: 24px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    .filter-bar {
        background: #F1F5F9;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .hero-container {
        text-align: center;
        max-width: 900px;
        margin: 0 auto;
        padding: 100px 20px;
        position: relative;
        z-index: 10;
    }
    .hero-icon {
        font-size: 6rem;
        margin-bottom: 30px;
        background: linear-gradient(135deg, #60A5FA 0%, #A78BFA 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        filter: drop-shadow(0 0 30px rgba(96, 165, 250, 0.4));
        animation: float-icon 6s ease-in-out infinite;
    }
    .hero-title {
        font-size: 4rem;
        font-weight: 900;
        color: #fff;
        margin-bottom: 20px;
        letter-spacing: -0.04em;
        line-height: 1.1;
        text-shadow: 0 20px 40px rgba(0,0,0,0.3);
    }
    .hero-subtitle {
        font-size: 1.25rem;
        color: #CBD5E1;
        margin-bottom: 50px;
        line-height: 1.7;
        font-weight: 400;
        max-width: 650px;
        margin-left: auto;
        margin-right: auto;
    }
    .hero-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
    }
    .btn-hero-primary {
        background: linear-gradient(to right, var(--primary), var(--primary-hover));
        color: #fff;
        padding: 16px 40px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s;
        box-shadow: 0 10px 30px -10px rgba(37, 99, 235, 0.6);
        border: 1px solid rgba(255,255,255,0.1);
    }
    .btn-hero-primary:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px -10px rgba(37, 99, 235, 0.8);
        color: #fff;
    }
    .btn-hero-secondary {
        background-color: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(10px);
        color: #fff;
        padding: 16px 40px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1.1rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s;
    }
    .btn-hero-secondary:hover {
        background-color: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.3);
        transform: translateY(-4px);
        color: #fff;
    }

    @keyframes float-icon {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
        100% { transform: translateY(0px); }
    }

    .bg-glow-1 {
        position: absolute;
        top: -10%;
        left: 20%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(37, 99, 235, 0.15) 0%, transparent 70%);
        filter: blur(80px);
        z-index: 1;
        animation: pulse-glow 8s infinite alternate;
    }
    .bg-glow-2 {
        position: absolute;
        bottom: -10%;
        right: 10%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(139, 92, 246, 0.12) 0%, transparent 70%);
        filter: blur(80px);
        z-index: 1;
        animation: pulse-glow 10s infinite alternate-reverse;
    }
    @keyframes pulse-glow {
        0% { opacity: 0.5; transform: scale(1); }
        100% { opacity: 1; transform: scale(1.1); }
    }
</style>

<div style="border: none; box-shadow: none; background: transparent; padding: 0;">
    <?php if (Auth::isLoggedIn()) : ?>
        <div class="welcome-banner">
            <div>
                <h2 style="margin: 0 0 8px 0; font-size: 1.5rem; color: var(--dark);">Dashboard Overview</h2>
                <p style="color: var(--text-muted); margin: 0;">Halo <strong><?= htmlspecialchars(Auth::userName()) ?></strong>, selamat datang kembali di panel kontrol.</p>
            </div>
            <div style="text-align: right;">
                <span style="background: var(--light); padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; color: var(--text-main); border: 1px solid var(--border);">
                    <i class="fas fa-user-tag" style="margin-right: 5px;"></i> <?= ucfirst(htmlspecialchars(Auth::userRole())) ?>
                </span>
            </div>
        </div>
        <?php if (Auth::checkRole(['admin', 'superadmin'])) : ?>
            <?php if (Auth::checkRole('superadmin')) : ?>
            <div class="filter-bar">
                <span style="font-weight: 600; color: var(--dark); display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-chart-pie" style="color: var(--primary);"></i> Data: <span style="color: var(--primary);"><?= htmlspecialchars($selected_branch_name) ?></span>
                </span>
                <div style="display: flex; gap: 10px;">
                    <form action="index.php" method="GET" style="margin: 0;">
                        <input type="hidden" name="c" value="home">
                        <input type="hidden" name="a" value="index">
                        <select name="branch_id" style="padding: 8px; border-radius: 6px; border: 1px solid var(--border); min-width: 200px;" onchange="this.form.submit()">
                            <option value="">Tampilkan Semua</option>
                            <?php foreach ($branches as $branch) : ?>
                                <option value="<?= $branch['branch_id'] ?>" <?= ($selected_branch_id == $branch['branch_id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($branch['nama_cabang']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                    <a href="index.php?c=home&a=index" class="btn btn-secondary" style="padding: 8px 12px; font-size: 13px;">Reset</a>
                </div>
            </div>
            <?php endif; ?>
            <div class="dashboard-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #E0F2FE; color: #0284C7;">
                        <i class="fas fa-home"></i>
                    </div>
                    <span class="stat-value"><?= $stats['total_kamar'] ?></span>
                    <span class="stat-label">Total Kamar</span>
                    <small class="text-muted" style="margin-top: 5px; font-size: 12px;">
                        <i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($selected_branch_name) ?>
                    </small>
                </div>
                <div class="stat-card" style="border-bottom: 4px solid var(--success);">
                    <div class="stat-icon" style="background: #DCFCE7; color: #16A34A;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <span class="stat-value"><?= $stats['tersedia'] ?></span>
                    <span class="stat-label">Kamar Tersedia</span>
                    <?php $filterLink = "index.php?c=room&a=index&status=tersedia" . ($selected_branch_id ? "&branch_id=$selected_branch_id" : ""); ?>
                    <a href="<?= $filterLink ?>" style="font-size: 12px; margin-top: 10px; color: var(--success); font-weight: 500;">
                        Lihat Detail <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="stat-card" style="border-bottom: 4px solid var(--primary);">
                    <div class="stat-icon" style="background: #DBEAFE; color: #2563EB;">
                        <i class="fas fa-users"></i>
                    </div>
                    <span class="stat-value"><?= $stats['terisi'] ?></span>
                    <span class="stat-label">Kamar Terisi</span>
                </div>
                <div class="stat-card" style="border-bottom: 4px solid var(--warning);">
                    <div class="stat-icon" style="background: #FEF3C7; color: #D97706;">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <span class="stat-value"><?= $stats['tagihan_pending'] ?></span>
                    <span class="stat-label">Verifikasi Bayar</span>
                    <?php if($stats['tagihan_pending'] > 0): ?>
                        <a href="index.php?c=admin&a=payments" style="font-size: 12px; margin-top: 10px; color: var(--warning); font-weight: 600;">
                            Perlu Tindakan! <i class="fas fa-exclamation-circle"></i>
                        </a>
                    <?php else: ?>
                        <small style="color: var(--success); margin-top: 10px; font-size: 12px;">
                            <i class="fas fa-check"></i> Semua aman
                        </small>
                    <?php endif; ?>
                </div>
                <div class="stat-card" style="border-bottom: 4px solid var(--danger);">
                    <div class="stat-icon" style="background: #FEE2E2; color: #DC2626;">
                        <i class="fas fa-tools"></i>
                    </div>
                    <span class="stat-value"><?= $stats['laporan_baru'] ?></span>
                    <span class="stat-label">Laporan Kerusakan</span>
                    <?php if($stats['laporan_baru'] > 0): ?>
                        <a href="index.php?c=admin&a=reports" style="font-size: 12px; margin-top: 10px; color: var(--danger); font-weight: 600;">
                            Cek Laporan <i class="fas fa-arrow-right"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-rocket" style="color: var(--primary); margin-right: 10px;"></i> Aksi Cepat</h3>
                </div>
                <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                    <a href="index.php?c=contract&a=create" class="btn"><i class="fas fa-file-signature" style="margin-right: 8px;"></i> Buat Kontrak</a>
                    <a href="index.php?c=room&a=create" class="btn btn-secondary"><i class="fas fa-plus" style="margin-right: 8px;"></i> Tambah Kamar</a>
                    <a href="index.php?c=announcement&a=create" class="btn btn-secondary"><i class="fas fa-bullhorn" style="margin-right: 8px;"></i> Info Baru</a>
                </div>
            </div>
        <?php elseif (Auth::checkRole('penghuni')) : ?>
            <div class="dashboard-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #DBEAFE; color: #2563EB;">
                        <i class="fas fa-bed"></i>
                    </div>
                    <span class="stat-value"><?= !empty($contract) ? htmlspecialchars($contract['nomor_kamar']) : '-' ?></span>
                    <span class="stat-label">Kamar Anda</span>
                    <small style="margin-top: 5px; font-size: 12px;">
                        Status: <?= !empty($contract) ? '<span style="color: var(--success);">Aktif</span>' : '<span style="color: var(--text-muted);">Belum ada</span>' ?>
                    </small>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #D1FAE5; color: #059669;">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <span class="stat-value">Rp <?= !empty($contract) ? number_format($contract['harga_bulanan'], 0, ',', '.') : '0' ?></span>
                    <span class="stat-label">Tagihan Bulanan</span>
                    <a href="index.php?c=invoice&a=index" style="font-size: 12px; margin-top: 10px; color: var(--primary); font-weight: 600;">
                        Bayar Sekarang <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-bullhorn" style="color: var(--danger);"></i> Papan Pengumuman</h3>
                </div>
                <?php if (empty($announcements)) : ?>
                    <p style="text-align: center; color: var(--text-muted); padding: 20px;">Belum ada pengumuman terbaru.</p>
                <?php else : ?>
                    <?php foreach ($announcements as $announcement) : ?>
                        <div style="border-left: 4px solid var(--primary); padding-left: 15px; margin-bottom: 24px;">
                            <h4 style="margin: 0 0 5px 0; color: var(--dark);"><?= htmlspecialchars($announcement['judul']) ?></h4>
                            <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 10px;">
                                <i class="far fa-clock"></i> <?= date('d M Y', strtotime($announcement['created_at'])) ?> • 
                                <i class="far fa-user"></i> <?= htmlspecialchars($announcement['nama_lengkap']) ?>
                            </div>
                            <p style="margin: 0; white-space: pre-line; color: var(--text-main);"><?= htmlspecialchars($announcement['isi_pengumuman']) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php else : ?>
        <div class="bg-glow-1"></div>
        <div class="bg-glow-2"></div>
        <div class="hero-container">
            <div class="hero-icon">
                <i class="fas fa-home"></i>
            </div>
            <h1 class="hero-title">
                Sistem Manajemen <span style="background: linear-gradient(to right, #60A5FA, #A78BFA); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Kos Modern</span>
            </h1>
            <p class="hero-subtitle">
                Platform serba bisa untuk kelola kamar, tagihan otomatis, dan layanan penghuni yang lebih efisien dalam satu platform. Simpel, Aman, dan Efisien.
            </p>
            <div class="hero-buttons">
                <a href="index.php?c=auth&a=login" class="btn-hero-primary">
                    <i class="fas fa-sign-in-alt" style="margin-right: 10px;"></i> Login Akun
                </a>
                <a href="index.php?c=auth&a=register" class="btn-hero-secondary">
                    <i class="fas fa-user-plus" style="margin-right: 10px;"></i> Daftar Baru
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>