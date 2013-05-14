<?php
require_once 'app/config/db.php';
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';

$pembayaran = pembayaran_penjualan_muat_data($_GET['id']);
$pembayarans= pembayaran_penjualan_muat_data($_GET['id']);
foreach ($pembayaran as $row);
?>
<link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/workspace.css') ?>" media="all" />
<link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/base.css') ?>" media="all" />
	<? require_once 'app/actions/admisi/lembar-header.php'; ?>

<fieldset><legend>Detail Pembeli</legend>
	<table width=100%>
                <tr><td width="26%">Nomor Penjualan</td><td width="0%">:</td><td width="74%"><?= $_GET['id'] ?></td></tr>
		<tr><td width="26%">Pembeli</td><td width="0%">:</td><td width="74%"><?= $row['nama'] ?></td></tr>
                <tr><td width="26%">Total Tagihan</td><td width="0%">:</td><td width="74%"><?= rupiah($row['total_tagihan']) ?></td></tr>
                <tr><td width="26%">Tanggal Penjualan</td><td>:</td><td><?= $row['waktu'] ?></td></tr>
	</table>
</fieldset>
<div class="data-list">
    
	<table width=100% class="tabel" cellspacing="0">
            <tr>
                <th>No</th>
                <th>Tanggal Bayar</th>
                <th>Pegawai</th>
                <th>Jumlah Bayar(Rp.)</th>
                <th>Sisa Tagihan(Rp.)</th>
            </tr>
	<?php
	$total = 0;
	foreach($pembayarans as $key => $rows): ?>
		<tr class="<?= ($key%2)?'odd':'even' ?>">
                    <td align="center"><?= ++$key ?></td>
                    <td align="center"><?= datetime($rows['waktu']) ?></td><td><?= $rows['petugas'] ?></td>
                    <td align="right"><?= rupiah($rows['jumlah_bayar']) ?></td><td align="right"><?= rupiah($rows['sisa']) ?></td>
		</tr>

	<?php
	$total = $total + $rows['jumlah_bayar'];
        $sisa  = $rows['sisa'];
	endforeach; ?>
                <tr><td colspan="3" align="center">TOTAL</td><td align="right"><?= rupiah($total) ?></td><td align="right"><?= rupiah($sisa) ?></td></tr>
	</table>

	<table width=100% style="border:none">

		<tr><td></td><td></td><td align="right">&nbsp;</td></tr>
		<tr><td></td><td></td><td align="right"><?= $_SESSION['nama'] ?><br/>PETUGAS</td></tr>
	</table>

        
    <span id="SCETAK"><input type="button" class="tombol" value="Cetak" onClick="cetak()"/></span>
</div>

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
exit;
?>