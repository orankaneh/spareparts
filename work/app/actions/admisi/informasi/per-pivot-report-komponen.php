<script type="text/javascript">
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
                        width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                        dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
                function(event,data,formated){
                    $('#kelurahan').attr('value',data.nama_kel);
                    $('#idKel').attr('value',data.id_kel);
                }
            );
       });
    </script>
<script type="text/javascript">
        $(function() {
            $('#perujuk').autocomplete("<?= app_base_url('/admisi/search?opsi=rujukan') ?>",
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
                            var str='<div class=result><b style="text-transform:capitalize">'+data.nama+'</b></div>';
                            return str;
                        },
                        width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                        dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
                function(event,data,formated){
                    $('#perujuk').attr('value',data.nama);
                    $('#idPerujuk').attr('value',data.id);
                }
            );
       });
    </script>
<script type="text/javascript">
        $(function() {
            $('#kecamatan').autocomplete("<?= app_base_url('/admisi/search?opsi=kecamatan') ?>",
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
                            var str='<div class=result><b style="text-transform:capitalize">'+data.nama+'</b> </div>';
                            return str;
                        },
                        width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                        dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
                function(event,data,formated){
                    $('#kecamatan').attr('value',data.nama);
                    $('#idKec').attr('value',data.id);
                }
            );
       });
    </script>
<script type="text/javascript">
        $(function() {
            $('#kabupaten').autocomplete("<?= app_base_url('/admisi/search?opsi=kabupaten') ?>",
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
                            var str='<div class=result><b style="text-transform:capitalize">'+data.nama+'</b> </div>';
                            $('#idKab').removeAttr('value','');
                            return str;
                        },
                        width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                        dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
                function(event,data,formated){
                    $('#kabupaten').attr('value',data.nama);
                    $('#idKab').attr('value',data.id);
                }
            );
       });
    </script>
<script type="text/javascript">
        $(function() {
            $('#provinsi').autocomplete("<?= app_base_url('/admisi/search?opsi=provinsi') ?>",
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
                            var str='<div class=result><b style="text-transform:capitalize">'+data.nama+'</b> </div>';
                            $('#idPro').removeAttr('value','');
                            return str;
                        },
                        width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                        dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
                function(event,data,formated){
                    $('#provinsi').attr('value',data.nama);
                    $('#idPro').attr('value',data.id);
                }
            );
       });
</script>
<script type="text/javascript">
  $(function() {
        $('#nama').autocomplete("<?= app_base_url('/admisi/search?opsi=pasien') ?>",
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
                        //if (data.id_pasien == null) {
                        //var str='<div class=result>'+data.nama_pas+' <br/> <i>'+data.alamat_jalan+' '+data.nama_kelurahan+'</i></div>';
                        //} else {
                        //var str='<div class=result><b>'+data.id_pasien+'</b> - '+data.nama_pas+' <br/> <i>'+data.alamat_jalan+' '+data.nama_kelurahan+'</i></div>';
                        var str='<div class=result><b>'+data.id+'</b> - '+data.nama+' <br/> <i>';
                            str+=data.alamat_jalan==null?'-':data.alamat_jalan;
                            str+=' ';
                            str+=data.kelurahan==null?'-':data.kelurahan;
                            str+='</i></div>';
                        //}
                        return str;
                    },
                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                    $('#nama').attr('value',data.nama);
                    
            }
        );
});
</script>
<script type="text/javascript">
$(function() {
        $('#noRm').autocomplete("<?= app_base_url('/admisi/search?opsi=noRm') ?>",
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
                        var str='<div class=result>'+data.id_pasien+' '+data.nama_pas+'</div>';
                        return str;
                    },
                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                $('#noRm').attr('value',data.id_pasien);                
            }
        );
});
</script>
<?php
require_once "app/actions/admisi/informasi/adm-report-func.php";
require_once 'app/lib/common/master-data.php';
$idLap = isset($_GET['idLap'])?$_GET['idLap']:NULL;
$kategori = isset($_GET['kategori'])?$_GET['kategori']:NULL;

if ($idLap == 2) { ?>
    <fieldset class="field-group">
        <legend>Jenis Kelamin</legend>
        <label class="field-option"><input type='radio' name='jeKel' value='L'> Laki-laki</label>
        <label class="field-option"><input type='radio' name='jeKel' value='P'> Perempuan</label>
        <label class="field-option"><input type='radio' name='jeKel' value='LP' checked="checked"> Semua </label>
    </fieldset>
<?php exit;}

if ($idLap == 3) { ?>
    
<label for="idPkw">Status Perkawinan</label>
        <select name='idPkw'><option value="ss">Semua status</option>
        <?php foreach (perkawinan_get_for_selection() as $key => $value): ?>
            <option value="<?php echo $key ?>"><?php echo $value ?></option>
        <?php endforeach ?>
        </select>
<?php exit;}
if ($idLap == 4) { ?>

    <label for="idPdd">Pendidikan</label>
        <select name='idPdd' id="idPdd"><option value="sp">Semua pendidikan</option>
        <?php foreach (pendidikan_get_for_selection() as $key => $value): ?>
            <option value="<?php echo $key ?>"><?php echo $value ?></option>';
        <?php endforeach ?>
        </select>
    
<?php exit;}

