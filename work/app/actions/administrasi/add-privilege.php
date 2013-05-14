<?
$module = module_muat_data();
$id = $_GET['id'];
?>
<span class="data-input">
    <fieldset><legend>Form Tambah Privilege</legend>
    <form action="<?= app_base_url('administrasi/control/privilege?opsi=addprivilege') ?>" method="post" onSubmit="simpanPrivilege($(this)); return false">
    <label for="privilege">Module</label>    
    <select name="module" class="select-style">
        <option value="">-- Pilih module-- </option><?php
        foreach ($module as $mod) {
			echo "<option value=".$mod['id']." ";
			if($mod['id'] == $id) echo"selected";
			echo ">".$mod['module']."</option>";
        }
        ?>
    </select>    
    <label for="privilege">Privilege</label><input type="text" name="privilege" id="namaprivilege" />
    <label for="url">URL</label><input type="text" name="url" id="url" />
	<label for="icon">Icon</label><input type="text" name="icon" id="icon" />
        <input type="hidden" name="tab" value="privilege"/>
	<label for="icon_extra">Icon Tablet</label><input type="text" name="icon_extra" id="icon_extra" />
    <label></label>
        <input type="submit" value="Simpan" name="addprivilege" class="stylebutton" style="margin-right: 5px"/>
        <input type="button" value="Batal" class="stylebutton" onClick=javascript:location.href="<?= app_base_url('/administrasi/usersystem') ?>" />
    </form>
    </fieldset>
</span>