<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' . SITE_NAME : SITE_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="<?php echo SITE_URL; ?>/assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php if (isset($_SESSION['user_id'])): ?>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-brand">
                <h1 class="sidebar-brand-text"><?php echo SITE_NAME; ?></h1>
            </div>
            <hr class="sidebar-divider">
            
            <?php if ($_SESSION['user_type'] === 'admin'): ?>
            <!-- Admin Navigation -->
            <div class="sidebar-heading">Yönetim</div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'admin/dashboard.php') !== false ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/admin/dashboard.php">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'admin/businesses.php') !== false ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/admin/businesses.php">
                        <i class="bi bi-shop"></i>
                        <span>İşletmeler</span>
                    </a>
                </li>
            </ul>
            
            <hr class="sidebar-divider">
            
            <div class="sidebar-heading">Konfigürasyon</div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'admin/settings.php') !== false ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/admin/settings.php">
                        <i class="bi bi-gear"></i>
                        <span>Sistem Ayarları</span>
                    </a>
                </li>
            </ul>
            <?php else: ?>
            <!-- Business Navigation -->
            <div class="sidebar-heading">İşletme</div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'business/dashboard.php') !== false ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/business/dashboard.php">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'business/appointments.php') !== false ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/business/appointments.php">
                        <i class="bi bi-calendar-check"></i>
                        <span>Randevular</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'business/customers.php') !== false ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/business/customers.php">
                        <i class="bi bi-people"></i>
                        <span>Müşteriler</span>
                    </a>
                </li>
            </ul>
            
            <hr class="sidebar-divider">
            
            <div class="sidebar-heading">WhatsApp Bot</div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'business/whatsapp-menus.php') !== false ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/business/whatsapp-menus.php">
                        <i class="bi bi-chat-dots"></i>
                        <span>Menü Yönetimi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'business/whatsapp-settings.php') !== false ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/business/whatsapp-settings.php">
                        <i class="bi bi-whatsapp"></i>
                        <span>WhatsApp Ayarları</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'business/messages.php') !== false ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/business/messages.php">
                        <i class="bi bi-envelope"></i>
                        <span>Mesaj Geçmişi</span>
                    </a>
                </li>
            </ul>
            
            <hr class="sidebar-divider">
            
            <div class="sidebar-heading">Konfigürasyon</div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'business/settings.php') !== false ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/business/settings.php">
                        <i class="bi bi-gear"></i>
                        <span>İşletme Ayarları</span>
                    </a>
                </li>
            </ul>
            <?php endif; ?>
        </div>
        
        <div id="sidebar-backdrop" class="sidebar-backdrop"></div>
        
        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Topbar -->
            <div class="topbar">
                <button id="sidebarToggle" class="topbar-toggle">
                    <i class="bi bi-list"></i>
                </button>
                
                <div class="topbar-nav">
                    <div class="dropdown">
                        <a class="btn btn-link nav-link dropdown-toggle" href="#" role="button" id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
                            <li><h6 class="dropdown-header">Bildirimler</h6></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-calendar-check text-success"></i> Yeni bir randevu oluşturuldu</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-chat-dots text-primary"></i> Yeni mesaj alındı</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-exclamation-circle text-warning"></i> Abonelik sona eriyor</a></li>
                        </ul>
                    </div>
                    
                    <div class="topbar-divider"></div>
                    
                    <div class="dropdown">
                        <a class="btn btn-link nav-link dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="d-none d-lg-inline text-gray-600 small me-2"><?php echo $_SESSION['user_name']; ?></span>
                            <i class="bi bi-person-circle"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profil</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Ayarlar</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/logout.php"><i class="bi bi-box-arrow-right"></i> Çıkış Yap</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="main-content">
                <!-- Page Title -->
                <?php if (isset($page_title)): ?>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0 text-gray-800"><?php echo $page_title; ?></h1>
                </div>
                <?php endif; ?>
    <?php else: ?>
    <div class="container mt-4">
    <?php endif; ?> 