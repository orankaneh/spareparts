<?
  $data = spesialisasi_muat_data($_GET['id']);
?>
<div class="data-input">
<fieldset><legend>Form Edit Data Spesialisasi</legend>
    <form action="<?= app_base_url('/admisi/control/spesialisasi') ?>" method="post" >
        <label for="spesialisasi">Nama spesialisasi</label>
        <input type="text" name="spesialisasi" id="spesialisasi" value="<?= $data['nama']?>"/>
        <input type="hidden" name="idSpesialisasi" id="idSpesialisasi" value="<?= $data['id']?>">
        <label for="profesi">Nama Profesi</label>
        <input type="text" name="profesi" id="profesi" value="<?= $data['profesi']?>"/>
        <input type="hidden" name="idProfesi" id="idProfesi" value="<?= $data['id_profesi']?>"/>
        <fieldset class="input-process">
                <input type="submit" value="Simpan" class="tombol" name="edit" id="save"/>&nbsp;
                <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('admisi/data-spesialisasi') ?>'" />
         </fieldset>
    </form>
</fieldset>
</div>
