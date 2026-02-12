<?php
class Area extends Database {
    public function getAllArea() {
        $sql = "SELECT * FROM tb_area_parkir";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function tambahArea($data) {
        $sql = "INSERT INTO tb_area_parkir (nama_area, kapasitas, terisi) VALUES (?, ?, 0)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$data['nama_area'], $data['kapasitas']]);
    }

    public function getAreaById($id) {
        $stmt = $this->db->prepare("SELECT * FROM tb_area_parkir WHERE id_area = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editArea($id, $data) {
        $sql = "UPDATE tb_area_parkir SET nama_area = ?, kapasitas = ? WHERE id_area = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$data['nama_area'], $data['kapasitas'], $id]);
    }

    public function countArea() {
        $sql = "SELECT COUNT(*) as totalArea FROM tb_area_parkir";
        $stmt = $this->db->query($sql);
        return $stmt->fetch()['totalArea'];
    }
}