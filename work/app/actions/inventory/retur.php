<?php
  include_once "app/lib/common/functions.php";
  include_once "app/lib/common/master-data.php";
  include_once 'app/actions/admisi/pesan.php';
  set_time_zone();
  $date=Date('d').'/'.Date('m').'/'.(2000+Date('y'));
?>
<script type="text/javascript">
$(function() {
        $('#suplier').autocomplete("<?= app_base_url('/inventory/search?opsi=suplier') ?>",
        {
                    parse: function(data){
                        var parsed = [];
                        for (var i=0; i < data.length; i++) {
                            parsed[i] = {
                                data: data[i],
                                value: data[i].nama // nama field yang dicari
                            };
                        }
                        return parsed;
                    },
                    formatItem: function(data,i,max){
                        var str='<div class=result>'+data.nama+' <br/><i> '+data.alamat+' , '+data.nama_kelurahan+'</i></div>';
                        return str;
                    },
                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                $('#suplier').attr('value',data.nama);
                $('#idsuplier').attr('value',data.id);
            }
        );
});
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#tambahBaris").click(function(){
            var counter = $(".barang_tr").length+1;
            string = "<tr class='barang_tr'>\n\
                      <td>"+counter+"</td>\n\
                      <td><input type='text' name='barang[]' class='auto barang"+counter+"'>\n\
                      <input type='hidden' name='idBarang[]' class='auto idbarang"+counter+"'></td>\n\
                      <td><input type='text' name='noBatch[]' class='auto'></td>\n\
                      <td>\n\
                      <select name='noFaktur[]' class='auto'>\n\
                      <option value=''>No. Faktur</option>\n\
                      <option value='1'>F001, Tgl: <?= date('d/m/Y')?></option>\n\
                      <option value='2'>F002, Tgl: <?= date('d/m/Y')?></option>\n\
                      </select>\n\
                      </td>\n\
                      <td><input type='text' name='jmlRetur[]' class='auto'></td>\n\
                      <td><input type='text' name='alasan[]' class='auto'></td>\n\
                      <td><input type='button' class='del' value='X' onClick='hapusBarang("+counter+",this)'></td>\n\
                      </tr>";
           $("#tblRetur").append(string);
           
           $('.barang'+counter).autocomplete("<?= app_base_url('/inventory/search?opsi=namabarang') ?>",
            {
                    parse: function(data){
                        var parsed = [];
                        for (var i=0; i < data.length; i++) {
                            parsed[i] = {
                                data: data[i],
                                value: data[i].nama_barang // nama field yang dicari
                            };
                        }
                        return parsed;
                    },
                    formatItem: function(data,i,max){
                        var str='<div class=result><b>'+data.nama_barang+'</b><br /><i>Satuan:</i> '+data.satuan+' <i>Kemasan</i>: '+data.kemasan+' <br/><i>Macam:</i> '+data.macam_barang+'</div>';
                        return str;
                    },
                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
           }).result(
            function(event,data,formated){
                $(this).attr('value',data.nama_barang);
                $('.idbarang'+counter+'').attr('value',data.id);
            });
        });
    });
    function hapusBarang(count,el){
        var parent = el.parentNode.parentNode;
        parent.parentNode.removeChild(parent);
        var penerimaan=$('.barang_tr');
        var countPenerimaanTr=penerimaan.length;
        for(var i=0;i<countPenerimaanTr;i++){
            $('.barang_tr:eq('+i+')').children('td:eq(0)').html(i+1);
        }
    }
</script>    
<h2 class="judul">Tambah Retur</h2><?= isset ($pesan)?$pesan:NULL?>
<div class="data-input">
    <fieldset>
    <legend>Retur Barang ke Suplier</legend>    
    <label for="tanggal">Tanggal</label><input type="text" name="tanggal" id="awal" class="tanggal" value="<?=$date?>"/>
    <label for="suplier">Suplier</label><input type="text" name="suplier" id="suplier" /><input type="hidden" name="idsuplier" id="idsuplier" />
    </fieldset>
</div> 
<input type="button" value="Tambah Baris" id="tambahBaris" class="tombol" style="margin-bottom: 5px;">
<form action="" method="POST">
    <table width="55%" style="border: 1px solid #f4f4f4; float: left" id="tblRetur">
      <tr style="background: #F4F4F4;">
        <th>No</th>
        <th>Nama Barang</th>
        <th>No. Batch</th>
        <th>No. Faktur</th>
        <th>Jumlah Retur</th>
        <th>Alasan</th>
        <td>Aksi</td>
      </tr>
      <?
        for($i=1;$i<=5;$i++){
      ?>
         <tr class="barang_tr">
           <td><?= $i?></td>
           <td><input type="text" name="barang[]" class="auto barang<?= $i?>"><input type="hidden" name="idBarang[]" class="auto idbarang<?= $i?>"></td>
           <td><input type="text" name="noBatch[]" class="auto"></td>
           <td>
               <select name="noFaktur[]" class="auto">
                   <option value="">No. Faktur</option>
                   <option value="1">F001, Tgl: <?= date('d/m/Y')?></option>
                   <option value="2">F002, Tgl: <?= date('d/m/Y')?></option>
               </select>
           </td>
           <td><input type="text" name="jmlRetur[]" class="auto"></td>
           <td><input type="text" name="alasan[]" class="auto"></td>
           <td><input type="button" class="del" value="X" onClick="hapusBarang(<?= $i?>,this)"></td>
         </tr>    
         <script type="text/javascript">
        $(function() {
        $('.barang'+<?= $i ?>).autocomplete("<?= app_base_url('/inventory/search?opsi=namabarang') ?>",
        {
                    parse: function(data){
                        var parsed = [];
                        for (var i=0; i < data.length; i++) {
                            parsed[i] = {
                                data: data[i],
                                value: data[i].nama_barang // nama field yang dicari
                            };
                        }
                        return parsed;
                    },
                    formatItem: function(data,i,max){
                        var str='<div class=result><b>'+data.nama_barang+'</b><br /><i>Satuan:</i> '+data.satuan+' <i>Kemasan</i>: '+data.kemasan+' <br/><i>Macam:</i> '+data.macam_barang+'</div>';
                        return str;
                    },
                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                $(this).attr('value',data.nama_barang);
                $('.idbarang'+<?= $i?>).attr('value',data.id);
            }
        );
        });
      </script>  
      <?
        }
      ?>
    </table>
<span style="float: left;clear: left; padding-top: 20px;">
 <input type="submit" value="Simpan" name="save" class="tombol" />
 <input type="button" value="Cetak" name="cetak" class="tombol cetakRetur" />
</span>      
</form>    
<script type="text/javascript">
    $(document).ready(function(){
        $('.cetakRetur').click(function(){
            window.open('', 'myWindow', 'width=500px,height=600px')
        })  
    })
</script>    