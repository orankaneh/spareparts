<?
$moduls=modul_muat_data();
$role=role_muat_data($_GET['id']);
?>
<script type="text/javascript">
    function checkAllRole(className,modulSelect){
        var val=$('.val_'+className).val();
        if(val==1){
            $('.'+className).attr('checked','checked');
            $('.val_'+className).val('0');
            $('.font_'+className).html('Uncheck');
        }else{
            $('.'+className).removeAttr('checked');
            $('.val_'+className).val('1');
            $('.font_'+className).html('Check All');
        }
    }
</script>
<fieldset class="data-input">
    <label for="nama-role">Nama Role:</label><span style="font-size: 12px;padding-top: 5px;"><?=$role[0]['nama_role']?></span>
</fieldset>
<form action="<?= app_base_url('/administrasi/control/usersystem')?>?tab=role" method="post">
    <input type="hidden" name="id" value="<?=$role[0]['id_role']?>">
    <div class="data-list">
    <table class="tabel" width="50%">
        <tr>
            <th>No</th>
            <th>Privilege</th>
            <th>Sub Privilege</th>
            <th>Grant</th>
        </tr>
        <?showModul($moduls, $role);?>
    </table>
    </div>    
    <input type="submit" value="Simpan" name="editRolePrivilage" class="tombol" />
    <input type="button" class="tombol" value="Batal" onClick="javascript:location.href='<?= app_base_url('administrasi/usersystem')?>'">
</form>