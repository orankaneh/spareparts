<h2 class="judul">Penerimaan Retur Unit</h2>
<?php
require 'app/lib/common/master-data.php';
require 'app/lib/common/master-inventory.php';
require 'app/actions/admisi/pesan.php';
$pesan = isset ($pesan)?$pesan:"";
echo "$pesan";
?>
<script type="text/javascript">
    function initAutocomplete(count){
        $('#barang'+count).autocomplete("<?= app_base_url('/inventory/search?opsi=penerimaan_unit_retur') ?>",
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
                  var str=ac_nama_packing_barang([data.generik, data.nama, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik], ['Batch',data.batch]);                  
                  return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            var harga = (data.hna*data.margin)+(data.hna*1);
            $('#idbarang'+count).attr('value', data.id_packing);
            $('#idpacking'+count).attr('value', data.id_packing);
            $('#penerimaan'+count).attr('value',data.id_penerimaan);
            $('#harga'+count).attr('value',harga);
            var str=nama_packing_barang([data.generik, data.nama, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik]);
            $(this).attr('value', str);
            $('#kemasan'+count).html(data.satuan_terbesar);
            $('#jumlah_retur'+count).html(data.jumlah_retur);
            $('#batch'+count).html(data.batch);
			$('#nobatch'+count).attr('value',data.batch);
			
        });
        
