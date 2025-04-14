<?php
require_once '../includes/config.php';
require_once '../includes/header.php';

// Oturum ve yetki kontrolü
checkLogin();
checkUserType('business');

$page_title = "Mesaj Geçmişi";

// Müşteri listesini getir
// Gerçek projede veritabanından alınacak
$customers = [
    [
        'id' => 1,
        'name' => 'Ahmet Yılmaz',
        'phone' => '+905551234567',
        'avatar' => 'https://randomuser.me/api/portraits/men/1.jpg',
        'last_message' => 'Randevumu iptal etmek istiyorum.',
        'last_message_time' => '14:25',
        'unread' => 2,
        'online' => true
    ],
    [
        'id' => 2,
        'name' => 'Ayşe Demir',
        'phone' => '+905551234568',
        'avatar' => 'https://randomuser.me/api/portraits/women/1.jpg',
        'last_message' => 'Teşekkür ederim, randevumun saatini aldım.',
        'last_message_time' => '12:40',
        'unread' => 0,
        'online' => false
    ],
    [
        'id' => 3,
        'name' => 'Mehmet Kaya',
        'phone' => '+905551234569',
        'avatar' => 'https://randomuser.me/api/portraits/men/2.jpg',
        'last_message' => 'Yarınki randevu için uygun musunuz?',
        'last_message_time' => 'Dün',
        'unread' => 0,
        'online' => false
    ],
    [
        'id' => 4,
        'name' => 'Zeynep Şahin',
        'phone' => '+905551234570',
        'avatar' => 'https://randomuser.me/api/portraits/women/2.jpg',
        'last_message' => 'Size nasıl ulaşabilirim?',
        'last_message_time' => '10.05.2023',
        'unread' => 0,
        'online' => false
    ]
];

// Aktif müşteri
$active_customer = isset($_GET['customer_id']) ? intval($_GET['customer_id']) : 1;

// Aktif müşterinin mesajlarını getir
// Gerçek projede veritabanından alınacak
$active_customer_data = $customers[0]; // Default olarak ilk müşteri
foreach ($customers as $customer) {
    if ($customer['id'] === $active_customer) {
        $active_customer_data = $customer;
        break;
    }
}

// Mesaj geçmişini getir
// Gerçek projede veritabanından alınacak
$messages = [
    [
        'id' => 1,
        'customer_id' => 1,
        'content' => 'Merhaba, yarın için bir randevu alabilir miyim?',
        'timestamp' => '2023-05-10 09:30:00',
        'is_customer' => true
    ],
    [
        'id' => 2,
        'customer_id' => 1,
        'content' => 'Merhaba, elbette. Yarın saat 14:00 müsait. Uygun mu?',
        'timestamp' => '2023-05-10 09:35:00',
        'is_customer' => false
    ],
    [
        'id' => 3,
        'customer_id' => 1,
        'content' => 'Evet, 14:00 mükemmel olur. Teşekkürler!',
        'timestamp' => '2023-05-10 09:40:00',
        'is_customer' => true
    ],
    [
        'id' => 4,
        'customer_id' => 1,
        'content' => 'Randevunuz oluşturuldu. Yarın saat 14:00\'te görüşmek üzere!',
        'timestamp' => '2023-05-10 09:41:00',
        'is_customer' => false
    ],
    [
        'id' => 5,
        'customer_id' => 1,
        'content' => 'Randevumu iptal etmek istiyorum.',
        'timestamp' => '2023-05-10 14:25:00',
        'is_customer' => true
    ]
];

// Sadece aktif müşterinin mesajlarını filtrele
$filtered_messages = array_filter($messages, function($message) use ($active_customer) {
    return $message['customer_id'] === $active_customer;
});

// Yeni mesaj gönderimi
$success = "";
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'send_message') {
    $message_content = $_POST['message_content'];
    $customer_id = $_POST['customer_id'];
    
    // Gerçek projede veritabanına kayıt işlemi burada yapılacak
    // Şimdilik başarılı kabul edelim
    $success = "Mesaj gönderildi!";
}
?>

