<?php
require_once 'app/lib/pf/satuan.php';
require_once 'app/actions/admisi/pesan.php';
$sort = isset($_GET['sort']) ? $_GET['sort'] : NULL;
$code = isset($_GET['code']) ? $_GET['code'] : NULL;
$page = isset($_GET['page']) ? $_GET['page'] : NULL;
$sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : NULL;
$dataPerPage = 15;
$key = isset($_GET['key'])?$_GET['key']:NULL;
$satuan = satuan_muat_data($code, $sort, $sortBy, $page, $dataPerPage,$key);
$no=nomer_paging($page,$dataPerPage);
?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#satuan-title').focus();   
    
    $("#save").click(function(event){
        event.preventDefault();
         if($('#satuan-title').attr('value')==''){
            alert('Nama satuan tidak boleh kosong');
            $('#satuan-title').focus();
            return false;
        }else{
            if(!isNama($('#satuan-title').attr('value'))){
                alert("Nama satuan hanya boleh berisi alphabet dan spasi");
                $('#satuan-title').focus();
                return false;
            }else{
                var id=($(this).attr("name")=="edit"?'&id='+$('input[name=id]').attr('value'):'');
                $.ajax({
                    url: "<?= app_base_url('inventory/search?opsi=cek_Satuan')?>",
                    data:'&nama='+$('#satuan-title').attr('value')+id,
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
        }
    });
});
        
        </script>
        
<h2 class="judul"><a href="<?= app_base_url('pf/satuan') ?>">Master Data Satuan</a></h2>
<?
if (isset($_GET['do'])) {
    if ($_GET['do'] == 'add') {
        require_once 'app/actions/pf/add-satuan.php';
    } else if ($_GET['do'] == 'edit') {
        require_once 'app/actions/pf/edit-satuan.php';
    }
}
?>
<? echo isset($pesan) ? $pesan : NULL; ?>
<div class="data-list w600px">
	<div class="floleft"><?php echo addButton('/pf/satuan/?do=add','Tambah'); ?></div>
    <div class="floright">
		<form action="" method="GET"class="search-form" style="margin: -5px 0 0 0">
				<span style="float:right;"><input type="text" name="key" class="search-input" id="keyword" value="<?= $key ?>"/><input type="submit" class="search-button" value=""/></span>
		</form>
    </div>

    <table class="tabel full">
        <tr>
            <th>NO</th>
            <th style="width:50%"><a href="<?= app_base_url('pf/satuan?') . generate_sort_parameter(2, $sortBy) ?>" class="sorting">Nama Satuan</a></th>
            <th>Aksi</th>
        </tr>
<? foreach ($satuan['list'] as $num => $row): ?>
            <tr class="<?= ($num % 2) ? 'even' : 'odd' ?>">
             <td align="center" style="width: 5%"><?= $no++ ?></td>
            <td><?= $row['nama'] ?></td>
            <td class="aksi" style="width: 10%;">
                <a href="<?= app_base_url('/pf/satuan/?do=edit&id=' . $row['id'])."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="edit"><small>edit</small></a>
                <a href="<?= app_base_url('/pf/control/satuan/satuan/?id=' . $row['id'])."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="delete"><small>hapus</small></a>
            </td>
        </tr>
<? endforeach; ?>

    </table>
</div>
<?=
        $satuan['paging'];
        $count = $satuan['total'];
        echo "<p>Jumlah Total Nama Satuan: " . $count . "</p>"; ?>
<script type="text/javascript">
    $(document).ready(function(){
   /*     $(".block").after('<span class="tooltip" style="width:0px;height:0px"><span style="display:none"></span></span>');
        $(".block").mouseover(function(event){
            event.preventDefault();
            var index=$(".block").index($(this));
            var tooltipContent=$("span.tooltip").eq(index).children().html();
            if(tooltipContent==''||tooltipContent==null){
                //var value="<table style='text-align:left'cellspacing='2' width='100%'>";
                var value='<ul class="tooltip" style="">';
                $.ajax({
                    url: "<?= app_base_url('/pf/search?opsi=paging_satuan') ?>",
                    data:'page='+$(this).html()+'&perPage=<?=$dataPerPage?>&<?= generate_get_parameter($_GET, null, array('page')) ?>',
                    cache: false,
                    dataType: 'json',
                    success: function(data){
                        data=data.list;
                        for(var i=0;i<data.length;i++){
                            value+='<li>'+data[i].nama+" ";
                            value+='</li>';
                        }
                        value+='</ul>';
                        $("span.tooltip").eq(index).children().html(value);
                        $("span.tooltip").eq(index).mouseover();
                    }
                });
            }else{
                $("span.tooltip").eq(index).mouseover();
            }
        });
        
            
        $("span.tooltip").tipsy({
            gravity:'w',
            html:true,
            title:function(){return $(this).children().html()}
        });    
            
        $(".block").mouseout(function(event){
            var index=$(".block").index($(this));
            $("span.tooltip").eq(index).mouseout();
                
        });*/
    });
</script>