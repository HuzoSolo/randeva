<?php
require_once '../includes/config.php';
require_once '../includes/header.php';

// Oturum ve yetki kontrolü
checkLogin();
checkUserType('business');

$page_title = "Müşteriler";

// Örnek veri - gerçek projede veritabanından çekilecek
$customers = [
    [
        'id' => 1,
        'name' => 'Ahmet Yılmaz',
        'phone' => '+905551234567',
        'email' => 'ahmet.yilmaz@example.com',
        'created_at' => '2023-02-15',
        'last_appointment' => '2023-05-10',
        'appointment_count' => 4,
        'status' => 'active'
    ],
    [
        'id' => 2,
        'name' => 'Ayşe Demir',
        'phone' => '+905551234568',
        'email' => 'ayse.demir@example.com',
        'created_at' => '2023-03-20',
        'last_appointment' => '2023-05-05',
        'appointment_count' => 2,
        'status' => 'active'
    ],
    [
        'id' => 3,
        'name' => 'Mehmet Kaya',
        'phone' => '+905551234569',
        'email' => 'mehmet.kaya@example.com',
        'created_at' => '2023-01-10',
        'last_appointment' => '2023-04-28',
        'appointment_count' => 6,
        'status' => 'active'
    ],
    [
        'id' => 4,
        'name' => 'Zeynep Şahin',
        'phone' => '+905551234570',
        'email' => 'zeynep.sahin@example.com',
        'created_at' => '2023-04-05',
        'last_appointment' => '2023-04-15',
        'appointment_count' => 1,
        'status' => 'inactive'
    ],
    [
        'id' => 5,
        'name' => 'Mustafa Öztürk',
        'phone' => '+905551234571',
        'email' => 'mustafa.ozturk@example.com',
        'created_at' => '2023-02-25',
        'last_appointment' => '2023-05-01',
        'appointment_count' => 3,
        'status' => 'active'
    ],
    [
        'id' => 6,
        'name' => 'Emine Yıldız',
        'phone' => '+905551234572',
        'email' => 'emine.yildiz@example.com',
        'created_at' => '2023-03-15',
        'last_appointment' => '2023-03-30',
        'appointment_count' => 2,
        'status' => 'inactive'
    ]
];

// Form işlemleri
$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] == 'add_customer') {
        // Yeni müşteri ekleme işlemi
        // Gerçek projede veritabanına kayıt edilecek
        $success = "Yeni müşteri başarıyla eklendi!";
    } else if (isset($_POST['action']) && $_POST['action'] == 'edit_customer') {
        // Müşteri düzenleme işlemi
        // Gerçek projede veritabanında güncellenecek
        $success = "Müşteri bilgileri başarıyla güncellendi!";
    } else if (isset($_POST['action']) && $_POST['action'] == 'delete_customer') {
        // Müşteri silme işlemi
        // Gerçek projede veritabanından silinecek
        $success = "Müşteri başarıyla silindi!";
    }
}
?>

<!-- Üst İstatistikler -->
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Toplam Müşteri</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo count($customers); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-people fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Aktif Müşteriler</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php 
                            $active_count = count(array_filter($customers, function($customer) {
                                return $customer['status'] == 'active';
                            }));
                            echo $active_count;
                            ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-person-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Bu Ay Yeni Müşteri
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">2</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-person-plus fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Ortalama Randevu Sayısı</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php
                            $total_appointments = array_sum(array_column($customers, 'appointment_count'));
                            echo number_format($total_appointments / count($customers), 1);
                            ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-calendar-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Başarı/Hata Mesajları -->
<?php if (!empty($success)): ?>
<div class="alert alert-success"><?php echo $success; ?></div>
<?php endif; ?>

<?php if (!empty($error)): ?>
<div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>

<!-- Müşteri Listesi -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Müşteri Listesi</h6>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
            <i class="bi bi-person-plus"></i> Yeni Müşteri
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="customersTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Müşteri Adı</th>
                        <th>Telefon</th>
                        <th>E-posta</th>
                        <th>Kayıt Tarihi</th>
                        <th>Son Randevu</th>
                        <th>Randevu Sayısı</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customers as $customer): ?>
                    <tr>
                        <td><?php echo $customer['id']; ?></td>
                        <td><?php echo $customer['name']; ?></td>
                        <td><?php echo $customer['phone']; ?></td>
                        <td><?php echo $customer['email']; ?></td>
                        <td><?php echo $customer['created_at']; ?></td>
                        <td><?php echo $customer['last_appointment']; ?></td>
                        <td><?php echo $customer['appointment_count']; ?></td>
                        <td>
                            <?php if ($customer['status'] == 'active'): ?>
                            <span class="badge bg-success">Aktif</span>
                            <?php else: ?>
                            <span class="badge bg-secondary">Pasif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewCustomerModal<?php echo $customer['id']; ?>">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editCustomerModal<?php echo $customer['id']; ?>">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteCustomerModal<?php echo $customer['id']; ?>">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Yeni Müşteri Ekleme Modal -->
