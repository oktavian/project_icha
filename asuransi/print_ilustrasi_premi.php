<?php  
    
include "config/koneksidb.php";


//mengambil data dari print ilustrasi premi
$no_spaj       = $_GET['spaj'];
$nama_nasabah  = $_GET['nm'];
$tgl_lahir     = $_GET['tgl'];
$usia          = $_GET['usia'];
$masa          = $_GET['ms'];
$jup           = $_GET['jup'];
$jumlah_bayar  = $_GET['premi'];
$tgl           = date("Y-m-d");


//masukan ke 
$masukan_nasabah = mysql_query("UPDATE nasabah SET masa_asuransi=$masa, 
                                            total_premi=$jumlah_bayar,
                                            tgl_ilustrasi='$tgl'
                                WHERE no_spaj='$no_spaj'") or die(mysql_error());
if($masukan_nasabah){
    
    header("Cache-Control: no-cache, no-store, must-revalidate");  
    header("Content-Type: application/vnd.ms-excel");  
    header("Content-Disposition: attachment; filename=ilustrasi_premi.xls");  

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
            <td>Total Bayar Premi</td>
            <td>:</td>
            <td><?php echo $jumlah_bayar; ?></td>
        </tr>
    </table>
</div>
<?php 
}
?>  
