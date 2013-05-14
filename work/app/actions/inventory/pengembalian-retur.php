<?php
  include_once "app/lib/common/functions.php";
  include_once "app/lib/common/master-data.php";
  include_once 'app/actions/admisi/pesan.php';
  set_time_zone();
?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#tampil").click(function(){
            $("#hide").slideToggle();
        })  
        $("#hide").toggle(false);
    })
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#tambahBarang").click(function(){
            var counter = $(".barang_tr").length+1;
            string = "\n\
                     <tr class='barang_tr'>\n\
                     <td>"+counter+"</td>\n\
                     <td><input type='text' name='barang[]' class='auto barang"+counter+"'><input type='hidden' name='idbarang[]' class='idbarang"+counter+"' class='auto'></td>\n\
                     <td><input type='text' name='noFaktur[]' id='noFaktur' class='auto'></td>\n\
                     <td><input type='text' name='jmlRetur[]' id='jmlRetur' class='auto'></td>\n\
                     <td><input type='text' name='noBatch[]' id='noBatch' class='auto'></td>\n\
                     <td><input type='text' name='kadaluarsa[]' id='kadaluarsa"+counter+"' class='auto'></td>\n\
                     <td><input type='text' name='jmlTerima[]' id='jmlTerima' class='auto'></td>\n\
                     <td><input type='text' name='satuan[]' id='satuan' class='auto'></td>\n\
                     <td><input type='button' class='del' value='X' onClick='hapusBarang("+counter+",this)'></td>\n\
                     </tr>";
           $("#tblBarang").append(string);
           
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
            
          $(function(){
             $('#kadaluarsa'+counter+'').datepicker({
                changeMonth: true,
                changeYear: true
          }) 
          }) 
          
        })
    })
    
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
<script type="text/javascript">
    $(document).ready(function(){
        $("#tambahUang").click(function(){
            var counter = $(".uang_tr").length+1;
            string = "<tr class='uang_tr'>\n\
                      <td>"+counter+"</td>\n\
                      <td><input type='text' name='barang[]' class='auto barang"+counter+"'><input type='hidden' name='idbarang[]' class='idbarang"+counter+"' class='auto'></td>\n\
                      <td><input type='text' name='noFaktur[]' id='noFaktur' class='auto'></td>\n\
                      <td><input type='text' name='jmlRetur[]' id='jmlRetur' class='auto'></td>\n\
                      <td><input type='text' name='harga[]' id='harga' class='auto'></td>\n\
                      <td><input type='text' name='diskon[]' id='diskon' class='auto'></td>\n\
                      <td><input type='text' name='hargaTotal[]' id='hargaTotal' class='auto'></td>\n\
                      <td><input type='text' name='hargaRetur[]' id='hargaRetur' class='auto'></td>\n\
                      <td><input type='button' class='del' value='X' onClick='hapusUang("+counter+",this)'></td>\n\
                      </tr>";
                          
                      $("#tblUang").append(string);    
                      
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
        })
    })
    function hapusUang(count,el){
        var parent = el.parentNode.parentNode;
        parent.parentNode.removeChild(parent);
        var penerimaan=$('.uang_tr');
        var countPenerimaanTr=penerimaan.length;
        for(var i=0;i<countPenerimaanTr;i++){
            $('.uang_tr:eq('+i+')').children('td:eq(0)').html(i+1);
        }
    }
</script>    
<h2 class="judul">Pengembalian Retur</h2>
<div class="data-input">
    <fieldset><legend>Form Pengembalian Retur</legend>
    <fieldset class="field-group"><legend>Petugas</legend><span style="margin-left: 12px;font-size: 11px;"><?= $penerima = $_SESSION['nama'];?> <input type="hidden" name="idpegawai" value="<?= $idpegawai = $_SESSION['id_user']?>"></span>
    </fieldset>
    <label for="no-sr">No. Surat Retur</label><input type="text" name="nosr" id="nosr" onBlur="submit(form)"/>
    <label for="suplier">Suplier</label><input type="text" name="suplier" id="suplier"/>
    <label for="tanggal">Tanggal Terima</label><input type="text" name="tanggal" class="tanggal" value="<?= date('d/m/Y')?>"/>    
