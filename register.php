<?php
require_once 'includes/config.php';

$page_title = "Kayıt Ol";

// Eğer kullanıcı zaten giriş yapmışsa
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_type'] === 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: business/dashboard.php");
    }
    exit();
}

// Kayıt işlemi
$error = "";
$success = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $business_name = $_POST['business_name'];
    
    // Şifre kontrolü
    if ($password !== $confirm_password) {
        $error = "Şifreler eşleşmiyor!";
    } 
    // Diğer doğrulamalar burada yapılabilir
    else {
        // Gerçek uygulamada veritabanına kayıt işlemi yapılmalı
        // Şimdilik başarılı olduğunu varsayalım
        $success = "Kayıt başarıyla oluşturuldu! Giriş yapabilirsiniz.";
        
        // Gerçek bir uygulamada şifre hash'lenir ve veritabanına kaydedilir
        // Örneğin: $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        // Başarılı kayıt sonrası login sayfasına yönlendirme (isteğe bağlı)
        // header("Location: login.php");
        // exit();
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title . ' - ' . SITE_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #2e59d9;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --light-color: #f8f9fc;
            --dark-color: #5a5c69;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fc;
            background: linear-gradient(135deg, #f8f9fc 0%, #d1e6ff 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .register-container {
            max-width: 900px;
            margin: 50px auto;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .register-row {
            display: flex;
            background-color: #fff;
        }
        
        .register-image {
            flex: 1;
            background-image: url('https://images.unsplash.com/photo-1483389127117-b6a2102724ae?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80');
            background-size: cover;
            background-position: center;
            min-height: 600px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 30px;
            color: white;
            position: relative;
        }
        
        .register-image::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.7) 100%);
        }
        
        .register-image-content {
            position: relative;
            z-index: 1;
        }
        
        .register-form {
            flex: 1;
            padding: 40px;
        }
        
        .register-title {
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 25px;
            font-size: 28px;
        }
        
        .form-control {
            border-radius: 5px;
            padding: 12px 15px;
            border: 1px solid #e3e6f0;
            background-color: #f8f9fc;
            transition: all 0.3s;
            margin-bottom: 15px;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        
        .input-group {
            position: relative;
            margin-bottom: 15px;
        }
        
        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
            z-index: 10;
        }
        
        .input-with-icon {
            padding-left: 45px;
        }
        
        .btn-register {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            padding: 12px 20px;
            border-radius: 5px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }
        
        .btn-register:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .error-message {
            background-color: rgba(231, 74, 59, 0.1);
            border-left: 4px solid var(--danger-color);
            color: var(--danger-color);
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .success-message {
            background-color: rgba(28, 200, 138, 0.1);
            border-left: 4px solid var(--success-color);
            color: var(--success-color);
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .login-link {
            color: var(--primary-color);
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .login-link:hover {
            color: var(--secondary-color);
            text-decoration: none;
        }
        
        .footer {
            margin-top: auto;
            padding: 15px 0;
            background-color: white;
            border-top: 1px solid #e3e6f0;
            color: var(--dark-color);
            font-size: 14px;
        }
        
        /* Responsive ayarları */
        @media (max-width: 768px) {
            .register-row {
                flex-direction: column;
            }
            
            .register-image {
                min-height: 200px;
            }
            
            .register-form {
                padding: 30px;
            }
            
            .register-container {
                margin: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-container">
            <div class="register-row">
                <div class="register-image">
                    <div class="register-image-content">
                        <h2><?php echo SITE_NAME; ?></h2>
                        <p>İşletmenizi büyütmek ve müşteri ilişkilerinizi güçlendirmek için hemen kayıt olun.</p>
                    </div>
                </div>
                <div class="register-form">
                    <h3 class="register-title">Hemen Kayıt Olun</h3>
                    <?php if (!empty($error)): ?>
                        <div class="error-message">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($success)): ?>
                        <div class="success-message">
                            <i class="bi bi-check-circle-fill me-2"></i> <?php echo $success; ?>
                        </div>
                    <?php endif; ?>
                    <form action="register.php" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <i class="bi bi-person-fill input-icon"></i>
                                    <input type="text" class="form-control input-with-icon" name="first_name" placeholder="Adınız" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <i class="bi bi-person-fill input-icon"></i>
                                    <input type="text" class="form-control input-with-icon" name="last_name" placeholder="Soyadınız" required>
                                </div>
                            </div>
                        </div>
                        <div class="input-group">
                            <i class="bi bi-envelope-fill input-icon"></i>
                            <input type="email" class="form-control input-with-icon" name="email" placeholder="E-posta Adresiniz" required>
                        </div>
                        <div class="input-group">
                            <i class="bi bi-telephone-fill input-icon"></i>
                            <input type="text" class="form-control input-with-icon" name="phone" placeholder="Telefon Numaranız" required>
                        </div>
                        <div class="input-group">
                            <i class="bi bi-building input-icon"></i>
                            <input type="text" class="form-control input-with-icon" name="business_name" placeholder="İşletme Adı" required>
                        </div>
                        <div class="input-group">
                            <i class="bi bi-lock-fill input-icon"></i>
                            <input type="password" class="form-control input-with-icon" name="password" placeholder="Şifre" required>
                        </div>
                        <div class="input-group">
                            <i class="bi bi-lock-fill input-icon"></i>
                            <input type="password" class="form-control input-with-icon" name="confirm_password" placeholder="Şifre Tekrar" required>
                        </div>
                        <div class="form-check mb-4">
                            <input type="checkbox" class="form-check-input" id="termsCheck" required>
                            <label class="form-check-label" for="termsCheck">
                                <small>Kullanım şartlarını ve gizlilik politikasını kabul ediyorum</small>
                            </label>
                        </div>
                        <button type="submit" class="btn btn-register w-100">Kayıt Ol</button>
                        <div class="text-center mt-4">
                            <span>Zaten hesabınız var mı? </span>
                            <a href="login.php" class="login-link fw-bold">Giriş yapın</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer text-center">
        <div class="container">
            <span>© <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. Tüm hakları saklıdır.</span>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 