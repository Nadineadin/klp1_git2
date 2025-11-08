<?php
// model/sistem_login.php
session_start();

$_SESSION['user'] = ['id' => $user['id'], 'nim' => $user['nim']];

// helper flash (simpel)
function flash_set($key, $message) {
    $_SESSION['flash'][$key] = $message;
}

// include DB (pastikan path benar relative ke file ini)
require_once __DIR__ . '/../includes/db_connect.php';

// Ambil input
$input = trim($_POST['nim'] ?? '');
$password = $_POST['password'] ?? '';

// Validasi singkat
if ($input === '' || $password === '') {
    flash_set('error', 'Masukkan nim (nim) dan kata sandi.');
    header('Location: ../pages/login.php');
    exit;
}

// Kita anggap "nim" = nim (sesuaikan bila ingin pakai email)
$nim_input = $input;

// Prepared statement cari user berdasarkan nim
$sql = "SELECT id, nim, password FROM `user` WHERE nim = ? LIMIT 1";
$stmt = $mysqli->prepare($sql);
if (!$stmt) {
    flash_set('error', 'Terjadi kesalahan server (prepare).');
    header('Location: ../pages/login.php');
    exit;
}
$stmt->bind_param('s', $nim_input);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    flash_set('error', 'nim atau password salah.');
    header('Location: ../pages/login.php');
    exit;
}

// Ambil password DB
$db_hash = $user['password'];

// Cek apakah password di DB sudah hashed (bcrypt/argon2)
$verified = false;
if (strpos($db_hash, '$2y$') === 0 || strpos($db_hash, '$2b$') === 0 || strpos($db_hash, '$argon2') === 0) {
    // hashed -> gunakan password_verify
    if (password_verify($password, $db_hash)) $verified = true;
} else {
    // belum hashed (plain text) -> bandingkan langsung (sementara)
    if ($password === $db_hash) $verified = true;
}

// Jika verifikasi gagal
if (!$verified) {
    flash_set('error', 'nim atau password salah.');
    header('Location: ../pages/login.php');
    exit;
}

// Login sukses -> set session
session_regenerate_id(true);
$_SESSION['user'] = [
    'id' => $user['id'],
    'nim' => $user['nim']
];

// Routing berdasarkan nim (sesuaikan atau extend list ini)
$nim = $user['nim'];
$redirect = '../admin/index.php'; // default

switch ($nim) {
    case '240209501085':
        $redirect = '../admin/user/index.php';
        break;
    case '240209501084':
        $redirect = '../admin/ekstrakurikuler/index.php';
        break;
    case '240209501089':
        $redirect = '../admin/fasilitas/index.php';
        break;
    case '240209501093':
        $redirect = '../admin/komentar/index.php';
        break;
    case '240209501094':
        $redirect = '../admin/prestasi/index.php';
        break;
    default:
        // jika ingin arahkan berdasarkan role di DB, ubah logic di sini
        $redirect = '../admin/index.php';
        break;
}

// Optional: flash success
flash_set('success', 'Login berhasil. Selamat datang!');
header('Location: ' . $redirect);
exit;
