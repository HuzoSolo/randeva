<?php
require_once '../includes/config.php';
require_once '../includes/header.php';

// Oturum ve yetki kontrolü
checkLogin();
checkUserType('business');

// Menü ID kontrolü
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: whatsapp-menus.php");
    exit();
}

$menu_id = $_GET['id'];

// Veritabanından menü bilgisini çek
// Gerçek projede burada veritabanı sorgusu olacak
$menu = [
    'id' => $menu_id,
    'name' => ($menu_id == 1) ? 'Ana Menü' : 'Randevu Menüsü',
    'is_active' => ($menu_id == 1),
    'structure' => [
        'welcome_message' => 'Merhaba! 👋 Randeva sistemine hoş geldiniz. Lütfen aşağıdaki seçeneklerden birini seçin:',
        'options' => [
            [
                'id' => 1,
                'text' => 'Randevu Al',
                'type' => 'submenu',
                'submenu' => [
                    'message' => 'Hangi hizmet için randevu almak istersiniz?',
                    'options' => [
                        [
                            'id' => 11,
                            'text' => 'Saç Kesimi',
                            'type' => 'action',
                            'action' => 'BOOK_APPOINTMENT',
                            'action_data' => [
                                'service_id' => 1,
                                'service_name' => 'Saç Kesimi'
                            ]
                        ],
                        [
                            'id' => 12,
                            'text' => 'Sakal Tıraşı',
                            'type' => 'action',
                            'action' => 'BOOK_APPOINTMENT',
                            'action_data' => [
                                'service_id' => 2,
                                'service_name' => 'Sakal Tıraşı'
                            ]
                        ],
                        [
                            'id' => 13,
                            'text' => 'Ana Menüye Dön',
                            'type' => 'action',
                            'action' => 'MAIN_MENU'
                        ]
                    ]
                ]
            ],
            [
                'id' => 2,
                'text' => 'Randevularımı Görüntüle',
                'type' => 'action',
                'action' => 'VIEW_APPOINTMENTS'
            ],
            [
                'id' => 3,
                'text' => 'Randevu İptal Et',
                'type' => 'action',
                'action' => 'CANCEL_APPOINTMENT'
            ],
            [
                'id' => 4,
                'text' => 'Yardım',
                'type' => 'action',
                'action' => 'HELP'
            ]
        ]
    ]
];

$page_title = $menu['name'] . " - WhatsApp Menü Düzenleyicisi";

// Menü güncelleme işlemi
$success = "";
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form verilerini işle
    // Gerçek projede burada veritabanı güncelleme sorgusu olacak
    $success = "Menü başarıyla güncellendi!";
}
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

<div class="mb-3">
    <a href="whatsapp-menus.php" class="btn btn-outline-primary btn-sm">
        <i class="bi bi-arrow-left"></i> Menülere Dön
    </a>
</div>

