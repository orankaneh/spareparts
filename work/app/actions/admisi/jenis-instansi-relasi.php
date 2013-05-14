<?php
require_once 'app/lib/common/master-inventory.php';
require_once 'app/lib/common/functions.php';
if (isset($_GET['do']) && $_GET['do'] == 'edit') {
    $result = jenis_instansi_relasi_muat_data($_GET['id']);
    $title = "Form Edit Data Jenis Instansi Relasi";
} else if (isset($_GET['do']) && $_GET['do'] == 'add') {
    $title = "Form Tambah Data Jenis Instansi Relasi";
}else
    $title = "";

$id = (isset($result)) ? $result['id'] : null;
$nama = (isset($result)) ? $result['nama'] : null;
$sort = isset($_GET['sort']) ? $_GET['sort'] : NULL;
$code = isset($_GET['code']) ? $_GET['code'] : NULL;
$page = isset($_GET['page']) ? $_GET['page'] : NULL;
$dataPerPage = 15;
$numb=nomer_paging($page,$dataPerPage);
$jenisRelasi = jenis_instansi_relasi_muat_data($code, $sort, $page, $dataPerPage);
?>
<h1 class="judul"><a href="<?= app_base_url('admisi/jenis-instansi-relasi') ?>">Master Data Jenis Instansi Relasi</a></h1>
<?
include 'app/actions/admisi/pesan.php';
echo isset($pesan) ? $pesan : NULL;
if (isset($_GET['do']) && ($_GET['do'] == 'edit' || $_GET['do'] == 'add')) {
    ?>
    <script type="text/javascript">

        $(document).ready(function(){
            $('#jenis-induk-nama').focus();
            $(".data-input input[name=simpan]").click(function(event){
                event.preventDefault();
                
                if($('#jenis-induk-nama').attr('value')==''){
                    alert('Nama jenis instansi masih kosong');
                    $('#jenis-induk-nama').focus();
                    return false;
                }else if(!isNama($('#jenis-induk-nama').attr('value'))){
                    alert("Nama jenis hanya boleh berisi alphabet dan spasi");
                    $('#jenis-induk-nama').focus();
                    return false;
                }else{                
                    $.ajax({
                        url: "<?= app_base_url('inventory/search?opsi=cek_jenis_instansi') ?>",
                        data:'&nama='+$('#jenis-induk-nama').attr('value')+'&id='+$('input[name=id]').attr('value'),
                        cache: false,
                        dataType: 'json',
                        success: function(msg){
                            if(!msg.status){
                                alert('Nama Instansi sudah diinputkan ke database');
                                $('#jenis-induk-nama').focus();
                                return false;
                            }
                            $(".data-input input[name=simpan]").unbind("click").click();
                        }
                    });    
                }
            });
        });
    </script>
    <div class="data-input">
        <form action="<?= app_base_url('/admisi/control/jenis-instansi-relasi') ?>" method="post" onsubmit="return cekForm()">
            <fieldset>
                <legend><?= $title ?></legend>
                <input type="hidden" name="id" value="<?= $id ?>" />
                <label for="jenis-induk-nama">Nama</label>
                <input type="text" id="jenis-induk-nama" name="nama"  onblur="cekJenisInstansi()" value="<?= $nama ?>" />
                <fieldset class="input-process">
                    <input type="submit" value="Simpan" name="simpan" class="tombol"/>
                    <input type="button" value="Batal" class="tombol" onclick="javascript:location.href='<?= app_base_url('admisi/jenis-instansi-relasi') ?>'">
                </fieldset>
            </fieldset>
        </form>
    </div>
    <?
}
?>
<script type="text/javascript">
    $(document).ready(function(){
     /*   $(".block").after('<span class="tooltip" style="width:0px;height:0px"><span style="display:none"></span></span>');
        $(".block").mouseover(function(event){
            event.preventDefault();
            var index=$(".block").index($(this));
            var tooltipContent=$("span.tooltip").eq(index).children().html();
            if(tooltipContent==''||tooltipContent==null){
                //var value="<table style='text-align:left'cellspacing='2' width='100%'>";
                var value='<ul class="tooltip" style="">';
                $.ajax({
                    url: "<?= app_base_url('/admisi/search?opsi=paging_jenis_instansi_relasi') ?>",
                    data:'&page='+$(this).html()+'&perPage=<?= $dataPerPage ?>&<?= generate_get_parameter($_GET, null, array('page')) ?>',
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
<div class="data-list">
    <a href="<?= app_base_url('admisi/jenis-instansi-relasi/?do=add') ?>" class="add"><div class="icon button-add"></div>tambah</a><br/>
    <table class="tabel" id="table" cellpadding="0" cellspacing="0" style="width: 50%">

        <tr>
            <th>NO</th>
          <th><a href="<?= app_base_url('admisi/jenis-instansi-relasi?sort=2') ?>" class="sorting">Nama</a></th>
            <th>Aksi</th>
        </tr>

        <? foreach ($jenisRelasi['list'] as $num => $row): 
		$no=$row['id'];
		?>
        
            <tr class="<?= ($num % 2) ? 'even' : 'odd' ?>">
                <td align="center" style="width: 5%"><?= $numb++ ?></td>
                <td><?= $row['nama'] ?></td>
               <td class="aksi" style="width: 10%;">
                     <?    if ($no == '1' || $no == '2' || $no == '3' || $no == '4' || $no == '5' || $no == '6' || $no == '7' || $no == '8' || $no == '9' || $no == '10' ){
		echo "-";
		}
		else {
		?>
                    <a href="<?= app_base_url('/admisi/jenis-instansi-relasi/?do=edit&id=' . $row['id'])."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="edit"><small>edit</small></a>
                    <a href="<?= app_base_url('/admisi/control/jenis-instansi-relasi?do=delete&id=' . $row['id'])."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="delete"><small>hapus</small></a>
                    <?
					}
					?>
                </td>
            </tr>
        <? endforeach ?>

    </table>
</div>
<?php
echo $jenisRelasi['paging'];


$count = $jenisRelasi['total'];
echo "<p>Jumlah Total Nama Jenis Instansi Relasi:" . $count . "</p>";
?>