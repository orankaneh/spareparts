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
    require_once 'app/lib/common/master-inventory.php';
    require_once 'app/lib/common/master-data.php';
    
    $retur = retur_penjualan_muat_data($_GET['id']);
    $retur=$retur[0];
    $detail = detail_retur_penjualan_muat_data($_GET['id']);
?>

	<? require_once 'app/actions/admisi/lembar-header.php'; ?>
        <center><span style='width:100%;'>KITIR RETUR PENJUALAN</span></center>
<div class="body-nota">
	<table width=100% ">
                <tr><td width="26%">No. Surat Retur</td><td>:</td><td><?= $retur['id']?></td></tr>
		<tr><td width="26%">Pembeli/Pasien</td><td>:</td><td><?= $retur['pembeli'] ?></td></tr>
	</table>
</div>
<div class="body-nota">
	
	<table class='bordertabel' width='100%' cellpadding="0" cellspacing="0">
            <tr>
                <td>Nama</td>
                <td>No. Nota</td>
                <td>Jumlah</td>
                <td>Harga</td>
                <td>Sub Total</td>
            </tr>
	<?php 
        $jumlah=0;
	foreach($detail as $row):
            $d=$row;
            $nama = "$d[barang]";
            if (($d['generik'] == 'Generik') || ($d['generik'] == 'Non Generik')) {
                $nama.= ( $d['kekuatan'] != 0) ? " $d[kekuatan], $d[sediaan]" : " $d[sediaan]";
            }
            $nama .=" @$d[nilai_konversi] $d[satuan_terkecil]";
            $nama.= ( $d['generik'] == 'Generik') ? ' ' . $d['pabrik'] : '';
        ?>
            <tr valign="top">
                <td><?= $nama ?></td>
                <td><?=$row['no_nota']?></td>
                <td><?= $row['jumlah_retur'] ?></td>
                <td align="right" style="white-space: nowrap;"><?= rupiah(($d['hna']*$d['margin']/100)+$d['hna']) ?></td>
                <td style="white-space: nowrap;" align="right"><?=rupiah((($d['hna']*$d['margin']/100)+$d['hna'])*$d['jumlah_retur'])?></td>
            </tr>	
	<?php
            $jumlah+=(($d['hna']*$d['margin']/100)+$d['hna'])*$d['jumlah_retur'];
	endforeach; 
        ?>
		
	</table>
</div>
<div class="body-nota">
	<table width=100%>
            <tr><td style="width:60%;text-align: right">TOTAL RETUR</td><td></td><td align="right"><?= rupiah($jumlah) ?></td></tr>
		<tr><td></td><td></td><td align="right">&nbsp;</td></tr>
		<tr><td></td><td></td><td align="right"><?=$retur['pegawai'] ?><br/>PETUGAS</td></tr>
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