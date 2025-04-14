<?php
require_once '../includes/config.php';
require_once '../includes/header.php';

// Oturum ve yetki kontrolü
checkLogin();
checkUserType('business');

$page_title = "İşletme Ayarları";
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">İşletme Ayarları</h1>
</div>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Ayar Kategorileri</h5>
            </div>
            <div class="list-group list-group-flush">
                <a href="#profile" class="list-group-item list-group-item-action active" data-bs-toggle="list">Profil Bilgileri</a>
                <a href="#business-hours" class="list-group-item list-group-item-action" data-bs-toggle="list">Çalışma Saatleri</a>
                <a href="#services" class="list-group-item list-group-item-action" data-bs-toggle="list">Hizmetler</a>
                <a href="#whatsapp" class="list-group-item list-group-item-action" data-bs-toggle="list">WhatsApp Ayarları</a>
                <a href="#notifications" class="list-group-item list-group-item-action" data-bs-toggle="list">Bildirim Ayarları</a>
            </div>
        </div>
    </div>
    <div class="col-md-9 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="profile">
                        <h4 class="mb-3">Profil Bilgileri</h4>
                        <form>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="businessName" class="form-label">İşletme Adı</label>
                                    <input type="text" class="form-control" id="businessName" value="Örnek İşletme">
                                </div>
                                <div class="col-md-6">
                                    <label for="ownerName" class="form-label">İşletme Sahibi</label>
                                    <input type="text" class="form-control" id="ownerName" value="Ahmet Yılmaz">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="businessPhone" class="form-label">Telefon</label>
                                    <input type="tel" class="form-control" id="businessPhone" value="0555 123 4567">
                                </div>
                                <div class="col-md-6">
                                    <label for="businessEmail" class="form-label">E-posta</label>
                                    <input type="email" class="form-control" id="businessEmail" value="info@ornek.com">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="businessAddress" class="form-label">Adres</label>
                                <textarea class="form-control" id="businessAddress" rows="3">Örnek Mahallesi, Örnek Caddesi No:123, İstanbul</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="businessDescription" class="form-label">İşletme Açıklaması</label>
                                <textarea class="form-control" id="businessDescription" rows="3">Örnek işletme açıklaması burada yer alacak.</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Kaydet</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="business-hours">
                        <h4 class="mb-3">Çalışma Saatleri</h4>
                        <form>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Gün</th>
                                            <th>Açılış</th>
                                            <th>Kapanış</th>
                                            <th>Kapalı</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Pazartesi</td>
                                            <td><input type="time" class="form-control" value="09:00"></td>
                                            <td><input type="time" class="form-control" value="18:00"></td>
                                            <td><input type="checkbox" class="form-check-input"></td>
                                        </tr>
                                        <tr>
                                            <td>Salı</td>
                                            <td><input type="time" class="form-control" value="09:00"></td>
                                            <td><input type="time" class="form-control" value="18:00"></td>
                                            <td><input type="checkbox" class="form-check-input"></td>
                                        </tr>
                                        <tr>
                                            <td>Çarşamba</td>
                                            <td><input type="time" class="form-control" value="09:00"></td>
                                            <td><input type="time" class="form-control" value="18:00"></td>
                                            <td><input type="checkbox" class="form-check-input"></td>
                                        </tr>
                                        <tr>
                                            <td>Perşembe</td>
                                            <td><input type="time" class="form-control" value="09:00"></td>
                                            <td><input type="time" class="form-control" value="18:00"></td>
                                            <td><input type="checkbox" class="form-check-input"></td>
                                        </tr>
                                        <tr>
                                            <td>Cuma</td>
                                            <td><input type="time" class="form-control" value="09:00"></td>
                                            <td><input type="time" class="form-control" value="18:00"></td>
                                            <td><input type="checkbox" class="form-check-input"></td>
                                        </tr>
                                        <tr>
                                            <td>Cumartesi</td>
                                            <td><input type="time" class="form-control" value="10:00"></td>
                                            <td><input type="time" class="form-control" value="16:00"></td>
                                            <td><input type="checkbox" class="form-check-input"></td>
                                        </tr>
                                        <tr>
                                            <td>Pazar</td>
                                            <td><input type="time" class="form-control" disabled></td>
                                            <td><input type="time" class="form-control" disabled></td>
                                            <td><input type="checkbox" class="form-check-input" checked></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button type="submit" class="btn btn-primary">Kaydet</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="services">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4>Hizmetler</h4>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                                <i class="bi bi-plus-circle"></i> Yeni Hizmet Ekle
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Hizmet Adı</th>
                                        <th>Süre (dk)</th>
                                        <th>Fiyat (₺)</th>
                                        <th>Durum</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Saç Kesimi</td>
                                        <td>30</td>
                                        <td>100</td>
                                        <td><span class="badge bg-success">Aktif</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-info"><i class="bi bi-pencil"></i></button>
                                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sakal Tıraşı</td>
                                        <td>15</td>
                                        <td>50</td>
                                        <td><span class="badge bg-success">Aktif</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-info"><i class="bi bi-pencil"></i></button>
                                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Saç Boyama</td>
                                        <td>60</td>
                                        <td>200</td>
                                        <td><span class="badge bg-danger">Pasif</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-info"><i class="bi bi-pencil"></i></button>
                                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="whatsapp">
                        <h4 class="mb-3">WhatsApp Ayarları</h4>
                        <form>
                            <div class="mb-3">
                                <label for="whatsappPhone" class="form-label">WhatsApp Telefon Numarası</label>
                                <input type="tel" class="form-control" id="whatsappPhone" value="05551234567">
                            </div>
                            <div class="mb-3">
                                <label for="welcomeMessage" class="form-label">Karşılama Mesajı</label>
                                <textarea class="form-control" id="welcomeMessage" rows="3">Merhaba, [İşletme] randevu sistemine hoş geldiniz. Size nasıl yardımcı olabiliriz?</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="confirmMessage" class="form-label">Randevu Onay Mesajı</label>
                                <textarea class="form-control" id="confirmMessage" rows="3">Merhaba [Müşteri], [Tarih] tarihinde saat [Saat] için [Hizmet] randevunuz onaylanmıştır. Teşekkür ederiz.</textarea>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="enableReminders" checked>
                                <label class="form-check-label" for="enableReminders">Randevu Hatırlatmaları Gönder</label>
                            </div>
                            <div class="mb-3">
                                <label for="reminderTime" class="form-label">Hatırlatma Zamanı (Saat Önce)</label>
                                <input type="number" class="form-control" id="reminderTime" value="24">
                            </div>
                            <button type="submit" class="btn btn-primary">Kaydet</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="notifications">
                        <h4 class="mb-3">Bildirim Ayarları</h4>
                        <form>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="newAppointmentNotify" checked>
                                <label class="form-check-label" for="newAppointmentNotify">Yeni Randevu Bildirimleri</label>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="cancelAppointmentNotify" checked>
                                <label class="form-check-label" for="cancelAppointmentNotify">İptal Edilen Randevu Bildirimleri</label>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="dailySummary" checked>
                                <label class="form-check-label" for="dailySummary">Günlük Özet Bildirimi</label>
                            </div>
                            <div class="mb-3">
                                <label for="dailySummaryTime" class="form-label">Günlük Özet Gönderim Saati</label>
                                <input type="time" class="form-control" id="dailySummaryTime" value="20:00">
                            </div>
                            <button type="submit" class="btn btn-primary">Kaydet</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Yeni Hizmet Ekle Modal -->
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addServiceModalLabel">Yeni Hizmet Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="serviceName" class="form-label">Hizmet Adı</label>
                        <input type="text" class="form-control" id="serviceName" required>
                    </div>
                    <div class="mb-3">
                        <label for="serviceDuration" class="form-label">Süre (Dakika)</label>
                        <input type="number" class="form-control" id="serviceDuration" required>
                    </div>
                    <div class="mb-3">
                        <label for="servicePrice" class="form-label">Fiyat (₺)</label>
                        <input type="number" class="form-control" id="servicePrice" required>
                    </div>
                    <div class="mb-3">
                        <label for="serviceDescription" class="form-label">Açıklama</label>
                        <textarea class="form-control" id="serviceDescription" rows="3"></textarea>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="serviceActive" checked>
                        <label class="form-check-label" for="serviceActive">Aktif</label>
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