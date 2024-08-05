<?php
session_start(); // Memulai sesi PHP untuk menggunakan variabel session

include "koneksi.php"; // Menyertakan file koneksi.php yang berisi kode untuk menghubungkan ke database

// Mengecek apakah parameter 'id' ada di URL
if (isset($_GET['id'])) {
    $id = $_GET['id']; // Mengambil ID barang dari parameter URL

    // Validasi ID untuk memastikan itu adalah angka
    if (filter_var($id, FILTER_VALIDATE_INT) !== false) {
        // Menyusun query SQL untuk menghapus data barang dari tabel 'barang' berdasarkan ID menggunakan prepared statement
        $sql = "DELETE FROM barang WHERE id_barang = ?";
        if ($stmt = mysqli_prepare($db, $sql)) {
            // Bind parameter
            mysqli_stmt_bind_param($stmt, "i", $id);

            // Menjalankan query SQL pada database
            if (mysqli_stmt_execute($stmt)) {
                // Jika berhasil, set pesan sukses dalam session dan arahkan ke halaman lihat.php
                $_SESSION['pesan'] = "Berhasil menghapus barang";
                header("Location: lihat.php"); // Arahkan pengguna ke halaman lihat.php
                exit(); // Hentikan eksekusi script setelah redirect
            } else {
                // Jika gagal, tampilkan pesan error
                die("Gagal menghapus barang: " . mysqli_error($db));
            }
            mysqli_stmt_close($stmt);
        } else {
            // Jika gagal mempersiapkan statement, tampilkan pesan error
            die("Gagal mempersiapkan query: " . mysqli_error($db));
        }
    } else {
        // Jika ID tidak valid, tampilkan pesan error
        die("ID tidak valid.");
    }
} else {
    // Jika parameter 'id' tidak ada di URL, tampilkan pesan error
    die("ID barang tidak ditemukan.");
}
?>
