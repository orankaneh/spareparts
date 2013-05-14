<?php
require_once 'app/lib/pf/obat.php';
require_once 'app/lib/pf/satuan.php';
require_once 'app/lib/pf/sediaan.php';
require_once 'app/lib/common/functions.php';
require 'app/actions/admisi/pesan.php';
?>
<h2 class="judul"><a href="<?= app_base_url('pf/obat') ?>">Master Data Obat</a></h2><?= isset($pesan) ? $pesan : NULL ?>
<?
$sort = isset($_GET['sort']) ? $_GET['sort'] : NULL;
$sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : NULL;
$page = isset($_GET['page']) ? $_GET['page'] : NULL;
$key = isset($_GET['key']) ? $_GET['key'] : NULL;
$code = isset($_GET['code']) ? $_GET['code'] : NULL;
$obats = obat_muat_data($code, $page, 15, $sort, $sortBy, $key);
$no=nomer_paging($page,15);

$perundangans = perundangan_muat_data();
$sediaan = sediaan_muat_data();
if (isset($_GET['do']) && ($_GET['do'] == 'edit' || $_GET['do'] == 'add')) {
    if ($_GET['do'] == 'edit') {
        $obat = obat_muat_data($_GET['id']);
    } else
        $obat=array();
    $idObat = array_value($obat, 'id');
    $nama = array_value($obat, 'nama_barang');
    $pabrik = array_value($obat, 'pabrik');
    $idPabrik = array_value($obat, 'id_pabrik');
    $idBarang = array_value($obat, 'id');
    $idSediaan = array_value($obat, 'id_sediaan');
    $sediaan = array_value($obat, 'sediaan');
    $indikasi = array_value($obat, 'indikasi');
    $ssFarmakologi = array_value($obat, 'sub_sub_farmakologi');
    $idFarmakologi = array_value($obat, 'id_sub_sub_farmakologi');
    $perundangan = array_value($obat, 'id_gol_perundangan');
    $ven = array_value($obat, 'ven');
    $generik = array_value($obat, 'generik');
    $kekuatan = array_value($obat, 'kekuatan');
    $checked1 = null;
    $checked2 = null;
    if ($generik == 'Generik' || $generik == 'Non Generik') {
        if ($generik == 'Generik')
            $checked1 = 'checked';
        else
            $checked2='checked';
    }
    if (isset($_GET['do']) && $_GET['do'] == "add") {
        $title = "Form Tambah Data Obat";
    } else if (isset($_GET['do']) && $_GET['do'] == "edit") {
        $title = "Form Edit Data Obat";
    }else
        $title = "";
    ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#namaObat').focus();
            $('#pabrik').autocomplete("<?= app_base_url('/inventory/search?opsi=suplier&enis_instansi=5') ?>",
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
                    $('#idpabrik').attr('value','');
                    var str='<div class=result>'+data.nama+' <br/><i> '+data.alamat+' , '+data.nama_kelurahan+'</i></div>';
                    return str;
                },
                width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
            function(event,data,formated){
                $('#pabrik').attr('value',data.nama);
                $('#idpabrik').attr('value',data.id);
            }
        );
        });
        /*else if($('#kekuatan').attr('value')==''){
                alert('Kekuatan masih kosong');
                $('#kekuatan').focus();
                return false;
            }else if($('#idSediaan').attr('value')==''){
                $.ajax({
                    url: "<?//= app_base_url('/pf/search?opsi=sediaan') ?>",
                    data:'&q='+$('#sediaan').attr('value'),
                    cache: false,
                    dataType: 'json',
                    success: function(msg){
                        if (msg.length==1){
                            $('#idSediaan').attr('value',msg[0].id);
                            $('#sediaan').attr('value',msg[0].nama);
                            cekForm();
                        }if(msg.length==0 || $('#sediaan').attr('value')==''){
                            alert('Sediaan belum ditemukan');
                            $('#sediaan').focus();
                        }else if(msg.length>1){
                            alert('Data sediaan ambigu, silakan input ulang');
                            $('#sediaan').focus();
                        }
                    }
                });
                return false;
            }else if($('#idpabrik').attr('value')==''){
                $.ajax({
                    url: "<?//= app_base_url('/inventory/search?opsi=suplier') ?>&jenis_instansi=5",
                    data:'&q='+$('#pabrik').attr('value'),
                    cache: false,
                    dataType: 'json',
                    success: function(msg){
                        if (msg.length==1){
                            $('#pabrik').attr('value',msg[0].nama);
                            $('#idpabrik').attr('value',msg[0].id);
                            cekForm();
                        }if(msg.length==0 || $('#pabrik').attr('value')==''){
                            alert('Pabrik belum ditemukan');
                            $('#pabrik').focus();
                        }else if(msg.length>1){
                            alert('Data pabrik ambigu, silakan input ulang');
                            $('#pabrik').focus();
                        }
                    }
                });
                return false;
            }else if($('#perundangan').attr('value')==''){
                alert('Perundangan belum terpilih');
                $('#perundangan').focus();
                return false;
            }else if($('#ven').attr('value')==''){
                alert('Ven belum terpilih');
                $('#ven').focus();
                return false;
            }else if($('#ssFarmakologi').attr('value')==''){
                alert('Farmakologi masih kosong');
                $('#ssFarmakologi').focus();
                return false;
            }else if($('#idFarmakologi').val()==''){
                alert('Farmakologi belum diisi dengan benar,silakan input ulang')
                $('#ssFarmakologi').focus();
                return false;
            }else if($('input[name=pabrik]').attr('value')==''){
                alert('Pabrik masih kosong');
                $('input[name=pabrik]').focus();
                return false;
            }
            return true
        }
*/
        $(document).ready(function(){   
        
            $("#save").click(function(event){
            event.preventDefault();                    
                //var id=($("#idObat").attr("value")==""?'&idObat='+$('#idObat').attr('value'):'');
                if($('#namaObat').attr('value')==''){
                    alert('Nama obat tidak boleh kosong !');
                    $('#namaObat').focus();    
                    return false;
                }else if($("input[name=generik]:checked").val()==''||$("input[name=generik]:checked").val()==null){
                    alert('Generik tidak boleh kosong !');
                    $('input[name=generik]').focus();  
                    return false;
                }else{
                
                var dataString=$('#obatForm').serialize();
                $.ajax({
                    url: "<?= app_base_url('inventory/search?opsi=cek_obat')?>",
                    data:dataString,
                    cache: false,
                    dataType: 'json',
                    success: function(msg){
                        if(msg.status){
                            if(msg.data!=""){
                                var kekuatan=parseInt(msg.data[0].kekuatan)>0?msg.data[0].kekuatan:'';

                               var tabel='<td width="2%" align="center">'+msg.data[0].id_barang+'</td>'+
                                            '<td width="10%" class="no-wrap">'+msg.data[0].nama_barang+'</td>'+
                                            '<td width="1%" align="center">'+kekuatan+'</td>'+
                                            '<td width="1%">'+msg.data[0].sediaan+'</td>'+
                                            '<td width="10%" class="no-wrap">'+msg.data[0].pabrik+'</td>'+
                                            '<td width="2%">'+msg.data[0].generik+'</td>'+
                                            '<td width="20%">'+msg.data[0].indikasi+' </td>'+
                                            '<td width="5%" class="no-wrap">'+msg.data[0].perundangan+'</td>'+
                                            '<td width="10%">'+msg.data[0].sub_sub_farmakologi+'-'+msg.data[0].sub_farmakologi+'-'+msg.data[0].farmakologi+'</td>'+
                                            '<td width="5%">'+msg.data[0].ven+'</td>'+                
                                            '<td class="aksi" width="5%"><a href="<?=app_base_url("/pf/obat")?>?do=edit&id='+msg.data[0].id_barang+'" class="edit"><small>edit</small></a>'+
                                            '<a href="<?=app_base_url("/pf/obat")?>?do=edit&id='+msg.data[0].id_barang+'" class="delete"><small>delete</small></a></td>';
                               $('.tabel tr').not("tr:eq(0)").remove(); 
                               $('.tabel tr').after(tabel);
                            }                            
                            alert('Obat tersebut sudah ada di dalam database');
                            return false;
                         }else{
                             $("#save").unbind("click").click();
                         }
                    }
                 });
                }
                }
            );
        })
    </script>
    <div class="data-input">
        <fieldset><legend><?= $title ?></legend>
            <form action="<?= app_base_url('pf/control/obat-control') ?>" method="POST" id="obatForm">
                <input type="hidden" id="idObat" name="idObat" value="<?= $idObat ?>"><input type="hidden" name="simpan" value="simpan">
                <label for="namaObat">Nama *</label><input type="text" name="namaObat" id="namaObat" value="<?= $nama ?>"/>
                <label for="kekuatan">Kekuatan </label>
            <input type="text" name="kekuatan" value="<?= $kekuatan ?>" id="kekuatan"/>
                <label for="sediaan">Sediaan </label><input type="text" id="sediaan" value="<?= $sediaan ?>" /><input type="hidden" id="idSediaan" name="idSediaan" value="<?= $idSediaan ?>" />
                <label for="barang">Pabrik </label><input type="text" id="pabrik" value="<?= $pabrik ?>"/><input type="hidden" name="idPabrik" id="idpabrik" value="<?= $idPabrik ?>"/>
                <fieldset class="field-group">
                    <label for="generik">Generik *</label>
                    <label for="generik" class="field-option"><input type="radio" name="generik" class="generik" value="Generik" <?= $checked1 ?> /> Generik</label>
                    <label for="generik" class="field-option"><input type="radio" name="generik" class="generik" value="Non Generik" <?= $checked2 ?> /> Non Generik</label>
                </fieldset>
                <label for="indikasi">Indikasi </label><textarea cols="20" rows="4" id="indikasi" name="indikasi"><?= $indikasi ?></textarea>
                <label for="perundangan">Golongan Perundangan </label>
                <select name="perundangan" id="perundangan">
                    <option value="">Pilih undang-undang ...</option>
                    <?
                    foreach ($perundangans as $p) {
                        $selected = ($p['id'] == $perundangan) ? 'selected' : null;
                        echo"<option value=$p[id] $selected>$p[nama]</option>";
                    }
                    ?>
                </select>
                <label for="ven">Ven </label>
                <select name="ven" id="ven">
                    <option value="">Pilih ven</option>
                    <option value="Esensial" <?= ($ven == "Esensial") ? 'selected' : '' ?>>Esensial</option>
                    <option value="Non Esensial" <?= ($ven == "Non Esensial") ? 'selected' : '' ?>>Non Esensial</option>
                    <option value="Vital" <?= ($ven == "Vital") ? 'selected' : '' ?>>Vital</option>
                </select>
                <label for="ssFarmakologi">Sub-sub Farmakologi </label><input type="text" id="ssFarmakologi" value="<?= $ssFarmakologi ?>" /><input type="hidden" name="idFarmakologi" id="idFarmakologi" value="<?= $idFarmakologi ?>" />
                <fieldset class="input-process">
                    <input type="submit" value="Simpan" class="tombol tombol_ok" name="simpan" id="save"/>
                    <input type="button" value="Batal" name="batal" class="tombol" onclick="javascript:location.href='<?= app_base_url('pf/obat?') ?>'"/>
                </fieldset>
            </form>
    </div>
    <?
}
?>
<!-- DIsable tipsy...
<script type="text/javascript">
    $(document).ready(function(){
        $(".block").after('<span class="tooltip" style="width:0px;height:0px"><span style="display:none"></span></span>');
        $(".block").mouseover(function(event){
            event.preventDefault();
            var index=$(".block").index($(this));
            var tooltipContent=$("span.tooltip").eq(index).children().html();
            if(tooltipContent==''||tooltipContent==null){
                //var value="<table style='text-align:left'cellspacing='2' width='100%'>";
                var value='<ul class="tooltip" style="">';
                $.ajax({
                    url: "<?= app_base_url('/pf/search?opsi=paging_obat') ?>",
                    data:'page='+$(this).html()+'&<?= generate_get_parameter($_GET, null, array('page')) ?>',
                    cache: false,
                    dataType: 'json',
                    success: function(data){
                        data=data.list;
                        for(var i=0;i<data.length;i++){
                            value+='<li>'+data[i].nama_barang+" ";
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
</script>-->
<div class="data-list">
    <div id="perpage" style="float:left">
        <a href="<?= app_base_url('/pf/obat?do=add') ?>" class="add"><div class="icon button-add"></div>Tambah</a>
    </div>
    <form action="" method="GET" class="search-form">
            <span style="float:right">Nama Obat: <input type="text" name="key" class="search-input" id="keyword" value="<?= $key ?>"/><input type="submit" value="" class="search-button" /></span>
    </form>
    <table class="tabel" width="100%">
        <tr>
            <th>NO</th>
          <th><a href="<?= app_base_url('pf/obat?') . generate_sort_parameter(1, $sortBy) ?>" class="sorting">Nama</a></th>
            <th>Kekuatan</th>
            <th>Sediaan</th>
            <th><a href="<?= app_base_url('pf/obat?') . generate_sort_parameter(2, $sortBy) ?>" class="sorting">Pabrik</a></th>
            <th><a href="<?= app_base_url('pf/obat?') . generate_sort_parameter(3, $sortBy) ?>" class="sorting">Generik</a></th>
            <th>Indikasi</th>
            <th>Gol. <br/>Perundangan</th>
            <th>Sub-sub Farmakologi</th>
            <th>Ven</th>
            <th style="width: 7%">Aksi</th>
        </tr>
        <?php foreach ($obats['list'] as $num => $data): ?>
            <?
            //jika barang mempunyai kategori obat, tetapi belum terdapat di obat, maka masukkan obat baru
            if ($data['id'] == null || $data['id'] == '') {
                _insert('insert into obat (id) values (' . $data['id_barang'] . ')');
            }
            ?>
            <tr class="<?= ($num % 2) ? 'odd' : 'even' ?>">
                <td width="2%" align="center"><?= $no++?></td>
                <td width="10%" class="no-wrap"><?= $data['nama_barang'] ?></td>
                <td width="1%" align="center"><?= ($data['kekuatan'] != 0) ? $data['kekuatan'] : '' ?></td>
                <td width="1%"><?= $data['sediaan'] ?></td>
                <td width="10%" class="no-wrap"><?= $data['pabrik'] ?></td>
                <td width="2%"><?= $data['generik'] ?></td>
                <td width="20%"><?= $data['indikasi'] ?> </td>
                <td width="5%" class="no-wrap"><?= $data['perundangan'] ?></td>
                <td width="10%"><?= $data['sub_sub_farmakologi'] . "-" . $data['sub_farmakologi'] . "-" . $data['farmakologi'] ?></td>
                <td width="5%"><?= $data['ven'] ?></td>
                <? $_GET['do'] = 'edit' ?>
                <td class="aksi" width="5%"><a href="<?= app_base_url('/pf/obat?') . generate_get_parameter($_GET, array('do' => 'edit', 'id' => $data['id_barang']),array('msg','msr')) ?>" class="edit"><small>edit</small></a>
                    <? $_GET['do'] = 'del' ?><a href="<?= app_base_url('/pf/control/obat-control?') . generate_get_parameter($_GET, array('do' => 'delete', 'id' => $data['id_barang']),array('msg','msr')) ?>" class="delete"><small>delete</small></a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<div style="float:right;">
    <a href="<?= app_base_url('pf/report/obat-excel') ?>" class="excel">Cetak Excel</a>
</div>
<?= (empty($_GET['code'])) ? $obats['paging'] : '' ?>
<?
$count = $obats['total'];
echo "<p>Jumlah Total Nama Obat: " . $count . "</p>";
?>

<script type="text/javascript">
    $(document).ready(function(){
        $('input[name=batal]').mouseover(function(){
            $('input[name=batal]').addClass('focus');
        });
        $('input[name=batal]').mouseout(function(){
            $('input[name=batal]').removeClass('focus');
        });
        $('#namaBarang').autocomplete("<?= app_base_url('/pf/search?opsi=barang2') ?>",
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
                $('#idBarang').attr('value','');
                var str='<div class=result><b>'+data.nama+' </b><br/><i> kategori: '+data.kategori+'</i></div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $('#idBarang').attr('value',data.id);
            $('#namaBarang').attr('value',data.nama);
        }
    );
        $('#sediaan').autocomplete("<?= app_base_url('/pf/search?opsi=sediaan') ?>",
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
                $('#idSediaan').attr('value','');
                var str='<div class=result><b>'+data.nama+' </b><br/></div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $('#idSediaan').attr('value',data.id);
            $(this).attr('value',data.nama);
        }
    );
        $('#ssFarmakologi').autocomplete("<?= app_base_url('/pf/search?opsi=sub_sub_farmakologi') ?>",
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
                var str='<div class=result><b>'+data.nama+'</b>-'+data.nama_sub_farmakologi+'-'+data.nama_farmakologi+'<br/></div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $('#idFarmakologi').attr('value',data.id_sub_sub_farmakologi);
            $('#ssFarmakologi').attr('value',data.nama+'-'+data.nama_sub_farmakologi+'-'+data.nama_farmakologi);
        }
    );
    });
    
</script>