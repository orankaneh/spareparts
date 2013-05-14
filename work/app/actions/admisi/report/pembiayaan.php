<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if($_GET['period'] == 1){
foreach($data as $num => $row): ?>
<tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
    <td align="center"><?= ++$num ?></td>
    <td class="no-wrap"><?= $row['nama'] ?></td>
    <?php
        $total = 0;
    for ($i = 0; $i <= $difference; $i++) {

        //$cols = report_pembiayaan_muat_data($row[value], $tgl[$i], $week_start, $week_end, $mount_start, $mount_end, $_GET[awal]+$i, $_GET[akhir], $_GET[period]); 
	$cols = report_pembiayaan_muat_data($row['value'], $tgl[$i], '', '', '', '', $_GET['awal']+$i, $_GET['akhir'], $_GET['period']);
	?>

        <td align="center"><?= $cols; ?></td>
        <? $total = $cols + $total; ?>
    <?php } ?>
    <td align="center"><?= $total ?></td>
</tr>
<?php endforeach;
}
if($_GET['period'] == 2){
    $awal = isset($_GET['awal'])?$_GET['awal']:NULL;
    $akhir = isset($_GET['akhir'])?$_GET['akhir']:NULL;
    
    if(!empty($payment)){
        if($payment == '2'){
            $sql = mysql_query("select * from jenis_asuransi");
            $no = 1;
	    while ($row = mysql_fetch_array($sql)) {
	    echo "<tr bgcolor='"; if ($no % 2 == 0) echo "#F4F4F4"; else echo "#FFFFFF"; echo "'>
	    <td align=center>$no</td>
	    <td>$row[jenis_asuransi]</td>";
	    $date = explode("-",$tanggal);
	    $n = 0;
            $total = 0;
	    for ($i = $rows['minggu1']; $i <= $rows['minggu2']; $i ++) {
	      $x  = mktime(0, 0, 0, date($date[1]), date($date[2])+(7*$n), date($date[0]));
	      $thn = date("Y-m-d",$x);
	      $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
              $jml = mysql_num_rows(mysql_query("select * from kunjungan k, asuransi a, jenis_asuransi j where k.id = a.id_kunjungan and a.id_jenis_asuransi = j.id_jenis_asuransi and k.waktu between '$thn' and '$next[0]' and j.id_jenis_asuransi = '$row[id_jenis_asuransi]'"));
	      echo "<td align=center>$jml</td>";
              $total += $jml;
	      $n += 1;
	    }
        echo "<td align=center>$total</td>";    
	echo "</tr>";	
	$no += 1;}
        }
        if($payment == '3'){
            $sql = mysql_query("select * from jenis_charity");
		
	    $no = 1;
	    while ($row = mysql_fetch_array($sql)) {
	    $jml = mysql_num_rows(mysql_query("select * from kunjungan k, charity c, jenis_charity j where k.id = c.id_kunjungan and c.id_jenis_charity = j.id_jenis_charity and k.waktu between '".date2mysql($awal)."' and '".date2mysql($akhir)."' and j.id_jenis_charity = '$row[id_jenis_charity]'"));
		
	    echo "<tr bgcolor='"; if ($no % 2 == 0) echo "#F4F4F4"; else echo "#FFFFFF"; echo "'>
	    <td align=center>$no</td>
	    <td>$row[jenis_charity]</td>";
	    $date = explode("-",$tanggal);
	    $n = 0;
            $total = 0;
	    for ($i = $rows['minggu1']; $i <= $rows['minggu2']; $i ++) {
	      $x  = mktime(0, 0, 0, date($date[1]), date($date[2])+(7*$n), date($date[0]));
	      $thn = date("Y-m-d",$x);
	      $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
	      $jml = mysql_num_rows(mysql_query("select * from kunjungan k, charity c, jenis_charity j where k.id = c.id_kunjungan and c.id_jenis_charity = j.id_jenis_charity and k.waktu between '$thn' and '$next[0]' and j.id_jenis_charity = '$row[id_jenis_charity]'"));
	      echo "<td align=center>$jml</td>";
              $total += $jml;
	      $n += 1;
	   }
           echo "<td align=center>$total</td>";
	   echo "</tr>";	
	   $no += 1;
	}
        }
      if($payment == '1'){
          $sql = mysql_query("select id_kunjungan from asuransi");
	  while ($data = mysql_fetch_array($sql)) {
	    $asuransi[] = $data['id_kunjungan'];
	  }
	  $id_asuransi = implode(",",$asuransi);
		
	  $sql2= mysql_query("select id_kunjungan from charity");
	  while ($data2 = mysql_fetch_array($sql2)) {
	    $charity[] = $data2['id_kunjungan'];
	  }
	  $id_charity = implode(",",$charity);
				
	  $no = 1;
	  echo "<tr bgcolor='"; if ($no % 2 == 0) echo "#F4F4F4"; else echo "#FFFFFF"; echo "'>
	  <td align=center>$no</td>
	  <td>Biaya Sendiri</td>";
	   $date = explode("-",$tanggal);
	   $n = 0;
           $total = 0;
	   for ($i = $rows['minggu1']; $i <= $rows['minggu2']; $i ++) {
	     $x  = mktime(0, 0, 0, date($date[1]), date($date[2])+(7*$n), date($date[0]));
	     $thn = date("Y-m-d",$x);
	     $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
	     $jml = mysql_num_rows(mysql_query("select * from kunjungan where waktu between '$thn' and '$next[0]' and id not in($id_asuransi,$id_charity)"));
	     echo "<td align=center>$jml</td>";
             $total += $jml;
	     $n += 1;
	   }
           echo "<td align=center>$total</td>";
	   echo "</tr>";
      }  
    }
}
 ?>
