<?php
// admin/prestasi/delete.php
$title = "Hapus Prestasi";
if (session_status() === PHP_SESSION_NONE) session_start();
require_once("../../includes/config.php");
require("../../includes/db_connect.php");
require('../../includes/auth.php');

require_nim_allow('240209501094');

$id = $_GET['id'] ?? '';
if ($id === '') { header('Location: index.php'); exit; }

// Ambil data (untuk hapus file gambar)
$stmt = $mysqli->prepare("SELECT gambar FROM prestasi_siswa WHERE id = ? LIMIT 1");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$stmt->close();

if (!$row) { $_SESSION['flash']['success']='Data tidak ditemukan.'; header('Location:index.php'); exit; }

// Hapus record
$stmt = $mysqli->prepare("DELETE FROM prestasi_siswa WHERE id = ?");
$stmt->bind_param('i', $id);
if ($stmt->execute()) {
    // hapus file gambar jika ada
    $img_path = __DIR__ . '/../../assets/images/prestasi/' . ($row['gambar'] ?? '');
    if (!empty($row['gambar']) && file_exists($img_path)) {
        @unlink($img_path);
    }
    $_SESSION['flash']['success'] = 'Data berhasil dihapus.';
} else {
    $_SESSION['flash']['success'] = 'Gagal menghapus: ' . $mysqli->error;
}
$stmt->close();
header('Location: index.php');
exit;
