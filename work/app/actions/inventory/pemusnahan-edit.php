<?php
include_once "app/lib/common/master-data.php";
include 'app/actions/admisi/pesan.php';
set_time_zone();
$pemusnahan= pemusnahan_muat_data_by_id(get_value('id'));
$master = $pemusnahan['master'];
?>
<script type="text/javascript">
        $(function() {
    $('#saksi').autocomplete("<?= app_base_url('/inventory/search?opsi=saksi') ?>",
    {
        parse: function(data){
            var parsed = [];
            for (var i=0; i < data.length; i++) {
                parsed[i] = {
                    data: data[i],
                    value: data[i].sub_macam // nama field yang dicari
                };
            }
            return parsed;
        },
        formatItem: function(data,i,max){
            $('#macam-barang').attr('value','');
            $('#id-sub-macam-barang').attr('value','');
            var str='<div class=result><b>'+data.nama+' </b></div>';
            return str;
        },
        width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
        dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
    }).result(
        function(event,data,formated){
            $(this).attr('value',data.nama);
            $('#idsaksi').attr('value',data.id);
        }
    );
});
</script>  
<script type="text/javascript">
function hapusBarang(index,iddetail,el){
    if(!confirm('apakah anda yakin akan menghapus data '+$('#barang'+index).attr('value'))){
        return true;
    }
    $.ajax({
            type: "GET",
            url: "<?=  app_base_url('inventory/control/detail-pemusnahan-delete')?>",
            data: 'id='+iddetail,
            dataType: 'json',
            success:function(data){
                if(data.status){
                    var parent = el.parentNode.parentNode;
                    parent.parentNode.removeChild(parent);
                    var jumlah=$('.number').length;
                    for(var i=0;i<=jumlah;i++){
                        $(".number:eq("+i+")").html(i+1);
                    }
                }
            }
    });
    
}

function initAutocompleteBarang(index){
    $('#barang'+index).autocomplete("<?= app_base_url('/inventory/search?opsi=packing_barang') ?>",
    {
        parse: function(data){
            var parsed = [];
            for (var i=0; i < data.length; i++) {
                parsed[i] = {
                    data: data[i],
                    value: data[i].sub_macam // nama field yang dicari
                };
            }
            return parsed;
        },
        formatItem: function(data,i,max){
             var str='<div class=result>'+data.barang+' '+data.satuan_terbesar+' '+data.nilai_konversi+' '+data.satuan_terkecil+'</div>';
                        return str;
                    },
                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
    }).result(
        function(event,data,formated){
            $(this).attr('value',data.barang+' '+data.satuan_terbesar+' '+data.nilai_konversi+' '+data.satuan_terkecil);
            $('#idPacking'+index).attr('value',data.id);
            $('#stok1'+index).attr('value',data.sisa);
            $('#idStok1'+index).attr('value',data.stok);
        });
}
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#tambahBaris").click(function(){
            var counterr = $('.barang_tr').length+1;
            var barang = 'barang'+counterr,
            satuan = 'satuan'+counterr,
            sisa = 'sisa'+counterr,
            rop = 'rop'+counterr

            string = "<tr class='barang_tr'>\n\
                    <td align=center>"+counterr+"</td>\n\
                    <td align='center'><input type=text name='barang["+counterr+"][nama]' id=barang"+counterr+" class=auto style='width: 15em;'/><input type=hidden name=name='barang["+counterr+"][idbarang]' id=idPacking"+counterr+" class=auto /></td>\n\
                    <td align='center'><input type=text name='barang["+counterr+"][jumlah]' id=jumlah"+counterr+" class=auto onkeyup='Angka(this)'/></td>\n\
                    <td><input type='text' name='barang["+counterr+"][stok]' class='auto' id='stok"+counterr+"' readonly/><input type='hidden' name='id_stok[]' class='auto' id=idStok"+counterr+"></td>\n\
                    <td align=center><select name='name='barang["+counterr+"][alasan]''>\n\
                    <option value=''>Pilih alasan</option>\n\
                    <option value='Rusak'>Rusak</option><option value='Kadaluarsa'>Kadaluarsa</option></select></td>\n\
                    <td align='center'><input type=text name='barang["+counterr+"][nobatch]' id=noBatch"+counterr+" class=auto /></td>\n\
                    <td align='center'><button onClick='removeMe("+counterr+",this)' class='tombol'>Hapus</button></td>\n\
                    </tr>";
            $("#tblPemusnahan").append(string);

            $(function() {
            $('#barang'+counterr).autocomplete("<?= app_base_url('/inventory/search?opsi=packing_barang') ?>",
            {
                parse: function(data){
                    var parsed = [];
                    for (var i=0; i < data.length; i++) {
                        parsed[i] = {
                            data: data[i],
                            value: data[i].sub_macam // nama field yang dicari
                        };
                    }
                    return parsed;
                },
                formatItem: function(data,i,max){
                     var str='<div class=result>'+data.barang+' '+data.satuan_terbesar+' '+data.nilai_konversi+' '+data.satuan_terkecil+'</div>';
                                return str;
                            },
                            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
                function(event,data,formated){
                    $(this).attr('value',data.barang+' '+data.satuan_terbesar+' '+data.nilai_konversi+' '+data.satuan_terkecil);
                    $('#idPacking'+counterr).attr('value',data.id);
                    $('#stok'+counterr).attr('value',data.sisa);
                    $('#idStok'+counterr).attr('value',data.stok);
                });
        });
        })
        })
        function removeMe(count,el){
        var parent = el.parentNode.parentNode;
        parent.parentNode.removeChild(parent);
        var penerimaan=$('.barang_tr');
        var countPenerimaanTr=penerimaan.length;
        for(var i=0;i<countPenerimaanTr;i++){
            $('.barang_tr:eq('+i+')').children('td:eq(0)').html(i+1);
        }}
