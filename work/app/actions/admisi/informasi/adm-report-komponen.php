<?php
ob_start();
?>
<script type="text/javascript">
$(function() {
        $('#no-rm').autocomplete("<?= app_base_url('/admisi/search?opsi=noRm') ?>",
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
                var str='<div class=result><b style="text-transform:capitalize">'+data.id_pasien+'</b> <i>Nama: '+data.nama_pas+'</i></div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                $('#no-rm').attr('value',data.id_pasien);
            }
        );
});
$(function() {
        $('#kelurahan').autocomplete("<?= app_base_url('/admisi/search?opsi=kelurahan') ?>",
        {
                    parse: function(data){
                        var parsed = [];
                        for (var i=0; i < data.length; i++) {
                            parsed[i] = {
                                data: data[i],
                                value: data[i].nama_kel // nama field yang dicari
                            };
                        }
                        return parsed;
                    },
                    formatItem: function(data,i,max){
                        var str='<div class=result><b style="text-transform:capitalize">'+data.nama_kel+'</b> <i>Kec: '+data.nama_kec+'<br/> Kab: '+data.nama_kab+' Prov: '+data.nama_pro+'</i></div>';
                        return str;
                    },
                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                $('#kelurahan').attr('value',data.nama_kel);
                $('#idKel').attr('value',data.id_kel);
            }
        );
});

$(document).ready(function(){
    $('.sort-by').css('cursor','pointer');
    $(".sort-by").click(function(){
	$('#option').slideToggle('fast');
    });
    $("#no-rm").attr("disabled","disabled");
    $("#nama").attr("disabled","disabled");
    $("#tipePasien").attr("disabled","disabled");
    $("#laki-laki").attr("disabled","disabled");
    $("#perempuan").attr("disabled","disabled");
    $("#lp").attr("disabled","disabled");
    $("#id-perkawinan").attr("disabled","disabled");
    $("#id-pendidikan").attr("disabled","disabled");
    $("#id-pekerjaan").attr("disabled","disabled");
    $("#id-agama").attr("disabled","disabled");
    $("#kelurahan").attr("disabled","disabled");
    $("#idKel").attr("disabled","disabled");
    $("#id-kunjungan").attr("disabled","disabled");
    $("#id-pembiayaan").attr("disabled","disabled");
    $("#id-perujuk").attr("disabled","disabled");
    $("#idPerujuk").attr("disabled","disabled");
    $("#option").hide();
    
    $("input[name=option1]").click(function() {
        if ($('input[name=option1]').attr("checked")) {
            $("#no-rm").removeAttr("disabled","disabled");
        } else {
            //$("#no-rm").hide("fast");
            $("#no-rm").attr("disabled","disabled");
        }

    });
    $("input[name=option2]").click(function() {
        if ($('input[name=option2]').attr("checked")) {
            $("#nama").removeAttr("disabled","disabled");
        } else {
            $("#nama").attr("disabled","disabled");
        }

    });
    $("input[name=option3]").click(function() {
            
        if ($('input[name=option3]').attr("checked")) {
            $("#tipePasien").removeAttr("disabled","disabled");
            
            
        } else {
            $("#tipePasien").attr("disabled","disabled");
            
        }

    });
    $("input[name=option4]").click(function() {
        if ($('input[name=option4]').attr("checked")) {
            $("#laki-laki").removeAttr("disabled","disabled");
            $("#perempuan").removeAttr("disabled","disabled");
            $("#lp").removeAttr("disabled","disabled");
        } else {
            $("#laki-laki").attr("disabled","disabled");
            $("#perempuan").attr("disabled","disabled");
            $("#lp").attr("disabled","disabled");
        }

    });
    $("input[name=option5]").click(function() {
        if ($('input[name=option5]').attr("checked")) {
            $("#id-perkawinan").removeAttr("disabled","disabled");
        } else {
            $("#id-perkawinan").attr("disabled","disabled");
        }

    });
    $("input[name=option6]").click(function() {
        if ($('input[name=option6]').attr("checked")) {
            $("#id-pendidikan").removeAttr("disabled","disabled");
        } else {
            $("#id-pendidikan").attr("disabled","disabled");
        }

    });
    $("input[name=option7]").click(function() {
        if ($('input[name=option7]').attr("checked")) {
            $("#id-pekerjaan").removeAttr("disabled","disabled");
        } else {
            $("#id-pekerjaan").attr("disabled","disabled");
        }

    });
    $("input[name=option8]").click(function() {
        if ($('input[name=option8]').attr("checked")) {
            $("#id-agama").removeAttr("disabled","disabled");
        } else {
            $("#id-agama").attr("disabled","disabled");
        }

    });
    $("input[name=option9]").click(function() {
        if ($('input[name=option9]').attr("checked")) {
            $("#kelurahan").removeAttr("disabled","disabled");
            $("#idKel").removeAttr("disabled","disabled");
        } else {
            $("#kelurahan").attr("disabled","disabled");
            $("#idKel").attr("disabled","disabled");
        }

    });
    $("input[name=option10]").click(function() {
        if ($('input[name=option10]').attr("checked")) {
            $("#id-kunjungan").removeAttr("disabled","disabled");
        } else {
            $("#id-kunjungan").attr("disabled","disabled");
        }

    });
    $("input[name=option11]").click(function() {
        if ($('input[name=option11]').attr("checked")) {
            $("#id-pembiayaan").removeAttr("disabled","disabled");
        } else {
            $("#id-pembiayaan").attr("disabled","disabled");
        }

    });
    $("input[name=option12]").click(function() {
        if ($('input[name=option12]').attr("checked")) {
            $("#id-perujuk").removeAttr("disabled","disabled");
        } else {
            $("#id-perujuk").attr("disabled","disabled");
        }

    });
});

