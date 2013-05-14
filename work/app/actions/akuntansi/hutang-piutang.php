<?php

$sub=isset($_GET['section'])?$_GET['section']:NULL;
if (isset($sub)) {

switch ($sub) {

	// --------------------------- List Hutang Piutang --------------------------- //
	
	case "listperson":
	set_time_zone();
	require_once 'app/lib/common/master-akuntansi.php';
	$tipe=isset($_GET['tipe'])?$_GET['tipe']:NULL;
	$status=isset($_GET['status'])?$_GET['status']:NULL;
	$data = data_list_hutang_piutang($tipe,$status);
	
	if (count($data) != 0) { 
	?>
	<div class="data-list w600px">
	<table class="tabel full" style="margin-top: 10px" border=1 bordercolor='#ccc'>
        <tr>
		  <th width="8%">No</th>
		  <th width="27%">Terkait</th>
		  <th width="59%">Nama</th>
		  <th width="6">Status</th>
		</tr><?php
		$no = 1;
		
		
		
		foreach ($data as $key => $row) { ?>
			<tr class='<?php echo ($key%2)?'odd':'even'; ?>'>
				<td align='center'><?php echo $no; ?></td>
				<td><?php
				switch($row['status_terkait']) {
						case "1": echo "Pasien"; $nama=$row['nama_terkait'];break;
						case "2": echo "Pegawai";$nama=$row['nama_terkait'];break;
						case "3": echo "Instansi";$nama=$row['nama_instansi'];break;
				}
				?></td>
				<td><a href="" onclick="lihatLaporan('<?php echo app_base_url('/akuntansi/hutang-piutang?section=laporan')."&id=".$row['id_terkait']."&tipe=".$row['tipe']."&status=".$row['status_terkait']; ?>'); return false"><?php echo $nama; ?></a></td>
				<td><?php echo ($row['tipe']=="h")?"Hutang":"Piutang"; ?> </td>
			
			</tr>


		<?php
		$no+=1;
		} ?>
	</table>
	
	<?php
	} else {
		echo notifikasi("Tidak ada <b>Hutang Piutang</b> pada bulan ini",1);
	}

	
	break;


	// --------------------------- Laporan Hutang Piutang --------------------------- //
	
	case "laporan":
	
	set_time_zone();
	require_once 'app/lib/common/master-akuntansi.php';
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
	
    
	if ($tipe == "h") {
		$judul="Hutang";
		
	} else {
		$judul="Piutang";
	}
        
	if (count($data) != 0) {
	?>
	
	<center><h2 class="judul"><?php echo "LAPORAN ".strtoupper($judul); ?><br/>
	<?php echo $namaPerson." (".$jenis.")<br>".$profil['nama'] ?><h2></center><br/>
	<?php
	
	echo excelButton("akuntansi/report/hutang-piutang?id=".$id."&tipe=".$tipe."&status=".$status,'Cetak Excel');
	?>
	
	<table class="tabel full" style="margin-top: 10px" border=1 bordercolor='#ccc'>
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
				<td rowspan=<?php echo $rspan; ?> align="right"><?= rupiahplus($row['jumlah']) ?></td>
				<?php for ($i=0; $i < $rspan; $i++) { 
					if (isset($row['rekening_debet'][$i])) {
						echo "<td class='".$row['id']."'>".$row['rekening_debet'][$i]['nama_rekening']."</td><td class='".$row['id']."' align='right'>".rupiahplus($row['rekening_debet'][$i]['jumlah_rekening'])."</td>";
							if ($tipe == "h") {
								if ($row['rekening_debet'][$i]['kategori']=="2") $saldoakhir=$saldoakhir-$row['rekening_debet'][$i]['jumlah_rekening'];
							} else {
								if ($row['rekening_debet'][$i]['kategori']=="4") $saldoakhir=$saldoakhir+$row['rekening_debet'][$i]['jumlah_rekening'];
							}
						
					} else { 
						echo "<td class='".$row['id']."'>-</td><td class='".$row['id']."'>-</td>";
					}
					
					if (isset($row['rekening_kredit'][$i])) {
						echo "<td class='".$row['id']."'>".$row['rekening_kredit'][$i]['nama_rekening']."</td><td class='".$row['id']."' align='right'>".rupiahplus($row['rekening_kredit'][$i]['jumlah_rekening'])."</td>";
						if ($tipe == "h") {
								if ($row['rekening_kredit'][$i]['kategori']=="2") $saldoakhir=$saldoakhir+$row['rekening_kredit'][$i]['jumlah_rekening'];
							} else {
								if ($row['rekening_kredit'][$i]['kategori']=="4") $saldoakhir=$saldoakhir-$row['rekening_kredit'][$i]['jumlah_rekening'];
							}
					} else {
						echo "<td class='".$row['id']."'>-</td><td class='".$row['id']."'>-</td>";
					}
				if ($i<$rspan) echo "</tr><tr class='".$warnarekening."' id='".$row['id']."'>";
				} ?>
			</tr>
			<?php 
			}
			echo "<tr>
				<td colspan=3 align=right><b>Sisa ".$judul."</b></td>
				<td colspan=4 align=right>".rupiahplus($saldoakhir)."</td>
			</tr>
			</table>";
		} else {
			echo notifikasi("Tidak ada <b>Hutang Piutang</b> pada bulan ini",1);
		}
        ?>
    </table>
	<?php
	break;
	
	
}
exit();
}


require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';


?>
<script type="text/javascript">

contentloader('<?= app_base_url('/akuntansi/hutang-piutang?section=listperson'); ?>','#content');

function tampilLaporan(tipe,status) {
		contentloader('<?= app_base_url('/akuntansi/hutang-piutang?section=listperson'); ?>&tipe='+tipe+'&status='+status,'#content');
	}
function lihatLaporan(url) {
	contentloader(url,'#content');
}
</script>

<h1 class="judul"><a href="<?= app_base_url('akuntansi/hutang-piutang') ?>">Hutang Piutang</a></h1>

<!-- notifikasi/alert -->

<div id="box-notif"></div><div class="clear"></div>

<fieldset>
	<legend>Pilih Kategori dan Jenis Terkait</legend>
	<form method="POST" class="search-form" style="float: none" onsubmit="tampilLaporan($('#tipe').val(),$('#status').val());return false;" id="pilihbulan">
	
	<select class="select-style" style="width: 120px" id="tipe">
		<option value="">Tampil Semua</option>
		<option value="h">Hutang</option>
		<option value="p">Piutang</option>
	</select>
	
	<select class="select-style" style="width: 140px" id="status">
		<option value="">Tampil Semua</option>
		<option value="1">Pasien</option>
		<option value="2">Pegawai</option>
		<option value="3">Instansi</option>
	</select>
	<input type="submit" value="" class="search-button">
	</form>
</fieldset>

<div id="admission"></div>

<div class="data-list full">
    <div id="content"></div>
</div>