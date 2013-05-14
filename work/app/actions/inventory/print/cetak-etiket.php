<?php
require_once 'app/config/db.php';
include_once "app/lib/common/master-data.php";
require_once 'app/lib/common/master-inventory.php';
require_once 'app/lib/common/functions.php';
$no_r=$_GET['no_r'];
//$row = cetak_etiket_muat_data($_GET['code']);
$resep=nota_penjualan_muat_data($_GET['code'], $_GET['kelas'],$_GET['no_r']);
//$resep=cetak_salin_resep_muat_data($_GET['code'], $_GET['kelas'],null);

$head = head_laporan_muat_data();
?>
<html>
    <head>
        <title>Salin Resep</title>
        <script language='JavaScript'>
            function cetak() {
                SCETAK.innerHTML = '';
                window.print();
                if (confirm('Apakah menu print ini akan ditutup?')) {
                    window.close();
                }
                SCETAK.innerHTML = '<br /><input onClick=\'cetak()\' type=\'submit\' name=\'Submit\' value=\'Cetak\' class=\'tombol\'>';
            }
		</script>
		<style type="text/css">
		.wrapper {width: 230px;  font: 13px consolas,tahoma,arial !important}
		h1 {font: 15px arial,tahoma !important; font-weight: bold !important}
		td {font-size: 13px}
		</style>
    </head>
    <body>
	
	<div class="wrapper">
	<center><h1><?php echo $head['nama']?></h1><br>

	 -- CETAK ETIKET --</center><br><br>

<table>
    <tr>
        <td width=80>No. Resep</td>
        <td>: <?= $resep['list'][0]['id']?></td>
    </tr>
    <tr>
        <td>Tanggal</td>
        <td>: <?= datefmysql($resep['list'][0]['waktu'])?></td>
    </tr>
    <tr>
        <td>Pasien</td>
        <td>: <?= $resep['list'][0]['nama_pembeli']?></td>
    </tr>
    
</table>
    <br><br>
    <table width=100%>
	<?php
    if ($resep['list'][0]['jenis_r'] == 'Tunggal') {
	$total = 0;
	foreach($resep['list'] as $rows): 
            if($rows['no_r']==$no_r){
            ?>
                <tr valign="top">
                    <td><?= $rows['no_r'] ?></td>
                    <td><?= $rows['nama_obat']." @".$rows['nilai_konversi']." ".$rows['satuan_terkecil'] ?></td>
                    <td><?//= $rows['jumlah_r_tebus'] ?></td>
                    <td><?//= $rows['satuan'] ?></td>
                    <td></td>
		</tr>
                <tr valign="top">
                    <td></td><td colspan="3">                        
                     <?= "".$rows['aturan_pakai']."" ?> (Sebelum/Sesudah Makan)
                    </td>
                </tr>
	<?php
            
            }
            endforeach;
        } else { ?>
                <tr valign="top">
                    <td><?= $resep['list'][0]['no_r'] ?></td>
                    <td><?= $resep['list'][0]['nama_obat']." @".$resep['list'][0]['nilai_konversi']." ".$resep['list'][0]['satuan_terkecil'] ?></td>
                    <td><?//= $resep['list'][0]['jumlah_r_tebus'] ?></td>
                    <td><?//= $resep['list'][0]['satuan_terkecil'] ?></td>
                    <td></td>
		</tr>
                <tr valign="top">
                    <td></td><td colspan="3">                        
                     <?= "".$resep['list'][0]['aturan_pakai']."" ?> (Sebelum/Sesudah Makan)
                    </td>
                </tr>
        <?php }
        ?>
	</table>
    <br/>
    <table>
    <tr>
        <td colspan="2" style="font: 14px arial,tahoma">NB : .........................................</td>
    </tr>
    <tr>
        <td colspan="2"></td>
    </tr>
</table>
<center> 
	Terima Kasih<br>
</center>
</div>
      

        
<span id="SCETAK"><br><br><br><input type="button" class="tombol" value="Cetak" onClick="cetak()"/></span>        
</body>
</html>
<?php
exit();
?>