//         $('#batch'+count).autocomplete("<?= app_base_url('/inventory/search?opsi=batch_penerimaan_unit_retur') ?>",
//        {   
//            extraParams:{
//                id_packing: function() { return $('#idpacking'+count).val(); 
//                }
//            },
//            parse: function(data){
//                var parsed = [];
//                for (var i=0; i < data.length; i++) {
//                    parsed[i] = {
//                        data: data[i],
//                        value: data[i].batch // nama field yang dicari
//                    };
//                }
//                return parsed;
//            },
//            formatItem: function(data,i,max){
//                  return "<div class='result'>"+data.batch+"</div>";
//            },
//            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
//            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
//        }).result(
//        function(event,data,formated){
//           $(this).val(data.batch);
//        });
    }
    
    function cekForm(){
        //cek form barang
        var jumlahForm=$('.barang_tr').length;
        var i=0;
        var isi=false;
        for(i=1;i<=jumlahForm;i++){
            if($('#idpacking'+i).attr('value')!=""){
                if($('#nobatch'+i).val()==''){
                    alert('No. Batch tidak boleh kosong')
                    $('#nobatch'+i).focus();
                    return false;
                }
                if($('#jumlah'+i).attr('value')=='' || ($('#jumlah'+i).attr('value')*1)==0){
                    alert('Jumlah tidak boleh kosong');
                    $('#jumlah'+i).focus();
                    return false;
                }
                if($('#alasan'+i).val()==''){
                    alert('Alasan pemusnahan tidak boleh kosong');
                    $('#alasan'+i).focus();
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
<?
set_time_zone();
$noSurat = _select_arr("select (max(id)+1) as id from penerimaan_retur_unit");
$noSurat = $noSurat[0]['id'];
if ($noSurat == NULL) {
    $noSurat = 1;
}
?>
<form action="<?= app_base_url('inventory/control/penerimaan-retur-unit-control') ?>" method="post" onSubmit="return cekForm()">
    <div class="data-input">
        <fieldset><legend>Form Tambah Retur</legend>
            <label for="waktu">Tanggal</label><span style="font-size: 12px;padding-top: 5px;"><?= date('d-m-Y') ?></span>
            <label for="waktu">Pegawai</label><span style="font-size: 12px;padding-top: 5px;"><?= $_SESSION['nama'] ?></span>
            <label for="no-surat">No Transaksi</label><input type="text" name="nosurat" id="no-surat" value="<?= $noSurat ?>" disabled/>
        </fieldset>
    </div>
    <input type="button" value="Tambah Baris" id="tambahBaris" class="tombol"><br /><br />
    <div class="data-list tabelflexibel">
    <table id="tblPemesanan" class="table-input" style="border: 1px solid #f4f4f4; float: left">
        <tr style="background: #F4F4F4;">
            <th>No</th>
            <th>Nama Packing Barang</th>
            <th>No. Batch</th>
            <th>Jumlah Retur</th>
            <th>Jumlah Penerimaan</th>
            <th style="width:120px">Kemasan</th>
            <th>Alasan</th>
            <th>Aksi</th>
        </tr>
        <?php for ($i = 1; $i <= 2; $i++) {
        ?>
            <tr class="barang_tr <?= ($i % 2) ? 'even' : 'odd' ?>">
                <td align="center"><?= $i ?></td>
                <td align="center">
                    <input type="text" name="barang[<?= $i ?>][nama]" id="barang<?= $i ?>" class="auto" style="width:30em;" /><span class='bintang2'>*</span>
                    <input type="hidden" name="barang[<?= $i ?>][idpacking]" id="idpacking<?= $i ?>" class="auto" />
                       <input type="hidden" name="barang[<?= $i ?>][nobatch]" id="nobatch<?= $i ?>" class="auto" />
                
                 
                </td>
<!--                <td align="center"><input type="text" name="barang[<?= $i ?>][batch]" id="batch<?= $i ?>" class="auto"><span class='bintang2'>*</span></td>-->
                <td align="center" id="batch<?= $i ?>"> </td>
                <td align="center" id="jumlah_retur<?= $i ?>"></td>
                <td align="center"><input size="5" type="text" name="barang[<?= $i ?>][jumlah]" id="jumlah<?= $i ?>" class="auto" onblur="hitungTotal(<?= $i ?>)" onkeyup="Desimal(this)"><span class='bintang2'>*</span></td>
                <td align="center" id="kemasan<?= $i ?>"></td>
                <td align="center">
                    <select name="barang[<?= $i ?>][alasan]" id="alasan<?= $i?>">
                        <option value="">Pilih alasan</option>
                        <option value="Rusak">Rusak</option>
                        <option value="Kadaluarsa">Kadaluarsa</option>
                         <option value="Tidak Terpakai">Tidak Terpakai</option>
                    </select><span class='bintang2'>*</span>
                </td>

                <td align="center"><input type="button" class="tombol" value="Hapus" onclick="hapusBarang(1,this)"></td>
            </tr>
            <script type="text/javascript">initAutocomplete(<?= $i ?>);</script>
        <? } ?>
    </table>
    </div>
    <span class="input-process" style="clear:left;float: left;margin: 10px;">
        <input type="submit" value="Simpan" name="save" class="tombol" />
    <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/penerimaan-retur-unit') ?>'" />
    </span>
</form>
<script type="text/javascript">
    var countBarang=$('.barang_tr').length+1;
    var tot=0;
    function hitungTotal(no){
//        var harga = $("#harga"+no).val();
//        var jumlah=$("#jumlah"+no).val();
//        var subtotal=harga*jumlah;
//        $("#subtotal"+no).val(subtotal);
//        tot = tot + subtotal;
//        $("#bayar").html(tot);
//        $("#totalBayar").val(tot);
           var juml_retur =  $("#jumlah_retur"+no).html();
           var jumlah=$("#jumlah"+no).val();
           if(jumlah>juml_retur){
                $("#jumlah"+no).val('');
               alert('jumlah penerimaan melebihi jumlah retur');
           }
    }
    $(document).ready(function(){
        $("#tambahBaris").click(function(){
            var number = countBarang++;
            var counter=$('.barang_tr').length+1;
            var string = "<tr class=barang_tr> "+
                "<td align='center'>"+counter+"</td> "+
                "<td align='center'><input type='text' name='barang["+number+"][nama]' id='barang"+number+"' class='auto' class=auto style='width:30em;'><span class='bintang2'>*</span> <input type='hidden' name='barang["+number+"][idpacking]' id='idpacking"+number+"' class='auto' /><input type='hidden' name='barang["+number+"][nobatch]' id='nobatch"+number+"' class='auto' />"+
                "</td> "+
                 "<td align='center' id='batch"+number+"'></td> "+
                  "<td align='center' id='jumlah_retur"+number+"'></td> "+
                "<td align='center'><input size='5' type='text' name='barang["+number+"][jumlah]' onkeyup='Desimal(this)' id='jumlah"+number+"' onblur='hitungTotal("+number+")' class='auto'><span class='bintang2'>*</span></td> "+
                "<td align='center' id='kemasan"+number+"'></td> "+
                "<td align='center'> "+
                "<select name='barang["+number+"][alasan]' id='alasan"+number+"'> "+
                "<option value=''>Pilih alasan</option> "+
                "<option value='Rusak'>Rusak</option> "+
                "<option value='Kadaluarsa'>Kadaluarsa</option> "+
				"<option value='Tidak Terpakai'>Tidak Terpakai</option>"+
				"</select><span class='bintang2'>*</span> "+
                "</td> "+
                "<td><input type='button' value='Hapus' class='tombol' onClick='hapusBarang("+number+",this)' title='Hapus'></td></tr>";
			
            $("#tblPemesanan").append(string);
            if (counter % 2 == 1) {
                $('.barang_tr:eq('+(counter-1)+')').addClass('even');
            }else{
                $('.barang_tr:eq('+(counter-1)+')').addClass('odd');
            }
			
            initAutocomplete(number);
            counter++;
        });
    })
    function hapusBarang(count,el){
        var parent = el.parentNode.parentNode;
        parent.parentNode.removeChild(parent);
        var penerimaan=$('.barang_tr');
        var countPenerimaanTr=penerimaan.length;
        for(var i=0;i<countPenerimaanTr;i++){
            $('.barang_tr:eq('+i+')').children('td:eq(0)').html(i+1);
            $('.barang_tr:eq('+i+')').removeClass('even');
            $('.barang_tr:eq('+i+')').removeClass('odd');
            if((i+1) % 2 == 1){
                $('.barang_tr:eq('+i+')').addClass('even');
            }else{
                $('.barang_tr:eq('+i+')').addClass('odd');
            }
        }}
				   
					
    $(function() {
        $('#nama').autocomplete("<?= app_base_url('/admisi/search?opsi=nama') ?>",
        {
            parse: function(data){
                var parsed = [];
                for (var i=0; i < data.length; i++) {
                    parsed[i] = {
                        data: data[i],
                        value: data[i].nama_pas // nama field yang dicari
                    };
                }
                return parsed;
            },
            formatItem: function(data,i,max){
                if (data.id_pasien == null) {
                    var str='<div class=result>'+data.nama_pas+' <br/> <i>'+data.alamat_jalan+' '+data.nama_kelurahan+'</i></div>';
                } else {
                    var str='<div class=result><b>'+data.id_pasien+'</b> - '+data.nama_pas+' <br/> <i>'+data.alamat_jalan+' '+data.nama_kelurahan+'</i></div>';
                }
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.nama_pas);
            $('#idpenduduk').attr('value',data.id_penduduk);
        }
    );
    });

</script>    