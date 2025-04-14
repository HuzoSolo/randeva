<?php
require_once '../includes/config.php';
require_once '../includes/header.php';

// Oturum ve yetki kontrolü
checkLogin();
checkUserType('admin');

$page_title = "Sistem Ayarları";
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Sistem Ayarları</h1>
</div>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Ayar Kategorileri</h5>
            </div>
            <div class="list-group list-group-flush">
                <a href="#general" class="list-group-item list-group-item-action active" data-bs-toggle="list">Genel Ayarlar</a>
                <a href="#whatsapp" class="list-group-item list-group-item-action" data-bs-toggle="list">WhatsApp Entegrasyonu</a>
                <a href="#email" class="list-group-item list-group-item-action" data-bs-toggle="list">E-posta Ayarları</a>
                <a href="#notifications" class="list-group-item list-group-item-action" data-bs-toggle="list">Bildirim Ayarları</a>
                <a href="#security" class="list-group-item list-group-item-action" data-bs-toggle="list">Güvenlik Ayarları</a>
            </div>
        </div>
    </div>
    <div class="col-md-9 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="general">
                        <h4 class="mb-3">Genel Ayarlar</h4>
                        <form>
                            <div class="mb-3">
                                <label for="siteName" class="form-label">Site Adı</label>
                                <input type="text" class="form-control" id="siteName" value="Randeva">
                            </div>
                            <div class="mb-3">
                                <label for="siteUrl" class="form-label">Site URL</label>
                                <input type="url" class="form-control" id="siteUrl" value="http://localhost/randeva-php">
                            </div>
                            <div class="mb-3">
                                <label for="adminEmail" class="form-label">Admin E-posta</label>
                                <input type="email" class="form-control" id="adminEmail" value="admin@randeva.com">
                            </div>
                            <div class="mb-3">
                                <label for="timezone" class="form-label">Zaman Dilimi</label>
                                <select class="form-select" id="timezone">
                                    <option value="Europe/Istanbul" selected>Türkiye (Europe/Istanbul)</option>
                                    <option value="Europe/London">Londra (Europe/London)</option>
                                    <option value="America/New_York">New York (America/New_York)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="dateFormat" class="form-label">Tarih Formatı</label>
                                <select class="form-select" id="dateFormat">
                                    <option value="d.m.Y" selected>DD.MM.YYYY (31.12.2023)</option>
                                    <option value="Y-m-d">YYYY-MM-DD (2023-12-31)</option>
                                    <option value="m/d/Y">MM/DD/YYYY (12/31/2023)</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Kaydet</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="whatsapp">
                        <h4 class="mb-3">WhatsApp Entegrasyonu</h4>
                        <form>
                            <div class="mb-3">
                                <label for="whatsappProvider" class="form-label">WhatsApp Sağlayıcı</label>
                                <select class="form-select" id="whatsappProvider">
                                    <option value="twilio" selected>Twilio</option>
                                    <option value="desk360">Desk360</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="whatsappApiKey" class="form-label">API Anahtarı</label>
                                <input type="text" class="form-control" id="whatsappApiKey">
                            </div>
                            <div class="mb-3">
                                <label for="whatsappApiSecret" class="form-label">API Secret</label>
                                <input type="password" class="form-control" id="whatsappApiSecret">
                            </div>
                            <div class="mb-3">
                                <label for="whatsappPhoneNumber" class="form-label">WhatsApp Telefon Numarası</label>
                                <input type="tel" class="form-control" id="whatsappPhoneNumber">
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="enableWhatsapp" checked>
                                <label class="form-check-label" for="enableWhatsapp">WhatsApp Entegrasyonunu Aktif Et</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Kaydet</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="email">
                        <h4 class="mb-3">E-posta Ayarları</h4>
                        <form>
                            <div class="mb-3">
                                <label for="smtpHost" class="form-label">SMTP Host</label>
                                <input type="text" class="form-control" id="smtpHost" value="smtp.example.com">
                            </div>
                            <div class="mb-3">
                                <label for="smtpPort" class="form-label">SMTP Port</label>
                                <input type="number" class="form-control" id="smtpPort" value="587">
                            </div>
                            <div class="mb-3">
                                <label for="smtpUsername" class="form-label">SMTP Kullanıcı Adı</label>
                                <input type="text" class="form-control" id="smtpUsername">
                            </div>
                            <div class="mb-3">
                                <label for="smtpPassword" class="form-label">SMTP Şifre</label>
                                <input type="password" class="form-control" id="smtpPassword">
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="smtpSecure" checked>
                                <label class="form-check-label" for="smtpSecure">Güvenli Bağlantı (SSL/TLS)</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Kaydet</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="notifications">
                        <h4 class="mb-3">Bildirim Ayarları</h4>
                        <form>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="emailNotifications" checked>
                                <label class="form-check-label" for="emailNotifications">E-posta Bildirimleri</label>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="whatsappNotifications" checked>
                                <label class="form-check-label" for="whatsappNotifications">WhatsApp Bildirimleri</label>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="adminNewBusiness">
                                <label class="form-check-label" for="adminNewBusiness">Yeni İşletme Kaydı (Admin Bildirimi)</label>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="adminNewAppointment">
                                <label class="form-check-label" for="adminNewAppointment">Yeni Randevu (Admin Bildirimi)</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Kaydet</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="security">
                        <h4 class="mb-3">Güvenlik Ayarları</h4>
                        <form>
                            <div class="mb-3">
                                <label for="sessionTimeout" class="form-label">Oturum Zaman Aşımı (Dakika)</label>
                                <input type="number" class="form-control" id="sessionTimeout" value="30">
                            </div>
                            <div class="mb-3">
                                <label for="loginAttempts" class="form-label">Maksimum Giriş Denemesi</label>
                                <input type="number" class="form-control" id="loginAttempts" value="5">
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="forceHttps" checked>
                                <label class="form-check-label" for="forceHttps">HTTPS Zorla</label>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="enableCaptcha">
                                <label class="form-check-label" for="enableCaptcha">CAPTCHA Etkinleştir</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Kaydet</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?> 