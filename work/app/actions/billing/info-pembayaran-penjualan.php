<?php
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';
set_time_zone();
$startDate=(isset($_GET['startDate']))? $_GET['startDate']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
$endDate=(isset($_GET['endDate']))? $_GET['endDate']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
?>
<script type="text/javascript">
    $(function() {
        $('#petugas').autocomplete("<?= app_base_url('billing/search?opsi=petugas') ?>",
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
                var str='<div class=result>'+data.nama+' <br/> NIP: <i>'+data.nip+'</i> Unit: <i>'+data.unit+'</i></div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                $(this).attr('value',data.nama);
                $('#idpetugas').attr('value',data.id)
        })
        $('#pembeli').autocomplete("<?= app_base_url('billing/search?opsi=pembeli') ?>",
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
                var str='<div class=result>'+data.nama+' <br/> '+data.alamat_jalan+', '+data.kelurahan+'</div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                $(this).attr('value',data.nama);
                $('#idpembeli').attr('value',data.id);
                
        })
        $('#display').click(function () {
            var awal    = $('#awal').val();
            var akhir   = $('#akhir').val();
            var petugas = $('#idpetugas').val();
            var pembeli = $('#idpembeli').val();
            $.ajax({
                url: "<?= app_base_url('billing/info-pembayaran-penjualan-tabel') ?>",
                cache: false,
                data: 'startDate='+awal+'&endDate='+akhir+'&idpetugas='+petugas+'&idpembeli='+pembeli,
                success: function (msg) {
                    $('.show').html(msg);
                }
            })
        })
    })
</script>
<h2 class="judul">Pembayaran Penjualan</h2>
<div class="data-input pendaftaran">
    <fieldset id="master"><legend>Form Pencarian Informasi Pembayaran Penjualan</legend>
        <fieldset class="field-group">
        <legend>Awal - akhir periode</legend>
            <input type="text" id="awal" name="startDate" value="<?= $startDate ?>" class="tanggal"/>

            <label for="akhir" class="inline-title"> s . d </label>
            <input type="text" id="akhir" name="endDate" value="<?= $endDate ?>" class="tanggal"/>
        </fieldset>
        <label for="petugas">Petugas</label><input type="text" name="petugas" id="petugas" /><input type="hidden" name="idpetugas" id="idpetugas" />
        <label for="pembeli">Pembeli</label><input type="text" name="pembeli" id="pembeli" /><input type="hidden" name="idpembeli" id="idpembeli" />
        <fieldset class="input-process">
            <input type="submit" value="Display" class="tombol" id="display" />
            <input type="button" value="Cancel" class="tombol" onClick=javascript:location.href="<?= app_base_url('billing/info-pembayaran-penjualan')?>" />
        </fieldset>
    </fieldset>
</div>

<div class="data-list show">
    
</div>