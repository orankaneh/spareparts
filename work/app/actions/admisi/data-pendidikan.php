<?
require_once 'app/lib/common/master-data.php';
include 'app/actions/admisi/pesan.php';
$code = isset($_GET['code'])?$_GET['code']:NULL;
$sort = isset($_GET['sort'])?$_GET['sort']:NULL;
$sortBy = isset($_GET['sortBy'])?$_GET['sortBy']:NULL;
$key = isset($_GET['key'])?$_GET['key']:NULL;
$pendidikan = pendidikan_muat_data($code,$sort,$sortBy,$key);
?>
<div class="judul"><a href="<?= app_base_url('admisi/data-pendidikan')?>">Master Data Tingkat Pendidikan</a></div><?= isset($pesan)?$pesan:NULL?>
<?
if (isset($_GET['do'])) {
    ?>
  
<script type="text/javascript">
    $(document).ready(function(){
        $("#pendidikan").focus();         
    
    $("#save").click(function(event){
        event.preventDefault();
         if($('#pendidikan').attr('value')==''){
            alert('Nama pendidikan tidak boleh kosong');
            $('#pendidikan').focus();
            return false;
        }else{
            var id=($(this).attr("name")=="edit"?'&id='+$('input[name=idPendidikan]').attr('value'):'');
            $.ajax({
                url: "<?= app_base_url('inventory/search?opsi=cek_Pendidikan')?>",
                data:'&nama='+$('#pendidikan').attr('value')+id,
                cache: false,
                dataType: 'json',
                success: function(msg){
                    if(!msg.status){
                        alert('Nama yang sama sudah pernah diinputkan');
                        return false;
                     }else{
                         $("form input[type=submit]").unbind("click").click();
                     }
                }
             });
        }
    });
});
        
        </script>
    <?
    if ($_GET['do'] == 'add') {
            require_once 'app/actions/admisi/add-pendidikan.php';
    }
    else if ($_GET['do'] == 'edit') {
            require_once 'app/actions/admisi/edit-pendidikan.php';
    }
}

?>
<div class="data-list"><br>
    <div style="display:block;width:430px">
        <div class="floleft" style='width: 50%'>
            <?php echo addButton('/admisi/data-pendidikan/?do=add','Tambah'); ?>
        </div>
        <div class="floleft" style='width: 50%'>
            <form action="" method="GET"class="search-form" style="margin: -5px 0 0 0">
                    <span style="float:right;"><input type="text" name="key" class="search-input" id="keyword" value="<?= $key ?>"/><input type="submit" class="search-button" value=""/></span>
            </form>
        </div>
    </div>
   <br/><br/>
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="tabel" style="width:430px;">
	<tr>
            <th><!--<a href="<?//=  app_base_url('admisi/data-pendidikan/?'). generate_sort_parameter(1, $sortBy)?>" class="sorting"></a>-->NO</th>
            <th><a href="<?=  app_base_url('admisi/data-pendidikan/?'). generate_sort_parameter(2, $sortBy)?>" class="sorting">Nama Pendidikan</a></th>
            <th>Aksi</th>
				
	</tr>
		<?php foreach($pendidikan as $num => $row): ?>
        <tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
            <td align=center><?= ++$num ?></td>
            <td><?= $row['nama'] ?></td>
            <td align=center class="aksi">
            <a href="<?= app_base_url('admisi/data-pendidikan/?do=edit&id='.$row['id'].'')."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="edit"><small>edit</small></a>
            <a href="<?= app_base_url('admisi/control/pendidikan/?id='.$row['id'].'')."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="delete"><small>delete</small></a></td>
        </tr>
        <?php endforeach; ?>
  </table>
</div>
<?
      $count = count($pendidikan);
      echo "<p>Jumlah Total Nama Pendidikan: ".$count."</p>";
	  ?>