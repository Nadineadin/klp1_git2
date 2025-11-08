<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm py-3">
      <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?= $base_url ?>index.html">
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
            <li class="nav-item"><a class="nav-link <?= ($title == 'Home') ? 'active' : '' ?>" href="<?= $base_url ?>">HOME</a></li>
            <li class="nav-item"><a class="nav-link <?= ($title == 'Fasilitas') ? 'active' : '' ?>" href="<?= $base_url ?>pages/fasilitas.php">FASILITAS</a></li>
            <li class="nav-item"><a class="nav-link <?= ($title == 'Ekstrakurikuler') ? 'active' : '' ?>" href="<?= $base_url ?>pages/ekstrakurikuler.php">EKSTRAKURIKULER</a></li>
            <li class="nav-item"><a class="nav-link <?= ($title == 'Kontak') ? 'active' : '' ?>" href="<?= $base_url ?>pages/kontak.php">KONTAK</a></li>
            <li class="nav-item"><a class="nav-link <?= ($title == 'About Us') ? 'active' : '' ?>" href="<?= $base_url ?>pages/about_us.php">ABOUT US</a></li>
            <li class="nav-item"><a class="nav-link <?= ($title == 'Login') ? 'active' : '' ?>" href="<?= $base_url ?>pages/login.php">LOGIN</a></li>
          </ul>
        </div>
      </div>
    </nav>