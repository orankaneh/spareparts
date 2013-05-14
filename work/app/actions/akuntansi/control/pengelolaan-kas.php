<?php

if (isset($_GET['opsi']) and $_GET['opsi'] == "generatejournal") {
require_once "app/lib/common/functions.php";
require_once "app/lib/common/master-akuntansi.php";

// -- Tanggal -- //

$tanggal = date2mysql($_POST['tanggal']);
$tanggal_parse = explode("-",$tanggal);
$bulan = $tanggal_parse[1];
$tahun = $tanggal_parse[0];

$data = laporan_cash_piutang(date2mysql($_POST['tanggal']));



$bk = _select_unique_result("select * from jurnal where id = (select max(id) from jurnal)");
$no_bukti= substr($bk['nomor_bukti'], 3, 10)+1; 

$datarekening = _select_unique_result("select * from rekening_auto");

// -- Cash -- //

if (count($data['cash'])>0) {
	$jumlah_cash = 0;
	foreach ($data['cash'] as $cash){ $jumlah_cash += $cash['jumlah_bayar']; }
	$no_bukti+=1;
	$sql=_insert("insert into jurnal VALUES (null,'".$tanggal."','Pendapatan Tanggal ".$_POST['tanggal']."','BKP".$no_bukti."','".$jumlah_cash."','1')");
	
	if ($sql) {
		$idjurnal=_last_id();
		
		_insert("insert into detail_jurnal values (null,'".$idjurnal."','".$datarekening['kas']."','".$jumlah_cash."','d')");
		transaksi_jurnalumum($bulan,$tahun,$datarekening['kas']);
		_insert("insert into detail_jurnal values (null,'".$idjurnal."','".$datarekening['pendapatan']."','".$jumlah_cash."','k')");
		transaksi_jurnalumum($bulan,$tahun,$datarekening['pendapatan']);
	}
}

// -- Piutang -- //

if (count($data['piutang'])>0) {
        
	foreach ($data['piutang'] as $piu) {
   
	$no_bukti+=1;
	$sql=_insert("insert into jurnal VALUES (null,'".$tanggal."','Piutang Pasien ".$piu['nama_pas']."','BKP".$no_bukti."','".$piu['jumlah_sisa_tagihan']."','1')");
	
		if ($sql) {
			$idjurnal=_last_id();
			
			_insert("insert into detail_jurnal values (null,'".$idjurnal."','".$datarekening['kas']."','".$piu['jumlah_sisa_tagihan']."','d')");
			transaksi_jurnalumum($bulan,$tahun,$datarekening['kas']);
			_insert("insert into detail_jurnal values (null,'".$idjurnal."','".$datarekening['piutang']."','".$piu['jumlah_sisa_tagihan']."','k')");
			transaksi_jurnalumum($bulan,$tahun,$datarekening['piutang']);
			_insert("insert into hutang_piutang values ('','1','".$piu['id_pas']."','".$idjurnal."','p')");
		}

	} 
}

// -- Piutang Dibayar -- //

if (count($data['piutang_dibayar'])>0) {
        
	foreach ($data['piutang_dibayar'] as $piu) {
   
	$no_bukti+=1;
	$sql=_insert("insert into jurnal VALUES (null,'".$tanggal."','Piutang Pasien ".$piu['nama_pas']."','BKP".$no_bukti."','".$piu['jumlah_bayar']."','1')");
	
		if ($sql) {
			$idjurnal=_last_id();
			
			_insert("insert into detail_jurnal values (null,'".$idjurnal."','".$datarekening['kas']."','".$piu['jumlah_bayarn']."','d')");
			transaksi_jurnalumum($bulan,$tahun,$datarekening['kas']);
			_insert("insert into detail_jurnal values (null,'".$idjurnal."','".$datarekening['piutang']."','".$piu['jumlah_bayar']."','k')");
			transaksi_jurnalumum($bulan,$tahun,$datarekening['piutang']);
			
			_insert("insert into hutang_piutang values ('','1','".$piu['id_pas']."','".$idjurnal."','p')");
		}

	} 
}

_insert("insert into hasil_auto_jurnal values ('','".$tanggal."')");

echo 1;

} else {

if(isset($_GET["tanggal"])){
require_once "app/lib/common/functions.php";
require_once "app/lib/common/master-akuntansi.php";
$tanggal = date2mysql($_GET['tanggal']);
$data = laporan_cash_piutang($tanggal);
$jumlah = 0;

?>
<br>
<script type="text/javascript">
	function autoJurnal(formid) {
		progressAdd(formid);
		$('#auto_button').hide();
		$('#caution').html('Generate Auto Jurnal berhasil dilakukan!').show();
	}
</script>

<fieldset style="clear: both; margin-top: 20px"><legend>Resensi Pendapatan Pada Hari Ini <?php echo $_GET['tanggal']; ?></legend>

	   <table class="tabel" width="450">
        <tr>
            <th width="12%">No</th>
			<th width="50%">Nama Pasien</th>
            <th width="38%">Cash</th>
            
        </tr>
        <?php
        $no = 1;
		$jumlah_cash=0;
		foreach ($data['cash'] as $cash) {
        ?>
        <tr class="<?= ($no % 2) ? 'even' : 'odd' ?>">
            <td align="center"><?= $no;?></td>
            <td><?= $cash['nama_pas'];?></td>
			<td align="right"><?= rupiah($cash['jumlah_bayar']);?></td>
        </tr>
        <?php
		$jumlah_cash += $cash['jumlah_bayar']; 
        $no++;
        }
        ?>
		<tr>
			<td colspan=2 align="right">TOTAL</td>
			<td align="right"><b>Rp <?php echo rupiah($jumlah_cash); ?></b></td>
		</tr>
    </table>
	<br>
   
   <table class="tabel" width="450">
        <tr>
            <th width="12%">No</th>
			<th width="50%">Nama Pasien</th>
            <th width="38%">Piutang</th>
            
        </tr>
        <?php
        $no = 1;
        foreach ($data['piutang'] as $piu){
        ?>
        <tr class="<?= ($no % 2) ? 'even' : 'odd' ?>">
            <td align="center"><?= $no;?></td>
            <td><?= $piu['nama_pas'];?></td>
			<td align="right"><?= rupiah($piu['jumlah_sisa_tagihan']);?></td>
        </tr>
        <?php
        $no++;
        }
        ?>
    </table>
	<br>
    <table class="tabel" width="450">
        <tr>
            <th width="12%">No</th>
			<th width="50%">Nama Pasien</th>
            <th width="38%">Piutang Dibayar</th>
            
        </tr>
        <?php
        $no = 1;
		if (count($data['piutang_dibayar']) == 0) {
			echo "<tr><td colspan='3'>Tidak Ada Piutang Dibayar</td></tr>";
		} else {
			foreach ($data['piutang_dibayar'] as $piu){
			?>
			<tr class="<?= ($no % 2) ? 'even' : 'odd' ?>">
				<td align="center"><?= $no;?></td>
				<td><?= $piu['nama_pas'];?></td>
				<td align="right"><?= rupiah($piu['jumlah_bayar']);?></td>
				
			</tr>
			<?php
		}
        $no++;
        }
        ?>
    </table>
	<br>
	
	
	
	<?php 

	$value_auto = _select_unique_result("select tanggal from hasil_auto_jurnal where tanggal = '".$tanggal."'"); 
	

	if ($value_auto['tanggal'] != "") {
		echo notifikasi("Generate telah dilakukan untuk hari ini");
		
	} else {
	?>
	<form action="<?= app_base_url('akuntansi/control/pengelolaan-kas?') ?>opsi=generatejournal" method="post" onsubmit="autoJurnal($(this));return false;" >
		<input type="hidden" name="tanggal" value="<?php echo $_GET['tanggal']; ?>">
		<input type="submit" value="Generate Laporan Pengelolaan Kas (Jurnal Otomatis)"  id="auto_button" class="stylebutton" name="generatejournal">
	</form>
	<div id="caution" class='notif' style="display: none"></div>
	<?php 
	} ?>
	
</fieldset>
<?php

}
}

exit();