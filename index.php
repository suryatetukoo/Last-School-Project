<?php
session_start();

require 'koneksi.php';

$sql = "SELECT dt_buku.id_buku , dt_buku.cover , dt_buku.judul_buku , count(distinct id_peminjaman) AS jumlah_buku FROM dt_buku 
left join dt_peminjaman on dt_peminjaman.judul_buku = dt_buku.judul_buku
GROUP BY 1
ORDER BY jumlah_buku DESC
LIMIT 6
";

$showbooks = $koneksi->query($sql)->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT * FROM dt_buku ORDER BY id_buku DESC";

$sql = "SELECT * FROM dt_buku WHERE kategori_buku = 'Komik' ORDER BY id_buku DESC ";

$sql = "SELECT * FROM dt_buku WHERE kategori_buku = 'Novel' ORDER BY id_buku DESC";

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PUERPOESTAKAANJAY</title>
  <!-- CSS -->
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-body-tertiary p-0 fixed-top">
    <div class="container-fluid p-4" style="background-color: #37306B">
      <a class="navbar-brand text-white" href="#home">PUERPOESTAKAANJAY📚</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <?php
            if (isset($_SESSION['username'])) { ?>
            <?php if ($_SESSION['role'] === 'Pustakawan') : ?>
              <a href="iseng/index.php" class="btn btn-daftar" style="color: white;"> Admin Panel</a>
            <?php endif; ?>
            <a class="btn btn-masuk" style="color: white;">Welcome, <?= $_SESSION['username'] ?>👋</a>
            <?php } else { ?>
            <a class="nav-link active rounded-2" style="color: white;" aria-current="page" href="register.php">Register</a>
            <?php } ?>
          </li>
          <li class="nav-item dropdown">
            <button class="btn text-white p-2 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
              Other
            </button>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li><a class="dropdown-item" href="#library">Buku </a></li>
              <li><a class="dropdown-item" href="daftarpinjam.php">Peminjaman</a></li>
              <li><a class="dropdown-item" href="daftarpengembalian.php">Pengembalian</a></li>
            </ul>
          </li>

          <li class="nav-item">
            <a class="nav-link" style="color: white;" href="/logout.php">Logout</a>
          </li>
        </ul>
        </form>
      </div>
    </div>
  </nav>
  <!-- End -->

  <!-- Hero Section start -->
  <section class="hero" id="home">
    <main class="content">
      <h1>Ayo Baca Komikmu, Untuk Senyummu😁</h1>
      <a href="login.php" style="background-color: #37306B;" class="btn btn-primary">KLIK DISINI UNTUK LOGIN DULU BRO🧐</a>
    </main>
  </section>
  <!-- Hero Section End -->

  <div class="container-fluid" id="library">
    <h2 class="mt-3 fw-bold" style="margin-left: 300px;">Comics✌🏾</h2>
    <div class="container my-1 p-5">
      <div class="d-flex">
        <div class="row ">
          <?php foreach ($showbooks as $b) : ?>
          <div class="col-lg-3">
            <a href="details.php?id_buku=<?= $b['id_buku'] ?>">
              <img class="card_content">
                <div class="card cardscale" style="width: 16rem; margin: 16px;">
                  <img src="pict/<?= $b['cover'] ?>" alt="<?= $b['judul_buku'] ?>">
                </div>
              </a>
            </div>
            <?php endforeach; ?>
        </div>
      </a>
      </div>
    </div>
  </div>
  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>