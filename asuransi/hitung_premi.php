<?php
    include "config/koneksidb.php";
    //ambil data dari hitung link ilustransi
    $spaj     = $_GET['nomor_spaj'];
    $nama     = $_GET['nama'];
    $usia     = $_GET['usia'];
    $jup      = $_GET['jup'];
    $cr_byr   = $_GET['cr_byr'];
    $tgllahir = $_GET['tgllahir'];
    
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
            <div id="header">
                <p>
                Perhitungan Premi
                Jumlah Premi Yang Harus Di Bayarkan oleh nasabah
                </p>
            </div>
            <div id="content">
               <form method="POST" action="">
                <table>
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="otomatis" id="otomatis" value="<?php echo $nama; ?>" disabled />
                            <input type="hidden" name="nama_nasabah" id="nama_nasabah" value="<?php echo $nama; ?>" /> 
                            <input type="hidden" name="no_spaj" value="<?php echo $spaj; ?>" />
                            <input type="hidden" name="cara_bayar" value="<?php echo $cr_byr; ?>" />
                            
                        </td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="otomatis" id="otomatis" value="<?php echo $tgllahir; ?>" readonly />
                            <input type="hidden" name="tgl_lahir" id="tgl_lahir" value="<?php echo $tgllahir; ?>" />
                        </td>
                    </tr>
                    <tr>
                            <td>Usia</td>
                            <td>:</td>
                            <td>
                                <input type="text" name="otomatis" id="otomatis" value="<?php echo $usia; ?>" disabled />
                                <input type="hidden" name="usia" id="usia" value="<?php echo $usia; ?>" />
                            </td>
                    </tr>
                    <tr>
                        <td>Jumlah Uang Pertanggungan</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="otomatis" id="otomatis" value="<?php echo $jup; ?>" disabled />
                            <input type="hidden" name="jup" id="jup" value="<?php echo $jup; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>Masa Asuransi</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="masa" id="masa" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="right">
                            <input type="submit" value="hitung" name="hitung" />
                        </td>
                    </tr>
                </table>
            </form>
               <?php if(isset($_POST['hitung'])){ 
                   
                    //PERHITUNGAN TOTAL PREMI
                    
                   //komponen untuk perhitungan PREMI
                   $no_spaj      = $_POST['no_spaj'];
                   $nama_nasabah = $_POST['nama_nasabah'];
                   $cara_bayar   = $_POST['cara_bayar'];
                   $usia         = (int) $_POST['usia'];
                   $jup          = $_POST['jup'];
                   $masa         = $_POST['masa'];
                   $tgl_lahir    = $_POST['tgl_lahir'];
                   
                   //nilai cara bayar 
                   if($cara_bayar==1){
                       $cb = 0.132; 
                   }elseif($cara_bayar==3){
                       $cb = 0.265;
                   }elseif($cara_bayar==6){
                       $cb = 0.52;
                   }elseif($cara_bayar==12){
                       $cb = 1;
                   }
                   
                 //mengambil rate berdasarkan umur dari database  
                 $rate      = mysql_query("SELECT*FROM rate WHERE umur=$usia AND masa_asuransi=$masa") or die(mysql_error());
                 $data_rate = mysql_fetch_array($rate);
                
                 //rumus premi
                 $premi        = ($jup*$data_rate['rate']*$cb)/1000;
                 $materai      = 6000;
                 $jumlah_bayar = $premi+$materai;
                 
                
                ?> 
                <div id="hasil_perhitungan">
                    <h2>Data pertanggungan</h2>    
                    <table cellpadding="5">
                        <tr>
                            <td>Nama Tertanggungan</td>
                            <td>:</td>
                            <td><?php echo $nama_nasabah; ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Lahir</td>
                            <td>:</td>
                            <td><?php echo $tgl_lahir; ?></td>
                        </tr>
                        <tr>
                            <td>Usia Nasabah</td>
                            <td>:</td>
                            <td><?php echo $usia; ?></td>
                        </tr>
                        <tr>
                            <td>Masa asuransi</td>
                            <td>:</td>
                            <td><?php echo $masa; ?></td>
                        </tr>
                        <tr>
                            <td>JUP</td>
                            <td>:</td>
                            <td><?php echo $jup; ?></td>
                        </tr>
                        <tr>
                            <td>Premi</td>
                            <td>:</td>
                            <td><?php echo $premi; ?></td>
                        </tr>
                        <tr>
                            <td>Materai</td>
                            <td>:</td>
                            <td><?php echo $materai; ?></td>
                        </tr>
                        <tr>
                            <td>Total Bayar Premi</td>
                            <td>:</td>
                            <td><?php echo $jumlah_bayar; ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="right">
                                <a href="print_ilustrasi_premi.php?spaj=<?php echo $no_spaj; ?>
                                                   &nm=<?php echo $nama_nasabah; ?>
                                                   &tgl=<?php echo $tgl_lahir; ?>
                                                   &usia=<?php echo $usia; ?>
                                                   &ms=<?php echo $masa; ?>
                                                   &jup=<?php echo $jup; ?>
                                                   &premi=<?php echo $jumlah_bayar; ?>" class="linkvalue">
                                 Print
                                </a>
                                                   
                            </td>
                        </tr>
                    </table>
                </div>
            <?php } ?>    
            </div>
            <div class="clear"></div>
        </div>   
    </body>
</html>    
