<script type="text/javascript">
  function cekform(data) {
        if (data.nama.value == "") {
            alert('Nama instansi relasi tidak boleh kosong');
            data.nama.focus();
            return false;
        }
        if (data.alamat.value == "") {
            alert('Alamat instansi relasi tidak boleh kosong');
            data.alamat.focus();
            return false;
        }
        if (data.kelurahan.value == "") {
            alert('Kelurahan relasi tidak boleh kosong');
            data.kelurahan.focus();
            return false;
        }
        if (data.relasiInstansi.value == "") {
            alert('Jenis instansi relasi tidak boleh kosong');
            data.relasiInstansi.focus();
            return false;
        }
        if($('#email').val() != '')
		{
            var RegExp = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
		    var email    = $('#email').val();
		    if (RegExp.test(email))
            {}
            else {
                alert('E-mail tidak valid. Pastikan berpola example@destination.com');
                $('#email').focus();
                return false;
            }
		}
		if($('#website').val() != '')
		{
            var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
		    var URL    = $('#website').val();
		    if (RegExp.test(URL))
            {}
            else {
                alert('URL tidak valid. Pastikan berpola http://example.com');
                $('#website').focus();
                return false;
            }
		}
}
</script>
<?php
$instansi_id = instansi_relasi_muat_data_by_id($_GET['id']);
foreach($instansi_id as $row):
?>
        <div class="data-input">
            <form id="formInstansiRelasi" action="<?= app_base_url('/pf/control/instansi-relasi/edit') ?>" method="post" onsubmit="return cekform(this)">
                <fieldset>
                    <legend>Form Edit Data Instansi Relasi</legend>
                    <label for="relasi-instansi">Jenis Instansi Relasi</label>
                    <select name="relasiInstansi" id="relasi-instansi">
                        <option value="">Pilih jenis..</option>
                        <? foreach($jenis_instansi['list'] as $rows): ?>
                        <option value="<?= $rows['id'] ?>" <? if ($rows['id'] == $row['id_jenis_instansi_relasi']) echo "selected"; ?>><?= $rows['nama'] ?></option>
                        <? endforeach; ?>
                    </select>

                    <input type="hidden" name="idInstansi" value="<?= $row['id'] ?>" /><span class="bintang">*</span>
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" value="<?= $row['nama'] ?>"><span class="bintang">*</span>
                    <label for="barang-alamat">Alamat</label>
                    <textarea name="alamat" id="alamat" cols="50" rows="5"><?= $row['alamat'] ?></textarea><span class="bintang">*</span>
                    <label for="kelurahan">Kelurahan</label>
                    <input type="text" name="kelurahan" id="kelurahan" value="<?= $row['nama_kelurahan'] ?>" />
                    <input type="hidden" name="id-kelurahan" id="id-kelurahan" value="<?= $row['id_kelurahan'] ?>" /><span class="bintang">*</span>
                    <label for="telp">No. Telepon</label><input type="text" id="telpon" name="telpon" maxsize="15" value="<?= $row['telp']?>">
                    <label for="fax">No. Fax</label><input type="text" id="fax" name="fax" value="<?= $row['fax']?>">
                    <label for="email">Email</label><input type="text" id="email" name="email" value="<?= $row['email']?>">
                    <label for="web">Website</label><input type="text" id="website" name="website" value="<?= $row['website']?>">

                    <fieldset class="input-process">
                        <input type="submit" value="Simpan" class="tombol">
                        <input type="button" value="Batal" class="tombol" onclick="javascript:location.href='<?=  app_base_url('/pf/inventory/instansi-relasi')?>'">
                    </fieldset>
                </fieldset>

            </form>
        </div>
<?
            endforeach;
?>            
