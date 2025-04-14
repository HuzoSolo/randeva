<?php
require_once '../includes/config.php';
require_once '../includes/header.php';

// Oturum ve yetki kontrolü
checkLogin();
checkUserType('business');

$page_title = "WhatsApp Menü Yönetimi";

// Eğer yeni bir menü oluşturuluyorsa
$success = "";
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'create') {
    $menu_name = $_POST['menu_name'];
    
    // Veritabanına kayıt işlemi burada yapılacak
    // Şimdilik başarılı kabul edelim
    $success = "Menü başarıyla oluşturuldu!";
}

// Aktif menüleri getir
// Veritabanından çekilecek, şimdilik sabit veriler
$menus = [
    [
        'id' => 1,
        'name' => 'Ana Menü',
        'is_active' => true,
        'created_at' => '2023-05-10 14:30:00'
    ],
    [
        'id' => 2,
        'name' => 'Randevu Menüsü',
        'is_active' => false,
        'created_at' => '2023-05-12 09:15:00'
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
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Menü Listem</h5>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createMenuModal">
                    <i class="bi bi-plus-circle"></i> Yeni Menü Oluştur
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Menü Adı</th>
                                <th>Durum</th>
                                <th>Oluşturulma Tarihi</th>
                                <th>İşlem</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($menus)): ?>
                            <tr>
                                <td colspan="4" class="text-center">Henüz menü oluşturulmamış</td>
                            </tr>
                            <?php else: ?>
                                <?php foreach ($menus as $menu): ?>
                                <tr>
                                    <td><?php echo $menu['name']; ?></td>
                                    <td>
                                        <?php if ($menu['is_active']): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Pasif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $menu['created_at']; ?></td>
                                    <td>
                                        <a href="whatsapp-menu-editor.php?id=<?php echo $menu['id']; ?>" class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil-square"></i> Düzenle
                                        </a>
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteMenuModal" data-menu-id="<?php echo $menu['id']; ?>" data-menu-name="<?php echo $menu['name']; ?>">
                                            <i class="bi bi-trash"></i> Sil
                                        </button>
                                        <?php if (!$menu['is_active']): ?>
                                        <button class="btn btn-success btn-sm">
                                            <i class="bi bi-check-circle"></i> Aktifleştir
                                        </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Yeni Menü Oluşturma Modalı -->
<div class="modal fade" id="createMenuModal" tabindex="-1" aria-labelledby="createMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createMenuModalLabel">Yeni WhatsApp Menüsü Oluştur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="whatsapp-menus.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="menu_name" class="form-label">Menü Adı</label>
                        <input type="text" class="form-control" id="menu_name" name="menu_name" required>
                        <small class="text-muted">Menüyü tanımlayan bir isim yazın. Örn: "Ana Menü", "Randevu Menüsü" vb.</small>
                    </div>
                    <input type="hidden" name="action" value="create">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">Oluştur</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Menü Silme Modalı -->
<div class="modal fade" id="deleteMenuModal" tabindex="-1" aria-labelledby="deleteMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMenuModalLabel">Menüyü Sil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bu menüyü silmek istediğinizden emin misiniz? Bu işlem geri alınamaz!</p>
                <p><strong id="menuNameToDelete"></strong> menüsü silinecek.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                <form action="whatsapp-menus.php" method="POST">
                    <input type="hidden" name="menu_id" id="menuIdToDelete">
                    <input type="hidden" name="action" value="delete">
                    <button type="submit" class="btn btn-danger">Sil</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Silme modalı için veri aktarımı
    const deleteMenuModal = document.getElementById('deleteMenuModal');
    if (deleteMenuModal) {
        deleteMenuModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const menuId = button.getAttribute('data-menu-id');
            const menuName = button.getAttribute('data-menu-name');
            
            document.getElementById('menuIdToDelete').value = menuId;
            document.getElementById('menuNameToDelete').textContent = menuName;
        });
    }
});
</script>

<?php require_once '../includes/footer.php'; ?> 