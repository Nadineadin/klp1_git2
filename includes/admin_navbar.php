<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$nama_user = null;
if (!empty($_SESSION['user']['nim'])) {
  $nim = $_SESSION['user']['nim'];
  $stmt = $mysqli->prepare("SELECT nama FROM anggota WHERE nim = ?");
  $stmt->bind_param("s", $nim);
  $stmt->execute();
  $stmt->bind_result($nama_user);
  $stmt->fetch();
  $stmt->close();
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm py-3">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="<?= $base_url ?>">
      <img
        src="<?= $base_url ?>assets/images/lainnya/lambang.png"
        width="40"
        alt="logo"
        class="me-2"
      />
      <span class="fw-bold">SMAN 9 Makassar</span>
    </a>
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#mainNav"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto fw-semibold d-flex align-items-center">
      <?php if (!empty($_SESSION['user']['nim'])): ?>
        <li class="nav-item">
          <span class="me-2 text-light">Hi, <?= htmlspecialchars($nama_user ?? $_SESSION['user']['nim']) ?></span>
        </li>
        <li class="nav-item">
          <a href="/klp1pemrogweb/model/logout.php" type="button" class="btn btn-outline-light ">Logout</a>
        </li>
      <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
