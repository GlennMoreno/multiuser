<?php
include("inc_header.php");
if (!in_array("user", $_SESSION['admin_akses'])) {
    echo "kamu tidak punya akses";
    include("inc_footer.php");
    exit();
}
?>

<br>
<h1>Halaman Inventory</h1>
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



<h2>Daftar Item</h2>
<table>
    <tr>
        <th>Nama Item</th>
        <th>Jumlah</th>
        <th>Barang Dari</th>
    </tr>
    <?php
    if (isset($_POST['input_item'])) {
        $nama_item = mysqli_real_escape_string($koneksi, $_POST['nama_item']);
        $jumlah = (int)$_POST['jumlah'];
        $barang_dari = mysqli_real_escape_string($koneksi, $_POST['barang_dari']);

        $sql2 = "INSERT INTO item (nama_item, jumlah, barang_dari) VALUES ('$nama_item', '$jumlah', '$barang_dari')";
        $q2 = mysqli_query($koneksi, $sql2);

        if ($q2) {
            echo "<p style='color: green;'>Input item berhasil</p>";
        } else {    
            echo "<p style='color: red;'>Input item gagal: " . mysqli_error($koneksi) . "</p>";  
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
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='3'>Tidak ada data.</td></tr>";
    }
    ?>
</table>

<?php
$koneksi->close();
include("inc_footer.php");
?>
