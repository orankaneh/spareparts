<?php
require_once 'app/lib/pf/obat.php';
require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-data.php';

$namaFile = "penjualan-excel.xls";


$idPegawai = isset($_GET['idPegawai']) ? $_GET['idPegawai'] : NULL;
$pegawai = isset($_GET['pegawai']) ? $_GET['pegawai'] : NULL;
$dokter=get_value('dokter');
$idDokter=get_value('idDokter');
$pembeli=get_value('pembeli');
$idPembeli=get_value('idPembeli');
$jenis = isset($_GET['jenis']) ? $_GET['jenis'] : NULL;
$startDate = (isset($_GET['startDate'])) ? get_value('startDate') : date("d/m/Y");
$endDate = (isset($_GET['endDate'])) ? get_value('endDate') : date("d/m/Y");
if(isset($_GET['startDate'])){
    $penjualan = penjualan_muat_data(date2mysql($startDate), date2mysql($endDate), $jenis, get_value('idPembeli'), $idPegawai,  $idDokter);    
}else{
    $penjualan = penjualan_muat_data(null, null, null,null,null,null);
}
$jumlahPenjualan=$penjualan['num_rows'];
$jumlahNilaiTagihan=empty($penjualan['total_tagihan'][0])?"Rp 0,-":"Rp ".rupiah($penjualan['total_tagihan'][0]).",-";
$jumlahJasaPelayanan=empty($penjualan['total_jasa_pelayanan'])?"Rp 0,-":"Rp ".rupiah($penjualan['total_jasa_pelayanan']).",-";
// header file excel

header_excel($namaFile);
?>


<table class="tabel" border=1>
<?php
    echo lembar_header_excel(7);    
?>
    <tr>
        <td colspan="7" style='border:0;text-align:center;'><h4>INFORMASI PENJUALAN</h4></td>
    </tr>
<?php
    if($startDate!=null&&$endDate!=null){
        echo "<tr><td colspan='7' style='border:0;text-align:center;'><h4>".  indo_tgl($startDate)." s.d ".  indo_tgl($endDate)."</h4></td></tr>";
    }
?>
<tr>
    <th>No Nota</th>
    <th>Tanggal</th>
    <th>Jenis</th>
    <th>Nama Pembeli</th>
    <th>Nama Pegawai</th>
    <th>Nama Dokter</th>
    <th>Total Tagihan (Rp)</th>
</tr>
<?php foreach ($penjualan['list'] as $key => $row): ?>
            <tr class="<?= ($key % 2) ? 'odd' : 'even' ?>">
                <td align="center"><?=$row['id']  ?></td>
                <td><?= datefmysql($row['tanggal']) ?></td>
                <td align="center"><?= $row['jenis'] ?></td>
                <td class="no-wrap"><?= $row['pembeli'] ?></td>
                <td class="no-wrap"><?= $row['pegawai'] ?></td>
                <td class="no-wrap"><?= $row['dokter'] ?></td>
                <td align="right"><?=rupiah($row['total_tagihan'])?></td>
            </tr>
<?php
     endforeach;
?>
    <tr>
        <td colspan="6">Total Jumlah Transaksi :</td><td align="right"><?=$jumlahPenjualan?></td>
    </tr>
    <tr>
         <td colspan="6">Total Jumlah Nilai Tagihan Transaksi :</td><td align="right"><?=$jumlahNilaiTagihan?></td>
    </tr>
    <tr>
         <td colspan="6">Total Jumlah Jasa Pelayanan Farmasi :</td><td align="right"><?=$jumlahJasaPelayanan?></td>
    </tr>
</table>
<?
exit();
?>