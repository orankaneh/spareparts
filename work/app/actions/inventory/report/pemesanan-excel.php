<?php
    require_once 'app/lib/common/functions.php';
    require_once 'app/lib/common/master-data.php';
    set_time_zone();
    
    $namaFile = "pemesanan-info-excel.xls";
    header_excel($namaFile);
    $id = isset ($_GET['id'])?$_GET['id']:NULL;
    $sp = sp_muat_data_by_id($id);
    $master = $sp['master'];
    $detail = $sp['barang'];
    $head = head_laporan_muat_data();
    $rs=  profile_rumah_sakit_muat_data();
    $tanggal = explode("-", $master['tanggal']);
?>
    <table class="head-laporan">
    <?php
    echo lembar_header_excel(4);
?>
        <tr>
            <td colspan="4" align="center">
                SURAT PEMESANAN <br />
                Nomor: <?php echo $master['id']."/".$tanggal[1]."/".$tanggal[0]?>
            </td>
        </tr>
    </table> 
    <table class="contain">
      <tr>
          <td colspan="4" style="padding-left: 20px;" align="right"><?=$rs['kabupaten'].", ".  indo_tgl(Date('d/m/Y'), '/')?></td>
      </tr>
      <tr>
          <td colspan="4" style="padding-left: 20px;">
              Kepada:<br>
              Yth. <b><?=$master['suplier']?></b><br>
              Di <b><?echo $master['alamat']."<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$master['kabupaten'];?></b>
              <br><br>
          </td>
      </tr>
      <tr>
          <td colspan="4">Dengan Hormat,</td>
      </tr>
      <tr>
          <td colspan="4">Mohon dikirim barang sbb :</td>
      </tr>
      <tr>
          <td colspan="4">
              <div class="data-list">
              <table width="100%" class="table" border="1px">
                  <tr>
                      <th style="width: 5%">No</th>
                      <th style="width: 40%">Nama</th>
                      <th style="width: 12%">Jumlah</th>
                      <th>Keterangan</th>
                  </tr>
                  <?php
                      $no = 1;
                      foreach ($detail as $row){
                  ?>
                  <tr>
                      <td align="center"><?= $no++?></td>
                      <td><?= $row['nama_barang']." ".$row['kekuatan']." $row[sediaan] @$row[nilai_konversi] $row[satuan_terkecil]" ?></td>
                      <td><?= rupiah($row['jumlah_pesan'])." ".$row["satuan_terbesar"]?></td>
                      <td>&nbsp;</td>
                  </tr>
                  <?php
                      }
                  ?>
              </table>
              </div>    
          </td>
      </tr>
      <tr><td colspan="4">Atas perhatiannya kami mengucapkan terima kasih.</td></tr>
      <tr><td colspan="4">Hormat kami,</td></tr>
      <tr><td colspan="4" height="70" valign="top">Penanggung Jawab,</td></tr>
      <tr><td colspan="4"><?= $master['pegawai']?><br />________________________</td></tr>
      <tr><td colspan="4">SIP. <?= ($master['sip']!="NULL"&&$master['sip']!="")?$master['sip']:"--"?></td></tr>
    </table>  
<?
       exit();
?>