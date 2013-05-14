<?php
require_once 'app/lib/common/master-data.php';
$kepesertaanAsuransi = kepesertaan_asuransi($_GET['id']);
?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#tambahBaris').click(function(){
           var counter = $('.barang_tr').length+1,
           number = $('.barang_tr').length+1,
           string = "<tr class='barang_tr'>"+
                    "<td>"+number+"</td>"+
                    "<td><input type='text' name='produkAsuransi[]' id='produkAsuransi"+counter+"' style='width: 85%'/><input type='hidden' name='idProdukAsuransi[]' id='idProdukAsuransi"+counter+"' /></td>"+
                    "<td><input type='text' name='noPolis[]' id='noPolis"+counter+"' style='width: 85%'/></td>"+
                    "<td><input type='button' class='tombol' value='Hapus' onclick='hapusBarang("+counter+",this)' /></td>"
                    "</tr>";
           $('#tblKepesertaan').append(string);     
           initAsuransi(counter);
       })
    })
    
      
</script>
<table id="tblKepesertaan" class="table-input" style="width: 60%">
    <tr>
        <th style="width: 5%">No</th> 
        <th>Nama Produk Asuransi</th>
        <th>No. Polis</th>
        <th style="width: 10%">Aksi</th>
    </tr>
    <?php
    if(count($kepesertaanAsuransi) > 0){
        $num = 1;
        foreach ($kepesertaanAsuransi as $row){
    ?>
       <tr class="barang_tr <?= ($num%2)?'odd':'even' ?>">
           <td><?= $num++?></td>
           <td><?= $row['nama_asuransi']?><input type="hidden" id="idKepesertaan<?= $num?>" value="<?= $row['id_asuransi_kepesertaan']?>"></td>
           <td><?= $row['no_polis']?></td>
           <td><input type="button" class="tombol" value="Hapus" onclick="hapusKepesertaan(<?= $num?>,this)" /></td>
       </tr>
    <?php
        }
    }
    ?>
    <?php
      $num = isset ($num)?$num:0;
      $number = ($num > 0)?$num:1;
      for($i = ($number);$i <= ($number);$i++){
    ?>
      <tr class="barang_tr <?= ($i%2)?'odd':'even' ?>">
          <td><?= $i?></td>
          <td><input type="text" name="produkAsuransi[]" id="produkAsuransi<?= $i?>" style="width: 85%"/><span class="bintang2">*</span><input type="hidden" name="idProdukAsuransi[]" id="idProdukAsuransi<?= $i?>" /></td>
          <td><input type="text" name="noPolis[]" id="noPolis<?= $i?>" style="width: 85%"/><span class="bintang2">*</span></td>
          <td><input type="button" class="tombol" value="Hapus" onclick="hapusBarang(<?= $i?>,this)" /></td>
      </tr>
      <script type="text/javascript">
        initAsuransi(<?= $i?>);
      </script>
    <?php
      }
    ?>
</table>
<? exit; ?>
