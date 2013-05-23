<?php
     session_start();
    //inisialisasi
     include "config/koneksidb.php";
    
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $jbt  = $_POST['jbt'];

    //ambil data akun
    $ambil_data = mysql_query("SELECT*FROM user WHERE username='$user' AND password='$pass' AND jabatan='$jbt'");
    $jmldata    = mysql_num_rows($ambil_data);
    
    if($jmldata==1){
        $_SESSION["username"] = $user;
        $_SESSION["password"] = $pass;
        $_SESSION["jabatan"]  = $jbt;
        
        header("location:home.php");
    }else{
        header("location:index.php");
    }
    

?>
