<?
$profesi = profesi_muat_data($_GET['id']);
foreach ($profesi as $data);
?>
<div class="data-input">
<fieldset><legend>Form Edit Data Profesi</legend>
 <form action="<?= app_base_url('/admisi/control/profesi') ?>" method="post">
 <input type="hidden" name="idProfesi" id="idProfesi" value="<?= $data['id']?>"/>
        <label for="profesi">Nama Profesi</label>
        <input type="text" name="profesi" id="profesi" value="<?= $data['nama']?>"/>
        <label>Jenis Profesi</label>
        <select name="jenis" id="jenis">
            <option value="">Pilih jenis profesi</option>
            <option value="Nakes" <?php if($data['jenis'] == "Nakes") echo "selected";?>>Nakes</option>
            <option value="Bukan" <?php if($data['jenis'] == "Bukan") echo "selected";?>>Bukan Nakes</option>
        </select>
         <fieldset class="input-process">
            <input type="submit" value="Simpan" class="tombol" name="edit" id="save"/>&nbsp;
            <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('admisi/data-profesi') ?>'" />
     </fieldset>
    </form>
</fieldset>
</div>