<?php
require_once 'app/lib/common/master-akuntansi.php';
$bulan=isset($_GET['bulan'])?$_GET['bulan']:date('m');
$tahun=isset($_GET['tahun'])?$_GET['tahun']:date('Y');
header_excel("kertas-kerja-".$bulan."-".$tahun.".xls");
if(isset($_GET["section"]) && $_GET["section"]=="KK"){
$profil = profile_rumah_sakit_muat_data();
$jmlHari=cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun); 
$data_muat_data = kertas_kerja_muat_data($bulan,$tahun);
	?>
<table>
<tr><th colspan='12'  class="judul" style='font-size: 20px'>Kertas Kerja<br><?= $profil['nama'] ?></th></tr>
<tr><th style='font-size: 14px' colspan='12'>Untuk Periode Yang Berakhir <?php echo $jmlHari." ".bulan($bulan)." ".$tahun; ?></th></tr>
</table>
<table class="data-list tabel w800px" border='1'>
	<tr>
		<th rowspan="2" colspan="2">Rekening</th>
		<th colspan="2">Neraca Saldo</th>
		<th colspan="2">Jurnal Penyesuaian</th>
		<th colspan="2">Neraca Saldo Disesuaikan</th>
		<th colspan="2">Laba Rugi</th>
		<th colspan="2">Neraca</th>
	</tr>
	<tr>
		<th>Debit</th>
		<th>Kredit</th>
		<th>Debit</th>
		<th>Kredit</th>
		<th>Debit</th>
		<th>Kredit</th>
		<th>Debit</th>
		<th>Kredit</th>
		<th>Debit</th>
		<th>Kredit</th>
		
	</tr>
<?php 
	$jml1='0';
	$jml2='0';
	$jml3='0';
	$jml4='0';
	$jml5='0';
	$jml6='0';
	$jml7='0';
	$jml8='0';
	$jml9='0';
	$jml10='0';
	foreach($data_muat_data as $kat=>$rek){
		echo "<tr>";
		echo "<td colspan='12'>$kat</td>";
		echo "</tr>";
		foreach($rek as $datarek){
			$dp = ($datarek['penyesuaian']['debet']!=$datarek['saldo']['debet'] )? $datarek['penyesuaian']['debet']:"";
			$dk =  ($datarek['penyesuaian']['kredit']!=$datarek['saldo']['kredit'] )? $datarek['penyesuaian']['kredit']:"";
			echo "<tr class='even'>";
			echo "<td style=\"width:5px;\"></td>";
			echo "<td >$datarek[nama_rek]</td>";
			echo "<td >".(($datarek['saldo']['debet']=="")? " ":rupiah($datarek['saldo']['debet']))."</td>";
			echo "<td >".(($datarek['saldo']['kredit']=="")? " ":rupiah($datarek['saldo']['kredit']))."</td>";
			echo "<td >".(($dp=="")? "":rupiah($dp))."</td>";
			echo "<td >".(($dk=="")? "":rupiah($dk))."</td>";
			echo "<td >".(($datarek['saldo_disesuaikan']['debet']=="")? " ":rupiah($datarek['saldo_disesuaikan']['debet']))."</td>";
			echo "<td >".(($datarek['saldo_disesuaikan']['kredit']=="")? " ":rupiah($datarek['saldo_disesuaikan']['kredit']))."</td>";
			echo "<td >".(($datarek['laba_rugi']['debet']=="")? " ":rupiah($datarek['laba_rugi']['debet']))."</td>";
			echo "<td >".(($datarek['laba_rugi']['kredit']=="")? " ":rupiah($datarek['laba_rugi']['kredit']))."</td>";
			echo "<td >".(($datarek['neraca']['debet']=="")? "":rupiah($datarek['neraca']['debet']))."</td>";
			echo "<td >".(($datarek['neraca']['kredit']=="")? "":rupiah($datarek['neraca']['kredit']))."</td>";
			echo "</tr>";
			$jml1+=$datarek['saldo']['debet'];
			$jml2+=$datarek['saldo']['kredit'];
			$jml3+=$dp;
			$jml4+=$dk;
			$jml5+=$datarek['saldo_disesuaikan']['debet'];
			$jml6+=$datarek['saldo_disesuaikan']['kredit'];
			$jml7+=$datarek['laba_rugi']['debet'];
			$jml8+=$datarek['laba_rugi']['kredit'];
			$jml9+=$datarek['neraca']['debet'];
			$jml10+=$datarek['neraca']['kredit'];
		}
	}
	echo "<tr class='even'>";
	echo "<td colspan='2'>Jumlah</td><td>".rupiah($jml1)."</td><td>".rupiah($jml2)."</td><td>".rupiah($jml3)."</td><td>".rupiah($jml4)."</td><td>".rupiah($jml5)."</td><td>".rupiah($jml6)."</td><td>".rupiah($jml7)."</td><td>".rupiah($jml8)."</td><td>".rupiah($jml9)."</td><td>".rupiah($jml10)."</td>";
	echo "</tr>";
	echo "<tr class='even'>";
	$lrDebet = ($jml7<$jml8)?($jml8-$jml7):'0';
	$lrKredit = ($jml8<$jml7)?($jml7-$jml8):'0';
	$NKredit = ($jml10<=$jml9)?($jml9-$jml10):($jml10-$jml9);
	echo "<td colspan='2'>Laba Rugi</td><td></td><td></td><td></td><td></td><td></td><td></td><td>".rupiah($lrDebet)."</td><td>".rupiah($lrKredit)."</td><td></td><td>".rupiah($NKredit)."</td>";
	echo "</tr>";
	echo "<tr class='even'>";
	echo "<td colspan='2'>Total</td><td>".rupiah($jml1)."</td><td>".rupiah($jml2)."</td><td>".rupiah($jml3)."</td><td>".rupiah($jml4)."</td><td>".rupiah($jml5)."</td><td>".rupiah($jml6)."</td><td>".rupiah($jml7+$lrDebet)."</td><td>".rupiah($jml8+$lrKredit)."</td><td>".rupiah($jml9)."</td><td>".rupiah(($jml10<$jml9)?($jml10+$NKredit):($jml10-$NKredit))."</td>";
	echo "</tr>";
	echo "</table>";
}
exit;