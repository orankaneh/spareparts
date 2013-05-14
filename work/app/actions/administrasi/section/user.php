<?php require_once 'app/lib/administrasi/usersystem.php';

/**
     * fungsi ini dugunakan untuk manampilkan table priviledge
     * @param <type> $privilege
     * @param <type> $role
     * @param <type> $classRole
     */
    function showPrivilegeManagement($privilege){
        foreach($privilege as $key => $data): ?>
            <tr class="<?= ($key%2) ? 'even':'odd' ?>" id="<?php echo $data['id']; ?>">
                <td align="center">&nbsp;</td><!--No-->
                <td>&nbsp;</td><!--Module-->
                <td class="no-wrap"><?= $data['nama'] ?></td><!--Nama Previledge-->
                <td class="no-wrap"><?=$data['url']?></td>
                <td class="aksi" style="text-align:left;">
                    <a href="<?= app_base_url('administrasi/usersystem?do=edit_privilege&id='.$data["id"].'') ?>&tab=privilege" class="edit" title="edit privilege">edit</a>
                    <a href="" onclick="showFormConfirm('Apakah Anda ingin menghapus privilege <b><?php echo $data['nama']; ?></b> tersebut ?','<?= app_base_url('administrasi/control/privilege?opsi=hapusprivilege'); ?>','<?=$data['id']; ?>'); return false" class="delete">Delete</a>
                </td>
             </tr>
        <?php endforeach;
    }
    /**
     *
     * @param array $module modul yang akan ditampilkan
     * @param integer $at
     */
     function showModulManagement($module,$at=0){
         $nbsp='';
         for($i=0;$i<=($at*5);$i++){
             $nbsp.='&nbsp;';
         }
         foreach($module as $nums=>$row){
            echo"<tr>"; ?>
            <td align="center"><?= ($at==0)?++$nums:'' ?></td><!--No-->
            <td class="bolder no-wrap"><?= $nbsp.$row['module'] ?></td><!--nama modul-->
            <td>&nbsp;</td><!--priviledge-->
            <td>&nbsp;</td><!--URL-->
            <td class="aksi" style="text-align:left;">
                <a href="<?= app_base_url('administrasi/usersystem?do=edit_module&id='.$row["id"].'') ?>&tab=privilege" class="edit" title="edit module">edit</a>
                <a href="<?= app_base_url('administrasi/control/usersystem?do=delete_module&id='.$row['id'].'')?>&tab=privilege" class="delete" title="delete module">delete</a>
                <a href="<?= app_base_url('administrasi/usersystem?do=add_privilege&id='.$row["id"].'') ?>&tab=privilege" class="inadd" title="tambah privilege">tambah</a>
            </td>
            <?
             echo"</tr>";
             if(isset($row['subModul']) && count($row['subModul'])){
                 showModulManagement($row['subModul'], $at+1);
             }
             if(isset($row['privilege']) && count($row['privilege'])){
                 showPrivilegeManagement($row['privilege']);
             }
        }

    }


$modulList = module_muat_data();

