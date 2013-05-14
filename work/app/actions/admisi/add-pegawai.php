<script type="text/javascript">
    $(function() {
		$('#sipsip').attr('style', 'display: none');
        //$('#nip').focus();
        
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
            $('#kelurahan').attr('value',data.nama_kel+" Kec: "+data.nama_kec);
            $('#idKelurahan').attr('value',data.id_kel);
        });
        $('#nama').autocomplete("<?= app_base_url('/admisi/search?opsi=calon_pegawai') ?>",
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
                        if(data.nama_kel == null){
                            var str='<div class=result>'+data.nama+' <br/> <i>'+data.alamat_jalan+'</i></div>';
                        }else if((data.nama_kel && data.alamat_jalan) == null){
                             var str='<div class=result>'+data.nama+'</div>';
                        }
                        else{
                            var str='<div class=result>'+data.nama+' <br/> <i>'+data.alamat_jalan+' '+data.nama_kel+'</i></div>';
                        }
                        return str;
                    },
                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                    $('#nama').attr('value',data.nama);
                    $('#idpenduduk').attr('value',data.id);
                    $('#almt').attr('value',data.alamat_jalan);
                    $('#kelurahan').attr('value',data.nama_kel);
                    $('#idKelurahan').attr('value',data.id_kelurahan);
                    $('#gol').attr('value',data.gol_darah);
                    $('#tglLahir').attr('value',data.tanggal_lahir);
                    $('#idPkw').attr('value',data.status_pernikahan);
                    $('#idPendidikan').attr('value',data.id_pendidikan_terakhir);
                    $('#namaPkj').attr('value',data.nama_pro);
                    $('#idAgama').attr('value',data.id_agama);
                    $('#no_identitas').attr('value',data.no_identitas);
                    $('#no_kk').attr('value',data.no_kartu_keluarga);
                   // $('#posisi').attr('value',data.posisi_di_keluarga);
                    $('#sip').attr('value',data.sip);
                    $('#no_telp').attr('value',data.no_telp);
                    $('#idProfesi').attr('value',data.id_profesi);
		    $('#idPekerjaan').attr('value',data.id_pekerjaan);
                    $('#idPerkawinan').attr('value',data.status_pernikahan);
                    hitungUmur();
                    if(data.jenis_kelamin == "L") {
                            $('#laki-laki').attr('checked','checked');
                        }
                    else if(data.jenis_kelamin == "P") {
                            $('#perempuan').attr('checked','checked');
                        }
					if (data.id_profesi == 3)
					{
						$('#sipsip').removeAttr('style')
					}
            }
        );
    });
