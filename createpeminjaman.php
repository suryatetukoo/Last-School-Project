<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!isset($_SESSION['username'])) {
        echo '<script>
        alert("Anda belum login!");
        window.location.href = "index.php";
        </script>';
        exit;
    }

    $id_buku = htmlspecialchars($_POST['id_buku']);
    $id_user = htmlspecialchars($_POST['id_user']);

    date_default_timezone_set('Asia/Jakarta');
    $tgl_pinjam = date('Y-m-d', time());

    $jumlah_buku = 1;
    $konfirmasi = 0;

    require 'koneksi.php';
    require 'Database.php';

    $query = <<<QUERY
    insert into dt_peminjaman (id_peminjaman, id_buku, id_user, jumlah_buku, tgl_pinjam, nama, jumlah_buku, status_pinjam, tgl_kembali, konfirmasi)
     values ('$id_peminjaman', '$id_buku', '$id_user', '$jumlah_buku', '$tgl_pinjam', '$nama', '$jumlah_buku', '$status_pinjam', '$tgl_kembali', '$konfirmasi')
    QUERY;

    $koneksi->query($query);

    echo '<script>
    alert("Berhasil meminjam buku!");
    window.location.href ="daftarpinjam.php";
    </script>';
    exit;
}
?>