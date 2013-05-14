<script>
	contentloader('<?php echo app_base_url('/administrasi/section/user?sub=tabelprivilege') ?>','#content');
	
	function showModuleForm() {
		contentloader('<?php echo app_base_url('/administrasi/section/user?sub=moduleform') ?>','#admission');
	}
	
	function simpanModule(formid) {
		if ($('#module').val() == '') {
			caution('Isian tidak boleh kosong');
		} else {
			progressAdd(formid);
			setTimeout("contentloader('<?php echo app_base_url('/administrasi/section/user?sub=tabelprivilege') ?>','#content')",800);
		}
	}
	
	function simpanPrivilege(formid) {
		if ($('#module').val() == '') {
			caution('Modul harus dipilih');
		} else if ($('#namaprivilege').val() == '') {
			caution('Nama Privilege harus diisi');
		} else if ($('#url').val() =='' ) {
			caution('URL tidak boleh kosong');
		} else {
			progressAdd(formid);
			setTimeout("contentloader('<?php echo app_base_url('/administrasi/section/user?sub=tabelprivilege') ?>','#content')",800);
			$('#admission').html('');
		}
	}
</script>

<?php 


      if (isset($_GET['do'])) {
      if ($_GET['do'] == 'add_module') {
	require_once 'app/actions/administrasi/add-module.php';
      }
      else if ($_GET['do'] == 'edit_module') {
	require_once 'app/actions/administrasi/edit-module.php';
      }
      else if ($_GET['do'] == 'add_privilege') {
	require_once 'app/actions/administrasi/add-privilege.php';
      }
      else if ($_GET['do'] == 'edit_privilege') {
	require_once 'app/actions/administrasi/edit-privilege.php';
      }
      }
      
?>
	<?php boxnotif(); ?>
    <div class="data-list w800px">
         <?php echo addButton('showModuleForm()','Tambah Module','addModuleForm') ?>

	<div id="admission"></div>
	<div id="content"></div>
    </div>