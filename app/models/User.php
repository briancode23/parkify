<?php

require_once 'core/Database.php';

class User extends Database {

    public function findByUsername($username) {
        $sql = "SELECT * FROM tb_user 
                WHERE username = ? 
                AND status_aktif = 1
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll() {
        $stmt = $this->db->query(
            "SELECT id_user, nama_lengkap, username, role, status_aktif
             FROM tb_user"
        );

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll() { 
        $stmt = $this->db->query("
        SELECT COUNT(*) as total FROM tb_user");
        return $stmt->fetch()['total'];
    }

    // nonaktifkan user
    public function deactivate($id) {
        $stmt = $this->db->prepare(
            "UPDATE tb_user SET status_aktif = 0 WHERE id_user = ?"
        );
        return $stmt->execute([$id]);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM tb_user WHERE id_user = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM tb_user WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO tb_user 
                (nama_lengkap, username, password, role, status_aktif)
                VALUES (?, ?, ?, ?, 1)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $data['nama'],
            $data['username'],
            $data['password'],
            $data['role']
        ]);
    }
}