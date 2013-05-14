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
            
            $cols = report_cols_instalasi($row['id'], $tgl[$i], '', '', '', '', $_GET['awal']+$i, $_GET['akhir'], $_GET['period']); ?>
            <td align="center"><?= $cols; ?></td>
            <? $total = $cols + $total; ?>
        <?php } ?>
        <td align="center"><?= $total ?></td>
    </tr>
    <?php endforeach; 
}
else if($_GET['period'] == 2){   
    foreach($data as $num => $row){?>
    <tr class="<?= ($num%2) ? 'even' : 'odd' ?>"> 
<?php        
    echo "<td align=center>".++$num."</td>
    <td>$row[nama]</td>
    ";
    $date = explode("-",$tanggal);
    $n = 0;
    $total = 0;			
    for ($i = $rows['minggu1']; $i <= $rows['minggu2']; $i ++) {
    $x  = mktime(0, 0, 0, date($date[1]), date($date[2])+(7*$n), date($date[0]));
    $thn = date("Y-m-d",$x);
    $next = mysql_fetch_row(mysql_query("select (INTERVAL 6 DAY + '$thn')"));
    $cols = report_cols_instalasi_mingguan($row['id'], $thn, $next[0]);							
				
    echo "<td align=center>$cols </td>"; 
    $total += $cols;
}
echo "<td align=center>$total</td>";
echo "</tr>";
$no += 1;
}
}        
?>