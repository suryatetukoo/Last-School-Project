<?php
$host = "localhost";
$username = "root";
$password = ""; 
$database = "perpustakaan";

$koneksi = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}

function registrasi($data)
{
  global $koneksi;
  $nama = mysqli_real_escape_string($koneksi, $data['nama']);
  $no_telp = mysqli_real_escape_string($koneksi, $data['no_telp']);
  $username = mysqli_real_escape_string($koneksi, $data['username']);
  $password = mysqli_real_escape_string($koneksi, $data['password']);

  mysqli_query($koneksi, "INSERT INTO dt_user VALUE('', '$nama','$no_telp','$username','$password', 'Member')");
  return mysqli_affected_rows($koneksi);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (registrasi($_POST) > 0) {
    echo "<script>
      alert ('Berhasil Registrasi');
      windows.location.href = 'login.php';
      </script>";
      exit;
  } else {
    echo "<script>
    alert ('Gagal Registrasi');
    </script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar dulu yuk!</title>
    <link rel="stylesheet" href="reg.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>
<body>
    <div class="card">
        <div class="card-header-custom">
          <div class="text-header">Buat Akun Perpustakaanmu!😋</div>
        </div>
        <div class="card-body">
          <form method="post">
            <div class="form-group">
              <label for="username">Username :</label>
              <input required="" class="form-control" name="username" id="username" type="text">
            </div>
            <div class="form-group">
              <label for="nama">Nama :</label>
              <input required="" class="form-control" name="nama" id="nama" type="text">
            </div>
            <div class="form-group">
              <label for="password">Password :</label>
              <input required="" class="form-control" name="password" id="password" type="password">
            </div>
            <div class="form-group">
              <label for="no_telp">No. Telepon :</label>
              <input required="" class="form-control" name="no_telp" id="no_telp" type="number">
            </div>
           <button type="submit" class="button-submit">Submit</button>
          </form>
        </div>
      </div>
      <script src="bootstrap/js/bootstrap.bundle.js"></script>
</body>
</html>