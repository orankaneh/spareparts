<?php 
header_excel("laporan-harian-.xls");
if(isset($_GET["tanggal"])){
require_once "app/lib/common/functions.php";
require_once "app/lib/common/master-akuntansi.php";
	$array_data = laporan_harian_muat_data($_GET["tanggal"]);
	$profil = profile_rumah_sakit_muat_data();
	$array_tanggal = explode('-',$_GET["tanggal"]);
	header_excel("laporan-harian-".$_GET["tanggal"].".xls");
	?>
	<table>
	<tr><th colspan='3'  class="judul" style='font-size: 20px'>Laporan Pendapatan<br><?= $profil['nama'] ?></th></tr>
	<tr><th style='font-size: 14px' colspan='3'>per-Tanggal : <?php echo $_GET["tanggal"]; ?></th></tr>
	</table>
	<br><br>
	<table class='data-list w700px' >
		<dl >
			
			<dd></dd>
			<?php
			$tot_all=0;
			foreach($array_data["non_piutang"] as $record=>$data){
				$total='0';
				echo "<tr ><td><dt><strong>".str_replace("_"," ",$record)."</strong></dt></td></tr>";
				foreach($data as $record2=>$data2){
					echo "<tr class='even'><td><dd> - ".$record2."</td><td>Rp ".rupiah($data2["total"])."</dd></td></tr>";
					$total += $data2["total"];
				}
				$tot_all += $total;
				echo "<tr class='even'><td><dd><strong>Total</strong></dd></td><td></td><td>Rp ".rupiah($total)."</td></tr><tr><td colspan='3'></td></tr>";
			}
			if(count($array_data["non_piutang"])<=0){
					echo "<tr ><td><dt><strong><i>NULL</i></strong></dt></td><td></td><td>Rp 0</td></tr>";
			}
			echo "<tr ><td><dt><strong></strong></dt></td><td></td><td>--------------- &nbsp +</td></tr><tr><td colspan='3'></td></tr>";
			echo "<tr class='even'><td><dt><strong>Total Pendapatan Seluruh Poli</strong></dt></td><td></td><td>Rp ".rupiah($tot_all)."</td></tr><tr><td colspan='3'></td></tr>";
			echo "<tr class='even'><td><dt><strong>Piutang Diterima</strong></dt></td><td>Rp ".rupiah($array_data["piutang_diterima"])."</td></tr>";
			echo "<tr class='even'><td><dt><strong>Piutang Terbayar</strong></dt></td><td>Rp ".rupiah($array_data["piutang_terbayar"])."</td></tr>";
			echo "<tr class='even'><td><dt><strong>Piutang Belum Terbayar</strong></dt></td><td>Rp ".rupiah($array_data["piutang_belum_terbayar"])."</td></tr>";
			$sum = $array_data["piutang_diterima"]+$array_data["piutang_terbayar"]+$array_data["piutang_belum_terbayar"];
			echo "<tr class='even'><td><dt><strong>Total Piutang</strong></dt></td><td></td><td>Rp ".rupiah($sum)."</td></tr>";
			?>
		</dl>
		</table>	
	</table>
	<?php
}
exit();