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
      <ul class="navbar-nav ms-auto fw-semibold">
        <li class="nav-item"><a class="nav-link text-uppercase <?= ($title == 'Home') ? 'active' : '' ?>" href="<?= $base_url ?>">home</a></li>
        <li class="nav-item"><a class="nav-link text-uppercase <?= ($title == 'Fasilitas') ? 'active' : '' ?>" href="<?= $base_url ?>pages/fasilitas.php">fasilitas</a></li>
        <li class="nav-item"><a class="nav-link text-uppercase <?= ($title == 'Ekstrakurikuler') ? 'active' : '' ?>" href="<?= $base_url ?>pages/ekstrakurikuler.php">ekstrakurikuler</a></li>
        <li class="nav-item"><a class="nav-link text-uppercase <?= ($title == 'Kontak') ? 'active' : '' ?>" href="<?= $base_url ?>pages/kontak.php">kontak</a></li>
        <li class="nav-item"><a class="nav-link text-uppercase <?= ($title == 'About Us') ? 'active' : '' ?>" href="<?= $base_url ?>pages/about_us.php">about</a></li>
        <li class="nav-item"><a class="nav-link text-uppercase <?= ($title == 'Login') ? 'active' : '' ?>" href="<?= $base_url ?>pages/login.php">login</a></li>
      </ul>
    </div>
  </div>
</nav>