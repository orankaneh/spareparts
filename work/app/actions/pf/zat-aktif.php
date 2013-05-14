<?php

require_once 'app/lib/pf/farmakologi.php';
require_once 'app/lib/pf/zat-aktif.php';
require_once 'app/actions/admisi/pesan.php';

//$subSubFarmakologi = farmakologi_muat_data_sub_sub_farmakologi();
$subSubFarmakologi =sub_sub_farmakologi_muat_data();
//$id = isset($_GET['id'])?$_GET['id']:NULL;
$key = isset($_GET['key'])?$_GET['key']:NULL;

	$sort	= isset($_GET['sort']) ? $_GET['sort'] : NULL;
	$by		= isset($_GET['by']) ? $_GET['by'] : 'asc';

	//membuat link sorting
	if($sort=='id' && $by == 'asc')
		$id = app_base_url('pf/zat-aktif?sort=id&by=desc');
	else
		$id = app_base_url('pf/zat-aktif?sort=id&by=asc');

	if($sort=='nama' && $by == 'desc')
		$nama = app_base_url('pf/zat-aktif?sort=nama&by=asc');
	else
		$nama = app_base_url('pf/zat-aktif?sort=nama&by=desc');
$zatAktif = zat_aktif_muat_data($id = null,$key, $sort, $by);
$no = 1;
?>
<script type="text/javascript">
    $(function(){
        $('#satuan-kode').focus();
        $("#save").click(function(event){
            event.preventDefault();
             if($('input[name=nama]').attr('value')==''){
                alert('Nama Zat Aktif tidak boleh kosong');
                $('input[name=nama]').focus();
                return false;
            }else{
                var id=($(this).attr("name")=="edit"?'&id='+$('input[name=id]').attr('value'):'');
                $.ajax({
                    url: "<?= app_base_url('inventory/search?opsi=cek_zat_aktif')?>",
                    data:'&nama='+$('input[name=nama]').attr('value')+id,
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
    })
    function cekIsian(data) {
    }
</script>
<h2 class="judul">Master zat aktif</h2>
<?
if (isset($_GET['do'])) {
    if ($_GET['do'] == 'add') {
            require_once 'app/actions/pf/add-zat-aktif.php';
    }
    else if ($_GET['do'] == 'edit') {
            require_once 'app/actions/pf/edit-zat-aktif.php';
    }
}
?>

<? echo isset($pesan)?$pesan:NULL; ?>
<div class="data-list">
    <div style="display:block;width:50%">
        <div class="floleft" style='width: 50%'>
           <?php echo addButton('/pf/zat-aktif/?do=add','Tambah'); ?>
        </div>
        <div class="floleft" style='width: 50%'>
            <form action="" method="GET"class="search-form" style="margin: -5px 0 0 0">
                    <span style="float:right;"><input type="text" name="key" class="search-input" id="keyword" value="<?= $key ?>"/><input type="submit" class="search-button" value=""/></span>
            </form>
        </div>
    </div>   
   <table cellpadding="0" cellspacing="0" border="0" id="table" class="tabel" style="width: 50%;">
            <tr>
                <th>NO</th>
                <th><a href="<?php echo $nama; ?>" class="sorting">Nama Zat Aktif</a></th>
                <th>Aksi</th>
            </tr>
            <? foreach ($zatAktif as $num => $row): ?>
            <tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
                <td align="center" style=" width: 5%;"><?= $no++; ?></td>
                <!--td><?= $row['id'] ?></td-->
                <td><?= $row['nama'] ?></td>

              <td class="aksi" style="width: 10%;">
                    <a href="<?= app_base_url('/pf/zat-aktif/?do=edit&id='.$row['id'])."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="edit"><small>edit</small></a>
                    <a href="<?= app_base_url('/pf/control/zat-aktif/zat-aktif/?id='.$row['id'])."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="delete"><small>hapus</small></a>
                </td>
            </tr>
            <? endforeach; ?>
    </table>
</div>