if ($idLap == 13) { ?>
    <fieldset class="field-group">
        <legend>Tipe Pasien</legend>
        <label class="field-option"><input type='radio' name='tipePas' value='1'> Pasien Lama</label>
        <label class="field-option"><input type='radio' name='tipePas' value='2'> Pasien Baru</label>
        <label class="field-option"><input type='radio' name='tipePas' value='3' checked="checked"> Semua Pasien</label>
    </fieldset>
<?php exit;}
if($idLap == 15){?>
    
<?php    
exit;}
if ($idLap == 5) { ?>
    <label>Pekerjaan</label>
    
        <select name='idPkj'><option value="spk">Semua pekerjaan</option>
        <?php foreach (pekerjaan_get_for_selection() as $key => $value): ?>
            <option value="<?php echo $key ?>"><?php echo $value ?></option>
        <?php endforeach ?>
        </select>
    
<?php exit;}
if ($idLap == 16) { ?>
    <label>Profesi</label>
    
        <select name='idPrf'><option value="spk">Semua profesi</option>
        <?php foreach (profesi_get_for_selection() as $key => $value): ?>
            <option value="<?php echo $key ?>"><?php echo $value ?></option>
        <?php endforeach ?>
        </select>
    
<?php exit;}
if ($idLap == 6) { ?>
   <label for="idAgm">Agama</label>
    <select name='idAgm' id="idAgm"><option value="sa">Semua agama</option>
    <?php foreach (agama_get_for_selection() as $key => $value): ?>
        <option value="<?php echo $key ?>"><?php echo $value ?></option>
    <?php endforeach ?>
    </select>
<?php exit;}

if ($idLap == 7) { ?>

    <label for="kelurahan">Desa / Kelurahan</label>
    <input type='text' name='kelurahan' id="kelurahan" class='form' />
    <input type='hidden' name='idKel' id='idKel' value="all" />
    
<?php exit;}

if ($idLap == 8) { ?>
    <label for="kecamatan">Kecamatan</label>
        <input type='text' name='kecamatan' id="kecamatan" class='form' />
        <input type='hidden' name='idKec' id='idKec' value="all" />
    
<?php exit;}

if ($idLap == 9) { ?>

    <label for="kabupaten">Kabupaten</label>
    
        <input type='text' name='kabupaten' id="kabupaten" class='form' />
        <input type='hidden' name='idKab' id='idKab' value="all" />
    
<?php exit;}

if ($idLap == 10) { ?>
    <label for="provinsi">Provinsi</label>
    
        <input type='text' name='propinsi' id="provinsi" class='form' />
        <input type='hidden' name='idProp' id='idPro' value="all" />
    
<?php exit;}

if ($idLap == 11) { ?>
    <label for="idKun">Layanan</label>
    
        <select name='idKun' id="idKun"><option value="st">Semua Layanan</option>
        <?php 
            foreach (layanan_muat_data () as $key => $row): 
                if ($row['bobot'] == 'Tanpa Bobot') $bobot = "";
			else $bobot = $row['bobot'];
			
		if ($row['profesi'] == 'Tanpa Profesi') $profesi = "";
		else $profesi = $row['profesi'];
		
		$spesialisasi = "";
		if ($row['spesialisasi'] == 'Tanpa Spesialisasi') $spesialiasi= "";
		else $spesialisasi = $row['spesialisasi'];
		
		if ($row['instalasi'] == 'Tanpa Instalasi') $instalasi= "";
		else if ($row['instalasi'] == 'Semua') $instalasi = "";
		else $instalasi = $row['instalasi'];
		
		
		$layanans = "$row[nama] $profesi $spesialisasi $bobot $instalasi";
                ?>
            <option value="<?php echo $row['id'] ?>"><?php echo $layanans ?></option>
        <?php endforeach ?>
        </select>
    
<?php exit;}

if ($idLap == 12) { ?>
    <label for="idPem">Cara Pembayaran</label>
    
        <select name='idPem' id="idPem">
       		<option value="charity">Charity</option>
       		<option value="bs">Biaya Sendiri</option>
        </select>
    
<?php exit;}
if ($idLap == 14) { ?>
    <label for="perujuk">Nama Perujuk</label>
    
        <input type='text' name='perujuk' id="perujuk" class='form' />
        <input type='hidden' name='idPerujuk' id='idPerujuk' value="all" />
    
<?php exit;}

if($kategori == 1){?>
  <label for="nama">Nama</label>
  <input type='text' name='key' id="nama" class='form'/>
<?php exit;}

if($kategori == 2){?>
    <label for="norm">No. RM</label>
    <input type='text' name='key' id="noRm" class="key"/>
<?php exit;}  

if($idLap == 15){?>
    <label for="norm">Asuransi Produk</label>
    <input type='text' name='key' id="asuransi" class="key"/><input type="hidden" name="id_asuransi" id="idAsuransi">
    
    
    <script type="text/javascript">
        $(document).ready(function(){
            $('#asuransi').autocomplete("<?= app_base_url('/admisi/search?opsi=asuransiProduk') ?>",
            {
                parse: function(data){
                    var parsed = [];
                    for (var i=0; i < data.length; i++) {
                        parsed[i] = {
                            data: data[i],
                            value: data[i].nama_asuransi// nama field yang dicari
                        };
                    }
                    return parsed;
                },
                formatItem: function(data,i,max){
                    var str='<div class=result>'+data.nama_asuransi+' <br/><i><b>'+data.nama_pabrik+'</b> '+data.nama_kelurahan+'</i></div>';
                    return str;
                },
                width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
            function(event,data,formated){
                $(this).attr('value',data.nama_asuransi);
                $('#idAsuransi').attr('value',data.id_asuransi);
            });
        });
    </script>
<?php exit;}else{
   exit; 
}  
?>
