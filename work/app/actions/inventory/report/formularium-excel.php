<?php
require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-data.php';
require_once 'app/config/db.php';
set_time_zone();

$formularium = formularium_muat_data($_GET['id']);
$tanggal=_select_unique_result("select tanggal from formularium where id='$_GET[id]'");
$namaFile = "formularium-excel.xls";

header_excel($namaFile);
?>
  <table border="0">
      <tr bgcolor="#cccccc">
          <td colspan="9" align="center"><strong><font size="+1">RS. PKU MUHAMMADYAH TEMANGGUNG</font></strong></td>
      </tr>
      <tr bgcolor="#cccccc">
          <td colspan="9" align="center"><strong><font size="+1">INFORMASI FORMULARIUM</font></strong></td>
      </tr>
      <tr bgcolor="#cccccc">
          <td colspan="9" align="center"><strong><font size="+1">TANGGAL: <?= indo_tgl($tanggal['tanggal'],"-")?></font></strong></td>
      </tr>
      <tr>
          <td colspan="9">&nbsp;</td>
      </tr>    
  </table>
  <table border="1">
        <tr>
            <td>No</td>
            <td>Obat</td>
            <td>Farmakologi</td>
        </tr>
      <?$no=1;
            foreach ($formularium['list'] as $rows) {
                $konversi = isset($rows['nilai_konversi']) ? $rows['nilai_konversi'] : "";
                $satuan = isset($rows['satuan']) ? $rows['satuan'] : "";
            ?>
                <tr>
                    <td align="center"><?=$no++ ?></td>
                    <td class="no-wrap"><?= "$rows[barang] $rows[kekuatan] $rows[sediaan] " ?></td>
                    <td class="no-wrap"><?= $rows['sub_sub_farmakologi'] . "-" . $rows['sub_farmakologi'] . "-" . $rows['farmakologi'] ?></td>
                </tr>
            <?
                $no++;
            }
      ?>
  </table>
<?
exit();
?>
