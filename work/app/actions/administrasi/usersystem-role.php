<script type="text/javascript">
	contentloader('<?= app_base_url('administrasi/section/user?sub=tabelrole')?>','#contentrole');
    $('#namarole').focus();
    
    function simpanRole(formid) {
		if ($('#namarole').val() == "") {
			caution('Data nama role tidak boleh kosong','#box-notif-role');
			$('#namarole').focus();
		}else if ($("select[name=kategori]").val() == "") {
			caution('Kategori tidak boleh kosong','#box-notif-role');
			$("select[name=kategori]").focus();
		}else{
			progressAdd(formid,"#box-notif-role");
			contentloader('<?= app_base_url('administrasi/section/user?sub=tabelrole')?>','#contentrole');
			$('#admissionrole').html('');
			$('#addRoleButton').show();
		}
	}

    function showRoleForm() {
		contentloader('<?= app_base_url('administrasi/section/user?sub=roleform')?>','#admissionrole');
		$('#addRoleButton').hide();
	}
	
	function hideRoleForm() {
		$('#admissionrole').html('');
		$('#addRoleButton').show();
	}
	
	function sortRole(sortdata) {
		contentloader(sortdata,'#contentrole');
	}
	
    
</script>
<?

if (isset($_GET['do'])) {
	if ($_GET['do'] == 'edit_role') {
        require_once 'app/actions/administrasi/edit-role.php';
    } else if ($_GET['do'] == 'active_role') {
        require_once 'app/actions/administrasi/active-role.php';
    } else if ($_GET['do'] == 'edit_role_privilege') {
        require_once 'app/actions/administrasi/edit-role-privilege.php';
    }
}
?>
<div class="data-list w700px">
<?	if ($_SESSION['id_role']=='1'){?>
	<div id="box-notif-role"></div><div class="clear"></div>
    <?php echo addButton('showRoleForm()','Tambah','addRoleButton'); ?>
	<div id="admissionrole"></div>
    <div id="contentrole"></div>
<? } 
else{?>
<div id="box-notif-role">Maaf Hanya Admin Yang Boleh Mengakses Halaman Ini...</div>
<?}?>   
</div>