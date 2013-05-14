<?php
require_once "app/lib/common/functions.php";
$bulanPM = isset($_GET['bulan'])?$_GET['bulan']:date('m');
$tahunPM = isset($_GET['tahun'])?$_GET['tahun']:date('Y');
header_excel("laporan-perubahan-modal-".$bulanPM."-".$tahunPM.".xls");
if(isset($_GET['PM'])){
	require_once "app/lib/common/master-akuntansi.php";
	$data_laporan = perubahan_modal_muat_data($bulanPM,$tahunPM);
	$array_bulan = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December');
	?>
		<table class='data-list w700px' >
		<tr ><td colspan='3' align='center' style='font-size:16'><strong>Laporan Perubahan Modal  <?php echo $array_bulan[$bulanPM].'  '.$tahunPM;?></strong></td></tr>
			<dl >
				<?php
					$kategoriPM="";
					$pendapatanPM = 0;
					foreach($data_laporan['penjumlah'] as $key=>$data){
						if($key!=$kategoriPM) echo "<tr ><td width='400px'><dt><b>$key</b></dt></td><td width='150px'></td><td width='150px'></td></tr>";
						$kategoriPM = $key;
						foreach($data as $record){
							if($record['nama_rek']!=null || $record['nama_rek']!='' ){
							echo "<tr class='even ' ><td width='400px'><dd>- $record[nama_rek] </dd></td><td width='150px'></td ><td width='150px' align='right'>Rp ".rupiah($record['saldo'])."</td></tr>";
							$pendapatanPM +=$record['saldo'];
							}
						}
						if(count($data_laporan['penjumlah'][$key])<=0){
							echo "<tr class='even ' ><td width='400px'><dd>-  <i>NULL</i> </dd></td><td width='150px'></td><td width='150px' align='right'>Rp 0</td></tr>";
						}
					}
					if(count($data_laporan['penjumlah'])<=0){
						echo "<tr class='even ' ><td width='400px'><dd>-  <i>NULL</i> </dd></td><td width='150px'></td><td width='150px' align='right'>Rp 0</td></tr>";
					}
					$pendapatanPM +=  $data_laporan['labarugi'];
					?>
					<tr class='even'>
						<td width="400px"><dt><b>Laba / Rugi Bersih</b></dt></td><td width="150px"></td><td width="150px" align='right'><?php echo 'Rp '.rupiah($data_laporan['labarugi']) ;?></td>
					</tr>
					<tr class='even ' ><td width='400px'><dd><b>Total </b></dd></td><td width='150px'></td><td width='150px' align='right'>__________&nbsp;+<br/> Rp <?php echo rupiah($pendapatanPM);?></td></tr>
					<?php
					$kategoriPM2="";
					$bebanPM=0;
					foreach($data_laporan['pengurang'] as $key=>$data){
						if($key!=$kategoriPM2) echo "<tr ><td width='400px'><dt><b>$key</b></dt></td><td width='150px'></td><td width='150px'></td></tr>";
						$kategoriPM2 = $key;
						foreach($data as $record){
							if($record['nama_rek']!=null || $record['nama_rek']!='' ){
							echo "<tr class='even ' ><td width='400px'><dd>- $record[nama_rek] </dd></td><td width='150px' align='right'>Rp ".rupiah($record['saldo'])."</td><td width='150px'></td></tr>";
							$bebanPM +=$record['saldo'];
							}
						}
						if(count($data_laporan['pengurang'][$key])<=0){
							echo "<tr class='even ' ><td width='400px'><dd>-  <i>NULL</i> </dd></td><td width='150px' align='right'>Rp 0</td><td width='150px'></td></tr>";
						}
					}
					if(count($data_laporan['pengurang'])<=0){
						echo "<tr class='even ' ><td width='400px'><dd>-  <i>NULL</i> </dd></td><td width='150px'></td><td width='150px' align='right'>Rp 0</td></tr>";
					}
				?>
				<tr class='even'>
					<td width="400px"><dd><b>Total</b></dd></td><td></td><td width="150px" align='right'><?php echo "Rp ".rupiah($bebanPM);?><br>__________&nbsp;-</td>
				</tr>
				<tr class='even'>
					<td width="400px"><dd><b>Modal (akhir)</b></dd></td><td></td><td width="150px" align='right'><?php echo "Rp ".rupiah($pendapatanPM-$bebanPM);?></td>
				</tr>
			</dl>
		</table>
<?php
}
exit();
?>
?>