<div class="row">
    <div class="col-lg-5 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title">Menü Önizleme</h5>
                <div>
                    <button class="btn btn-sm btn-outline-success" id="expandAll">
                        <i class="bi bi-arrows-expand"></i> Tümünü Genişlet
                    </button>
                    <button class="btn btn-sm btn-outline-secondary" id="collapseAll">
                        <i class="bi bi-arrows-collapse"></i> Tümünü Daralt
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="menu-preview">
                    <div class="wa-message">
                        <?php echo $menu['structure']['welcome_message']; ?>
                    </div>
                    
                    <ul class="wa-options">
                        <?php foreach ($menu['structure']['options'] as $index => $option): ?>
                        <li class="wa-option" data-option-id="<?php echo $option['id']; ?>">
                            <div>
                                <span class="wa-option-number"><?php echo $index + 1; ?></span>
                                <?php echo $option['text']; ?>
                            </div>
                            <i class="bi bi-chevron-right"></i>
                        </li>
                            <?php if ($option['type'] === 'submenu'): ?>
                            <div class="submenu-preview ps-4 mt-2 mb-3 d-none">
                                <div class="wa-message">
                                    <?php echo $option['submenu']['message']; ?>
                                </div>
                                <ul class="wa-options">
                                    <?php foreach ($option['submenu']['options'] as $subIndex => $subOption): ?>
                                    <li class="wa-option">
                                        <div>
                                            <span class="wa-option-number"><?php echo $subIndex + 1; ?></span>
                                            <?php echo $subOption['text']; ?>
                                        </div>
                                        <i class="bi bi-chevron-right"></i>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-7 mb-4">
        <form action="whatsapp-menu-editor.php?id=<?php echo $menu_id; ?>" method="POST">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title">Menü Düzenleyici</h5>
                    <div>
                        <button type="submit" class="btn btn-sm btn-success">
                            <i class="bi bi-save"></i> Kaydet
                        </button>
                        <button type="button" class="btn btn-sm btn-primary" id="addMenuItemBtn">
                            <i class="bi bi-plus-circle"></i> Yeni Seçenek Ekle
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label for="menuName" class="form-label">Menü Adı</label>
                        <input type="text" class="form-control" id="menuName" name="menu_name" value="<?php echo $menu['name']; ?>" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="welcomeMessage" class="form-label">Karşılama Mesajı</label>
                        <textarea class="form-control" id="welcomeMessage" name="welcome_message" rows="3" required><?php echo $menu['structure']['welcome_message']; ?></textarea>
                        <small class="text-muted">Kullanıcıya gösterilecek karşılama mesajını girin. Emoji kullanabilirsiniz.</small>
                    </div>
                    
                    <div class="menu-editor">
                        <h6 class="mb-3">Menü Seçenekleri</h6>
                        <div id="menuItemsContainer">
                            <?php foreach ($menu['structure']['options'] as $index => $option): ?>
                            <div class="menu-item" data-option-id="<?php echo $option['id']; ?>">
                                <div class="menu-item-header">
                                    <div class="menu-item-title">
                                        <span class="me-2"><?php echo $index + 1; ?>.</span>
                                        <?php echo $option['text']; ?>
                                    </div>
                                    <div class="menu-item-actions">
                                        <button type="button" class="btn btn-sm btn-outline-primary edit-menu-item-btn">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-menu-item-btn">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        <?php if ($option['type'] === 'submenu'): ?>
                                        <button type="button" class="btn btn-sm btn-outline-secondary toggle-submenu-btn">
                                            <i class="bi bi-chevron-down"></i>
                                        </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="menu-item-content">
                                    <div class="badge bg-info mb-1">
                                        <?php echo ($option['type'] === 'submenu') ? 'Alt Menü' : 'Eylem: ' . $option['action']; ?>
                                    </div>
                                    
                                    <?php if ($option['type'] === 'submenu'): ?>
                                    <div class="menu-item-submenu d-none">
                                        <div class="mb-3">
                                            <label class="form-label">Alt Menü Mesajı</label>
                                            <textarea class="form-control form-control-sm" name="submenu_message_<?php echo $option['id']; ?>" rows="2"><?php echo $option['submenu']['message']; ?></textarea>
                                        </div>
                                        
                                        <div class="submenu-items">
                                            <?php foreach ($option['submenu']['options'] as $subIndex => $subOption): ?>
                                            <div class="menu-item nested-menu-item mb-2">
                                                <div class="menu-item-header">
                                                    <div class="menu-item-title">
                                                        <span class="me-2"><?php echo $subIndex + 1; ?>.</span>
                                                        <?php echo $subOption['text']; ?>
                                                    </div>
                                                    <div class="menu-item-actions">
                                                        <button type="button" class="btn btn-sm btn-outline-primary edit-submenu-item-btn">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-danger delete-submenu-item-btn">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="menu-item-content">
                                                    <div class="badge bg-info mb-1">
                                                        Eylem: <?php echo $subOption['action']; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                            
                                            <button type="button" class="btn btn-sm btn-primary add-submenu-item-btn mt-2" data-parent-id="<?php echo $option['id']; ?>">
                                                <i class="bi bi-plus-circle"></i> Alt Seçenek Ekle
                                            </button>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Menü Öğesi Ekleme/Düzenleme Modalı -->
