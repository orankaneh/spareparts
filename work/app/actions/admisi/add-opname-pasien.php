<?
set_time_zone();
$profesi = profesi_muat_data();
$pekerjaan = pekerjaan_muat_data();
$agama = agama_muat_data();
$pendidikan = pendidikan_muat_data();
$new_number = create_medical_record_number();
$new_number = $new_number['new_number'];
$input = "enable";
?>

<?php echo isset($pesan) ? $pesan : null; ?>
<form action="<?= app_base_url('admisi/control/pasien/add') ?>" method="post" name="formPasien">
    <div class="data-input">
        <fieldset><legend>Form Tambah Opname Pasien</legend>

            <table width="100%">
                <tr>
                    <td valign="top">

                        <input type="hidden" name="no_antri" value="" />
                        <input type="hidden" name="layanan" id="idLayanan"/>
<label for="noRm">No. Rekam Medik</label><input type="text" name="norm"  id="norm" value="<?= noRm($new_number) ?>">
                        <input type="hidden" name="no_rm" id="no_rm">

                        <label for="nama">Nama Lengkap*</label> <input type="text" name="nama" id="nama" <?= $input ?>>
                        <input type="hidden" name="idPenduduk" id="idPenduduk">

                        <label for="alamatJln">Alamat Jalan / RT / RW</label>
                        *
                        <input type="text" name="alamatJln" id="alamatJln" <?= $input ?>>

                        <label for="kelurahan">Desa / Kelurahan</label>
                        <input type="text" name="kelurahan" id="kelurahan" <?= $input ?>>
                        <input type="hidden" name="idKel" id="idKel">
                        <fieldset class="field-group">
                            <legend>Jenis Kelamin </legend>&nbsp;
                            <label for="laki-laki" class="field-option"><input type="radio" name="kelamin" id="laki-laki" value="L" <?= $input ?>> Laki-laki</label>
                            <label for="perempuan" class="field-option"><input type="radio" name="kelamin" id="perempuan" value="P" <?= $input ?>> Perempuan</label>
                        </fieldset>
                        <fieldset class="field-group">
                            <label for="tglLahir">Tanggal lahir</label>
                            <input type="text" id="tglLahir" name="tglLahir" class="tgl" value="" <?= $input ?> />
                            <label for="umur-tahun" class="inline-title">Umur:</label>
                            <input type="text" id="umur-tahun"  value="" class="umur2" onKeyup="Angka(this)" />
                            <span>Thn</span>
                            <input type="text" id="umur-bulan"  value="" class="umur2" onKeyup="Angka(this)" />
                            <span>Bln</span>
                            <input type="text" id="umur-hari" value="" class="umur2" onKeyup="Angka(this)" />
                            <span>Hr</span>
                        </fieldset>
                        <label for="gol">Golongan Darah</label>
                        <select name="gol" id="gol" <?= $input ?>><option value="">Pilih golongan darah</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="AB">AB</option>
                            <option value="O">O</option>
                        </select>
                    </td><td valign="top">
                        <label for="idPkw">Status Perkawinan</label>
                        <select name="idPkw" id="idPkw" <?= $input ?>>
                            <option value="">Pilih status</option>
                            <option value="Lajang">Lajang</option>
                            <option value="Menikah">Menikah</option>
                            <option value="Janda">Janda</option>
                        </select>

                        <label for="pendidikan">Pendidikan Terakhir</label>
                        <select name="pendidikan" id="pendidikan" <?= $input ?>>
                            <option value="">Pilih pendidikan</option>
                            <?php foreach ($pendidikan as $row): ?>
                                <option value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
                            <?php endforeach; ?>
                        </select>

                        <label for="namaPkj">Profesi</label>
                        <select name="profesi" id="profesi" <?= $input ?>>
                            <option value="">Pilih profesi</option>
                            <?php foreach ($profesi as $row): ?>
                                <option value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="namaPkj">Pekerjaan</label>
                        <select name="pekerjaan" id="pekerjaan" <?= $input ?>>
                            <option value="">Pilih pekerjaan</option>
                            <?php foreach ($pekerjaan['list'] as $row): ?>
                                <option value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
                            <?php endforeach; ?>
                        </select>

                        <label for="idAgama">Agama</label>
                        <select name="agama" id="agama" <?= $input ?>>
                            <option value="">Pilih Agama</option>
                            <?php foreach ($agama['list'] as $row): ?>
                                <option value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label>No. Kunjungan*</label><input type="text" name="no_kunjungan" onKeyup="Angka(this)"/>
                        <fieldset class="input-process">
                            <input type="submit" value="Simpan" class="tombol" name="save"  <?= $input ?> />
                            <input type="reset" value="Batal" class="tombol" <?= $input ?> onClick="javascript:location.href='<?= app_base_url('admisi/opname-pasien') ?>'"/>
                        </fieldset>
                    </td></tr></table>
        </fieldset>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $('.cetak').click(function(){
            var win = window.open('print/kartu-antrian?noAntrian='+$('#noAntrian').val()+'&nama='+$('#nama').val()+'&alamatJln='+$('#alamatJln').val()+'&tujuan='+$('#tujuan').val()+'', 'myWindow', 'width=500px, height=500px, scrollbars=1');
        });
        $('form[name=formPasien]').submit(function(event){
            event.preventDefault();
            if ($('input[name=nama]').attr('value') == "") {
                alert("Nama tidak boleh kosong");
                $('input[name=nama]').focus();
                return false;
            }
            if ($('input[name=alamatJln]').attr('value')== "") {
                alert("Alamat jalan tidak boleh kosong");
                $('input[name=alamatJln]').focus();
                return false;
            }
            if ($('input[name=kelurahan]').attr('value') == "") {
                alert("Kelurahan tidak boleh kosong");
                $('input[name=kelurahan]').focus();
                return false;
            }
            if ($('input[name=idKel]').attr('value') == "") {
                alert("Kelurahan harus dari list");
                $('input[name=idKel]').focus();
                return false;
            }
            if ($('input[name=no_kunjungan]').attr('value')== "") {
                alert("No kunjungan tidak boleh kosong");
                $('input[name=no_kunjungan]').focus();
                return false;
            }
            $.ajax({
                url:"<?= app_base_url('admisi/search?opsi=cek_norm') ?>",                        
                data:'q='+$("input[name=norm]").attr('value'),
                cache: false,
                dataType: 'json',
                success: function(msg){
                    if(msg.status){                          
                        $("form[name=formPasien]").unbind('submit').submit();    
                    }else{                            
                        alert("Id pasien sudah ada di database");                
                        $('input[name=norm]').focus();
                    }
                }
            });
        });
    })
    jQuery(document).ready(function(){
        jQuery("#sh-1").hide();
        //jQuery("#subjudul-1").css({"border":"none"});
        jQuery("#sh-2").hide();
        jQuery("#sh-3").hide();
        jQuery("#sh-4").show();
        jQuery("#sh-5").hide();
        jQuery("#sh-6").hide();
    });

    jQuery("#subjudul-1").click(function () {
        jQuery("#sh-1").slideToggle("fast");
    });
    jQuery("#subjudul-2").click(function () {
        jQuery("#sh-2").slideToggle("fast");
    });
    jQuery("#subjudul-3").click(function () {
        jQuery("#sh-3").slideToggle("fast");

    });
    /*jQuery("#subjudul-4").click(function () {
        jQuery("#sh-4").slideToggle("fast");
	
});*/
    jQuery("#subjudul-5").click(function () {
        jQuery("#sh-5").slideToggle("fast");
	
    });
    jQuery("#subjudul-6").click(function () {
        jQuery("#sh-6").slideToggle("fast");
	
    });



    (function(window, $){
        window.hub = function(data) {

            $("input[name=nmKeluarga]").val(data.nm_Keluarga);
            $("input[name=idNmKeluarga]").val(data.id_NmKeluarga);
            $("select[name=hubKeluarga]").val(data.hub_Keluarga);
            $("input[name=alamatK]").val(data.alamat_K);
            $("input[name=ntK]").val(data.nt_K);
        };

    })(window, jQuery);

    $(function() {
        $('#nama').autocomplete("<?= app_base_url('/admisi/search?opsi=calonPasien') ?>",
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
                var str='<div class=result>'+data.nama_pas+' <br/> <i>'+data.alamat_jalan+' '+data.nama_kelurahan+'</i></div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            if(data.id_penduduk!=null || data.id_pasien!=null) {
                $('#idPenduduk').attr('value',data.id_penduduk);
                $('#nama').attr('value',data.nama_pas);
                $('#alamatJln').attr('value',data.alamat_jalan);
                $('#kelurahan').attr('value',data.nama_kelurahan);
                $('#idKel').attr('value',data.id_kelurahan);
                $('#gol').attr('value',data.gol_darah);
                $('#tglLahir').attr('value',data.tanggal_lahir);
                var tglNow = new Date();
                var tanggal=$('#tglLahir').attr('value');
                var elem = tanggal.split('/');
                var tglLahir = new Date(elem[2],elem[1],elem[1]);
                var selisih = Date.parse(tglNow.toGMTString()) - Date.parse(tglLahir.toGMTString());
                var hasil = Math.round(selisih/(1000*60*60*24*365));
                hitungUmur();
                $('#idPkw').attr('value',data.status_pernikahan);
                $('#pendidikan').attr('value',data.id_pendidikan_terakhir);
                $('#profesi').attr('value',data.id_pro);
                $('#pekerjaan').attr('value',data.id_pekerjaan);
                $('#agama').attr('value',data.id_agama);
                if(data.jenis_kelamin == "L") {
                    $('#laki-laki').attr('checked','checked');
                }else if(data.jenis_kelamin == "P") {
                    $('#perempuan').attr('checked','checked');
                }
            }
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
