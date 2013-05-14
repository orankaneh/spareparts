<?php 
require_once "app/lib/common/functions.php";
$bulanN = isset($_GET['bulan'])?$_GET['bulan']:date('m');
$tahunN = isset($_GET['tahun'])?$_GET['tahun']:date('Y');
if(isset($_GET['to']) && $_GET['to']=='N'){
$url = app_base_url("akuntansi/report/neraca?N=true&bulan=".$bulanN."&tahun=".$tahunN);
$url2=app_base_url('akuntansi/jurnal-umum');
die("<div class='notif'>
Apakah anda yakin transaksi jurnal Umum pada bulan $bulanN tahun $tahunN sudah Benar?<br>
Karena apabila anda melihat laporan neraca,<br>
Jurnal umum sudah tidak akan dapat di edit lagi.<br><br>
<input type='button' value='Batal, Lihat Laporan Jurnal Umum'  class='stylebutton' onclick=\"javascript:location.href='$url2' \"/>
<input type='button' value='Ya, lihat Neraca'  class='stylebutton redbutton' onClick=\"go('ya','alert_N','contentN','$url');getButtonGenerate();getButtonGeneratePM();getButtonGenerateN();\"/>
</div>");
}else if(isset($_GET['N'])){
	require_once "app/lib/common/master-akuntansi.php";
	$data_laporan = neraca_muat_data($bulanN,$tahunN);
	generateBulanSebelumnya($bulanN,$tahunN);
	?>
	<table class='data-list'>
		<tr>
			<td colspan='7' align='center' ><h1>Laporan Neraca  Bulan <?php echo bulan($bulanN).' '.$tahunN;?></h1></td>
		</tr>
		<tr>
			<td style="width: 600px;border-right: 1px dotted #ccc; padding: 0 10px 0 0">
				<table >
				<?php
						$kategoriKirN="";
						$pendapatanKirN = 0;
						$count=count($data_laporan['kiri']['penjumlah']);
						$no=1;
						foreach($data_laporan['kiri']['penjumlah'] as $key=>$data){
							if($key!=$kategoriKirN) echo "<tr ><td width='350px'><dt><b>$key</b></dt></td><td width='125px'></td><td width='125px'></td></tr>";
							$kategoriKirN = $key;
							$counts = count($data);
							$nos=1;
							foreach($data as $record){
								if($record['nama_rek']!=null || $record['nama_rek']!='' ){
								echo "<tr class='even ' ><td width='350px'><dd>- $record[nama_rek] </dd></td><td width='125px'></td><td width='125px' align='right'>".rupiahplus($record['saldo'])."</td>";
								if ($no==$count and $nos==$counts) echo "<td rowspan=2>&nbsp;+&nbsp;</td>"; //krikrik
								echo "</tr>";
								$pendapatanKirN+=$record['saldo'];
								}
								$nos+=1;
								
							}
							if(count($data_laporan['kiri']['penjumlah'][$key])<=0){
								echo "<tr class='even ' ><td width='400px'><dd>-  <i>NULL</i> </dd></td><td width='150px'></td><td width='150px' align='right'>".rupiahplus(0)."</td>";
								if ($no==$count) echo "<td rowspan=2>&nbsp;+&nbsp;</td>"; //krikrik
								echo "</tr>";
							}
							$no+=1;
						}
						if(count($data_laporan['kiri']['penjumlah'])<=0){
							echo "<tr class='even ' ><td width='400px'><dd>  <i>NULL</i> </dd></td><td width='150px'></td><td width='150px' align='right'>".rupiahplus(0)."</td></tr>";
						}
						?>
						<tr class='even ' ><td width='400px'><dd><b>Total </b></dd></td><td width='150px'></td><td width='150px' align='right' style='border-top: 1px solid #000'><?php echo rupiahplus($pendapatanKirN);?></td></tr>
				<?php
						$kategoriKirN2="";
						$bebanKirN=0;
						foreach($data_laporan['kiri']['pengurang'] as $key=>$data){
							if($key!=$kategoriKirN2) echo "<tr ><td width='350px'><dt><b>$key</b></dt></td><td width='125px'></td><td width='125px'></td></tr>";
							$kategoriKirN2 = $key;
							foreach($data as $record){
								if($record['nama_rek']!=null || $record['nama_rek']!='' ){
								echo "<tr class='even ' ><td width='350px'><dd>- $record[nama_rek] </dd></td><td width='125px' align='right'>".rupiahplus($record['saldo'])."</td><td width='125px'></td></tr>";
			
								$bebanKirN +=$record['saldo'];
								}
							}
							if(count($data_laporan['kiri']['pengurang'][$key])<=0){
								echo "<tr class='even ' ><td width='400px'><dd>-  <i>NULL</i> </dd></td><td width='150px' align='right'>".rupiahplus(0)."</td><td width='150px'></tr>";
							}
						}
						if(count($data_laporan['kiri']['pengurang'])<=0){
							echo "<tr class='even ' ><td width='400px'><dd>  <i>NULL</i> </dd></td><td width='150px' align='right'>".rupiahplus(0)."</td><td width='150px'></td></tr>";
						}
					?>
					<tr class='even'>
						<td width="350px"><dd><b>Total</b></dd></td><td width="125px"></td><td width="125px" align='right'><?php echo rupiahplus($bebanKirN); ?></td><td rowspan=2>&nbsp;+&nbsp;</td></tr>
					</tr>
					<tr class='even'>
						<td width="350px"><dd><b>Total HarTa</b></dd></td><td width="125px"></td><td width="125px" style='border-top: 1px solid #000' align='right'><?php echo rupiahplus($pendapatanKirN-$bebanKirN); ?></td>
					</tr>
				</table>
			</td>
		
			<td  style="width: 600px;padding: 0 0 0 20px">
				<table >
						<?php
						$kategoriKanN="";
						$pendapatanKanN = 0;
			
						foreach($data_laporan['kanan']['penjumlah'] as $key=>$data){
							if($key!=$kategoriKanN) echo "<tr ><td width='350px'><dt><b>$key</b></dt></td><td width='125px'></td><td width='125px'></td></tr>";
							$kategoriKanN = $key;
					
							foreach($data as $record){
								if($record['nama_rek']!=null || $record['nama_rek']!='' ){
									echo "<tr class='even ' ><td width='350px'><dd>- $record[nama_rek] </dd></td><td width='125px'></td><td width='125px' align='right'>".rupiahplus($record['saldo'])."</td></tr>";
									$pendapatanKanN +=$record['saldo'];
								}
								
							}
							if(count($data_laporan['kanan']['penjumlah'][$key])<=0){
								echo "<tr class='even ' ><td width='400px'><dd>-  <i>NULL</i> </dd></td><td width='150px'></td><td width='150px' align='right'>".rupiahplus(0)."</td>";
								echo "</tr>";
							}
							
						}
						if(count($data_laporan['kanan']['penjumlah'])<=0) echo "<tr class='even ' ><td width='400px'><dd>  <i>NULL</i> </dd></td><td width='150px'></td><td width='150px' align='right'>".rupiahplus(0)."</td></tr>";
						
						echo "<tr ><td width='350px'><dt><b>Modal (Akhir)</b></dt></td><td width='125px'></td><td width='125px' align='right'>".rupiahplus($data_laporan["perubahanmodal"])."</td>";
						echo "<td rowspan=2>&nbsp;+&nbsp;</td>"; //krikrik
						echo "</tr>";
						$pendapatanKanN +=$data_laporan['perubahanmodal'];
						?>
						<tr class='even ' ><td width='400px'><dd><b>Total </b></dd></td><td width='150px'></td><td width='150px' style='border-top: 1px solid #000' align='right'><?php echo rupiahplus($pendapatanKanN);?></td></tr>
				<?php
						$kategoriKanN2="";
						$bebanKanN=0;
						foreach($data_laporan['kanan']['pengurang'] as $key=>$data){
							if($key!=$kategoriKanN2) echo "<tr ><td width='350px'><dt><b>$key</b></dt></td><td width='125px'></td><td width='125px'></td></tr>";
							$kategoriKanN2 = $key;
							foreach($data as $record){
								if($record['nama_rek']!=null || $record['nama_rek']!='' ){
								echo "<tr class='even'><td width='350px'><dd>- $record[nama_rek] </dd></td><td width='125px' align='right'>".rupiahplus($record['saldo'])."</td><td width='125px'></td></tr>";
								$bebanKanN +=$record['saldo'];
								}
							}
							if(count($data_laporan['kanan']['pengurang'][$key])<=0){
								echo "<tr class='even ' ><td width='400px'><dd>-  <i>NULL</i> </dd></td><td width='150px' align='right'>".rupiahplus(0)."</td><td width='150px'></td></tr>";
							}
						}
						if(count($data_laporan['kanan']['pengurang'])<=0){
							echo "<tr class='even ' ><td width='400px'><dt><i>NULL</i> </dt></td><td width='150px'align='right'>".rupiahplus(0)."</td><td width='150px'></td></tr>";
						}
					?>
					<tr class='even'>
						<td width="350px"><dd><b>Total</b></dd></td><td width="125px"></td><td width="125px" align='right'><?php echo rupiahplus($bebanKanN);?></td><td rowspan=2>&nbsp;-&nbsp;</td></tr>
					</tr>
					<tr class='even'>
						<td width="350px"><dd><b>Total Utang dan Modal</b></dd></td><td width="125px"></td><td width="125px" align='right' style='border-top: 1px solid #000' ><?php echo rupiahplus($pendapatanKanN-$bebanKanN);?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	</fieldset>
<div class='data-list' width='1200px'>
	<?php
		echo excelButton("akuntansi/excel/neraca?cetak=1&N=cetak&bulan=".$bulanN."&tahun=".$tahunN,'Cetak Excel');
	?>
</div>
<?php
}
exit;
?>