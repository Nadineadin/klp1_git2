<?php
// includes/auth.php
if (session_status() === PHP_SESSION_NONE) session_start();

function is_logged_in() {
    return !empty($_SESSION['user']['nim']);
}

function current_user_nim() {
    return $_SESSION['user']['nim'] ?? null;
}

function require_login() {
    if (!is_logged_in()) {
        // set flash message (opsional)
        $_SESSION['flash']['error'] = 'Silakan login terlebih dahulu.';
        header('Location: /klp1pemrogweb/pages/login.php');
        exit;
    }
}

/**
 * require_nim_allow($allowed_array_or_string)
 * - $allowed: string nim atau array of nim
 * Jika user tidak punya akses -> redirect ke halaman login atau 403.
 */
function require_nim_allow($allowed) {
    require_login();
    $nim = current_user_nim();
    if (is_array($allowed)) {
        $ok = in_array($nim, $allowed, true);
    } else {
        $ok = ($nim === (string)$allowed);
    }
    if (!$ok) {
        // bisa arahkan ke halaman 403 atau halaman dashboard umum
        http_response_code(403);
        // optional: tampilkan pesan sederhana, atau redirect
        echo "<h2>403 Forbidden</h2><p>Anda tidak punya akses ke halaman ini.</p>";
        exit;
    }
}
