


<?php
  set_time_zone();
  require_once 'app/lib/common/master-data.php';
  $detail = detail_billing_muat_data($_GET['id']);
  
  $query = mysql_query("select b.id,k.id as id_kunjungan,k.id_pasien as norm,pd.nama as pasien,dp.alamat_jalan,kel.nama as kelurahan,kec.nama as kecamatan,kab.nama as kabupaten,pro.nama as provinsi ,(select count(*) from pembayaran_billing where id_billing = b.id)+1 as pembayaran from billing b
        left join kunjungan k on b.id_kunjungan = k.id
        left join pasien ps on k.id_pasien = ps.id
        left join penduduk pd on ps.id_penduduk = pd.id  
        left join dinamis_penduduk dp on dp.id_penduduk = pd.id
        left join kelurahan kel on dp.id_kelurahan = kel.id
        left join kecamatan kec on kel.id_kecamatan = kec.id
        left join kabupaten kab on kec.id_kabupaten = kab.id
        left join provinsi pro on kab.id_provinsi = pro.id where b.id='$_GET[id]'");
  
  $data = mysql_fetch_array($query);
  
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
        <table class=head-laporan>
            <tr>
              <td align="center">NOTA PEMBAYARAN</td>
            </tr>
        </table>
        <table class="contain">
            <tr>
                <td>&nbsp;</td><td width="70px">No. Nota</td><td>: <?= $nota?></td><td>&nbsp;</td><td width="70px">Pasien</td><td>: <?= $data['pasien']?></td>
            </tr>
            <tr>
                <td>&nbsp;</td><td width="70px">Tanggal</td><td>: <?= date("d/m/Y");?></td><td>&nbsp;</td><td width="70px">Alamat</td><td>: <?= $data['alamat_jalan']." <br />&nbsp; Kel.  ".$data['kelurahan']?></td>
            </tr>
            <tr>
                <td>&nbsp;</td><td width="70px">No. Tagihan</td><td>: <?= $data['id']?></td><td>&nbsp;</td><td width="70px">Petugas</td><td>: <?= User::$nama?></td>
            </tr>
            <tr>
                <td colspan="4">&nbsp;</td><td>Paraf</td><td></td>
            </tr>
            <tr>
                <td colspan="4">&nbsp;</td><td>&nbsp;</td><td>..................................</td>
            </tr>
        </table>
        <table class="contain2">
            <tr>
                <td align="center">No</td>
                <td align="center">Nama Layanan</td>
                <td align="center">Kelas</td>
                <td align="center">Frekuensi</td>
                <td align="center">Harga</td>
                <td align="center">Subtotal</td>
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
                  <td><?= rupiah($row['total'])?></td>
                  <td>
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
                  <td colspan="5" align="right">Total</td><td><?= rupiah($totalAll)?></td>
              </tr>
              <tr>
                  <td colspan="5" align="right">Bayar</td><td><?= rupiah($_GET['bayar'])?></td>
              </tr>
              <tr>
                  <td colspan="5" align="right">Kembali</td><td><?= rupiah($_GET['kembali'])?></td>
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