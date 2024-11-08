<?php
// classes/User.php

// Memuat file konfigurasi database
require_once './config/database.php';

// Kelas User untuk menghandle user login dan registrasi
class User {
    private $conn;
    private $table_name = "users";

    // Konstruktor untuk menghubungkan ke database
    public function __construct($db) {
        $this->conn = $db;
    }

    // Fungsi untuk melakukan login
    public function login($username, $password) {
    // Query untuk mendapatkan data user berdasarkan username
        // :username digunakan sebagai parameter untuk menggantikan nilai username di query
        // LIMIT 1 digunakan untuk mengambil hanya 1 baris data, karena kita hanya perlu 1 data user yang cocok dengan username yang diinput
    $query = "SELECT * FROM " . $this->table_name . " WHERE username = :username LIMIT 1";

    $stmt = $this->conn->prepare($query);// Prepare query untuk menggantikan nilai parameter :username dengan nilai yang diinputkan
    
    // Bind parameter :username dengan nilai yang diinputkan
    $stmt->bindParam(":username", $username);
    // Jalankan query
    $stmt->execute();

    // Jika data user ditemukan, maka cek password
    if ($stmt->rowCount() > 0) {
        // Jalankan query dan simpan hasilnya dalam variable $row
            // PDO::FETCH_ASSOC digunakan untuk mengambil data dalam bentuk array asosiatif
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Jika password yang diinputkan cocok dengan password yang dienkripsi di database,
            // maka fungsi password_verify() akan mengembalikan nilai true
        if (password_verify($password, $row['password'])) {
            
            // Mulai sesi dan simpan username
            session_start();
            $_SESSION['username'] = $username;
            return true;
        }
    }
    return false;
}


    // Fungsi untuk menambahkan user baru
    public function register($username, $password) {
        // Query untuk menambahkan data user baru
        $query = "INSERT INTO " . $this->table_name . " (username, password) VALUES (:username, :password)";
        $stmt = $this->conn->prepare($query);
        
        // Enkripsi password sebelum disimpan ke database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Bind parameter :username dan :password dengan nilai yang diinputkan
            // Dengan menggunakan bind parameter, maka nilai yang diinputkan tidak akan dianggap sebagai
            // bagian dari query, sehingga mengurangi resiko adanya SQL Injection. Nilai yang diinputkan
            // akan dianggap sebagai nilai yang akan dijalankan di dalam query, bukan sebagai bagian dari
            // query itu sendiri.
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $hashed_password);
        
        // Jika query berhasil, maka return true
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>

