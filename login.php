<?php
session_start();
include "koneksi.php"; // Menghubungkan ke database

if (isset($_POST['login'])) { // Cek apakah tombol login diklik
    $nama = $_POST['username']; // Ambil username dari form
    $pass = $_POST['password']; // Ambil password dari form

    // Query SQL untuk memeriksa apakah username ada di database
    $sql = "SELECT * FROM users WHERE username = '$nama'";
    $query = mysqli_query($db, $sql);

    if ($query->num_rows > 0) { // Jika username ditemukan
        // Hash password menggunakan MD5 (sebaiknya gunakan password_hash di masa mendatang)
        $md5 = md5($pass);
        // Query SQL untuk memverifikasi username dan password
        $masuk = "SELECT * FROM users WHERE username = '$nama' AND password = '$md5'";
        $cek = mysqli_query($db, $masuk);

        if ($cek->num_rows > 0) { // Jika username dan password cocok
            $data = $cek->fetch_array(); // Ambil data pengguna dari database

            // Cek role pengguna dan arahkan sesuai dengan role mereka
            if ($data['role'] == "admin") {
                $_SESSION['pesan'] = "Berhasil masuk";
                header("Location: lihat.php"); // Arahkan ke halaman admin
                exit(); // Hentikan eksekusi script setelah redirect
            } elseif ($data['role'] == "kasir") {
                $_SESSION['pesan'] = "Berhasil masuk";
                header("Location: kasir.php"); // Arahkan ke halaman kasir
                exit(); // Hentikan eksekusi script setelah redirect
            } else {
                $_SESSION['pesan'] = "Belum ada role";
                header("Location: login.php"); // Arahkan kembali ke halaman login
                exit(); // Hentikan eksekusi script setelah redirect
            }
        } else {
            // Jika password tidak cocok
            $_SESSION['pesan'] = "Password salah";
            header("Location: login.php"); // Arahkan kembali ke halaman login
            exit(); // Hentikan eksekusi script setelah redirect
        }
    } else {
        // Jika username tidak ditemukan di database
        $_SESSION['pesan'] = "Username tidak ada";
        header("Location: login.php"); // Arahkan kembali ke halaman login
        exit(); // Hentikan eksekusi script setelah redirect
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        .login-container input[type="password"] {
            width: calc(100% - 20px);
            /* Mengatur lebar agar konsisten */
            padding: 10px;
            margin: 10px 0;
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
        <h2>Login</h2>
        <?php if (isset($_SESSION['pesan'])) : ?>
            <div class="error"><?php echo $_SESSION['pesan']; ?></div>
        <?php endif; ?>
        <?php unset($_SESSION['pesan']); // Hapus pesan setelah ditampilkan 
        ?>
        <form action="login.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login" name="login"><br><br>
            <p class="register">Belum memiliki akun? <a href="register.php">Daftar</a></p>
        </form>
    </div>
</body>

</html>
