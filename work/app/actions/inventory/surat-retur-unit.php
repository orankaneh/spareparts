<script type="text/javascript">
    function initAutocomplete(count){
        $('#barang'+count).autocomplete("<?= app_base_url('/inventory/search?opsi=barang_unit_retur2') ?>",
        {
            extraParams:{
                noPenerimaan: function() { return $('#penerimaan'+count).attr('value'); }
            },
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
                var str=ac_nama_packing_barang([data.generik, data.nama, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik], ['No Penerimaan',data.no_penerimaan,'Batch',data.batch])
                return str;    
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){

            var harga = (data.hna*data.margin)+(data.hna*1);
            var str=nama_packing_barang([data.generik, data.nama, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik])
            $('#idbarang'+count).attr('value', data.id_packing);
            $('#idpacking'+count).attr('value', data.id_packing);
            $('#detail'+count).attr('value',data.id_detail);
            $('#penerimaanLabel'+count).html(data.no_penerimaan);
            $('#harga'+count).attr('value',harga);
            $(this).attr('value', str);
            $('#kemasan'+count).html(data.satuan_terbesar);
            $('#batch'+count).val(data.batch);
			$('#stok'+count).html(data.sisa);
			$('#jmlstk'+count).val(data.sisa);
            $('#batchLabel'+count).html(data.batch);
        });
    }
	  function cekJumlah(num){
        var sisa = $('#jmlstk'+num).val()*1;
        var jumlah = $('#jumlah'+num).val()*1;
        if(jumlah > sisa){
            alert('stok tidak cukup untuk dipakai');
            $('#jumlah'+num).val('');
            $('#jumlah'+num).focus();
        }
        
    }
	  function cekForm(){
        //cek form barang
		
        var jumlahForm=$('.barang_tr').length;
        var i=0;
        var isi=false;
        for(i=1;i<=jumlahForm;i++){
		var sisa = $('#jmlstk'+i).val()*1;
        var jumlah = $('#jumlah'+i).val()*1;
            if($('#idPacking'+i).attr('value')!=""){
			if($('#jumlah'+i).attr('value')=='' || ($('#jumlah'+i).attr('value')*1)==0){
                    alert('Jumlah tidak boleh kosong');
                    $('#jumlah'+i).focus();
                    return false;
                }
			else if(jumlah > sisa){
                     alert('stok tidak cukup untuk dipakai');
			         $('#jumlah'+i).val('');
                     $('#jumlah'+i).focus();
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
include 'app/actions/admisi/pesan.php';
?>
<h2 class="judul">Retur Unit</h2><? echo isset($pesan) ? $pesan : NULL; ?>
<?
set_time_zone();
$noSurat = _select_arr("select (max(id)+1) as id from retur_unit");
$noSurat = $noSurat[0]['id'];
if ($noSurat == NULL) {
    $noSurat = 1;
}
?>
<form action="<?= app_base_url('inventory/control/surat-retur-unit') ?>" method="post" onSubmit="return cekForm()">
    <div class="data-input">
        <fieldset><legend>Form Tambah Retur</legend>
            <label for="waktu">Tanggal</label><span style="font-size: 12px;padding-top: 5px;"><?=  get_date_now() ?></span>
            <label for="waktu">Pegawai</label><span style="font-size: 12px;padding-top: 5px;"><?= $_SESSION['nama'] ?></span>
            <label for="no-surat">No Transaksi</label><input type="text" name="nosurat" id="no-surat" value="<?= $noSurat ?>" disabled/>
        </fieldset>
    </div>
    <input type="button" value="Tambah Baris" id="tambahBaris" class="tombol"><br />
    <div class="data-list tabelflexibel">
    <table width="950" class="table-input" id="tblPemesanan" style="border: 1px solid #f4f4f4; float: left">
<tr style="background: #F4F4F4;">
      <th width="20">No</th>
      <th width="300">Nama Packing Barang</th>
      <th width="70">No. Penerimaan</th>
      <th >No. Batch</th>
       <th style="width:5%">Stok</th>
      <th width="69">Jumlah</th>
      <th width="100" style="width:100px">Kemasan</th>
      <th width="114">Alasan</th>
      <th width="57">Aksi</th>
      </tr>
        <?php for ($i = 1; $i <= 1; $i++) {
        ?>
            <tr class="barang_tr <?=($i%2==0?'even':'odd')?>">
                <td align="center"><?= $i ?></td>
                <td align="center">
                    <input type="text" name="barang[<?= $i ?>][nama]" id="barang<?= $i ?>" class="auto" size="55" />
                    <input type="hidden" name="barang[<?= $i ?>][idpacking]" id="idpacking<?= $i ?>" class="auto" />
                    <input type="hidden" name="barang[<?= $i ?>][id_detail]" id="detail<?= $i ?>" class="auto" />
                    <input type="hidden" name="barang[<?= $i ?>][batch]" id="batch<?= $i ?>" class="auto" /><sup style="color:#FF0000;">*</sup>
                </td>
                <td align="center" id="penerimaanLabel<?=$i?>"></td>
                <td align="center" id="batchLabel<?=$i?>"></td>
                     <td align="center" id="stok<?=$i?>"></td>
                <td align="center"> <input type="hidden" name="id_stok[]" class="auto" id="jmlstk<?= $i ?>"><input size="5" type="text" name="barang[<?= $i ?>][jumlah]" id="jumlah<?= $i ?>" class="auto" onblur="cekJumlah(<?= $i?>)" onkeyup="Angka(this)" maxlength="11"><sup style="color:#FF0000;">*</sup></td>
                <td align="center" id="kemasan<?= $i ?>"></td>
                <td align="center">
                    <select name="barang[<?= $i ?>][alasan]" class="alasan">
                        <option value="">Pilih alasan</option>
                        <option value="Rusak">Rusak</option>
                        <option value="Kadaluarsa">Kadaluarsa</option>
                        <option value="Tidak Terpakai">Tidak Terpakai</option>
                    </select><sup style="color:#FF0000;">*</sup>
                </td>

                <td align="center"><input type="button" class="tombol" value="Hapus" onclick="hapusBarang(1,this)"></td>
            </tr>
            <script type="text/javascript">initAutocomplete(<?= $i ?>);</script>
        <? } ?>
    </table>
    </div>
<span class="input-process" style="clear:left;float: left;margin: 10px;">
        <input type="submit" value="Simpan" name="save" class="tombol" />
 <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/surat-retur-unit') ?>'" />
    </span>
</form>
<script type="text/javascript">
    var countBarang=$('.barang_tr').length+1;
    var tot=0;
    function hitungTotal(no){
        var harga = $("#harga"+no).val();
        var jumlah=$("#jumlah"+no).val();

        var subtotal=harga*jumlah;
        $("#subtotal"+no).val(subtotal);
        tot = tot + subtotal;
        $("#bayar").html(tot);
        $("#totalBayar").val(tot);
    }
    $(document).ready(function(){
        $('input[name=save]').click(function(event){
            event.preventDefault();
            var row = $('.barang_tr').length;

            for (i = 1; i <= row; i++) {
               if($('#idpacking'+i).attr('value')!=''||i==1){                                  
                   if($('#barang'+i).attr('value')==''){
                       alert("Nama barang tidak boleh kosong !");
                       $('#barang'+i).focus();
                       return false;
                   }else{
                       if(($('#barang'+i).attr('value')!='')&&($('#idpacking'+i).attr('value')=='')){
                          alert("Nama packing barang tidak diketahui !");
                           $('#barang'+i).focus();
                           return false; 
                       }else{
                           for (j = 1;j < i; j++) {
                               if($('#barang'+j).attr('value')==$('#barang'+i).attr('value')){
                                   alert("Nama barang tidak boleh sama !");
                                   $('#barang'+i).focus();
                                   return false;
                               }
                           }
                       }
                   }
                   
                   if($('#jumlah'+i).attr('value')==''){
                       alert("Jumlah tidak boleh kosong !");
                       $('#jumlah'+i).focus();
                       return false;
                   }
                   if($('.alasan').eq(i-1).val()==''){
                       alert("Alasan tidak boleh kosong !");
                       $$('.alasan').eq(i-1).focus();
                       return false;
                   }
               }
            }
            $('input[name=save]').unbind('click').click();
        });
        
        
        $("#tambahBaris").click(function(){
            var counter = countBarang++;
            var number=$('.barang_tr').length+1;
            var string = "<tr class='barang_tr "+((number%2==0)?"even":"odd")+"'>\n\
            <td align='center'>"+number+"</td>\n\
            <td align='center'>\n\
                <input type='text' name='barang["+counter+"][nama]' size=55 id='barang"+counter+"' class='auto'>\n\
                <input type='hidden' name='barang["+counter+"][id_detail]' id='detail"+counter+"' class=auto>\n\
                <input type='hidden' name='barang["+counter+"][idpacking]' id='idpacking"+counter+"' class='auto'' /><input type='hidden' name='barang["+counter+"][batch]' id='batch"+counter+"' class='auto'' /><sup style='color:#FF0000;'>*</sup>\n\
            </td>\n\
			   <td align='center' id='stok"+counter+"'></td>\n\
            <td align='center' id='penerimaanLabel"+counter+"'></td><td align='center' id='batchLabel"+counter+"'></td>\n\
            <td align='center'><input type='text' name='barang["+counter+"][jumlah]' size=5 onkeyup='Angka(this)' maxlength='11' id='jumlah"+counter+"' onblur='hitungTotal("+counter+")' class='auto'><sup style='color:#FF0000;'>*</sup></td>\n\
            <td align='center' id='kemasan"+counter+"'></td>\n\
            <td align='center'>\n\
            <select name='barang["+counter+"][alasan]' class='alasan'>\n\
            <option value=''>Pilih alasan</option>\n\
            <option value='Rusak'>Rusak</option>\n\
            <option value='Kadaluarsa'>Kadaluarsa</option>\n\
			  <option value='Tidak Terpakai'>Tidak Terpakai</option></select>\n\
            <sup style='color:#FF0000;'>*</sup></td>\n\
           <td><input type='button' value='Hapus' class='tombol' align='center' onClick='hapusBarang("+counter+",this)' title='Hapus'></td></tr>";
                       $("#tblPemesanan").append(string);
                       initAutocomplete(counter);
                       counter++;
                   });
               })
               function hapusBarang(count,el){
                   var parent = el.parentNode.parentNode;
                   parent.parentNode.removeChild(parent);
                   var penerimaan=$('.barang_tr');
                   var countPenerimaanTr=penerimaan.length;
                   for(var i=0;i<countPenerimaanTr;i++){
                       $('.barang_tr:eq('+i+')').removeClass('odd');
                       $('.barang_tr:eq('+i+')').removeClass('even');
                       $('.barang_tr:eq('+i+')').addClass(((i+1)%2==0)?'even':'odd');
                       $('.barang_tr:eq('+i+')').children('td:eq(0)').html(i+1);
                   }}

</script>    