<?php
    include "config/koneksidb.php";
    
    //ngambil data dari form
    $no_spaj   = $_POST['spaj'];
    $tgl_byr   = $_POST['tgl_byr'];
    $nominal   = $_POST['nominal'];
    $cabang    = $_POST['cbg'];
    
    
    //ambil data nasabah
    $ambil_nasabah = mysql_query("SELECT MAX(no_polis) AS max_polis FROM nasabah") or die(mysql_error());
    $data_nasabah  = mysql_fetch_array($ambil_nasabah);
    
    $max_polis = (int) $data_nasabah['max_polis'];
    
    //kalau misal maximum no polis belum ada maka isi nomor polis awal-berarti masih nol
    //kalau misal maximum no poluis sudah ada, maka tambah nomor polis +1 (0002+1) = 0003
    if($max_polis==0){
        if($cabang=="cb1"){
            $nomor_polis_new =  22010001;
        }else{
            $nomor_polis_new =  22020002;
        }
    }else{
          $nomor_polis_new = $max_polis+1;
    }
    
    
    //masukan ke deal2 dulu - tabel nasabah
    $update_nasabah = mysql_query("UPDATE nasabah SET no_polis=$nomor_polis_new, 
                                                      tgl_deal='$tgl_byr',
                                                      status_deal=1
                                   WHERE no_spaj='$no_spaj'") or die(mysql_error());
    
    
    if($update_nasabah){
        //ambil data nasabah yang sebelumnya di input 
        $ambil_nasabah_sebelumnya = mysql_query("SELECT*FROM nasabah WHERE no_polis=$nomor_polis_new");
        $dt_nasabah         = mysql_fetch_array($ambil_nasabah_sebelumnya);
        
        $cara_bayar_nasabah = (int) $dt_nasabah['cara_bayar'];   
        
        //cari pembayaran bulan terbaru
        
        
        
        
        
        
        
        $total_premi        = $dt_nasabah['total_premi'];
        $LK                 = $nominal-$total_premi;
        $sisa               = abs($LK); 
        
        $tgl_tempo=date('Y-m-d',strtotime($tgl_byr."+".$cara_bayar_nasabah." month")); 
        
        //$tgl_tempo          = date('Y-m-d', strtotime('+'.$cara_bayar_nasabah.'month', $tgl_byr)); 
        
        //kalau kurang, status LK = kurang
/*
        echo $total_premi."<br>";
        echo $LK."<br>";
        echo $sisa."<br>";
        echo $nominal."<br>";
  
 * 
 */    
        
        
        
        if($LK<0){
            $statusLK = "kurang";
        }elseif($LK>0){
            $statusLK = "lebih";
        }else{
            $statusLK = "pass"; 
        }
        
        
        
        $pilih_nasabah      = mysql_query("SELECT*from nasabah WHERE no_spaj = '$no_spaj'") or die(mysql_error());
        $dt_nasabah_pilihan = mysql_fetch_array($pilih_nasabah);
        
        $id_nasabah = $dt_nasabah_pilihan['id_nasabah'];
        //echo $id_nasabah;
        
        $update_nasabah = mysql_query("UPDATE nasabah SET cabang='$cabang', no_polis = $nomor_polis_new 
                                       WHERE id_nasabah='$id_nasabah'
                                     ");
        
        //berarti sudah deal nasabah
        if($update_nasabah){
            //id nasabah yang ssudah di input dan no polis
            
            //pilih no polis yang sudah diinputkan,
            //sudah bisa dilaporkan ke Dsp sesuai no polis dan cabang
            $masukan_dsp = mysql_query("INSERT into dsp(id_nasabah,tgl_tempo,tgl_bayar,bulan,jumlah_bayar,sisa,lk)
                                    VALUES($id_nasabah,'$tgl_tempo','$tgl_byr',$cara_bayar_nasabah,$nominal,$LK,'$statusLK')
                                   ")or die(mysql_error()); 
        
         
           if($masukan_dsp){
             header("location:dsp.php");
           }
        }
     
    }
    

?>
