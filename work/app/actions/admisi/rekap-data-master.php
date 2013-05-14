<?php
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/master-inventory.php';
require_once 'app/lib/common/functions.php'; 
$barang = "select * from barang";
$jumlahBarang = _num_rows($barang);
?>
<style type="text/css">
	fieldset {
		background:#f4f4f4;
		border:1px dotted #333;
		margin-top: 5px;
	}
	legend {
		font-size:8px;
		font-weight:bold;
		text-transform:uppercase;
		background:#f1f1f1;
		border-top:1px dotted #333;
		border-left:1px dotted #333;
		border-right:1px dotted #333;
		padding:3px;
		background:#ddd;
	}
	.noborder {
		border:none;
		background:none;
	}
	input[type=button] {
		font-size:11px;
	}
</style>
<h2 class="judul">Informasi Rekap Data Master Terakhir</h2>

<table width="100%"> 
<tr>
<td valign="top" width="50%">    
<fieldset>
    <legend><b>Barang: <?= $jumlahBarang?> Item</b></legend>
    <table width="100%">
        <tr>
            <td width="35%">Perbekalan Farmasi</Td>
            <td>:
                <?
                   $jumlah = rekap_barang_muat_data(1);
                   echo "$jumlah Item";
                ?>
            </td>
        </tr>
        <tr>
            <td width="35%">Perbekalan Gizi</Td>
            <td>:
                <?
                   $jumlah = rekap_barang_muat_data(3);
                   echo "$jumlah Item";
                ?>
            </td>
        </tr>
        <tr>
            <td width="35%">Perbekalan Rumah Tangga</Td>
            <td>:
                <?
                   $jumlah = rekap_barang_muat_data(2);
                   echo "$jumlah Item";
                ?>
            </td>
        </tr>
    </table>
    <fieldset>
        <table>
            <?
               $sql = "select id from sub_kategori_barang";
               $idSubKategori = _select_arr($sql);
               foreach ($idSubKategori as $rows){
               $datas = rekap_barang_muat_data(NULL,$rows['id']);    
           ?>
               <tr>
                   <td><?= $datas['nama']?></td>
                   <td>: <?= $datas['jumlah']!=0?$datas['jumlah']:"-"?></td>
               </tr>
           <? 
               }
           ?>
        </table>
  
    <table width="100%" style="border-top:1px dotted #ccc; margin-top:10px;">
        <tr>
            <td width="35%">Packing Barang</td><td>:
            <?
              $sql = "select * from packing_barang";
              $jumlah = _num_rows($sql);
              echo "$jumlah Item";
            ?>
            </td>
        </tr>
    </table>
</fieldset>
<fieldset>
    <?
      $penduduk = penduduk_muat_data();
    ?>
    <legend><b>Penduduk: <?= count($penduduk['list']);?></b></legend>
    <table width="100%">
        <tr>
            <td width="35%">Pegawai</td><td>: 
              <?
                $sql = "select * from penduduk where id in (select id from pegawai)";
                $jumlah = _num_rows($sql);
                echo "$jumlah Orang";
              ?>
            </td>
        </tr>
        <tr>
            <td width="35%">Pasien</td><td>: 
            <?
               $sql = "select * from penduduk where id in (select id_penduduk from pasien)";
               $jumlah = _num_rows($sql);
               echo "$jumlah Orang";
              ?>
            </td>
        </tr>
        <tr>
            <td width="35%">Lain-lain</td><td>:
            <?
                $sql = "select * from penduduk where id not in (select id_penduduk from pasien) and id not in (select id from pegawai)";
                $jumlah = _num_rows($sql);
                echo "$jumlah Orang";
              ?>
            </td>
        </tr>
    </table>
</fieldset>
</td>
<td valign="top" width="50%">
    <fieldset>
        <legend><b>Layanan & Tarif</b></legend>
        <table width="100%">
           <tr>
               <td width="35%">Layanan</td><td>:
                <?
                  $sql = "select * from layanan";
                  $jumlah = _num_rows($sql);
                  echo "$jumlah Item";
                ?>
               </td>
           </tr>
           <tr>
               <td width="35%">Tarif</td><td>:
               <?
                  $sql = "select * from tarif";
                  $jumlah = _num_rows($sql);
                  echo "$jumlah Item";
                ?>
               </td>
           </tr>
        </table>    
    </fieldset>
    <fieldset>
        <?
          $instansi = instansi_relasi_muat_data();
          $jumlah = count($instansi['list']);
        ?>
        <legend><b>Instansi Relasi: <?= $jumlah?></b></legend>
        <table>
            <?
               $sql = "select id from jenis_instansi_relasi";
               $idJenis = _select_arr($sql);
               foreach ($idJenis as $row){
               $data = rekap_instansi_relasi_muat_data($row['id']);    
           ?>
               <tr>
                   <td><?= $data['nama']?></td>
                   <td>: <?= $data['jumlah']!=0?$data['jumlah']:"-"?></td>
               </tr>
           <? 
               }
           ?>
        </table>
    </fieldset>
</td>
</tr></table>
