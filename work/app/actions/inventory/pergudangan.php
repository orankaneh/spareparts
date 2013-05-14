<?php
  include_once "app/lib/common/functions.php";
  include_once "app/lib/common/master-data.php";
  include_once 'app/actions/admisi/pesan.php';
  set_time_zone();
  $date=Date('d').'/'.Date('m').'/'.(2000+Date('y'));
?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#tambahBaris").click(function(){
            var counter = $('.barang_tr').length+1;
            var barang = 'barang'+counter,
            satuan = 'satuan'+counter,
            sisa = 'sisa'+counter,
            rop = 'rop'+counter

            string = "<tr class='barang_tr'>\n\
                    <td align=center>"+counter+"</td><td align=center>\n\
                    <input type=text name=barang["+counter+"][nama] id=barang"+counter+" class=auto />\n\
                    <input type=hidden name=barang["+counter+"][idbarang] id=idbarang"+counter+" class=auto /></td>\n\
                    <td align=center>&nbsp;</td>\n\
                    <td align=center><input type=text name=barang["+counter+"][satuan] id=satuan"+counter+" class=auto /></td>\n\
                    <td align=center><button onClick='hapusBarang("+counter+",this)' class='del'>X</button></td>\n\
                    </tr>";
            $("#tblPemesanan").append(string);

            $('#barang'+counter).autocomplete("<?= app_base_url('/inventory/search?opsi=namabarang') ?>",
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
                $('#idbarang'+counter+'').attr('value',data.id);
            });
        });
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
<h2 class="judul">Distribusi Barang</h2><?= isset ($pesan)?$pesan:NULL?>
<div class="data-input">  
        <fieldset>
        <label for="unit">Unit</label><input type="text" name="unit" id="unit" />
        <label for="tanggal">Tanggal</label><input type="text" name="tanggal" id="tanggal" value="<?= $date?>"/>
        <label for="petugas">Petugas</label><input type="text" value="<?= $_SESSION['nama'] ?>" disabled />
        </fieldset>
</div>
<input type="button" value="Tambah Baris" id="tambahBaris" class="tombol" style="margin-bottom: 5px;">
<form action="" method="POST">
<table width="40%" style="border: 1px solid #f4f4f4; float: left" id="tblPemesanan">
    <tr style="background: #F4F4F4;">
        <th>No</th>
        <th>Nama Barang</th>
        <th>Stok Barang</th>
        <th>Jumlah Keluar</th>
        <th>Hapus</th>
    </tr>
<script type="text/javascript">
$(function() {
    $('#barang1').autocomplete("<?= app_base_url('/inventory/search?opsi=namabarang') ?>",
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
             var str='<div class=result><b>'+data.nama_barang+'</b><br /><i>Satuan:</i> '+data.satuan+' <i>Kemasan</i>: '+data.kemasan+' <br/><i>Macam:</i> '+data.macam_barang+'</div>';
                        return str;
                    },
                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
    }).result(
        function(event,data,formated){
            $(this).attr('value',data.nama_barang);
            $('#idbarang1').attr('value',data.id);
        });
});
</script>
    <tr class="barang_tr">
        <td align="center">1</td>
        <td align="center"><input type=text name=barang1 id=barang1 class=auto /><input type=hidden name=idbarang1 id=idbarang1 class=auto /></td>
        <td align="center">Bodrexin</td>
        <td align="center"><input type=text name=alasan1 id=alasan1 class=auto /></td>
        <td align="center"><button onClick='hapusBarang(1,this)' class="del">X</button></td>
    </tr>
</table>
<span style="float: left;clear: left; padding-top: 20px;">
 <input type="submit" value="Simpan" name="save" class="tombol" />
</span>
</form>