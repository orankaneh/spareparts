<?php
include_once "app/lib/common/functions.php";
include 'app/actions/admisi/pesan.php';
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/pf/obat.php';
set_time_zone();
$unite = $_SESSION['id_unit'];
$startDate = (isset($_GET['awal'])) ? $_GET['awal'] : Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$endDate = (isset($_GET['akhir'])) ? $_GET['akhir'] : Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$barang = isset($_GET['barang']) ? $_GET['barang'] : NULL;
$subKategori = isset($_GET['subKategori']) ? $_GET['subKategori'] : NULL;
$idSubKategori = isset($_GET['idSubKategori']) ? $_GET['idSubKategori'] : NULL;
$packing = isset($_GET['idPacking']) ? $_GET['idPacking'] : NULL;
$jenisTransaksi = isset($_GET['transaksi']) ? $_GET['transaksi'] : NULL;
$transaksi = jenis_transaksi_muat_data();
$stok = stok_barang_muat_data2($startDate, $endDate, $_SESSION['id_unit'], $packing, $jenisTransaksi, $idSubKategori);
$cp=profile_rumah_sakit_muat_data();
 

$namaFile = "riwayat-stok-barang-gudang.xls";

header_excel($namaFile);
?>
<table border="0">
      <tr bgcolor="#cccccc">
          <td colspan="13" align="center"><strong><font size="+1"><?=$cp['nama']?></font></strong></td>
      </tr>
      <tr bgcolor="#cccccc">
          <td colspan="13" align="center"><strong><font size="+1">RIWAYAT STOK BARANG GUDANG</font></strong></td>
      </tr>
     
      <tr>
          <td colspan="13">&nbsp;</td>
      </tr>    
</table>
     <table class="tabel full" border="1">
         <tr>
         
                <th rowspan='2' style="vertical-align: middle">Waktu</th>
                <th rowspan='2' style="width: 50%;vertical-align: middle">Nama Packing Barang</th>
                <th rowspan='2' style="vertical-align: middle">No. Batch</th>
                <th rowspan='2' style="vertical-align: middle">E.D</th>
                <th rowspan='1' colspan="4"> Jumlah</th>
                <th rowspan='2' style="vertical-align: middle">Kemasan</th>
                     <th rowspan='2'>Harga</th>
                 <th rowspan='2'>Nilai</th>
            <th rowspan='2' style="vertical-align: middle">No. Pembelian</th>
                <th rowspan='2' style="vertical-align: middle">Jenis Transaksi</th>
            </tr>
                <tr>
                <th rowspan='1'> Awal</th>
                <th rowspan='1'>Masuk</th>
                <th rowspan='1'>Keluar</th>
                <th rowspan='1'>Sisa</th>
             
             
            </tr>
<?php 
$no = 1;
foreach($stok as $key => $rows): ?>
        <?php
		 if ($rows['generik'] == 'Generik') {
                            $nama = ($rows['kekuatan']!=0)?"$rows[barang] $rows[kekuatan], $rows[sediaan]":"$rows[barang] $rows[sediaan]";
                        }
						 else if ($rows['generik'] == 'Non Generik') {
                            $nama = ($rows['kekuatan']!=0)?"$rows[barang] $rows[kekuatan]":"$rows[barang] ";
                        }
                        else {
                $nama = "$rows[barang]";
              }
              $nama .=" @$rows[nilai_konversi] $rows[satuan]";
              $nama.=($rows['generik'] == 'Generik')?' '. $rows['pabrik']:'';
			  
            $selisihHari=selisih_hari(date("Y-m-d"),$rows['ed']);
            if ($selisihHari <= 0) {
                $style = 'style="background-color: #DE5252; color: white;"';
            } else if ($selisihHari > 0 && $selisihHari <= 180) {
                $style = 'style="background-color: #FAF0AC; color: black;"';
            } else{
                    $style = ($rows['sisa'] < hitung_rop($rows['id_packing_barang'])) ? 'style="background-color: blue ;color: white;"' : (($no%2) ? 'class="odd"' : 'class="even"');
            }
        ?>
        <tr <?=$style?>>

            <td><?= datefmysql($rows['tanggal']) ?></td>
            <td><?=$nama?></td>
            <td class="no-wrap" align="center"><?= ($rows['batch']=='')?'-':$rows['batch'] ?></td>
            <td class="no-wrap" align="center"><?= ($rows['batch']=='')?'-':datefmysql($rows['ed']) ?></td>
            <td><?= $rows['awal']?></td>
            <td><?= $rows['masuk']?></td>
            <td><?= $rows['keluar']?></td>
            <td><?= $rows['sisa']?></td>
            <td><?= $rows['kemasan'] ?></td>
              <td><?= rupiah($rows['hna']) ?></td>
                     <td><?= rupiah($rows['hargax']) ?></td>
            <td><?= $rows['id_transaksi'] ?></td>
            <td class="no-wrap"><?= $rows['jenis_transaksi'] ?></td>
        </tr>
       <?php
        $no++;
        endforeach; 
	
       ?>
    </table>
<?
exit();
?>