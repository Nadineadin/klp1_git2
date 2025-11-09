<?php 
if (session_status() === PHP_SESSION_NONE) session_start();

switch ($_SESSION['user']['nim']) {
  case '240209501084':
    header('Location: /klp1pemrogweb/admin/ekstrakurikuler/');
    exit;
  case '240209501085':
    header('Location: /klp1pemrogweb/admin/user/');
    exit;
  case '240209501089':
    header('Location: /klp1pemrogweb/admin/fasilitas');
    exit;
  case '240209501093':
    header('Location: /klp1pemrogweb/admin/komentar/');
    exit;
  case '240209501094':
    header('Location: /klp1pemrogweb/admin/prestasi/');
    exit;
  default:
    header('Location: /klp1pemrogweb/');
    exit;
}

?>