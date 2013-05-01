<?php
   function HitungUmur($tgllhr)
    {
       
        list($thn,$bln,$tgl) = explode('-',$tgllhr);	
	$lahir = mktime(0, 0, 0, (int)$bln, (int)$tgl, $thn); //jam,menit,detik,bulan,tanggal,tahun
	$t = time();
	$umur = ($lahir < 0) ? ( $t + ($lahir * -1) ) : $t - $lahir;
	$tahun = 60 * 60 * 24 * 365;
	$tahunlahir = $umur / $tahun;
	$umursekarang=floor($tahunlahir) ;
	return $umursekarang;
      }
?>
