<?php
require_once 'app/config/db.php';
require_once 'app/lib/common/master-akuntansi.php';

$bulan=isset($_GET['bulan'])?$_GET['bulan']:date('m');
$tahun=isset($_GET['tahun'])?$_GET['tahun']:date('Y');
$tipe=$_GET['tipe'];
if ($tipe==1) {
	$judul = "JURNAL UMUM";
	$namefile="jurnal-umum";
} else {
	$judul = "JURNAL PENYESUAIAN";
	$namefile="jurnal-penyesuaian";
}

set_time_zone();

$profil = profile_rumah_sakit_muat_data();
$namaFile = $namefile."_".$bulan."-".$tahun.".xls";

// header file excel

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0,
        pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");

// header untuk nama file
header("Content-Disposition: attachment;
        filename=".$namaFile."");

header("Content-Transfer-Encoding: binary ");

	$profil = profile_rumah_sakit_muat_data();
	$data = jurnal_umum_muat_data($bulan,$tahun,$tipe);
	$jmlHari=cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        
	?>
	
	<center><h2 class="judul"><?php echo $judul."<br>".$profil['nama'] ?><br/>
	<?php 
	if ($bulan == date('m') and $tahun == date('Y')) { ?>	
		Tanggal 1 - <?= date("d") ?> <?= bulan(date("m")) ?> <?= date("Y") ?></h2></center><?php 
	} else {
		echo "Tanggal 1 - ".$jmlHari." ".bulan($bulan)." ".$tahun."</h2></center>";
	}
	?>
	
	<table border=1>
        <tr>
            <th rowspan="2">Tanggal</th>
            <th rowspan="2">Transaksi</th>
            <th rowspan="2">No. Bukti</th>
            <th rowspan="2">Jumlah</th>
            <th colspan="2">Debet</th>
            <th colspan="2">Kredit</th>
			
        </tr>
        <tr>
            <th>Rekening Debet</th>
            <th>Jumlah</th>
            <th>Rekening Kredit</th>
            <th>Jumlah</th>
        </tr>
        <?php
		
		
       
        foreach ($data as $key => $row) { 
		$rspan=$row['jumlah_max_rekening'];
		
		$warnarekening=($key%2)?'odd':'even';
		?>
        <tr class="<?php echo $warnarekening; ?>" id="<?php echo $row['id']; ?>">
            <td align="center" rowspan=<?php echo $rspan; ?>><?= datefmysql($row['tanggal']) ?></td>
            <td rowspan=<?php echo $rspan; ?>><?php echo $row['nama'];
			if (!empty($row['status_terkait'])) {
				echo "<br><span style='font-size: 10px'>";
				switch($row['status_terkait']) {
					case "1": echo "(Pasien : ".$row['nama_terkait'].")";break;
					case "2": echo "(Pegawai : ".$row['nama_terkait'].")";break;
					case "3": echo "(Instansi : ".$row['nama_instansi'].")";break;
				}
				echo "</span>";
			}

			?></td>
            <td rowspan=<?php echo $rspan; ?>><?= $row['nomor_bukti'] ?></td>
			<td rowspan=<?php echo $rspan; ?> align="right"><?php echo rupiah($row['jumlah']); ?></td>
			<?php for ($i=0; $i < $rspan; $i++) { 
			
				if (isset($row['rekening_debet'][$i])) echo "<td class='".$row['id']."'>".$row['rekening_debet'][$i]['nama_rekening']."</td><td class='".$row['id']."' align='right'>".rupiah($row['rekening_debet'][$i]['jumlah_rekening'])."</td>";
				else echo "<td class='".$row['id']."'>-</td><td class='".$row['id']."'>-</td>";
				if (isset($row['rekening_kredit'][$i])) echo "<td class='".$row['id']."'>".$row['rekening_kredit'][$i]['nama_rekening']."</td><td class='".$row['id']."' align='right'>".rupiah($row['rekening_kredit'][$i]['jumlah_rekening'])."</td>";
				else echo "<td class='".$row['id']."'>-</td><td class='".$row['id']."'>-</td>";

			if ($i<$rspan and $rspan!=1 and $i!=($rspan-1)) echo "</tr><tr>";
			} ?>
			
        </tr>
        <?php 
		}
		echo "</table>";

exit();
?>
