<?php
    session_start();
    include "config/koneksidb.php";
    //mengambil data dari form kartu premi
    if(isset($_POST['awal']) && isset($_POST['ahkir'])){
        //tanggal awal-ahkir
        $polis = $_POST['polis'];
        $awal  = $_POST['awal'];
        $ahkir = $_POST['ahkir'];
        
        //mencari Profil dari nasabah
        $mencari_profil_by_polis = mysql_query("SELECT n.no_polis AS no_polis, n.no_spaj AS no_spaj, n.cabang AS cabang,
                                                s.nama AS nama_lengkap, s.alamat AS alamat_nasabah, n.jup AS jup, n.cara_bayar
                                                FROM nasabah n, spaj s
                                                WHERE n.no_polis = $polis
                                                AND s.no_spaj = n.no_spaj
                                               ") or die(mysql_error());
        
        $data_nasabah = mysql_fetch_array($mencari_profil_by_polis);
        
        //mencari daftar kartu premi
        
        $mencari_daftar_premi  = mysql_query("SELECT n.no_polis AS no_polis, n.no_spaj AS no_spaj, n.jup AS jup, n.total_premi AS total_premi, 
                                            d.tgl_tempo AS tgl_tempo, d.tgl_bayar AS tgl_bayar, d.bulan AS bulan_ke, d.jumlah_bayar AS jumlah_bayar   
                                            FROM nasabah n, dsp d
                                            WHERE n.no_polis = $polis  
                                            AND d.tgl_bayar >= '$awal' 
                                            AND d.tgl_bayar <= '$ahkir'
                                            AND n.id_nasabah = d.id_nasabah
                                            ") or die(mysql_error());
        
         
        
    }
    
    
?>
<html>
    <head>
        <title>Kartu Premi</title>
        <?php include "config/head_file.php"; ?>
    </head>
    <body>
        <?php include "config/keterangan.php"; ?>
        <?php include "config/linkpage.php"; ?>
<div id="outer">        
    <div id="header">
        <h1>FORM PREMI</h1>
        <form class="fm_input" action="" method="POST" style="width:400px;">
            <table cellpadding="10">
                <tr>
                    <td>No Polis</td>
                    <td>:</td>
                    <td>
                        <input type="text" name="polis" id="polis" size="10" />
                    </td>
                </tr>
                <tr>
                    <td>Tgl. Awal</td>
                    <td>:</td>
                    <td>
                        <input type="text" name="awal" id="awal" class="tgl" />
                    </td>
                </tr>
                <tr>
                    <td>Tgl Ahkir</td>
                    <td>:</td>
                    <td><input type="text" name="ahkir" id="ahkir" class="tgl" /></td>
                </tr>
                <tr>
                    <td colspan="3" align="right">
                        <input type="submit" value="Cari" />
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div id="isi">
    <h1>Kartu Premi</h1>
        <table cellpadding="10">
            <tr>
                <td>Cabang</td>
                <td>:</td>
                <td>
                    <?php  
                        if($data_nasabah['cabang']=="cb1"){
                            echo "BANDUNG-01";
                        }else{
                            echo "BANDUNG-02";
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td>No. Spaj / Polis</td>
                <td>:</td>
                <td>
                    <?php
                        echo $data_nasabah['no_spaj']." / ".$data_nasabah['no_polis'];
                    
                    ?>
                    
                </td>
            </tr>
            <tr>
                <td>Pemegang</td>
                <td>:</td>
                <td><?php echo $data_nasabah['nama_lengkap']; ?></td>
            </tr>
            <tr>
                <td>Alamat rumah</td>
                <td>:</td>
                <td><?php echo $data_nasabah['alamat_nasabah']; ?></td>
            </tr>
            <tr>
                <td>Uang Pertanggung</td>
                <td>:</td>
                <td><?php echo $data_nasabah['jup']; ?></td>
            </tr>
            <tr>
                <td>Cara Bayar</td>
                <td>:</td>
                <td><?php echo $data_nasabah['cara_bayar']; ?></td>
            </tr>
            <tr>
                <td>Tgl Cetak</td>
                <td>:</td>
                <td>
                    <?php echo date("Y-m-d"); ?>
                </td>
            </tr>
        </table>
        <table border="1">
            <tr>
                <th>No. </th>
                <th>Jatuh Tempo</th>
                <th>Bulan ke</th>
                <th>Jenis</th>
                <th>Tagihan</th>
                <th>Jumlah Bayar</th>
            </tr>  
  <?php 
  $no = 1;
  while($data_kartu_premi = mysql_fetch_array($mencari_daftar_premi)){ 
  
 ?>          
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $data_kartu_premi['tgl_bayar']; ?></td>
                <td><?php echo $data_kartu_premi['bulan_ke']; ?></td>
                <td>
                    Premi<br>
                    Materai
                </td>
                <td>
                    <?php 
                        $total_byr = $data_kartu_premi['total_premi']-6000;
                        echo $total_byr."<br>";
                        echo "6000";
                    ?>
                </td>
                <td><?php echo $data_kartu_premi['jumlah_bayar']; ?></td>
            </tr>
  <?php } ?>          
        </table>
    </div>    
</div>
   <div class="clear"></div>
    </body>
</html>