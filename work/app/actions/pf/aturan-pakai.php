<h2 class="judul"><a href="<?=  app_base_url('pf/aturan-pakai')?>">Master Data Aturan Pakai</a></h2>
<script type="text/javascript">
  $(function(){
      $('#keterangan').focus();
  })
</script>
<?php
require_once "app/lib/common/master-data.php";
require_once "app/lib/common/functions.php";
require_once "app/actions/admisi/pesan.php";

if (isset($_GET['do'])) {
	if ($_GET['do'] == 'add') {
		require "app/actions/pf/add-aturan-pakai.php";
	}else if ($_GET['do'] == 'edit') {
		require "app/actions/pf/edit-aturan-pakai.php";
	}
}
?>
<script type="text/javascript">
    
$(document).ready(function(){    
    $("#save").click(function(event){
        event.preventDefault();
         if($('#keterangan').attr('value')==''){
            alert('keterangan tidak boleh kosong');
            $('#keterangan').focus();
            return false;}
        else{
            var id=($(this).attr("name")=="edit"?'&id='+$('input[name=id]').attr('value'):'');
            $.ajax({
                url: "<?= app_base_url('inventory/search?opsi=cek_aturan')?>",
                data:'&nama='+$('#keterangan').attr('value')+id,
                cache: false,
                dataType: 'json',
                success: function(msg){
                    if(!msg.status){
                        alert('Keterangan aturan pakai sudah diinputkan ke database');
                        $('#keterangan').focus();
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

<?php
    echo isset($pesan)?$pesan:NULL;
    $page = isset($_GET['page'])?$_GET['page']:NULL;
    $code = isset($_GET['code'])?$_GET['code']:NULL;
    $key = isset($_GET['key'])?$_GET['key']:NULL;

	$sort	= isset($_GET['sort']) ? $_GET['sort'] : NULL;
	$by		= isset($_GET['by']) ? $_GET['by'] : 'asc';

	//membuat link sorting
	if($sort=='id' && $by == 'asc')
		$id = app_base_url('pf/aturan-pakai?sort=id&by=desc');
	else
		$id = app_base_url('pf/aturan-pakai?sort=id&by=asc');

	if($sort=='nama' && $by == 'desc')
		$nama = app_base_url('pf/aturan-pakai?sort=nama&by=asc');
	else
		$nama = app_base_url('pf/aturan-pakai?sort=nama&by=desc');
		$aturan_pakai = aturan_pakai_muat_list_data($code,$key,$sort,$by);
?>

<div class="data-list">
    <div style="display:block;width:50%">
        <div class="floleft" style='width: 50%'>
           <?php echo addButton('/pf/aturan-pakai?do=add','Tambah'); ?>
        </div>
        <div class="floleft" style='width: 50%'>
            <form action="" method="GET"class="search-form" style="margin: -5px 0 0 0">
                    <span style="float:right;"><input type="text" name="key" class="search-input" id="keyword" value="<?= $key ?>"/><input type="submit" class="search-button" value=""/></span>
            </form>
        </div>
    </div>       

  <table class="tabel" id="table" cellpadding="0" cellspacing="0" style="width: 50%">
        <tr>
            <th><a href="<?php echo $id ?>" class="sorting">ID</a></th>
            <th><a href="<?php echo $nama ?>" class="sorting">Nama</a></th>
	    <th>Aksi</th>
        </tr>
        <?php
		
		foreach($aturan_pakai['list'] as $num => $row): 
        ?>
        <tr class="<?= ($num%2) ? 'even':'odd' ?>">
             <td align="center" style="width: 5%;"><?= $row['id'] ?></td>
            <td class="no-wrap"><?= $row['nama'] ?></td>
            <td class="aksi" style="width: 10%;">
            <a href="<?= app_base_url('/pf/aturan-pakai?do=edit&id='.$row['id'].'')."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="edit"><small>edit</small></a>
            <a href="<?= app_base_url('/pf/control/aturan-pakai?id='.$row['id'].'')."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="delete"><small>delete</small></a></td>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?
      $count = count($aturan_pakai['list']);
      echo "<p>Jumlah Total Nama Aturan Pakai: ".$count."</p>";
    ?>
</div>
