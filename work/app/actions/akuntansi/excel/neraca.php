<?php
require_once "app/lib/common/functions.php";
$bulanN = isset($_GET['bulan'])?$_GET['bulan']:date('m');
$tahunN = isset($_GET['tahun'])?$_GET['tahun']:date('Y');
header_excel("neraca-".$bulanN."-".$tahunN.".xls");
if(isset($_GET['N'])){
	require_once "app/lib/common/master-akuntansi.php";
	$data_laporan = neraca_muat_data($bulanN,$tahunN);
	$array_bulan = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December');
	?>
			<table class='data-list floleft' style="width: 600px;border-right: 1px dotted #ccc; padding: 0 10px 0 0" >
			<tr ><td colspan='3' align='center' style='font-size:16'><strong>Laporan Neraca  <?php echo $array_bulan[$bulanN].'  '.$tahunN;?></strong></td></tr>
				<?php
						$kategoriKirN="";
						$pendapatanKirN = 0;
						foreach($data_laporan['kiri']['penjumlah'] as $key=>$data){
							if($key!=$kategoriKirN) echo "<tr ><td width='350px'><dt><b>$key</b></dt></td><td width='125px'></td><td width='125px'></td></tr>";
							$kategoriKirN = $key;
							foreach($data as $record){
								if($record['nama_rek']!=null || $record['nama_rek']!='' ){
								echo "<tr class='even ' ><td width='350px'><dd>- $record[nama_rek] </dd></td><td width='125px'></td><td width='125px' align='right'>Rp ".rupiah($record['saldo'])."</td></tr>";
								$pendapatanKirN +=$record['saldo'];
								}
							}
							if(count($data_laporan['kiri']['penjumlah'][$key])<=0){
								echo "<tr class='even ' ><td width='400px'><dd>-  <i>NULL</i> </dd></td><td width='150px'></td><td width='150px' align='right'>Rp 0</td></tr>";
							}
						}
						if(count($data_laporan['kiri']['penjumlah'])<=0){
							echo "<tr class='even ' ><td width='400px'><dd>  <i>NULL</i> </dd></td><td width='150px'></td><td width='150px' align='right'>Rp 0</td></tr>";
						}
						?>
						<tr class='even ' ><td width='400px'><dd><b>Total </b></dd></td><td width='150px'></td><td width='150px' align='right'>__________&nbsp;+<br/> Rp <?php echo rupiah($pendapatanKirN);?></td></tr>
				<?php
						$kategoriKirN2="";
						$bebanKirN=0;
						foreach($data_laporan['kiri']['pengurang'] as $key=>$data){
							if($key!=$kategoriKirN2) echo "<tr ><td width='350px'><dt><b>$key</b></dt></td><td width='125px'></td><td width='125px'></td></tr>";
							$kategoriKirN2 = $key;
							foreach($data as $record){
								if($record['nama_rek']!=null || $record['nama_rek']!='' ){
								echo "<tr class='even ' ><td width='350px'><dd>- $record[nama_rek] </dd></td><td width='125px' align='right'>Rp ".rupiah($record['saldo'])."</td><td width='125px'></td></tr>";
								$bebanKirN +=$record['saldo'];
								}
							}
							if(count($data_laporan['kiri']['pengurang'][$key])<=0){
								echo "<tr class='even ' ><td width='400px'><dd>-  <i>NULL</i> </dd></td><td width='150px' align='right'>Rp 0</td><td width='150px'></td></tr>";
							}
						}
						if(count($data_laporan['kiri']['pengurang'])<=0){
							echo "<tr class='even ' ><td width='400px'><dd>  <i>NULL</i> </dd></td><td width='150px' align='right'>Rp 0</td><td width='150px'></td></tr>";
						}
					?>
					<tr class='even'>
						<td width="350px"><dd><b>Total</b></dd></td><td width="125px"></td><td width="125px" align='right'>Rp  <?php echo rupiah($bebanKirN); ?><br>__________&nbsp;-</td>
					</tr>
					<tr class='even'>
						<td width="350px"><dd><b>Total HarTa</b></dd></td><td width="125px"></td><td width="125px" align='right'>Rp  <?php echo rupiah($pendapatanKirN-$bebanKirN); ?></td>
					</tr>
			</table>
			<table  class='data-list floleft' style="width: 600px;padding: 0 0 0 20px" ><tr><td>=================================<br>=================================</td><td>==========================<br>==========================</td><td>==========================<br>==========================</td></tr></table>
				<table  class='data-list floleft' style="width: 600px;padding: 0 0 0 20px" >
						<?php
						$kategoriKanN="";
						$pendapatanKanN = 0;
						foreach($data_laporan['kanan']['penjumlah'] as $key=>$data){
							if($key!=$kategoriKanN) echo "<tr ><td width='350px'><dt><b>$key</b></dt></td><td width='125px'></td><td width='125px'></td></tr>";
							$kategoriKanN = $key;
							foreach($data as $record){
								if($record['nama_rek']!=null || $record['nama_rek']!='' ){
									echo "<tr class='even ' ><td width='350px'><dd>- $record[nama_rek] </dd></td><td width='125px'></td><td width='125px' align='right'>Rp ".rupiah($record['saldo'])."</td></tr>";
									$pendapatanKanN +=$record['saldo'];
								}
							}
							if(count($data_laporan['kanan']['penjumlah'][$key])<=0){
								echo "<tr class='even ' ><td width='400px'><dd>-  <i>NULL</i> </dd></td><td width='150px'></td><td width='150px' align='right'>Rp 0</td></tr>";
							}
						}
						if(count($data_laporan['kanan']['penjumlah'])<=0){
							echo "<tr class='even ' ><td width='400px'><dd>  <i>NULL</i> </dd></td><td width='150px'></td><td width='150px' align='right'>Rp 0</td></tr>";
						}
						echo "<tr ><td width='350px'><dt><b>Modal (Akhir)</b></dt></td><td width='125px'></td><td width='125px' align='right'>Rp ".rupiah($data_laporan["perubahanmodal"])."</td></tr>";
						$pendapatanKanN +=$data_laporan['perubahanmodal'];
						?>
						<tr class='even ' ><td width='400px'><dd><b>Total </b></dd></td><td width='150px'></td><td width='150px' align='right'>__________&nbsp;+<br/> Rp <?php echo rupiah($pendapatanKanN);?></td></tr>
				<?php
						$kategoriKanN2="";
						$bebanKanN=0;
						foreach($data_laporan['kanan']['pengurang'] as $key=>$data){
							if($key!=$kategoriKanN2) echo "<tr ><td width='350px'><dt><b>$key</b></dt></td><td width='125px'></td><td width='125px'></td></tr>";
							$kategoriKanN2 = $key;
							foreach($data as $record){
								if($record['nama_rek']!=null || $record['nama_rek']!='' ){
								echo "<tr class='even ' ><td width='350px'><dd>- $record[nama_rek] </dd></td><td width='125px' align='right'>Rp ".rupiah($record['saldo'])."</td><td width='125px'></td></tr>";
								$bebanKanN +=$record['saldo'];
								}
							}
							if(count($data_laporan['kanan']['pengurang'][$key])<=0){
								echo "<tr class='even ' ><td width='400px'><dd>-  <i>NULL</i> </dd></td><td width='150px' align='right'>Rp 0 </td><td width='150px'></td></tr>";
							}
						}
						if(count($data_laporan['kanan']['pengurang'])<=0){
							echo "<tr class='even ' ><td width='400px'><dt>  <i>NULL</i> </dt></td><td width='150px' align='right'>Rp 0 </td><td width='150px'></td></tr>";
						}
					?>
					<tr class='even'>
						<td width="350px"><dd><b>Total</b></dd></td><td width="125px"></td><td width="125px" align='right'>Rp  <?php echo rupiah($bebanKanN);?><br>__________&nbsp;-</td>
					</tr>
					<tr class='even'>
						<td width="350px"><dd><b>Total Utang dan Modal</b></dd></td><td width="125px"></td><td width="125px" align='right'>Rp  <?php echo rupiah($pendapatanKanN-$bebanKanN);?></td>
					</tr>
				</table>
<?php
}
exit;
?>