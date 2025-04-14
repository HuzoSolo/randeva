<?php
require_once '../includes/config.php';
require_once '../includes/header.php';

// Oturum ve yetki kontrolü
checkLogin();
checkUserType('admin');

$page_title = "İşletme Yönetimi";
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">İşletme Yönetimi</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBusinessModal">
        <i class="bi bi-plus-circle"></i> Yeni İşletme Ekle
    </button>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>İşletme Adı</th>
                        <th>Telefon</th>
                        <th>E-posta</th>
                        <th>Durum</th>
                        <th>Kayıt Tarihi</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Örnek İşletme 1</td>
                        <td>0555 123 4567</td>
                        <td>info@ornek1.com</td>
                        <td><span class="badge bg-success">Aktif</span></td>
                        <td>01.01.2023</td>
                        <td>
                            <button class="btn btn-sm btn-info"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Örnek İşletme 2</td>
                        <td>0555 123 4568</td>
                        <td>info@ornek2.com</td>
                        <td><span class="badge bg-warning">Onay Bekliyor</span></td>
                        <td>15.01.2023</td>
                        <td>
                            <button class="btn btn-sm btn-info"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Örnek İşletme 3</td>
                        <td>0555 123 4569</td>
                        <td>info@ornek3.com</td>
                        <td><span class="badge bg-danger">Pasif</span></td>
                        <td>30.01.2023</td>
                        <td>
                            <button class="btn btn-sm btn-info"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Yeni İşletme Ekle Modal -->
<div class="modal fade" id="addBusinessModal" tabindex="-1" aria-labelledby="addBusinessModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBusinessModalLabel">Yeni İşletme Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="businessName" class="form-label">İşletme Adı</label>
                        <input type="text" class="form-control" id="businessName" required>
                    </div>
                    <div class="mb-3">
                        <label for="businessPhone" class="form-label">Telefon</label>
                        <input type="tel" class="form-control" id="businessPhone" required>
                    </div>
                    <div class="mb-3">
                        <label for="businessEmail" class="form-label">E-posta</label>
                        <input type="email" class="form-control" id="businessEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="businessPassword" class="form-label">Şifre</label>
                        <input type="password" class="form-control" id="businessPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="businessStatus" class="form-label">Durum</label>
                        <select class="form-select" id="businessStatus" required>
                            <option value="active">Aktif</option>
                            <option value="pending">Onay Bekliyor</option>
                            <option value="inactive">Pasif</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                <button type="button" class="btn btn-primary">Kaydet</button>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?> 