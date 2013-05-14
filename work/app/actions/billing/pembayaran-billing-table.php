<?php
require_once 'app/lib/common/master-data.php';
$detail = detail_billing_muat_data($_GET['id']);
$sql ="select sum(jumlah_bayar) as jumlah_bayar from detail_pembayaran_billing where id_billing='$_GET[id]'";
$data = _select_unique_result($sql);
?>
<script type="text/javascript">
  function hitungTotal(){
      var total = currencyToNumber($("#totalAll").val());
      var bayar = currencyToNumber($("#bayar").val());
      $('#bayar1').val(bayar);
      if(bayar > total){
           var kembali = bayar - total;
           $("#kembali2").val(kembali);
           $("#kembali1").html(numberToCurrency(kembali));
           $("#sisaTagihan1").html('-');
           $("#sisaTagihan2").val('');
      }else if(total > bayar){
           var sisaTagihan = total - bayar;
           $("#sisaTagihan1").html(numberToCurrency(sisaTagihan));
           $("#sisaTagihan2").val(sisaTagihan);
           $("#kembali2").val('');
           $("#kembali1").html('-');
      }else{
           $("#kembali2").val('');
           $("#kembali1").html('-');
           $("#sisaTagihan1").html('-');
           $("#sisaTagihan2").val('');
      }
      
  }
</script>
<div class="data-list">
<table class="tabel" cellpadding="0" cellspacing="0" style="width: 100%">
    <tr>
        <th>No</th>
        <th width="50%">Nama Layanan</th>
        <th>Kelas</th>
        <th>Frekuensi</th>
        <th>Harga</th>
        <th>Subtotal (Rp.)</th>
    </tr>
    <?
      $totalAll = 0;
      $no = 0;
      foreach ($detail as $row){
    ?>
      <tr class="<?= ($no % 2) ? 'even' : 'odd' ?>">
          <td align="center"><?= ++$no?></td>
          <td><?php
		$bobot=($row['bobot'] == 'Tanpa Bobot')?"":$row['bobot'];
                $profesi=($row['profesi'] == 'Tanpa Profesi')?"":$row['profesi'];
                $spesialisasi=($row['spesialisasi'] == 'Tanpa Spesialisasi')?"":$row['spesialisasi'];
                $layanans=($row['jenis'] == "Rawat Inap" && $row['id_instalasi']<>9)?"$row[layanan] $row[instalasi]":$row['layanan'];
                $layanan = "$layanans $bobot $profesi $spesialisasi ";
                $layanan.=($row['id_kelas']!='1')?$row['kelas']:'';
                echo $layanan;
          ?></td>
          <td><?= $row['kelas']?></td>
          <td width="10%"><?= $row['frekuensi']?></td>
          <td align="right"><?= rupiah($row['total'])?></td>
          <td align="right">
              <?
                $subtotal = $row['frekuensi'] * $row['total'];
                echo rupiah($subtotal);
              ?>
          </td>
      </tr>
    <?
      $totalAll += $subtotal;
      }
      
      if($totalAll == $data['jumlah_bayar']){
          $bayar = 0;
      }else if($totalAll > $data['jumlah_bayar']){
          $bayar = $totalAll - $data['jumlah_bayar'];
      }else if($data['jumlah_bayar'] > $totalAll){
          $bayar = 0;
      }
    ?>
</table>
</div>
<span style="position: relative;float: right;padding-top: 10px;width: 100%">
    <table style="float:right">
        <tr>
            <td>Tagihan</td><td>:</td><td align="right"><b><?= rupiah($totalAll)?></b><input type="hidden" value="<?= $totalAll?>"></td>
        </tr>
        <tr>
            <td>Total Tagihan</td><td>:</td><td align="right"><b><?= rupiah($bayar)?></b><input type="hidden" id="totalAll" value="<?= $bayar?>" name="totalAll"></td>
        </tr>
        <tr>
            <td>Bayar</td><td>:</td><td><input type="text" onkeyup='formatNumber(this)' class="auto right" name="bayar" id="bayar" onBlur="hitungTotal()" <?if($bayar == 0) echo "disabled=disabled";?>><input type="hidden" id="bayar1"></td>
        </tr>
        <tr>
            <td>Kembali</td><td>:</td><td id="kembali1" style="font-weight:bold" align="right"></td>
        </tr>
        <tr>
            <td>Sisa Tagihan</td><td>:</td><td id="sisaTagihan1" align="right" style="font-weight:bold"></td>
        </tr>
    </table>
    <input type="hidden" id="kembali2" name="kembali">
    <input type="hidden" id="sisaTagihan2" name="sisaTagihan">
</span>    
<?php
exit();
?>
