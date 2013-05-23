<?php
    session_start();
    include "config/koneksidb.php";
    //ambil data DSP
    $kirim_perintah = mysql_query("SELECT n.no_polis AS no_polis ,
                                     s.nama AS nama_nasabah,
                                     d.tgl_tempo AS tgl_tempo, 
                                     d.tgl_bayar AS tgl_bayar, 
                                     n.cara_bayar AS cara_bayar,
                                     n.cabang AS cabang,
                                     n.total_premi AS premi_pertama,
                                     n.tgl_deal AS tgl_pertama_bayar,
                                     d.jumlah_bayar AS jumlah_bayar,
                                     d.sisa AS sisa,
                                     d.lk AS lk,
                                     d.bulan AS bulan_ke
                               FROM spaj s, nasabah n, dsp d
                               WHERE s.no_spaj = n.no_spaj
                               AND n.id_nasabah = d.id_nasabah
                               ");
    
    
    
    if($_SESSION["jabatan"]=="administrasi"){
        //inisialisasi/ mengambil apa yang dibutukan
        $judul_form   = "DSP TAHUN PERTAMA";
        $tujuanproses = "proses_dsp_thn_pertama.php"; 
        $identitas    = "No. Polis";
        $ididentitas  = "polis";
        $namasubmit   = "Masukan";
        
    }else{
        //inisialisasi/ mengambil apa yang dibutukan
        $judul_form   = "DSP PERTAMA";
        $tujuanproses = "proses_dsp.php";
        $identitas    = "No. Spaj";
        $ididentitas  = "spaj";
        $namasubmit   = "Deal";
    }
 

?>
<html>
    <head>
        <title>DSP</title>
        <?php include "config/head_file.php"; ?>
    </head>
    <body>
        <?php include "config/keterangan.php"; ?>
        <?php include "config/linkpage.php"; ?>
        <div id="outer">
            <div id="header">   
                <h1><?php echo $judul_form; ?></h1>
                <form action="<?php echo $tujuanproses; ?>" class="fm_input" method="POST" style="width: 40%;">
                    <table cellpadding="10">
                        <tr>
                            <td><?php echo $identitas; ?></td>
                            <td>:</td>
                            <td><input type="text" name="<?php echo $ididentitas; ?>" id="<?php echo $ididentitas; ?>" /></td>
                        </tr>
                        <tr>
                            <td>Tanggal Bayar</td>
                            <td>:</td>
                            <td><input type="text" name="tgl_byr" id="tgl_byr" size="10" class="tgl" /></td>
                        </tr>
                        <tr>
                            <td>Nominal</td>
                            <td>:</td>
                            <td><input type="text" name="nominal" id="nominal" /></td>
                        </tr>
                     <?php if($_SESSION['jabatan']!="administrasi"){?>   
                        <tr>
                            <td>Cabang</td>
                            <td>:</td>
                            <td>
                                <select name="cbg">
                                    <option value="cb1">Bandung 1</option>
                                    <option value="cb2">Bandung 2</option>
                                </select>
                            </td>
                        </tr>
                   <?php } ?>     
                        <tr>
                            <td colspan="3" align="right">
                                <input type="submit" value="<?php echo $namasubmit; ?>" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div id="content">
                <h1>DAFTAR SETORAN PREMI</h1>
                <table border>
                    <tr>
                        <th>No Polis</th>
                        <th>Nama Nasabah</th>
                        <th>Tanggal Jatuh Tempo</th>
                        <th>Tanggal Bayar</th>
                        <th>Cara Bayar</th>
                        <th>Premi Pertama</th>
                        <th>Premi Lanjutan Tahun Pertama</th>
                        <th>Premi Lanjutan</th>
                        <th>Jumlah Dibayar</th>
                        <th>Sisa</th>
                        <th>LK</th>
                    </tr>
  <?php while($data_dsp = mysql_fetch_array($kirim_perintah)){ ?>                  
                    <tr>
                        <td><?php echo $data_dsp['no_polis']; ?></td>
                        <td><?php echo $data_dsp['nama_nasabah']; ?></td>
                        <td><?php echo $data_dsp['tgl_tempo']; ?></td>
                        <td><?php echo $data_dsp['tgl_bayar']; ?></td>
                        <td><?php echo $data_dsp['cara_bayar']; ?></td>
                        <td>
                            
                            <?php
                                if($data_dsp['tgl_pertama_bayar'] == $data_dsp['tgl_bayar']){
                                    echo $data_dsp['premi_pertama'];
                                }else{
                                    echo "&nbsp;";
                                }
                            ?>
                            
                        </td>
                        <td>
                            <?php
                                if($data_dsp['tgl_bayar'] > $data_dsp['tgl_pertama_bayar'] && $data_dsp['bulan_ke']<=12){
                                    echo $data_dsp['premi_pertama'];
                                }else{
                                    echo "&nbsp;";
                                }
                            ?>
                        </td>
                        <td>
                            <?php 
                                if($data_dsp['bulan_ke']>=13){ 
                                    echo $data_dsp['premi_pertama'];    
                                }else{
                                    echo "&nbsp;";
                                }
                           ?>
                        </td>
                        <td>
                            <?php 
                                
                                echo $data_dsp['jumlah_bayar']; 
                             
                            ?>
                        </td>
                        <td><?php echo $data_dsp['sisa']; ?></td>
                        <td><?php echo $data_dsp['lk']; ?></td>
                    </tr>
  <?php } ?>                  
                </table>
            </div>
        </div>
    </body>
</html>