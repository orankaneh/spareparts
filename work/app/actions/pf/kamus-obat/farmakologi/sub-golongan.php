<?php
require_once 'app/lib/pf/farmakologi.php';
include 'app/actions/admisi/pesan.php';
$farmakologi = farmakologi_muat_data_farmakologi();
if($tab == "tab3"){
    $key = isset($_GET['key']) ? $_GET['key'] : NULL;
    $sort = isset($_GET['sort']) ? $_GET['sort'] : NULL;
    $sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : NULL;
    $code = isset($_GET['code']) ? $_GET['code'] : NULL;
    $batas = 15;
    if ($page_sub_gol > 1)
        $no_sub_gol = $batas * ($page_sub_gol - 1) + 1;
    else
        $no_sub_gol = 1;
    
    echo isset ($pesan)?$pesan:NULL;
}else{
    $key = NULL;
    $sort = NULL;
    $sortBy = NULL;
    $code = NULL;
    $batas = 15;
    $no_sub_gol = 1;
}
$subSubFarmakologi = sub_sub_farmakologi_muat_data($code, $sort, $page_sub_gol, $batas, $key, $sortBy);
$no=nomer_paging($page_sub_gol,$batas);
if (isset($_GET['do']) && $_GET['do'] == "addSubSubFar") {
    $title = "Form Tambah Data Sub-Sub Farmakologi";
} else if (isset($_GET['do']) && $_GET['do'] == "editSubSubFar") {
    $title = "Form Edit Data Sub-Sub Famakologi";
}else
    $title = "";
