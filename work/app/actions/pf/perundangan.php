<?php
require_once 'app/lib/pf/obat.php';

if (isset($_GET['do']) && $_GET['do'] == 'edit') {
    $result = _select_arr('select * from perundangan where id="' . $_GET['id'] . '"');
}
$id = (isset($result)) ? $result[0]['id'] : null;
$nama = (isset($result)) ? $result[0]['nama'] : null;
$code = isset($_GET['code']) ? $_GET['code'] : NULL;
$key  = isset($_GET['key']) ? $_GET['key'] : NULL;

$sort	= isset($_GET['sort']) ? $_GET['sort'] : NULL;
$by		= isset($_GET['by']) ? $_GET['by'] : 'asc';

//membuat link sorting
if($sort=='id' && $by == 'asc')
    $id = app_base_url('pf/perundangan?sort=id&by=desc');
else
    $id = app_base_url('pf/perundangan?sort=id&by=asc');

if($sort=='nama' && $by == 'desc')
    $nama = app_base_url('pf/perundangan?sort=nama&by=asc');
else
    $nama = app_base_url('pf/perundangan?sort=nama&by=desc');
	
$perundangan = perundangan_muat_data($code, $key, $sort, $by);
?>
<h1 class="judul"><a href="<?= app_base_url('pf/perundangan')?>">Master Data Perundangan</a></h1>
<?
tampilkan_pesan();
if (isset($_GET['do']) && $_GET['do'] == "add") {
    $title = "Form Tambah Data Perundangan";
} else if (isset($_GET['do']) && $_GET['do'] == "edit") {
    $title = "Form Edit Data Perundangan";
}else
    $title = "";
if (isset($_GET['do']) && ($_GET['do'] == 'edit' || $_GET['do'] == 'add')) {
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
                        
    
    $("#save").click(function(event){
        event.preventDefault();
         if($('#farmakologi-induk-nama').attr('value')==''){
                alert('Nama perundangan masih kosong');
                $('#farmakologi-induk-nama').focus();
                return false;
            }
        else{
            
            if(!$('input[name=batal]').hasClass('focus')){
                var id=($("input[name=id]").attr("value")!=null?'&id='+$('input[name=id]').attr('value'):'');
                $.ajax({
                    url: "<?= app_base_url('inventory/search?opsi=cek_perundangan') ?>",
                    data:'&nama='+$('#farmakologi-induk-nama').attr('value')+'&id='+$('input[name=id]').attr('value'),
                    cache: false,
                    dataType: 'json',
                    success: function(msg){
                        if(!msg.status){
                            alert('Nama Perundangan sudah diinputkan ke database');
                            $('#farmakologi-induk-nama').focus();
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
    <div class="data-input">
        <form action="<?= app_base_url('/pf/control/perundangan') ?>" method="post">
            <fieldset>
                <legend><?= $title ?></legend>
                <input type="hidden" name="id" value="<?= $id ?>" />
                <label for="farmakologi-induk-nama">Nama</label>
                <input type="text" id="farmakologi-induk-nama" name="nama" value="<?= $nama ?>" />
                <fieldset class="input-process">
                    <input type="submit" value="Simpan" name="simpan" class="tombol" id="save"/>
                    <input type="button" name="batal" value="Batal" class="tombol" onclick="javascript:location.href='<?= app_base_url('pf/perundangan/') ?>'">
                </fieldset>
            </fieldset>
        </form>
    </div>
<?
}
?>
<div class="data-list w600px">
	<div class="floleft"><?php echo addButton('/pf/perundangan/?do=add','Tambah'); ?></div>
	<div class="floright">
    <form action="<?= app_base_url('/pf/perundangan/')?>" method="GET" class="search-form" style="margin-top: -5px">
        <input type="text" name="key" class="search-input" value="<?= $key?>" /><input type="submit" class="search-button" value="" />     
    </form>
	</div>
    <table class="tabel full" id="table">

        <tr>
            <th>NO</th>
            <th><a class="sorting" href="<?php echo $nama ?>">Nama</a></th>

            <th>Aksi</th>
        </tr>

        <? foreach ($perundangan as $num => $row): ?>
            <tr class="<?= ($num % 2) ? 'even' : 'odd' ?>">
                <td align="center" style="width: 5%;"><?=++$num?></td>
                <td><?= $row['nama'] ?></td>
                <td class="aksi" style="width: 10%;">
                    <a href="<?= app_base_url('/pf/perundangan/?do=edit&id=' . $row['id'])."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="edit"><small>edit</small></a>
                    <a href="<?= app_base_url('/pf/control/perundangan?do=delete&id=' . $row['id'])."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="delete"><small>hapus</small></a>
                </td>
            </tr>
        <? endforeach ?>

        </table>
    </div>
<?
            $count = count($perundangan);
            echo "<p>Jumlah Total Nama Perundangan: " . $count . "</p>";
?>