<?php

class Mhsw {

    private static $db;

    public function __construct()
    {
        try {
            self::$db = new PDO("mysql:host=localhost;dbname=dbakademik", "root", "");
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error " . $e->getMessage());
        }
    }

    public function tambahData(string $nim, string $nama, ?string $alamat = null) {
        try {
            $existingStudent = self::$db->prepare("SELECT * FROM tb_mhsw WHERE mhsw_nim = ?");
            $existingStudent->execute([$nim]);
            if ($existingStudent->rowCount() > 0) {
                return "Error: Siswa dengan NIM $nim sudah ada";
            }
            $sql = "INSERT INTO tb_mhsw (mhsw_nim, mhsw_nama, mhsw_alamat) VALUES (?, ?, ?)";
            $stmt = self::$db->prepare($sql);
            $stmt->execute([$nim, $nama, $alamat]);
            return true;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }


    public function ambilData() {
        try {
            $sql = "SELECT * FROM tb_mhsw";
            $stmt = self::$db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function updateData(int $id, ?string $nim = null, ?string $nama = null, ?string $alamat = null) {
        try {
            $sql = "UPDATE tb_mhsw SET mhsw_nim=?, mhsw_nama=?, mhsw_alamat=? WHERE mhsw_id=?";
            $stmt = self::$db->prepare($sql);
            $stmt->execute([$nim, $nama, $alamat, $id]);
            return true;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function hapusData(int $id) {
        try {
            $sql = "DELETE FROM tb_mhsw WHERE mhsw_id=?";
            $stmt = self::$db->prepare($sql);
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
}

?>
