<?php
include("inc_header.php");
if (!in_array("user", $_SESSION['admin_akses'])) {
    echo "kamu tidak punya akses";
    include("inc_footer.php");
    exit();
}
?>

<br>
<h1>Request barang</h1>
Selamat Datang

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$koneksi = new mysqli("localhost", "root", "", "multiuser");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>
<link rel="stylesheet" href="style.css">
<style>
    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
    }
    th, td {
        border: 1px solid #000;
        padding: 10px;
        text-align: left;
    }
    th {
        background-color: #5490b3;
    }
    tr:nth-child(even) {
        background-color: #b8e1f5;
    }
</style>

<form action="" method="post">
    <table>
        <tr>
            <th>Nama dan departement</th>
            <th>Nama barang</th>
            <th>jumlah barang</th>
            <th>Keperluan</th>
            <th></th>
        </tr>
        <tr>
            <td><input type="text" name="nama" required></td>
            <td><input type="text" name="barang" required></td>
            <td><input type="number" name="jumlah_diperlukan" required min="1"></td>
            <td><input type="text" name="keperluan"></td>
            <td><input type="submit" name="input_request" value="Input"></td>
        </tr>
    </table>
</form>

<h2>Daftar Request</h2>
<table>
    <tr>
        <th>Nama dan departement</th>
        <th>nama barang</th>
        <th>Jumlah barang</th>
        <th>Keperluan</th>
    </tr>
    <?php
    if (isset($_POST['input_request'])) {
        $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
        $barang = mysqli_real_escape_string($koneksi, $_POST['barang']);
        $jumlah = (int)$_POST['jumlah_diperlukan'];
        $keperluan = mysqli_real_escape_string($koneksi, $_POST['keperluan']);

        $sql2 = "INSERT INTO request (nama, barang, jumlah_diperlukan, keperluan) VALUES ('$nama', '$barang', '$jumlah', '$keperluan')";
        $q2 = mysqli_query($koneksi, $sql2);

        if ($q2) {
            echo "<p style='color: green;'>Berhasil request</p>";
        } else {    
            echo "<p style='color: red;'>Gagal request: " . mysqli_error($koneksi) . "</p>";  
        }
    }

    $sql1 = "SELECT * FROM request";
    $q1 = mysqli_query($koneksi, $sql1);

    if ($q1) {
        while ($r1 = mysqli_fetch_array($q1)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($r1['nama']) . "</td>";
            echo "<td>" . htmlspecialchars($r1['barang']) . "</td>";
            echo "<td>" . htmlspecialchars($r1['jumlah_diperlukan']) . "</td>"; 
            echo "<td>" . htmlspecialchars($r1['keperluan']) . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>Tidak ada data.</td></tr>";
    }
    ?>
</table>

<?php
$koneksi->close();
include("inc_footer.php");
?>
