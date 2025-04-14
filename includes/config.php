<?php
session_start();

// Hata raporlama
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Veritabanı bağlantı bilgileri
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'randeva');

// Site ayarları
define('SITE_NAME', 'Randeva');

// Dinamik URL tespiti
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'];
$script_name = $_SERVER['SCRIPT_NAME'];
$base_dir = dirname(dirname($script_name));
$base_url = $base_dir === '\\' || $base_dir === '/' ? '' : $base_dir;
define('SITE_URL', $protocol . $host . $base_url);

// Oturum kontrolü
function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: " . SITE_URL . "/login.php");
        exit();
    }
}

// Kullanıcı tipi kontrolü
function checkUserType($required_type) {
    if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== $required_type) {
        header("Location: " . SITE_URL . "/login.php");
        exit();
    }
}
?> 