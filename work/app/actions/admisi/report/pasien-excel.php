<?php
    require_once 'app/lib/common/master-data.php';
    require_once 'app/lib/common/functions.php';

    $category = isset ($_GET['category'])?$_GET['category']:NULL;
    $sort = isset ($_GET['sort'])?$_GET['sort']:NULL;
    $sortBy = isset ($_GET['sortBy'])?$_GET['sortBy']:NULL;
    //$page = isset ($_GET['page'])?$_GET['page']:NULL;
    $key = isset ($_GET['key'])?$_GET['key']:NULL;
    $rs = profile_rumah_sakit_muat_data();
    $pasien=  informasi_pasien_muat_data(null, $key, $category, $sort, $sortBy, null, null);
    $namaFile = "pasien-excel.xls";

    // header file excel

    header_excel($namaFile);
?>
<table border="0">
    <tr bgcolor="#cccccc">
        <td colspan="10" align="center"><strong><font size="+1"><?php echo $rs['nama'];?></font></strong></td>
    </tr>
    <tr bgcolor="#cccccc">
        <td colspan="10" align="center"><strong><font size="+1">INFORMASI PASIEN</font></strong></td>
    </tr>    
</table>
<table class="tabel" border=1>
    <tr>
        <th style="width:5%;">No.RM</th>
        <th style="width:15%;">Nama Lengkap</th>
        <th style="width:2%;">Kelamin</th>
        <th style="width:5%;">Usia (Th)</th>
        <th style="width:3%;">Gol.Darah</th>
        <th style="width:15%;">Alamat Jalan</th>
        <th style="width:7%;">Kelurahan</th>
        <th style="width:8%;">Kecamatan</th>
        <th style="width:8%;">No. Telp</th>
        <th style="width:7%;">No. Kunjungan</th>
    </tr>
     <? foreach($pasien['list'] as $num => $row): ?>
        <tr class="<?= ($num%2) ? 'even':'odd' ?>">
            <td align="center"><?= "&nbsp;".noRm($row['id_pas']) ?></td>
                <td><?= $row['nama'] ?></td>
                <td align="center"><?= $row['jenis_kelamin'] ?></td>
                <td align="center"><?= createUmur($row['tanggal_lahir']) ?></td>
                <td align=center><?= $row['gol_darah'] ?></td>
                <td><?= $row['alamat_jalan'] ?></td>
                <td><?= $row['nama_kelurahan'] ?></td>
                <td><?= $row['nama_kecamatan'] ?></td>
                <td><?= "&nbsp;".$row['no_telp'] ?></td>
                <td align="center"><?= ($row['no_kunjungan'] ==null)?'0':$row['no_kunjungan'] ?></td>                
        </tr>
    <? endforeach; ?>
</table>

<?
exit();
?>
