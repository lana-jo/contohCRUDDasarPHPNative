<?php

include 'database.php';
include 'classes/film.php';

$db = new database();
$film = new Film($db->getConnection());

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($film->delete_data($id)) {
        header("Location: tampil.php?message=Data berhasil dihapus");
        exit();
    } else {
        header("Location: tampil.php?message=Gagal menghapus data");
        exit();
    }
} else {
    header("Location: tampil.php?message=ID tidak valid");
    exit();
}
