<?php
// Konfigurasi database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'Film';
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $cover = null;
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] == UPLOAD_ERR_OK) {
        $cover = $_FILES['cover']['name'];
        move_uploaded_file($_FILES['cover']['tmp_name'], "uploads/" . $cover); // Pastikan direktori uploads ada
    }

    $judul = $_POST['judul'];
    $genre = $_POST['genre'];
    $actor = $_POST['actor'];
    $tahun = (int)$_POST['tahun'];

    $sql = "INSERT INTO film (cover, judul, genre, actor, tahun) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi",$cover, $judul, $genre, $actor, $tahun);

    if ($stmt->execute()) {
        echo '<script>
            var msg = "Data berhasil ditambahkan!";
            alert(msg);
        </script>';
    } else {
        echo '<script>
            var msg = "Error: " + ' . $stmt->error . ';
            alert(msg);
        </script>';
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Input Data Film</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="input.css">
</head>
<body>
<div class="container">
    <h1 class="text-center">Input Data Film</h1>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label for="cover">Cover:</label>
            <input type="file" class="form-control-file border p-1 d-block rounded" id="cover" name="cover" required>
        </div>
        <div class="form-group">
            <label for="judul">Judul:</label>
            <input type="text" class="form-control" id="judul" name="judul" required>
        </div>
        <div class="form-group">
            <label for="genre">Genre:</label>
            <input type="text" class="form-control" id="genre" name="genre" required>
        </div>
        <div class="form-group">
            <label for="actor">Actor:</label>
            <input type="text" class="form-control" id="actor" name="actor" required>
        </div>
        <div class="form-group">
            <label for="tahun">Tahun:</label>
            <input type="number" class="form-control" id="tahun" name="tahun" required>
        </div>
        <div style="display: flex; justify-content: space-between;">
            <button type="submit" class="btn btn-primary">Tambahkan Film</button>
            <a class="btn btn-secondary" href="tampil.php">Kembali ke Daftar Film</a>
        </div>
</div>
</body>
</html>

