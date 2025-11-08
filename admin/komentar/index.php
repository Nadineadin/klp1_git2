<?php 
//240209501093 - Sherli
$title = "Admin Sherli"; 
require_once("../../includes/config.php");
require("../../includes/db_connect.php");
require("../../includes/header.php"); 
require('../../includes/auth.php');
require_nim_allow('240209501093');
?>
<h1>Selamat datang di halaman Komentar</h1>
<p>NIM: <?= htmlspecialchars(current_user_nim()) ?></p>
<a href="/klp1pemrogweb/pages/logout.php">Logout</a>
<?php
require_once("../../includes/footer.php")
?>