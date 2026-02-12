<?php

class Log extends Database {

    public function add($id_user, $aktivitas) {

        $sql = "INSERT INTO tb_log_aktivitas (id_user, aktivitas, waktu_aktivitas)
                VALUES (:id_user, :aktivitas, NOW())";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id_user'   => $id_user,
            ':aktivitas' => $aktivitas
        ]);
    }

    public function getAll() {
        $sql = "SELECT l.*, u.nama_lengkap
                FROM tb_log_aktivitas l
                JOIN tb_user u ON l.id_user = u.id_user
                ORDER BY waktu_aktivitas DESC";

        return $this->db->query($sql)->fetchAll();
    }
}