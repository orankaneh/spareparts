<?php
require_once 'app/config/db.php';
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';

$pembayaran = detail_pembayaran_penjualan_muat_data($_GET['id']);
$pembayarans= detail_pembayaran_penjualan_muat_data($_GET['id']);

foreach ($pembayaran as $row);
$data = _select_unique_result("select count(*)+1 as jumlah from pembayaran where id_penjualan = '$row[id_penjualan]' and id < $_GET[id]");
?>
<link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/tabel.css') ?>" />
<link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/base.css') ?>" />
<style type="text/css">
    * {
        font-size: 12px;
        font-family: Arial;
}
</style>
	<? require_once 'app/actions/admisi/lembar-header.php'; ?>

<fieldset><legend>Detail Pembeli</legend>
	<table width=100%>
                <tr><td width="26%">Nomor Penjualan</td><td width="0%">:</td><td width="74%"><?= $row['id_penjualan'] ?></td></tr>
		<tr><td width="26%">Pembeli</td><td width="0%">:</td><td width="74%"><?= $row['pembeli'] ?></td></tr>
                <tr><td width="26%">Total Tagihan (Rp.)</td><td width="0%">:</td><td width="74%"><?= rupiah($row['total_tagihan']) ?></td></tr>
                <tr><td width="26%">Angsuran Ke</td><td>:</td><td><?= $data['jumlah'] ?></td></tr>
	</table>
</fieldset>
<div class="data-list">

    <table class="tabel" style="width: 100%;">
    <tr>
        <th style="width: 5%">ID</th>
        <th style="width: 10%">Waktu</th>
        <th style="width: 20%">Petugas</th>
        <th style="width: 10%">Jumlah Bayar (Rp)</th>
        <th style="width: 10%">Sisa</th>
    </tr>
    <?php
    
    foreach ($pembayarans as $key => $row):
    ?>
    <tr class="<?= ($key%2)?'odd':'even' ?>">
        <td align="center"><?= $row['id'] ?></td>
        <td align="center"><?= datetime($row['waktu']) ?></td>
        <td><?= $row['petugas'] ?></td>
        <td align="right"><?= rupiah($row['jumlah_bayar']) ?></td>
        <td align="right"><?= rupiah($row['sisa']) ?></td>
    </tr>
    <?php endforeach; ?>
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