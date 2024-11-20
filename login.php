<?php
 session_start();
 if (isset($_SESSION['admin_username'])) {
    header("location:admin_depan.php");
 }
 include("inc_koneksi.php");
 $username = "";
 $password = "";
 $err = "";
 if (isset($_POST['login'])) {
     $username = $_POST['username'];
     $password = $_POST['password'];
     if ($username == '' or $password == ''){
        $err .= "<li>Silahkan Masukan Username dan Password</li>";
     }
     if(empty($err)){
        $sql1 = "select * from admin where username = '$username'";
        $q1 = mysqli_query($koneksi,$sql1);
        $r1 = mysqli_fetch_array($q1);
        if($r1['password'] != md5($password)){
            $err .= "<li>user atau password salah</li>";
        }
     }
     if (empty($err)){
        $login_id = $r1['login_id'];
        $ql1 = "select * from admin_akses where login_id = '$login_id'";
        $q1 = mysqli_query($koneksi,$ql1);
        while($r1 =mysqli_fetch_array($q1)){
            $akses[] =$r1['akses_id']; 
        }
        if (empty($akses)){
            $err .= "<li>Anda belum punya akses untuk aplikasi ini</li>";
        }
     }
     if(empty($err)){
        $_SESSION['admin_username'] = $username;
        $_SESSION['admin_akses'] = $akses;
        header("location:admin_depan.php");
        exit();
     }
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Courier+Prime:ital,wght@0,400;0,700;1,400;1,700&family=Jost:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href     ="style.css">
</head>

<body>
    <div id="app">
        <h1>Login Page  </h1>
        <?php
        if($err){
            echo "<ul>$err</ul>";
        }
        ?>
        <form action="" method="post">
            <input type="text" value="<?php echo $username; ?>"  name="username" class="input" placeholder="isi Username"/><br /><br />
            <input type="password" value="<?php echo $password; ?>" name="password" class="input" placeholder="isi Password"/><br /><br />
            <input type="submit" name="login" class="tombol"q value="Masuk Ke System"/>
        </form>
    </div>
</body>
</html>