<?php
require_once './config/database.php';

class Film {
    private $conn;
    private $table_name = "film";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function get_film_by_id($id) {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table_name . " WHERE Id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete_data($id) {
        $stmt = $this->conn->prepare("DELETE FROM " . $this->table_name . " WHERE Id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function update_film($id, $cover, $judul, $genre, $actor, $tahun) {
    $stmt = $this->conn->prepare("UPDATE " . $this->table_name . " SET Cover = :cover, Judul = :judul, Genre = :genre, Actor = :actor, Tahun = :tahun WHERE Id = :id");
    
    // Bind parameter untuk cover, judul, genre, actor, tahun, dan id
    $stmt->bindParam(":cover", $cover, PDO::PARAM_STR);
    $stmt->bindParam(":judul", $judul, PDO::PARAM_STR);
    $stmt->bindParam(":genre", $genre, PDO::PARAM_STR);
    $stmt->bindParam(":actor", $actor, PDO::PARAM_STR);
    $stmt->bindParam(":tahun", $tahun, PDO::PARAM_INT);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    
    // Eksekusi pernyataan
    return $stmt->execute();
}


    public function tampil_data() {
        $hasil = [];
        $data = $this->conn->query("SELECT * FROM " . $this->table_name . " ORDER BY Id ASC");
        while ($d = $data->fetch(PDO::FETCH_ASSOC)) {
            $hasil[] = $d;
        }
        return $hasil;
    }
}
