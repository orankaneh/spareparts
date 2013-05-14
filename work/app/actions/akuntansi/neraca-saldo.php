<?php


if (isset($_GET['section'])) {

switch($_GET['section']) {

// ---------------------- Tabel Neraca Saldo -------------------------- //

case "tabelneracasaldo":

require_once 'app/lib/common/master-akuntansi.php';
$profil = profile_rumah_sakit_muat_data();

set_time_zone();
$bulan=isset($_GET['bulan'])?$_GET['bulan']:date('m');
$tahun=isset($_GET['tahun'])?$_GET['tahun']:date('Y');
$jmlHari=cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun); ?>

<center><h2 class="judul" style="padding: 0; margin: 0">NERACA SALDO<br><?= $profil['nama'] ?><h2>
Periode 1 - <?php echo $jmlHari." ".bulan($bulan)." ".$tahun; ?></center>

<div class="data-list full">
<?php

$neraca=neracasaldo_muatdata($bulan,$tahun); 

if (count($neraca) != 0) {
echo excelButton("/akuntansi/report/neraca-saldo?bulan=".$bulan."&tahun=".$tahun,'Cetak Excel');
?>
<center>
<table class="tabel full" style="margin: 10px auto">
        <tr>
            <th width="4%" rowspan="2">No</th>
            <th width="18%" rowspan="2">Rekening / No</th>

			<th width="39%" colspan="2">Sebelum Disesuaikan</th>
			<th width="39%" colspan="2">Penyesuaian</th>
			<th width="39%" colspan="2">Setelah Disesuaikan</th>
        </tr>
        <tr>
            <th width="13%">Debet</th>
            <th width="13%">Kredit</th>
			<th width="13%">Debet</th>
			<th width="13%">Kredit</th>
			<th width="13%">Debet</th>
			<th width="13%">Kredit</th>
			</tr>
        <?php
        $no=1;
		$saldo_debet=0;
		$saldo_kredit=0;
		$saldo_penyesuaian_debet=0;
		$saldo_penyesuaian_kredit=0;
        foreach ($neraca as $key => $row) { ?>
        <tr class="<?= ($key%2)?'odd':'even' ?>" id="<?=$row['id']; ?>">
            <td align="center"><?php echo $no ?></td>
            <td><?php echo $row['nama']." / ".$row['kode']; ?></td><?php 
			
			// Sebelum Penyesuaian
			
			if ($row['status']==1) {
				/*if ($row['jumlah'] < 0) {
					echo "<td></td>";
					echo "<td align='right'>".rupiahplus(abs($row['jumlah']))."</td>";
				} else {*/
					echo "<td align='right'>",rupiahplus($row['jumlah'])."</td>";
					echo "<td></td>";
				/*}*/
				$saldo_debet+=$row['jumlah'];
			} else {
				/*if ($row['jumlah'] < 0) {
					echo "<td align='right'>",rupiahplus(abs($row['jumlah']))."</td>";
					echo "<td></td>";
				} else {*/
					echo "<td></td>";
					echo "<td align='right'>",rupiahplus($row['jumlah'])."</td>";
				/*}*/
				$saldo_kredit+=$row['jumlah'];
			}
			
			// Penyesuaian
			
			if ($row['status']==1) {
				if ($row['jumlah_disesuaikan'] < 0) {
					echo "<td></td>";
					echo "<td align='right'>";
					echo (!empty($row['jumlah_disesuaikan']))?rupiahplus(abs($row['jumlah_disesuaikan'])):Null;
					echo "</td>";
				} else {
					echo "<td align='right'>";
					echo (!empty($row['jumlah_disesuaikan']))?rupiahplus($row['jumlah_disesuaikan']):Null;
					echo "</td>";
					echo "<td></td>";
				}
			} else {
				if ($row['jumlah_disesuaikan'] < 0) {
					echo "<td align='right'>";
					echo (!empty($row['jumlah_disesuaikan']))?rupiahplus(abs($row['jumlah_disesuaikan'])):Null;
					echo "</td>";
					echo "<td></td>";
				} else {
					echo "<td></td>";
					echo "<td align='right'>";
					echo (!empty($row['jumlah_disesuaikan']))?rupiahplus($row['jumlah_disesuaikan']):Null;
					echo "</td>";
				}
			}

			
			// Setelah Penyesuaian
			
			
			if ($row['status']==1) {
				
				/*if ($row['jumlah_akhir'] < 0) {
					echo "<td></td>";
					echo "<td align='right'>";
					echo !empty($row['jumlah_akhir'])?rupiahplus(abs($row['jumlah_akhir'])):Null;
					echo "</td>";
				} else {*/
					echo "<td align='right'>";
					echo !empty($row['jumlah_akhir'])?rupiahplus($row['jumlah_akhir']):Null;
					echo "</td>";
					echo "<td></td>";
				/*}*/
				$saldo_penyesuaian_debet+=$row['jumlah_akhir'];
			} else {
				/*if ($row['jumlah_akhir'] < 0) {
					echo "<td align='right'>";
					echo !empty($row['jumlah_akhir'])?rupiahplus(abs($row['jumlah_akhir'])):Null;
					echo "</td>";
					echo "<td></td>";
				} else {*/
					echo "<td></td>";
					echo "<td align='right'>";
					echo !empty($row['jumlah_akhir'])?rupiahplus($row['jumlah_akhir']):Null;
					echo "</td>";
				/*}*/
				$saldo_penyesuaian_kredit+=$row['jumlah_akhir'];
			} ?>
        </tr>
        <?php
		$no+=1;
		}
        ?>
		<tr>
			<td colspan=2 class="right"><b>TOTAL SALDO</b></td>
			<td class="right"><b><span class="floleft">Rp</span><?php echo rupiah($saldo_debet); ?></b></td>
			<td class="right"><b><span class="floleft">Rp</span><?php echo rupiah($saldo_kredit); ?></b></td>
			<td></td>
			<td></td>
			<td class="right"><b><span class="floleft">Rp</span><?php echo rupiah($saldo_penyesuaian_debet); ?></b></td>
			<td class="right"><b><span class="floleft">Rp</span><?php echo rupiah($saldo_penyesuaian_kredit); ?></b></td>
		</tr>
    </table></center>
<?php
} else {
echo notifikasi("Data Neraca Saldo tidak tersedia",1);
}
echo "</div>";
break;

}

