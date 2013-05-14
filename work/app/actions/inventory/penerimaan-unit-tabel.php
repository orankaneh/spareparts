<?php
    require_once 'app/lib/common/master-inventory.php';
    $barang= penerimaan_unit_muat_data($_GET['id']);    
?>
<script type="text/javascript">
function hapusBarang(count,el){
var parent = el.parentNode.parentNode;
parent.parentNode.removeChild(parent);
var penerimaan=$('.barang_tr');
var countPenerimaanTr=penerimaan.length;
for(var i=0;i<countPenerimaanTr;i++){
  $('.barang_tr:eq('+i+')').children('td:eq(0)').html(i+1);
}}

function cekJumlah(num){
    var jumDistribusi = $('#jumDistribusi'+num).val()*1,
    jumDiterima = $('#jumDiterima'+num).val()*1,
    jumlah = $('#jumlah'+num).val()*1;
    
    if((jumlah+jumDiterima) > jumDistribusi){
        alert("Jumlah yang diinputkan melebihi jumlah distribusi");
        $('#jumlah'+num).val('');
        return false;
    }
}

function cekForm(){
            if($("#distribusi").val() == ""){
                alert("No. Distribusi tidak boleh kosong");
                $("#distribusi").focus();
                return false;
            }
            if($("#idDistribusi").val() == ""){
                alert("Pilih No. Distribusi dengan benar");
                $("#idDistribusi").focus();
                return false;
            }
            
             var jumlahForm=$('.barang_tr').length;
             var i=0;
             for(i=1;i<=jumlahForm;i++){
                 if($('#jumlah'+i).attr('value')=='' || ($('#jumlah'+i).attr('value')*1)==0){
                     alert('Jumlah tidak boleh kosong');
                     $('#jumlah'+i).focus();
                     return false;
                 }
             }
        }
</script>
<div class="data-list tabelflexibel">
<table class="table-input" cellspacing="0" cellpadding="0" id="tblPembelian" style="width: 80%">
    <tr style="background: #F4F4F4;">
        <th>No</th>
        <th style="width: 32%">Nama Packing Barang</th>
        <th style="width: 15%">No. Batch</th>
        <th class="sleft no-wrap">Jumlah Terima</th>
        <th>Jumlah Distribusi</th>
        <th>Jumlah Telah Diterima</th>
        <th class="no-wrap">Kemasan</th>
        <th>Aksi</th>
    </tr>
    <? 
        $no = 1;
        foreach ($barang as $key => $row){
            $nama=nama_packing_barang(array($row['generik'],$row['barang'],$row['kekuatan'],$row['sediaan'],$row['nilai_konversi'],$row['satuan_terkecil'],$row['pabrik']));  
                    
    ?>
      <tr class="<?= ($key%2) ? 'odd' : 'even' ?> barang_tr">
         <td align="center"><?= ++$key?></td>
         <td class="no-wrap">
            <?= $nama?>
            <input type="hidden" name="id_packing[]" value="<?= $row['id_packing_barang']?>"> 
         </td>
         <td align="center">
             <?= $row['batch']?>
             <input type="hidden" value="<?= $row['batch']?>" name="batch[]" id="batch<?= $no?>">
         </td>
         <td align="center">
           <input type="text" name="jumlah[]" style="width:50%" id="jumlah<?= $no?>" onkeyup="Desimal(this)" onblur="return cekJumlah(<?= $no?>)" maxlength="<?=  strlen($row['jumlah_distribusi'])?>">
         </td>
         <td align="center">
             <?= $row['jumlah_distribusi']?>
             <input type="hidden" value="<?= $row['jumlah_distribusi']?>" id="jumDistribusi<?= $no?>">
         </td>
         <td align="center">
             <?= rupiah($row['sisa'])?>
             <input type="hidden" value="<?= $row['sisa']?>" id="jumDiterima<?= $no?>">
         </td>
         <td style="text-align:center;"><?=$row['satuan_terbesar']?></td>
         <td align="center">
            <input type="button" class="tombol" value="Hapus" onclick="hapusBarang(<?= $key?>,this)">
         </td>
      </tr>    
    <?
    $no++;
    }
?>
</table>
</div>    
<?  exit();?>
