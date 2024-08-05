<?php
session_start(); // Memulai sesi PHP untuk menggunakan variabel session

include "koneksi.php"; // Menyertakan file koneksi.php yang berisi kode untuk menghubungkan ke database
// Mengecek apakah form telah disubmit
if (isset($_POST['submit'])) {
    $id = $_GET['id']; // Mengambil ID barang dari URL
    $nama = $_POST['nama_barang']; // Mengambil nama barang dari input form
    $harga = $_POST['harga_barang']; // Mengambil harga barang dari input form
    $stok = $_POST['stok_barang']; // Mengambil stok barang dari input form
    // Menyusun query SQL untuk memperbarui data barang dalam tabel 'barang'
    $sql = "UPDATE barang SET nama_barang = '$nama', harga_barang = '$harga', stok_barang = '$stok' WHERE id_barang = $id";
    // Menjalankan query SQL pada database
    $query = mysqli_query($db, $sql);
    // Mengecek apakah query berhasil dijalankan
    if ($query) {
        // Jika berhasil, set pesan sukses dalam session dan arahkan ke halaman lihat.php
        $_SESSION['pesan'] = "Berhasil mengedit barang";
        header("Location: lihat.php"); // Arahkan pengguna ke halaman lihat.php
        exit(); // Hentikan eksekusi script setelah redirect
    } else {
        // Jika gagal, tampilkan pesan error dan hentikan eksekusi script
        die("Gagal mengedit barang: " . mysqli_error($db));
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>
</head>
<body>
    <h2>Form Edit Barang</h2>
    <!-- Form untuk mengedit barang -->
    <form action="edit.php?id=<?php echo $_GET['id'] ?>" method="post">
        <?php
        // Mengecek apakah ID barang ada di URL
        if (isset($_GET['id'])) {
            $id = $_GET['id']; // Mengambil ID barang dari URL
            $sql = "SELECT * FROM barang WHERE id_barang = $id"; // Menyusun query SQL untuk mengambil data barang berdasarkan ID
            $query = mysqli_query($db, $sql); // Menjalankan query pada database
            // Mengecek apakah query mengembalikan hasil data
            if ($query->num_rows > 0) {
                $data = $query->fetch_assoc(); // Mengambil data hasil query
        ?>
                <!-- Input form dengan nilai awal diisi dengan data barang yang ada -->
                <label for="nama_barang">Nama Barang:</label><br>
                <input type="text" id="nama_barang" name="nama_barang" value="<?php echo $data['nama_barang'] ?>" required><br><br>
                <label for="harga_barang">Harga Barang:</label><br>
                <input type="number" id="harga_barang" name="harga_barang" value="<?php echo $data['harga_barang'] ?>" required><br><br>
                <label for="stok_barang">Stok Barang:</label><br>
                <input type="number" id="stok_barang" name="stok_barang" value="<?php echo $data['stok_barang'] ?>" required><br><br>
        <?php
            }
        }
        ?>
        <!-- Tombol submit untuk mengirim data ke server -->
        <input type="submit" value="Edit Barang" name="submit">
        <!-- Link untuk kembali ke halaman lihat.php -->
        <a href="lihat.php">Kembali</a>
    </form>
</body>
</html>