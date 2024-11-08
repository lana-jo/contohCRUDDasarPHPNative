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
    $stmt->bind_param("ssssi", $cover, $judul, $genre, $actor, $tahun);

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
</head>
<body>
    <h1>Input Data Film</h1>
    <form method="POST" action="" enctype="multipart/form-data">
        <label for="cover">Cover:</label>
        <input type="file" id="cover" name="cover" required>
        <br><br>

        <label for="judul">Judul:</label>
        <input type="text" id="judul" name="judul" required>
        <br><br>

        <label for="genre">Genre:</label>
        <input type="text" id="genre" name="genre" required>
        <br><br>

        <label for="actor">Actor:</label>
        <input type="text" id="actor" name="actor" required>
        <br><br>

        <label for="tahun">Tahun:</label>
        <input type="number" id="tahun" name="tahun" required>
        <br><br>

        <button type="submit">Tambahkan Film</button>
        <a href="Dashboard.php">Kembali ke Daftar Film</a>
    </form>
</body>
</html>
