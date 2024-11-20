<?php
session_start();
include("inc_koneksi.php");
if (!isset($_SESSION['admin_username'])) {
    header("location:login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Courier+Prime:ital,wght@0,400;0,700;1,400;1,700&family=Jost:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>GudangIT</title> 
</head>

<body>
    <div id="app">
        <nav>
            <ul>
                <br>
                <li><a href="admin_depan.php">Home</a></li>
                <?php if (in_array("user", $_SESSION['admin_akses'])){ ?>
                <li><a href="inventory_user.php">Inventory</a></li>
                <?php } ?>
                <?php if (in_array("admin", $_SESSION['admin_akses'])){ ?>
                <li><a href="inventory.php">admin inventory</a></li>
                <?php } ?>
                <?php if (in_array("user", $_SESSION['admin_akses'])){ ?>
                <li><a href="request.php">request barang</a></li>
                <?php } ?>
                <?php if (in_array("admin", $_SESSION['admin_akses'])){ ?>
                <li><a href="request_admin.php">request barang</a></li>
                <?php } ?>
                <li><a href="logout.php">LogOut</a></li>
            </ul>
        </nav>

        