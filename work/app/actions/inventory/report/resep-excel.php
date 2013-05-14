<?php
require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-data.php';
require_once 'app/config/db.php';
set_time_zone();

$awal=(isset($_GET['awal']))? $_GET['awal']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
$akhir=(isset($_GET['akhir']))? $_GET['akhir']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
$idPasien=isset ($_GET['idPasien'])?$_GET['idPasien']:NULL;
$idDokter=isset ($_GET['idDokter'])?$_GET['idDokter']:NULL;
$resep=resep_muat_data($awal,$akhir,$idDokter,$idPasien);
$namaFile = "penjualan-resep-excel.xls";

// header file excel

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0,
        pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");

// header untuk nama file
header("Content-Disposition: attachment;
        filename=".$namaFile."");

header("Content-Transfer-Encoding: binary ");

?>
  <table border="0">
      <tr bgcolor="#cccccc">
          <td colspan="5" align="center"><strong><font size="+1">RS. PKU MUHAMMADYAH TEMANGGUNG</font></strong></td>
      </tr>
      <tr bgcolor="#cccccc">
          <td colspan="5" align="center"><strong><font size="+1">INFORMASI TRANSAKSI PENJUALAN RESEP</font></strong></td>
      </tr>
      <tr bgcolor="#cccccc">
          <td colspan="5" align="center"><strong><font size="+1">PERIODE:: <?= indo_tgl($awal)?> s . d <?= indo_tgl($akhir)?></font></strong></td>
      </tr>
  
  </table>
  <table border="1">
<tr>
          <td>No</td> 
           <td>No. Resep</td>
           <td>Tanggal</td>
           <td>Dokter</td>
           <td>Pasien</td>
      </tr>    
     <?php
            $jumlahResep = 0;
            $jumlahR = 0;
            foreach ($resep as $key => $row) {
           ?>
            <tr class="<?= ($key%2) ? 'even':'odd' ?>">
            <td align="center"><?= ++$key ?></td>
            <td><?= $row['no_resep']?></td>
            <td><?= datefmysql($row['tanggal'])?></td>
            <td class="no-wrap"><?= $row['nama_dokter']?></td>
            <td class="no-wrap"><?= $row['nama_pasien']?></td>
            </tr>    
    <?php 
        $jumlahResep += count($row['no_resep']);
        $detail = detail_resep_muat_data($row['no_resep']);
        foreach ($detail as $rows){
            $jumlahR += count($rows['no_resep']);
        }
        } ?>
<tr class="even">
          <td colspan="4">Jumlah Resep</td>
          <td><?= $jumlahResep?></td>
        </tr>
        <tr class="odd">
          <td colspan="4">Jumlah /R</td>
          <td><?= $jumlahR?></td>
        </tr>
      </table>
<?
exit();
?>
