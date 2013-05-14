<?php
require_once 'app/lib/pf/obat.php';
require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-data.php';

$obats = obat_muat_data();
$rs = profile_rumah_sakit_muat_data();
$namaFile = "obat-excel.xls";

// header file excel

header_excel($namaFile);
?>
<table border="0">
    <tr bgcolor="#cccccc">
        <td colspan="10" align="center"><strong><font size="+1"><?= $rs['nama'] ?></font></strong></td>
    </tr>
    <tr bgcolor="#cccccc">
        <td colspan="10" align="center"><strong><font size="+1">INFORMASI OBAT</font></strong></td>
    </tr>
</table>
<table class="tabel" border="1">
<tr>
    <th>No</th>
	<th>Nama</th>
	<th>Pabrik</th>
	<th>Kekuatan</th>
	<th>Sediaan</th>
	<th>Indikasi</th>
	<th>Farmakologi</th>
	<th>Golongan Perundangan</th>
	<th>Ven</th>
	<th>Generik</th>
</tr>
<?php foreach($obats['list'] as $num => $data) {?>
<tr class="<?= ($num%2) ? 'odd' : 'even' ?>">
	<td align="center"><?= ++$num + $obats['offset'] ?></td>
	<td class="no-wrap"><?= $data['nama_barang'] ?></td>
	<td class="no-wrap"><?= $data['pabrik'] ?></td>
	<td align="center"><?= $data['kekuatan'] ?></td>
	<td><?= $data['sediaan'] ?></td>
	<td><?= $data['indikasi'] ?></td>
	<td><?= $data['sub_sub_farmakologi']."-".$data['sub_farmakologi']."-".$data['farmakologi'] ?></td>
	<td><?= $data['perundangan'] ?></td>
	<td><?= $data['ven'] ?></td>
	<td><?= $data['generik'] ?></td>
</tr>
<?php } ?>
</table>
<?
exit();
?>