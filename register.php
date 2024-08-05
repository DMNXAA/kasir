<?php
session_start();
include "koneksi.php"; // Menghubungkan ke database

if (isset($_POST['register'])) { // Cek apakah tombol daftar diklik
    $nama = $_POST['username']; // Ambil username dari form
    $pass = $_POST['password']; // Ambil password dari form
    $role = $_POST['role']; // Ambil role dari form

    // Query SQL untuk memeriksa apakah username sudah ada di database
    $cek = mysqli_query($db, "SELECT * FROM users WHERE username = '$nama'");

    if ($cek->num_rows == 0) { // Jika username belum ada di database
        // Hash password menggunakan MD5 (sebaiknya gunakan password_hash di masa mendatang)
        $md5 = md5($pass);

        // Query SQL untuk menambahkan pengguna baru ke database
        $tambah = mysqli_query($db, "INSERT INTO users(username, password, role) VALUES ('$nama', '$md5', '$role')");

        if ($tambah) { // Jika penambahan berhasil
            $_SESSION['pesan'] = "Berhasil membuat akun"; // Simpan pesan berhasil
            header("Location: login.php"); // Arahkan pengguna ke halaman login
            exit(); // Hentikan eksekusi script setelah redirect
        }
    } else {
        // Jika username sudah ada, berikan pesan error
        $_SESSION['pesan'] = "Username sudah ada, gunakan yang lain!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .login-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        .login-container input[type="text"],
        .login-container input[type="password"],
        .login-container select {
            width: calc(100% - 0px);
            /* Mengatur lebar agar konsisten */
            padding: 10px;
            margin: 10px 0;
            /* Margin yang sama di atas dan bawah */
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            /* Memastikan padding termasuk dalam perhitungan lebar */
        }

        .login-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .login-container input[type="submit"]:hover {
            background-color: #218838;
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }

        .register {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Daftar</h2>
        <!-- Tampilkan pesan error jika ada -->
        <?php if (isset($_SESSION['pesan'])) : ?>
            <div class="error"><?php echo $_SESSION['pesan']; ?></div>
        <?php endif; ?>
        <?php unset($_SESSION['pesan']); // Hapus pesan setelah ditampilkan 
        ?>

        <form action="register.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role" required>
                <option value="admin">Admin</option>
                <option value="kasir">Kasir</option>
            </select>
            <input type="submit" value="Daftar" name="register"><br><br>
            <p class="register">Sudah memiliki akun? <a href="login.php">Login</a></p>
        </form>
    </div>
</body>

</html>
