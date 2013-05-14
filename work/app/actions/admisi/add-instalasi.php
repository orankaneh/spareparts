<div class="data-input">
<fieldset><legend>Form Tambah Data Instalasi/Ruang</legend>

    <form action="<?= app_base_url('/admisi/control/instalasi/add') ?>" method="post" name="dataform" onSubmit="return cekform()">
        <label for="instalasi">Nama</label><input type="text" name="instalasi" id="instalasi"/>
        <input type="hidden" name="idInstalasi" id="idInstalasi"/>
         <fieldset class="input-process">
            <input type="submit" value="Simpan" class="tombol" name="save" id="save"/>&nbsp;
            <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('admisi/data-instalasi') ?>'" />
     </fieldset>
    </form>

</fieldset>
</div>