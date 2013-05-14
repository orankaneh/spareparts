<script type="text/javascript">
    $(document).ready(function(){
        $('#barangAsal').focus();
    })
    $(function() {
        $('#barangAsal').autocomplete("<?= app_base_url('/inventory/search?opsi=packing_barang_stok') ?>",
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
                    var batch=null;                    
                    if(data.batch==null || data.batch==''){
                        batch = ['No. Batch :','-'];
                    }else
                        batch = ['No. Batch :',data.batch];                 
                }
                var str=ac_nama_packing_barang([data.generik, data.barang, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik], batch)
                
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            var hnaHasil = (data.hna/data.nilai_konversi);
            var hppHasil = (data.hpp/data.nilai_konversi);
            var str=nama_packing_barang([data.generik, data.barang, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik],null)
            var batch=(data.batch!=null && data.batch!='')?' No. Batch: '+data.batch:'';
            $(this).attr('value', str+batch);
            $('#stokAsal').val(data.stok);
            $('#idBarangAsal').val(data.id_barang);
			$('#batchasal').val(data.batch);
            $('#sisaAsal').html(data.sisa);
            $('.kemasanAsal').html(data.satuan_terbesar);
            $('.hnaAsal').html(numberToCurrency2(data.hna));
            $('.hppAsal').html(numberToCurrency2(data.hpp));
            $('#barangHasil').removeAttr('disabled');
            $('#konversi').val(data.nilai_konversi);
            $('.hnaHasil').html(numberToCurrency2(hnaHasil));
            $('.hppHasil').html(numberToCurrency2(hppHasil));
            $('#hnaHasil').val(hnaHasil);
            $('#hppHasil').val(hppHasil);
			$('#batchHasil').val(data.batch);
            $('#idSatuanTerkecil').val(data.id_satuan_terkecil);
        });
        
        $('#barangHasil').autocomplete("<?= app_base_url('/inventory/search?opsi=namabarang3') ?>",
        {
            extraParams:{
                id_barang: function(){return $('#idBarangAsal').val()},
                id_satuan_terbesar: function(){return $('#idSatuanTerkecil').val()},
		        		batch: function(){return $('#batchasal').val()}
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
                var batch;
                if(data.kategori=='Obat'){
                    var pabrik='';
                    if(data.generik=='Generik'){
                        pabrik='<br>\n\<b>Pabrik :</b><i>'+data.pabrik+'</i>';
                    }
                    if(data.sediaan==null){
                        data.sediaan='';
                    }
                    if(data.kekuatan!=null && data.kekuatan!=0){
                        var str='<div class=result><b>'+data.nama_barang+'</b> <i>'+data.kekuatan+', '+data.sediaan+' @'+data.nilai_konversi+' '+data.satuan_terkecil+'</i>'+pabrik+'</div>';
                    }else{
                        var str='<div class=result><b>'+data.nama_barang+'</b> <i>' +data.sediaan+' @'+data.nilai_konversi+' '+data.satuan_terkecil+'</i>'+pabrik+'</div>';
                    }
                }else{
                    if(data.kekuatan!=null && data.kekuatan!=0){
                        var str='<div class=result><b>'+data.nama_barang+'</b> <i>'+data.kekuatan+', '+data.sediaan+' @'+data.nilai_konversi+' '+data.satuan_terkecil+'</i></div>';
                    }else{
                        var str='<div class=result><b>'+data.nama_barang+'</b> <i>'+' @'+data.nilai_konversi+' '+data.satuan_terkecil+'</i></div>';
                    }
                }return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            var kekuatan=(data.kekuatan!=null && data.kekuatan!=0)?' '+data.kekuatan+',':'';
            var sediaan=(data.sediaan!=null)?' '+data.sediaan:'';
            var pabrik='';
            if(data.generik=='Generik'){
                pabrik=' '+data.pabrik;
            }
            $(this).attr('value', data.nama_barang+kekuatan+sediaan+' @'+data.nilai_konversi+' '+data.satuan_terkecil+pabrik);
            $('#kemasanHasil').html(data.satuan_terkecil);
            $('#idPackingHasil').val(data.id);
        });
     });   
     
     function cekJumlah(){
         var sisaAsal = $('#sisaAsal').html()*1,
         jumlahAsal = $('#jumlahAsal').val()*1,
         konversi = $('#konversi').val()*1;
         ;
         
         if(jumlahAsal>sisaAsal){
             alert('Jumlah repackage maksimal'+sisaAsal);
             $('#jumlahAsal').val('');
             return false;
         }else{
             var hasilKali = jumlahAsal * konversi;
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
         if($('#jumlahAsal').val() == ""){
             alert('Jumlah barang asal tidak boleh kosong');
             $('#jumlahAsal').focus();
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
             $('#jumlahAsal').val('');
             $('#jumlahHasil').val('');
             $('#kemasanHasil').html('');
             $('#jumlahHasilDisplay').html('');
             $('#barangHasil').focus();
             return false;
         }
     }
</script>
<form action="<?= app_base_url('inventory/control/repackage')?>" method="POST" onSubmit="return cekForm()">
<div class="data-input">
    <fieldset>
        <legend>Form Repackage</legend>
            <label>Packing Barang Asal*</label>
              <input type="text" name="barangAsal" id="barangAsal" style="width: 35em"/>
              <input type="hidden" name="stokAsal" id="stokAsal" />
              <input type="hidden" name="idBarangAsal" id="idBarangAsal" />
              <input type="hidden" name="idSatuanTerkecil" id="idSatuanTerkecil" />
                   <input type="hidden" name="batchasal" id="batchasal" />
            <fieldset class="field-group">
                <label>Harga Jual (Rp.)</label>
                <span style="font-size: 11px;padding-top: 5px" class="hnaAsal"></span>
            </fieldset>
            <fieldset class="field-group">
                <label>Harga  Beli (Rp.)</label>
                <span style="font-size: 11px;padding-top: 5px" class="hppAsal"></span>
            </fieldset>  
            <fieldset class="field-group">  
              <label>Sisa Stok Barang Asal</label>
              <span style="font-size: 11px;padding-top: 5px;margin-right: 5px" id="sisaAsal"></span>
              <span style="font-size: 11px;padding-top: 5px" class="kemasanAsal"></span>
            </fieldset>  
            <label>Packing Barang Hasil*</label>
              <input type="text" name="barangHasil" id="barangHasil" disabled="disabled" style="width: 30em"/>
              <input type="hidden" name="idPackingHasil" id="idPackingHasil" />
              <input type="hidden" id="konversi" />
            <fieldset class="field-group">
                <label>Harga Jual(Rp.)</label>
                <span style="font-size: 11px;padding-top: 5px" class="hnaHasil"></span>
                <input type="hidden" name="hnaHasil" id="hnaHasil">
            </fieldset>
            <fieldset class="field-group">
                <label>Harga  Beli (Rp.)</label>
                <span style="font-size: 11px;padding-top: 5px" class="hppHasil"></span>
                <input type="hidden" name="hppHasil" id="hppHasil">
            </fieldset>  
            <fieldset class="field-group">
                <label>No. Batch</label>      
                <input name="batchHasil" type="text" id="batchHasil" readonly="readonly"/>
            </fieldset>  
            <fieldset class="field-group">
              <label>Jumlah Asal*</label>
              <input type="text" name="jumlahAsal" id="jumlahAsal" class="tgl" onkeyup="Desimal(this)" onBlur="return cekJumlah(this)"/>
              <span style="font-size: 11px;padding-top: 5px" class="kemasanAsal"></span>
              <label>Jumlah Hasil</label>
              <span style="font-size: 11px;padding-top: 5px;margin-right: 5px" id="jumlahHasilDisplay"></span>
              <span style="font-size: 11px;padding-top: 5px" id="kemasanHasil"></span>
              <input type="hidden" name="jumlahHasil" id="jumlahHasil" class="tgl" readonly="readonly"/>
            </fieldset>
    </fieldset>
</div>
<div class="field-group">
    <input type="submit" value="Simpan" name="save" class="tombol" />
    <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/repackage') ?>'"/>
</div>
</form>