<?php 
$section= isset($_GET['section']) ? $_GET['section']: NULL;

if (isset($section)) {
switch($section) {

// ---------------------- Tabel Agama ---------------------------- //

case "tabelagama":


require_once 'app/lib/common/master-data.php'; 
$code = isset($_GET['code'])?$_GET['code']:NULL;
$key = isset($_GET['key'])?$_GET['key']:NULL;
$agama = agama_muat_data($code,$key);

?>

<table class="tabel full" id="table">
	<tr>
		  <th>ID</th>
		  <th>Nama agama</th>
		  <th>Aksi</th>

	</tr>
		<?php foreach($agama['list'] as $num => $row): ?>
		<tr id="<?= $row['id']?>" class="<?= ($num%2) ? 'even' : 'odd' ?>">
				<td width="12" align=center><?= ++$num?></td>
				<td width="200"><?= $row['nama'] ?></td>
				<td width="40" align=center class="aksi">
					<a href="" onclick="editAgama('<?= $row['id']?>','<?= $row['nama'] ?>'); return false" class="edit">edit</a>
					<a href="" onclick="showFormConfirm('Apakah Anda ingin menghapus Agama <?php echo $row['nama']; ?> ?','<?= app_base_url('admisi/control/agama?sub=hapusagama'); ?>','<?=$row['id']; ?>'); return false" class="delete">delete</a>
				</td>
		</tr>
		<?php endforeach; ?>
     </table>
    <?
      $count = count($agama['list']);
      echo "<p>Jumlah Total Nama Agama: <b>".$count."</b></p>";
exit();
break;

// ------------------- Form Tambah Agama ------------------------- //

case "formagama":

$id=isset($_GET['id']) ? $_GET['id'] : NULL;
$nama=isset($_GET['nama']) ? $_GET['nama'] : NULL;
$namatombol=isset($_GET['id']) ? "Edit" : "Simpan";
 ?>


    <form action="<?= app_base_url('/admisi/control/agama?sub=simpanagama') ?>" method="post" id="formagama"  onsubmit="simpanAgama($(this)); return false;">
<fieldset style="margin-top: 25px"><legend>Form <?php echo $namatombol; ?> Data agama</legend>
        <label for="agama">Nama agama</label><input type="text" name="namaagama" value="<?php echo $nama; ?>" id="inputagama" class="input-style"/>
		<label></label>
				<input type="hidden" name="idagama" value="<?php echo $id; ?>">
                <input type="submit" value="<?php echo $namatombol; ?>" class="stylebutton" name="add" id="save"/>&nbsp;
                <input type="button" value="Batal" class="stylebutton" onclick="cancelAddAgama()" />

    </form>
</fieldset>

<?php
exit(); 

break;

}

} else {



?>
<div class="judul"><a href="<?=  app_base_url('admisi/data-agama')?>">Master Data Agama</a></div><?php echo isset($pesan)?$pesan:NULL;?>
<script type="text/javascript">

contentloader('<?= app_base_url('/admisi/data-agama?section=tabelagama'); ?>','#content');

function showFormAddAgama() {
	contentloader('<?= app_base_url('/admisi/data-agama?section=formagama'); ?>','#admission');
	$('#inputagama').focus();
}

function cancelAddAgama() {
	$('#admission').html('');
}

function simpanAgama(formid) {
    if($('#inputagama').attr('value')==''){
       caution('Nama agama masih kosong');
       $('#inputagama').focus();
    }else{
        progressAdd(formid);
		contentloader('<?= app_base_url('/admisi/data-agama?section=tabelagama'); ?>','#content');
		$('#admission').html('');
    }
}

function editAgama(id,nama) {
	contentloader('<?= app_base_url('/admisi/data-agama?section=formagama'); ?>&id='+id+'&nama='+nama,'#admission');
}
function searchAgama() {
	contentloader('<?= app_base_url('/admisi/data-agama?section=tabelagama');?>&key='+$("#keysearch").val(),'#content');
}
</script>

<div id="box-notif"></div><div class="clear"><div>
<?
if (isset($_GET['do'])) {
    if ($_GET['do'] == 'add') {
            require_once 'app/actions/admisi/add-agama.php';
    }
    else if ($_GET['do'] == 'edit') {
            require_once 'app/actions/admisi/edit-agama.php';
    }
}
?>
<div class="data-list w600px">
    
        <div class="floleft"><?php echo addButton('showFormAddAgama()','Tambah Agama','addButtonAgama'); ?></div>
        <div class="floright">
            <form action="" method="POST"class="search-form" onsubmit="searchAgama(); return false;" style="margin: -5px 0 0 0">
                    <span style="float:right;"><input type="text" name="key" class="search-input" id="keysearch" value=""/><input type="submit" class="search-button" value=""/></span>
            </form>
        </div>
		<div id="admission"></div>
        <div id="content"></div>
</div>

<?php } ?>