</script>

<div id="option">

    <label for="nama"><input type="checkbox" name="option2" id="nama-pasien" value="1">
           Nama Pasien</label>
        <input type="text" name="nama" id="nama">
    


    
        <label for="tipePasien"><input type="checkbox" name="option3" value="1"> Tipe pasien</label>
        <select name="tipepas" id="tipePasien">
            <option value="1">Baru</option>
            <option value="2">Lama</option>
        </select>
        
    

    <fieldset class="field-group">
        <legend><input type="checkbox" name="option4" value="1"> Jenis Kelamin</legend>
            
        <label for="laki-laki" class="field-option"><input type="radio" name="jeKel" value="L" id="laki-laki"> Laki-laki</label>
        <label for="perempuan" class="field-option"><input type="radio" name="jeKel" value="P" id="perempuan"> Perempuan</label>
        
        
    </fieldset>

    <label for="id-perkawinan"><input type="checkbox" name="option5" value=1"> Status Perkawinan</label>
    
        <select name="idPerkawinan" id="id-perkawinan">
            <option value="">Semua status</option>
        <?php foreach (perkawinan_get_for_selection() as $key => $value): ?>
            <option value="<?php echo $key ?>"><?php echo $value ?></option>
        <?php endforeach ?>
        </select>
    

    <label for="id-pendidikan"><input type="checkbox" name="option6" value="1"> Pendidikan</label>
    
        <select name="idPendidikan" id="id-pendidikan">
            <option value="all">Semua pendidikan</option>
        <?php foreach (pendidikan_get_for_selection() as $key => $value): ?>
            <option value="<?php echo $key ?>"><?php echo $value ?></option>";
        <?php endforeach ?>
        </select>
    

    <label for="id-pekerjaan"><input type="checkbox" name="option7" value="1"> Pekerjaan</label>
    
        <select name="idPekerjaan" id="id-pekerjaan">
            <option value="all">Semua pekerjaan</option>
        <?php foreach (profesi_get_for_selection() as $key => $value): ?>
            <option value="<?php echo $key ?>"><?php echo $value ?></option>
        <?php endforeach ?>
        </select>
    

    <label for="idAgama"><input type="checkbox" name="option8" value="1"> Agama</label>
    <select name="idAgama" id="id-agama"><option value="all">Semua agama</option>
    <?php foreach (agama_get_for_selection() as $key => $value): ?>
        <option value="<?php echo $key ?>"><?php echo $value ?></option>
    <?php endforeach ?>
    </select>
    

    <label for="kelurahan"><input type="checkbox" name="option9" value="1"> Desa / Kelurahan </label>
    
        <input type="text" name="kelurahan" id="kelurahan" />
        <input type="hidden" name="idKel" id="idKel" />
    

    <label for="id-kunjungan"><input type="checkbox" name="option10" value="1"> Tujuan Kunjungan </label>
    
        <select name="idKunjungan" id="id-kunjungan">
            <option value="all">Pilih Kunjungan..</option>
        <?php foreach (instalasi_get_for_selection() as $key => $value): ?>
            <option value="<?php echo $key ?>"><?php echo $value ?></option>
        <?php endforeach ?>
        </select>
    

    <label for="id-pembiayaan"><input type="checkbox" name="option11" value="1"> Cara Pembiayaan </label>
    
        <select name="idPembiayaan" id="id-pembiayaan">
            <option value="1">biaya sendiri</option>
            <option value="2">asuransi</option>
            <option value="3">charity</option>
        </select>
    

   <label for="id-perujuk"><input type="checkbox" name="option12" value="1"> Nama Perujuk </label>
   
        <input type="text" name="perujuk" id="id-perujuk" class="form" />
        <input type="hidden" name="idPerujuk" id="idPerujuk" value="" />
   
</div>
   
<? echo ob_get_clean(); ?>