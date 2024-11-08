<?php
include 'config/database.php';
include 'classes/film.php';

$db = new database();
$film = new Film($db->getConnection());

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $film_data = $film->get_film_by_id($id);

    if (!$film_data) {
        die("Film tidak ditemukan.");
    }
} else {
    die("ID film tidak ditentukan.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $genre = $_POST['genre'];
    $actor = $_POST['actor'];
    $tahun = (int)$_POST['tahun'];
    $cover = $film_data['cover'];

    if (isset($_FILES['cover']) && $_FILES['cover']['error'] == UPLOAD_ERR_OK) {
        $cover = $_FILES['cover']['name'];
        move_uploaded_file($_FILES['cover']['tmp_name'], "uploads/" . $cover);
    }

    if ($film->update_film($id, $cover, $judul, $genre, $actor, $tahun)) {
        header("Location: tampil.php");
        exit;
    } else {
        echo "Error: Gagal mengupdate data.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Film</title>
</head>
<body>
    <h1>Edit Data Film</h1>
    <form method="POST" action="" enctype="multipart/form-data">
        <label for="cover">Cover:</label>
        <div>
            <img src="uploads/<?php echo $film_data['cover']; ?>" width="70" height="100" alt="Cover Film">
        </div>
        <input type="file" id="cover" name="cover">
        <p>Biarkan kosong jika tidak ingin mengganti gambar.</p>

        <label for="Judul">Judul:</label>
        <input type="text" id="judul" name="judul" value="<?php echo htmlspecialchars($film_data['judul']); ?>" required>
        <br><br>

        <label for="Genre">Genre:</label>
        <input type="text" id="genre" name="genre" value="<?php echo htmlspecialchars($film_data['genre']); ?>" required>
        <br><br>

        <label for="Actor">Actor:</label>
        <input type="text" id="actor" name="actor" value="<?php echo htmlspecialchars($film_data['actor']); ?>" required>
        <br><br>

        <label for="Tahun">Tahun:</label>
        <input type="number" id="tahun" name="tahun" value="<?php echo htmlspecialchars($film_data['tahun']); ?>" required>
        <br><br>

        <input type="submit" value="Update Film">
        <a href="Dashboard.php">Kembali ke Daftar Film</a>
    </form>
</body>
</html>
