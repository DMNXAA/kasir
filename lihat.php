<?php
session_start(); // Memulai session untuk menggunakan $_SESSION

// Menyertakan file koneksi untuk menghubungkan ke database
include "koneksi.php";

// Menulis query SQL untuk mengambil semua data dari tabel 'barang'
$sql = "SELECT * FROM barang";

// Menjalankan query dan menyimpan hasilnya ke dalam variabel $query
$query = mysqli_query($db, $sql);

// Mengecek apakah jumlah baris hasil query lebih dari 0
if ($query->num_rows>0) {}
  // Jika ada data, mulai membuat tabel HTML dengan border
  echo "<a href='tambah.php'>Tambah barang</a><br><br>";
  // Mengecek jika ada pesan dalam session dan menampilkannya
  if (isset($_SESSION['pesan'])) {
      echo $_SESSION['pesan']; // Menampilkan pesan
      unset($_SESSION['pesan']); // Menghapus pesan dari session setelah ditampilkan
    }
    // Membuat tabel HTML
     echo "
  <table border='1'>
    <tr>
       <td>No</td> <!-- Kolom untuk nomor urut -->
       <td>Nama Barang</td> <!-- Kolom untuk nama barang -->
       <td>Harga Barang</td> <!-- Kolom untuk harga barang -->
       <td>Stok Barang</td> <!-- Kolom untuk stok barang -->
       <td>Action</td> <!-- Kolom untuk aksi edit dan hapus -->
    </tr>
    ";
    // Mengambil setiap baris data hasil query dan menampilkannya di dalam tabel
     while ($data = mysqli_fetch_array($query)) {
     echo "
    <tr>
       <td>{$data['id_barang']}</td> <!-- Menampilkan ID barang -->
       <td>{$data['nama_barang']}</td> <!-- Menampilkan nama barang -->
       <td>{$data['harga_barang']}</td> <!-- Menampilkan harga barang -->
       <td>{$data['stok_barang']}</td> <!-- Menampilkan stok barang -->
    <td><a href='edit.php?id={$data['id_barang']}'>Edit</a> | <a href='hapus.php?id={$data['id_barang']}'>Hapus</a></td> <!-- Link untuk aksi edit dan hapus -->
    </tr>
    ";
    }
    // Menutup tag tabel setelah semua data ditampilkan
    echo "
    </table>"; 