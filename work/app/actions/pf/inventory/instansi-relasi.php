<?
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';
include_once 'app/actions/admisi/pesan.php';
require_once 'app/lib/common/master-inventory.php';
$code = isset($_GET['code'])?$_GET['code']:NULL;
$page = isset($_GET['page'])?$_GET['page']:NULL;
$sort = isset ($_GET['sort'])?$_GET['sort']:NULL;
$sortBy = isset ($_GET['sortBy'])?$_GET['sortBy']:NULL;
$key = isset ($_GET['key'])?$_GET['key']:NULL;
$jenis_instansi = jenis_instansi_relasi_muat_data();
$dataPerPage = 15;
$no=nomer_paging($page,$dataPerPage);
$all=instansi_relasi_muat_data(NULL,NULL,NULL,NULL,NULL,$key);
$instansi = instansi_relasi_muat_data($code,$sort, $sortBy, $page, $dataPerPage, $key);
?>
<script type="text/javascript">
$(function() {
    $('#nama').focus();
    $('#kelurahan').autocomplete("<?= app_base_url('/pf/inventory/search?opsi=allKelurahan') ?>",
    {
        parse: function(data){
            var parsed = [];
            for (var i=0; i < data.length; i++) {
                parsed[i] = {
                    data: data[i],
                    value: data[i].nama_kelurahan // nama field yang dicari
                };
            }
            return parsed;
        },
        formatItem: function(data,i,max){
            var str='<div class=result><b>'+data.nama_kelurahan+'</b> <i> '+data.nama_kecamatan+' <br/> '+data.nama_kabupaten+' '+data.nama_propinsi+'</i> </div>';
            return str;
        },
        width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
        dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
    })
    .result(
        function(event,data,formated){
            $('#kelurahan').attr('value',data.nama_kelurahan);
            $('#id-kelurahan').attr('value',data.id_kelurahan);
        }
    );
});
$(document).ready(function()
{
   /* $(".block").after('<span class="tooltip" style="width: 0px; height: 0px;"><span style="display: none;"></span></span>');
    $(".block").mouseover(function(event)
    {
        event.preventDefault();
        var index          = $(".block").index($(this));
        var tooltipContent = $("span.tooltip").eq(index).children().html();
        if(tooltipContent == '' || tooltipContent == null)
        {
            var value = '<ul class="tooltip" style="">';
            $.ajax(
            {
                url: "<?= app_base_url('/inventory/search?opsi=paging_instansi_relasi') ?>",
                data:'&page='+$(this).html()+'&perPage=15<?=isset($_GET['category'])?"&category=".$_GET['category']:""?><?=isset($_GET['sort'])?"&sort=".$_GET['sort']:""?><?=isset($_GET['sortBy'])?"&sortBy=".$_GET['sortBy']:""?><?=isset($_GET['key'])?"&key=".$_GET['key']:""?>',
                cache: false,
                dataType: 'json',
                success: function(data)
                {
                    for(var i=0;i<data.length;i++)
                    {
                        value += '<li>'+data[i].nama+" ";
                        value += '</li>';
                    }
                    value += '</ul>';
                    $("span.tooltip").eq(index).children().html(value);
                    $("span.tooltip").eq(index).mouseover();
                }
            });
        } else
            $("span.tooltip").eq(index).mouseover();
    });
    
    $("span.tooltip").tipsy(
    {
        gravity:'s',
        html:true,
        title:function(){return $(this).children().html()}
    });    
    $(".block").mouseout(function(event)
    {
        var index = $(".block").index($(this));
        $("span.tooltip").eq(index).mouseout();
    });*/
});
</script>
<h1 class="judul"><a href="<?= app_base_url('pf/inventory/instansi-relasi')?>">MASTER DATA INSTANSI RELASI</a></h1><?echo isset($pesan)?$pesan:NULL;?>
<?
if (isset($_GET['do'])) {
    if ($_GET['do'] == 'add') {
            require_once 'app/actions/pf/inventory/add-instansi-relasi.php';
    }
    else if ($_GET['do'] == 'edit') {
            require_once 'app/actions/pf/inventory/edit-instansi-relasi.php';
    }
}
?>
<? $page  = isset($_GET['page'])?$_GET['page']:NULL; ?>
<div class="data-list">
    <div style="display:block;width:100%">
        <div class="floleft" style='width: 50%'>
           <?php echo addButton('/pf/inventory/instansi-relasi/?do=add','Tambah'); ?>
        </div>
        <div class="floleft" style='width: 50%'>
            <form action="" method="GET"class="search-form" style="margin: -5px 0 0 0">
                    <span style="float:right;"><input type="text" name="key" class="search-input" id="keyword" value="<?= $key ?>"/><input type="submit" class="search-button" value=""/></span>
            </form>
        </div>
    </div>    
    <table class="tabel full">

            <tr>
                <th><!--<a href='<?//=app_base_url('pf/inventory/instansi-relasi?').  generate_sort_parameter(1, $sortBy)?>' class='sorting'></a>-->NO</th>
                <th><a href='<?=app_base_url('pf/inventory/instansi-relasi?').  generate_sort_parameter(2, $sortBy)?>' class='sorting'>Nama </a></th>
                <th>Alamat</th>
                <th>Kelurahan</th>
                <th>No. Telepon</th>
                <th>Email</th>
                <th>No. Fax</th>
                <th>Website</th>
                <th><a href='<?=app_base_url('pf/inventory/instansi-relasi?').  generate_sort_parameter(3, $sortBy)?>' class='sorting'>Jenis</a></th>
              <th>Aksi</th>
            </tr>

            <? foreach ($instansi['list']  as $num => $row): ?>
            <tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
                <td align="center"><?= $no++ ?></td>
                <td class="no-wrap"><?= $row['nama'] ?></td>
                <td style="width:25%"><?= $row['alamat'] ?></td>
                <td class="no-wrap"><?= $row['nama_kelurahan'] ?></td>
                <td><?= $row['telp']?></td>
                <td class="no-wrap"><?= $row['email']?></td>
                <td><?= $row['fax']?></td>
                <td class="no-wrap"><?= $row['website']?></td>
                <td class="no-wrap"><?= $row['jenis_instansi'] ?></td>
                <td class="aksi">
                    <a href="<?= app_base_url('/pf/inventory/instansi-relasi/?do=edit&id='.$row['id'])."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="edit"><small>edit</small></a>
                    <a href="<?= app_base_url('/pf/control/instansi-relasi/delete/?id='.$row['id'])."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="delete"><small>delete</small></a>
                </td>
            </tr>
            <? endforeach ?>
        </tbody>
    </table>
</div>
 <a class=excel class=tombol href="<?=app_base_url('pf/report/instansi-relasi-excel')?>">Cetak</a><p></p>
<?php
        echo $instansi['paging'];

	
 $count = count($all['list']);
      echo "<p>Jumlah Total Nama Instansi Relasi: ".$count."</p>";
?>
</div>