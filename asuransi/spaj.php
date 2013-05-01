<?php
    include "config/koneksidb.php";
    include "config/fn_umur.php";
    //ambil data nasabah
    $ambil_nasabah = mysql_query("SELECT*from nasabah") or die(mysql_error());
?>
<html>
    <head>
        <title>SPAJ</title>
        <?php include "config/head_file.php"; ?>
    </head>
    <body>
        <div id="keterangan">
           berisi logut, hak akses , anda berada di menu apa
        </div>
        <?php include "config/linkpage.php"; ?>
        <div id="outer">
            <div id="header" class="fm_data">
               tes
            </div>
            <div id="content">
               
            </div>
        </div>
        <div class="clear"></div>
    </body>
</html>