</script>
<form action="<?=  app_base_url('inventory/control/pemusnahan-update')?>" method="post">
<h2 class="judul">Master Pemusnahan</h2><?echo isset($pesan)?$pesan:NULL;?>
<div class="data-input">
    <fieldset>
        <legend>Pemusnahan Barang</legend>
        <input type="hidden" name="idPemusnahan" value="<?= get_value('id')?>">
        <label for="petugas">Petugas</label><input type="text" value="<?= User::$nama?>" disabled><input type="hidden" name="idUser" value="<?= User::$id_user?>">
        <label for="saksi">Saksi</label><input type="text" value="<?= $master['saksi']?>" id="saksi"><input type="hidden" name="idSaksi" id="idsaksi" value="<?= $master['id_penduduk_saksi']?>">
        <label for="waktu">Tanggal</label><span style="font-size: 12px;padding-top: 5px;"><?= date('d-m-Y')?></span>
        <label for="waktu">Waktu</label><span style="font-size: 12px;padding-top: 5px;" id="jam"></span>
    </fieldset>
</div>    
<input type="button" value="Tambah Baris" id="tambahBaris" class="tombol" style="margin-bottom: 5px;">
<br>
<table id="tblPemusnahan" width="35%" style="border: 1px solid #f4f4f4; float: left">
    <tr style="background: #F4F4F4;">
        <th>No</th>
        <th>Nama Barang</th>
        <th>Jumlah</th>
        <th>Stok</th>
        <th>Alasan</th>
        <th>No Batch</th>
        <th>Aksi</th>
    </tr>
<?php
$i=1;
foreach ($pemusnahan['detail'] as $row){
?>
   <tr class="barang_tr">
     <td align="center" class="number"><?= $i?><input type="hidden" name="barang[<?=$i?>][iddetail]" value="<?=$row['id_detail_pemusnahan']?>"></td>
     <td>
         <input type="text" name="barang[<?= $i?>][nama]" id="barang<?= $i ?>" class="auto" value="<?=$row['barang']?>" style='width: 15em;'>
         <input type="hidden" name="barang[<?= $i?>][idbarang]" id="idbarang<?= $i ?>" class="auto" value="<?=$row['id_packing_barang']?>">
     </td>
     <td><input type="text" name="barang[<?= $i?>][jumlah]" id="jumlah<?= $i ?>" class="auto" value="<?= $row['jumlah']?>"></td>
     <td><input type="text" name="barang[<?= $i?>][stok]" id="stok<?= $i ?>" class="auto" value="<?= $row['sisa']?>"></td>
     <td>
         <select name="barang[<?= $i?>][alasan]">
                <option value="">Pilih alasan</option>
                <option value="Rusak" <?if($row['alasan'] == "Rusak") echo"selected"?>>Rusak</option>
                <option value="Kadaluarsa" <?if($row['alasan'] == "Kadaluarsa") echo"selected"?>>Kadaluarsa</option>
            </select>   
     </td>
     <td><input type="text" name="barang[<?= $i?>][nobatch]" id="nobatch<?= $i ?>" class="auto" value="<?= $row['no_batch']?>"></td>
     <td>
         <input type="button" class="tombol" value="Hapus" onclick="hapusBarang(<?=$i?>,<?=$row['id_detail_pemusnahan']?>,this)">
     </td>
   </tr>    
   <script type="text/javascript">
       initAutocompleteBarang(<?=$i?>);
   </script>    
<?php   
$i++;
}
?>    
</table>
<span style="position: relative;float: left;clear: left;padding-top: 30px;left: 90px">   
      <input type="submit" value="Simpan" name="save" class="tombol" />
      <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/info-pemusnahan') ?>'" />
 </span>     
</form>
<script type="text/javascript">
    function jam(){
        var waktu = new Date();
        var jam = waktu.getHours();
        var menit = waktu.getMinutes();
        var detik = waktu.getSeconds();

        if (jam < 10){
        jam = "0" + jam;
        }
        if (menit < 10){
        menit = "0" + menit;
        }
        if (detik < 10){
        detik = "0" + detik;
        }
        var jam_div = document.getElementById('jam');
        jam_div.innerHTML = jam + ":" + menit + ":" + detik;
        setTimeout("jam()", 1000);
    }
    jam();
</script>