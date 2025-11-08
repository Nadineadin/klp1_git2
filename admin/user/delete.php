<?php
// admin/user/delete.php
$title = "Hapus Anggota";
if (session_status() === PHP_SESSION_NONE) session_start();
require_once("../../includes/config.php");
require("../../includes/db_connect.php");
require('../../includes/auth.php');
require_nim_allow('240209501085');

$nim = $_GET['nim'] ?? '';
if ($nim === '') { header('Location: index.php'); exit; }

// Ambil data (untuk hapus file gambar)
$stmt = $mysqli->prepare("SELECT gambar FROM anggota WHERE nim = ? LIMIT 1");
$stmt->bind_param('s', $nim);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$stmt->close();

if (!$row) { $_SESSION['flash']['success']='Data tidak ditemukan.'; header('Location:index.php'); exit; }

// Hapus record
$stmt = $mysqli->prepare("DELETE FROM anggota WHERE nim = ?");
$stmt->bind_param('s', $nim);
if ($stmt->execute()) {
    // hapus file gambar jika ada
    if (!empty($row['gambar']) && file_exists(__DIR__ . '/../../' . $row['gambar'])) {
        @unlink(__DIR__ . '/../../' . $row['gambar']);
    }
    $_SESSION['flash']['success'] = 'Data berhasil dihapus.';
} else {
    $_SESSION['flash']['success'] = 'Gagal menghapus: ' . $mysqli->error;
}
$stmt->close();
header('Location: index.php');
exit;
