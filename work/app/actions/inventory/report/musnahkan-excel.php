<?php
include_once "app/lib/common/functions.php";
include 'app/actions/admisi/pesan.php';
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/pf/obat.php';
$startDate = (isset($_GET['awal'])) ? $_GET['awal'] : Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$endDate = (isset($_GET['akhir'])) ? $_GET['akhir'] : Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$barang = isset($_GET['barang']) ? $_GET['barang'] : NULL;
$idBarang = isset($_GET['idBarang']) ? $_GET['idBarang'] : NULL;
$idPegawai = isset($_GET['idPegawai']) ? $_GET['idPegawai'] : NULL;
$pegawai = isset($_GET['pegawai']) ? $_GET['pegawai'] : NULL;
$saksi = isset($_GET['saksi']) ? $_GET['saksi'] : NULL;
$idSaksi = isset($_GET['idSaksi']) ? $_GET['idSaksi'] : NULL;
$pemusnahan = pemusnahan_muat_data($startDate, $endDate, $idPegawai, $idSaksi, NULL);
$cp=profile_rumah_sakit_muat_data();
 

$namaFile = "informasi-pemusnahan.xls";

header_excel($namaFile);
?>
<table border="0">
      <tr bgcolor="#cccccc">
          <td colspan="5" align="center"><strong><font size="+1"><?=$cp['nama']?></font></strong></td>
      </tr>
      <tr bgcolor="#cccccc">
          <td colspan="5" align="center"><strong><font size="+1">Informasi Pemusnahan</font></strong></td>
      </tr>
     
      <tr>
          <td colspan="5">&nbsp;</td>
      </tr>    
</table>
    <table class="tabel">
        <tr>
            <th>No</th> 
            <th>No Pemusnahan</th>
            <th>Tanggal</th>
            <th>Pegawai</th>
            <th>Saksi</th>
 
        </tr>
        <?php foreach ($pemusnahan as $key => $row) {
        ?>
            <tr class="<?= ($key % 2) ? 'odd' : 'even' ?>">
                <td align="center"><?= ++$key ?></td>
                <td><?= $row['id'] ?></td>
                <td><?= datefmysql($row['tanggal']) ?></td>
                <td class="no-wrap"><?= $row['namaPegawai'] ?></td>
                <td class="no-wrap"><?= $row['namaSaksi'] ?></td>
              
            </tr>
        <?php } ?>
    </table>
<?
exit();
?>