<?php
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';
include 'app/actions/admisi/pesan.php';
set_time_zone();

$startDate = (isset($_GET['startDate'])) ? get_value('startDate') : date("d/m/Y");
$endDate = (isset($_GET['endDate'])) ? get_value('endDate') : date("d/m/Y");
$nakes = isset($_GET['idnakes'])?$_GET['idnakes']:NULL;
$layanan = isset($_GET['idlayanan'])?$_GET['idlayanan']:NULL;
$jasa_medis = jasa_medis_muat_data($startDate, $endDate, $nakes, $layanan);
?>
<link rel="stylesheet" href="<?= app_base_url('assets/css/base.css') ?>" />
<link rel="stylesheet" href="<?= app_base_url('assets/css/tabel.css') ?>" />
<link rel="stylesheet" href="<?= app_base_url('assets/css/style.css') ?>" />
<title>Cetak Laporan Jasa Medis</title>
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
<div class="data-list">
	<?php
	include "app/actions/admisi/lembar-header.php";
	?>
	<center>INFORMASI JASA MEDIS TANGGAL <?= $startDate ?> s.d <?= $endDate ?> </center>
	<table width="55%" class="tabel">
	
            <tr>
				<th>No</th>
                <th>Tanggal</th>
                <th>Nakes</th>
                <th>Layanan</th>
                <th>Jumlah (Rp)</th>
            </tr>
            <?php 
			$total = 0;
			foreach ($jasa_medis as $key => $row): ?>
			<tr class="<?= ($key % 2) ? 'even' : 'odd' ?>">
				<td align="center"><?= ++$key ?></td>
				<td align="center"><?= datefmysql($row['waktu']) ?></td>
				<td><?= $row['nakes'] ?></td>
				<td><?= $row['layanan'] ?></td>
				<td align="center"><?= $row['total'] ?></td>
			</tr>
			
		<?php 
			$total = $total + $row['total'];
		endforeach; ?>
			<tr>
				<td colspan=4>TOTAL</td><td align=center><?= $total ?></td>
			</tr>
	</table>
	
</div>
<div class="data-input">

        <span id="SCETAK"><input type="button" class="tombol" value="Cetak" onClick="cetak()"/></span>
</div>
<?php
die;
?>