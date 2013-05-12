<?php
    include "config/koneksidb.php";
    include "config/fn_umur.php";

    /*
    //ambil nomor spaj terhakir
    $ambil_spaj_terahkir = mysql_query("SELECT MAX(no_spaj) AS max_spaj FROM spaj");
    $spaj_lama  = mysql_fetch_array($ambil_spaj_terahkir);
    $max_spaj   = $spaj_lama['max_spaj'];
    $pisah      = explode("-", $max_spaj); 
    @$max_number = (int) $pisah[1];
    $new_number = $max_number+1;
    //membentuk spaj terbaru, dengan 5 digit anggka dibelakan FM-, contoh : (FM-00005)
    $spaj_terbaru = "FM-".sprintf("%05s",$new_number);
*/

    //ambil data nasabah
    $ambil_nasabah = mysql_query("SELECT n.no_spaj AS no_spaj,
                                 n.nama AS nama_lengkap, 
                                 n.alamat AS alamat,
                                 n.telepon AS telepon,
                                 n.tgl_lahir AS tgl_lahir,
                                 s.jup AS jup,
                                 s.cara_bayar AS cara_bayar 
                                 FROM spaj n, nasabah s
                                 WHERE status_deal=1
                                 AND n.no_spaj = s.no_spaj
                                 ") or die(mysql_error());

?>

<html>
    <head>
        <title>NASABAH</title>
        <?php include "config/head_file.php"; ?>
        <script type="text/javascript" src="js/js_nasabah.js"></script>
    </head>
    <body>
        <div id="keterangan">
           berisi logut, hak akses , anda berada di menu apa
        </div>
        <?php include "config/linkpage.php"; ?>
        <div id="outer">
            <div id="header">
                
            </div>
            <div id="content">
              <div id="tabel_nasabah">
                 <table class="auto_tabel_5page">
                    <thead>
                    <tr>
                        <th>NO. POLIS</th>
                        <th>NAMA NASABAH</th>
                        <th>UMUR</th>
                        <th>JUP</th>
                        <th>AKSI</th>
                    </tr>
                    </thead>
                    <tbody>
            <?php while($data = mysql_fetch_array($ambil_nasabah)){
                //tgl lahir dari database
                $tgllhr = $data['tgl_lahir'];
                //tgl lahir dimasukan ke umur
                $umur = HitungUmur($tgllhr);
            ?>        
                    <tr>
                        <td><a href="#"><?php echo $data['no_spaj']; ?></a></td>
                        <td><?php echo $data['nama_lengkap']; ?></td>
                        <td><?php echo $umur; ?></td>
                        <td><?php echo $data['jup']; ?></td>
                        <td>
                            <a href="hitung_premi.php?nomor_spaj=<?php echo $data['no_spaj']; ?>
                                     &nama=<?php echo $data['nama_lengkap']; ?>
                                     &usia=<?php echo $umur; ?>
                                     &jup=<?php  echo $data['jup']; ?>
                                     &cr_byr=<?php  echo $data['cara_bayar']; ?>
                                     &tgllahir=<?php echo $data['tgl_lahir']; ?>
                            ">    
                            ilustrasi premi
                            </a>
                        </td>
                    </tr>
            <?php } ?> 
                    </tbody>
                </table>
               </div>
            </div>
            <div class="clear"></div>
        </div>
    </body>
</html>    