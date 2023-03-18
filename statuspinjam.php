<?php
require 'koneksi.php';
require 'Database.php';
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: Login.php");
  exit();
}

$query = "SELECT * FROM dt_peminjaman LEFT JOIN dt_buku ON dt_peminjaman.id_buku = dt_buku.id_buku WHERE id_user = '" . $_SESSION['id_user'] . "' AND NOT Konfirmasi = 'Sudah Kembali' ORDER BY id_peminjaman DESC";
$result = mysqli_query($koneksi, $query);

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> RCO-LIBRARY</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css">
</head>

<body style="background-image: linear-gradient(to right, black,rgb(33, 33, 33),rgb(61, 61, 61)); ">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-body-tertiary header">
    <div class="container-fluid">
      <a class="navbar-brand text-white ms-2 judul" style="font-size: 20px;" href="homepage.html">RCO-LIBRARY</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse d-flex" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto me-3 mb-2 mb-lg-0">
          <li class="nav-item ">
            <a class="nav-link active text-white" aria-current="page" href="dashboard-user.php">Home</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Daftar Pinjam -->
  <div class="container-fluid ">
    <div class="box-pinjam mx-auto mt-5 mb-5" id="Status">
      <div class="d-flex ">
        <h2 style="margin: auto;  color: white; margin-bottom: 50px; margin-top: 10px; padding-top: 10px ;">S t a t u s &nbsp; &nbsp; P i n j a m</h2>
      </div>
      <div class=" mx-auto">
        <div class="row row-cols-4 g-5 mx-auto">
          <?php foreach ($result as $buku) : ?>
            <div class="col">
              <div class="card  ms-5 mt-3" style="width: 16rem; height: 500px; box-shadow: 1px solid black;">
                <img src="../Admin/<?= $buku['cover'] ?>" class="card-img-top " alt="...">
                <div class=" container-fluid ">
                  <div class="work-line d-flex align-items-center gap-2">
                    <p class="work-title" itemprop="name" style="font-weight: bold; font-size: 16px;">
                      <?= $buku['judul_buku'] ?>
                    </p>
                  </div>
                  <h6 class="work-title" style="font-size: 13px;"> Tanggal Pinjam :&nbsp;<?= $buku['Tgl_Pinjam'] ?></h6>
                  <h6 class="work-title" style="font-size: 13px;"> Tanggal Kembali :&nbsp;<?= $buku['Tgl_Pengembalian'] ?></h6>
                  <h6 class="work-title" style="font-size: 13px;"> Jumlah Buku :&nbsp;<?= $buku['Jumlah_Buku'] ?></h6>
                </div>
                <div class="mx-auto mt-auto mb-2">
                  <?php if ($buku['status_pinjam'] == 'Terkonfirmasi') : ?>
                    <div class="btn btn-success" style="width: 15em; border-radius: 20px;">
                      Terkonfirmasi
                    </div>
                  <?php elseif ($buku['status_pinjam'] == 'Menunggu') : ?>
                    <div class="btn btn-warning" style="width: 15em; color: white; border-radius: 20px;">
                      Menunggu...
                    </div>
                  <?php elseif ($buku['status_pinjam'] == 'Tidak Terkonfirmasi') : ?>
                    <div class="btn btn-danger" style="width: 15em; border-radius: 20px;">
                      Tidak Terkonfirmasi
                    </div>
                  <?php else : ?>
                    <?= $buku['status_pinjam'] ?>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          <?php endforeach ?>
        </div>
      </div>
    </div>
  </div>
  <script src="bootstrap-5.3.0-alpha1-dist/js/bootstrap.bundle.js"></script>
</body>
</html>