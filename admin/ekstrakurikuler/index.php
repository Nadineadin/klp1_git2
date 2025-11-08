<?php
// 240209501084 - Riska
$title = "Admin Riska"; 
require_once("../../includes/config.php");
require("../../includes/db_connect.php");
require("../../includes/header.php"); 
require('../../includes/auth.php');
require_nim_allow('240209501084');
?>
<h1>Selamat datang di halaman Ekstrakurikuler</h1>
<p>NIM: <?= htmlspecialchars(current_user_nim()) ?></p>
<a href="/klp1pemrogweb/pages/logout.php">Logout</a>
<?php
require_once("../../includes/footer.php")
?>