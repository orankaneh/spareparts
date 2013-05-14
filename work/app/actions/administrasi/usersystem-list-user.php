<script type="text/javascript">
    $(function(){
        $('#nama').focus();
    })
    function checkvalues(data) {
        if (data.nama.value == "") {
            alert('Data nama tidak boleh kosong');
            data.nama.focus();
            return false;
        }
        if (data.username.value == "") {
            alert('Data username tidak boleh kosong');
            data.username.focus();
            return false;
        }
        if (data.rolename.value == "") {
            alert('Data role name tidak boleh kosong');
            data.rolename.focus();
            return false;
        }
        if (data.target.value == "") {
            alert('Data target tidak boleh kosong');
            data.target.focus();
            return false;
        }
		 if (data.limit.value == "") {
            alert('Data limit tidak boleh kosong');
            data.limit.focus();
            return false;
        }
		 if (data.alamat.value == "") {
            alert('Data limit tidak boleh kosong');
            data.alamat.focus();
            return false;
        }
		 if (data.salesid.value == "" || data.namasales.value == "") {
            alert('Data sales tidak boleh kosong');
            data.saleid.focus();
            return false;
        }
    }
</script>
<?
//show_array($_SESSION);
if (isset($_GET['do'])) {
    if ($_GET['do'] == 'add_user') {
        require_once 'app/actions/administrasi/add-user.php';
    } else if ($_GET['do'] == 'edit_user') {
        require_once 'app/actions/administrasi/edit-user.php';
    }
}
?>
<div class="data-list" style="width: 1010px !important">
    <?php echo addButton('/administrasi/usersystem/?do=add_user','Tambah'); ?>
    
    <form action="" method="GET" class="search-form">
        <span style="float:right">Nama: <input type="text" name="key" class="search-input" id="keyword" value="<?= $key ?>"/><input type="submit" value="" class="search-button" /></span>
    </form>
    <table class="tabel full" style="overflow: auto;width: 100%;display: block">
        <tr>
            <th>ID</th>
            <th>Username/NIP</th>
            <th><a href="<?= app_base_url('/administrasi/usersystem') ?>?sort=1" class="sorting">Nama</a></th>
            <th>Role</th>
            <!--<th>Unit Organisasi</th>-->
            <th>Akses Terakhir</th>
            <!--<th>Layout</th>-->
            <th>Aksi</th>
        </tr>
        <?php
        foreach ($usersystem['list'] as $numb => $row):
            ?>
            <tr class="<?= ($numb % 2) ? 'even' : 'odd' ?>">
                <td align="center" style="width: 5%"><?= $row['id'] ?></td>
                <td style="width: 10%"><?= $row['username'] ?></td>
                <? if(strtolower($row['nama_role'])=='sales'){?>
                <td class="no-wrap"><?= $row['salesname'] ?></td>
                <? }?>
                <? if(strtolower($row['nama_role'])=='konsumen'){?>
                <td class="no-wrap"><?= $row['konsumenname'] ?></td>
                <? }?>
                 <? if(strtolower($row['nama_role'])=='admin'){?>
                <td class="no-wrap">Admin</td>
                <? }?>
                <td style="width: 25%"><?= $row['nama_role'] ?></td>
                 <!-- <td style="width: 15%"><?$row['nama_unit'] ?></td>-->
                <td align="center" style="width: 10%"><?= $row['last_access'] ?></td>
                <!--<td>
                    <?// 
                      if($row['id_layout'] == 1){
                          echo "Layout 1 (Full)";
                      }else{
                          echo "Layout 2 (Tablet)";
                      }
                    ?>
                </td>-->
               
                <td class="aksi" style="width: 7%;">
                 <?	if ($_SESSION['id_role']=='1'){?>
                    <a href="<?= app_base_url('administrasi/usersystem?do=edit_user&id=' . $row["id"] . '') ?>" class="edit" title="Edit"></a>
                    <a href="<?= app_base_url('administrasi/control/usersystem?do=delete_user&id=' . $row["id"] . '') ?>" class="delete" title="Delete"></a>
                    <?
                    if ($row['status'] == 1) {
                        ?>
                        <a href="<?= app_base_url('administrasi/control/usersystem?do=activation&value=0&id=' . $row["id"] . '') ?>" class="nonaktif" title="Non-Aktifkan"></a>
                        <?
                    } else if ($row['status'] == 0) {
                        ?>
                        <a href="<?= app_base_url('administrasi/control/usersystem?do=activation&value=1&id=' . $row["id"] . '') ?>" class="aktif" title="Aktifkan"></a>
                        <?
                    }
                    ?>
                    <a href="<?= app_base_url('administrasi/control/usersystem?do=reset_user&id=' . $row["id"] . '') ?>" class="reset" title="Reset Password"></a>
                    <? 
					}
					else{
					?>
                      <a href="<?= app_base_url('administrasi/usersystem?do=edit_user&id=' . $row["id"] . '') ?>" class="edit" title="Edit"></a>
                    <?
					}
					?>	
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php
echo $usersystem['paging'];
?>