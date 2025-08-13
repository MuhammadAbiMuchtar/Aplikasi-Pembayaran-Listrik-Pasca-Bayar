<?php
/*
 * Script ini adalah halaman registrasi akun baru untuk pelanggan PLN.
 * Alur:
 * - Memastikan koneksi database aktif
 * - Menyediakan form registrasi pelanggan (ID, nama, alamat, email, password, daya)
 * - Validasi email/username unik sebelum insert
 * - Menyimpan data pelanggan baru ke database
 * - Terdapat fungsi PHP dan JS untuk generate ID pelanggan unik otomatis
 * - Menampilkan pesan sukses/gagal
 */
include 'config/koneksi.php';
$msg = '';

// Fungsi PHP untuk generate username unik otomatis untuk pelanggan
function generateUsername($koneksi) {
    /*
     * Fungsi ini menghasilkan ID pelanggan unik dengan prefix '12' dan 6 digit acak.
     * Mengecek ke database agar tidak ada duplikasi ID.
     * Return: string ID pelanggan unik
     */
    $prefix = '12';
    do {
        $rand = str_pad(strval(rand(0, 999999)), 6, '0', STR_PAD_LEFT);
        $username = $prefix . $rand;
        $cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE id_pelanggan='$username'"));
    } while ($cek > 0);
    return $username;
}

$username = isset($_POST['username']) ? $_POST['username'] : generateUsername($koneksi);

if (isset($_POST['register'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $username = $_POST['username'];
    $daya = $_POST['daya'];
    $tanggal_registrasi = date('Y-m-d');
    
    // Validasi email/username unik
    $cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE email='$email' OR id_pelanggan='$username'"));
    if ($cek > 0) {
        $msg = '<div class="alert alert-danger">Email atau Username sudah terdaftar!</div>';
    } else {
        mysqli_query($koneksi, "INSERT INTO pelanggan (id_pelanggan, nama, password, email, alamat, daya, tanggal_registrasi) VALUES ('$username', '$nama', '$password', '$email', '$alamat', '$daya', '$tanggal_registrasi')");
        $msg = '<div class="alert alert-success">Registrasi berhasil! Username Anda: <b>'.$username.'</b> Silakan login.</div>';
        $username = generateUsername($koneksi);
    }
}
$tarif = mysqli_query($koneksi, "SELECT * FROM tarif ORDER BY daya ASC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Akun - Sistem PLN</title>
    <?php include 'assets/bootstrap.html'; ?>
    <style>
        body {
            background: #f4faff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px 0;
        }
        .register-container {
            background: #fff;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            max-width: 500px;
            width: 100%;
            margin: 0 auto;
        }
        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .register-header h2 {
            color: #0074c7;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .register-header .subtitle {
            color: #666;
            font-size: 14px;
        }
        .form-label {
            font-weight: bold;
            color: #0074c7;
            margin-bottom: 8px;
        }
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #0074c7;
            box-shadow: 0 0 0 0.2rem rgba(0, 116, 199, 0.25);
        }
        .btn-register {
            background: #0074c7;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: bold;
            width: 100%;
            transition: all 0.3s ease;
        }
        .btn-register:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }
        .login-link a {
            color: #0074c7;
            font-weight: bold;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .login-link a:hover {
            color: #ffe600;
        }
        .pln-accent {
            color: #ffe600;
            font-weight: bold;
        }
        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
    <script>
    // Fungsi JS untuk generate username random 8 digit untuk pelanggan
    function randomUsername() {
        var prefix = '12';
        var rand = Math.floor(Math.random() * 1000000).toString().padStart(6, '0');
        return prefix + rand;
    }
    window.onload = function() {
        document.getElementById('username').value = randomUsername();
    };
    </script>
</head>
<body>
<div class="container">
    <div class="register-container">
        <div class="register-header">
            <h2>Daftar Akun <span class="pln-accent">PLN</span></h2>
            <div class="subtitle">Registrasi Pelanggan Baru</div>
        </div>
        
        <?= $msg ?>
        
        <form method="POST" id="registerForm">
            <div class="mb-3">
                <label class="form-label">ID Pelanggan (8 digit):</label>
                <input type="text" name="username" id="username" class="form-control" readonly required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Nama:</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Alamat:</label>
                <textarea name="alamat" class="form-control" rows="3" required></textarea>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Daya (Watt):</label>
                <select name="daya" class="form-control" required>
                    <option value="">-- Pilih Daya --</option>
                    <?php mysqli_data_seek($tarif, 0); while($row = mysqli_fetch_assoc($tarif)): ?>
                        <option value="<?= $row['daya'] ?>"><?= $row['daya'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="mb-3">
                <button type="submit" name="register" class="btn btn-register btn-primary">Daftar</button>
            </div>
        </form>
        
        <div class="login-link">
            Sudah punya akun? <a href="login.php">Login</a>
        </div>
    </div>
</div>
</body>
</html> 