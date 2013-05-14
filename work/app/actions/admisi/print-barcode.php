<script type="text/javascript">
 $(function() {
        $('#barang').autocomplete("<?= app_base_url('/inventory/search?opsi=namabarang') ?>",
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
                          var str='';
            var str=ac_nama_packing_barang([data.generik, data.nama_barang, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik], null)
return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            var str=nama_packing_barang([data.generik, data.nama_barang, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik], null)

$(this).attr('value', str);
            $('#idPacking').attr('value',data.id);
            $('#barcode').attr('value',data.barcode);
            if(data.barcode == ""){
               for(var i=data.id.length;i<11;i++){
                    data.id='0'+data.id;
               } 
               $('#stikerBarcode').html(data.id) 
            }else{
               $('#stikerBarcode').html(data.barcode) 
            }
        }
    );
    });
</script>    
<h2 class="judul">Cetak Barcode Barang</h2>
<div class="data-input">
    <fieldset>
       <label for="barang">Nama Barang</label><input type="text" id="barang" class="nama_barang">
       <label for="idPacking">Id Packing Barang</label><input type="text" id="idPacking" readonly>
       <label for="barcode">Barcode</label><input type="text" id="barcode" readonly>
       <fieldset class="field-group">
       <label for="stiker">Sticker Barcode</label><span id="stikerBarcode" style="font-size: 24px;padding-top: 5px;font-family: 'barcode';"></span>
       </fieldset>
       <fieldset class="field-group">
       <label for="jumlah">Jumlah Cetak</label><input type="text" id="jumlahCetak" class="tgl">
       </fieldset>
       <fieldset class="input-process">
           <input type="button" class="cetaks tombol" value="Cetak">
           <input type="button" class="tombol" value="Batal" onClick="javascript:location.href='<?= app_base_url('admisi/print-barcode')?>'">
       </fieldset>
    </fieldset>
</div>    
<script type="text/javascript">
    $(document).ready(function(){
        $(".cetaks").click(function(){
            var win = window.open('report/print-barcode?idPacking='+$('#idPacking').val()+'&jumlah='+$('#jumlahCetak').val()+'&barang='+$('#barang').attr('value'), 'MyWindow', 'width=800px,height=600px,scrollbars=1');
        })
    })
</script>  