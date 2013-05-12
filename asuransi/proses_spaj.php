<?php

    include "config/koneksidb.php";
    
    //menerima data dari form SPAJ / inisialisasi
    //masuk ke tabel nasabah 
    $no_spaj       = $_POST['no_spaj']; //nasabah dan spaj sebagai primary key & foreign key
    
    $jki           = $_POST['jki'];
    $nmr           = $_POST['nmr'];
    $nm_lkp        = $_POST['nm_lkp'];
    $nm_kcl        = $_POST['nm_kcl'];
    $tmpt          = $_POST['tmpt'];
    $tgl_lhr       = $_POST['tgl_lhr'];
    $jns_kel       = $_POST['jns_kel'];
    $sts_kwn       = $_POST['sts_kwn'];
    $agm           = $_POST['agm'];
    $asli_ibu      = $_POST['asli_ibu'];
    $almt          = $_POST['almt'];
    $kota          = $_POST['kota'];
    $provinsi      = $_POST['provinsi'];
    $telp          = $_POST['telp'];
    $kd_pos        = $_POST['kd_pos'];
    $kwn           = $_POST['kwn'];
    $asl_neg       = $_POST['asl_neg'];
    $pkrjaan       = $_POST['pkrjaan'];
    $kerja_lain    = $_POST['kerja_lain'];
    
    
    //masuk ke tabel spaj
    $cr_byr        = $_POST['cr_byr'];
    $jml_tanggung  = $_POST['jml_tanggung'];
     

    
    //proses memasukan ke tabel spaj
    $masuk_nasabah = mysql_query("INSERT into spaj(no_spaj,
                                                      jenis_kartu,
                                                      nomor,
                                                      nama,
                                                      nama_kecil,
                                                      tempat_lahir,
                                                      tgl_lahir,
                                                      kelamin,
                                                      status,
                                                      agama,
                                                      nama_ibu,
                                                      alamat,
                                                      kota,
                                                      provinsi,
                                                      telepon,
                                                      kode_pos,
                                                      warga,
                                                      asal,
                                                      pekerjaan,
                                                      tgl_catat
                                                      ) VALUES(
                                                      '$no_spaj',
                                                      '$jki',
                                                      $nmr,
                                                      '$nm_lkp',
                                                      '$nm_kcl',
                                                      '$tmpt',
                                                      '$tgl_lhr',
                                                      '$jns_kel',
                                                      '$sts_kwn',
                                                      '$agm',
                                                      '$asli_ibu',
                                                      '$almt',
                                                      '$kota',
                                                      '$provinsi',
                                                      '$telp',
                                                      $kd_pos,
                                                      '$kwn',
                                                      '$asl_neg',
                                                      '$pkrjaan',
                                                      NOW()
                                                      )") or die(mysql_error());
    
     
    
    //jika nasabah masuk, maka masuk juga ke nasabah
    if($masuk_nasabah){
       $masuk_spaj = mysql_query("INSERT into nasabah(no_spaj,
                                                    cara_bayar,
                                                    jup
                                                    ) VALUES(
                                                    '$no_spaj',
                                                     $cr_byr,
                                                     $jml_tanggung
                                                    )") or die(mysql_error());
        
        header("location:spaj.php");
        

    }
    
?>