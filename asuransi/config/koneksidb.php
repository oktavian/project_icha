<?php
    $hos = "localhost";
    $usr = "root";
    $pas = "";

    $koneksi = mysql_connect($hos,$usr,$pas);
    //if($koneksi){
      //  echo "oke";
    //}
    
    $koneksdb = mysql_select_db("bringinlifedb");
    
?>