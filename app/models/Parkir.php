<?php

class Parkir extends Database
{

    public function kendaraanMasuk($data)
    {
        $sql = "INSERT INTO tb_transaksi
                (id_kendaraan, waktu_masuk, id_tarif, durasi_jam, biaya_total, status, id_user, id_area)
                VALUES
                (:id_kendaraan, NOW(), :id_tarif, 0, 0, 'masuk', :id_user, :id_area)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id_kendaraan' => $data['id_kendaraan'],
            ':id_tarif' => $data['id_tarif'],
            ':id_user' => $data['id_user'],
            ':id_area' => $data['id_area']
        ]);
        return $this->db->lastInsertId();
    }

    public function kendaraanKeluar($id_parkir, $durasi, $total)
    {
        $sql = "UPDATE tb_transaksi
                SET waktu_keluar = NOW(),
                    durasi_jam = :durasi,
                    biaya_total = :total,
                    status = 'keluar'
                WHERE id_parkir = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':durasi' => $durasi,
            ':total' => $total,
            ':id' => $id_parkir
        ]);
    }

    public function getAktif()
    {
        $sql = "SELECT t.*, k.plat_nomor
                FROM tb_transaksi t
                JOIN tb_kendaraan k ON t.id_kendaraan = k.id_kendaraan
                WHERE t.status = 'masuk' ORDER BY waktu_masuk DESC";

        return $this->db->query($sql)->fetchAll();
    }

    public function countAktif()
    {
        $stmt = $this->db->query("
        SELECT COUNT(*) as total FROM tb_transaksi WHERE status='masuk' AND waktu_keluar IS NULL");
        return $stmt->fetch()['total'];
    }

    public function countHariIni()
    {
        $query = "SELECT COUNT(*) AS total FROM tb_transaksi WHERE DATE(waktu_masuk) = CURDATE()";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function countHariIniOut()
    {
        $query = "SELECT COUNT(*) AS total FROM tb_transaksi WHERE DATE(waktu_keluar) = CURDATE()";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getById($id)
    {
        $sql = "SELECT t.*,
                       k.plat_nomor, k.jenis_kendaraan,
                       u.nama_lengkap,
                       tr.tarif_per_jam,
                       a.nama_area
                FROM tb_transaksi t
                JOIN tb_kendaraan k ON t.id_kendaraan = k.id_kendaraan
                JOIN tb_user u ON t.id_user = u.id_user
                JOIN tb_tarif tr ON t.id_tarif = tr.id_tarif
                JOIN tb_area_parkir a ON t.id_area = a.id_area
                WHERE t.id_parkir = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getMasukById($id)
    {
        $sql = "SELECT t.*, k.plat_nomor, k.jenis_kendaraan,
                       u.nama_lengkap, a.nama_area
                FROM tb_transaksi t
                JOIN tb_kendaraan k ON t.id_kendaraan = k.id_kendaraan
                JOIN tb_user u ON t.id_user = u.id_user
                JOIN tb_area_parkir a ON t.id_area = a.id_area
                WHERE t.id_parkir = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getKeluarById($id)
    {
        $sql = "SELECT t.*, k.plat_nomor, k.jenis_kendaraan,
                       u.nama_lengkap, a.nama_area,
                       tr.tarif_per_jam
                FROM tb_transaksi t
                JOIN tb_kendaraan k ON t.id_kendaraan = k.id_kendaraan
                JOIN tb_user u ON t.id_user = u.id_user
                JOIN tb_area_parkir a ON t.id_area = a.id_area
                JOIN tb_tarif tr ON t.id_tarif = tr.id_tarif
                WHERE t.id_parkir = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateKeluar($id, $waktuKeluar, $durasi, $total)
    {
        $sql = "UPDATE tb_transaksi
            SET waktu_keluar = :keluar,
                durasi_jam = :durasi,
                biaya_total = :total,
                status = 'keluar'
            WHERE id_parkir = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':keluar' => $waktuKeluar,
            ':durasi' => $durasi,
            ':total' => $total,
            ':id' => $id
        ]);
    }

    public function grafikHarian()
    {
        $stmt = $this->db->query("
        SELECT DATE(waktu_masuk) as tgl,
               COUNT(*) as total
        FROM tb_transaksi
        GROUP BY DATE(waktu_masuk)
        ORDER BY tgl ASC
    ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}