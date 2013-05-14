<style>
body {margin: 0 30px; padding: 0; font:12px "arial","Consolas","Fixedsys",arial !important;}
td { font-size: 12px !important}
.tabel-judul {border-top: 1px dashed #000; border-bottom: 1px dashed #000; width: 1300px; margin: 20px 0}
.head-cetak-instansi {font-size: 22px; font-family: "Arial Narrow",tahoma; font-weight: 800}
.tabel-label td {border-bottom: 1px dashed #000; padding: 5px 0 10px 0}
</style>


<?php
  set_time_zone();
  require_once 'app/lib/common/master-data.php';
  $detail = detail_billing_muat_data($_GET['id']);
  
  $query = "select b.id,ps.id as norm,
        pd.nama as pasien,dp.alamat_jalan,kel.nama as kelurahan,kec.nama as kecamatan,kab.nama as kabupaten,pro.nama as provinsi 
        from billing b
        left join pasien ps on b.id_pasien = ps.id
        left join penduduk pd on ps.id_penduduk = pd.id  
        left join dinamis_penduduk dp on dp.id_penduduk = pd.id
        left join kelurahan kel on dp.id_kelurahan = kel.id
        left join kecamatan kec on kel.id_kecamatan = kec.id
        left join kabupaten kab on kec.id_kabupaten = kab.id
        left join provinsi pro on kab.id_provinsi = pro.id where b.id='$_GET[id]'";
  
  $data = _select_unique_result($query);
  
  $sql = mysql_query("select max(id) as id from pembayaran");
  $rows = mysql_fetch_array($sql);
  $nota = $rows['id'] + 1;
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
        <?require_once 'app/actions/admisi/lembar-header.php';?>  
        <table class="tabel-judul">
            <tr>
              <td align="center">NOTA PEMBAYARAN</td>
            </tr>
        </table>
        <table width=1300 border=0>
            <tr>
               <td width="160">No. Nota</td><td width="500">: <?= $nota?></td><td>&nbsp;</td><td width="170">Pasien</td><td width>: <?= $data['pasien']?></td>
            </tr>
            <tr>
                <td>Tanggal</td><td>: <?= date("d/m/Y");?></td><td>&nbsp;</td><td>Alamat</td><td>: <?= $data['alamat_jalan']." &nbsp; Kel.  ".$data['kelurahan']?></td>
            </tr>
            <tr>
                <td>No. Tagihan</td><td>: <?= $data['id']?></td><td>&nbsp;</td><td>Petugas</td><td>: <?= User::$nama?></td>
            </tr>
            <tr>
                <td colspan="3" height=60px>&nbsp;</td><td valign=bottom>Paraf</td><td valign=bottom>..................................</td>
            </tr>
            
        </table>
        <table class="tabel-judul">
            <tr class="tabel-label">
                <td>No</td>
                <td>Nama Layanan</td>
                <td>Kelas</td>
                <td>Frekuensi</td>
                <td align="right">Harga</td>
                <td align="right">Subtotal</td>
            </tr>
            <?
              $totalAll = 0;
              $no = 0;
              foreach ($detail as $row){
            ?>
               <tr>
                  <td><?= ++$no?></td>
                  <td><?= $row['layanan']?></td>
                  <td><?= $row['kelas']?></td>
                  <td><?= $row['frekuensi']?></td>
                  <td align="right"><?= rupiah($row['total'])?></td>
                  <td align="right">
                      <?
                        $subtotal = $row['frekuensi'] * $row['total'];
                        echo "".rupiah($subtotal)."";
                      ?>
                  </td>
              </tr>
            <?
            $totalAll += $subtotal;
              }
            ?>
              <tr>
                  <td colspan="5" align="right">Total</td><td align="right"><?= rupiah($totalAll)?></td>
              </tr>
              <tr>
                  <td colspan="5" align="right">Bayar</td><td align="right"><?= $_GET['bayar']==''?'':rupiah($_GET['bayar'])?></td>
              </tr>
              <tr>
                  <td colspan="5" align="right">Kembali</td><td align="right"><?=$_GET['kembali']==''?'':rupiah($_GET['kembali'])?></td>
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