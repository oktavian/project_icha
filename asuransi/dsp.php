<?php
    include "config/koneksidb.php";
    $kirim_perintah = mysql_query("SELECT d.no_polis AS no_polis ,
                                     s.nama AS nama_nasabah,
                                     d.tgl_tempo AS tgl_tempo, 
                                     d.tgl_bayar AS tgl_bayar, 
                                     n.cara_bayar AS cara_bayar,
                                     n.cabang AS cabang,
                                     n.total_premi AS premi_pertama, 
                                     d.jumlah_bayar AS jumlah_bayar,
                                     d.sisa AS sisa,
                                     d.lk AS lk
                               FROM spaj s, nasabah n, dsp d
                               WHERE s.no_spaj = n.no_spaj
                               AND n.no_polis = d.no_polis
                               ");
 

?>
<html>
    <head>
        <title>DSP</title>
        <?php include "config/head_file.php"; ?>
    </head>
    <body>
        <div id="keterangan">
           berisi logut, hak akses , anda berada di menu apa
        </div>
        <?php include "config/linkpage.php"; ?>
        <div id="outer">
            <div id="header">
                <h1>FORM DSP PERTAMA</h1>
                <form action="proses_dsp.php" class="fm_input" method="POST" style="width: 40%;">
                    <table cellpadding="10">
                        <tr>
                            <td>No Spaj</td>
                            <td>:</td>
                            <td><input type="text" name="spaj" id="spaj" /></td>
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
                        <tr>
                            <td colspan="3">
                                <input type="submit" value="deal" />
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
                        <td><?php echo $data_dsp['premi_pertama']; ?></td>
                        <td><?php echo $data_dsp['jumlah_bayar']; ?></td>
                        <td><?php echo $data_dsp['sisa']; ?></td>
                        <td><?php echo $data_dsp['lk']; ?></td>
                    </tr>
  <?php } ?>                  
                </table>
            </div>
        </div>
    </body>
</html>