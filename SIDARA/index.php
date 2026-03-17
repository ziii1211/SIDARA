<?php
session_start();
include 'config/koneksi.php';

if (isset($_POST['masuk'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);

    $query = mysqli_query($conn, "SELECT * FROM pengguna WHERE nama_pengguna='$username' AND kata_sandi='$password'");
    $cek = mysqli_num_rows($query);

    if ($cek > 0) {
        $data = mysqli_fetch_assoc($query);
        
        // Simpan Data Utama
        $_SESSION['id_pengguna'] = $data['id_pengguna'];
        $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
        $_SESSION['peran'] = $data['peran'];
        
        // Simpan NIP & Divisi (Gunakan tanda strip jika kosong agar tidak error)
        $_SESSION['nip'] = !empty($data['nip']) ? $data['nip'] : '-';
        $_SESSION['divisi'] = !empty($data['divisi']) ? $data['divisi'] : '-';

        // Redirect sesuai Peran
        if ($data['peran'] == 'admin') {
            echo "<script>window.location='admin/dashboard.php';</script>";
        } elseif ($data['peran'] == 'pimpinan') {
            echo "<script>window.location='pimpinan/dashboard.php';</script>";
        } elseif ($data['peran'] == 'staff') {
            echo "<script>window.location='staff/dashboard.php';</script>";
        }
    } else {
        echo "<script>alert('Username atau Password salah!'); window.location='index.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login Sistem Kearsipan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/sidara/assets/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .logo-container {
            display: flex;
            align-items: center;
            gap: 15px; 
            margin-bottom: 40px;
        }
        .logo-container img {
            height: 60px;
            width: auto;
        }
        .logo-text {
            font-size: 32px;
            font-weight: 800;
            color: #198754; 
            letter-spacing: 2px;
            text-transform: uppercase;
        }
    </style>
</head>
<body class="login-page-body">
    <div class="login-wrapper">
        <div class="login-left">
            <div class="illustration-box">
                  <img src="img/arsip.png" alt="Ilustrasi Arsip">
            </div>
            <div class="left-text-content">
                <h2>Efisien, Terstruktur dan Fleksibel<br>Kejaksaan Negeri Banjarmasin</h2>
                <p>Sistem Informasi Kearsipan Perkara pada Kejaksaan Negeri Banjarmasin meningkatkan efisiensi dalam pengelolaan arsip secara elektronik.</p>
            </div>
        </div>

        <div class="login-right">
            <div class="login-form-container">
                <div class="logo-container">
                    <img src="/sidara/img/kjn.webp" alt="Logo Kejaksaan">
                    <span class="logo-text">SIDARA</span>
                </div>

                <h3>Login</h3>
                <p class="subtitle">Silakan masukkan detail Anda untuk melanjutkan.</p>

                <form method="POST">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" required placeholder="Masukkan Username">
                    </div>
                    <div class="form-group password-group">
                        <label>Password</label>
                        <input type="password" name="password" id="password" required placeholder="Masukkan Password">
                    </div>
                    <button type="submit" name="masuk" class="btn-primary">Masuk</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

