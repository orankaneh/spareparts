<?php
require_once 'app/lib/pf/obat.php';
require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-data.php';
$pegawais = pegawai_muat_data();

$namaFile = "pegawai-excel.xls";

// header file excel

header_excel($namaFile);
?>


<table class="tabel" border=1>
<?php
    echo lembar_header_excel(7);
?>
<tr>
    <th>ID</th>
    <th>NIP</th>
    <th>Nama Pegawai</th>
    <th>Asal Kelurahan</th>
    <th>Asal Kecamatan</th>
    <th>Level</th>
    <th>Unit</th>
</tr>
<?php foreach($pegawais['list'] as $num => $data) {?>
<tr class="<?= ($num%2) ? 'odd' : 'even' ?>">
	<td align="center"><?= $data['id'] ?></td>
	<td class="no-wrap"><?= $data['nip'] ?></td>
	<td class="no-wrap"><?= $data['nama'] ?></td>
	<td align="center"><?= $data['kelurahan'] ?></td>
	<td align="center"><?= $data['kecamatan'] ?></td>
	<td align="center"><?= $data['nama_level'] ?></td>
        <td align="center"><?= $data['nama_unit'] ?></td>
</tr>
<?php } ?>
</table>
<?
exit();
?>