<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="card">
            <div class="card-body p-0">
                <div class="row g-0">
                    <!-- Sol Panel - Müşteri Listesi -->
                    <div class="col-md-4 col-lg-3 border-end">
                        <div class="p-3 border-bottom">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Müşteri Ara..." id="searchCustomer">
                                <button class="btn btn-outline-secondary" type="button" id="refreshCustomers">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </button>
                            </div>
                        </div>
                        <div class="customer-list overflow-auto" style="height: calc(100vh - 280px);">
                            <?php foreach ($customers as $customer): ?>
                            <a href="?customer_id=<?php echo $customer['id']; ?>" class="customer-item d-flex align-items-center p-3 border-bottom text-decoration-none <?php echo $customer['id'] === $active_customer ? 'bg-light' : ''; ?>">
                                <div class="position-relative me-3">
                                    <img src="<?php echo $customer['avatar']; ?>" alt="<?php echo $customer['name']; ?>" class="rounded-circle" width="48" height="48">
                                    <?php if ($customer['online']): ?>
                                    <span class="position-absolute bottom-0 end-0 bg-success rounded-circle p-1" style="width: 12px; height: 12px;"></span>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 text-truncate"><?php echo $customer['name']; ?></h6>
                                        <small class="text-muted ms-2"><?php echo $customer['last_message_time']; ?></small>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="mb-0 text-muted small text-truncate"><?php echo $customer['last_message']; ?></p>
                                        <?php if ($customer['unread'] > 0): ?>
                                        <span class="badge bg-primary rounded-pill ms-2"><?php echo $customer['unread']; ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <!-- Sağ Panel - Mesaj İçerikleri -->
                    <div class="col-md-8 col-lg-9">
                        <!-- Müşteri Bilgisi -->
                        <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="<?php echo $active_customer_data['avatar']; ?>" alt="<?php echo $active_customer_data['name']; ?>" class="rounded-circle me-3" width="48" height="48">
                                <div>
                                    <h5 class="mb-0"><?php echo $active_customer_data['name']; ?></h5>
                                    <p class="mb-0 text-muted small"><?php echo $active_customer_data['phone']; ?></p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <a href="#" class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#customerInfoModal">
                                    <i class="bi bi-info-circle"></i> Bilgi
                                </a>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="messageActionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="messageActionsDropdown">
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-telephone"></i> Ara</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-calendar-plus"></i> Randevu Oluştur</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash"></i> Sohbeti Sil</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Mesaj Alanı -->
                        <div class="messages-area p-3 overflow-auto" style="height: calc(100vh - 380px); background-color: #f5f6fa;">
                            <?php 
                            $current_date = '';
                            foreach ($filtered_messages as $message): 
                                $message_date = date('Y-m-d', strtotime($message['timestamp']));
                                $display_date = date('d F Y', strtotime($message['timestamp']));
                                $message_time = date('H:i', strtotime($message['timestamp']));
                                
                                // Tarih ayracı ekle
                                if ($current_date != $message_date):
                                    $current_date = $message_date;
                            ?>
                            <div class="message-date-separator text-center my-3">
                                <span class="badge bg-secondary"><?php echo $display_date; ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <div class="message-item mb-3 <?php echo $message['is_customer'] ? 'message-customer' : 'message-business'; ?>">
                                <div class="d-flex <?php echo $message['is_customer'] ? '' : 'flex-row-reverse'; ?>">
                                    <div class="message-bubble p-3 rounded-3 <?php echo $message['is_customer'] ? 'bg-white' : 'bg-primary text-white'; ?>" style="max-width: 75%;">
                                        <p class="mb-0"><?php echo $message['content']; ?></p>
                                        <small class="d-block text-end mt-1 <?php echo $message['is_customer'] ? 'text-muted' : 'text-white-50'; ?>"><?php echo $message_time; ?></small>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- Mesaj Gönderme Alanı -->
                        <div class="p-3 border-top">
                            <form action="messages.php?customer_id=<?php echo $active_customer; ?>" method="POST" id="messageForm" class="d-flex align-items-center">
                                <div class="dropdown me-2">
                                    <button class="btn btn-outline-secondary" type="button" id="quickResponseDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-lightning"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="quickResponseDropdown">
                                        <li><h6 class="dropdown-header">Hızlı Yanıtlar</h6></li>
                                        <li><a class="dropdown-item quick-response" href="#">Merhaba, size nasıl yardımcı olabilirim?</a></li>
                                        <li><a class="dropdown-item quick-response" href="#">Teşekkür ederim, iyi günler dilerim.</a></li>
                                        <li><a class="dropdown-item quick-response" href="#">Randevunuz onaylanmıştır.</a></li>
                                        <li><a class="dropdown-item quick-response" href="#">Özür dileriz, belirttiğiniz saatte müsait değiliz. Alternatif bir saat önerebilir misiniz?</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#quickResponseManagerModal"><i class="bi bi-gear"></i> Hızlı Yanıtları Yönet</a></li>
                                    </ul>
                                </div>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="messageContent" name="message_content" placeholder="Mesajınızı yazın..." required>
                                    <button class="btn btn-primary" type="submit" id="sendMessage">
                                        <i class="bi bi-send"></i>
                                    </button>
                                </div>
                                <input type="hidden" name="customer_id" value="<?php echo $active_customer; ?>">
                                <input type="hidden" name="action" value="send_message">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Müşteri Bilgileri Modalı -->
