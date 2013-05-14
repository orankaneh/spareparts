<?php
require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-data.php';
  include_once "app/lib/common/master-inventory.php";
set_time_zone();

$startDate = (isset($_GET['awal'])) ? $_GET['awal'] : Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$endDate = (isset($_GET['akhir'])) ? $_GET['akhir'] : Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$idPegawai = isset($_GET['idPegawai']) ? $_GET['idPegawai'] : NULL;
$pegawai = isset($_GET['pegawai']) && ($idPegawai != null) ? $_GET['pegawai'] : NULL;
$idUnit = get_value('unit');
 $detail = detail_distribusi_muat_data($_GET['id']);
$namaFile = "distribusi-report.xls";
 $cp=profile_rumah_sakit_muat_data();
// header file excel

//header_excel($namaFile);
?>
  <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/base.css')?>">
     <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/style.css')?>">
     <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/workspace.css')?>">
    <?require_once 'app/actions/admisi/lembar-header.php';?> 
  <center>INFORMASI DETAIL DISTRIBUSI <BR /> NO DISTRIBUSI: <?=$_GET['id']?> <BR /> UNIT TUJUAN: <?=$_GET['unittujuan']?></center>
    <div class="data-list">
 <table class="tabel" style="width: 100%;" border="1">
        <tr>
            <th style="width: 5%">No</th>
            <th>Nama Barang</th>
            <th style="width: 10%">Jumlah Distribusi</th>
            <th style="width: 10%">No Penerimaan Unit</th>
            <th style="width: 10%">Jumlah Terima</th>
            <th style="width: 10%">Satuan</th>
            <th style="width: 10%">Selisih</th>
        </tr>
        <?
            $i=1;
          foreach ($detail as $key => $row) {
              $nama=nama_packing_barang(array($row['generik'],$row['barang'],$row['kekuatan'],$row['sediaan'],$row['nilai_konversi'],$row['satuan'],$row['pabrik']));
                ?>
                <tr class="<?= (($i-1)%2) ? 'odd':'even' ?>">
                    <td align="center"><?=$i++?></td>
                    <td class="no-wrap" style="width: 30%"><?=$nama?></td>
                    <td><?=($row['jumlah_distribusi'])?></td>
                    <td><?=$row['id_penerimaan_unit']?></td>
                    <td><?=$row['jumlah_penerimaan_unit']?></td>
                    <td><?=$row['satuan']?></td>
                    <td><?=($row['jumlah_distribusi']-$row['jumlah_penerimaan_unit'])?></td>
                </tr>
                <?
            }
        ?>
    </table>
</div>
 <center>
      <p><span id="SCETAK"><input type="button" class="button" value="Cetak" onClick="cetak()"/></span></p>
    </center>
  <script language='JavaScript'>
  	function cetak() {  		
  		SCETAK.innerHTML = '';
		window.print();
		if (confirm('Apakah menu print ini akan ditutup?')) {
			window.close();
		}
		SCETAK.innerHTML = '<br /><input onClick=\'cetak()\' type=\'submit\' name=\'Submit\' value=\'Cetak\' class=\'tombol\'>';
  	}
  
   </script>
<?exit;?>