<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCustomerModalLabel">Yeni Müşteri Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST">
                <input type="hidden" name="action" value="add_customer">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Ad Soyad</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Telefon</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-posta</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Durum</label>
                        <select class="form-select" id="status" name="status">
                            <option value="active">Aktif</option>
                            <option value="inactive">Pasif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Müşteri Detay Modalları -->
<?php foreach ($customers as $customer): ?>
<!-- Müşteri Görüntüleme Modal -->
<div class="modal fade" id="viewCustomerModal<?php echo $customer['id']; ?>" tabindex="-1" aria-labelledby="viewCustomerModalLabel<?php echo $customer['id']; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewCustomerModalLabel<?php echo $customer['id']; ?>">Müşteri Detayları</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-4 fw-bold">Müşteri ID:</div>
                    <div class="col-8"><?php echo $customer['id']; ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-4 fw-bold">Ad Soyad:</div>
                    <div class="col-8"><?php echo $customer['name']; ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-4 fw-bold">Telefon:</div>
                    <div class="col-8"><?php echo $customer['phone']; ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-4 fw-bold">E-posta:</div>
                    <div class="col-8"><?php echo $customer['email']; ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-4 fw-bold">Kayıt Tarihi:</div>
                    <div class="col-8"><?php echo $customer['created_at']; ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-4 fw-bold">Son Randevu:</div>
                    <div class="col-8"><?php echo $customer['last_appointment']; ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-4 fw-bold">Randevu Sayısı:</div>
                    <div class="col-8"><?php echo $customer['appointment_count']; ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-4 fw-bold">Durum:</div>
                    <div class="col-8">
                        <?php if ($customer['status'] == 'active'): ?>
                        <span class="badge bg-success">Aktif</span>
                        <?php else: ?>
                        <span class="badge bg-secondary">Pasif</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                <a href="<?php echo SITE_URL; ?>/business/appointments.php?customer_id=<?php echo $customer['id']; ?>" class="btn btn-primary">Randevuları Görüntüle</a>
                <a href="<?php echo SITE_URL; ?>/business/messages.php?customer_id=<?php echo $customer['id']; ?>" class="btn btn-info">Mesajları Görüntüle</a>
            </div>
        </div>
    </div>
</div>

<!-- Müşteri Düzenleme Modal -->
<div class="modal fade" id="editCustomerModal<?php echo $customer['id']; ?>" tabindex="-1" aria-labelledby="editCustomerModalLabel<?php echo $customer['id']; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCustomerModalLabel<?php echo $customer['id']; ?>">Müşteri Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST">
                <input type="hidden" name="action" value="edit_customer">
                <input type="hidden" name="customer_id" value="<?php echo $customer['id']; ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name<?php echo $customer['id']; ?>" class="form-label">Ad Soyad</label>
                        <input type="text" class="form-control" id="edit_name<?php echo $customer['id']; ?>" name="name" value="<?php echo $customer['name']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_phone<?php echo $customer['id']; ?>" class="form-label">Telefon</label>
                        <input type="tel" class="form-control" id="edit_phone<?php echo $customer['id']; ?>" name="phone" value="<?php echo $customer['phone']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_email<?php echo $customer['id']; ?>" class="form-label">E-posta</label>
                        <input type="email" class="form-control" id="edit_email<?php echo $customer['id']; ?>" name="email" value="<?php echo $customer['email']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="edit_status<?php echo $customer['id']; ?>" class="form-label">Durum</label>
                        <select class="form-select" id="edit_status<?php echo $customer['id']; ?>" name="status">
                            <option value="active" <?php echo $customer['status'] == 'active' ? 'selected' : ''; ?>>Aktif</option>
                            <option value="inactive" <?php echo $customer['status'] == 'inactive' ? 'selected' : ''; ?>>Pasif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">Güncelle</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Müşteri Silme Modal -->
<div class="modal fade" id="deleteCustomerModal<?php echo $customer['id']; ?>" tabindex="-1" aria-labelledby="deleteCustomerModalLabel<?php echo $customer['id']; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCustomerModalLabel<?php echo $customer['id']; ?>">Müşteri Sil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong><?php echo $customer['name']; ?></strong> isimli müşteriyi silmek istediğinize emin misiniz?</p>
                <p class="text-danger">Bu işlem geri alınamaz ve müşteriye ait tüm veriler silinecektir!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                <form method="POST">
                    <input type="hidden" name="action" value="delete_customer">
                    <input type="hidden" name="customer_id" value="<?php echo $customer['id']; ?>">
                    <button type="submit" class="btn btn-danger">Evet, Sil</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // DataTable initialization - bu gerçek projede kullanılacak
    if (typeof $.fn.DataTable !== 'undefined') {
        $('#customersTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/tr.json'
            }
        });
    }
    
    // Telefon numarası formatı
    const phoneInputs = document.querySelectorAll('input[type="tel"]');
    phoneInputs.forEach(function(input) {
        input.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 0 && value.charAt(0) !== '+') {
                value = '+' + value;
            }
            e.target.value = value;
        });
    });
});
</script>

<?php
require_once '../includes/footer.php';
?> 