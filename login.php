<?php
require_once 'includes/config.php';

$page_title = "Giriş";

// Eğer kullanıcı zaten giriş yapmışsa
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_type'] === 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: business/dashboard.php");
    }
    exit();
}

// Login işlemi
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Şimdilik basit bir kontrol yapıyoruz
    if ($phone === "admin" && $password === "admin123") {
        $_SESSION['user_id'] = 1;
        $_SESSION['user_type'] = 'admin';
        $_SESSION['user_name'] = 'Admin';
        header("Location: admin/dashboard.php");
        exit();
    } else if ($phone === "business" && $password === "business123") {
        $_SESSION['user_id'] = 2;
        $_SESSION['user_type'] = 'business';
        $_SESSION['user_name'] = 'İşletme';
        header("Location: business/dashboard.php");
        exit();
    } else {
        $error = "Telefon numarası veya şifre hatalı!";
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
        
        .login-container {
            max-width: 900px;
            margin: 100px auto;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .login-row {
            display: flex;
            background-color: #fff;
        }
        
        .login-image {
            flex: 1;
            background-image: url('https://images.unsplash.com/photo-1557200134-90327ee9fafa?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80');
            background-size: cover;
            background-position: center;
            min-height: 450px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 30px;
            color: white;
            position: relative;
        }
        
        .login-image::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.7) 100%);
        }
        
        .login-image-content {
            position: relative;
            z-index: 1;
        }
        
        .login-form {
            flex: 1;
            padding: 50px;
        }
        
        .login-title {
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 30px;
            font-size: 28px;
        }
        
        .form-control {
            border-radius: 5px;
            padding: 12px 15px;
            border: 1px solid #e3e6f0;
            background-color: #f8f9fc;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        
        .input-group {
            position: relative;
            margin-bottom: 25px;
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
        
        .btn-login {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            padding: 12px 20px;
            border-radius: 5px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
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
            margin-bottom: 25px;
            font-size: 14px;
        }
        
        .forgot-link {
            color: var(--primary-color);
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .forgot-link:hover {
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
            .login-row {
                flex-direction: column;
            }
            
            .login-image {
                min-height: 200px;
            }
            
            .login-form {
                padding: 30px;
            }
            
            .login-container {
                margin: 50px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="login-row">
                <div class="login-image">
                    <div class="login-image-content">
                        <h2><?php echo SITE_NAME; ?></h2>
                        <p>WhatsApp üzerinden randevularınızı kolayca yönetin, müşterilerinizle anında iletişime geçin.</p>
                    </div>
                </div>
                <div class="login-form">
                    <h3 class="login-title">Hoş Geldiniz</h3>
                    <?php if (!empty($error)): ?>
                        <div class="error-message">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    <form action="login.php" method="POST">
                        <div class="input-group">
                            <i class="bi bi-person-fill input-icon"></i>
                            <input type="text" class="form-control input-with-icon" name="phone" placeholder="Telefon Numarası / Kullanıcı Adı" required>
                        </div>
                        <div class="input-group">
                            <i class="bi bi-lock-fill input-icon"></i>
                            <input type="password" class="form-control input-with-icon" name="password" placeholder="Şifre" required>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">Beni Hatırla</label>
                            </div>
                            <a href="#" class="forgot-link">Şifremi Unuttum</a>
                        </div>
                        <button type="submit" class="btn btn-login w-100">Giriş Yap</button>
                        <div class="text-center mt-4">
                            <span>Hesabınız yok mu? </span>
                            <a href="register.php" class="forgot-link fw-bold">Kayıt olun</a>
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