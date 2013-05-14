<?php
  $module_id = module_muat_data($_GET['id']);
  $modulList = module_muat_data();
?>
<span class="data-input">
    <fieldset><legend>Form Edit Module</legend>
    <?  foreach ($module_id as $mod):?>     
    <form action="<?= app_base_url('administrasi/control/usersystem') ?>?tab=privilege" method="post" onSubmit="return checkvalues(this)">
    <label for="module">Module</label><input type="text" name="module" id="module" value="<?= $mod['module']?>"/><input type="hidden" name="idModule" value="<?= $mod['id']?>">
    <label>Parent Module</label>
    <select name="parent">
        <option value="">Parent module</option>
        <?
          foreach ($modulList as $row){
        ?>
           <option value="<?= $row['id']?>" <?if($row['id_parent_modul']==$mod['id']) echo "selected='selected'";?>><?= $row['module']?></option>
        <?
          }
        ?>
    </select>
    <fieldset class="input-process">
        <input type="submit" value="Simpan" name="editmodule" class="tombol" />
        <input type="button" value="Batal" class="tombol" onClick=javascript:location.href="<?= app_base_url('/administrasi/usersystem') ?>" />
    </fieldset>
    </form>
     <?  endforeach;?>   
    </fieldset>
</span>