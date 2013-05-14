<script type="text/javascript">
    function cekForm(){
        if($('#farmakologi-golongan-nama').attr('value')==''){
            alert('Nama golongan masih kosong');
            $('#farmakologi-golongan-nama').focus();
            return false;
        }
        if($('#namaFarmakologi').attr('value')==''){
            alert('Farmakologi belum dipilih');
            $('#namaFarmakologi').focus();
            return false;
        }
        if($('#idFarmakologi').attr('value')==''){
            alert('Farmakologi pilih dari list yang ada');
            $('#namaFarmakologi').focus();
            return false;
        }
        if($('#farmakologi-golongan-keterangan').attr('value')==''){
            alert('Keterangan belum diisi');
            $('#farmakologi-golongan-keterangan').focus();
            return false;
        }
    }
    
    $(document).ready(function(){
        $('#farmakologi-golongan-nama').focus();
        $('input[name=batal]').mouseover(function(){
            $('input[name=batal]').addClass('focus');
        });
        $('input[name=batal]').mouseout(function(){
            $('input[name=batal]').removeClass('focus');
        });

        $('#namaFarmakologi').autocomplete("<?= app_base_url('/pf/search?opsi=farmakologi') ?>",
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
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
            function(event,data,formated){
                $('#namaFarmakologi').attr('value',data.nama);
                $('#idFarmakologi').attr('value',data.id);
            }
        );
    });
    
    
