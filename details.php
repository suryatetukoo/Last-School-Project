<?php
session_start();

require 'koneksi.php';
require 'Database.php';

$database = new Database();

if (empty($_GET['id_buku'])) {
  echo 'Buku tidak ditemukan';
  exit;
}

$id_buku = htmlspecialchars($_GET['id_buku'] ?? '');

$query = <<<QUERY
    select * 
    from dt_buku 
    where id_buku = $id_buku
    limit 1
QUERY;

$buku = $database->koneksi
  ->query($query)
  ->fetch(PDO::FETCH_ASSOC);

if (!$buku) {
  echo 'Buku tidak ditemukan';
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!isset($_SESSION['username'])) {
    echo '<script>
            alert("Anda belum login!");
            window.location.href = "index.php";
        </script>';
    exit;
  }

  if (isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];
  }

  $id_buku = $_POST['id_buku'];
  $id_user = $_SESSION['id_user'];
  $judul_buku  = $buku['judul_buku'];
  $username = $_SESSION['username'];
  $tgl_pinjam = date("Y-m-d");
  $tgl_kembali = date("Y-m-d");
  $konfirmasi = 'Terkonfirmasi';

  $tgl_kembali = htmlspecialchars($_POST['tgl_kembali']);
  $jumlah_buku = htmlspecialchars($_POST['jumlah_buku']);

  $update = " UPDATE dt_buku SET jumlah_buku = jumlah_buku - $jumlah_buku WHERE id_buku = $id_buku";
  mysqli_query($koneksi, $update);

  $dbPeminjaman = $database->koneksi->query(" INSERT INTO dt_peminjaman (id_user, id_buku, judul_buku, nama, tgl_pinjam, tgl_kembali, jumlah_buku, konfirmasi, status_pinjam)
  VALUES ('$id_user', '$id_buku', '$judul_buku', '$username', '$tgl_pinjam', '$tgl_kembali', '$jumlah_buku', '$konfirmasi', 'Boleh')");

  if (!$dbPeminjaman) {
    echo '<script>
          alert("Gagal Meminjam");
        </script>';
    exit;
  } else {
    echo '<script>
          alert("Berhasil");
        </script>';
    echo '<script>window.location="index.php"</script>';
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Detail Buku</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt2NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />

  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

  <link rel="stylesheet" href="style.css" />

  <style></style>
</head>

<body style="background-color: #37306b">
  <div class="row justify-content-center">
    <div class="col-lg-4">
      <div class="card-detail shadow rounded-22">
        <div style="display: flex">
          <img src="pict/<?= $buku['cover'] ?>" alt="cover" class="card-img-top" alt="..." style="height: 50vh" />
          <div class="card-body">
            <h1 class="card-title d-flex justify-content-center" id="judul_buku">
               <?= $buku['judul_buku']; ?>
            </h1>
            <p class="card-text d-flex justify-content-center" id="pengarang">
              Pengarang: <?= $buku['pengarang']; ?>
            </p>
            <p id="sinopsis">
              <?= $buku['sinopsis']; ?>
            </p>
            <div style="display: flex; gap: 16px;">
              <form method="POST">
                <div class="col">
                <div class="input-group">
                  <input type="hidden" name="id_buku" value="<?= $buku['id_buku'] ?>">
                  <input type="hidden" name="id_user" value="<?= $_SESSION['id_user'] ?>">
                    <input class="form-control" type="date" name="tgl_pinjam" id="tgl_pinjam" placeholder="Durasi">
                    <span class="input-group-text">Tanggal Pinjam</span>
                  </div>
                  <div class="input-group">
                    <input class="form-control" type="date" name="tgl_kembali" id="tgl_kembali" placeholder="Durasi">
                    <span class="input-group-text">Tanggal Kembali</span>
                  </div>
                  <div class="input-group">
                  <input class="form-control" type="number" name="jumlah_buku" id="jumlah_buku" placeholder="Jumlah">
                  <span class="input-group-text">Buku</span>
                  </div>
                  <input type="submit" value="PINJAM" class="btn btn-pinjam rounded" style="margin-top: 16px;">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
  <br><br>
  <script src="../bootstrap/js/bootstrap.bundle.js"></script>
  <script src="script.js"></script>
</body>

</html>