<?php
// model/sistem_login.php
// Pastikan file ini aman (di luar webroot bila bisa) dan PHP >= 7.3 direkomendasikan.

// Set secure session cookie params sebelum session_start
$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '', // kosong = host saat ini
    'secure' => $secure,
    'httponly' => true,
    'samesite' => 'Lax'
]);

session_start();

// helper flash (simpel)
function flash_set($key, $message) {
    if (!isset($_SESSION['flash'])) $_SESSION['flash'] = [];
    $_SESSION['flash'][$key] = $message;
}

// include DB (pastikan path benar relative ke file ini)
require_once __DIR__ . '/../includes/db_connect.php';

// Pastikan request via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/login.php');
    exit;
}

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
    // error prepare
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

// Verifikasi password:
// - Jika field DB berisi hash valid (password_get_info algo != 0) -> password_verify
// - Jika bukan hash (algo == 0) -> anggap plaintext, bandingkan langsung
$verified = false;
$used_plaintext = false;

$info = password_get_info($db_hash);
if (!empty($db_hash) && $info['algo'] !== 0) {
    // DB berisi hash: gunakan password_verify
    if (password_verify($password, $db_hash)) {
        $verified = true;
    }
} else {
    // DB bukan hash (kemungkinan plaintext) -> bandingkan langsung
    if ($password === $db_hash) {
        $verified = true;
        $used_plaintext = true;
    }
}

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

// --- Upgrade password (hash) bila perlu ---
// Pilih algoritma: prefer argon2id bila tersedia, fallback bcrypt
if (defined('PASSWORD_ARGON2ID')) {
    $algo = PASSWORD_ARGON2ID;
    $algo_name = 'argon2id';
    $rehash_options = []; // bisa set memory_cost/time_cost/threads jika perlu
} else {
    $algo = PASSWORD_BCRYPT;
    $algo_name = 'bcrypt';
    $rehash_options = ['cost' => 12];
}

try {
    $need_rehash = false;
    // Jika password di DB plaintext (used_plaintext) -> perlu hash
    if ($used_plaintext) {
        $need_rehash = true;
    } else {
        // DB sudah hash -> cek apakah perlu rehash karena opsi berubah
        // Hanya panggil password_needs_rehash bila DB berisi hash valid
        if ($info['algo'] !== 0 && password_needs_rehash($db_hash, $algo, $rehash_options)) {
            $need_rehash = true;
        }
    }

    if ($need_rehash) {
        $new_hash = password_hash($password, $algo, $rehash_options);
        if ($new_hash !== false) {
            $u_stmt = $mysqli->prepare("UPDATE `user` SET `password` = ? WHERE id = ?");
            if ($u_stmt) {
                $u_stmt->bind_param('si', $new_hash, $user['id']);
                $u_stmt->execute();
                // optional: cek affected_rows jika ingin log
                $u_stmt->close();
            }
            // jika gagal update, jangan tolak login — tetap login.
        }
    }
} catch (Throwable $e) {
    // Jika terjadi error pada rehash/update, jangan blokir login — tapi bisa log jika perlu.
    // error_log($e->getMessage());
}

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