<div class="modal fade" id="customerInfoModal" tabindex="-1" aria-labelledby="customerInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customerInfoModalLabel">Müşteri Bilgileri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <img src="<?php echo $active_customer_data['avatar']; ?>" alt="<?php echo $active_customer_data['name']; ?>" class="rounded-circle" width="100" height="100">
                    <h4 class="mt-2 mb-0"><?php echo $active_customer_data['name']; ?></h4>
                    <p class="text-muted"><?php echo $active_customer_data['phone']; ?></p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="#" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-telephone"></i> Ara
                        </a>
                        <a href="#" class="btn btn-outline-success btn-sm">
                            <i class="bi bi-whatsapp"></i> WhatsApp
                        </a>
                        <a href="#" class="btn btn-outline-info btn-sm">
                            <i class="bi bi-calendar-plus"></i> Randevu
                        </a>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h6>Müşteri Detayları</h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <th>E-posta</th>
                                    <td>ahmet.yilmaz@example.com</td>
                                </tr>
                                <tr>
                                    <th>Kayıt Tarihi</th>
                                    <td>10.04.2023</td>
                                </tr>
                                <tr>
                                    <th>Son Randevu</th>
                                    <td>08.05.2023 - 14:00</td>
                                </tr>
                                <tr>
                                    <th>Toplam Randevu</th>
                                    <td>5</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div>
                    <h6>Notlar</h6>
                    <textarea class="form-control" rows="3" placeholder="Müşteri hakkında notlar..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-primary">Kaydet</button>
            </div>
        </div>
    </div>
</div>

<!-- Hızlı Yanıt Yönetimi Modalı -->
<div class="modal fade" id="quickResponseManagerModal" tabindex="-1" aria-labelledby="quickResponseManagerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quickResponseManagerModalLabel">Hızlı Yanıtları Yönet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="quickResponseText" class="form-label">Yeni Hızlı Yanıt</label>
                    <textarea class="form-control" id="quickResponseText" rows="3"></textarea>
                </div>
                <button type="button" class="btn btn-primary mb-4">Ekle</button>
                
                <h6>Mevcut Hızlı Yanıtlar</h6>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Merhaba, size nasıl yardımcı olabilirim?
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Teşekkür ederim, iyi günler dilerim.
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Randevunuz onaylanmıştır.
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Özür dileriz, belirttiğiniz saatte müsait değiliz. Alternatif bir saat önerebilir misiniz?
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hızlı yanıtları mesaj kutusuna ekle
    const quickResponses = document.querySelectorAll('.quick-response');
    const messageContent = document.getElementById('messageContent');
    
    quickResponses.forEach(response => {
        response.addEventListener('click', function(e) {
            e.preventDefault();
            messageContent.value = this.textContent;
            messageContent.focus();
        });
    });
    
    // Müşteri arama
    const searchCustomer = document.getElementById('searchCustomer');
    const customerItems = document.querySelectorAll('.customer-item');
    
    searchCustomer.addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        
        customerItems.forEach(item => {
            const customerName = item.querySelector('h6').textContent.toLowerCase();
            
            if (customerName.indexOf(searchValue) > -1) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });
    
    // Mesaj formunu gönderme
    const messageForm = document.getElementById('messageForm');
    
    messageForm.addEventListener('submit', function(e) {
        // Bu örnek için gerçek form gönderimini engelliyoruz
        // Gerçek projede bu kısım kaldırılabilir
        e.preventDefault();
        
        // Mesajı ekle
        const messagesArea = document.querySelector('.messages-area');
        const newMessage = document.createElement('div');
        newMessage.className = 'message-item mb-3 message-business';
        newMessage.innerHTML = `
            <div class="d-flex flex-row-reverse">
                <div class="message-bubble p-3 rounded-3 bg-primary text-white" style="max-width: 75%;">
                    <p class="mb-0">${messageContent.value}</p>
                    <small class="d-block text-end mt-1 text-white-50">${new Date().getHours()}:${String(new Date().getMinutes()).padStart(2, '0')}</small>
                </div>
            </div>
        `;
        messagesArea.appendChild(newMessage);
        
        // Mesaj alanını temizle
        messageContent.value = '';
        
        // Mesaj alanını alta kaydır
        messagesArea.scrollTop = messagesArea.scrollHeight;
    });
    
    // Sayfa yüklendiğinde mesaj alanını alta kaydır
    const messagesArea = document.querySelector('.messages-area');
    messagesArea.scrollTop = messagesArea.scrollHeight;
});
</script>

<?php require_once '../includes/footer.php'; ?> 