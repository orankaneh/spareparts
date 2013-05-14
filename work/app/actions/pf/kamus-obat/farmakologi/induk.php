<?php
require_once 'app/lib/pf/farmakologi.php';
include 'app/actions/admisi/pesan.php';
$key = isset($_GET['key'])?$_GET['key']:NULL;
if (isset($_GET['do']) && $_GET['do'] == 'editFar') {
    $result = _select_arr('select * from farmakologi where id="' . $_GET['id'] . '"');
}
$id = (isset($result)) ? $result[0]['id'] : null;
$nama = (isset($result)) ? $result[0]['nama'] : null;
$keterangan = (isset($result)) ? $result[0]['keterangan'] : null;
if($tab == "tab1"){
    $sort = isset($_GET['sort']) ? $_GET['sort'] : NULL;
    $sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : NULL;
    $code = isset($_GET['code']) ? $_GET['code'] : NULL;
    $batas = 15;
	
    $farmakologi = farmakologi_muat_data_farmakologi($code, $sort, $sortBy, $page_induk, $batas, $key);
    if ($page_induk > 1)
        $no_induk = $batas * ($page_induk - 1) + 1;
    else
        $no_induk = 1;
    echo isset($pesan) ? $pesan : NULL; 
}else{
    $sort = NULL;
    $sortBy = NULL;
    $code = NULL;
    $batas = 15;
    $farmakologi = farmakologi_muat_data_farmakologi($code, $sort, $sortBy, $page_induk, $batas);
    $no_induk = 1;
}
$no=nomer_paging($page_induk,$batas);
?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#farmakologi-induk-nama').focus();
        $('input[name=batal]').mouseover(function(){
            $('input[name=batal]').addClass('focus');
        });
        $('input[name=batal]').mouseout(function(){
            $('input[name=batal]').removeClass('focus');
        });
    });
    function checkdata() {
        if($('#farmakologi-induk-nama').attr('value')==''){
            alert('Nama farmakologi masih kosong');
            $('#farmakologi-induk-nama').focus();
            return false;
        }
        if($('#farmakologi-induk-keterangan').attr('value')==''){
            alert('keterangan farmakologi masih kosong');
            $('#farmakologi-induk-keterangan').focus();
            return false;
        }
    }
    $(document).ready(function(){
        $(".data-input input[name=simpan]").click(function(event){
            event.preventDefault();
            $.ajax({
                url: "<?= app_base_url('inventory/search?opsi=cek_farmakologi') ?>",
                data:'&nama='+$('#farmakologi-induk-nama').attr('value')+'<?= isset($_GET['id']) ? "&id=" . $_GET['id'] : null ?>',
                cache: false,
                dataType: 'json',
                success: function(msg){
                    if(!msg.status){
                        alert('Nama farmakologi sudah diinputkan ke database');
                        $('.data-input input[name=simpan]').focus();
                        return false;
                    }else{
                        $(".data-input input[name=simpan]").unbind("click").click();
                    }
                }
            });
        });
    });
    $(document).ready(function(){
     /*   $('#tab1').find(".block").after('<span class="tooltip" style="width:0px;height:0px"><span style="display:none"></span></span>');
        $('#tab1').find(".block").mouseover(function(event){
            event.preventDefault();
            var index=$(".block").index($(this));
            var tooltipContent=$("span.tooltip").eq(index).children().html();
            if(tooltipContent==''||tooltipContent==null){
                //var value="<table style='text-align:left'cellspacing='2' width='100%'>";
                var value='<ul class="tooltip" style="">';
                $.ajax({
                    url: "<?= app_base_url('/pf/search?opsi=paging_farmakologi') ?>",
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
<?
if (isset($_GET['do']) && $_GET['do'] == "addFar") {
    $title = "Form Tambah Data Famakologi";
} else if (isset($_GET['do']) && $_GET['do'] == "editFar") {
    $title = "Form Edit Data Famakologi";
}else
    $title = "";

if (isset($_GET['do']) && ($_GET['do'] == 'editFar' || $_GET['do'] == 'addFar')) {
    ?>
    <div class="data-input">
        <form action="<?= app_base_url('/pf/control/farmakologi') ?>" method="post" onSubmit="return checkdata()">
            <fieldset>
                <legend><?= $title ?></legend>
                <input type="hidden" name="id" value="<?= $id ?>" />
                <label for="farmakologi-induk-nama">Nama</label>
                <input type="text" id="farmakologi-induk-nama" name="nama" value="<?= $nama ?>" />
                <label for="farmakologi-induk-keterangan">Keterangan</label>
                <textarea id="farmakologi-induk-keterangan" name="keterangan" cols="25" rows="2"><?= $keterangan ?></textarea>
                <fieldset class="input-process">
                    <input type="submit" value="Simpan" name="simpan" class="tombol"/>
                    <input type="button" value="Batal" name="batal" class="tombol" onclick="javascript:location.href='<?= app_base_url('pf/kamus-obat/farmakologi/?tab=tab1') ?>'">
                </fieldset>
            </fieldset>
        </form>
    </div>
    <?
}
?>
<div class="data-list">
    <a href="<?= app_base_url('pf/kamus-obat/farmakologi/?do=addFar&tab=tab1') ?>" class="add"><div class="icon button-add"></div>tambah</a>
     <form action="<?= app_base_url('pf/kamus-obat/farmakologi/')?>" method="GET" class="search-form">
        <span style="float:right">
        <input type="text" name="key" class="input-text" value="<?= $key?>"><input type="hidden" name="tab" value="tab1"><input type="submit" value="" class="search-button"/>
        </span>
    </form>
    <table class="tabel full">

        <tr>
            <th style="width: 5%">NO</th>
            <th style="width: 25%"><a href="<?= app_base_url('pf/kamus-obat/farmakologi/?') . generate_sort_parameter(2, $sortBy, "tab1") ?>" class="sorting">Nama Farmakologi</a></th>
            <th>Keterangan</th>
            <th style="width: 5%">Aksi</th>
        </tr>

        <? foreach ($farmakologi['list'] as $key => $row): ?>
            <tr class="<?= ($no_induk % 2) ? 'even' : 'odd' ?>">
                <td align="center"><?= ($no++) ?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['keterangan'] ?></td>
                <td class="aksi">
                    <a href="<?= app_base_url('/pf/kamus-obat/farmakologi/?do=editFar&tab=tab1&id=' . $row['id'])."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="edit"><small>edit</small></a>
                    <a href="<?= app_base_url('/pf/control/farmakologi?do=delete&id=' . $row['id'])."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="delete"><small>hapus</small></a>
                </td>
            </tr>
        <?
          $no_induk++;
          endforeach 
        ?>

    </table>
</div>
<?
echo "$farmakologi[paging]";

$count = $farmakologi['total'];
echo "<p>Jumlah Total Nama Farmakologi: " . $count . "</p>";
?>
