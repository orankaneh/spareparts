<?php
require_once "app/lib/common/functions.php";
$bulan = isset($_GET['bulan'])?$_GET['bulan']:date('m');
$tahun = isset($_GET['tahun'])?$_GET['tahun']:date('Y');
header_excel("laporan-laba-rugi-".$bulan."-".$tahun.".xls");
if(isset($_GET['LR'])){
	require_once "app/lib/common/master-akuntansi.php";
	$bulan = isset($_GET['bulan'])?$_GET['bulan']:date('m');
	$tahun = isset($_GET['tahun'])?$_GET['tahun']:date('Y');
	$data_laporan = laporan_labarugi_muat_data($bulan,$tahun);
	$array_bulan = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December');
	?>
		<table class='data-list w700px' >
			<tr ><td colspan='3' align='center' style='font-size:16'><strong>Laporan Labarugi  <?php echo $array_bulan[$bulan].'  '.$tahun;?></strong></td></tr>
			<dl >
				<?php
					$kategori="";
					$pendapatan = 0;
					foreach($data_laporan['penjumlah'] as $key=>$data){
						if($key!=$kategori) echo "<tr ><td width='400px'><dt><b>$key</b></dt></td><td width='150px'></td><td width='150px'></td></tr>";
						$kategori = $key;
						
						foreach($data as $record){
							if($record['nama_rek']!=null || $record['nama_rek']!='' ){
							echo "<tr class='even ' ><td width='400px'><dd>- $record[nama_rek] </dd></td><td width='150px'></td><td width='150px' align='right'>Rp ".rupiah($record['saldo'])."</td></tr>";
							$pendapatan +=$record['saldo'];
							}
						}
						if(count($data_laporan['penjumlah'][$key])<=0){
							echo "<tr class='even ' ><td width='400px'><dd>- <i>NULL</i> </dd></td><td width='150px'></td><td width='150px align='right''>Rp 0</td></tr>";
						}
					}
					if(count($data_laporan['penjumlah'])<=0){
						echo "<tr class='even ' ><td width='400px'><dd>- <i>NULL</i> </dd></td><td width='150px'></td><td width='150px' align='right'>Rp 0</td></tr>";
					}
					echo "<tr class='even ' ><td width='400px'><dd><b>Total </b></dd></td><td width='150px'></td><td width='150px' align='right'>__________&nbsp;+<br/> Rp ".rupiah($pendapatan)."</td></tr>";
					$kategori2="";
					$beban=0;
					foreach($data_laporan['pengurang'] as $key=>$data){
						if($key!=$kategori2) echo "<tr ><td width='400px'><dt><b>$key</b></dt></td><td width='150px'></td><td width='150px'></td></tr>";
						$kategori2 = $key;
						foreach($data as $record){
							if($record['nama_rek']!=null || $record['nama_rek']!='' ){
							echo "<tr class='even ' ><td width='400px'><dd>- $record[nama_rek] </dd></td><td width='150px' align='right'>Rp ".rupiah($record['saldo'])."</td><td width='150px'></td></tr>";
							$beban +=$record['saldo'];
							}
						}
						if(count($data_laporan['pengurang'][$key])<=0){
							echo "<tr class='even ' ><td width='400px'><dd>- <i>NULL</i> </dd></td><td width='150px' align='right'>Rp 0</td><td width='150px'></td></tr>";
						}
					}
					if(count($data_laporan['pengurang'])<=0){
						echo "<tr class='even ' ><td width='400px'><dd>- <i>NULL</i> </dd></td><td width='150px'></td><td width='150px' align='right'>Rp 0</td></tr>";
					}
				?>
				<tr class='even'>
					<td width="400px"><dd><b>Total </b></dd></td><td></td><td width="150px" align='right'><?php echo "Rp ".rupiah($beban);?><br>__________&nbsp;-</td>
				</tr>
				<tr class='even'>
					<td width="400px"><dd><b>Laba /Rugi Bersih</b></dd></td><td></td><td width="150px" align='right'><?php echo "Rp ".rupiah($pendapatan-$beban);?></td>
				</tr>
			</dl>
		</table>
<?php
}
exit;