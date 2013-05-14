<script type="text/javascript">
$(function() {
        $('#nip').focus();
        
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
    });
</script>
<?php
$pegawai = pegawai_muat_data($_GET['id'],NULL,NULL);
$level = level_muat_data();
$unit=unit_muat_data();
$penduduk = penduduk_muat_data($_GET['id'], NULL, NULL, NULL, NULL, NULL);
//$penduduk = $penduduk['list'][0];
$profesi = profesi_muat_data();
$pekerjaaan = pekerjaan_muat_data();
$agama = agama_muat_data();
$pendidikan = pendidikan_muat_data();
?>
<div class="data-input">
        <form name="formpegawai" action="<?= app_base_url('admisi/control/pegawai') ?>" method="post">
            <input type="hidden" name="idpegawai" id="idpegawai" value="<?= $pegawai['id'] ?>">
            <input type="hidden" name="edit" value="edit"/>
            <fieldset>
                <legend>Form Edit Data Pegawai</legend>
                <table width=100%>
                    <tr>
                        <td valign="top">
                         <?
                            foreach ($pegawai['list'] as $row) {
                            ?>
                            <label for="nip">NIP*</label><input type="text" name="nip" id="nip" value="<?= $pegawai['nip'] ?>"/>
                            <label for="nama">Nama*</label><input type="text" name="nama" id="nama" value="<?= $penduduk['nama'] ?>" />
                            <input type="hidden" name="idpenduduk" id="idpenduduk" id="nama" value="<?= $_GET['id'] ?>"/>
                            <label for="level">Level*</label>
                            <select name="level">
                                <option value="">Pilih level</option>
                            <?
							}
                            foreach ($level as $row) {
                            ?>
                                <option value="<?= $row['id'] ?>" <?= ($row['id'] == $pegawai['id_level']) ? 'selected' : '' ?>><?= $row['nama'] ?></option>
                            <?
                            }
                            ?>
                        </select>
                           <!-- <label for="unit">Unit*</label>
                            <select name="unit">
                                <option value="">Pilih unit</option> -->
                            <?						
                           // foreach ($unit['list'] as $row) {
                            ?>
                             <option value="<? // $row['id'] ?>" <? //($row['id'] == $pegawai['id_unit']) ? 'selected' : '' ?>><? ///$row['nama'] ?></option>
                            <?
                            //}
                            ?>
                        </select>
                        <label for="no_identitas">No Identitas* </label> <input name="no_identitas" id="no_identitas" type=text id="nama" value="<?= $penduduk['no_identitas'] ?>">
                        <label for="almt">Alamat Jalan* </label> <input type="text" name="almt" id="almt" id="nama" value="<?= $penduduk['alamat_jalan'] ?>">
                        <label for="kelurahan">Kelurahan / Desa *</label><input type="text" name="kelurahan" id="kelurahan" id="nama" value="<?= $penduduk['nama_kel'] ?>">
                        <input type="hidden" name="idKelurahan" id="idKelurahan" id="nama" value="<?= $penduduk['id_kelurahan'] ?>">
                        <fieldset class="field-group">
                            <legend>Jenis Kelamin </legend>&nbsp;
                            <label for="laki-laki" class="field-option"><input type="radio" name="jeKel" id="laki-laki" value="L" <?= ($penduduk['jenis_kelamin'] == 'L') ? 'checked' : '' ?>> Laki-laki</label>
                            <label for="perempuan" class="field-option"><input type="radio" name="jeKel" id="perempuan" value="P" <?= ($penduduk['jenis_kelamin'] == 'P') ? 'checked' : '' ?>> Perempuan</label>
                        </fieldset>
                        <fieldset class="field-group">
                            <label for="tglLahir">Tanggal Lahir</label>
                            <input type="text" name="tglLahir" id="tglLahir" value="<?= datefmysql($penduduk['tanggal_lahir']) ?>">
                            <label for="umur-tahun" class="inline-title">Umur</label>
                            <input type="text" id="umur-tahun"  value="" class="umur2" onKeyup="Angka(this)" />
                            <span>Thn</span>
                            <input type="text" id="umur-bulan"  value="" class="umur2" onKeyup="Angka(this)" />
                            <span>Bln</span>
                            <input type="text" id="umur-hari" value="" class="umur2" onKeyup="Angka(this)" />
                            <span>Hr</span>
                            <script type="text/javascript">hitungUmur();</script>
                        </fieldset>
                        <script type="text/javascript">
                            hitungUmur();
                        </script>
                    </td>
                    <td valign="top">
                        <label for="no_kk">No. Kartu Keluarga </label> <input type="text" name="no_kk" id="no_kk" value="<?= $penduduk['no_kartu_keluarga']!='NULL'?$penduduk['no_kartu_keluarga']:'' ?>">
                        <label for="posisi">Posisi di Keluarga </label> <select name="posisi" id="posisi">
                            <option value="">Pilih posisi</option>
                                <option value="Ayah" <?= ($penduduk['posisi_di_keluarga']=="Ayah"? 'selected' : '') ?>>Ayah</option>
                                <option value="Ibu" <?= ($penduduk['posisi_di_keluarga']=="Ibu" ? 'selected' : '') ?>>Ibu</option>
                                <option value="Anak" <?= ($penduduk['posisi_di_keluarga']=="Anak" ? 'selected' : '') ?>>Anak</option>
                            </select>
                        <label for="sip">Nomor SIP </label> <input type="text" name="sip" id="sip" value="<?= $penduduk['sip']!='NULL'?$penduduk['sip']:'' ?>">
                            <label for="no_telp">No. Telepon </label><input type="text" name="no_telp" id="no_telp" value="<?= $penduduk['no_telp']!='NULL'?$penduduk['no_telp']:'' ?>">
                            <label for="idPdd">Pendidikan Terakhir </label><select name="idPendidikan" id="idPendidikan">
                                <option value="">Pilih pendidikan</option>
                            <? foreach ($pendidikan as $rows): ?>
                                    <option value="<?= $rows['id'] ?>" <?= ($rows['id'] == $penduduk['id_pendidikan_terakhir']) ? 'selected' : '' ?>><?= $rows['nama'] ?></option>
                            <? endforeach; ?>
                                </select>
                                <label for="idPkj">Profesi</label>
                                <select name="idProfesi" id="idProfesi">
                                    <option value="">Pilih profesi</option>
                                    <? foreach ($profesi as $rows): ?>
                                                <option value="<?= $rows['id'] ?>" <?= ($rows['id'] == $penduduk['id_profesi']) ? 'selected' : '' ?>><?= $rows['nama'] ?></option>
                                    <? endforeach; ?>
                                    </select>
                                <label for="idPekerjaan">Pekerjaan</label>
                                <select name="idPekerjaan" id="idPekerjaan">
                                    <option value="">Pilih pekerjaan</option>
                                        <? foreach ($pekerjaaan['list'] as $rows): ?>
                                                    <option value="<?= $rows['id'] ?>" <?=$rows['id']==$penduduk['id_pekerjaan']?"selected":''?>><?= $rows['nama'] ?></option>
                                        <? endforeach; ?>
                                    </select>
                                    <label for="idAgama">Agama </label>
                                    <select name="idAgama" id="idAgama">
                            <? foreach ($agama['list'] as $rows): ?>
                                            <option value="<?= $rows['id'] ?>" <?= ($rows['id'] == $penduduk['id_agama']) ? 'selected' : '' ?>><?= $rows['nama'] ?></option>
                            <? endforeach; ?>
                                        </select>
                                        <label for="idPerkawinan">Perkawinan </label>
                                        <select name="idPerkawinan" id="idPerkawinan">
                                            <option value="">Pilih Status Perkawinan</option>
                                            <option value="Lajang" <?if($penduduk['status_pernikahan'] == "Lajang") echo "selected='selected'";?>>Lajang</option>
                                            <option value="Menikah" <?if($penduduk['status_pernikahan'] == "Menikah") echo "selected='selected'";?>>Menikah</option>
                                            <option value="Janda" <?if($penduduk['status_pernikahan'] == "Janda") echo "selected='selected'";?>>Janda</option>
                                        </select>
                                        <fieldset class="input-process">
                                    <input type="submit" name="edit" value="Simpan" class="tombol" />
                                    <input type="button" value="Batal" class="tombol" onclick="javascript:location.href='<?= app_base_url('/admisi/pegawai/') ?>'"/>
                                </fieldset>
                                        </td>
                                    </tr>
                                </table>
                            </fieldset>
                        </form>
</div>