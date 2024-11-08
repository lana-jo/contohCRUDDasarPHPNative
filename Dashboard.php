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
</head>
<body>
    <h2>CRUD OOP PHP</h2>
    <nav>
        <a href="#">Home</a> |
        <a href="input1.php">Input Data</a> |
        <form action="logout.php" method="POST" style="display:inline;">
            <button type="submit">Logout</button>
        </form>
    </nav>
    <br><br>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Id</th>
                <th>Cover</th>
                <th>Judul</th>
                <th>Genre</th>
                <th>Actor</th>
                <th>Tahun</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $id = 1;
            foreach ($film->tampil_data() as $x) {
            ?>
                <tr>
                    <td><?php echo $id++; ?></td>
                    <td><img src="Images/<?php echo $x['cover']; ?>" width="70" height="100"></td>
                    <td><?php echo htmlspecialchars($x['judul']); ?></td>
                    <td><?php echo htmlspecialchars($x['genre']); ?></td>
                    <td><?php echo htmlspecialchars($x['actor']); ?></td>
                    <td><?php echo htmlspecialchars($x['tahun']); ?></td>
                    <td>
                        <a href="edit1.php?id=<?php echo $x['id']; ?>&aksi=edit" onclick="return confirm('Apakah Anda yakin ingin mengedit data ini?');">Edit</a> |
                        <a href="delete.php?id=<?php echo $x['id']; ?>&aksi=delete" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Delete</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</body>
</html>
