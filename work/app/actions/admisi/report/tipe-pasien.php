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

            //$cols = report_tipepasien_muat_data($row[tipe], $tgl[$i], $week_start, $week_end, $mount_start, $mount_end, $_GET[awal]+$i, $_GET[akhir], $_GET[period]); 
	    $cols = report_tipepasien_muat_data($row['tipe'], $tgl[$i], '', '','', '', $_GET['awal']+$i, $_GET['akhir'], $_GET['period']); 
	    ?>
            <td align="center"><?= $cols; ?></td>
            <? $total = $cols + $total; ?>
        <?php } ?>
        <td align="center"><?= $total ?></td>
    </tr>
    <?php endforeach;
}
else if($_GET['period'] == 2){
    if ($patientType == 1){ 
        $action = "having count(k.id_pasien) = 1";
        $status = "Pasien Baru";
        }
    if ($patientType == 2){ 
        $status = "Pasien Lama";
        $action = "having count(k.id_pasien) > 1";}
    echo "<tr>
    <td align=center>1</td>
    <td>$status</td>
    ";
    $date = explode("-",$tanggal);
    $n = 0;
    $total = 0;
    for ($i = $rows['minggu1']; $i <= $rows['minggu2']; $i ++) {
    $x  = mktime(0, 0, 0, date($date[1]), date($date[2])+(7*$n), date($date[0]));
    $thn = date("Y-m-d",$x);
    $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
    $jml = mysql_num_rows(mysql_query("select k.id_pasien, p.nama, count(k.id_pasien) as jml_kunjungan from kunjungan k,pasien ps ,penduduk p
    where k.id_pasien=ps.id and ps.id_penduduk=p.id and k.waktu between '$thn' and '$next[0]' group by k.id_pasien $action"));
    echo "<td align=center>$jml</td>";
    $total += $jml;
    $n += 1;
    }
echo "<td align=center>$total</td>";    
echo "</tr>";
}    
?>
