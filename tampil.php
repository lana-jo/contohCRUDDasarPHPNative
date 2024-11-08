<?php
include './config/database.php';
include './classes/film.php';

$db = new database();
$film = new Film($db->getConnection());

session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda belum login. Silakan login terlebih dahulu.'); window.location = 'index.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD OOP PHP</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="tampil.css">
</head>
<body>  
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">CRUD OOP PHP</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="input.php">Input Data</a>
                </li>
            </ul>
        </div>
        <form class="form-inline my-2 my-lg-0" action="logout.php" method="POST">
            <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Logout</button>
        </form>
    </nav>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Cover</th>
                <th scope="col">Judul</th>
                <th scope="col">Genre</th>
                <th scope="col">Actor</th>
                <th scope="col">Tahun</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $id = 1;
            foreach ($film->tampil_data() as $x) {
            ?>
                <tr>
                    <th scope="row"><?php echo $id++; ?></th>
                    <td><img src="uploads/<?php echo $x['cover']; ?>" width="70" height="100"></td>
                    <td><?php echo htmlspecialchars($x['judul']); ?></td>
                    <td><?php echo htmlspecialchars($x['genre']); ?></td>
                    <td><?php echo htmlspecialchars($x['actor']); ?></td>
                    <td><?php echo htmlspecialchars($x['tahun']); ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $x['id']; ?>&aksi=edit" class="btn btn-warning" onclick="return confirm('Apakah Anda yakin ingin mengedit data ini?');">Edit</a>
                        <a href="delete.php?id=<?php echo $x['id']; ?>&aksi=delete" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Delete</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</body>
</html>

