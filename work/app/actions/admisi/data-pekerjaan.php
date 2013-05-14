<?php
require_once 'app/lib/common/master-data.php';
include 'app/actions/admisi/pesan.php';

$sort = isset($_GET['sort'])?$_GET['sort']:NULL;
$sortBy = isset($_GET['sortBy'])?$_GET['sortBy']:NULL;
$page = isset($_GET['page'])?$_GET['page']:NULL;
$code = isset($_GET['code'])?$_GET['code']:NULL;
$key = isset($_GET['key'])?$_GET['key']:NULL;
$pekerjaan = pekerjaan_muat_data($code, $sort,$sortBy, $page, $dataPerPage = 15, $key);
$numb=nomer_paging($page,$dataPerPage);
?>
<script type="text/javascript">

$(document).ready(function(){
    $('#pekerjaan').focus();        
    
    $("#save").click(function(event){
        event.preventDefault();
         if($('#pekerjaan').attr('value')==''){
            alert('Nama pekerjaan tidak boleh kosong !');
            $('#pekerjaan').focus();
            return false;
	}
        else{
            var id=($(this).attr("name")=="edit"?'&id='+$('input[name=idPekerjaan]').attr('value'):'');
            $.ajax({
                url: "<?= app_base_url('inventory/search?opsi=cek_Pekerjaan')?>",
                data:'&nama='+$('#pekerjaan').attr('value')+id,
                cache: false,
                dataType: 'json',
                success: function(msg){
                    if(!msg.status){
                        alert('Pekerjaan sudah ada di database !');
                        $('#pekerjaan').focus();
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
<div class="judul"><a href="<?= app_base_url('admisi/data-pekerjaan')?>">Master Data Pekerjaan</a></div><?= isset($pesan)?$pesan:NULL ?>
<?
if (isset($_GET['id'])) { 
	$id = isset($_GET['id'])?$_GET['id']:NULL;
	$edit = pekerjaan_muat_data($id);
	?>
	<div class="data-input">
	<fieldset><legend>Form Edit Data Pekerjaan</legend>
	    <form action="<?= app_base_url('/admisi/control/pekerjaan') ?>" method="post">
	        <input type="hidden" name="idPekerjaan" value="<?= $edit['id'] ?>" />
	        <label for="pekerjaan">Nama Pekerjaan</label><input type="text" name="pekerjaan" id="pekerjaan" value="<?= $edit['nama'] ?>" />
	         <fieldset class="input-process">
	            <input type="submit" value="Simpan" class="tombol" name="edit" />&nbsp;
	            <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('admisi/data-pekerjaan') ?>'" />
	     </fieldset>
	    </form>
	</fieldset>
	</div>

<?php }
else if (isset($_GET['do'])) { ?>
    
	<div class="data-input">
	<fieldset><legend>Form Tambah Data Pekerjaan</legend>
	    <form action="<?= app_base_url('/admisi/control/pekerjaan') ?>" method="post">
	        <input type="hidden" name="idPekerjaan" value="<?= $row['id'] ?>" />
	        <label for="pekerjaan">Nama Pekerjaan</label><input type="text" name="pekerjaan" id="pekerjaan"/>
	         <fieldset class="input-process">
	            <input type="submit" value="Simpan" class="tombol" name="add" id="save"/>&nbsp;
	            <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('admisi/data-pekerjaan') ?>'" />
	     </fieldset>
	    </form>
	</fieldset>
	</div>

<?php }

if (!isset($_GET['do'])) {
?>
<?php } ?>
<div class="data-list">
    <div style="display:block;width:50%">
        <div class="floleft" style='width: 50%'>
           <?php echo addButton('/admisi/data-pekerjaan/?do=add','Tambah Pekerjaan'); ?>
        </div>
        <div class="floleft" style='width: 50%'>
            <form action="" method="GET"class="search-form" style="margin: -5px 0 0 0">
                    <span style="float:right;"><input type="text" name="key" class="search-input" id="keyword" value="<?= $key ?>"/><input type="submit" class="search-button" value=""/></span>
            </form>
        </div>
    </div>
    <br/>    
	
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="tabel" style="width: 50%;">

			<tr>
				<th>NO</th>
              <th><a href='<?=app_base_url('admisi/data-pekerjaan?').  generate_sort_parameter(1, $sortBy)?>' class='sorting'>Nama Pekerjaan</a></th>
				<th>Aksi</th>
			</tr>
            <?php 
		
			foreach($pekerjaan['list'] as $num => $row): ?>
			<tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
				 <td align="center" style="width: 5%"><?= $numb++ ?></td>
				<td><?= $row['nama'] ?></td>
				<td class="aksi" style="width: 10%;">
				<a href="<?= app_base_url('admisi/data-pekerjaan/?do=edit&id='.$row['id'].'')."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="edit"><small>edit</small></a>
				<a href="<?= app_base_url('admisi/control/pekerjaan/?id='.$row['id'].'')."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="delete"><small>delete</small></a>
				</td>
				
			</tr>
            <?php endforeach; ?>
  </table>
</div>
<?= $pekerjaan['paging'];
$count = $pekerjaan['total'];
      echo "<p>Jumlah Total Nama Pekerjaan: ".$count."</p>";?>
