<h2 class="judul">Retur Penjualan</h2>
<script type="text/javascript">
  $(function(){
      $('#nama').focus();
  })
</script>

<script type="text/javascript">

function hitungTotal(no){
     var tot=0;
    var temp=0;
    var harga = currencyToNumber($("#harga"+no).val());
    var jumlah=$("#jumlah"+no).val();
    var subtotal=harga*jumlah;
    //console.log(harga);
    $("#subtotal"+no).val(numberToCurrency(titikKeKoma(Math.round(subtotal*100)/100)));
    $('.barang_tr td:nth-child(8) input').each(function(){
        temp=currencyToNumber($(this).val());
        if(!isNaN(temp)&&temp!=""){
            tot=tot+temp;
        }        
        //console.log($(this).val());
    });
    
    //tot = tot + subtotal;
    $("#bayar").html(numberToCurrency(titikKeKoma(Math.round(tot*100)/100)));
    //$("#bayar").html(numberToCurrency(titikKeKoma(tot)));
    $("#totalBayar").val(tot);
}    
    function initAutocomplete(count){
            $('#barang'+count).autocomplete("<?= app_base_url('/inventory/search?opsi=penjualan_barang_retur')?>",
            {
                extraParams:{
                   no_faktur: function(){return $('#nofaktur'+count).val();},
                   id_penduduk: function(){return $('#idpenduduk').val();}
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
                        $('#iddetail'+count).attr('value', '');
                        var str=ac_nama_packing_barang([data.generik, data.nama, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik], new Array('No Nota :',data.no_faktur));
                        return str;  
                    },
                    cache:false,
                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
           }).result(
            function(event,data,formated){
                var harga = titikKeKoma(Math.round((parseFloat(data.hna*data.margin/100)+parseFloat(data.hna))*100)/100);
                $('#jumlahPenjualan'+count).html(data.jumlah_penjualan);
                $('#idbarang'+count).attr('value', data.id_packing);
                $('#iddetail'+count).attr('value', data.id_detail);
                $('#idpacking'+count).attr('value', data.id_packing);
				 $('#batch'+count).attr('value', data.batch);
                $('#noNota'+count).attr('value',data.no_faktur);
                $('#harga'+count).attr('value',numberToCurrency(harga));   
                var str=nama_packing_barang([data.generik, data.nama, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik]);
                $(this).attr('value', str);
            });
    }
    $(document).ready(function(){
        $('.barang_tr td:nth-child(5)').children('input').keyup(function(){
            var jmlh=$(this).val();
            if(parseInt(jmlh)>parseInt($(this).parent().prev().html())){                
                //$(this).val(jmlh.substr(0,jmlh.length-1));                
                alert('Jumlah melebihi jumlah penjualan');
                $(this).val('');
            }
            
        });
        
        $("#tambahBaris").click(function(){
            var counter = $('.barang_tr').length+1,
            string = "<tr class=barang_tr>"+
            "<td align='center'>"+counter+"</td>"+
            "<td align='center'><input style='width: 95%' type='text' name='barang["+counter+"][nama]' id='barang"+counter+"' class='auto'>"+
            "<input type='hidden' name='barang["+counter+"][iddetail]' class='auto' id='iddetail"+counter+"'></td>"+
            "<td align='center'><input type='text' id='noNota"+counter+"' name='barang["+counter+"][noNota]' class='auto'></td>"+
            "<td align='center' id='jumlahPenjualan"+counter+"'></td>"+
            "<td align='center'><input type='text' name='barang["+counter+"][jumlah]' onkeyup='Desimal(this)' id='jumlah"+counter+"' onblur='hitungTotal("+counter+")' class='auto'></td>"+
            "<td align='center'>"+
            "<select name='barang["+counter+"][alasan]'>"+
            "<option value=''>Pilih alasan</option>"+
            "<option value='Rusak'>Rusak</option>"+
            "<option value='Kadaluarsa'>Kadaluarsa</option>"+
			"<option value='Obat Tidak Terpakai'>Obat Tidak Terpakai</option></select>"+
            "</td><td align='center'><input type='text' name='barang["+counter+"][harga]' id='harga"+counter+"'></td></td>"+
            "<td align='center'><input type='text' name='barang["+counter+"][subtotal]' id='subtotal"+counter+"'></td><td align='center'><input type='button' value='Hapus' class='tombol' onClick='hapusBarang("+counter+",this)' title='Hapus'></td></tr>";
            $("#tblPemesanan").append(string);
            $('.barang_tr:eq('+(counter-1)+')').addClass((counter % 2 == 0)?'even':'odd');
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
          $('.barang_tr:eq('+i+')').children('td:eq(0)').html(i+1);
          $('.barang_tr:eq('+i+')').removeClass('even');
          $('.barang_tr:eq('+i+')').removeClass('odd');
          $('.barang_tr:eq('+i+')').addClass(((i+1) % 2 == 0)?'even':'odd');
      }}
$(function() {    
    $('#nama').autocomplete("<?= app_base_url('/inventory/search?opsi=nama') ?>",
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
  function cekForm(){
        //cek form barang
        var jumlahForm=$('.barang_tr').length;
        var i=0;
        var isi=false;
        for(i=1;i<=jumlahForm;i++){
            if($('#idpacking'+i).attr('value')!=""){
                if($('#noNota'+i).val()==''){
                    alert('No. nota tidak boleh kosong')
                    $('#noNota'+i).focus();
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
$noSurat=  _select_arr("select (max(id)+1) as id from retur_penjualan");
$noSurat=$noSurat[0]['id'];
if($noSurat == NULL){
    $noSurat = 1;
}

?>
<form action="<?= app_base_url('inventory/control/surat-retur-penjualan') ?>" method="post" onsubmit="return cekForm()">
<div class="data-input">
    <fieldset><legend>Form Tambah Retur Penjualan</legend>
        <label for="pegawai">Pegawai</label><span style="font-size: 12px;padding-top: 5px;"><?= $_SESSION['nama']?></span>
        <label for="no-surat">No. Surat</label><span style="font-size: 12px;padding-top: 5px;"><?=$noSurat?></span><input type="hidden" name="nosurat" id="no-surat" value="<?=$noSurat?>" disabled/>
        <label for="pembeli">Pembeli</label><input type="text" id="nama"><input type="hidden" name="pembeli" id="idpenduduk">
    </fieldset>
</div>    
<input type="button" value="Tambah Baris" id="tambahBaris" class="tombol"><br />
<div class="data-list tabelflexibel">
<table id="tblPemesanan" width="100%" class="table-input" style="border: 1px solid #f4f4f4; float: left">
    <tr style="background: #F4F4F4;">
        <th>No</th>
        <th style="width: 25%">Nama Packing Barang</th>
        <th>No. Nota</th>
        <th>Jumlah Penjualan</th>
        <th>Jumlah</th>
        <th>Alasan</th>
        <th>Harga</th>
        <th>Sub Total</th>
        <th>Aksi</th>
    </tr>
     <?php for ($i = 1; $i <= 2; $i++) { ?>
    <tr class="barang_tr <?=($i%2==1)?'odd':'even'?>">
        <td align="center"><?= $i?></td>
        <td align="center">
           <input style="width: 95%" type="text" name="barang[<?=$i?>][nama]" id="barang<?= $i ?>" class="auto" />
          <input type="hidden" name="barang[<?=$i?>][iddetail]" id="iddetail<?= $i ?>" class="auto" />
          <input type="hidden" name="barang[<?=$i?>][idpacking]" id="idpacking<?= $i ?>" class="auto" />
          <input type="hidden" name="barang[<?=$i?>][batch]" id="batch<?= $i ?>" class="auto" />
        </td>
        <td align="center"><input type="text" name="barang[<?= $i?>][noNota]" id="noNota<?= $i?>" class="auto"></td>
        <td align="center" id="jumlahPenjualan<?= $i?>"></td>
        <td align="center"><input type="text" name="barang[<?= $i?>][jumlah]" id="jumlah<?= $i?>" onkeyup="Desimal(this)" class="auto" onblur="hitungTotal(<?= $i ?>)"></td>
        <td align="center">
            <select name="barang[<?= $i?>][alasan]" id="alasan<?= $i?>">
                <option value="">Pilih alasan</option>
                <option value="Rusak">Rusak</option>
                <option value="Kadaluarsa">Kadaluarsa</option>
				<option value="Obat Tidak Terpakai">Obat Tidak Terpakai</option>
            </select>    
        </td>
        <td align="center"><input type="text" name="barang[<?= $i?>][harga]" id="harga<?= $i?>"></td>
        <td align="center"><input type="text" name="barang[<?= $i?>][subtotal]" id="subtotal<?= $i?>"></td>
        <td align="center"><input type="button" class="tombol" value="Hapus" onclick="hapusBarang(1,this)"></td>
    </tr>
    <script type="text/javascript">initAutocomplete(<?=$i?>);</script>
    <?}?>
</table>    
<span style="position: relative;float: left;clear: left;padding-top: 10px;left: 730px">
    <table>
        <tr>
            <td>Total</td><td>: <input type="hidden" name="total" id="totalBayar"></td><td width="110px" id="bayar">-</td>
        </tr>
    </table>
    </div>
</span>    
 <span class="input-process" style="clear:left;float: left;margin: 10px;">
     <input type="submit" value="Simpan" name="save" class="tombol" />
  <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/surat-retur-penjualan') ?>'" />
 </span>
</form>

