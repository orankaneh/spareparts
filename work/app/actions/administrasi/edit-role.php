<?
$role = role_muat_data($_GET['id']);
$kategori = kategori_barang_muat_data2();
?>
<span class="data-input">
            <fieldset><legend>Edit Role</legend>
            <form action="<?= app_base_url('administrasi/control/usersystem') ?>?tab=role" method="post">
                <input type="hidden" value="<?=$role[0]['id_role']?>" name="id">
            <label for="namarole">Nama</label><input type="text" name="nama_role" id="namarole" value="<?=$role[0]['nama_role']?>"/>
       
            <fieldset class="input-process">
                <input type="submit" value="Simpan" name="editrole" class="tombol buttonRole" />
                <input type="button" class="tombol" value="Batal" onClick="javascript:location.href='<?= app_base_url('administrasi/usersystem')?>'">
            </fieldset>
            </form>
            </fieldset>
</span>