</div>    
<h2 class="judul">Pengembalian Retur Barang</h2>
<input type="button" value="Tambah Baris" id="tambahBarang" class="tombol" style="margin-bottom: 5px;">
<form action="" method="post">
<table width="55%" style="border: 1px solid #f4f4f4; float: left" id="tblBarang">
    <tr style="background: #F4F4F4;">
        <th>No</th>
        <th>Nama Barang</th>
        <th>No. Faktur</th>
        <th>Jumlah Retur</th>
        <th>No. Batch</th>
        <th>Tanggal Kadaluwarsa</th>
        <th>Jumlah Terima</th>
        <th>Satuan</th>
        <td>Aksi</td>
    </tr>
   <?
     for($i=1;$i<=5;$i++){
   ?>
      <tr class="barang_tr">
        <td><?= $i?></td>
        <td><input type="text" name="barang[]" class="auto barang<?= $i?>"><input type="hidden" name="idBarang[]" class="idbarang<?= $i?>" class="auto"></td>
        <td><input type="text" name="noFaktur[]" id="noFaktur" class="auto"></td>
        <td><input type="text" name="jmlRetur[]" id="jmlRetur" class="auto"></td>
        <td><input type="text" name="noBatch[]" id="noBatch" class="auto"></td>
        <td><input type="text" name="kadaluarsa[]" id="kadaluarsa<?= $i?>" class="auto"></td>
        <td><input type="text" name="jmlTerima[]" id="jmlTerima" class="auto"></td>
        <td><input type="text" name="satuan[]" id="satuan" class="auto"></td>
        <td><input type="button" class="del" value="X" onClick="hapusBarang(<?= $i?>,this)"></td>
      </tr>    
      <script type="text/javascript">
          $(function(){
              $('#kadaluarsa<?= $i?>').datepicker({
                   changeMonth: true,
                   changeYear: true
              })
          })
      </script>    
   <? 
     }
   ?> 
</table>
  <span style="float: left;clear: left; padding-top: 20px;">
      <input type="submit" value="Simpan" name="save" class="tombol" />
  </span>  
</form>    
<span style="float: right;position: relative;right: 230px;padding-top: 20px;">
      <input type="submit" value="Pengembalian Uang" class="tombol" id="tampil"/>
</span>

<div id="hide" style="clear:left;padding-top: 20px;">
<h2 class="judul">Pengembalian Retur Uang</h2>
<input type="button" value="Tambah Baris" id="tambahUang" class="tombol" style="margin-bottom: 5px;">
<form action="" method="post">
<table width="55%" style="border: 1px solid #f4f4f4; float: left" id="tblUang">
    <tr style="background: #F4F4F4;">
        <th>No</th>
        <th>Nama Barang</th>
        <th>No. Faktur</th>
        <th>Jumlah Retur</th>
        <th>Harga</th>
        <th>Diskon</th>
        <th>Harga Total</th>
        <th>Harga Retur</th>
        <td>Aksi</td>
    </tr>
   <?
     for($i=1;$i<=5;$i++){
   ?>  
      <tr class="uang_tr">
        <td><?= $i?></td>
        <td><input type="text" name="barang[]" class="auto barang<?= $i?>"><input type="hidden" name="idBarang[]" class="idbarang<?= $i?>" class="auto"></td>
        <td><input type="text" name="noFaktur[]" id="noFaktur" class="auto"></td>
        <td><input type="text" name="jmlRetur[]" id="jmlRetur" class="auto"></td>
        <td><input type="text" name="harga[]" id="harga" class="auto"></td>
        <td><input type="text" name="diskon[]" id="diskon" class="auto"></td>
        <td><input type="text" name="hargaTotal[]" id="hargaTotal" class="auto"></td>
        <td><input type="text" name="hargaRetur[]" id="hargaRetur" class="auto"></td>
        <td><input type="button" class="del" value="X" onClick="hapusUang(<?= $i?>,this)"></td>
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
  </span>  
</form>    
</div>

    