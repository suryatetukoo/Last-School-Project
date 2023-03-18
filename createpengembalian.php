<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['username'])) {
        echo '<script>
        alert("Anda belum login");
        window.location.href = "daftarpinjam.php";
        </script>';
        exit;
    }

    require 'koneksi.php';
    require 'Database.php';

    if (empty($_POST['id_peminjaman'])) {
        echo '<script>
        alert("ID Peminjaman tidak boleh kosong!");
        window.location.href = "daftarpinjam.php";
        </script>';
        exit;
        
    }

    $id_peminjaman = $_POST['id_peminjaman'];

    $dt_peminjaman = $koneksi
        ->query("select dt_peminjaman.jumlah_buku, dt_buku.judul_buku, dt_user.username, dt_buku.id_buku, dt_peminjaman.tgl_kembali from dt_peminjaman inner join dt_buku on dt_buku.id_buku = dt_peminjaman.id_buku inner join dt_user on dt_user.id_user = dt_peminjaman.id_user where id_peminjaman = '$id_peminjaman' limit 1")
        ->fetch_assoc();

    if(!$dt_peminjaman) {
        echo '<script>
        alert("Peminjaman tidak ditemukan!");
        window.location.href = "daftarpinjam.php";
        </script>';
        exit;
    }

    date_default_timezone_set('Asia/Jakarta');
    $tgl_pengembalian = new DateTime(date('Y-m-d', time()));
    $batas_pengembalian = new DateTime(date('Y-m-d', strtotime($dt_peminjaman['tgl_kembali'])));

    $koneksi->query("update dt_buku set jumlah_buku = jumlah_buku + {$dt_peminjaman['jumlah_buku']} where id_buku = {$dt_peminjaman['id_buku']}");

    $denda = 0;
    $status_denda = 'null';
    $konfirmasi = 'Dikembalikan';
    if($tgl_pengembalian > $batas_pengembalian){
        $lama_terlambat = $batas_pengembalian->diff($tgl_pengembalian)->days;

        $denda = 2500 * $lama_terlambat;
        $status_denda = "'Didenda'";
        $konfirmasi = 'Belum Dikembalikan';
    }
    $tgl_pengembalian = $tgl_pengembalian->format('Y-m-d');
    
    $koneksi->query("update dt_peminjaman set tgl_kembali = '$tgl_pengembalian', denda = '$denda', status_denda = $status_denda, konfirmasi = '$konfirmasi' where id_peminjaman = $id_peminjaman");

    echo '<script>
    alert("Berhasil mengembalikan buku!");
    window.location.href = "daftarpengembalian.php";
    </script>';
    exit;
    
}
?>