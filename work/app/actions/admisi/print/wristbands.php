<link rel="stylesheet" href="<?= app_base_url('assets/css/barcode.css') ?>" />
<title>Cetak Wristbands</title>
<?php
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';
include 'app/actions/admisi/pesan.php';
function datediff($d1, $d2){  
	$d1 = (is_string($d1) ? strtotime($d1) : $d1);  
	$d2 = (is_string($d2) ? strtotime($d2) : $d2);  
	$diff_secs = abs($d1 - $d2);  
	$base_year = min(date("Y", $d1), date("Y", $d2));  
	$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);  
	return array( "years" => date("Y", $diff) - $base_year,  "months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1,  "months" => date("n", $diff) - 1,  "days_total" => floor($diff_secs / (3600 * 24)),  "days" => date("j", $diff) - 1,  "hours_total" => floor($diff_secs / 3600),  "hours" => date("G", $diff),  "minutes_total" => floor($diff_secs / 60),  "minutes" => (int) date("i", $diff),  "seconds_total" => $diff_secs,  "seconds" => (int) date("s", $diff)  );  
 }  

$row = pasien_muat_data($id = $_GET['norm'], $key = NULL, $category = NULL, $sort = NULL,$sortBy=null, $page = null, $dataPerPage = null);
$a = datediff($row['tanggal_lahir'], date("Y/m/d/ h:m:s"));
$thn = isset($a['years'])?$a['years']:NULL;
$bln = isset($a['months'])?$a['months']:NULL;
$day = isset($a['days'])?$a['days']:NULL;

?>
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
<div style="margin: 5px;width: 290px; text-align: center">
	
	<div class="barcode"><span id="stikerBarcode" style="font-size: 36px;padding-top: 5px;font-family: 'barcode','free 3 of 9';">*<?= $_GET['norm'] ?>*</span><br/>&nbsp<span style="font-size:15px; font: 16px arial;letter-spacing:9px;"><?= $_GET['norm'] ?></span></div>
	<div class="info"> <span style="font: 10px 'consolas',arial,tahoma; line-height: 10px"><?= $row['nama'] ?> <br/> <?php echo ''.$thn.' tahun '.$bln.' bulan '.$day.' hari'; ?> <br/> <?= $row['alamat_jalan'] . '<br/>' . $row['nama_kelurahan'] ?></span></div>
</div>
<p>
<span id='SCETAK'><input type='button' class='tombol' value='Cetak' onClick='cetak()'/></span>
</p>
<?php die; ?>