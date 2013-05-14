<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

    foreach($data as $num => $row): ?>
    <tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
        <td align="center"><?= ++$num ?></td>
        <td class="no-wrap"><?= $row['nama'] ?></td>
        <?php
        if ($patientType == 2) $tipe = "Pasien Lama"; else $tipe = "Pasien Baru";
        if ($destination and $patientType) { ?>
            <td width='150' class="no-wrap"><?= $tipe ?></td>
        <?php }
            $total = 0;
        for ($i = 0; $i <= $difference; $i++) {
        
             $cols = report_tujuan_pasien_muat_data($row[id], $patientType, $tgl[$i], $week_start, $week_end, $mount_start, $mount_end, $_GET[awal]+$i, $_GET[akhir], $_GET[period]); ?>
            <td align="center"><?= $cols; ?></td>
            <? $total = $cols + $total; ?>
        <?php } ?>
        <td align="center"><?= $total ?></td>
    </tr>
    <?php endforeach; ?>