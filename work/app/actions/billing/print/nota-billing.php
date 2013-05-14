<style>
body {margin: 0 30px; padding: 0; font:12px "arial","Consolas","Fixedsys",arial !important;}
td { font-size: 12px !important}
.tabel-judul {border-top: 1px dashed #000; border-bottom: 1px dashed #000; width: 800px; margin: 20px 0}
.head-cetak-instansi {font-size: 22px; font-family: "Arial Narrow",tahoma; font-weight: 800}
.tabel-label td {border-bottom: 1px dashed #000; padding: 5px 0 10px 0}
</style>


<?php
  set_time_zone();
  include 'app/actions/admisi/pesan.php';
  require_once 'app/lib/common/master-data.php';
  $billing=  billing_detail_muat_data($_GET['id']);
  $asuransi=  asuransi_kunjungan_muat_data($_GET['id']);
//  show_array($billing);
  $b=$billing['master'];
 //show_array($b);
  $detail=$billing['list'];
  $nomer=1;
?>
<html>
    <head>
        <title>Nota Pembayaran Billing</title>
         <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/base.css')?>" />
         <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/style.css')?>" />
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
<table width=800>
            <tr>
              <td align="center"><p align="center"><?require_once 'app/actions/admisi/lembar-header.php';?>  </p></td>
            </tr>
</table>
        
        <table class="tabel-judul">
            <tr>
              <td align="center"><p align="center"><strong>KITIR BILLING</strong></p></td>
            </tr>
        </table>
        <table width=800 border=0>
          <tr>
               <td width="108">No. Tagihan</td>
               <td width="254">: <?=$b['id']?></td>
               <td width="23">&nbsp;</td>
               <td width="141">No. RM</td>
               <td width>: <?=$b['norm']?></td>
          </tr>
            <tr>
             <td>Tanggal</td>
             <td>: <?= date("d/m/Y");?></td>
           
               <td width="23">&nbsp;</td>
               <td width="141">Nama Pasien/Pembeli</td>
               <td width>: <?=$b['penduduk']?></td>
            </tr>
            <tr>
                  <td width="108">&nbsp;</td>
               <td width="254">&nbsp;</td><td>&nbsp;</td><td>Alamat</td><td>: <?= $b['alamat']." <br/>&nbsp;  Kel.  ".$b['kelurahan']." Kab. ".$b['kabupaten']?></td>
            </tr>
            <tr>
                  <td width="108">&nbsp;</td>
               <td width="254">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp; <?= $b['kecamatan']." - ".$b['provinsi']?></td>
            </tr>
 <tr>
                  <td width="108">&nbsp;</td>
               <td width="254">&nbsp;</td><td>&nbsp;</td><td>Rencana Cara Bayar</td><td>: <?= $_GET['cara']?></td>
          </tr>
<tr>
                  <td width="108">&nbsp;</td>
               <td width="254">&nbsp;</td><td>&nbsp;</td>
               <td>Asuransi:</td>
    <td>&nbsp;</td>
            </tr>
            <tr>
                  <td width="108">&nbsp;</td>
               <td width="254">&nbsp;</td><td>&nbsp;</td>
               <td>
            <?     foreach ($asuransi as $rowz){?>
            <div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <?=$nomer++?>.<?=$rowz['nama_asuransi']?>
            </div>
            <? }?>
               </td>
               <td>&nbsp; </td>
            </tr>
      
        </table>
<table class="tabel-judul">
            <tr class="tabel-label">
                <td width="26">No</td>
                <td width="100">Harga (Rp.)</td>
                <td width="119" align="center">Frekuensi</td>
                <td width="131" align="center">Nama Nakes1</td>
                 <td width="131" align="center">Nama Nakes2</td>
                  <td width="109" align="center">Nama Nakes3</td>
                <td width="152" align="right">Sub Total (Rp.)</td>
          </tr>
            <?
              $no = 0;
        $jumlah=0;
        foreach ($detail as $row) {
            $jumlah+=($row['total']*$row['frekuensi']);
            $bobot=($row['bobot'] == 'Tanpa Bobot')?"":$row['bobot'];
            $profesi=($row['profesi'] == 'Tanpa Profesi')?"":$row['profesi'];
            $spesialisasi=($row['spesialisasi'] == 'Tanpa Spesialisasi')?"":$row['spesialisasi'];
            $layanans=($row['jenis'] == "Rawat Inap")?"$row[layanan] $row[instalasi]":$row['layanan'];
            $kelas=($row['id_kelas']!='1')?" ".$row['kelas']:'';
            $layanan = "$layanans $bobot $profesi $spesialisasi $kelas";
        ?>
    <tr class="<?= ($no % 2) ? 'even' : 'odd' ?>">
                  <td><?= ++$no?></td>
                  <td><?= rupiah($row['total'])?></td>
                  <td width="119"><div align="center"><?= $row['frekuensi'] ?></div>
                  </td>
      <td class="no-wrap" align="<?= ($row['nakes1'] == null || $row['nakes1'] ? 'center' : 'left') ?>"><?= ($row['nakes1'] != null && $row['nakes1'] != '') ? $row['nakes1'] : '-' ?></td>
         <td class="no-wrap" align="<?= ($row['nakes2'] == null || $row['nakes2'] ? 'center' : 'left') ?>"><?= ($row['nakes2'] != null && $row['nakes2'] != '') ? $row['nakes2'] : '-' ?></td>
                <td class="no-wrap" align="<?= ($row['nakes3'] == null || $row['nakes3'] ? 'center' : 'left') ?>"><?= ($row['nakes3'] != null && $row['nakes3'] != '') ? $row['nakes3'] : '-' ?></td>
      <td align="right"><?=rupiah($row['total']*$row['frekuensi'])?></td>
              </tr>
            <?
               
               
              }
            ?>
    </table>
                <table width=800>
              <tr>
                  <td colspan="5" align="right">Total</td><td align="right" width="133"><?=rupiah($jumlah)?></td>
              </tr>
</table>
       <table width=800>
              <tr>
                  <td colspan="6" align="center">--Silahkah Membayar di Kasir--</td>
              </tr>
</table>
           
<center>
    
          <p><span id='SCETAK'><input type='button' class='tombol' value='Cetak' onClick='cetak()'></span></p>
</center> 
    </body>
</html>
<?
exit();
?>