</script>
<?
$level = level_muat_data();
$unit=unit_muat_data();
//$posisi = posisi_keluarga_muat_data();
//$perkawinan = perkawinan_muat_data();
$profesi = profesi_muat_data();
$pekerjaan = pekerjaan_muat_data();
$agama = agama_muat_data();
$pendidikan = pendidikan_muat_data();	
?>
<div class="data-input">
    <form name="formpegawai" action="<?= app_base_url('admisi/control/pegawai') ?>" method="post">
        <fieldset>
            <legend>Form Tambah Data Pegawai</legend>
            <table width=100%>
                <tr>
                    <td valign="top">
                        <label for="nip">NIP *</label><input type="text" name="nip" id="nip" /><input type="hidden" value="tambah" name="tambah"/>
                        <label for="nama">Nama *</label><input type="text" name="nama" id="nama"/>
                        <input type="hidden" name="idpenduduk" id="idpenduduk" />
                        <label for="level">Level *</label>
                        <select name="level">
                            <option value="">Pilih level</option>
                            <?
                            foreach ($level as $row) {
                            ?>
                                <option value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
                            <?
                            }
                            ?>
                        </select>    
                    <!--    <label for="unit">Unit *</label>
                        <select name="unit">
                            <option value="">Pilih unit</option>
                            <?
                           // foreach ($unit['list'] as $row) {
                            ?>
                                <option value="<?//$row['id'] ?>"><?//$row['nama'] ?></option>
                            <?
                            //}
                            ?>
                        </select>   -->
                        <label for="no_identitas">No Identitas *</label> <input name="no_identitas" id="no_identitas" type=text value="">
                        <label for="almt">Alamat Jalan *</label> <input type="text" name="almt" id="almt" value="">
                        <label for="kelurahan">Kelurahan / Desa *</label><input type="text" name="kelurahan" id="kelurahan" value="">
                        <input type="hidden" name="idKelurahan" id="idKelurahan" value="">
                        <fieldset class="field-group">
                            <legend>Jenis Kelamin </legend>&nbsp;
                            <input type="radio" name="jeKel" id="laki-laki" value="L" /><label for="laki-laki" class="field-option" tabindex="1"> Laki-laki</label>
                            <input type="radio" name="jeKel" id="perempuan" value="P" checked="checked" /><label for="perempuan" class="field-option" tabindex="2"> Perempuan</label>
                        </fieldset>
                        <fieldset class="field-group">
                            <label for="tglLahir">Tanggal Lahir</label>
                            <input type="text" name="tglLahir" id="tglLahir" class="tanggal" value="">
                            <label for="umur-tahun" class="inline-title">Umur:</label>
                            <input type="text" id="umur-tahun"  value="" class="umur2" onKeyup="Angka(this)" />
                            <span>Thn</span>
                            <input type="text" id="umur-bulan"  value="" class="umur2" onKeyup="Angka(this)" />
                            <span>Bln</span>
                            <input type="text" id="umur-hari" value="" class="umur2" onKeyup="Angka(this)" />
                            <span>Hr</span>
                        </fieldset>
                    </td>
                    <td valign="top">
                        <label for="no_kk">No. Kartu Keluarga </label> <input type="text" name="no_kk" id="no_kk" value="">
                        <label for="posisi">Posisi di Keluarga </label> <select name="posisi" id="posisi">
                            <option value="">Pilih posisi</option>
                            <option value="Ayah">Ayah</option>
							<option value="Ibu">Ibu</option>
							<option value="Anak">Anak</option>
                        </select>
                            <div id="sipsip"><label for="sip">Nomor SIP </label> <input type="text" name="sip" id="sip" value=""></div>
                            <label for="no_telp">No. Telepon </label><input type="text" name="no_telp" id="no_telp" value="" onkeyup="Angka(this)">
                            <label for="idPdd">Pendidikan Terakhir </label><select name="idPendidikan" id="idPendidikan">
                                <option value="">Pilih pendidikan</option>
                            <? foreach ($pendidikan as $rows): ?>
                                    <option value="<?= $rows['id'] ?>"><?= $rows['nama'] ?></option>
                            <? endforeach; ?>
                                </select>
                                <label for="idPkj">Profesi</label>
                                <select name="idProfesi" id="idProfesi">
                                    <option value="">Pilih profesi</option>
                            <? foreach ($profesi as $rows): ?>
                                        <option value="<?= $rows['id'] ?>"><?= $rows['nama'] ?></option>
                            <? endforeach; ?>
                                    </select>
                                
                                <label for="idPekerjaan">Pekerjaan</label>
                                <select name="idPekerjaan" id="idPekerjaan">
                                    <option value="">Pilih pekerjaan</option>
                                        <? foreach ($pekerjaan['list'] as $rows): ?>
                                                    <option value="<?= $rows['id'] ?>"><?= $rows['nama'] ?></option>
                                        <? endforeach; ?>
                                    </select>
                                <label for="idAgama">Agama </label>
                                    <select name="idAgama" id="idAgama">
                                    <option value="">Pilih Agama</option>
                            <? foreach ($agama['list'] as $rows): ?>
                                            <option value="<?= $rows['id'] ?>"><?= $rows['nama'] ?></option>
                            <? endforeach; ?>
                                        </select>
                                        <label for="idPerkawinan">Perkawinan </label>
                                        <select name="idPerkawinan" id="idPerkawinan">
                                            <option value="">Pilih Status Perkawinan</option>
                                            <option value="Lajang">Lajang</option>
                                            <option value="Menikah">Menikah</option>
                                            <option value="Janda">Janda</option>
                                        </select>
                            <fieldset class="input-process">
                                    <input type="submit" name="tambah" value="Simpan" class="tombol"/>
                                    <input type="button" value="Batal" class="tombol" onclick="javascript:location.href='<?= app_base_url('/admisi/pegawai/') ?>'"/>
                                </fieldset>            
                                        </td>
                                    </tr>
                                </table>
        </fieldset>
    </form>
</div>

