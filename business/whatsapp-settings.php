<?php
require_once '../includes/config.php';
require_once '../includes/header.php';

// Oturum ve yetki kontrolü
checkLogin();
checkUserType('business');

$page_title = "WhatsApp Ayarları";

// Ayarları güncelleme işlemi
$success = "";
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form verilerini işle
    // Gerçek projede burada veritabanı güncelleme sorgusu olacak
    $success = "WhatsApp ayarları başarıyla güncellendi!";
}

// Mevcut ayarları getir
// Gerçek projede veritabanından alınacak
$settings = [
    'whatsapp_number' => '+905551234567',
    'auto_reply' => true,
    'working_hours' => [
        'monday' => ['09:00', '18:00', true],
        'tuesday' => ['09:00', '18:00', true],
        'wednesday' => ['09:00', '18:00', true],
        'thursday' => ['09:00', '18:00', true],
        'friday' => ['09:00', '18:00', true],
        'saturday' => ['10:00', '15:00', true],
        'sunday' => ['00:00', '00:00', false]
    ],
    'offline_message' => 'Şu anda müsait değiliz. Mesaj bırakabilirsiniz, en kısa sürede size dönüş yapacağız.',
    'welcome_message' => 'Merhaba! 👋 [İşletme Adı] WhatsApp hattına hoş geldiniz. Size nasıl yardımcı olabiliriz?',
    'notification_preferences' => [
        'new_appointment' => true,
        'appointment_reminder' => true,
        'appointment_cancelled' => true,
        'business_messages' => true
    ]
];
?>

<?php if (!empty($success)): ?>
<div class="alert alert-success">
    <i class="bi bi-check-circle me-2"></i> <?php echo $success; ?>
</div>
<?php endif; ?>

