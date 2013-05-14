<?php
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';
require_once 'app/actions/admisi/pesan.php';
$id = isset($_GET['id'])?$_GET['id']:NULL;
$page = isset($_GET['page'])?$_GET['page']:NULL;
$data_perpage = 10;
$cari = isset($_GET['key'])?$_GET['key']:NULL;
$icd_10 = icd_10_muat_data(NULL, $page, $data_perpage, $cari);

if(isset ($_GET['do']) && $_GET['do'] == "edit"){
   $data_input = icd_10_muat_data($id); 
   $kode = isset($data_input['kode'])?$data_input['kode']:NULL;
   $nama = isset($data_input['nama'])?$data_input['nama']:NULL;
   $subDeskripsi = isset($data_input['sub_diskripsi'])?$data_input['sub_diskripsi']:NULL;
}else{
    $kode = "";
    $nama = "";
	$subDeskripsi="";
}

?>
<script type="text/javascript">
$(function() {
    $('#key-nama').watermark('Masukkan Nama');
    $('#kode').focus();
    $('#submit').click(function() {
        if ($('#kode').val() == '') {
            alert('Kode tidak boleh kosong !');
            $('#kode').focus();
            return false;
        }
        if ($('#nama').val() == '') {
            alert('Nama tidak boleh kosong !');
            $('#nama').focus();
            return false;
        }
    })
})
function deleteConfirm(id, data) {
	$('.data-input').hide();
	$('#confirm-form').fadeIn();
	$('#idformhapus').val(id);
        $('#val').html(data);
	return false;
}


$(document).ready(function(){
    $('#kode').focus();        
    
    $("#save").click(function(event){
        event.preventDefault();
         if($('#kode').attr('value')==''){
            alert('Kode tidak boleh kosong !');
            $('#kode').focus();
            return false;
	}
	else if ($('#nama').val() == '') {
            alert('Nama tidak boleh kosong !');
            $('#nama').focus();
            return false;
        }
			else if ($('#subDeskripsi').val() == '') {
            alert('subDeskripsi tidak boleh kosong !');
            $('#subDeskripsi').focus();
            return false;
        }
		
        else{
            var id=($(this).attr("name")=="save"?'&id='+$('input[name=id]').attr('value'):'');
            $.ajax({
                url: "<?= app_base_url('inventory/search?opsi=cek_icd10')?>",
                data:'&kode='+$('#kode').attr('value')+id,
                cache: false,
                dataType: 'json',
                success: function(msg){
                    if(!msg.status){
                        alert('Kode ICD 10 sudah ada di database !');
                        $('#kode').focus();
                        return false;
                     }else{
                         $("#save").unbind("click").click();
                     }
                }
             });
            }
    });
});
</script>
<h1 class="judul">Master Data ICD 10</h1>
<? echo isset($pesan) ? $pesan : NULL; ?>
<?php
  if(isset ($_GET['do']) && $_GET['do'] != ""){
?>
<div class="data-input">
    <fieldset>
        <legend>Form <?= isset($_GET['do'])?$_GET['do']:'Tambah' ?> Data ICD 10</legend>
        <form action="<?= app_base_url('rekam-medik/control/icd_10') ?>" method="post">
            <label for="kode">Kode</label><input type="text" name="kode" id="kode" value="<?= $kode ?>" />
            <label for="nama">Nama</label><input type="text" name="nama" id="nama" value="<?= $nama ?>" />
            <label for="sub">Sub Deskripsi</label><input type="text" name="subDeskripsi" id="subDeskripsi" value="<?= $subDeskripsi ?>" />
            <fieldset class="input-process">
                <input type="hidden" value="<?= isset($_GET['id'])?$_GET['id']:NULL ?>" name="id" />
                <input type="submit" value="Simpan" name="save" id="save"/>
                <input type="button" value="Cancel" onclick=location.href="<?= app_base_url('rekam-medik/icd_10') ?>" />
            </fieldset>
        </form>
    </fieldset>
</div>
<?php
  }
?>
<div id="confirm-form" class='hidden-obj'>
    Apakah anda setuju menghapus data <span id="val"></span>?<br>
    <form action="<?= app_base_url('rekam-medik/control/icd_10'); ?>" method="post">
    <input type='hidden' id='idformhapus' name='idformhapus' />
    <input type='submit' value='Hapus' name='hapus' />
    <input type='button' value='Batal' onclick=location.href="<?= app_base_url('rekam-medik/icd_10') ?>" />
    </form>
</div>

<div class='data-list  w700px' style="clear:both">
    <div class="floleft">
        <a href="<?= app_base_url('/rekam-medik/icd_10/?do=add') ?>" class="add"><div class="icon button-add"></div>tambah</a>
    </div>
    <div class="floright">
        <form action="<?= app_base_url('rekam-medik/icd_10')?>" method="GET" class="search-form">
            <input type="text" name="key" id="key-nama" class="search-input"/><input type="submit" value="" class="search-button"/>
        </form>
    </div>
    <table class="tabel" cellpadding=2 cellspacing=0>
        <tr>
            <th style="width: 5%;">ID</th>
            <th style="width: 25%;">Kode ICD 10</th>
            <th style="width: 45%;">Nama ICD 10</th>
            <th style="width: 45%;">Sub Diskripsi 10</th>
            <th style="width: 10%;">Aksi</th>
        </tr>
        <?php
        foreach ($icd_10['list'] as $key => $row):
        ?>
            <tr class="<?= ($key % 2) ? 'even' : 'odd' ?>">
            <td align="center"><?= $row['id'] ?></td>
            <td><?= $row['kode'] ?></td>
            <td><?= $row['nama'] ?></td>
            <td><?= $row['sub_diskripsi'] ?></td>
            <td class="aksi">
                <a href="<?= app_base_url('rekam-medik/icd_10?do=edit&id='.$row['id'].'&page='.$page.'&key='.$cari.'') ?>" title="Edit" class="edit">Edit</a>
                <a title="Hapus" class="delete" onClick="deleteConfirm(<?= $row['id']; ?>,'<?= $row['kode'] ?>')">Delete</a>
            </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php
    echo $icd_10['paging'];
?>