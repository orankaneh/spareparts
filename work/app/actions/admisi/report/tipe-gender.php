<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if($_GET['period'] == 1){
    foreach($data as $num => $row): ?>
    <tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
        <td align="center"><?= ++$num ?></td>
        <td><?= $row['nama'] ?></td>
        <?php
            $total = 0;
        for ($i = 0; $i <= $difference; $i++) { ?>
            <?php 

            //$cols = report_gender_muat_data($row['value'], $tgl[$i], , $week_end, $mount_start, $mount_end, $_GET['awal']+$i, $_GET['akhir'], $_GET['period']); 
	    $cols = report_gender_muat_data($row['value'], $tgl[$i], '', '', '', '',$_GET['awal']+$i, $_GET['akhir'], $_GET['period']); ?>
            <td align="center"><?= $cols ?></td>
            <? $total = $cols + $total; ?>
        <?php } ?>
        <td align="center"><?= $total ?></td>
    </tr>
    <?php endforeach;
    echo "
    </table>
</div>";
}
else if($_GET['period'] == 2){
    $awal = date2mysql($_GET['awal']);
    $akhir = date2mysql($_GET['akhir']);
    if($sex == 'L'){
        $jmlL = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, kunjungan k where pd.id=p.id_penduduk and p.id=k.id_pasien and pd.jenis_kelamin = 'L' and k.waktu between '$awal' and '$akhir'"));
        echo "
	<tr>
	<td align=center> 1</td>
	<td>Laki-laki</td>";
	$date = explode("-",$tanggal);
	$no = 0;
        $total = 0;
	for ($i = $rows['minggu1']; $i <= $rows['minggu2']; $i ++) {
	$x  = mktime(0, 0, 0, date($date[1]), date($date[2])+(7*$no), date($date[0]));
	$thn = date("Y-m-d",$x);
	$next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
							
	$jmlL = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, kunjungan k where 
	pd.id=p.id_penduduk and p.id=k.id_pasien and pd.jenis_kelamin = 'L' and k.waktu between '$thn' and '$next[0]'"));
	echo "<td align=center>$jmlL </td>";
        $total += $jmlL;
	$no += 1;
//        echo "</tr>";
	}
    }
    else if($sex == 'P'){
        $jmlP = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, kunjungan k where pd.id=p.id_penduduk and p.id=k.id_pasien and pd.jenis_kelamin = 'P' and k.waktu between '$awal' and '$akhir'"));			
        echo "
	  <tr>
	  <td align=center> 1</td>
	  <td>Perempuan</td>";
	  $date = explode("-",$tanggal);
	  $no = 0;
          $total = 0;
	  for ($i = $rows['minggu1']; $i <= $rows['minggu2']; $i ++) {
	  $x  = mktime(0, 0, 0, date($date[1]), date($date[2])+(7*$no), date($date[0]));
	  $thn = date("Y-m-d",$x);
	  $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
	  						
	  $jmlP = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, kunjungan k where 
	  pd.id=p.id_penduduk and p.id=k.id_pasien and pd.jenis_kelamin = 'P' and k.waktu between '$thn' and '$next[0]'"));
	  echo "<td align=center>$jmlP </td>";
          $total += $jmlP;
	  $no += 1;
	  }
//echo "</tr>";
    } 
    echo "<td align=center>$total</td>";
    echo "</tr>";
}   
?>