function cekGolongan(){
    if(!$('input[name=batal]').hasClass('focus')){
        $.ajax({
        url: "<?= app_base_url('inventory/search?opsi=cek_gol')?>",
        data:'&nama='+$('#farmakologi-golongan-nama').attr('value')+'&id='+$('#id-farmakologi-golongan-nama').val(),
        cache: false,
        dataType: 'json',
        success: function(msg){
            if(!msg.status){
                alert('Nama Sub Farmakologi sudah ada di database!');
                $('#farmakologi-golongan-nama').focus();
                return false;
             }
            }
        });
    }
}
$(document).ready(function(){
     /*   $('#tab2').find(".block").after('<span class="tooltip" style="width:0px;height:0px"><span style="display:none"></span></span>');
        $('#tab2').find(".block").mouseover(function(event){
            event.preventDefault();
            var index=$(".block").index($(this));
            var tooltipContent=$("span.tooltip").eq(index).children().html();
            if(tooltipContent==''||tooltipContent==null){
                //var value="<table style='text-align:left'cellspacing='2' width='100%'>";
                var value='<ul class="tooltip" style="">';
                $.ajax({
                    url: "<?= app_base_url('/pf/search?opsi=paging_subfarmakologi') ?>",
                    data:'&page='+$(this).html()+'&perPage=15<?= isset($_GET['sort']) ? "&sort=" . $_GET['sort'] : "" ?><?= isset($_GET['sortBy']) ? "&sortBy=" . $_GET['sortBy'] : "" ?>',
                    cache: false,
                    dataType: 'json',
                    success: function(data){
                        data=data.list;
                        for(var i=0;i<data.length;i++){
                            value+='<li>'+data[i].nama+" ";
                            value+=data[i].kekuatan!=null?data[i].kekuatan+" ":"";
                            value+=data[i].sediaan!=null?data[i].sediaan+" ":"";
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
<?php
require_once 'app/lib/pf/farmakologi.php';
include 'app/actions/admisi/pesan.php';
if(isset ($_GET['do']) && $_GET['do'] == "addSubFar"){
    $title = "Form Tambah Data Sub Famakologi";
}else if(isset ($_GET['do']) && $_GET['do'] == "editSubFar"){
    $title = "Form Edit Data Sub Famakologi";
}else $title = "";
if(isset($_GET['do']) && $_GET['do']=='editSubFar'){
    $result_gol=_select_arr('select sf.*,f.id as id_farmakologi,f.nama as nama_farmakologi
        FROM sub_farmakologi sf
        JOIN farmakologi f on f.id=sf.id_farmakologi
        WHERE sf.id="'.$_GET['id_gol'].'"');
}

$id=(isset($result_gol))?$result_gol[0]['id']:null;
$nama=(isset($result_gol))?$result_gol[0]['nama']:null;
$keterangan=(isset($result_gol))?$result_gol[0]['keterangan']:null;
$namaFarmakologi=(isset($result_gol))?$result_gol[0]['nama_farmakologi']:null;
$idFarmakologi=(isset($result_gol))?$result_gol[0]['id_farmakologi']:null;
$id_sub_farmakologi = isset($_GET['id_sub'])?$_GET['id_sub']:NULL;

if($tab == "tab2"){
    $sort = isset($_GET['sort'])?$_GET['sort']:NULL;
    $sortBy = isset($_GET['sortBy'])?$_GET['sortBy']:NULL;
    $key = isset($_GET['key'])?$_GET['key']:NULL;
    $batas = 15;
    if ($page_gol > 1)
        $no_gol = $batas * ($page_gol - 1) + 1;
    else
        $no_gol = 1;
    
    echo isset ($pesan)?$pesan:NULL;
}else{
    $sort = NULL;
    $sortBy = NULL;
    $key = NULL;
    $batas = 15;
    $no_gol = 1;
}

$no=nomer_paging($page_gol,$batas);
$farmakologi = sub_farmakologi_muat_data($id_sub_farmakologi,$key,$sort,$sortBy,$page_gol,$batas);

if(isset($_GET['do']) && ($_GET['do']=='editSubFar' || $_GET['do']=='addSubFar')){
?>
            <div class="data-input">
                <form action="<?= app_base_url('/pf/control/sub_farmakologi') ?>" method="post" onsubmit="return cekForm()">
                    <fieldset>
                        <legend><?= $title?></legend>
                        <input type="hidden" name="id" value="<?=$id?>" id="id-farmakologi-golongan-nama"/>
                        <label for="farmakologi-golongan-nama">Nama Sub Farmakologi *</label>
                        <input type="text" id="farmakologi-golongan-nama" name="nama" onblur="cekGolongan()" value="<?=$nama?>" />
                        <label for="farmakologi-golongan-farmakologi">Farmakologi *</label>
                        <input type="text" id="namaFarmakologi"value="<?=$namaFarmakologi?>"><input type="hidden" value="<?=$idFarmakologi?>" name="farmakologi" id="idFarmakologi">
                        <label for="farmakologi-golongan-keterangan">Keterangan *</label>
                        <textarea id="farmakologi-golongan-keterangan" name="keterangan" cols="25" rows="2"><?=$keterangan?></textarea>
                        <fieldset class="input-process">
                            <input type="submit" value="Simpan" class="tombol" name="simpan"/>
                            <input type="button" value="Batal" name="batal" class="tombol" onclick="javascript:location.href='<?=  app_base_url('pf/kamus-obat/farmakologi/?tab=tab2')?>'">
                        </fieldset>
                    </fieldset>
                </form>
            </div>
<?
}
?>
<div class="data-list">
    <div class="perpage" style="float: left">
        <a href="<?= app_base_url('pf/kamus-obat/farmakologi/?do=addSubFar&tab=tab2') ?>" class="add"><div class="icon button-add"></div>tambah</a>
    </div>
    <form action="<?= app_base_url('pf/kamus-obat/farmakologi/')?>" method="GET" class="search-form">
        <span style="float:right">
        <input type="text" name="key" class="input-text" value="<?= $key?>"><input type="hidden" name="tab" value="tab2"><input type="submit" value="" class="search-button"/>
        </span>
    </form>
    <table class="tabel" style="width: 100%">
            <tr>
                <th style="width:5%">NO</th>
              <th style="width:20%"><a href="<?= app_base_url('pf/kamus-obat/farmakologi/?').generate_sort_parameter(2, $sortBy,"tab2")?>" class="sorting">Nama</a></th>
		<th>Farmakologi</th>
                <th style="width:40%">Keterangan</th>
                <th style="width:15%">Aksi</th>
            </tr>
        
            <? foreach ($farmakologi['list'] as $key => $row): ?>
            <tr class="<?= ($no_gol%2) ? 'even' : 'odd' ?>">
                <td align="center"><?=  ($no++)?></td>
                <td><?= $row['nama'] ?></td>
				<td><?= $row['farmakologi'] ?></td>
                <td><?= $row['keterangan'] ?></td>
                <td class="aksi">
                    <a href="<?= app_base_url('/pf/kamus-obat/farmakologi/?do=editSubFar&tab=tab2&id_gol='.$row['id'])."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="edit"><small>edit</small></a>
                    <a href="<?= app_base_url('/pf/control/sub_farmakologi/?do=delete&id_gol='.$row['id'])."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="delete"><small>hapus</small></a>
                </td>
            </tr>
            <?
             $no_gol++;
             endforeach 
            ?>
        
    </table>
</div>
<?
echo $farmakologi['paging'];
$count = $farmakologi['total'];
      echo "<p>Jumlah Total Nama Sub Farmakologi: ".$count."</p>"; ?>