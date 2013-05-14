<?php
//include_once "include_once.php";
echo "<div class='dasar'>";
echo "<link rel='stylesheet' href='public/scripts/sorter/style.css' />";
if ($_GET['period'] == '1') {
$awal = date2mysql($_GET[awal]);
$akhir = date2mysql($_GET[akhir]);
$selisih = (strtotime(date2mysql($_GET[akhir])) - strtotime(date2mysql($_GET[awal])))/24/60/60;
echo "
	<center>LAPORAN HARIAN UNIT ADMISI REKAP PENDAPATAN PENDAFTARAN <br>
	PERIODE: ".indoTgl($_GET[awal])." s. d ".indoTgl($_GET[akhir])." </center>
	<table cellpadding='0' cellspacing='0' border='0' id='table' class='sortable' style='width:100%;' style='width:100%;'>
		<thead>
			<tr>
				<th rowspan='2'><h3>No</h3></th>
				<th rowspan='2'><h3>Item Pendapatan</th>
				<th colspan='".($selisih+2)."' class='nosort' style='text-align:center;'><h3>Pendapatan Per Hari (Rp.)</h3></th></tr>";

				$date = explode("/",$_GET['awal']);
				for ($i = 0; $i <= $selisih; $i ++) {
					$x  = mktime(0, 0, 0, date($date[1]), date($date[0])+$i, date($date[2]));
					$new = date("d",$x);
					echo "<th class='nosort' style='text-align:center;'><h3>$new</h3></th>";
				}
			echo "<th style='text-align:center;'><h3>Total</h3></th></tr></thead><tbody>";
	$sql = mysql_query("select * from tarif");
	$no = 1;
	while ($row = mysql_fetch_array($sql)) {
			echo "<tr bgcolor='"; if ($no % 2 == 1) echo "#FFFFFF"; else echo "#F9F9F9"; echo "'>
				<td align=center>$no</td>
				<td>$row[nama]</td>";
				for ($i = 0; $i <= $selisih; $i ++) {
					$x  = mktime(0, 0, 0, date($date[1]), date($date[0])+$i, date($date[2]));
					$new = date("Y-m-d",$x);
					$data= mysql_fetch_array(mysql_query("select sum(t.harga) as total from kunjungan k, pelayanan p, tarif t where k.id = p.id_kunjungan 
					and p.id_tarif = t.id and k.waktu like ('$new%') and t.id = '$row[id]'"));
					if ($data[total] == NULL) echo "<td align=center>-</td>"; else echo "<td>".cost($data[total])."</td>";
					
				}
			$data= mysql_fetch_array(mysql_query("select sum(t.harga) as total from kunjungan k, pelayanan p, tarif t where k.id = p.id_kunjungan 
					and p.id_tarif = t.id and k.waktu between '$awal' and '$akhir' and t.id = '$row[id]'"));
			echo "<td>".cost($data[total])."</td></tr>";
	$no += 1;
	}
	$jml = mysql_fetch_array(mysql_query("select count(p.id) as jumlah, sum(t.harga) as harga from pelayanan p, tarif t where p.id_tarif = t.id"));
	echo "</tbody>
	<tr bgcolor=#FFFFF><td></td><td>TOTAL</td>";
	$date = explode("/",$_GET['awal']);
	for ($i = 0; $i <= $selisih; $i ++) {
		$x  = mktime(0, 0, 0, date($date[1]), date($date[0])+$i, date($date[2]));
		$new = date("Y-m-d",$x);
		$data= mysql_fetch_array(mysql_query("select sum(t.harga) as total from kunjungan k, pelayanan p, tarif t where k.id = p.id_kunjungan and p.id_tarif = t.id and k.waktu like ('$new%')"));
		
		if ($data[total] == NULL) echo "<td align=center>-</td>"; else echo "<td>".cost($data[total])."</td>";
	}
	$data= mysql_fetch_array(mysql_query("select sum(t.harga) as total from kunjungan k, pelayanan p, tarif t where k.id = p.id_kunjungan and p.id_tarif = t.id and k.waktu between '$awal' and '$akhir'"));
	
	echo "<td>".cost($data[total])."</td></tr>
	</table>
	<br><center><input type=button name=cetak value=' Cetak ' class=tombol onclick=\"window.open('./print/TR/?period=$_GET[period]&awal=$_GET[awal]&akhir=$_GET[akhir]','popup','width=1000,height=650,scrollbars=yes, resizable=no');\"></center>
	
	";
	
}
else if ($_GET['period'] == '2') {
	$sql = mysql_query("select week('".date2mysql($_GET[awal])."',1) as minggu1, week('".date2mysql($_GET[akhir])."',1) as minggu2");
	$row = mysql_fetch_array($sql);
	
	$selisih = $row[minggu2] - $row[minggu1];
	$a = mysql_fetch_array(mysql_query("select dayofweek('".date2mysql($_GET[awal])."') as hari_ke"));
	
	$slh_hari = $a[hari_ke] - 2; // inisialisasi awal hari senin
	if ($slh_hari == 0) {
		$tanggal = date2mysql($_GET[awal]);
	}
	if ($slh_hari > 0) {
		$tanggal = mysql_fetch_array(mysql_query("select '".date2mysql($_GET[awal])."' - INTERVAL $slh_hari DAY as new_day"));
		//echo "select INTERVAL $slh_hari DAY - '".date2mysql($_GET[awal])."' as new_day";
		$tanggal = $tanggal[new_day];
	}
	if ($slh_hari < 0) {
		$tanggal = mysql_fetch_array(mysql_query("select '".date2mysql($_GET[awal])."' - INTERVAL $slh_hari DAY as new_day"));
		$tanggal = $tanggal[new_day];
	}
	echo "<center>LAPORAN MINGGUAN UNIT ADMISI REKAP PENDAPATAN PENDAFTARAN <br>
	PERIODE: Minggu ke $row[minggu1] s . d Minggu ke $row[minggu2]</h2>";
	//if ($_GET['idAgm'] != 'sa') { $aksi = "where id = '$_GET[idAgm]'"; $axsi = "and dp.id_agama = '$_GET[idAgm]'"; }
	echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='sortable' style='width:100%;'>
		<thead>
			<tr>
				<th width='20px' rowspan=2><h3>No</h3></th>
				<th width='165px' rowspan=2><h3>Nama Agama</h3></th>
				<th colspan='".($selisih+2)."' class='nosort' style='text-align:center;'><h3>BANYAK PASIEN MINGGU KE -</th></tr>";

				$date = explode("-",$tanggal);
				$no = 0;
				for ($i = $row[minggu1]; $i <= $row[minggu2]; $i ++) {
					$x  = mktime(0, 0, 0, date($date[1]), date($date[2])+(7*$no), date($date[0]));
					$thn = date("Y-m-d",$x);
					$sqli = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
					echo "<th class='nosort' style='text-align:center;'><h3>$i</h3></th>";
				$no += 1;
				}
	echo "<th style='text-align:center;'><h3>Total</h3></th></tr></thead><tbody>
				";
				
		$sql = mysql_query("select * from tarif");
		$no = 1;
		while ($rows = mysql_fetch_array($sql)) {
			
			echo "<tr bgcolor='"; if ($no % 2 == 0) echo "#F4F4F4"; else echo "#FFFFFF"; echo "'>
			<td align=center>$no</td>
			<td>$rows[nama]</td>
			";
			$date = explode("-",$tanggal);
			$n = 0;
			
			for ($i = $row[minggu1]; $i <= $row[minggu2]; $i ++) {
				$x  = mktime(0, 0, 0, date($date[1]), date($date[2])+(7*$n), date($date[0]));
				$thn = date("Y-m-d",$x);
				$next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
				
				$jml = mysql_fetch_array(mysql_query("select sum(t.harga) as total from kunjungan k, pelayanan p, tarif t where k.id = p.id_kunjungan and p.id_tarif = t.id and t.id = '$rows[id]' and k.waktu between '$thn' and '$next[0]'"));
				
				if ($jml[total] == '') $total = "-"; else $total = "$jml[total]";
				echo "<td align=center>".cost($total)." </td>";
			$n += 1;
			}
			$jml = mysql_fetch_array(mysql_query("select sum(t.harga) as total from kunjungan k, pelayanan p, tarif t where k.id = p.id_kunjungan and p.id_tarif = t.id and t.id = '$rows[id]' and k.waktu between '$tanggal' and '$next[0]'"));
			echo "<td align=center>".cost($jml[total])." </td>
			</tr>
			";
		$no += 1;
		}
		
		echo "</tbody>
		<tr><td></td><td>Total</td>";
		$date = explode("-",$tanggal);
		$no = 0;
		for ($i = $row[minggu1]; $i <= $row[minggu2]; $i ++) {
			$x  = mktime(0, 0, 0, date($date[1]), date($date[2])+(7*$no), date($date[0]));
			$thn = date("Y-m-d",$x);
			$next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
			$total = mysql_fetch_array(mysql_query("select sum(t.harga) as total from kunjungan k, pelayanan p, tarif t where k.id = p.id_kunjungan and p.id_tarif = t.id  and k.waktu between '$thn' and '$next[0]'"));
			if ($total[total] == '') $total = "-"; else $total = "$total[total]";
			echo "<td align=center>".cost($total)."</td>";
			$no += 1;
		}
		$total = mysql_fetch_array(mysql_query("select sum(t.harga) as total from kunjungan k, pelayanan p, tarif t where k.id = p.id_kunjungan and p.id_tarif = t.id  and k.waktu between '$tanggal' and '$next[0]'"));
		echo "<td align=center>".cost($total[total])." </td></tr>
		</table>";
		echo "<br><center><input type=button name=cetak value=' Cetak ' class=tombol onclick=\"window.open('./print/TR/?period=$_GET[period]&awal=$_GET[awal]&akhir=$_GET[akhir]','popup','width=1000,height=650,scrollbars=yes, resizable=no');\"></center>
";
}
else if ($_GET['period'] == '3') {
	if (strlen(blnAngka($_GET[bln1])) < 2) {
		$bln1 = "0".blnAngka($_GET[bln1])."";
	}
	else if (strlen(blnAngka($_GET[bln1])) == 2) {
		$bln1 = blnAngka($_GET[bln1]);
	}
	
	if (strlen(blnAngka($_GET[bln2])) < 2) {
		$bln2 = "0".blnAngka($_GET[bln2])."";
	}
	else if (strlen(blnAngka($_GET[bln2])) == 2) {
		$bln2 = blnAngka($_GET[bln2]);
	}
$awal = "$_GET[thawal]$bln1";
$akhir = "$_GET[thakhir]$bln2";

$awalan = "$_GET[thawal]-$bln1-01";
$akhiran= "$_GET[thakhir]-$bln2-31";
$sql = mysql_query("select PERIOD_DIFF($akhir,$awal) as selisih");
$data= mysql_fetch_array($sql);

echo "
	<center>LAPORAN BULANAN UNIT ADMISI REKAP PENDAPATAN PENDAFTARAN <br>
	PERIODE: $_GET[bln1] $_GET[thawal] s.d $_GET[bln2] $_GET[thakhir] </center>
	<table cellpadding='0' cellspacing='0' border='0' id='table' class='sortable' style='width:100%;'>
		<thead>
			<tr>
				<th rowspan='2'><h3>No</h3></th>
				<th rowspan='2'><h3>Item Pendapatan</h3></th>
				<th colspan='".($data[selisih]+2)."' class='nosort' style='text-align:center;'><h3>Pendapatan Per Bulan (Rp.)</h3></th></tr>";

				$date = explode("/","$bln1/01/$_GET[thawal]");
				for ($i = 0; $i <= $data[selisih]; $i ++) {
					$x  = mktime(0, 0, 0, date($date[0])+$i, date($date[1]), date($date[2]));
					$new = date("M",$x);
					echo "<th class='nosort' style='text-align:center;'><h3>$new</h3></th>";
				}
			echo "<th style='text-align:center;'><h3>Total</h3></th></tr></thead><tbody>";
	$sql = mysql_query("select * from tarif");
	$no = 1;
	while ($row = mysql_fetch_array($sql)) {
			echo "<tr bgcolor='"; if ($no % 2 == 1) echo "#FFFFFF"; else echo "#F9F9F9"; echo "'>
				<td align=center>$no</td>
				<td>$row[nama]</td>";
				$date = explode("/","$bln1/01/$_GET[thawal]");
				for ($i = 0; $i <= $data[selisih]; $i ++) {
					$x  = mktime(0, 0, 0, date($date[0])+$i, date($date[1]), date($date[2]));
					$new = date("Y-m",$x);
					$rows= mysql_fetch_array(mysql_query("select sum(t.harga) as total from kunjungan k, pelayanan p, tarif t where k.id = p.id_kunjungan and p.id_tarif = t.id and k.waktu like ('$new%') and t.id = '$row[id]'"));
					if ($rows[total] == NULL) $total = "-"; else $total = cost($rows[total]);
					echo "<td align=center>$total</td>";
				}
				$rows= mysql_fetch_array(mysql_query("select sum(t.harga) as total from kunjungan k, pelayanan p, tarif t where k.id = p.id_kunjungan and p.id_tarif = t.id and k.waktu between '$awalan' and '$akhiran' and t.id = '$row[id]'"));
				
			echo "<td>".cost($rows[total])."</td></tr>";
	$no += 1;
	}
	//$jml = mysql_fetch_array(mysql_query("select count(p.id) as jumlah, sum(t.harga) as harga from pelayanan p, tarif t where p.id_tarif = t.id"));
	echo "</tbody>
	<tr bgcolor=#FFFFF><td></td><td>TOTAL</td>";
	for ($i = 0; $i <= $data[selisih]; $i ++) {
		$x  = mktime(0, 0, 0, date($date[0])+$i, date($date[1]), date($date[2]));
		$new = date("Y-m",$x);
		$rows= mysql_fetch_array(mysql_query("select sum(t.harga) as total from kunjungan k, pelayanan p, tarif t where k.id = p.id_kunjungan and p.id_tarif = t.id and k.waktu like ('$new%')"));
		if ($rows[total] == NULL) $total = "-"; else $total = cost($rows[total]);
		echo "<td align=center>$total</td>";
	}
	$rows= mysql_fetch_array(mysql_query("select sum(t.harga) as total from kunjungan k, pelayanan p, tarif t where k.id = p.id_kunjungan and p.id_tarif = t.id and k.waktu between '$awalan' and '$akhiran'"));
	echo "<td>$rows[total]</td></tr>
	</table>
	<br><center><input type=button name=cetak value=' Cetak ' class=tombol onclick=\"window.open('./print/TR/?period=$_GET[period]&bln1=$_GET[bln1]&thawal=$_GET[thawal]&bln2=$_GET[bln2]&thakhir=$_GET[thakhir]','popup','width=1000,height=650,scrollbars=yes, resizable=no');\"></center>
	
	";

}
else if ($_GET['period'] == '4') {

$selisih = $_GET[akhir] - $_GET[awal];

$awalan = "$_GET[awal]-01-01";
$akhiran= "$_GET[akhir]-12-31";
echo "
	<center>LAPORAN TAHUNAN UNIT ADMISI REKAP PENDAPATAN PENDAFTARAN <br>
	PERIODE: $_GET[awal] s.d $_GET[akhir] </center>
	<table cellpadding='0' cellspacing='0' border='0' id='table' class='sortable' style='width:100%;'>
		<thead>
			<tr>
				<th rowspan='2'><h3>No</h3></th>
				<th rowspan='2'><h3>Item Pendapatan</h3></th>
				<th colspan='".($selisih+2)."' class='nosort' style='text-align:center;'><h3>Pendapatan Per Hari (Rp.)</h3></th></tr>";

				//$date = explode("/","$_GET[bln1]/01/$_GET[thn1]");
				for ($i = 0; $i <= $selisih; $i ++) {
					$x  = mktime(0, 0, 0, date("01"), date("01"), date($_GET[awal])+$i);
					$new = date("Y",$x);
					echo "<th class='nosort' style='text-align:center;'><h3>$new</h3></th>";
				}
			echo "<th class='nosort' style='text-align:center;'><h3>Total</h3></th></tr></thead><tbody>";
	$sql = mysql_query("select * from tarif");
	$no = 1;
	while ($row = mysql_fetch_array($sql)) {
			echo "<tr bgcolor='"; if ($no % 2 == 1) echo "#FFFFFF"; else echo "#F9F9F9"; echo "'>
				<td align=center>$no</td>
				<td>$row[nama]</td>";
				for ($i = 0; $i <= $selisih; $i ++) {
					$x  = mktime(0, 0, 0, date("01"), date("01"), date($_GET[awal])+$i);
					$new = date("Y",$x);
					$data= mysql_fetch_array(mysql_query("select sum(t.harga) as total from kunjungan k, pelayanan p, tarif t where k.id = p.id_kunjungan and p.id_tarif = t.id and k.waktu like ('$new%') and t.id = '$row[id]'"));
					if ($data[total] == NULL) $total = "-"; else $total = cost($data[total]);
					echo "<td align=center>$total</td>";
				}
				$data= mysql_fetch_array(mysql_query("select sum(t.harga) as total from kunjungan k, pelayanan p, tarif t where k.id = p.id_kunjungan and p.id_tarif = t.id and k.waktu between '$awalan' and '$akhiran' and t.id = '$row[id]'"));
			echo "<td align=center>$data[total]</td></tr>";
	$no += 1;
	}
	$jml = mysql_fetch_array(mysql_query("select count(p.id) as jumlah, sum(t.harga) as harga from pelayanan p, tarif t where p.id_tarif = t.id"));
	echo "</tbody>
	<tr bgcolor=#FFFFF><td></td><td>TOTAL</td>";
	for ($i = 0; $i <= $selisih; $i ++) {
		$x  = mktime(0, 0, 0, date("m"), date("d"), date($_GET[awal])+$i);
		$new = date("Y",$x);
		$data= mysql_fetch_array(mysql_query("select sum(t.harga) as total from kunjungan k, pelayanan p, tarif t where k.id = p.id_kunjungan and p.id_tarif = t.id and k.waktu like ('$new%')"));
		if ($data[total] == NULL) $total = "-"; else $total = cost($data[total]);
		echo "<td align=center>$total</td>";
	}
	$data= mysql_fetch_array(mysql_query("select sum(t.harga) as total from kunjungan k, pelayanan p, tarif t where k.id = p.id_kunjungan and p.id_tarif = t.id and k.waktu like ('$new%')"));
	echo "<td align=center>$data[total]</td></tr>
	</table>
	<br><center><input type=button name=cetak value=' Cetak ' class=tombol onclick=\"window.open('./print/TR/?period=$_GET[period]&awal=$_GET[awal]&akhir=$_GET[akhir]','popup','width=1000,height=650,scrollbars=yes, resizable=no');\"></center>
	</div>
	";

}
echo "
<script type='text/javascript' src='public/scripts/sorter/script.js'></script>
	<script type='text/javascript'>
  var sorter = new TINY.table.sorter('sorter');
	sorter.head = 'head';
	sorter.asc = 'asc';
	sorter.desc = 'desc';
	sorter.even = 'evenrow';
	sorter.odd = 'oddrow';
	sorter.evensel = 'evenselected';
	sorter.oddsel = 'oddselected';
	sorter.paginate = true;
	sorter.currentid = 'currentpage';
	sorter.limitid = 'pagelimit';
	sorter.init('table',0);
  </script>
</div>";
?>