<?php
require_once 'app/lib/common/master-data.php';
include 'app/actions/admisi/pesan.php';
$page = isset ($_GET['page'])?$_GET['page']:NULL;
$code = isset($_GET['code'])?$_GET['code']:NULL;
$key = isset($_GET['key'])?$_GET['key']:NULL;
$sort = isset($_GET['sort']) ? $_GET['sort'] : NULL;
$sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : NULL;
$spesialisasi = spesialisasi_muat_data($code,$page,$dataPerPage=15,$sort, $sortBy,$key);
$nos=nomer_paging($page,$dataPerPage=15);
?>
<script type="text/javascript">
$(function() {
    $('#spesialisasi').focus();
        $('#profesi').autocomplete("<?= app_base_url('/admisi/search?opsi=profesi') ?>",
        {
                    parse: function(data){
                        var parsed = [];
                        for (var i=0; i < data.length; i++) {
                            parsed[i] = {
                                data: data[i],
                                value: data[i].nama // nama field yang dicari
                            };
                        }
                        return parsed;
                    },
                    formatItem: function(data,i,max){
                        var str='<div class=result>'+data.nama+'</div>';
                        return str;
                    },
                    width: 270, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                $('#profesi').attr('value',data.nama);
                $('#idProfesi').attr('value',data.id);
            }
        );
});
</script>
<script type="text/javascript">
		$(document).ready(function(){
    
    $("#save").click(function(event){
        event.preventDefault();
         if($('#spesialisasi').attr('value')==''){
            alert('Nama spesialisasi tidak boleh kosong');
            $('#spesialisasi').focus();
            return false;
			}
			   if($('#idProfesi').attr('value')==''){
            alert('Nama profesi tidak boleh kosong');
            $('#idProfesi').focus();
            return false;
        }else{
		var nama = $('#spesialisasi').attr('value');
	var prof = $('#idProfesi').attr('value');
            var id=($(this).attr("name")=="edit"?'&id='+$('input[name=idSpesialisasi]').attr('value'):'');
            $.ajax({
                url: "<?= app_base_url('inventory/search?opsi=cek_special')?>",
				 data:'&nama='+nama+'&profesi='+prof+id,
                cache: false,
                dataType: 'json',
                success: function(msg){
                    if(!msg.status){
                        alert('Nama spesialisai dan profesi yang sama sudah pernah diinputkan');
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
        


<div class="judul"><a href="<?= app_base_url('admisi/data-spesialisasi')?>">Master Data Spesialisasi Profesi</a></div>
<?php echo isset($pesan)?$pesan:NULL;?>
<?
  if(isset ($_GET['do'])){
      if($_GET['do'] == 'add'){
          require_once 'add-spesialisasi.php';
      }else if($_GET['do'] == 'edit'){
          require_once 'edit-spesialisasi.php';
      }
  }
?>
<div class="data-list">
    <div style="display:block;width:50%">
        <div class="floleft" style='width: 50%'>
           <?php echo addButton('/admisi/data-spesialisasi/?do=add','Tambah Spesialisasi'); ?>
        </div>
        <div class="floleft" style='width: 50%'>
            <form action="" method="GET"class="search-form" style="margin: -5px 0 0 0">
                    <span style="float:right;"><input type="text" name="key" class="search-input" id="keyword" value="<?= $key ?>"/><input type="submit" class="search-button" value=""/></span>
            </form>
        </div>
    </div>
   <br/>
         <table class="tabel" id="table" cellpadding="0" cellspacing="0" style="width: 50%">
            <tr>
                <th>NO</th>
                <th>Nama Spesialisasi</th>
                <th>Profesi</th>
                <th>Aksi</th>
            </tr>
            <?  foreach ($spesialisasi['list'] as $num => $row){
			$no=$row['id'];
            ?>    
             <tr class="<?= ($num%2) ? 'even':'odd' ?>">
                   <td align=center style="width: 5%;"><?= ($nos++) ?></td>
                <td class="no-wrap"><?= $row['nama']?></td>
                <td class="no-wrap"><?= $row['profesi']?></td>
                 <td align=center class="aksi" style="width: 10%;">
                  <?    if ($no == '1'){
		echo "-";
		}
		else {
		?>
                    <a href="<?= app_base_url('admisi/data-spesialisasi/?do=edit&id='.$row['id'].'')."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="edit"><small>edit</small></a>
                    <a href="<?= app_base_url('admisi/control/spesialisasi/?id='.$row['id'].'')."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="delete"><small>delete</small></a>
                </td>
            </tr>
            <?}
            }
            ?>
        </table>    
</div>
<?
      $count = count($spesialisasi['list']);
      echo "<p>Jumlah Total Nama Profesi Spesialisasi: ".$count."</p>";
      echo "$spesialisasi[paging]";
	  ?>
<script type="text/javascript">
    $(document).ready(function(){
    /*    $(".block").after('<span class="tooltip" style="width:0px;height:0px"><span style="display:none"></span></span>');
        $(".block").mouseover(function(event){
            event.preventDefault();
            var index=$(".block").index($(this));
            var tooltipContent=$("span.tooltip").eq(index).children().html();
            if(tooltipContent==''||tooltipContent==null){
                //var value="<table style='text-align:left'cellspacing='2' width='100%'>";
                var value='<ul class="tooltip" style="">';
                $.ajax({
                    url: "<?= app_base_url('/admisi/search?opsi=paging_spesialisasi') ?>",
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