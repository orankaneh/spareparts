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
    
   
    
    .bordertabel td,.bordertabel th{
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
//show_array($nota_penjualan);
    
    //$nota_penjualan2 = cetak_salin_resep_muat_data($_GET['code'],$_GET['kelas'],null);
    //show_array($nota_penjualan2);
    //$biaya_apt = administrasi_apoteker_muat_data();
    $biaya_apt=0;
?>

	<? require_once 'app/actions/admisi/lembar-header.php'; ?>
        <center><span style='width:100%;'>Kitir</span></center>
<div class="body-nota">
	<table width=100% ">
                <tr><td width="26%">No. Penjualan</td><td>:</td><td><?= $nota_penjualan['list'][0]['id'] ?></td></tr>
		<tr><td width="26%">Pembeli</td><td>:</td><td><?= $nota_penjualan['list'][0]['nama_pembeli'] ?></td></tr>
                <tr><td width="26%">Tanggal</td><td>:</td><td><?= datefmysql($nota_penjualan['list'][0]['waktu']) ?></td></tr>
	</table>
</div>
<div class="body-nota">
	
	<table class='bordertabel' width='100%' cellpadding="0" cellspacing="0">
            <tr>
                <!--<th>R/</th>-->
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Harga</th>
                <th>Sub Total</th>
            </tr>
	<?php 
	$total = 0;
        $total_embalase=0;
	foreach($nota_penjualan['list'] as $row){
        if($row['sub_kategori_barang']!='Embalase'){
        ?>
            <tr valign="top">
                <!--<td><?//= isset($row['no_r'])?$row['no_r']:'-' ?></td>-->
                <td><?= nama_packing_barang(array($row['generik'],$row['nama_obat'],$row['kekuatan'],$row['sediaan'],$row['nilai_konversi'],$row['satuan_terkecil'],'')); ?></td>
                <td><?= $row['jumlah_penjualan'] ?></td>
                <td ><?= $row['satuan_terkecil'] ?></td>
                <td style="white-space: nowrap;"><?= rupiah($row['harga']) ?></td>
                <td style="white-space: nowrap;" align="right"><?= rupiah($row['hna']*$row['jumlah_penjualan']) ?></td>
            </tr>	
	<?php
            $total = $total + ($row['hna']*$row['jumlah_penjualan']);
        }else{
            $total_embalase=$total_embalase+($row['hna']*$row['jumlah_penjualan']);
        }
	$biaya_apt=$row['biaya_apoteker'];
        $diskon=$row['diskon'];
        $total_tagihan=$row['total_tagihan'];
	}
        $jml_r=$_GET['kelas'] != null?$row['no_r']:0;
        ?>
		
	</table>
</div>
<div class="body-nota">
	<table width=100%>
		<tr><td style="width:60%;text-align: right">TOTAL</td><td></td><td align="right"><?= rupiah($total) ?></td></tr>
                <tr><td style="width:60%;text-align: right">JASA PELAYANAN</td><td></td><td align="right"><?= rupiah($biaya_apt) ?></td></tr>
                <tr><td style="width:60%;text-align: right">JASA SARANA</td><td></td><td align="right"><?= rupiah($total_embalase) ?></td></tr>
                <tr><td style="width:60%;text-align: right">DISKON</td><td></td><td align="right"><?= rupiah($diskon) ?></td></tr>
                <tr><td style="width:60%;text-align: right">TOTAL TAGIHAN</td><td></td><td align="right"><?= rupiah($total_tagihan) ?></td></tr>
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