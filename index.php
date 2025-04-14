<?php
require_once 'includes/config.php';

// Eğer kullanıcı giriş yapmışsa
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_type'] === 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: business/dashboard.php");
    }
} else {
    // Giriş yapmamışsa
    header("Location: login.php");
}
exit();
?> 