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
        //$cols = report_kelurahan_muat_data($row[id], $tgl[$i], $week_start, $week_end, $mount_start, $mount_end, $_GET[awal]+$i, $_GET[akhir], $_GET[period]); 
	$cols = report_kelurahan_muat_data($row['id'], $tgl[$i], '', '', '', '', $_GET['awal']+$i, $_GET['akhir'], $_GET['period']);
	?>
        <td align="center"><?= $cols; ?></td>
        <? $total = $cols + $total; ?>
        <?php } ?>
        <td align="center"><?= $total ?></td>
    </tr>
    <?php endforeach;} 
 if($_GET['period'] == 2){
    if(!empty($village)){
        $action = "where id = '$village'";
    }else $action = "";
    $sql = mysql_query("select * from kelurahan $action");
    $no = 1;
    while ($row = mysql_fetch_array($sql)) {
			
    echo "<tr bgcolor='"; if ($no % 2 == 0) echo "#F4F4F4"; else echo "#FFFFFF"; echo "'>
    <td align=center>$no</td>
    <td>".ucwords(strtolower($row['nama']))."</td>
    ";
    $date = explode("-",$tanggal);
    $n = 0;
    $total = 0;			
    for ($i = $rows['minggu1']; $i <= $rows['minggu2']; $i ++) {
    $x  = mktime(0, 0, 0, date($date[1]), date($date[2])+(7*$n), date($date[0]));
    $thn = date("Y-m-d",$x);
    $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
				
    $jml = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, dinamis_penduduk dp, kunjungan k where pd.id = dp.id_penduduk and pd.id = p.id_penduduk and p.id = k.id_pasien and dp.id_kelurahan = '$row[id]' and k.waktu between '$thn' and '$next[0]'"));
				
    echo "<td align=center>$jml </td>";
    $total += $jml;
    $n += 1;
}
echo "<td align=center>$total</td>";
echo "</tr>";
$no += 1;
}
}   
?>
