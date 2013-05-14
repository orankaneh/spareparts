<?php
require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-data.php';
require_once 'app/config/db.php';
set_time_zone();

$formularium = formularium_muat_data($_GET['id']);
$tanggal=_select_unique_result("select tanggal from formularium where id='$_GET[id]'");
?>
<html>
  <head>
     <title>Laporan Pembelian</title> 
     <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/base.css')?>">
     <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/style.css')?>">
     <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/tabel.css')?>">
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
  </head>  
  <body>
    <?require_once 'app/actions/admisi/lembar-header.php';?> 
  <center>INFORMASI FORMULARIUM <BR /> TANGGAL <?= indo_tgl($tanggal['tanggal'],"-")?></center>
  <div class="data-list">
      <table class="tabel" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <th>No</th>
                    <?$_GET['sort']=1?>
                    <th><a href="<?= app_base_url('inventory/formularium/?').  generate_get_parameter($_GET) ?>" class="sorting">Obat</a></th>
                    <th>Farmakologi</th>
                </tr>
            <?
            $no = 1;
            foreach ($formularium['list'] as $rows) {
                $konversi = isset($rows['nilai_konversi']) ? $rows['nilai_konversi'] : "";
                $satuan = isset($rows['satuan']) ? $rows['satuan'] : "";
            ?>
                <tr class="<?= ($no % 2) ? "even" : "odd" ?>">
                    <td align="center"><?= $no ?></td>
                    <td class="no-wrap"><?= "$rows[barang] $rows[kekuatan] $rows[sediaan] " ?></td>
                    <td class="no-wrap"><?= $rows['sub_sub_farmakologi'] . "-" . $rows['sub_farmakologi'] . "-" . $rows['farmakologi'] ?></td>
                </tr>
            <?
                $no++;
            }
            ?>
        </table>
  </div>
  <center>
      <p><span id="SCETAK"><input type="button" class="button" value="Cetak" onClick="cetak()"/></span></p>
    </center>
  </body>
</html>  
<?php
exit();
?>
