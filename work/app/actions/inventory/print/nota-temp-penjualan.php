<?php
    require_once 'app/config/db.php';
    require_once 'app/lib/common/master-inventory.php';
    require_once 'app/lib/common/functions.php';
    require_once 'app/lib/common/master-data.php';
    $nota_penjualan =nota_temp_penjualan_muat_data($_GET['code'],$_GET['kelas']);  
?>
<style>
    * { font-size: 12px; font-family: Arial;  }
</style>
	<? require_once 'app/actions/admisi/lembar-header.php'; ?>
        <center><span style='width:100%;font-size:11px; font-family:Courier New;'>Kitir</span></center>
<div class="body-nota">
	<table width=100%>
                <tr><td width="26%">No. Penjualan Temp</td><td>:</td><td><?= $nota_penjualan[0]['id'] ?></td></tr>
		<tr><td width="26%">Pembeli</td><td>:</td><td><?= $nota_penjualan[0]['nama_pembeli'] ?></td></tr>
                <tr><td width="26%">Tanggal</td><td>:</td><td><?= datefmysql($nota_penjualan[0]['waktu']) ?></td></tr>
	</table>
</div>
<div class="body-nota">
	
	<table width=100%>
	<?php 
	$total = 0;
	foreach($nota_penjualan as $row): 
            //$subtotal=$row['jenis']=='Bebas'?$row['hna']*$row['jumlah_penjualan']:$row['hna']*$row['jumlah_pakai'];    
            $subtotal=$row['hna']*$row['jumlah_penjualan'];    
        ?>
            <tr valign="top">
                        <td><?= isset($row['no_r'])?$row['no_r']:'-' ?></td>
			<td><?= nama_packing_barang(array($row['generik'],$row['nama_obat'],$row['kekuatan'],$row['sediaan'],$row['nilai_konversi'],$row['satuan_terkecil'],'')); ?></td>
                        <td><?= $row['jumlah_penjualan'] ?></td>
			<td><?= $row['satuan_terkecil'] ?></td>
                        <td style="white-space: nowrap;"><?= int_to_money($row['harga']) ?></td>
			<td style="white-space: nowrap;" align="right"><?= int_to_money($subtotal) ?></td>
		</tr>
	
	<?php
	$total = $total + $subtotal;
        $biaya_apt=$row['biaya_apoteker'];
        $diskon=$row['diskon'];
        $total_tagihan=$row['total_tagihan'];
	endforeach; 
        $jml_r=$_GET['kelas'] != null?$row['no_r']:0;
        ?>
		
	</table>
</div>
<div class="body-nota">
	<table width=100%>
		<tr><td style="width:60%;text-align: right">TOTAL</td><td></td><td align="right"><?= int_to_money($total) ?></td></tr>
                <tr><td style="width:60%;text-align: right">JASA PELAYANAN</td><td></td><td align="right"><?= int_to_money($biaya_apt) ?></td></tr>
                <tr><td style="width:60%;text-align: right">DISKON</td><td></td><td align="right"><?= int_to_money($diskon) ?></td></tr>
                <tr><td style="width:60%;text-align: right">TOTAL TAGIHAN</td><td></td><td align="right"><?= int_to_money($total_tagihan) ?></td></tr>
		<tr><td></td><td></td><td align="right">&nbsp;</td></tr>
		<tr><td></td><td></td><td align="right"><?= $_SESSION['nama'] ?><br/>PETUGAS</td></tr>
	</table>
</div>
<div class="head-nota">
	Terima Kasih, silahkan melakukan pembayaran di kasir
</div>

<span id="SCETAK"><input type="button" class="tombol" value="Cetak" onClick="cetak()"/></span>
<script type="text/javascript">
	function cetak() {
		SCETAK.innerHTML = '';
		window.print();
		if (confirm('Apakah menu print ini akan ditutup?')) {
			window.close();
		}
		SCETAK.innerHTML = '<br /><input onClick=\'cetak()\' type=\'submit\' name=\'Submit\' value=\'Cetak\' class=\'tombol\'>';
	}
</script>
<?php
die;
?>