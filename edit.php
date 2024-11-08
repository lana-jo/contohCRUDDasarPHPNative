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
    $cover = $film_data['cover']; // Simpan cover lama

    // Cek apakah ada gambar baru yang diupload
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] == UPLOAD_ERR_OK) {
        // Ambil nama file gambar baru
        $cover = $_FILES['cover']['name'];
        // Pindahkan file ke folder uploads
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="text-center">Edit Data Film</h1>
        <form method="POST" action="" enctype="multipart/form-data"> <!-- Tambahkan enctype -->
            <div class="form-group">
                <label for="cover">Cover:</label>
                <div>
                    <img src="uploads/<?php echo $film_data['cover']; ?>" width="70" height="100" alt="Cover Film">
                </div>
                <input type="file" class="form-control-file border p-1 d-block rounded" id="cover" name="cover">
                <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengganti gambar.</small>
            </div>
            <div class="form-group">
                <label for="Judul">Judul:</label>
                <input type="text" class="form-control" id="judul" name="judul" value="<?php echo htmlspecialchars($film_data['judul']); ?>" required>
            </div>
            <div class="form-group">
                <label for="Genre">Genre:</label>
                <input type="text" class="form-control" id="genre" name="genre" value="<?php echo htmlspecialchars($film_data['genre']); ?>" required>
            </div>
            <div class="form-group">
                <label for="Actor">Actor:</label>
                <input type="text" class="form-control" id="actor" name="actor" value="<?php echo htmlspecialchars($film_data['actor']); ?>" required>
            </div>
            <div class="form-group">
                <label for="Tahun">Tahun:</label>
                <input type="number" class="form-control" id="tahun" name="tahun" value="<?php echo htmlspecialchars($film_data['tahun']); ?>" required>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <input type="submit" class="btn btn-primary" value="Update Film">
                <a href="tampil.php" class="btn btn-secondary">Kembali ke Daftar Film</a>
            </div>
        </form>
    </div>
</body>
</html>
