<?php
    include "config/koneksidb.php";
    include "config/fn_umur.php";
    
    //ambil nomor spaj terhakir
    $ambil_spaj_terahkir = mysql_query("SELECT MAX(no_spaj) AS max_spaj FROM spaj");
    $spaj_lama           = mysql_fetch_array($ambil_spaj_terahkir);
    $max_spaj            = $spaj_lama['max_spaj'];
    $pisah               = explode("-", $max_spaj); 
    @$max_number         = (int) $pisah[1];
    $new_number          = $max_number+1;
    
    //membentuk spaj terbaru, dengan 5 digit anggka dibelakan FM-, contoh : (FM-00005)
    $spaj_terbaru = "FM-".sprintf("%05s",$new_number);
    
    //ambil data nasabah
    $ambil_nasabah = mysql_query("SELECT n.no_spaj AS no_spaj,
                                 n.nama AS nama_lengkap, 
                                 n.alamat AS alamat,
                                 n.telepon AS telepon,
                                 n.tgl_lahir AS tgl_lahir,
                                 s.jup AS jup,
                                 s.cara_bayar AS cara_bayar 
                                 FROM spaj n, nasabah s
                                 WHERE s.status_deal=0
                                 AND n.no_spaj = s.no_spaj
                                 ") or die(mysql_error());

?>
<html>
    <head>
        <title>SPAJ</title>
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
            <a href="#" id="daftar_nasabah">Pendaftaran Calon Nasabah</a>     
               <form method="POST" id="fm_nasabah" class="fm_input" action="proses_spaj.php">
               <table>
                   <tr>
                       <td>No. SPAJ</td>
                       <td>:</td>
                       <td>
                           <input type="text" name="otomatis" id="otomatis" value="<?php echo $spaj_terbaru; ?>" disabled />
                           <input type="hidden" name="no_spaj" id="no_spaj" value="<?php echo $spaj_terbaru; ?>" />
                       </td>
                   </tr>
                   <tr>
                       <td>Jenis Kartu Identitas</td>
                       <td>:</td>
                       <td>
                           <select name="jki">
                               <option value="">-- silahkah pilih --</option>
                               <option value="ktp">KTP</option>
                               <option value="sim">SIM</option>
                               <option value="pasport">PASPORT</option>
                           </select>
                       </td>
                   </tr>
                   <tr>
                       <td>Nomor</td>
                       <td>:</td>
                       <td><input type="text" name="nmr" /></td>
                   </tr>
                   <tr>
                       <td>Nama Lengkap</td>
                       <td>:</td>
                       <td><input type="text" name="nm_lkp" /></td>
                   </tr>
                   <tr>
                       <td>Nama Kecil</td>
                       <td>:</td>
                       <td><input type="text" name="nm_kcl" /></td>
                   </tr>
                   <tr>
                       <td>Tempat / Tanggal Lahir </td>
                       <td>:</td>
                       <td>
                            <input type="text" name="tmpt" /> /
                            <input type="text" name="tgl_lhr" class="tgl" />
                        </td>
                   </tr>
                   <tr>
                       <td>Jenis Kelamin</td>
                       <td>:</td>
                       <td>
                           <input type="text" name="jns_kel" />
                       </td>
                   </tr>
                   <tr>
                       <td>Status Perkawinan</td>
                       <td>:</td>
                       <td><input type="text" name="sts_kwn" /></td>
                   </tr>
                   <tr>
                       <td>Agama</td>
                       <td>:</td>
                       <td><input type="text" name="agm" /></td>
                   </tr>
                   <tr>
                       <td>Nama Asli Ibu Kandung</td>
                       <td>:</td>
                       <td><input type="text" name="asli_ibu" /></td>
                   </tr>
                   <tr>
                       <td>Alamat</td>
                       <td>:</td>
                       <td>
                        <textarea name="almt">

                        </textarea>
                        </td>
                   </tr>
                   <tr>
                       <td>Kota</td>
                       <td>:</td>
                       <td><input type="text" name="kota" /></td>
                   </tr>
                   <tr>
                       <td>Provinsi</td>
                       <td>:</td>
                       <td><input type="text" name="provinsi" /></td>
                   </tr>
                   <tr>
                       <td>No. Telp</td>
                       <td>:</td>
                       <td><input type="text" name="telp" /></td>
                   </tr>
                   <tr>
                       <td>Kode Pos</td>
                       <td>:</td>
                       <td><input type="text" name="kd_pos" /></td>
                   </tr>
                   <tr>
                       <td>Kewarganegaraan</td>
                       <td>:</td>
                       <td>
                        <select name="kwn">
                                <option value="">-- silahkan pilih --</option>
                                <option value="WNI">WNI</option>
                                <option value="WNA">WNA</option>
                        </select>
                    </td>
                   </tr>
                   <tr>
                       <td>Asal Negara</td>
                       <td>:</td>
                       <td><input type="text" name="asl_neg" /></td>
                   </tr>
                   <tr>
                       <td>Pekerjaan</td>
                       <td>:</td>
                       <td>
                        <select name="pkrjaan">
                                <option value="">-- silahkan pilih --</option>
                                <option value="pns">PNS</option>
                                <option value="tni_polri">TNI/POLRI</option>
                                <option value="peg_swasta">Pegawai Swasta</option>
                                <option value="wiraswasta">Wiraswasta</option>
                                <option value="pro">Propesional</option>
                                <option value="lainnya">lainnya</option>
                        </select>
                    </td>
                   </tr>
                        <tr>
                            <td>Sebutkan pekerjaan</td>
                            <td>:</td>
                            <td><input type="text" name="kerja_lain" /></td>
                        </tr>
                   <tr>
                       <td>Cara Bayar</td>
                       <td>:</td>
                       <td>
                        <select name="cr_byr">
                            <option value="">-- silahkan pilih --</option>
                            <option value="1">Bulanan</option>
                            <option value="3">3 Bulanan</option>
                            <option value="6">6 Bulanan</option>
                            <option value="12">Tahunan</option>
                        </select>
                    </td>
                   </tr>
                   <tr>
                       <td>Jumlah Uang Pertanggungan</td>
                       <td>:</td>
                       <td><input type="text" name="jml_tanggung" /></td>
                   </tr>
                    <tr>
                        <td align="right" colspan="3">
                           <input type="submit" value="simpan" />
                        </td>
                    </tr>
                </table>
            </form>
            </div>
            <div id="content">
              <div id="tabel_nasabah">
                 <table class="auto_tabel_5page">
                    <thead>
                    <tr>
                        <th>NO. SPAJ</th>
                        <th>NAMA NASABAH</th>
                        <th>UMUR</th>
                        <th>ALAMAT</th>
                        <th>TELEPON</th>
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
                        <td><?php echo $data['alamat']; ?></td>
                        <td><?php echo $data['telepon']; ?></td>
                        <td><?php echo $data['jup']; ?></td>
                        <td>
                            <a href="hitung_premi.php?nomor_spaj=<?php echo $data['no_spaj']; ?>
                                     &nama=<?php echo $data['nama_lengkap']; ?>
                                     &usia=<?php echo $umur; ?>
                                     &jup=<?php  echo $data['jup']; ?>
                                     &cr_byr=<?php  echo $data['cara_bayar']; ?>
                                     &tgllahir=<?php echo $data['tgl_lahir']; ?>
                            ">    
                            Edit | Delete
                            </a>
                            | 
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