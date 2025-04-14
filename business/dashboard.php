<?php
require_once '../includes/config.php';
require_once '../includes/header.php';

// Oturum ve yetki kontrolü
checkLogin();
checkUserType('business');

$page_title = "İşletme Dashboard";
?>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-calendar-check"></i> Bugünkü Randevular</h5>
                <h2 class="card-text">0</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-check-circle"></i> Tamamlanan Randevular</h5>
                <h2 class="card-text">0</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-people"></i> Toplam Müşteri</h5>
                <h2 class="card-text">0</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-clock"></i> Bekleyen Randevular</h5>
                <h2 class="card-text">0</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Günlük Randevu Takvimi</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Saat</th>
                                <th>Müşteri</th>
                                <th>Hizmet</th>
                                <th>Durum</th>
                                <th>İşlem</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5" class="text-center">Bugün için randevu bulunmuyor</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Hızlı İşlemler</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Yeni Randevu Ekle
                    </button>
                    <button class="btn btn-success">
                        <i class="bi bi-calendar-plus"></i> Toplu Randevu Oluştur
                    </button>
                    <button class="btn btn-info">
                        <i class="bi bi-gear"></i> Ayarları Düzenle
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?> 