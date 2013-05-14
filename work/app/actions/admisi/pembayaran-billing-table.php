<?php
require_once 'app/lib/common/master-data.php';
$detail = detail_billing_muat_data($_GET['id']);
$sql = mysql_query("select sum(jumlah_bayar) as jumlah_bayar from pembayaran_billing where id_billing='$_GET[id]'");
$data = mysql_fetch_array($sql);

?>
<script type="text/javascript">
  function hitungTotal(){
      var total = currencyToNumber($("#totalAll").val()),
      bayar = currencyToNumber($("#bayar").val());
      
      if(bayar > total){
       var kembali = bayar - total;
       $("#kembali2").val(kembali);
       $("#kembali1").html(kembali);   
      }else if(total > bayar){
       var sisaTagihan = total - bayar;
       $("#sisaTagihan1").html(sisaTagihan);
       $("#sisaTagihan2").val(sisaTagihan);
      }
      
  }
</script>
<div class="data-list">
<table class="tabel" cellpadding="0" cellspacing="0" style="width: 80%">
    <tr>
        <th>No</th>
        <th>Nama Layanan</th>
        <th>Kelas</th>
        <th>Frekuensi</th>
        <th>Harga</th>
        <th>Subtotal</th>
    </tr>
    <?
      $totalAll = 0;
      $no = 0;
      foreach ($detail as $row){
    ?>
      <tr class="<?= ($no % 2) ? 'even' : 'odd' ?>">
          <td><?= ++$no?></td>
          <td><?= $row['layanan']?></td>
          <td><?= $row['kelas']?></td>
          <td><?= $row['frekuensi']?></td>
          <td><?= $row['total']?></td>
          <td>
              <?
                $subtotal = $row['frekuensi'] * $row['total'];
                echo "$subtotal";
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
<span style="position: relative;float: left;clear: left;padding-top: 10px;left: 630px">
    <table>
        <tr>
            <td>Total Tagihan</td><td>:</td><td><b><?= $totalAll?></b><input type="hidden" value="<?= $totalAll?>"></td>
        </tr>
        <tr>
            <td>Yang Harus Dibayar</td><td>:</td><td><b><?= $bayar?></b><input type="hidden" id="totalAll" value="<?= $bayar?>" name="totalAll"></td>
        </tr>
        <tr>
            <td>Bayar</td><td>:</td><td><input type="text" onkeyup='Angka(this)' name="bayar" id="bayar" onBlur="hitungTotal()" <?if($bayar == 0) echo "disabled=disabled";?>></td>
        </tr>
        <tr>
            <td>Kembali</td><td>:</td><td id="kembali1" style="font-weight:bold"><input type="hidden" id="kembali2" name="kembali"></td>
        </tr>
        <tr>
            <td>Sisa Tagihan</td><td>:</td><td id="sisaTagihan1" style="font-weight:bold"><input type="hidden" id="sisaTagihan2" name="sisaTagihan"></td>
        </tr>
    </table>
</span>    
<?php
exit();
?>
