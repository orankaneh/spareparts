<?php
require_once 'app/lib/common/master-data.php';
include 'app/actions/admisi/pesan.php';
$key = isset ($_GET['key'])?$_GET['key']:NULL;
$page  = isset($_GET['page'])?$_GET['page']:NULL;
$sort = isset ($_GET['sort'])?$_GET['sort']:NULL;
$sortBy = isset ($_GET['sortBy'])?$_GET['sortBy']:NULL;
$code = isset ($_GET['code'])?$_GET['code']:NULL;
$category = isset ($_GET['category'])?$_GET['category']:NULL;
$searcing='';
if (($category !='')and (get_value('bed')!='')){
if($searcing=''){
$searcing="category=".$category."&bed=".get_value('bed');
}
else{
$searcing='';
}
}
$data = bed_by_kelas_instalasi($code, $page, $dataPerPage = 15, $sort,get_value('bed'),get_value('category'),$sortBy);
$no=nomer_paging($page,$dataPerPage);
if($code!=null){
    $bed=array();
    $bed['list'][0] =$data;
//    show_array($bed);
}else $bed=$data;
?>
<div class="judul"><a href="<?= app_base_url('admisi/data-bed')?>">Administrasi Kamar/Bed/Klinik</a></div><?php echo isset($pesan)?$pesan:NULL;?>

    <script type="text/javascript">
     $(document).ready(function(){
    $('#bed').focus();
    
    $("#save").click(function(event){
        event.preventDefault();
         if($('#bed').attr('value')==''){
            alert('Nomor kamar tidak boleh kosong !');
            $('#bed').focus();
            return false;
	}
	    else if($('#kelas').attr('value')==''){
            alert('kelas tidak boleh kosong !');
            $('#kelas').focus();
            return false;
	}
	    else if($('#instalasi').attr('value')==''){
            alert('instalasi tidak boleh kosong !');
            $('#instalasi').focus();
            return false;
	}else{
                        var data=$('form').serialize();
                        data=data+'&'+$(this).attr('name')+'=';
                        console.log(data);
                        $.ajax({
                            url: "<?= app_base_url('admisi/search?opsi=cek_bed')?>",
                            data:data,
                            cache: false,
                            dataType: 'json',
                            success: function(msg){
                                if(!msg.status){
                                    alert('data bed yang sama sudah pernah diinputkan');
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
    <?
	if (isset($_GET['do'])) {
    $instalasi=instalasi_muat_data();
    if ($_GET['do'] == 'add') {
            require_once 'app/actions/admisi/add-bed.php';
    }
    else if ($_GET['do'] == 'edit') {
            require_once 'app/actions/admisi/edit-bed.php';
    }
}else{
    ?>
    

    <?
}
?>
<script type="text/javascript">
  $(function(){
         if($('#category').val()!=0){
            $('#keyword').removeAttr("disabled");
        }else{
            $('#category').change(function(){
                if($('#category').val()!=0){
                    $('#keyword').removeAttr("disabled");
                }else{
                    $('#keyword').attr("disabled","disabled");
                }
            });
        }
  })
</script>
<div class="data-list w800px">
 <div class="floleft">
    <a href="<?= app_base_url('/admisi/data-bed/?do=add') ?>" class="add"><div class="icon button-add"></div>Tambah</a>
 </div>
 <div class="floright">   
       <form action="<?=app_base_url('admisi/data-bed')?>" method="GET" class="search-form"> 
       <select name="category" id="category" class="select-style" style="width: 150px">
          <option value="0">Cari Berdasarkan</option>
          <option value="1" <?if($category == 1){echo "selected";}?>>No. Kamar/Bed/Klinik</option>
          <option value="2" <?if($category == 2){echo "selected";}?>>Instalasi/Ruang</option>
       </select>    
       <input type="text" name="bed" value="<?=get_value('bed')?>" class="search-input" id="keyword" <?=(empty($_GET['bed'])?'disabled':'')?>/>
       <input type="submit" value="" name="cari" class="search-button"/>
       </form>
 </div>    
    <table cellpadding="0" cellspacing="0" border="0" id="table" class="tabel" style="width:100%">
        <tr>
           <th style="width:5%;">No</th>
            <th style="width:10%"><a href=<?= app_base_url('admisi/data-bed/?'.$searcing.generate_sort_parameter(4, $sortBy))?>" class="sorting">No. Kamar</a></th>
            
            <th><a href="<?= app_base_url('admisi/data-bed/?'.$searcing.generate_sort_parameter(2, $sortBy))?>" class="sorting">Instalasi/Ruang</a></th>
            <th><a href="<?= app_base_url('admisi/data-bed/?'.$searcing.generate_sort_parameter(3, $sortBy))?>" class="sorting">Kelas</a></th>
            <th><a href="<?= app_base_url('admisi/data-bed/?'.$searcing.generate_sort_parameter(6, $sortBy))?>" class="sorting">Jenis</a></th>
            <th><a href="<?= app_base_url('admisi/data-bed/?'.$searcing.generate_sort_parameter(5, $sortBy))?>" class="sorting">Status</a></th>
            <th style=" width: 20%">Aksi</th>
        </tr>
        <?
        foreach ($bed['list'] as $num => $row){
        ?>
          <tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
             <td align="center"><?=$no++?></td>
            <td><span class="kelas<?php echo $num;?>"><?= $row['nama']?></span></td>  
            <td class="no-wrap"><span class="instalasi<?php echo $num; ?>" style="display: none;"><?php echo $row['aidi'];?></span><?= $row['instalasi']?></td>
            <td><?= $row['kelas']?></td>
            <td><?= $row['jenis']?></td>
            <td class="no-wrap"><?= $row['status']?></td>
            <td class="aksi">
                <a href="<?= app_base_url('admisi/data-bed/?do=edit&id='.$row['id'].'')."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id'))?>" class="edit"><small>edit</small></a>
                <a href="<?= app_base_url('admisi/control/bed/?id='.$row['id'].'')."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id'))?>" class="delete"><small>delete</small></a>
            </td>
          </tr>    
        <?
        }
        ?>
   </table>
</div>
<?= (isset($bed['paging']))?$bed['paging']:null ?>