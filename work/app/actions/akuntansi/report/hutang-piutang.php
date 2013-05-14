<?php

require_once 'app/lib/common/master-akuntansi.php';
require_once 'app/config/db.php';
set_time_zone();

$tipe=isset($_GET['tipe'])?$_GET['tipe']:NULL;
$status=isset($_GET['status'])?$_GET['status']:NULL;
$id=isset($_GET['id'])?$_GET['id']:NULL;

$dataPerson=data_person_hutang_piutang($id,$status);

switch($dataPerson['status_terkait']) {
	case "1": $jenis="Pasien"; $namaPerson=$dataPerson['nama_terkait'];break;
	case "2": $jenis="Pegawai"; $namaPerson=$dataPerson['nama_terkait'];break;
	case "3": $jenis="Instansi"; $namaPerson=$dataPerson['nama_instansi'];break;
}

$profil = profile_rumah_sakit_muat_data();
$data = data_hutang_piutang($id,$tipe,$status);

if ($tipe == "h") $judul="Hutang";
else $judul="Piutang";


		
$namaFile = "laporan-".$judul."-".$jenis."-".$namaPerson.".xls";

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
	

	?>
	<center><h2 class="judul" style="padding: 0; margin:0"><?php echo "LAPORAN ".strtoupper($judul); ?><br/>
	<?php echo $namaPerson." (".$jenis.")<br>".$profil['nama'] ?><h2></center><br/>
	<table border=1>
        <tr>
            <th rowspan="2">Tanggal</th>
            <th rowspan="2">Transaksi</th>
            <th rowspan="2">Jumlah</th>
            <th colspan="2">Debet</th>
            <th colspan="2">Kredit</th>
	    </tr>
        <tr>
            <th>Rekening Debet</th>
            <th>Jumlah </th>
            <th>Rekening Kredit</th>
            <th>Jumlah </th>
        </tr>
        <?php
		$saldoakhir = 0;
        foreach ($data as $key => $row) { 
			$rspan=$row['jumlah_max_rekening'];
			$warnarekening=($key%2)?'odd':'even';
			?>
			<tr class="<?php echo $warnarekening; ?>" id="<?php echo $row['id']; ?>">
				<td align="center" rowspan=<?php echo $rspan; ?>><?= datefmysql($row['tanggal']) ?></td>
				<td rowspan=<?php echo $rspan; ?>><?php echo $row['nama']." <sup>(".$row['nomor_bukti'].")</sup>";?></td>
				<td rowspan=<?php echo $rspan; ?> align="right"><span class="floleft">Rp</span><?= rupiah($row['jumlah']) ?></td>
				<?php for ($i=0; $i < $rspan; $i++) { 
					if (isset($row['rekening_debet'][$i])) {
						echo "<td class='".$row['id']."'>".$row['rekening_debet'][$i]['nama_rekening']."</td><td class='".$row['id']."' align='right'>".rupiah($row['rekening_debet'][$i]['jumlah_rekening'])."</td>";
							if ($tipe == "h") {
								if ($row['rekening_debet'][$i]['kategori']=="2") $saldoakhir=$saldoakhir-$row['rekening_debet'][$i]['jumlah_rekening'];
							} else {
								if ($row['rekening_debet'][$i]['kategori']=="4") $saldoakhir=$saldoakhir+$row['rekening_debet'][$i]['jumlah_rekening'];
							}
					} else { 
						echo "<td class='".$row['id']."'>-</td><td class='".$row['id']."'>-</td>";
					}
					
					if (isset($row['rekening_kredit'][$i])) {
						echo "<td class='".$row['id']."'>".$row['rekening_kredit'][$i]['nama_rekening']."</td><td class='".$row['id']."' align='right'>".rupiah($row['rekening_kredit'][$i]['jumlah_rekening'])."</td>";
						if ($tipe == "h") {
								if ($row['rekening_kredit'][$i]['kategori']=="2") $saldoakhir=$saldoakhir+$row['rekening_kredit'][$i]['jumlah_rekening'];
							} else {
								if ($row['rekening_kredit'][$i]['kategori']=="4") $saldoakhir=$saldoakhir-$row['rekening_kredit'][$i]['jumlah_rekening'];
							}
					} else {
						echo "<td class='".$row['id']."'>-</td><td class='".$row['id']."'>-</td>";
					}
				if ($i<$rspan and $rspan!=1 and $i!=($rspan-1)) echo "</tr><tr class='".$warnarekening."' id='".$row['id']."'>";
				} ?>
			</tr>
			<?php 
			}
			echo "<tr>
				<td colspan=3 align=right><b>Sisa ".$judul."</b></td>
				<td colspan=4 align=right>".rupiah($saldoakhir)."</td>
			</tr>
		</table>";

exit();
?>
