<?php
require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-data.php';
require_once 'app/config/db.php';
set_time_zone();

$startDate=(isset($_GET['id']))? $_GET['id']:NULL;
 $detail = detail_pembelian_muat_data($_GET['id']);?>
<html>
  <head>
     <title>Laporan Detail Pembelian</title> 
     <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/base.css')?>">
     <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/style.css')?>">
     <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/workspace.css')?>">
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
  <center>INFORMASI DETAIL PEMBELIAN <br/> No. Surat: <?=$_GET['no']?></center>
  <div class="data-list">
            <table class="tabel">
                <tr>
                    <th >No</th>
                    <th style="width: 10%">Nama Packing Barang</th>
                    <th style="width: 10%">No Batch</th>
                    <th style="width: 10%">Jumlah Pembelian</th>
                    <th style="width: 10%">Harga@</th>
                    <th style="width: 10%">Sub Total</th>
                    <th style="width: 10%">Diskon (%)</th>
                    <th style="width: 10%">Nilai Diskon (Rp.)</th>
                </tr>
                <?php
                foreach ($detail as $num => $rows) {
                    $class = ($num % 2) ? 'even' : 'odd';
                    $style = "class='$class'";
                 $nama=nama_packing_barang(array($rows['generik'],$rows['nama'],$rows['kekuatan'],$rows['sediaan'],$rows['nilai_konversi'],$rows['satuan_terkecil'],$rows['pabrik']));
                    $subtotal=$rows['jumlah_pembelian']*$rows['harga_pembelian'];
                    ?>
                    <tr <?= $style ?>>
                        <td align="center"><?= ++$num ?></td>
                        <td class="no-wrap"><?= $nama ?></td>
                        <td align="center"><?= $rows['batch'] ?></td>
                        <td align="center"><?= ($rows['jumlah_pembelian']) ?></td>
                        <td class="no-wrap" align="right"><?= rupiah($rows['harga_pembelian']) ?></td>
                        <td align="right"><?= rupiah($subtotal) ?></td>
                        <td align="center"><?= $rows['diskon'] ?></td>
                        <td align="right"><?= rupiah(($subtotal*$rows['diskon'])/100) ?></td>
                    </tr>                
                    <?php
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
