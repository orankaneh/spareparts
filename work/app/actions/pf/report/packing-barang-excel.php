<?php
require_once 'app/lib/pf/obat.php';
require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-data.php';

$packingBarang = packing_barang_muat_data();

$namaFile = "packing-barang-excel.xls";

// header file excel

header_excel($namaFile);
?>

<table border="0">
    <tr bgcolor="#cccccc">
        <td colspan="7" align="center"><strong><font size="+1">RS. MUHAMMADYAH SRUWENG</font></strong></td>
    </tr>
    <tr bgcolor="#cccccc">
        <td colspan="7" align="center"><strong><font size="+1">INFORMASI BARANG</font></strong></td>
    </tr>
</table>
<table class="tabel">
<tr>
    <th>No</th>
    <th>Barcode</th>
    <th>Barang</th>
    <th>Kemasan</th>
    <th>Konversi</th>
    <th>Satuan</th>
    <th>Kategori</th>
</tr>
<?php foreach($packingBarang['list'] as $num => $data) {
$kekuatan = isset ($data['kekuatan'])?$data['kekuatan']:"";
$sediaan = isset ($data['sediaan'])?$data['sediaan']:"";
$pabrik = isset ($data['instansi_relasi'])?$data['instansi_relasi']:"";    
?>
<tr class="<?= ($num%2) ? 'odd' : 'even' ?>">
	<td align="center"><?= ++$num + $packingBarang['offset'] ?></td>
	<td>
                               <?
                                 if($data['barcode'] == ""){
                                     echo "$data[id_packing]";
                                 }else echo "$data[barcode]";  
                               ?>
                            </td>
                            <?
                                if ($kekuatan!=0){
                                        $namaBarang=($data['generik']=="Non Generik")?$data['nama_barang']." $kekuatan $sediaan":$data['nama_barang']." $kekuatan $sediaan $pabrik";
                                }else{
                                        $namaBarang=($data['generik']=="Non Generik")?$data['nama_barang']." $kekuatan $sediaan":$data['nama_barang']." $pabrik";
                                }
                            ?>
                            <td class="no-wrap"><?=$namaBarang?></td>
                            <td><?= $data['kemasan'] ?></td>
                            <td><?= $data['nilai_konversi'] ?></td>
                            <td><?= $data['satuan'] ?></td>
                            <td><?= $data['nama_kategori'] ?></td>
</tr>                            
<?php } ?>
</table>
<?
exit();
?>
