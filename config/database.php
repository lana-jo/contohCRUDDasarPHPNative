<?php
// config/Database.php
class Database {
    private $host = "localhost";
    private $db_name = "film";
    private $username = "root";
    private $password = "";
    public $conn;

    /**
     * Fungsi untuk menghubungkan ke database
     *
     * Fungsi ini akan membuat objek PDO yang digunakan untuk menghubungkan
     * ke database. Jika terjadi error, maka error tersebut akan ditampilkan.
     *
     * PDO (PHP Data Objects) adalah extension PHP yang digunakan untuk
     * mengakses database. PDO menyediakan interface yang sama untuk
     * mengakses berbagai macam database seperti MySQL, PostgreSQL,
     * SQLite, Oracle, dll. PDO juga menyediakan fitur-fitur seperti
     * parameterized query dan prepared statement yang dapat membantu
     * mencegah SQL injection.
     */
    public function getConnection() {
        $this->conn = null;
        try {
            // Buat objek PDO dengan host, nama database, username, dan password
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" .
             $this->db_name, $this->username, $this->password);
            
             // Set atribut error mode menjadi exception
            // Atribut error mode ini digunakan untuk menentukan bagaimana PDO
            // menangani error yang terjadi ketika berinteraksi dengan database.
            // Nilai PDO::ERRMODE_EXCEPTION akan membuat PDO melempar exception
            // jika terjadi error. Dengan demikian, kita dapat menangani error
            // tersebut dengan menggunakan try-catch.
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            // Jika terjadi error, maka tampilkan error tersebut
            echo "Connection error: " . $exception->getMessage();
        }
        // Kembalikan objek PDO yang telah dibuat
        return $this->conn;
    }
}
?>
