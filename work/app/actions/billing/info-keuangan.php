<?php
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';
set_time_zone();
$startDate=(isset($_GET['startDate']))? $_GET['startDate']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
$endDate=(isset($_GET['endDate']))? $_GET['endDate']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
?>
<script type="text/javascript">
    $(function() {
        $('#unit').autocomplete("<?= app_base_url('billing/search?opsi=unit') ?>",
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
                if (data.id_pasien == null){
                    var str='<div class=result>'+data.nama_pas+' <br/> <i>'+data.alamat_jalan+' '+data.nama_kelurahan+'</i></div>';
                }else{
                    var str='<div class=result><b>'+data.id_pasien+'</b> - '+data.nama_pas+' <br/> <i>'+data.alamat_jalan+' '+data.nama_kelurahan+'</i></div>';
                }
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                $(this).attr('value',data.nama);
                
                $('#display').attr('disabled', 'disabled');
            }
        );
        $('#kategori').change(function () {
            
            if ($('#kategori').val() != '') {
                $('#display').removeAttr('disabled', 'disabled');
                $('#param').html('');
            }
            else {
                $('#display').attr('disabled', 'disabled');
                $('#show-report').css({"display":"none"});
            }
            if ($('#kategori').val() == 2) {
                var str = '<label for="instalasi">Unit / Instalasi</label><input type="text" name="unit" id="unit" /> <input type="hidden" name="idunit" id="idunit" />';
                $('#param').html(str);
                $('#display').attr('disabled', 'disabled');
                    $('#unit').autocomplete("<?= app_base_url('billing/search?opsi=unit') ?>",
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
                            var str='<div class=result>'+data.nama+'</div>';
                            return str;
                        },
                        width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                        dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
                    }).result(
                        function(event,data,formated){
                            $(this).attr('value',data.nama);
                            $('#idunit').attr('value',data.id);
                            $('#display').removeAttr('disabled', 'disabled');
                    });
            }
            if ($('#kategori').val() == 3) {
                var str = '<label for="instalasi">Nakes Bidan</label><input type="text" name="nakes" id="nakes" /><input type="hidden" name="idnakes" id="idnakes" />';
                //$('#param').removeAttr('style');
                $('#display').attr('disabled', 'disabled');
                $('#param').html(str);
                $('#nakes').autocomplete("<?= app_base_url('billing/search?opsi=nakes') ?>&id_profesi=6",
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
                            var str='<div class=result>'+data.nama+' <br/> SIP:  <i>'+data.sip+' '+data.profesi+'</i></div>';
                            return str;
                        },
                        width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                        dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
                    }).result(
                        function(event,data,formated){
                            $(this).attr('value',data.nama);
                            $('#idnakes').attr('value',data.id);
                            $('#display').removeAttr('disabled', 'disabled');
                    });
            }
            if ($('#kategori').val() == 4) {
                var str = '<label for="instalasi">Nakes</label><input type="text" name="nakes" id="nakes" /><input type="hidden" name="idnakes" id="idnakes" />';
                //$('#param').removeAttr('style');
                $('#display').attr('disabled', 'disabled');
                $('#param').html(str);
                $('#nakes').autocomplete("<?= app_base_url('billing/search?opsi=nakes') ?>&id_profesi=7",
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
                            var str='<div class=result>'+data.nama+' <br/> SIP:  <i>'+data.sip+' '+data.profesi+'</i></div>';
                            return str;
                        },
                        width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                        dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
                    }).result(
                        function(event,data,formated){
                            $(this).attr('value',data.nama);
                            $('#idnakes').attr('value',data.id);
                            $('#display').removeAttr('disabled', 'disabled');
                    });
            }
            if ($('#kategori').val() == 5) {
                var str = '<label for="instalasi">Apoteker</label><input type="text" name="nakes" id="nakes" /><input type="hidden" name="idnakes" id="idnakes" />';
                //$('#param').removeAttr('style');
                $('#display').attr('disabled', 'disabled');
                $('#param').html(str);
                $('#nakes').autocomplete("<?= app_base_url('billing/search?opsi=nakes') ?>&id_profesi=5",
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
                            var str='<div class=result>'+data.nama+' <br/> SIP:  <i>'+data.sip+' '+data.profesi+'</i></div>';
                            return str;
                        },
                        width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                        dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
                    }).result(
                        function(event,data,formated){
                            $(this).attr('value',data.nama);
                            $('#idnakes').attr('value',data.id);
                            $('#display').removeAttr('disabled', 'disabled');
                    });
            }
        })
        
        $('#display').click(function () {
            $('#show-report').removeAttr('style');
            $('#detail').html("");
            var awal = $('#awal').val();
            var akhir= $('#akhir').val();
            var kategori= $('#kategori').val();
            var nakes   = $('#nakes').val();
            var idnakes = $('#idnakes').val();
            var unit    = $('#idunit').val();
            var nmunit  = $('#unit').val();
            
            $.ajax({
                url: "<?= app_base_url('billing/info-keuangan-tabel') ?>",
                cache: false,
                data:'&startDate='+awal+'&endDate='+akhir+'&kategori='+kategori+'&nakes='+nakes+'&idnakes='+idnakes+'&idunit='+unit+'&unit='+nmunit,
                success: function(msg){
                    $('#show-report').html(msg);
                }
            })
        })

    })

    function getDetail(url,id,specialist,nama){
         $('#detail').removeAttr('style');
            var awal = $('#awal').val();
            var akhir= $('#akhir').val();
            $.ajax({
                url: url,
                cache: false,
                data:'&startDate='+awal+'&endDate='+akhir+'&idPen='+id+'&spesialist='+specialist+'&nama='+nama,
                success: function(msg){
                    $('#detail').html(msg);
                }
          })
    }
</script>
<h1 class="judul"><a href="<?= app_base_url('billing/info-keuangan') ?>">Informasi Keuangan</a></h1>

<div class="data-input pendaftaran">
    <fieldset id="master"><legend>Form Pencarian Informasi Keuangan</legend>
        <fieldset class="field-group">
        <legend>Awal - akhir periode</legend>
            <input type="text" id="awal" name="startDate" value="<?= $startDate ?>" class="tanggal"/>

            <label for="akhir" class="inline-title"> s . d </label>
            <input type="text" id="akhir" name="endDate" value="<?= $endDate ?>" class="tanggal"/>
        </fieldset>
        <label for="filter">Pilih Pencarian</label>
        <select id="kategori" name="kategori">
            <option value="">Pilih berdasar</option>
            <option value="1">Jasa Per Dokter</option>
            <option value="2">Perawat Per Unit</option>
            <option value="3">Jasa Bidan</option>
            <option value="4">Jasa Ahli Gizi</option>
            <option value="5">Jasa Apoteker</option>
            <option value="6">Jasa Ambulance</option>
            <option value="7">Jasa Sewa Alat</option>
        </select>
        <div id="param">
            
        </div>
        <fieldset class="input-process">
            <input type="submit" value="Display" disabled class="tombol" id="display" />
            <input type="button" value="Cancel" class="tombol" onClick=javascript:location.href="<?= app_base_url('billing/info-keuangan')?>" />
        </fieldset>
    </fieldset>
</div>
<div id="show-report">

</div><br><br>
<div id='detail'>

</div>
