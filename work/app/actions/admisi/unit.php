<?php
require_once 'app/lib/common/master-data.php';
include 'app/actions/admisi/pesan.php';
$key = isset ($_GET['key'])?$_GET['key']:NULL;
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
$sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : '';
if (isset($_GET['do']) && $_GET['do'] == 'edit') {
    $result = unit_muat_data($_GET['id']);
}

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$perPage = 15;
$id = (isset($result)) ? $result['id'] : null;
$nama = (isset($result)) ? $result['nama'] : null;
$code = isset($_GET['code']) ? $_GET['code'] : NULL;
$jenisRelasi = $unit = unit_muat_data($code, $sort, $sortBy, $page, $perPage, $key);
$no=nomer_paging($page,$perPage);
?>
<h1 class="judul"><a href="<?= app_base_url('admisi/unit') ?>">Master Data Unit Organisasi</a></h1><?= isset($pesan) ? $pesan : NULL ?>
<?
if (isset($_GET['do']) && ($_GET['do'] == 'edit' || $_GET['do'] == 'add')) {
    if ($_GET['do'] == "add") {
        $title = "Form Tambah Data Unit Organisasi";
    } else if ($_GET['do'] == "edit") {
        $title = "Form Edit Data Unit Organisasi";
    }else
        $title = "";
    ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#jenis-induk-nama').focus();
            $("form").submit(function(event){
                event.preventDefault();
                $("form input[type=submit]").click();
            });
        
            $("input[name=simpan]").click(function(event){
                event.preventDefault();
                if($('#jenis-induk-nama').attr('value')==''){
                    alert('Nama jenis instansi masih kosong');
                    $('#jenis-induk-nama').focus();
                    return false;
                }else{
                    var id='&id='+$('input[name=id]').attr('value');
                    $.ajax({
                        url: "<?= app_base_url('inventory/search?opsi=cek_unit') ?>",
                        data:'&nama='+$('#jenis-induk-nama').attr('value')+id,
                        cache: false,
                        dataType: 'json',
                        success: function(msg){
                            if(!msg.status){
                                alert('Nama yang sama sudah pernah diinputkan');
                                return false;
                            }else{
                                $("form input[name=simpan]").unbind("click").click();
                            }
                        }
                    });
                }
            });
        });
    </script>
    <div class="data-input">
        <form action="<?= app_base_url('/admisi/control/unit') ?>" method="post">
            <fieldset>
                <legend><?= $title ?></legend>
                <input type="hidden" name="id" value="<?= $id ?>" />
                <label for="jenis-induk-nama">Nama</label>
                <input type="text" id="jenis-induk-nama" name="nama" value="<?= $nama ?>" />
                <fieldset class="input-process">
                    <input type="submit" value="Simpan" name="simpan" class="tombol"/>
                    <input type="button" value="Batal" class="tombol" onclick="javascript:location.href='<?= app_base_url('admisi/unit') ?>'">
                </fieldset>
            </fieldset>
        </form>
    </div>
    <?
}
?>
<div class="data-list"><br>
    <div style="display:block;width:50%">
        <div class="floleft" style='width: 50%'>
            <?php echo addButton('admisi/unit/?do=add','Tambah'); ?>
        </div>
        <div class="floleft" style='width: 50%'>
            <form action="" method="GET"class="search-form" style="margin: -5px 0 0 0">
                    <span style="float:right;"><input type="text" name="key" class="search-input" id="keyword" value="<?= $key ?>"/><input type="submit" class="search-button" value=""/></span>
            </form>
        </div>
    </div>
   <br/><br/>
   
 
 <table cellpadding="0" cellspacing="0" border="0" id="table" class="tabel" style="width: 50%">

        <tr>
            <th>NO</th>
            <th><a href='<?= app_base_url('admisi/unit?') . generate_sort_parameter(2, $sortBy) ?>' class='sorting'>Nama</a></th>
            <th>Aksi</th>
        </tr>

<? foreach ($jenisRelasi['list'] as $num => $row): ?>
            <tr class="<?= ($num % 2) ? 'even' : 'odd' ?>">
               <td align="center" style="width: 5%"><?= ($no++) ?></td>
                <td class="no-wrap"><?= $row['nama'] ?></td>
                  <td class="aksi" style="width: 10%;">
    <? if ($row['id'] < 1 || $row['id'] > 3) { ?>
                        <a href="<?= app_base_url('/admisi/unit/?do=edit&id=' . $row['id'])."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="edit"><small>edit</small></a>
                        <a href="<?= app_base_url('/admisi/control/unit?do=delete&id=' . $row['id'])."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="delete"><small>hapus</small></a>
    <?
    }else
        echo"-";
    ?>
                </td>
            </tr>
<? endforeach ?>
    </table>
</div>
<?php
echo $jenisRelasi['paging'];

$count = $jenisRelasi['total'];
echo "<p>Jumlah Total Nama Unit: " . $count . "</p>";
?>
<script type="text/javascript">
    $(document).ready(function(){
       /* $(".block").after('<span class="tooltip" style="width:0px;height:0px"><span style="display:none"></span></span>');
        $(".block").mouseover(function(event){
            event.preventDefault();
            var index=$(".block").index($(this));
            var tooltipContent=$("span.tooltip").eq(index).children().html();
            if(tooltipContent==''||tooltipContent==null){
                //var value="<table style='text-align:left'cellspacing='2' width='100%'>";
                var value='<ul class="tooltip" style="">';
                $.ajax({
                    url: "<?= app_base_url('/admisi/search?opsi=paging_unit') ?>",
                    data:'page='+$(this).html()+'&perPage=<?= $perPage ?>&<?= generate_get_parameter($_GET, null, array('page')) ?>',
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