<div class="modal fade" id="menuItemModal" tabindex="-1" aria-labelledby="menuItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="menuItemModalLabel">Menü Öğesi Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="menuItemForm">
                    <input type="hidden" id="menuItemId" value="">
                    <input type="hidden" id="parentMenuItemId" value="">
                    <input type="hidden" id="isSubmenuItem" value="0">
                    
                    <div class="mb-3">
                        <label for="menuItemText" class="form-label">Seçenek Metni</label>
                        <input type="text" class="form-control" id="menuItemText" required>
                        <small class="text-muted">Kullanıcıya gösterilecek seçenek metni. Örn: "Randevu Al", "Yardım" vb.</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="menuItemType" class="form-label">Seçenek Türü</label>
                        <select class="form-select" id="menuItemType">
                            <option value="action">Eylem</option>
                            <option value="submenu">Alt Menü</option>
                        </select>
                    </div>
                    
                    <div id="actionFields">
                        <div class="mb-3">
                            <label for="menuItemAction" class="form-label">Eylem</label>
                            <select class="form-select" id="menuItemAction">
                                <option value="BOOK_APPOINTMENT">Randevu Al</option>
                                <option value="VIEW_APPOINTMENTS">Randevuları Görüntüle</option>
                                <option value="CANCEL_APPOINTMENT">Randevu İptal Et</option>
                                <option value="HELP">Yardım</option>
                                <option value="MAIN_MENU">Ana Menüye Dön</option>
                                <option value="CUSTOM">Özel İşlem</option>
                            </select>
                        </div>
                        
                        <div class="mb-3" id="customActionField" style="display: none;">
                            <label for="menuItemCustomAction" class="form-label">Özel İşlem Kodu</label>
                            <input type="text" class="form-control" id="menuItemCustomAction">
                            <small class="text-muted">Özel işlem kodunu girin.</small>
                        </div>
                    </div>
                    
                    <div id="submenuFields" style="display: none;">
                        <div class="mb-3">
                            <label for="submenuMessage" class="form-label">Alt Menü Mesajı</label>
                            <textarea class="form-control" id="submenuMessage" rows="3"></textarea>
                            <small class="text-muted">Alt menüde kullanıcıya gösterilecek mesaj.</small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                <button type="button" class="btn btn-primary" id="saveMenuItem">Kaydet</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Önizleme etkileşimleri
    const waOptions = document.querySelectorAll('.wa-option');
    waOptions.forEach(option => {
        option.addEventListener('click', function() {
            const optionId = this.getAttribute('data-option-id');
            const submenuPreview = this.nextElementSibling;
            
            if (submenuPreview && submenuPreview.classList.contains('submenu-preview')) {
                submenuPreview.classList.toggle('d-none');
            }
        });
    });
    
    // Tümünü genişlet/daralt
    document.getElementById('expandAll').addEventListener('click', function() {
        document.querySelectorAll('.submenu-preview, .menu-item-submenu').forEach(el => {
            el.classList.remove('d-none');
        });
    });
    
    document.getElementById('collapseAll').addEventListener('click', function() {
        document.querySelectorAll('.submenu-preview, .menu-item-submenu').forEach(el => {
            el.classList.add('d-none');
        });
    });
    
    // Alt menüleri aç/kapat
    document.querySelectorAll('.toggle-submenu-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const menuItem = this.closest('.menu-item');
            const submenu = menuItem.querySelector('.menu-item-submenu');
            
            submenu.classList.toggle('d-none');
            
            // Icon değiştir
            const icon = this.querySelector('i');
            if (icon.classList.contains('bi-chevron-down')) {
                icon.classList.replace('bi-chevron-down', 'bi-chevron-up');
            } else {
                icon.classList.replace('bi-chevron-up', 'bi-chevron-down');
            }
        });
    });
    
    // Menü tipi değiştiğinde
    document.getElementById('menuItemType').addEventListener('change', function() {
        const actionFields = document.getElementById('actionFields');
        const submenuFields = document.getElementById('submenuFields');
        
        if (this.value === 'action') {
            actionFields.style.display = 'block';
            submenuFields.style.display = 'none';
        } else {
            actionFields.style.display = 'none';
            submenuFields.style.display = 'block';
        }
    });
    
    // Eylem türü değiştiğinde
    document.getElementById('menuItemAction').addEventListener('change', function() {
        const customActionField = document.getElementById('customActionField');
        
        if (this.value === 'CUSTOM') {
            customActionField.style.display = 'block';
        } else {
            customActionField.style.display = 'none';
        }
    });
    
    // Yeni öğe ekleme modalını göster
    document.getElementById('addMenuItemBtn').addEventListener('click', function() {
        document.getElementById('menuItemModalLabel').textContent = 'Yeni Menü Öğesi Ekle';
        document.getElementById('menuItemForm').reset();
        document.getElementById('menuItemId').value = '';
        document.getElementById('parentMenuItemId').value = '';
        document.getElementById('isSubmenuItem').value = '0';
        
        document.getElementById('actionFields').style.display = 'block';
        document.getElementById('submenuFields').style.display = 'none';
        document.getElementById('customActionField').style.display = 'none';
        
        const menuItemModal = new bootstrap.Modal(document.getElementById('menuItemModal'));
        menuItemModal.show();
    });
    
    // Alt menü öğesi ekleme butonları
    document.querySelectorAll('.add-submenu-item-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('menuItemModalLabel').textContent = 'Yeni Alt Menü Öğesi Ekle';
            document.getElementById('menuItemForm').reset();
            document.getElementById('menuItemId').value = '';
            document.getElementById('parentMenuItemId').value = this.getAttribute('data-parent-id');
            document.getElementById('isSubmenuItem').value = '1';
            
            // Alt menü öğeleri sadece eylem olabilir
            document.getElementById('menuItemType').value = 'action';
            document.getElementById('menuItemType').disabled = true;
            document.getElementById('actionFields').style.display = 'block';
            document.getElementById('submenuFields').style.display = 'none';
            document.getElementById('customActionField').style.display = 'none';
            
            const menuItemModal = new bootstrap.Modal(document.getElementById('menuItemModal'));
            menuItemModal.show();
        });
    });
    
    // Menü öğesi düzenleme
    document.querySelectorAll('.edit-menu-item-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const menuItem = this.closest('.menu-item');
            const menuItemId = menuItem.getAttribute('data-option-id');
            const menuItemTitle = menuItem.querySelector('.menu-item-title').textContent.trim().split('.')[1].trim();
            
            document.getElementById('menuItemModalLabel').textContent = 'Menü Öğesini Düzenle';
            document.getElementById('menuItemId').value = menuItemId;
            document.getElementById('menuItemText').value = menuItemTitle;
            
            // Burada gerçek projede API'den öğe detaylarını alıp form alanlarını dolduracaksınız
            
            const menuItemModal = new bootstrap.Modal(document.getElementById('menuItemModal'));
            menuItemModal.show();
        });
    });
    
    // Alt menü öğesi düzenleme
    document.querySelectorAll('.edit-submenu-item-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const menuItem = this.closest('.menu-item');
            // Gerçek projede burada alt menü öğesi id'si ve parent id'si alınacak
            
            document.getElementById('menuItemModalLabel').textContent = 'Alt Menü Öğesini Düzenle';
            document.getElementById('isSubmenuItem').value = '1';
            
            // Alt menü öğeleri sadece eylem olabilir
            document.getElementById('menuItemType').value = 'action';
            document.getElementById('menuItemType').disabled = true;
            document.getElementById('actionFields').style.display = 'block';
            document.getElementById('submenuFields').style.display = 'none';
            
            // Burada gerçek projede API'den öğe detaylarını alıp form alanlarını dolduracaksınız
            
            const menuItemModal = new bootstrap.Modal(document.getElementById('menuItemModal'));
            menuItemModal.show();
        });
    });
    
    // Öğe kaydetme işlevi
    document.getElementById('saveMenuItem').addEventListener('click', function() {
        // Burada form verilerini alıp işlemleri gerçekleştireceksiniz
        // Gerçek projede AJAX ile API'ye göndereceksiniz
        
        // Örnek olarak modal'ı kapat
        const menuItemModal = bootstrap.Modal.getInstance(document.getElementById('menuItemModal'));
        menuItemModal.hide();
        
        // Başarı mesajı göster
        alert('Değişiklikler kaydedildi! (Bu bir demo mesajıdır)');
    });
});
</script>

<?php require_once '../includes/footer.php'; ?> 