<?php
require_once '../includes/config.php';
require_once '../includes/header.php';

// Oturum ve yetki kontrolü
checkLogin();
checkUserType('business');

$page_title = "Randevu Yönetimi";
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Randevu Yönetimi</h1>
    <div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">
            <i class="bi bi-plus-circle"></i> Yeni Randevu
        </button>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Randevu Filtreleme</h5>
    </div>
    <div class="card-body">
        <form class="row g-3">
            <div class="col-md-3">
                <label for="startDate" class="form-label">Başlangıç Tarihi</label>
                <input type="date" class="form-control" id="startDate">
            </div>
            <div class="col-md-3">
                <label for="endDate" class="form-label">Bitiş Tarihi</label>
                <input type="date" class="form-control" id="endDate">
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label">Durum</label>
                <select class="form-select" id="status">
                    <option value="">Tümü</option>
                    <option value="pending">Bekliyor</option>
                    <option value="confirmed">Onaylandı</option>
                    <option value="completed">Tamamlandı</option>
                    <option value="canceled">İptal Edildi</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filtrele</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Müşteri</th>
                        <th>Telefon</th>
                        <th>Tarih</th>
                        <th>Saat</th>
                        <th>Hizmet</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Ahmet Yılmaz</td>
                        <td>0555 111 2222</td>
                        <td>01.05.2023</td>
                        <td>10:00</td>
                        <td>Saç Kesimi</td>
                        <td><span class="badge bg-success">Onaylandı</span></td>
                        <td>
                            <button class="btn btn-sm btn-info"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Mehmet Demir</td>
                        <td>0555 333 4444</td>
                        <td>02.05.2023</td>
                        <td>11:30</td>
                        <td>Sakal Tıraşı</td>
                        <td><span class="badge bg-warning">Bekliyor</span></td>
                        <td>
                            <button class="btn btn-sm btn-info"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Zeynep Kaya</td>
                        <td>0555 555 6666</td>
                        <td>03.05.2023</td>
                        <td>14:00</td>
                        <td>Saç Boyama</td>
                        <td><span class="badge bg-primary">Tamamlandı</span></td>
                        <td>
                            <button class="btn btn-sm btn-info"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Fatma Şahin</td>
                        <td>0555 777 8888</td>
                        <td>04.05.2023</td>
                        <td>16:30</td>
                        <td>Manikür</td>
                        <td><span class="badge bg-danger">İptal Edildi</span></td>
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

<!-- Yeni Randevu Ekle Modal -->
<div class="modal fade" id="addAppointmentModal" tabindex="-1" aria-labelledby="addAppointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAppointmentModalLabel">Yeni Randevu Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="customerName" class="form-label">Müşteri Adı</label>
                        <input type="text" class="form-control" id="customerName" required>
                    </div>
                    <div class="mb-3">
                        <label for="customerPhone" class="form-label">Telefon</label>
                        <input type="tel" class="form-control" id="customerPhone" required>
                    </div>
                    <div class="mb-3">
                        <label for="appointmentDate" class="form-label">Tarih</label>
                        <input type="date" class="form-control" id="appointmentDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="appointmentTime" class="form-label">Saat</label>
                        <input type="time" class="form-control" id="appointmentTime" required>
                    </div>
                    <div class="mb-3">
                        <label for="appointmentService" class="form-label">Hizmet</label>
                        <select class="form-select" id="appointmentService" required>
                            <option value="">Hizmet Seçin</option>
                            <option value="haircut">Saç Kesimi</option>
                            <option value="beard">Sakal Tıraşı</option>
                            <option value="color">Saç Boyama</option>
                            <option value="manicure">Manikür</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="appointmentStatus" class="form-label">Durum</label>
                        <select class="form-select" id="appointmentStatus" required>
                            <option value="pending">Bekliyor</option>
                            <option value="confirmed">Onaylandı</option>
                            <option value="completed">Tamamlandı</option>
                            <option value="canceled">İptal Edildi</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="appointmentNotes" class="form-label">Notlar</label>
                        <textarea class="form-control" id="appointmentNotes" rows="3"></textarea>
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