<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: /login.php');
    exit;
}

require 'koneksi.php';
require 'Database.php';

$query = <<<QUERY
         select dt_peminjaman.id_peminjaman, dt_buku.cover, dt_buku.judul_buku, dt_peminjaman.tgl_pinjam,  dt_peminjaman.tgl_pinjam, dt_peminjaman.tgl_kembali, dt_peminjaman.konfirmasi as konfirmasi, dt_peminjaman.denda, dt_peminjaman.status_denda, dt_buku.id_buku, dt_buku.pengarang
         from dt_peminjaman
         left join dt_buku on dt_peminjaman.id_buku = dt_buku.id_buku
         left join dt_user on dt_peminjaman.id_user = dt_user.id_user
         where dt_peminjaman.id_user = '{$_SESSION['id_user']}' and (dt_peminjaman.id_peminjaman is null or dt_peminjaman.konfirmasi = 'Terkonfirmasi')
         order by id_peminjaman desc
         QUERY;
$semuapeminjaman = $koneksi
    ->query($query)
    ->fetch_all(MYSQLI_ASSOC);
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
            <a class="navbar-brand text-white" href="index.php">PUERPOESTAKAANJAY📚</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <button class="btn text-white p-2 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Other
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="index.php">Halaman Utama</a></li>
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
            <h1>Scroll Kebawah Untuk Melihat Buku Apa Saja Yang Kamu Pinjam😁</h1>
        </main>
    </section>
    <!-- Hero Section End -->

    <div class="container-fluid" id="library">
        <div class="container my-7">
            <h1>Daftar Peminjamanmu</h1>
            <div class="px-lg-5 mt-4">
                <div class="row row-cols-4">
                    <div class="col">
                        <?php foreach ($semuapeminjaman as $b) : ?>
                            <div><img class="card_content" class="col">
                                <div class="card cardscale" style="width: 16rem;"><img src="pict/<?= $b['cover'] ?>" alt="<?= $b['judul_buku'] ?>"></div>
                            </div>
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