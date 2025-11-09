<?php
// admin/ekstrakurikuler/delete.php
$title = "Hapus Ekstrakurikuler";
if (session_status() === PHP_SESSION_NONE) session_start();
require_once("../../includes/config.php");
require("../../includes/db_connect.php");
require('../../includes/auth.php');
require_nim_allow('240209501084');

$id = $_GET['id'] ?? '';
if ($id === '') { header('Location: index.php'); exit; }

// Ambil data gambar
$stmt = $mysqli->prepare("SELECT gambar FROM ekstrakurikuler WHERE id = ? LIMIT 1");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$stmt->close();

if (!$row) { $_SESSION['flash']['success']='Data tidak ditemukan.'; header('Location:index.php'); exit; }

// Hapus record ekstrakurikuler
$stmt = $mysqli->prepare("DELETE FROM ekstrakurikuler WHERE id = ?");
$stmt->bind_param('i', $id);
if ($stmt->execute()) {
    // hapus gambar jika ada
    $img_path = __DIR__ . '/../../assets/images/ekstrakurikuler/' . ($row['gambar'] ?? '');
    if (!empty($row['gambar']) && file_exists($img_path)) {
        @unlink($img_path);
    }

    // juga hapus semua kegiatan & ekstra_prestasi terkait
    $stmt2 = $mysqli->prepare("DELETE FROM ekstra_kegiatan WHERE ekstrakurikuler_id = ?");
    $stmt2->bind_param('i', $id);
    $stmt2->execute();
    $stmt2->close();

    // ambil prestasi terkait agar bisa hapus file gambarnya
    $pstmt = $mysqli->prepare("SELECT gambar FROM ekstra_prestasi WHERE ekstrakurikuler_id = ?");
    $pstmt->bind_param('i', $id);
    $pstmt->execute();
    $pres = $pstmt->get_result();
    while ($p = $pres->fetch_assoc()) {
        if (!empty($p['gambar']) && file_exists(__DIR__ . '/../../assets/images/prestasi/' . $p['gambar'])) {
            @unlink(__DIR__ . '/../../assets/images/prestasi/' . $p['gambar']);
        }
    }
    $pstmt->close();

    $stmt3 = $mysqli->prepare("DELETE FROM ekstra_prestasi WHERE ekstrakurikuler_id = ?");
    $stmt3->bind_param('i', $id);
    $stmt3->execute();
    $stmt3->close();

    $_SESSION['flash']['success'] = 'Ekstrakurikuler dan data terkait berhasil dihapus.';
} else {
    $_SESSION['flash']['success'] = 'Gagal menghapus: ' . $mysqli->error;
}
$stmt->close();
header('Location: index.php');
exit;
