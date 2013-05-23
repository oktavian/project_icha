<?php
    include "config/koneksidb.php";
    
///////////////////////////////////////////////////////////////////////////////////    
    //ngambil data dari form administrasi, no polis sbg inputan
    $polis   = $_POST['polis'];
    $tgl_byr = $_POST['tgl_byr'];
    $nominal = $_POST['nominal'];
    
    
    //cari data-data nasabah yang diperlukan untuk pemrosesan sistem
    $mencari_nasabah    = mysql_query("SELECT*FROM nasabah WHERE no_polis=$polis");
    $ambil_data         = mysql_fetch_array($mencari_nasabah);
    
    //data data nasabah
    $id_nasabah         = $ambil_data["id_nasabah"]; 
    $cara_bayar         = (int)$ambil_data["cara_bayar"];
    $masa_asuransi      = $ambil_data["masa_asuransi"];
    $total_premi        = $ambil_data["total_premi"];
    
    //cari data-data dsp yang diperlukan untuk pemrosesan sistem
    $mencari_dsp        = mysql_query("SELECT MAX(tgl_tempo) AS tgl_tempo_max 
                                       FROM dsp WHERE id_nasabah=$id_nasabah");
    $ambil_data_dsp     = mysql_fetch_array($mencari_dsp);
    
    $cari_bulan_dsp     = mysql_query("SELECT MAX(bulan) AS bulan 
                                       FROM dsp WHERE id_nasabah=$id_nasabah");
    
    $data_bulan_dsp     = mysql_fetch_array($cari_bulan_dsp);
    
    //data data dsp
    $tgl_tempo_max  = $ambil_data_dsp["tgl_tempo_max"];
    
    $bulan_terahkir = (int)$data_bulan_dsp["bulan"];
   
    
    
///////////////////////////////////////////////////////////////////////////////////    
    
    
    
//////////////////////////////////////////////////////////////////////////////////////////    
    //hitung hitungan untuk Inputan 1. tanggal tempo, 2. bulan terbaru, 3. sisa, 4. lk
    //
    //1. tanggal tempo 
    $tgl_tempo      = date('Y-m-d',strtotime($tgl_byr."+".$cara_bayar." month")); 
    
    //2. bulan terbaru (bulan terahkir dikurangi cara bayar(1bulan/3bulan/6bulan))
    $bulan_terbaru = $bulan_terahkir+$cara_bayar;
    
    //3. sisa bayar (dijadikan absolute, gak ada minus)
    $sisa          = $nominal-$total_premi;
    $sisaabsolute  = abs($sisa);
    
    // 4. mencari status lebih/kurang(LK)
    if($sisa<0){
        $statusLK = "kurang";
    }elseif($sisa>0){
        $statusLK = "lebih";
    }else{
        $statusLK = "pass"; 
    }
 /////////////////////////////////////////////////////////////////////////////////////////   
    
    
    //2. mengelola pencocokan tanggal
    if($tgl_byr<=$tgl_tempo_max){
        
        //masukan ke dalam tabel dsp
        $masukan_ke_dsp = mysql_query("INSERT into dsp(id_nasabah,
                                                       tgl_tempo,
                                                       tgl_bayar,
                                                       bulan,
                                                       jumlah_bayar,
                                                       sisa,
                                                       lk)
                                       VALUES($id_nasabah,
                                              '$tgl_tempo',
                                              '$tgl_byr',
                                              $bulan_terbaru,
                                              $nominal,
                                              $sisaabsolute,
                                              '$statusLK')
                                    ") or die(mysql_error());
        
        if($masukan_ke_dsp){
            header("location:dsp.php");
        }
        
        
    }else{
        
            //JAGA JAGA DENDA ADA
        
            //input dsp 
           /*
            * untuk yang lanjutan dan tahunan
            * pilih history perbulan/perminggu/perhari
            * kartu premi = tiap nasabah itu bayar berapa saja.
            * 
            * 
            */ 
        
    }

?>
