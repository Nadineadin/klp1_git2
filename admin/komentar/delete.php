<?php
// admin/komentar/delete.php
$title = "Hapus Komentar";
if (session_status() === PHP_SESSION_NONE) session_start();
require_once("../../includes/config.php");
require("../../includes/db_connect.php");
require('../../includes/auth.php');

require_nim_allow('240209501093');

$nama = $_GET['nama'] ?? '';
$email = $_GET['email'] ?? '';
if ($nama === '' || $email === '') { 
    $_SESSION['flash']['success'] = 'Parameter tidak lengkap.'; 
    header('Location: index.php'); exit;
}

// Hapus berdasarkan nama+email (sesuai struktur DB sekarang)
$stmt = $mysqli->prepare("DELETE FROM komentar WHERE Nama_Lengkap = ? AND email = ?");
$stmt->bind_param('ss', $nama, $email);
if ($stmt->execute()) {
    $_SESSION['flash']['success'] = 'Komentar berhasil dihapus.';
} else {
    $_SESSION['flash']['success'] = 'Gagal menghapus: ' . $mysqli->error;
}
$stmt->close();
header('Location: index.php');
exit;
