<?php

$section=isset($_GET['section']) ? $_GET['section'] : NULL;

if (isset($section)) {
switch($section) {

case "formicd9": 
   $kode = isset($_GET['kode'])?$_GET['kode']:NULL;
   $nama = isset($_GET['nama'])?$_GET['nama']:NULL;
   $page = isset($_GET['page'])?$_GET['page']:NULL;

?>
<div class="clear" style="padding-top: 20px">
<div class="data-input">    
<fieldset>
    <legend>Form <?= isset($_GET['do'])?$_GET['do']:'Tambah' ?> Data ICD 9</legend>
    <form action="<?= app_base_url('rekam-medik/control/icd_9?act=simpan') ?>" method="post" onsubmit="simpanICD9($(this),'<?= $page ?>'); return false;">
            <label for="kode">Kode</label><input type="text" name="kode" id="kode" class="input-style" value="<?= $kode ?>" size="30"/>
            <label for="nama">Nama</label><input type="text" name="nama" id="nama" class="input-style" value="<?= $nama ?>" size="60"/>
            <fieldset class="input-process">
                <input type="hidden" value="<?= isset($_GET['id'])?$_GET['id']:NULL ?>" name="id" />
                <input type="submit" value="Simpan" name="submit" id="submit" />
                <input type="button" value="Batal" onclick="$('#admission').html('');" />
            </fieldset>
        </form>
    </fieldset>
</div>    
</div>
<?php
break;

// ----------- Tabel ICD 9 -------------- //

case "tabelicd9":

require_once 'app/lib/common/master-data.php';

$id = isset($_GET['id'])?$_GET['id']:NULL;
$page = isset($_GET['page'])?$_GET['page']:NULL;
$data_perpage = isset($_GET['key']) ? 10: 10;
$cari = isset($_GET['key'])?$_GET['key']:NULL;
$icd_9 = icd_9_muat_data(NULL, $page, $data_perpage, $cari);

?>

 <table class="tabel full">
        <tr>
            <th style="width: 5%;">ID</th>
            <th style="width: 25%;">Kode ICD 9</th>
            <th style="width: 45%;">Nama ICD 9</th>
            <th style="width: 9%;">Aksi</th>
        </tr>
        <?php
        foreach ($icd_9['list'] as $key => $row):
        ?>
            <tr class="<?= ($key % 2) ? 'even' : 'odd' ?>" id="<?= $row['id']; ?>">
            <td align="center"><?= $row['id'] ?></td>
            <td><?= $row['kode'] ?></td>
            <td><?= $row['nama'] ?></td>
            <td class="aksi">
                <a title="Edit" class="edit" href=""  onclick="editICD9('<?= $row['kode'] ?>','<?= $row['nama'] ?>','<?= $row['id'] ?>','<?= $page ?>');return false;">Edit</a>
                <a title="Hapus" class="delete" onclick="showFormConfirm('Apakah data ICD <b><?= $row['kode'] ?></b> tersebut akan dihapus?','<?= app_base_url('rekam-medik/control/icd_9?act=hapus') ?>','<?= $row['id']; ?>')">Delete</a>
            </td>
            </tr>
        <?php endforeach; ?>
    </table><br><br>
<?php if ($data_perpage==10) echo $icd_9['paging'];
break;
}

exit();
}


require_once 'app/lib/common/functions.php';
require_once 'app/actions/admisi/pesan.php';

?>
<script type="text/javascript">
contentloader('<?= app_base_url('rekam-medik/icd_9?section=tabelicd9'); ?>','#content');

$(function() {
    $('#key-nama').watermark('Masukkan Nama');
    $('#kode').focus();
})
function deleteConfirm(id, data) {
	$('.data-input').hide();
	$('#confirm-form').fadeIn();
	$('#idformhapus').val(id);
        $('#val').html(data);
	return false;
}

function simpanICD9(formid,page) {
	if ($('#kode').val() == '') {
		caution('Kode tidak boleh kosong !');
		$('#kode').focus();
	} else if ($('#nama').val() == '') {
		caution('Nama tidak boleh kosong !');
		$('#nama').focus();
	} else {
		progressAdd(formid);
		$('#admission').html('');
		contentloader('<?= app_base_url('rekam-medik/icd_9?section=tabelicd9'); ?>&page='+page,'#content');
	}
	
}

function editICD9(kode,nama,id,page) {
	contentloader('<?= app_base_url('rekam-medik/icd_9?section=formicd9'); ?>&kode='+kode+'&nama='+nama+'&id='+id+'&page='+page,'#admission');
	
}

function showFormICD9() {
	contentloader('<?= app_base_url('rekam-medik/icd_9?section=formicd9'); ?>','#admission');
}

function searchICD9() {
	contentloader('<?= app_base_url('rekam-medik/icd_9?section=tabelicd9'); ?>&key='+$('#keysearch').val(),'#content');
}
</script>
<h1 class="judul"><a href="<?= app_base_url('rekam-medik/icd_9')?>">Master Data ICD 9</a></h1>

<div id="box-notif"></div><div class="clear"></div>
<div id="admission"></div>
<div class="data-list w700px">
<div class="floleft"><?php echo addButton('showFormICD9()','Tambah Data','addICD'); ?></div>
<div class="floright">
	<form action="<?= app_base_url('rekam-medik/icd_9')?>" method="GET" class="search-form" style="margin-top: -5px" onsubmit="searchICD9(); return false;">
		<input type="text" class="search-input" id="keysearch"/><input type="submit" class="search-button" value=""/>
	</form>
</div>

<div id="content"></div>

   

</div>
