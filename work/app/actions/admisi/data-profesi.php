<?
require_once 'app/lib/common/master-data.php';
include 'app/actions/admisi/pesan.php';
$sort = isset($_GET['sort'])?$_GET['sort']:NULL;
$sortBy = isset($_GET['sortBy'])?$_GET['sortBy']:NULL;
$key = isset($_GET['key'])?$_GET['key']:NULL;
$code = isset($_GET['code'])?$_GET['code']:NULL;
$pekerjaan = profesi_muat_data($code, $sort,$sortBy, $key);

?>
<div class="judul"><a href="<?= app_base_url('admisi/data-profesi')?>">Master Data profesi</a></div><?= isset($pesan)?$pesan:NULL?>
<?
if (isset($_GET['id'])) {
    require_once 'app/actions/admisi/edit-profesi.php';
}
else if (isset($_GET['do'])) {
    require_once 'app/actions/admisi/add-profesi.php';
}

?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#profesi").focus();
    
    $("#save").click(function(event){
        event.preventDefault();
         if($('#profesi').attr('value')==''){
            alert('Nama profesi tidak boleh kosong');
            $('#profesi').focus();
            return false;
        }else{
            var id=($(this).attr("name")=="edit"?'&id='+$('input[name=idProfesi]').attr('value'):'');
            $.ajax({
                url: "<?= app_base_url('inventory/search?opsi=cek_Profesi')?>",
                data:'&nama='+$('#profesi').attr('value')+id,
                cache: false,
                dataType: 'json',
                success: function(msg){
                    if(!msg.status){
                        alert('Nama yang sama sudah pernah diinputkan');
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
	<div class="data-list w700px">
        <div class="floleft"> <?php echo addButton('/admisi/data-profesi/?do=add','Tambah'); ?></div>
        <div class="floright" style="margin: -5px 0 0 0">
            <form action="" method="GET" class="search-form">
                    <span style="float:right;"><input type="text" name="key" class="search-input" id="keyword" value="<?= $key ?>"/><input type="submit" class="search-button" value=""/></span>
            </form>
        </div>
   
	<table id="table" class="tabel full">
		<tr>
			<th width="20%"><!--<a href='<?//=app_base_url('admisi/data-profesi?').  generate_sort_parameter(1, $sortBy)?>' class='sorting'></a>-->NO</th>
			<th width="50%"><a href='<?=app_base_url('admisi/data-profesi?').  generate_sort_parameter(2, $sortBy)?>' class='sorting'>Nama Profesi</a></th>
                        <th>Jenis Profesi</th>
                        <th width="10%">Aksi</th>
			
		</tr>
		<?php foreach($pekerjaan as $num => $row): ?>
		<tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
			<td align="center"><?= ++$num ?></td>
			<td><?= $row['nama'] ?></td>
                        <td>
                          <?php
                             if($row['jenis'] == "Nakes"){
                                 echo "Nakes";
                             }else echo "Bukan Nakes";
                          ?>
                        </td>
			<td class="aksi">
			<a href="<?= app_base_url('admisi/data-profesi/?do=edit&id='.$row['id'].'')."&".generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="edit"><small>edit</small></a>
                        <a href="<?= app_base_url('admisi/control/profesi/?id='.$row['id'])."&".generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="delete"><small>delete</small></a>
			</td>
		</tr>
		<?php endforeach; ?>
  </table>
</div>

<?
      $count = count($pekerjaan);
      echo "<p>Jumlah Total Nama Profesi: ".$count."</p>";
	  ?>