exit();

} else {

set_time_zone();


$bulanArr=array('1'=>'Januari','2'=>'Februari','3'=>'Maret','4'=>'April','5'=>'Mei','6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember',);
$bulanCb="<select name=bulan id=bulan class='search-input' style='width: 120px;margin-right: 5px'>";
if(empty($_GET['bulan'])) $bulan=date('m'); else $bulan=$_GET['bulan'];
if(empty($_GET['tahun'])) $tahun=date('Y'); else $tahun=$_GET['tahun'];

foreach($bulanArr as $key=>$b){
   if($key==$bulan){
	   $selected='selected';
   }else{
	   $selected='';
   }
   $bulanCb.="<option value=$key $selected>$b</option>";
}
$bulanCb.="</select>";
$bulan=date('m');
$tahun=date('Y');
?>

<script type="text/javascript">
	contentloader('<?= app_base_url('akuntansi/neraca-saldo?section=tabelneracasaldo') ?>&bulan=<?php echo $bulan; ?>&tahun=<?php echo $tahun; ?>','#content');
	
	function tampilNeraca(bulan,tahun) {
		contentloader('<?= app_base_url('akuntansi/neraca-saldo?section=tabelneracasaldo') ?>&bulan='+bulan+'&tahun='+tahun,'#content');
	}
</script>


<fieldset>
	<legend>Pilih Bulan & Tahun</legend>
	<form method="POST" class="search-form" style="float: none" onsubmit="tampilNeraca($('#bulan').val(),$('#tahun').val());return false;">
	<?= $bulanCb ?><input type="text" onkeyup="Angka(this)" name="tahun" id="tahun" maxlength="4" value="<?=$tahun?>" class="search-input" style="width: 30px !important">
	<input type="submit" value="" class="search-button">
	</form>
</fieldset>


<div id="content" style="min-height: 300px"></div>

<?php
}
?>