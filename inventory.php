<?php
include("inc_header.php");
if (!in_array("admin", $_SESSION['admin_akses'])) {
    echo "kamu tidak punya akses";
    include("inc_footer.php");
    exit();
}
?>

<br>
<h1>Halaman Inventory Admin</h1>
Selamat Datang Admin

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
    input[type="submit"] {
        background-color: ##2cd4c0;
    }

</style>

<form action="" method="post">
    <table>
        <tr>
            <th>Nama Item</th>
            <th>Jumlah</th>
            <th>Barang Dari</th>
            <th>Tanggal</th>
            <th></th>
        </tr>
        <tr>
            <td><input type="text" name="nama_item" required></td>
            <td><input type="number" name="jumlah" required min="1"></td>
            <td><input type="text" name="barang_dari"></td>
            <td><input type="text" name="tanggal" required></td>
            <td><input type="submit" name="input_item" value="Input"></td>
        </tr>
    </table>
</form>

<h2>Daftar Item</h2>
<table>
    <tr>
        <th>Nama Item</th>
        <th>Jumlah</th>
        <th>Barang Dari</th>
        <th>Tanggal</th>
        <th>Hapus</th>
    </tr>
    <?php
    if (isset($_POST['input_item'])) {
        $nama_item = mysqli_real_escape_string($koneksi, $_POST['nama_item']);
        $jumlah = (int)$_POST['jumlah'];
        $barang_dari = mysqli_real_escape_string($koneksi, $_POST['barang_dari']);
        $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal']);

        $sql2 = "INSERT INTO item (nama_item, jumlah, barang_dari, tanggal) VALUES ('$nama_item', '$jumlah', '$barang_dari', '$tanggal')";
        $q2 = mysqli_query($koneksi, $sql2);

        if ($q2) {
            echo "<p style='color: green;'>Input item berhasil</p>";
        } else {
            echo "<p style='color: red;'>Input item gagal: " . mysqli_error($koneksi) . "</p>";
        }
    }

    if (isset($_GET['delete_nama']) && isset($_GET['delete_barang']) && isset($_GET['delete_tanggal'])) {
        $delete_nama = mysqli_real_escape_string($koneksi, $_GET['delete_nama']);
        $delete_barang = (int)$_GET['delete_barang'];
        $delete_tanggal = mysqli_real_escape_string($koneksi, $_GET['delete_tanggal']);

        $sql3 = "DELETE FROM item WHERE nama_item='$delete_nama' AND jumlah='$delete_barang' AND tanggal='$delete_tanggal'";
        $q3 = mysqli_query($koneksi, $sql3);

        if ($q3) {
            echo "<p style='color: green;'>Data berhasil dihapus</p>";
        } else {
            echo "<p style='color: red;'>Gagal menghapus data: " . mysqli_error($koneksi) . "</p>";
        }
    }

    $sql1 = "SELECT * FROM item";
    $q1 = mysqli_query($koneksi, $sql1);

    if ($q1) {
        while ($r1 = mysqli_fetch_array($q1)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($r1['nama_item']) . "</td>";
            echo "<td>" . htmlspecialchars($r1['jumlah']) . "</td>";
            echo "<td>" . htmlspecialchars($r1['barang_dari']) . "</td>";
            echo "<td>" . htmlspecialchars($r1['tanggal']) . "</td>";
            echo "<td><a href='?delete_nama=" . urlencode($r1['nama_item']) . "&delete_barang=" . $r1['jumlah'] . "&delete_tanggal=" . $r1['tanggal'] . "'>Hapus</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>Tidak ada data.</td></tr>";
    }
    ?>
</table>

<?php
$koneksi->close();
include("inc_footer.php");
?>