<?php if (!empty($error)): ?>
<div class="alert alert-danger">
    <i class="bi bi-exclamation-triangle me-2"></i> <?php echo $error; ?>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">WhatsApp Ayarları</h5>
            </div>
            <div class="list-group list-group-flush">
                <a href="#generalSettings" class="list-group-item list-group-item-action active" data-bs-toggle="list">Genel Ayarlar</a>
                <a href="#workingHours" class="list-group-item list-group-item-action" data-bs-toggle="list">Çalışma Saatleri</a>
                <a href="#messages" class="list-group-item list-group-item-action" data-bs-toggle="list">Mesaj Ayarları</a>
                <a href="#notifications" class="list-group-item list-group-item-action" data-bs-toggle="list">Bildirim Ayarları</a>
                <a href="#webhook" class="list-group-item list-group-item-action" data-bs-toggle="list">Webhook Entegrasyonu</a>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-whatsapp text-success" style="font-size: 2.5rem;"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">WhatsApp Durumu</h6>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-success me-2">Bağlı</span>
                            <small class="text-muted">Son Kontrol: Bugün 14:25</small>
                        </div>
                    </div>
                </div>
                <hr>
                <p class="mb-2 small"><i class="bi bi-info-circle me-1"></i> WhatsApp Business API entegrasyonu aktif.</p>
                <button class="btn btn-outline-danger btn-sm w-100">
                    <i class="bi bi-power"></i> Bağlantıyı Kes
                </button>
            </div>
        </div>
    </div>
    
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-body">
                <form action="whatsapp-settings.php" method="POST">
                    <div class="tab-content">
                        <!-- Genel Ayarlar -->
                        <div class="tab-pane fade show active" id="generalSettings">
                            <h4 class="mb-3">Genel Ayarlar</h4>
                            
                            <div class="mb-3">
                                <label for="whatsappNumber" class="form-label">WhatsApp Numarası</label>
                                <input type="text" class="form-control" id="whatsappNumber" name="whatsapp_number" value="<?php echo $settings['whatsapp_number']; ?>" required>
                                <small class="text-muted">Uluslararası formatta girin. Örn: +90xxxxxxxxxx</small>
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="autoReply" name="auto_reply" <?php echo $settings['auto_reply'] ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="autoReply">Otomatik Yanıt Etkinleştir</label>
                                <small class="d-block text-muted">Etkinleştirildiğinde, gelen mesajlara otomatik yanıt gönderilir.</small>
                            </div>
                            
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Kaydet</button>
                            </div>
                        </div>
                        
                        <!-- Çalışma Saatleri -->
                        <div class="tab-pane fade" id="workingHours">
                            <h4 class="mb-3">Çalışma Saatleri</h4>
                            <p class="text-muted mb-4">Çalışma saatleri dışında otomatik yanıt mesajı gönderilecektir.</p>
                            
                            <?php 
                            $days = [
                                'monday' => 'Pazartesi',
                                'tuesday' => 'Salı',
                                'wednesday' => 'Çarşamba',
                                'thursday' => 'Perşembe',
                                'friday' => 'Cuma',
                                'saturday' => 'Cumartesi',
                                'sunday' => 'Pazar'
                            ];
                            
                            foreach ($days as $day_key => $day_name): 
                                $hours = $settings['working_hours'][$day_key];
                            ?>
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input day-active" id="<?php echo $day_key; ?>_active" name="working_hours[<?php echo $day_key; ?>][active]" data-day="<?php echo $day_key; ?>" <?php echo $hours[2] ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="<?php echo $day_key; ?>_active"><?php echo $day_name; ?></label>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="time" class="form-control time-input" id="<?php echo $day_key; ?>_start" name="working_hours[<?php echo $day_key; ?>][start]" value="<?php echo $hours[0]; ?>" <?php echo !$hours[2] ? 'disabled' : ''; ?>>
                                        </div>
                                        <div class="col-6">
                                            <input type="time" class="form-control time-input" id="<?php echo $day_key; ?>_end" name="working_hours[<?php echo $day_key; ?>][end]" value="<?php echo $hours[1]; ?>" <?php echo !$hours[2] ? 'disabled' : ''; ?>>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Kaydet</button>
                            </div>
                        </div>
                        
                        <!-- Mesaj Ayarları -->
                        <div class="tab-pane fade" id="messages">
                            <h4 class="mb-3">Mesaj Ayarları</h4>
                            
                            <div class="mb-4">
                                <label for="welcomeMessage" class="form-label">Karşılama Mesajı</label>
                                <textarea class="form-control" id="welcomeMessage" name="welcome_message" rows="3" required><?php echo $settings['welcome_message']; ?></textarea>
                                <small class="text-muted">Kullanıcı ilk mesajını gönderdiğinde iletilecek karşılama mesajı. [İşletme Adı] gibi yer tutucular kullanabilirsiniz.</small>
                            </div>
                            
                            <div class="mb-4">
                                <label for="offlineMessage" class="form-label">Çalışma Saatleri Dışı Mesajı</label>
                                <textarea class="form-control" id="offlineMessage" name="offline_message" rows="3" required><?php echo $settings['offline_message']; ?></textarea>
                                <small class="text-muted">Çalışma saatleri dışında kullanıcıya gönderilecek mesaj.</small>
                            </div>
                            
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Kaydet</button>
                            </div>
                        </div>
                        
                        <!-- Bildirim Ayarları -->
                        <div class="tab-pane fade" id="notifications">
                            <h4 class="mb-3">Bildirim Ayarları</h4>
                            <p class="text-muted mb-4">Hangi durumlarda bildirim almak istediğinizi seçin.</p>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="notifyNewAppointment" name="notification_preferences[new_appointment]" <?php echo $settings['notification_preferences']['new_appointment'] ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="notifyNewAppointment">Yeni Randevu Oluşturulduğunda</label>
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="notifyAppointmentReminder" name="notification_preferences[appointment_reminder]" <?php echo $settings['notification_preferences']['appointment_reminder'] ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="notifyAppointmentReminder">Randevu Hatırlatmaları</label>
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="notifyCancelled" name="notification_preferences[appointment_cancelled]" <?php echo $settings['notification_preferences']['appointment_cancelled'] ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="notifyCancelled">Randevu İptal Edildiğinde</label>
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="notifyMessages" name="notification_preferences[business_messages]" <?php echo $settings['notification_preferences']['business_messages'] ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="notifyMessages">Yeni Mesajlar</label>
                            </div>
                            
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Kaydet</button>
                            </div>
                        </div>
                        
                        <!-- Webhook Entegrasyonu -->
                        <div class="tab-pane fade" id="webhook">
                            <h4 class="mb-3">Webhook Entegrasyonu</h4>
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i> Webhook entegrasyonu, WhatsApp'tan gelen bildirimleri kendi sisteminize iletmenizi sağlar.
                            </div>
                            
                            <div class="mb-3">
                                <label for="webhookUrl" class="form-label">Webhook URL</label>
                                <input type="url" class="form-control" id="webhookUrl" name="webhook_url" value="https://yourdomain.com/api/webhook">
                                <small class="text-muted">WhatsApp olaylarının bildirileceği URL adresi.</small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="webhookSecret" class="form-label">Webhook Güvenlik Anahtarı</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="webhookSecret" name="webhook_secret" value="87a6d8s76as98d7sa6">
                                    <button class="btn btn-outline-secondary" type="button" id="generateSecret">Yenile</button>
                                </div>
                                <small class="text-muted">Webhook isteklerinin doğruluğunu kontrol etmek için kullanılır.</small>
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="webhookActive" name="webhook_active" checked>
                                <label class="form-check-label" for="webhookActive">Webhook Aktif</label>
                            </div>
                            
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Kaydet</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Çalışma saatleri için etkinleştirme/devre dışı bırakma
    const dayActiveCheckboxes = document.querySelectorAll('.day-active');
    
    dayActiveCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const day = this.getAttribute('data-day');
            const startTimeInput = document.getElementById(`${day}_start`);
            const endTimeInput = document.getElementById(`${day}_end`);
            
            if (this.checked) {
                startTimeInput.disabled = false;
                endTimeInput.disabled = false;
            } else {
                startTimeInput.disabled = true;
                endTimeInput.disabled = true;
            }
        });
    });
    
    // Webhook güvenlik anahtarı oluşturma
    document.getElementById('generateSecret').addEventListener('click', function() {
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let result = '';
        const length = 24;
        
        for (let i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * characters.length));
        }
        
        document.getElementById('webhookSecret').value = result;
    });
});
</script>

<?php require_once '../includes/footer.php'; ?> 