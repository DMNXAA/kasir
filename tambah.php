<?php
session_start(); // Memulai session PHP agar bisa menggunakan variabel session

include "koneksi.php"; // Menyertakan file koneksi.php yang berisi kode untuk menghubungkan ke database
// Mengecek apakah form telah disubmit
if (isset($_POST['submit'])) {
    // Mengambil data dari form
    $nama = $_POST['nama_barang'];// Nama barang dari input form
    $harga = $_POST['harga_barang'];// Harga barang dari input form
    $stok = $_POST['stok_barang'];// Stok barang dari input form
    // Menyusun query SQL untuk memasukan data barang ke tabel 'barang
    $sql = "INSERT INTRO barang(nama_barang, harga_barang, stok_barang)
VALUES ('$nama', '$harga', '$stok')";
    // menjalankan query SQL pada database 
    $query = mysqli_query($db, $sql);
    // Mengecek apakah query berhasil dijalankan
    if ($query) {
         // jika berhasil, set pesan sukses dalam session dan arahkan ke halaman lihat.php
    $_SESSION['pesan'] = "Berhasil menambah barang";
    header("Location: lihat.php"); // Arahkan pengguna ke halaman lihat.php
    exit();// Hentikan eksekusi script setelah redirect
    } else {
        //Jika gagal, tampilkan pesan errorr dan hentikan eksekusi script 
        die("Gagal menambah barang:".mysqli_error($db));
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Tambah Barang</title>
</head>
<body>
  <h2>Form Tambah Barang</h2>
  <!-- Form untuk menambah barang -->
  <form action="tambah.php" method="post">
    <label for="nama_barang">Nama Barang:</label><br>
    <!-- Input untuk nama barang -->
    <input type="text" id="nama_barang" name="nama_barang" 
required><br><br>
    <label for="harga_barang">Harga Barang:</label><br>
    <!-- Input untuk harga barang -->
     <input type="number" id="harga_barang" name="harga_barang"
required><br><br>
    <label for="stok_barang">Stok Barang:</label><br>
    <!-- Input untuk stok barang -->
    <input type="number" id="stok_barang" name="stok_barang" 
required><br><br>
    <!-- Tombol submit untuk mengirim data ke server -->
 <input type="submit" value="Tambah Barang" name="submit">
    <!-- Link untuk kembali ke halaman lihat.php -->
   <a href="lihat.php">Kembali</a>
 </form>
</body>
</html>