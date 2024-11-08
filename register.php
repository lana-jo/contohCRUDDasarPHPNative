<?php
// register.php
require_once 'config/database.php';
require_once 'classes/user.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

// Cek apakah request method adalah POST
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form yang diinputkan
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Jika fungsi register di kelas User mengembalikan nilai true
    if($user->register($username, $password)) {
        // maka set pesan sukses
        $success_message = "Registrasi berhasil! Silakan login.";
    } else {
        // jika tidak maka set pesan error
        $error_message = "Registrasi gagal. Username mungkin sudah digunakan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registrasi</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h3 class="text-center">Registrasi</h3>
            <?php if(isset($success_message)): ?>
                <div class="alert alert-success"><?php echo $success_message; ?></div>
            <?php elseif(isset($error_message)): ?>
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
                <button type="submit" class="btn btn-primary btn-block">Daftar</button>
            </form>
            <p class="text-center mt-3">Sudah punya akun? <a href="index.php">Login di sini</a></p>
        </div>
    </div>
</div>
</body>
</html>
