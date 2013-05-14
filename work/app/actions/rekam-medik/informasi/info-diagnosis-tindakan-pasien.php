<?php
if(isset($_GET['opsi'])){
include_once "app/lib/common/master-data.php";
$data = info_diagnosa_tindakan_pasien($_GET['norm']);
?>
<div class='data-list'>
<fieldset>
<legend>Rawat Darurat</legend>
<table>
<?php
$i=1;
if(count($data['rawat_darurat'])>0){
	echo "<tr >
			<td><table>
	<tr><th>No</th><th><b>Diagnosa : </b></th></tr>";
	$i=1;
	foreach($data['rawat_darurat']['diagnosa'] as $diagnosa){
		$class = ($i%2)?"even":"odd";
		echo "<tr class='$class'><td>$i</td><td>".$diagnosa."</td></tr>";
		$i++;
	}
	echo "</table></td><td><table><tr><td></td></tr></table></td>";
	echo "<td><table>
	<tr><th>No</th><th><b>Tindakan : </b></th></tr>";
	$i=1;
	foreach($data['rawat_darurat']['tindakan'] as $tindakan){
		$class = ($i%2)?"even":"odd";
		echo "<tr class='$class'><td>$i</td><td>".$tindakan."</td></tr>";
		$i++;
	}
	echo "</table></td></tr>";
}

?>
</table>
</fieldset>
<fieldset>
<legend>Rawat Jalan</legend>
<table class="data-list">
<?php
$i=1;
if(count($data['rawat_jalan'])>0){
	echo "<tr >
			<td><table>
	<tr><th>No</th><th><b>Diagnosa : </b></th></tr>";
	$i=1;
	foreach($data['rawat_jalan']['diagnosa'] as $diagnosa){
		$class = ($i%2)?"even":"odd";
		echo "<tr class='$class'><td>$i</td><td>".$diagnosa."</td></tr>";
		$i++;
	}
	echo "</table></td><td><table><tr><td></td></tr></table></td>";
	echo "<td><table>
	<tr><th>No</th><th><b>Tindakan : </b></th></tr>";
	$i=1;
	foreach($data['rawat_jalan']['tindakan'] as $tindakan){
		$class = ($i%2)?"even":"odd";
		echo "<tr class='$class'><td>$i</td><td>".$tindakan."</td></tr>";
		$i++;
	}
	echo "</table></td></tr>";
}

?>
</table>
</fieldset>
<fieldset>
<legend>Rawat Inap</legend>
<table class="data-list">
<?php
$i=1;
if(count($data['rawat_inap'])>0){
	echo "<tr >
			<td><table>
	<tr><th>No</th><th><b>Diagnosa Utama : </b></th></tr>";
	$i=1;
	foreach($data['rawat_inap']['diagnosa_utama'] as $nama){
		$class = ($i%2)?"even":"odd";
		echo "<tr class='$class'><td>$i</td><td>".$nama."</td></tr>";
		$i++;
	}
	echo "</table></td><td><table><tr><td></td></tr></table></td>";
	echo "<td><table>
	<tr><th>No</th><th><b>Diagnosa Sekunder : </b></th></tr>";
	$i=1;
	foreach($data['rawat_inap']['diagnosa_inap'] as $nama){
		$class = ($i%2)?"even":"odd";
		echo "<tr class='$class'><td>$i</td><td>".$nama."</td></tr>";
		$i++;
	}
	echo "</table></td>";
		echo "<td><table>
	<tr><th>No</th><th><b>Diagnosa Nosokomial : </b></th></tr>";
	$i=1;
	foreach($data['rawat_inap']['diagnosa_nosokomial'] as $nama){
		$class = ($i%2)?"even":"odd";
		echo "<tr class='$class'><td>$i</td><td>".$nama."</td></tr>";
		$i++;
	}
	echo "</table></td>";
		echo "<td><table>
	<tr><th>No</th><th><b>Tindakan : </b></th></tr>";
	$i=1;
	foreach($data['rawat_inap']['tindakan'] as $nama){
		$class = ($i%2)?"even":"odd";
		echo "<tr class='$class'><td>$i</td><td>".$nama."</td></tr>";
		$i++;
	}
	echo "</table></td>";
}
?>
</table>
</fieldset>
</div>
<?php
}
exit();
?>