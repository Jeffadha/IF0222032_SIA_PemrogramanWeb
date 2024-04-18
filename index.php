<?php

require_once "app/Mhsw.php";

$mhsw = new Mhsw();

$updateId = "";
$updateNim = "";
$updateNama = "";
$updateAlamat = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["tambah"])) {
        $nim = $_POST["nim"];
        $nama = $_POST["nama"];
        $alamat = $_POST["alamat"];
        $result = $mhsw->tambahData($nim, $nama, $alamat);
    } elseif (isset($_POST["update"])) {
        $updateId = $_POST["id"];
        $updateNim = $_POST["nim"];
        $updateNama = $_POST["nama"];
        $updateAlamat = $_POST["alamat"];
        $result = $mhsw->updateData($updateId, $updateNim, $updateNama, $updateAlamat);
        $updateId = "";
    } elseif (isset($_POST["hapus"])) {
        $id = $_POST["id"];
        $result = $mhsw->hapusData($id);
    } else {
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'update_') !== false) {
                $updateId = str_replace('update_', '', $key);
                $rows = $mhsw->ambilData();
                foreach ($rows as $row) {
                    if ($row['mhsw_id'] == $updateId) {
                        $updateNim = $row['mhsw_nim'];
                        $updateNama = $row['mhsw_nama'];
                        $updateAlamat = $row['mhsw_alamat'];
                        break;
                    }
                }
                break;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="layout/assets/css/style.css">
    <title>Data Mahasiswa</title>
</head>
<body>
<h2>Data Mahasiswa</h2>
<table border="1" style="width: 750px;">
    <tr>
        <th>NO</th>
        <th>NIM</th>
        <th>NAMA</th>
        <th>ALAMAT</th>
        <th>ACTION</th>
    </tr>
    <?php 
    $rows = $mhsw->ambilData();
    foreach ($rows as $row) { ?>
    <tr>
        <td><?php echo $row['mhsw_id']; ?></td>
        <td><?php echo $row['mhsw_nim']; ?></td>
        <td><?php echo $row['mhsw_nama']; ?></td>
        <td><?php echo $row['mhsw_alamat']; ?></td>
        <td align="center">
            <form method="post">
                <input type="hidden" name="id" value="<?php echo $row['mhsw_id']; ?>">
                <input type="submit" name="update_<?php echo $row['mhsw_id']; ?>" value="Update">
                <input type="submit" name="hapus" value="Hapus">
            </form>
        </td>
    </tr>
    <?php } ?>
</table>
<hr color="black">
<?php if (empty($updateId)) { ?>
    <h2>Tambah Data</h2>
    <form method="post">
        <label for="nim">NIM:</label><br>
        <input type="text" id="nim" name="nim"><br>
        <label for="nama">Nama:</label><br>
        <input type="text" id="nama" name="nama"><br>
        <label for="alamat">Alamat:</label><br>
        <textarea id="alamat" name="alamat"></textarea><br><br>
        <input type="submit" name="tambah" value="Tambah Data">
    </form>
<?php } else { ?>
    <h2>Update Data</h2>
    <form method="post">
        <input type="hidden" name="id" value="<?php echo $updateId; ?>">
        <label for="nim">NIM:</label><br>
        <input type="text" id="nim" name="nim" value="<?php echo $updateNim; ?>"><br>
        <label for="nama">Nama:</label><br>
        <input type="text" id="nama" name="nama" value="<?php echo $updateNama; ?>"><br>
        <label for="alamat">Alamat:</label><br>
        <textarea id="alamat" name="alamat"><?php echo $updateAlamat; ?></textarea><br><br>
        <input type="submit" name="update" value="Update">
    </form>
<?php } ?>
</body>
</html>

