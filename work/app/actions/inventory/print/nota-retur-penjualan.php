<style type="text/css">
    *{
        font-size:12px;
    }
    div{
        font-family: arial;
        
    }
    table.bordertabel{
        margin-top: 10px;
        border-top: 1px solid #000000;
        border-left: 1px solid #000000;
    }
    
   
    
    .bordertabel td{
        padding: 2px;       
        border-bottom: 1px solid #000000;
        border-right: 1px solid #000000;
    }
    
     .bordertabel td.noborder{
        border-right: 0;
    }
</style>
<?php
    require_once 'app/config/db.php';
    require_once 'app/lib/common/master-inventory.php';
    require_once 'app/lib/common/functions.php';
    require_once 'app/lib/common/master-data.php';
    $nota_penjualan = nota_penjualan_muat_data($_GET['code'],$_GET['kelas']);
    //show_array($nota_penjualan1);
    
    //$nota_penjualan2 = cetak_salin_resep_muat_data($_GET['code'],$_GET['kelas'],null);
    //show_array($nota_penjualan2);
    $biaya_apt = administrasi_apoteker_muat_data();
?>

	<? require_once 'app/actions/admisi/lembar-header.php'; ?>
        <center><span style='width:100%;'>Kitir</span></center>
<div class="body-nota">
	<table width=100% ">
                <tr><td width="26%">No. Penjualan</td><td>:</td><td><?= $nota_penjualan[0]['id'] ?></td></tr>
		<tr><td width="26%">Pembeli</td><td>:</td><td><?= $nota_penjualan[0]['nama_pembeli'] ?></td></tr>
                <tr><td width="26%">Tanggal</td><td>:</td><td><?= datefmysql($nota_penjualan[0]['waktu']) ?></td></tr>
	</table>
</div>
<div class="body-nota">
	
	<table class='bordertabel' width='100%' cellpadding="0" cellspacing="0>
	<?php 
	$total = 0;
        $total_embalase=0;
	foreach($nota_penjualan as $row):
        if($row['sub_kategori_barang']!='Embalase'){
        ?>
            <tr valign="top">
                <td><?= isset($row['no_r'])?$row['no_r']:'-' ?></td>
                <td><?= $row['nama_obat']." ".$row['pabrik']." @".$row['nilai_konversi']." ".$row['satuan_terkecil'] ?></td>
                <td class="noborder"><?= $row['jumlah_penjualan'] ?></td>
                <td ><?= $row['satuan_terkecil'] ?></td>
                <td style="white-space: nowrap;"><?= int_to_money($row['harga']) ?></td>
                <td style="white-space: nowrap;" align="right"><?= int_to_money($row['hna']*$row['jumlah_penjualan']) ?></td>
            </tr>	
	<?php
            $total = $total + ($row['hna']*$row['jumlah_penjualan']);
        }else{
            $total_embalase=$total_embalase+($row['hna']*$row['jumlah_penjualan']);
        }
	
	endforeach; 
        $jml_r=$_GET['kelas'] != null?$row['no_r']:0;
        ?>
		
	</table>
</div>
<div class="body-nota">
	<table width=100%>
		<tr><td style="width:60%;text-align: right">TOTAL HARGA</td><td></td><td align="right"><?= int_to_money($total) ?></td></tr>
                <tr><td style="width:60%;text-align: right">BIAYA APOTEKER</td><td></td><td align="right"><?= int_to_money($biaya_apt[0]['nilai']*$jml_r) ?></td></tr>
                <tr><td style="width:60%;text-align: right">TOTAL_EMBALAGE</td><td></td><td align="right"><?= int_to_money($total_embalase) ?></td></tr>
                <tr><td style="width:60%;text-align: right">TOTAL TAGIHAN</td><td></td><td align="right"><?= int_to_money($total_embalase+$total+($biaya_apt[0]['nilai']*$jml_r)) ?></td></tr>
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