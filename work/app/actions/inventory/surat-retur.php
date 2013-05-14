<?php
  include_once 'app/actions/admisi/pesan.php';
?>

<h2 class="judul">Retur Pembelian</h2><?= isset ($pesan)?$pesan:NULL?>
<?php
require 'app/lib/common/master-data.php';
$list_retur = retur_muat_data();
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
                        value: data[i].id_pasien // nama field yang dicari
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
            $('#idSuplier').attr('value',data.id);
        }
    );
    });

    function initAutocomplete(count){
        $('#nofaktur'+count).unautocomplete().autocomplete("<?= app_base_url('/inventory/search?opsi=nofaktur') ?>",
        {
            extraParams:{
                id_packing: function() { return $('#idpacking'+count).attr('value'); }
            },
            parse: function(data){
                var parsed = [];
                for (var i=0; i < data.length; i++) {
                    parsed[i] = {
                        data: data[i],
                        value: data[i].no_faktur // nama field yang dicari
                    };
                }
                return parsed;
            },
            formatItem: function(data,i,max){
                var str='<div class=result><b>'+data.no_faktur+'</b><br><i>Sulplier:</i> '+data.suplier+' <br/>Tgl. Faktur: '+data.waktu+'</div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.no_faktur);
            $('#nobatch'+count).attr('value', data.batch);
            $('#batch'+count).attr('value',data.batch);
            $('#suplier'+count).attr('value',data.id_suplier);
            }
        );

        $('#barang'+count).unautocomplete().autocomplete("<?= app_base_url('/inventory/search?opsi=packing_barang') ?>",
        {
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
                if(data.kategori=='Obat'){
                    var pabrik='';
                    if(data.generik=='Generik'){
                        pabrik='<br>\n\<b>Pabrik :</b><i>'+data.pabrik+'</i>';
                    }
                    if(data.kekuatan!=null && data.kekuatan!=0){
                        var str='<div class=result><b>'+data.barang+'</b> <i>'+data.sediaan+', '+data.sediaan+' @'+data.nilai_konversi+' '+data.satuan_terkecil+'</i>'+pabrik+'</div>';
                    }else{
                        var str='<div class=result><b>'+data.barang+'</b> <i>' +data.sediaan+' @'+data.nilai_konversi+' '+data.satuan_terkecil+'</i>'+pabrik+'</div>';
                    }
                }else{
                    if(data.kekuatan!=null && data.kekuatan!=0){
                        var str='<div class=result><b>'+data.barang+'</b> <i>'+data.kekuatan+', '+data.sediaan+' @'+data.nilai_konversi+' '+data.satuan_terbesar+'</i></div>';
                    }else{
                        var str='<div class=result><b>'+data.barang+'</b> <i>'+' @'+data.nilai_konversi+' '+data.satuan_terkecil+'</i></div>';
                    }
                }return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $('#satuan_terbesar'+count).html(data.satuan_terbesar);
            $('#idpacking'+count).attr('value', data.id_packing);
            $('#konversi'+count).attr('value', data.nilai_konversi);
            var kekuatan=(data.kekuatan!=null && data.kekuatan!=0)?' '+data.kekuatan+',':'';
            var sediaan=(data.sediaan!=null)?' '+data.sediaan:'';
            var pabrik='';
            if(data.generik=='Generik'){
                pabrik=' '+data.pabrik;
            }
            $(this).attr('value', data.barang+kekuatan+sediaan+' @'+data.nilai_konversi+' '+data.satuan_terkecil+pabrik);
        });

    }
    $(document).ready(function(){
        $("#tambahBaris").click(function(){
             var counter = count++,
            number=$('.barang_tr').length+1,
            string = "<tr class=barang_tr> " +
            "<td align='center'>"+number+"</td> " +
            "<td align='center'><input  style='width:80%' type='text' name='barang["+counter+"][nama]' id='barang"+counter+"' class='auto'> <span class='bintang2'>*</span>" +
                "<input type='hidden' name='barang["+counter+"][noBatch]' id='nobatch"+counter+"' class='auto'> " +
                "<input type='hidden' name='barang["+counter+"][suplier]' id='suplier"+counter+"' class='auto'> " +
            "<td align='center'><input type='text' style='width:80%' name='barang["+counter+"][faktur]' id='nofaktur"+counter+"' class='auto' id='nofaktur"+counter+"'><span class='bintang2'>*</span></td> " +
            "<td align='center'><input size=8 type='text' style='width:80%' name='barang["+counter+"][batch]' id='batch"+counter+"' class='auto'><span class='bintang2'>*</span></td> " +
            "<td align='center'><input type='text' style='width:70%' size=8 name='barang["+counter+"][jumlah]' class='auto'><span class='bintang2'>*</span></td> " +
            "<td align='center' id='satuan_terbesar"+counter+"'></td> " +
            "<td align='center'> " +
            "<select name='barang["+counter+"][alasan]'> " +
            "<option value=''>Pilih alasan</option> " +
            "<option value='Rusak'>Rusak</option> " +
            "<option value='Kadaluarsa'>Kadaluarsa</option></select><span class='bintang2'>*</span></td> " +
            "<td align='center'><input type='button' value='Hapus' class='tombol' onClick='hapusBarang("+counter+",this)' title='Hapus'></td></tr>";
				$("#tblPemesanan").append(string);
				$('.barang_tr:eq('+(number-1)+')').addClass((number % 2 != 0)?'even':'odd');
				initAutocomplete(counter);
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
				$('.barang_tr:eq('+i+')').addClass(((i+1) % 2 != 0)?'even':'odd');
			}
		}
 function cekForm(){
        //cek form barang
        var jumlahForm=$('.barang_tr').length;
        var i=0;
        var isi=false;
        for(i=1;i<=jumlahForm;i++){
            if($('#idpacking'+i).attr('value')!=""){
			if($('#nofaktur'+i).val()==''){
                    alert('No. Faktur tidak boleh kosong')
                    $('#nofaktur'+i).focus();
                    return false;
                }
                if($('#batch'+i).val()==''){
                    alert('No. Batch tidak boleh kosong')
                    $('#batch'+i).focus();
                    return false;
                }
                if($('#jumlah'+i).attr('value')=='' || ($('#jumlah'+i).attr('value')*1)==0){
                    alert('Jumlah tidak boleh kosong');
                    $('#jumlah'+i).focus();
                    return false;
                }
                if($('#alasan'+i).val()==''){
                    alert('Alasan tidak boleh kosong');
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
$noSurat = _select_arr("select (max(id)+1) as id from retur_pembelian");
$noSurat = $noSurat[0]['id'];
if ($noSurat == NULL) {
    $noSurat = 1;
}
?>
<form action="<?= app_base_url('inventory/control/surat-retur') ?>" method="post" onsubmit="return cekForm()">
    <div class="data-input">
        <fieldset><legend>Form Tambah Retur Pembelian</legend>
            <label for="pegawai">Pegawai</label><span style="font-size: 12px;padding-top: 5px;"><?= $_SESSION['nama'] ?></span>
            <label for="no-surat">No. Surat</label><span style="font-size: 12px;padding-top: 5px;"><?= $noSurat ?></span>
        </fieldset>
    </div>
    <div class="field-group">
        <input type="button" class="tombol" value="Tambah Baris" id="tambahBaris"><br />
    </div>
    <table id="tblPemesanan" class="table-input">
        <tr>
          <th width="3%" style="width: 2%">No</th>
          <th width="32%" style="width: 40%">Nama Barang</th>
          <th width="21%" style="width: 10%">No Faktur</th>
          <th width="7%" style="width: 10%">No Batch</th>
          <th width="7%" style="width: 5%">Jumlah</th>
          <th width="9%" style="width: 10%">Kemasan</th>
          <th width="14%" style="width: 15%">Alasan</th>
          <th width="7%" style="width: 10%">Aksi</th>
      </tr>
        <?php for ($i = 1; $i <= 2; $i++) {
        ?>
            <tr class="barang_tr <?= ($i % 2) ? 'even' : 'odd' ?>">
                <td align="center"><?= $i ?></td>
                <td align="center">
                    <input type="text" style='width: 80%' name="barang[<?= $i ?>][nama]" id="barang<?= $i ?>" class="auto"/>
                    <input type="hidden" name="barang[<?= $i ?>][idpacking]" id="idpacking<?= $i ?>" class="auto" />
                    <input type="hidden" name="barang[<?= $i ?>][noBatch]" id="nobatch<?= $i ?>" class="auto">
                    <input type="hidden" name="barang[<?= $i ?>][suplier]" id="suplier<?= $i ?>" class="auto">
					<input type="hidden" name="barang[<?= $i ?>][konversi]" id="konversi<?= $i ?>"><span class="bintang2">*</span>
                </td>
                <td align="center"><input type="text" style='width: 80%' name="barang[<?= $i ?>][nofaktur]" id="nofaktur<?= $i ?>" class="auto"><span class="bintang2">*</span></td>
                <td align="center"><input size=8 style='width: 80%' type="text" name="barang[<?= $i ?>][batch]" id="batch<?= $i ?>" class="auto"><span class="bintang2">*</span></td>
                <td align="center"><input size=8 type="text" style='width: 70%' name="barang[<?= $i ?>][jumlah]" class="auto"><span class="bintang2">*</span></td>
                <td align="center" id="satuan_terbesar<?= $i ?>"></td>
                <td align="center">
                    <select name="barang[<?= $i ?>][alasan]" id="alasan<?= $i?>">
                        <option value="">Pilih alasan</option>
                        <option value="Rusak">Rusak</option>
                        <option value="Kadaluarsa">Kadaluarsa</option>
                    </select><span class="bintang2">*</span>
                </td>
                <td align="center"><input type="button" class="tombol" value="Hapus" onclick="hapusBarang(1,this)"></td>
            </tr>
            <script type="text/javascript">initAutocomplete(<?= $i ?>);</script>
        <? } ?>
    </table>
    <span class="input-process" style="clear:left;float: left;margin: 10px;">
        <input type="submit" value="Simpan" name="save" class="tombol" />
    <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/surat-retur') ?>'" />
    </span>
</form>
<script type="text/javascript">
var count=$('.barang_tr').length+1;
</script>