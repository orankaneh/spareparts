<?php

 $privilege = privilege_muat_data($_GET['id']);
 $module = module_muat_data();
 
?>
<span class="data-input">
    <?  foreach ($privilege as $priv):?>
    <fieldset style="border:none;">
    
    <form action="<?= app_base_url('administrasi/control/privilege') ?>?opsi=editprivilege" method="post" onSubmit="return checkvalues(this)">
    <label for="privilege">Module</label>    
    <select name="module">
        <option value="">Pilih module</option>
        <?
        foreach ($module as $mod) :
        ?>
          <option value="<?= $mod['id']?>"<?if ($priv['id_module']==$mod['id']) echo "selected";?>><?= $mod['module']?></option>
        <?
        endforeach;
        ?>
    </select>    
    <label for="privilege">Privilege</label>
    <input type="text" name="privilege" id="privilege" value="<?= $priv['nama']?>"/>
    <input type="hidden" name="idPrivilege" value="<?= $priv['id']?>"/>
    <input type="hidden" name="tab" value="privilege"/>
    <label for="url">URL</label><input type="text" name="url" id="url" value="<?= $priv['url']?>"/>
    <fieldset class="input-process">
        <input type="submit" value="Simpan" name="editprivilege" class="tombol" />
        <input type="button" value="Batal" class="tombol" onClick=javascript:location.href="<?= app_base_url('/administrasi/usersystem') ?>" />
    </fieldset>
    </form>
    </fieldset>
    <?  endforeach;?>
</span>
