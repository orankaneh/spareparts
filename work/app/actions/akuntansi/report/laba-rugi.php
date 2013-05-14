<?php 
require_once "app/lib/common/functions.php";
$bulan = isset($_GET['bulan'])?$_GET['bulan']:date('m');
$tahun = isset($_GET['tahun'])?$_GET['tahun']:date('Y');
if(isset($_GET['to']) && $_GET['to']=='LR'){
$url = app_base_url("akuntansi/report/laba-rugi?LR=true&bulan=".$bulan."&tahun=".$tahun);
$url2=app_base_url('akuntansi/jurnal-umum');
die("<div class='notif'>
Apakah anda yakin transaksi jurnal Umum pada bulan $bulan tahun $tahun sudah Benar?<br>
Karena apabila anda melihat laporan laba rugi,<br>
Jurnal umum sudah <b>tidak dapat</b> di edit lagi.<br><br>
<input type='button' class='stylebutton' value='Batal, Lihat Laporan Jurnal Umum' onclick=\"javascript:location.href='$url2' \"/>
<input type='button' class='stylebutton redbutton' value='Ya, lihat Laporan Labarugi' onClick=\"go('ya','alert_LR','contentLR','$url');getButtonGenerate();getButtonGeneratePM();getButtonGenerateN();\"/>

</div>");
}else if(isset($_GET['LR'])){
	require_once "app/lib/common/master-akuntansi.php";
	$data_laporan = laporan_labarugi_muat_data($bulan,$tahun);
	generateBulanSebelumnya($bulan,$tahun);
	?>
	<div class='data-list full w700px' >
	<fieldset><legend>Laporan Labarugi Bulan <?php echo bulan($bulan).' / '.$tahun;?></legend>
		<table class='data-list w700px'>
			<dl >
				<?php
					$kategori="";
					$pendapatan = 0;	
					$count=count($data_laporan['penjumlah']);
					$no=1;
					foreach($data_laporan['penjumlah'] as $key=>$data){
						if($key!=$kategori) echo "<tr ><td width='400px' ><dt><b>$key</b></dt></td><td width='150px'></td><td width='150px'></td></tr>";
						$kategori = $key;
						$counts = count($data);
						$nos=1;
						foreach($data as $record){
							if($record['nama_rek']!=null || $record['nama_rek']!='' ){
							echo "<tr class='even ' ><td width='400px'><dd>- $record[nama_rek] </dd></td><td width='150px'></td><td width='150px' align='right'>".rupiahplus($record['saldo'])."</td>";
							if ($no==$count and $nos==$counts) echo "<td rowspan=2>&nbsp;+&nbsp;</td>"; //krikrik
							echo "</tr>";
							$pendapatan +=$record['saldo'];
							}
							$nos+=1;
						}
						if(count($data_laporan['penjumlah'][$key])<=0){
							echo "<tr class='even ' ><td width='400px'><dd>- <i>NULL</i> </dd></td><td width='150px'></td><td width='150px' align='right'>".rupiahplus(0)."</td>";
							if ($no==$count) echo "<td rowspan=2>&nbsp;+&nbsp;</td>";
							echo "</tr>";
						}
							
						$no+=1;
					}
					if(count($data_laporan['penjumlah'])<=0){
						echo "<tr class='even ' ><td width='400px'><dd>- <i>NULL</i> </dd></td><td width='150px'></td><td width='150px' align='right'>".rupiahplus(0)."</td></tr>";
					}
					echo "<tr class='even ' ><td width='400px'><dd><b>Total </b></dd></td><td width='150px'></td><td width='150px' style='border-top: 1px solid #000' align='right'>".rupiahplus($pendapatan)."</td></tr>";
					$kategori2="";
					$beban=0;
					foreach($data_laporan['pengurang'] as $key=>$data){
						if($key!=$kategori2) echo "<tr ><td width='400px'><dt><b>$key</b></dt></td><td width='150px'></td><td width='150px'></td></tr>";
						$kategori2 = $key;
						foreach($data as $record){
							if($record['nama_rek']!=null || $record['nama_rek']!='' ){
							echo "<tr class='even ' ><td width='400px'><dd>- $record[nama_rek] </dd></td><td width='150px' align='right'>".rupiahplus($record['saldo'])."</td><td width='150px'></td></tr>";
							$beban +=$record['saldo'];
							}
						}
						if(count($data_laporan['pengurang'][$key])<=0){
							echo "<tr class='even ' ><td width='400px'><dd>- <i>NULL</i> </dd></td><td width='150px' align='right'>".rupiahplus(0)."</td><td width='150px'></td></tr>";
						}
					}
					if(count($data_laporan['pengurang'])<=0){
						echo "<tr class='even ' ><td width='400px'><dd>- <i>NULL</i> </dd></td><td width='150px'></td><td width='150px'>Rp 0</td></tr>";
					}
				?>
				<tr class='even'>
					<td width="400px"><dd><b>Total </b></dd></td><td></td><td width="150px" align="right"><?php echo rupiahplus($beban); ?></td><td rowspan=2>&nbsp;-&nbsp;</td>
				</tr>
				<tr class='even'>
					<td width="400px"><dd><b>Laba /Rugi Bersih</b></dd></td><td></td><td width="150px" align="right" style='border-top: 1px solid #000' ><?php echo rupiahplus($pendapatan-$beban);?></td>
				</tr>
			</dl>
		</table> <?php
		echo excelButton("akuntansi/excel/laba-rugi?cetak=1&LR=cetak&bulan=".$bulan."&tahun=".$tahun,'Cetak Excel');
		?>
	</fieldset>
</div>
<?php
}
exit;
?>