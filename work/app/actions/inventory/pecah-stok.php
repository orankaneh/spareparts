<script type="text/javascript">
    $(document).ready(function(){
        $('#barangAsal').focus();
    })
    $(function() {
        $('#batchHasil').autocomplete("<?= app_base_url('inventory/search?opsi=no_batch_stok_untuk_pecah_stok') ?>",
        { 
            extraParams:{
                id_packing: function() { return $("#idBarangAsal").val(); 
                }
            }, 
            parse: function(data){
                var parsed = [];
                for (var i=0; i < data.length; i++) {
                    parsed[i] = {
                        data: data[i],
                        value: data[i].batch // nama field yang dicari
                    };
                }
                return parsed;
            },
            formatItem: function(data,i,max){
              return "<div class=result>"+data.batch+"</div>";
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(function(event,data,formated){
              $('#batchHasil').val(data.batch);
              $('#edHasil').val(data.ed);
              $('#stokAsal').val(data.id);
              $('#sisaAsal').html(data.sisa);
              $('.kemasanAsal').html(data.satuan_terbesar);
        });
       
        $('#barangAsal').autocomplete("<?= app_base_url('/inventory/search?opsi=pecah-stok') ?>",
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
                var str=ac_nama_packing_barang([data.generik, data.barang, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik])
                
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            var hnaHasil = (data.hna/data.nilai_konversi);
            var hppHasil = (data.hpp/data.nilai_konversi);
            var str=nama_packing_barang([data.generik, data.barang, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik],null)
            $(this).attr('value', str);
            $('#idBarangAsal').val(data.id_barang);
            $('#idPackingHasil').val(data.id_barang);
            $('.hnaAsal').html(numberToCurrency2(data.hna));
            $('.hppAsal').html(numberToCurrency2(data.hpp));
            $('#barangHasil').val(str);
            $('#konversi').val(data.nilai_konversi);
            $('.marginAsal').html(data.margin);
            $('.hnaHasil').html(numberToCurrency2(hnaHasil));
            $('.hppHasil').html(numberToCurrency2(hppHasil));
            $('#hnaAsal').val(data.hna);
            $('#hppAsal').val(data.hpp);
            $('#idSatuanTerkecil').val(data.id_satuan_terkecil);
            $('#batchHasil').removeAttr("disabled");
        });
        
        });
 
     function cekJumlah(){
         var sisaAsal = $('#sisaAsal').html()*1,
         jumlah_yang_akan_di_pecah = $('#jumlah_yang_akan_di_pecah').val()*1,
         konversi = $('#konversi').val()*1;
         ;
         
         if(jumlah_yang_akan_di_pecah>sisaAsal){
             alert('Jumlah pecah stok maksimal \''+sisaAsal+'\'');
             $('#jumlah_yang_akan_di_pecah').val('');
             return false;
         }else{
             var hasilKali = jumlah_yang_akan_di_pecah * konversi;
             $('#jumlahHasil').val(hasilKali);
             $('#jumlahHasilDisplay').html(hasilKali);
         }
     }
     
     function cekForm(){
         if($('#barangAsal').val() == ""){
             alert('Barang asal tidak boleh kosong');
             $('#barangAsal').focus();
             return false;
         }
         if($('#stokAsal').val() == ""){
             alert('Pilih barang asal dengan benar');
             $('#barangAsal').focus();
             return false;
         }
         if($('#barangHasil').val() == ""){
             alert('Barang hasil tidak boleh kosong');
             $('#barangHasil').focus();
             return false;
         }
         if($('#jumlah_yang_akan_di_pecah').val() == ""){
             alert('Jumlah barang asal tidak boleh kosong');
             $('#jumlah_yang_akan_di_pecah').focus();
             return false;
         }
         if($('#batchHasil').val() == ""){
             alert('No. Batch barang hasil tidak boleh kosong');
             $('#batchHasil').focus();
             return false;
         }
         if($('#stokAsal').val() == $('#stokHasil').val()){
             alert('Tidak boleh me-repackage barang yang sama');
             $('#barangHasil').val('');
             $('#stokHasil').val('');
             $('#jumlah_yang_akan_di_pecah').val('');
             $('#jumlahHasil').val('');
             $('#kemasanHasil').html('');
             $('#jumlahHasilDisplay').html('');
             $('#barangHasil').focus();
             return false;
         }
     }
</script>
<form action="<?= app_base_url('inventory/control/pecah-stok')?>" method="POST" onSubmit="return cekForm()">
<div class="data-input">
    <fieldset>
      <legend>Form Pecah Stok</legend>
       
            <label>Packing Barang Asal*</label>
              <input type="text" name="barangAsal" id="barangAsal" style="width: 35em"/>
              <input type="hidden" name="stokAsal" id="stokAsal" />
              <input type="hidden" name="idBarangAsal" id="idBarangAsal" />
              <input type="hidden" name="idSatuanTerkecil" id="idSatuanTerkecil" />
      
            <fieldset class="field-group">
                <label>No. Batch</label>      
                <input type="text" name="batchHasil" id="batchHasil" disabled="disabled" />
            </fieldset> 
            <fieldset class="field-group">
                <label>E.D.</label>      
                <input type="text" name="edHasil" id="edHasil"/>
            </fieldset> 
            <fieldset class="field-group">
            <label>Harga Jual (Rp.)</label>
                <span style="font-size: 11px;padding-top: 5px" class="hnaAsal"></span>
            </fieldset>
            <fieldset class="field-group">
                <label>Harga Beli (Rp.)</label>
                <span style="font-size: 11px;padding-top: 5px" class="hppAsal"></span>
              <input type="hidden" name="hnaAsal" id="hnaAsal">
            </fieldset>
			<fieldset class="field-group">
                <label>Margin</label>
                <span style="font-size: 11px;padding-top: 5px" class="marginAsal"></span>
              <input type="hidden" name="hppAsal" id="hppAsal">
            </fieldset>  
            <fieldset class="field-group">  
              <label>Sisa Stok</label>
              <span style="font-size: 11px;padding-top: 5px;margin-right: 5px" id="sisaAsal"></span>
              <span style="font-size: 11px;padding-top: 5px" class="kemasanAsal"></span>
            </fieldset>  
            <label>Packing Barang Hasil*</label>
              <input type="text" name="barangHasil" id="barangHasil" readonly="readonly" style="width: 30em"/>
              <input type="hidden" name="idPackingHasil" id="idPackingHasil" />
              <input type="hidden" id="konversi" /> 
            <fieldset class="field-group">
              <label>Jumlah</label>
              <input type="text" name="jumlah_yang_akan_di_pecah" id="jumlah_yang_akan_di_pecah" class="tgl" onkeyup="Desimal(this)" onBlur="return cekJumlah(this)"/>
              <span style="font-size: 11px;padding-top: 5px" class="kemasanAsal"></span>
            </fieldset>
      </fieldset>
</div>
<div class="field-group">
    <input type="submit" value="Simpan" name="save" class="tombol" />
    <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/repackage') ?>'"/>
</div>
</form>