switch ($_GET['sub']) {

// ---------------------------------- Form Add Module ------------------------------------ //

case "moduleform":

?>
<div class="data-input" style='padding-top: 10px'>
    <fieldset><legend>Form Tambah Module</legend>
    <form action="<?= app_base_url('administrasi/control/privilege?opsi=addmodule'); ?>" method="post" onSubmit="simpanModule($(this));return false">
    <label for="module">Module</label><input type="text" name="module" id="module" />
    <label>Parent Module</label>
    <select name="parent" class="select-style">
        <option value="">Parent module</option>
        <?php foreach ($modulList as $row) {
			echo "<option value=".$row['id'].">".$row['module']."</option>";
		} ?>
    </select>
    <label></label>
        <input type="submit" value="Simpan" name="addmodule" class="stylebutton" style="margin-right: 5px"/>
        <input type="button" value="Batal" class="stylebutton" onclick="$('#admission').html('')" />
    </form>
    </fieldset>
</div>

<?php

break;

// ---------------------------------- Tabel Privilege ------------------------------------- //

case "tabelprivilege": 
require_once 'app/lib/common/master-data.php';

$modul = modul_muat_data();
?>

<table class="tabel full" style="margin: 10px 0">
	<tr>
		<th>No</th>
		<th>Privilege</th>
		<th>Sub Menu</th>
		<th>URL</th>
		<th style="width: 15%">Aksi</th>
	</tr>
	<? showModulManagement($modul)?>
 </table><?php

break;

// ----------------------------------- Tabel Role ------------------------------------------ //

case "tabelrole": 
require_once 'app/lib/common/master-data.php';

$sort = isset($_GET['sort'])?$_GET['sort']:NULL;
$sortBy = isset($_GET['sortBy'])?$_GET['sortBy']:NULL;
?>
	<table class="tabel full" style="margin-top: 10px">
			<tr>
				<th>ID</th>
				<th><a href="" onclick="sortRole('<?=app_base_url('administrasi/section/user?').  generate_sort_parameter(1, $sortBy)?>'); return false" class='sorting'>Nama</a></th>
				<!--<th style="width: 15%"><a href="" onclick="sortRole('<?//app_base_url('administrasi/section/user?').  generate_sort_parameter(2, $sortBy)?>'); return false" class='sorting'>Kategori Barang</a></th>-->
				<th>Status</th>
				<th style="width: 15%">Aksi</th>
			</tr>

	<?php
	$id = isset ($_GET['idRole'])?$_GET['idRole']:NULL;
	$role = role_muat_data($id,$sort,$sortBy);
	foreach ($role as $num => $rows):
	if ($rows['status'] == 1)
		$status = "active";
	else
		$status = "non-active";
	?>
		<tr class="<?= ($num % 2) ? 'even' : 'odd' ?>">
			<td align="center"><?= ++$num ?></td>
			<td class="no-wrap"><?= $rows['nama_role'] ?></td>
			<!--<td class="no-wrap"><?//$rows['kategori_barang'] ?></td>-->
			<td align="center" class="aksi">
				<a href="<?= app_base_url('/administrasi/usersystem?do=active_role&id=' . $rows['id_role'] . '') ?>&tab=role" class="<?=($rows['status'] == 1)?'aktif':'nonaktif'?>"><?= $status ?></a></td>
			<td class="aksi">
				<a href="<?= app_base_url('administrasi/usersystem?do=edit_role&id=' . $rows['id_role'] . '') ?>&tab=role" class="edit"><small>edit</small></a>
				<a href="<?= app_base_url('administrasi/control/usersystem?do=delete_role&id='.$rows['id_role'].'')?>&tabs=role" class="delete"><small>delete</small></a>
				<a href="<?= app_base_url('administrasi/usersystem?do=edit_role_privilege&id=' . $rows['id_role'] . '') ?>&tab=role" class="edit">edit privilege</a>
			</td>
		</tr>
	<?php endforeach; ?>
		</table>
		<?php
break;

// ----------------------------------- Form Role ------------------------------------------- //

case "roleform": 
require_once 'app/lib/common/master-data.php';
$kategori = kategori_barang_muat_data2();
?>
<span class="data-input">
            <fieldset><legend>Form Tambah Role</legend>
            <form action="<?= app_base_url('administrasi/control/privilege?opsi=addrole') ?>" method="post" onsubmit="simpanRole($(this)); return false">
            <label for="namarole">Nama</label><input type="text" name="namarole" id="namarole" />
            <!--<label for="kategori">Kategori Barang</label>
            <select name="kategori" class="select-style">
                <option value="">Pilih Kategori Barang</option><?//
				foreach ($kategori as $value) {
					echo "<option value=".$value['id'].">".$value['nama']."</option>";
                }
                ?>
            </select>-->
            <label></label>
                <input type="submit" value="Simpan" name="addrole" class="stylebutton" style="margin-right: 5px"/>
                <input type="button" class="stylebutton" value="Batal" onclick="hideRoleForm()">
            </form>
            </fieldset>
</span>

<?php
break;

}

exit(); ?>