<h2 class="judul">Produksi </h2>
<?php
require 'app/actions/admisi/pesan.php';
?>
<script type="text/javascript">
    function initNewRow(i) {
    $(function() {
            $('#jumlah_kurang'+i).live("keyup",function () {                
                var harga    = $('#harga'+i).val();
                var jumlah   = $(this).val();
                
                if (jumlah == '') {
                    var harga_jual = harga;
                } else {
                    var harga_jual   = harga * jumlah;
                }
                $('#hargajual'+i).html(numberToCurrency(harga_jual));
                $('#hiddenharga'+i).attr('value',harga_jual);
                var count = $('.repackage-tr').length;
                var total = 0;
                for(var j = 1; j <= count; j++) {
                    
                    var harga=isNaN(parseInt($('#hiddenharga'+j).val()))?0:parseInt($('#hiddenharga'+j).val());
                    var total = harga + total;
                   
                }
                $('#total').html(numberToCurrency(total));
                //alert(tot_harga);
            });
            
            $('#packing_kurang'+i).autocomplete("<?= app_base_url('/inventory/search?opsi=produksi-data') ?>",
            {
                    extraParams:{
                        kelas:function(){
                            return '';
                        }
                    },
                    parse: function(data){
                        var parsed = [];
                        for (var i=0; i < data.length; i++) {
                            parsed[i] = {
                                data: data[i],
                                value: data[i].barang // nama field yang dicari
                            };
                        }
                        return parsed;
                    },
                    formatItem: function(data,i,max){
                        var str=ac_nama_packing_barang([data.generik, data.barang, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik],null);
                        return str;
                    },
                width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
            function(event,data,formated){
                   var str=nama_packing_barang([data.generik, data.barang, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik]);
                    $(this).attr('value',str);
                    $('#id_packing_kurang'+i).attr('value',data.id_packing);
                    $('#kemasan'+i).html(data.satuan_terkecil);
                    $('#harga'+i).attr('value',data.harga);
                    $('#hiddenharga'+i).attr('value',data.harga);                    
                    $('#sisa'+i).html(data.sisa);
                    $('#hargajual'+i).html(numberToCurrency2(data.harga));
                    var harga=isNaN(parseInt($('#total').html()))?0:parseInt($('#total').html());                                            
                    harga=harga+parseInt(data.harga);
                    $('#total').html(harga);                    
            });
    })
    }
    $(function() {
    $('#packing_tambah').focus();
        $('#packing_tambah').autocomplete("<?= app_base_url('/inventory/search?opsi=namabarang') ?>",
            {
                    extraParams:{
                        kelas:function(){
                            return '';
                        }
                    },
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
                        var str=ac_nama_packing_barang([data.generik, data.nama_barang, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik], null)                        
                        return str;
                    },
                width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
            function(event,data,formated){
                var str=nama_packing_barang([data.generik, data.nama_barang, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik],null)
                $(this).attr('value',str);
                $('#id_packing_tambah').attr('value',data.id);
                    
        });
        
    })
    function deleteRows(count,el){
        var parent = el.parentNode.parentNode;
        parent.parentNode.removeChild(parent);
        var repackage=$('.repackage-tr');
        var countPenerimaanTr=repackage.length;
        for(var i=0;i<countPenerimaanTr;i++){
            $('.repackage-tr:eq('+i+')').children('td:eq(0)').html(i+1);
            $('.repackage-tr:eq('+i+')').removeClass('even');
            $('.repackage-tr:eq('+i+')').removeClass('odd');
            if((i+1) % 2 == 1){
                $('.repackage-tr:eq('+i+')').addClass('even');
            }else{
                $('.repackage-tr:eq('+i+')').addClass('odd');
            }
        }
        var count = $('.repackage-tr').length;
        var total = 0;
        for(j = 1; j <= count; j++) {
            var total = parseInt($('#hiddenharga'+j).val()) + total;
        }
        $('#total').html(numberToCurrency(total));
    }
    
    function cekJumlah(num){
        var sisa = $('#sisa'+num).html()*1;
        var jumlah = $('#jumlah_kurang'+num).val()*1;
        if(jumlah > sisa){
            alert('jumlah melebihi stok');
            $('#jumlah_kurang'+num).val('');
            $('#total').html('');
            $('#jumlah_kurang'+num).focus();
        }
        
    }
</script>
<script type="text/javascript">
    function cekForm(){
        if($('#packing_tambah').val() == ""){
            alert('Nama barang hasil tidak boleh kosong');
            $('#packing_tambah').focus();
            return false;
        }
        if($('#id_packing_tambah').val() == ""){
            alert('Pilih barang dengan benar, ulangi lagi');
            $('#id_packing_tambah').focus();
            return false;
        }
        if($('#jumlah_tambah').val() == "" || ($('#jumlah_tambah').val()*1) == 0){
            alert('Jumlah tambah tidak boleh kosong');
            $('#jumlah_tambah').focus();
            return false;
        }

      
        //cek form barang
		   var jumlahForm=$('.repackage-tr').length;
        var i=0;
        var isi=false;
        for(i=1;i<=jumlahForm;i++){
            if($('#id_packing_kurang'+i).attr('value')!=""){
               if($('#jumlah_kurang'+i).attr('value')=='' || ($('#jumlah_kurang'+i).attr('value')*1)==0){
                    alert('Jumlah tidak boleh kosong');
                    $('#jumlah_kurang'+i).focus();
                    return false;
                }
                isi=true;
            }
        }
        if(!isi){
            alert('inputan barang masih kosong');
            return false;
        }
    }
</script>
<?= isset($pesan)?$pesan:NULL; ?>
<div class="data-input">
<form action="<?= app_base_url('inventory/control/produksi') ?>" method="post" onsubmit="return cekForm()">
<fieldset>
<legend>Form Produksi</legend>
        <label for="packing_kurang">Packing Barang Hasil</label><input type="text" name="packing_tambah" id="packing_tambah" style="width: 30em"/>
        <input type="hidden" name="id_packing_tambah" id="id_packing_tambah" />
        <label for="packing_kurang">Jumlah</label><input type="text" name="jumlah" id="jumlah_tambah" style="min-width:50px" onkeyup="Desimal(this)" />
</fieldset>
</div>    
<input type="button" value="Tambah" id="addnewrow" />
<div class="data-list tabelflexibel">
    <table class="table-input" style="width:80%" id="repackage">
        <tr>
            <th>No</th>
            <th>Packing Barang Input</th>
            <th>Jumlah</th>
            <th>Satuan</th>
            <th>Sisa</th>
            <th>Harga Jual (Rp.)</th>
            <th>Aksi</th>
        </tr>
    <?php for($i = 1; $i <= 2; $i ++) { ?>
        <tr class="repackage-tr <?=($i%2)?'even':'odd' ?>">
            <td align="center"><?= $i ?></td>
            <td align="center"><input type='text' name='packing_kurang[]' id='packing_kurang<?= $i ?>' size='50' />
                <input type='hidden' name='id_packing_kurang[]' id='id_packing_kurang<?= $i ?>' size='50' /></td>
            <td align="center"><input type="text" name="jumlah_kurang[]" id="jumlah_kurang<?= $i ?>" onkeyup="Desimal(this)" onblur="cekJumlah(<?= $i?>)"/>
                <input type="hidden" id="harga<?= $i ?>" />
                <input type="hidden" name="hiddenharga[]" id="hiddenharga<?= $i ?>" /></td>
            <td align="center" id="kemasan<?= $i ?>"></td>
            <td align="center" id="sisa<?= $i ?>"></td>
            <td align="right" style="width:30%" id="hargajual<?= $i ?>"></td>
            <td align="center"><input type="button" value="Hapus" onclick="deleteRows(<?= $i ?>,this)" /></td>
            </tr>
    <script>initNewRow(<?= $i ?>);</script>
    <div id="show"></div>
    <?php } ?>
    
    </table>
    <table style="width:80%;border-top: none">
        <tr>
        <td align="right" width="75%">Total (Rp)</td>
        <td id="total" align="right" style="font-weight:bold;" width="18%"></td>
        <td width="7%"></td>
    </tr>
    </table>
</div>
    <input type="submit" name="repackage" value="Simpan" /> <input type="button" id="batal" onclick=location.href="<?= app_base_url('inventory/produksi') ?>" value="Batal" />
</form>
<script type="text/javascript">
    var counts =  $('.repackage-tr').length+1;
    $(document).ready(function(){
        $('#addnewrow').click(function() {
        var i = counts++,
        numb = $('.repackage-tr').length+1,
        string = "<tr class='repackage-tr'>"+
            "<td align='center'>"+numb+"</td>"+
            "<td align='center'><input type='text' name='packing_kurang"+i+"' id='packing_kurang"+i+"' size='50' />"+
                "<input type='hidden' name='id_packing_kurang[]' id='id_packing_kurang"+i+"' size='50' /></td>"+
            "<td align='center'><input type='text' name='jumlah_kurang[]' id='jumlah_kurang"+i+"' onkeyup='Desimal(this)' onblur='cekJumlah("+i+")'/>"+
                "<input type='hidden' id='harga"+i+"' /></td>"+
                "<input type='hidden' name='hiddenharga[]' id='hiddenharga"+i+"' />"+
            "<td id='kemasan"+i+"' align='center'></td>"+
            "<td id='sisa"+i+"' align='center'></td>"+
            "<td align='right' id='hargajual"+i+"'></td>"+
            "<td align='center'><input type='button' value='Hapus' onclick='deleteRows("+i+",this)' /></td>"+
        "</tr>";
        $('#repackage').append(string);
        if(i % 2 == 1){
            $('.repackage-tr:eq('+(i-1)+')').addClass('even');
        }else if(i % 2 == 0){
            $('.repackage-tr:eq('+(i-1)+')').addClass('odd');
        }
        initNewRow(i);
        });
    })
</script>