<?php
// index.php
require_once 'config/database.php';
require_once 'classes/user.php';

$database = new Database();

// mendapatkan koneksi database
// $database->getConnection() digunakan untuk mendapatkan koneksi database yang sudah di buat di kelas Database
// dan hasilnya di simpan di variable $db
$db = $database->getConnection();

// membuat instance/objek dari kelas User
// dan hasilnya di simpan di variable $user
// parameter $db di passing ke konstruktor User
// karena di dalam kelas User, kita membutuhkan koneksi database
// maka kita passing koneksi database yang sudah di buat di kelas Database
$user = new User($db);

// cek apakah request method adalah POST
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // ambil data dari form yang diinputkan
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // jika fungsi login di kelas User mengembalikan nilai true
    if($user->login($username, $password)) {
        // maka redirect ke halaman tampil.php
        header("Location: tampil.php");
        exit();
    } else {
        // jika tidak maka tampilkan pesan error
        $error_message = "Username atau password Tidak Sesuai!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h3 class="text-center">Login</h3>
            <?php if(isset($error_message)): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <form action="" method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
                <a href="register.php" class="btn btn-warning btn-block">Registrasi</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
