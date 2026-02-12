<?php

class Database {
    protected $db;

    public function __construct() {
        try {
            $this->db = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
                DB_USER,
                DB_PASS
            );
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, "/var/log/app/db_error.log");
        die("Maaf, terjadi kesalahan teknis. Tim kami sedang memperbaikinya.");
            // die("Database error: " . $e->getMessage());
        }
    }
}
