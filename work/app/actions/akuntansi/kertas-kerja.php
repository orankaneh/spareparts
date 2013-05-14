<script type="text/javascript">
	function goDisplayKK(bulan,tahun){
		$('#load').show();
		$.ajax({
				url: "search?opsi=cek_saldo_bulan_terpilih",
				data:'bulan='+bulan+'&tahun='+tahun,
				cache: false,
				dataType: 'json',
				success: function(msg){
					$('#load').hide();
					if(msg.status=='1'){
							$("#content").html("<div class='notif'>Maaf, data tidak tersedia</div>");
					}else{
						contentloader('<?= app_base_url('akuntansi/kertas-kerja?section=KK') ?>&bulan='+bulan+'&tahun='+tahun,'#content');
					}
				},
				error:function(error){
					$('#load').hide();
					caution("ERROR : "+error);
				}
		}); 
	}
</script>
<?php
require_once 'app/lib/common/master-akuntansi.php';
$profil = profile_rumah_sakit_muat_data();

set_time_zone();
$array_bulan = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December');
?>

<?php
if(isset($_GET["section"]) && $_GET["section"]=="KK"){
$bulan=isset($_GET['bulan'])?$_GET['bulan']:date('m');
$tahun=isset($_GET['tahun'])?$_GET['tahun']:date('Y');
$jmlHari=cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun); 
$data_muat_data = kertas_kerja_muat_data($bulan,$tahun);
	?>
<div class='data-list full'>
<center><h1 class="judul">Kertas Kerja<br><?= $profil['nama'] ?><br>
<span style='font-size: 14px'>Untuk Periode Yang Berakhir <?php echo $jmlHari." ".bulan($bulan)." ".$tahun; ?></span></h1></center>
<table class="tabel full">
	<tr>
		<th rowspan="2" colspan="2" width='10%'>Rekening</th>
		<th colspan="2">Neraca Saldo</th>
		<th colspan="2">Jurnal Penyesuaian</th>
		<th colspan="2">Neraca Saldo Disesuaikan</th>
		<th colspan="2">Laba Rugi</th>
		<th colspan="2">Neraca</th>
	</tr>
	<tr>
		<th width='9%'>Debit</th>
		<th width='9%'>Kredit</th>
		<th width='9%'>Debit</th>
		<th width='9%'>Kredit</th>
		<th width='9%'>Debit</th>
		<th width='9%'>Kredit</th>
		<th width='9%'>Debit</th>
		<th width='9%'>Kredit</th>
		<th width='9%'>Debit</th>
		<th width='9%'>Kredit</th>
		
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
			echo "<td align='right'>".(($datarek['saldo']['debet']=="")? " ":rupiah($datarek['saldo']['debet']))."</td>";
			echo "<td align='right'>".(($datarek['saldo']['kredit']=="")? " ":rupiah($datarek['saldo']['kredit']))."</td>";
			echo "<td align='right'>".(($dp=="")? "":rupiah($dp))."</td>";
			echo "<td align='right'>".(($dk=="")? "":rupiah($dk))."</td>";
			echo "<td align='right'>".(($datarek['saldo_disesuaikan']['debet']=="")? " ":rupiah($datarek['saldo_disesuaikan']['debet']))."</td>";
			echo "<td align='right'>".(($datarek['saldo_disesuaikan']['kredit']=="")? " ":rupiah($datarek['saldo_disesuaikan']['kredit']))."</td>";
			echo "<td align='right'>".(($datarek['laba_rugi']['debet']=="")? " ":rupiah($datarek['laba_rugi']['debet']))."</td>";
			echo "<td align='right'>".(($datarek['laba_rugi']['kredit']=="")? " ":rupiah($datarek['laba_rugi']['kredit']))."</td>";
			echo "<td align='right'>".(($datarek['neraca']['debet']=="")? "":rupiah($datarek['neraca']['debet']))."</td>";
			echo "<td align='right'>".(($datarek['neraca']['kredit']=="")? "":rupiah($datarek['neraca']['kredit']))."</td>";
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
	echo "<td colspan='2'>Jumlah</td><td align='right'>".rupiah($jml1)."</td><td align='right'>".rupiah($jml2)."</td><td align='right'>".rupiah($jml3)."</td><td align='right'>".rupiah($jml4)."</td><td align='right'>".rupiah($jml5)."</td><td align='right'>".rupiah($jml6)."</td><td align='right'>".rupiah($jml7)."</td><td align='right'>".rupiah($jml8)."</td><td align='right'>".rupiah($jml9)."</td><td align='right'>".rupiah($jml10)."</td>";
	echo "</tr>";
	echo "<tr class='even'>";
	$lrDebet = ($jml7<$jml8)?($jml8-$jml7):'0';
	$lrKredit = ($jml8<$jml7)?($jml7-$jml8):'0';
	$NKredit = ($jml10<=$jml9)?($jml9-$jml10):($jml10-$jml9);
	echo "<td colspan='2'>Laba Rugi</td><td></td><td></td><td></td><td></td><td></td><td></td><td align='right'>".rupiah($lrDebet)."</td><td align='right'>".rupiah($lrKredit)."</td><td></td><td align='right'>".rupiah($NKredit)."</td>";
	echo "</tr>";
	echo "<tr class='even'>";
	echo "<td colspan='2'>Total</td><td align='right'>".rupiah($jml1)."</td><td align='right'>".rupiah($jml2)."</td><td align='right'>".rupiah($jml3)."</td><td align='right'>".rupiah($jml4)."</td><td align='right'>".rupiah($jml5)."</td><td align='right'>".rupiah($jml6)."</td><td align='right'>".rupiah($jml7+$lrDebet)."</td><td align='right'>".rupiah($jml8+$lrKredit)."</td><td align='right'>".rupiah($jml9)."</td><td align='right'>".rupiah(($jml10<$jml9)?($jml10+$NKredit):($jml10-$NKredit))."</td>";
	echo "</tr>";
	echo "</table>";

		echo "<br><br>".excelButton("akuntansi/excel/kertas-kerja?cetak=1&section=KK&bulan=".$bulan."&tahun=".$tahun,'Cetak Excel');
	echo "</div>";
exit();
}else{
?>
<div class="data-input">
<fieldset><legend>Tampil Laba / Rugi</legend>
  <form method="POST" class="search-form" style="float: none" id="pilihbulan">
        <label for="period">Tahun</label>
		<select name='tahun' id='tahun' class='select-style'>
        <?php
			$tahun = date('Y');$tawal =	$tahun-5;$takhir =	$tahun;
			for($i=$tawal;$i<=$takhir;$i++){
				$selected=(date('Y')==$i)?"selected='selected'":"";
				echo "<option value='".$i."' $selected>".$i."</option>";
			}
		?>
		</select>
        <label for="laporan">Bulan</label>
		<select name='bulan' id='bulan' class='select-style'>
        <?php
		foreach($array_bulan as $key=>$bulan){
			$selected=(date('m')==$key)?"selected='selected'":"";
			echo "<option value='".$key."' $selected>".$bulan."</option>";
		}
		?>
		</select>
		<fieldset class="input-process">
		<?php
		$url = app_base_url("akuntansi/report/laba-rugi?LR=false");
		?>
            <input type="button" class="stylebutton" value="Tampilkan" onClick="goDisplayKK($('#bulan').val(),$('#tahun').val())" >
        </fieldset>
     </form>
</fieldset>
</div>
<?php	
}
?>
<div id="content"></div>