$subFarmakologi = sub_farmakologi_muat_data();
if (isset($_GET['do']) && ($_GET['do'] == 'editSubSubFar' || $_GET['do'] == 'addSubSubFar')) {
    if ($_GET['do'] == 'editSubSubFar') {
        $data = sub_sub_farmakologi_muat_data($_GET['id']);
        $data = $data[0];
    }
    $id = (isset($data)) ? $data['id'] : null;
    $nama = (isset($data)) ? $data['nama'] : null;
    $keterangan = (isset($data)) ? $data['keterangan'] : null;
    $id_sub_farmakologi = (isset($data)) ? $data['id_sub_farmakologi'] : null;
    $nama_sub_farmakologi = (isset($data)) ? $data['nama_sub_farmakologi'] : null;
    ?>
    <script type="text/javascript">
        function cekForm() {
            if ($('input[name=nama]').attr('value') == "") {
                alert('Nama sub golongan tidak boleh kosong');
                $('input[name=nama]').focus();
                return false;
            }else if ($('#id-subFarmokologi').attr('value') == "") {
                alert('Farmakologi belum dipilih');
                $('#nama-subFarmakologi').focus();
                return false;
            }else if ($('textarea[name=keterangan]').attr('value') == "") {
                alert('Keterangan harus diisi !');
                $('textarea[name=keterangan]').focus();
                return false;
            }
        }
        $(document).ready(function(){
            $('#farmakologi-subgolongan-nama').focus();
            $('input[name=batal]').mouseover(function(){
                $('input[name=batal]').addClass('focus');
            });
            $('input[name=batal]').mouseout(function(){
                $('input[name=batal]').removeClass('focus');
            });
            $('input[name=nama]').blur(function(){
                if(!$('input[name=batal]').hasClass('focus')){
                    $.ajax({
                        url: "<?= app_base_url('inventory/search?opsi=cek_SSF') ?>",
                        data:'&nama='+$('#farmakologi-subgolongan-nama').attr('value')+'&id='+$('#id-farmakologi-subgolongan-nama').val(),
                        cache: false,
                        dataType: 'json',
                        success: function(msg){
                            if(!msg.status){
                                alert('Nama Sub Sub Farmakologi yang sama sudah pernah diinputkan');
                                $('#farmakologi-subgolongan-nama').focus();
                                return false;
                            }
                        }
                    });
                }
            });
            $('#nama-subFarmakologi').autocomplete("<?= app_base_url('/pf/search?opsi=subFarmakologi') ?>",
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
                    var str='<div class=result><b>'+data.nama+'</b><br><i>'+data.nama_farmakologi+'</i></div>';
                    return str;
                },
                width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
            function(event,data,formated){
                $('#nama-subFarmakologi').attr('value',data.nama);
                $('#id-subFarmokologi').attr('value',data.id);
            }
        );
        })
    </script>
    <div class="data-input">
        <form action="<?= app_base_url('/pf/control/sub_sub_farmakologi') ?>" method="post" onsubmit="return cekForm()">
            <fieldset>
                <legend><?= $title ?></legend>
                <input type="hidden" name="id" value="<?= $id ?>" id="id-farmakologi-subgolongan-nama"/>
                <label for="farmakologi-subgolongan-nama">Sub-Sub Farmakologi *</label>
                <input type="text" id="farmakologi-subgolongan-nama" name="nama" value="<?= $nama ?>" />
                <label for="farmakologi-subgolongan-golongan">Sub Farmakologi *</label>
                <input type="text" id="nama-subFarmakologi" value="<?= $nama_sub_farmakologi ?>">
                <input type="hidden" id="id-subFarmokologi" name="sub-farmakologi" value="<?= $id_sub_farmakologi ?>">
                <label for="farmakologi-subgolongan-keterangan">Keterangan *</label>
                <textarea id="farmakologi-subgolongan-keterangan" name="keterangan" cols="25" rows="2"><?= $keterangan ?></textarea>
                <fieldset class="input-process">
                    <input type="submit" value="Simpan" name="simpan" class="tombol"/>
                    <input type="button" value="Batal" name="batal" class="tombol" onclick="javascript:location.href='<?= app_base_url('pf/kamus-obat/farmakologi/?tab=tab3') ?>'">
                </fieldset>
            </fieldset>
        </form>

    </div>
    <?
}
?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#tab3').find(".block").after('<span class="tooltip" style="width:0px;height:0px"><span style="display:none"></span></span>');
        $('#tab3').find(".block").mouseover(function(event){
            event.preventDefault();
            var index=$(".block").index($(this));
            var tooltipContent=$("span.tooltip").eq(index).children().html();
            if(tooltipContent==''||tooltipContent==null){
                //var value="<table style='text-align:left'cellspacing='2' width='100%'>";
                var value='<ul class="tooltip" style="">';
                $.ajax({
                    url: "<?= app_base_url('/pf/search?opsi=paging_subsubfarmakologi') ?>",
                    data:'page='+$(this).html()+'&<?= generate_get_parameter($_GET, null, array('page')) ?>',
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
                
        });
    });
</script>
<div class="data-list">
    <div class="perpage" style="float: left">
        <a href="<?= app_base_url('pf/kamus-obat/farmakologi/?do=addSubSubFar&tab=tab3') ?>" class="add"><div class="icon button-add"></div>tambah</a>
    </div>
    <form action="<?= app_base_url('pf/kamus-obat/farmakologi/') ?>" method="GET" class="search-form">
        <span style="float: right">
        <input type="text" name="key" class="input-text" value="<?= $key ?>"><input type="hidden" name="tab" value="tab3"><input type="submit" value="" class="search-button"  />
        </span>
    </form>
    <table class="tabel  full">
        <tr>
            <th style="width: 4%">NO</th>
          <th><a href="<?= app_base_url('pf/kamus-obat/farmakologi/?') . generate_sort_parameter(2, $sortBy, "tab3") ?>" class="sorting">Nama</a></th>
            <th>Sub Farmakologi</th>
            <th>Farmakologi</th>
            <th style="width: 50%">Keterangan</th>
            <th style="width: 15%">Aksi</th>
        </tr>
        <? foreach ($subSubFarmakologi['list'] as $key => $row): ?>
            <tr class="<?= ($no_sub_gol % 2) ? 'even' : 'odd' ?>">
                <td align="center"><?=($no++)?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['nama_sub_farmakologi'] ?></td>
                <td><?= $row['nama_farmakologi'] ?></td>
                <td><?= $row['keterangan'] ?></td>
                <td class="aksi">
                    <a href="<?= app_base_url('/pf/kamus-obat/farmakologi/?do=editSubSubFar&tab=tab3&id=' . $row['id'])."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="edit"><small>edit</small></a>
                    <a href="<?= app_base_url('/pf/control/sub_sub_farmakologi/?do=delete&id=' . $row['id'])."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="delete"><small>hapus</small></a>
                </td>
            </tr>
        <?
         $no_sub_gol++;
         endforeach 
        ?>
        </table>
    </div>
<?
echo "$subSubFarmakologi[paging]";
$count = $subSubFarmakologi['total'];
echo "<p>Jumlah Total Nama Sub Sub Farmakologi: " . $count . "</p>";
?>

