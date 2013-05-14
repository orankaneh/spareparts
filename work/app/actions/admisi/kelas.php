<script type="text/javascript">
    function cekForm(){
        if($('#nama-kelas').attr('value')==''){
            alert('Nama Kelas masih kosong');
            $('#nama-kelas').focus();
            return false;
        }
    }
    $(document).ready(function(){
        $('#nama-kelas').focus();
        $(".data-input input[name=simpan]").click(function(event){
            event.preventDefault();
                 $.ajax({
                    url: "<?= app_base_url('inventory/search?opsi=cek_kelas')?>",
                    data:'&nama='+$('#nama-kelas').attr('value')+'&id='+$('input[name=id]').attr('value'),
                    cache: false,
                    dataType: 'json',
                    success: function(msg){
                        if(!msg.status){
                            alert('Nama kelas sudah diinputkan ke database');
                            $('#nama-kelas').focus();
                            return false;
                         }
                         $(".data-input input[name=simpan]").unbind("click").click();
                    }
                 });
            });
        });
</script>
<?php
require_once 'app/lib/common/master-data.php'; 
include_once 'app/actions/admisi/pesan.php';
if(isset ($_GET['do']) && $_GET['do'] == "add"){
    $title = "Form Tambah Data Kelas";
}else if(isset ($_GET['do']) && $_GET['do'] == "edit"){
    $title = "Form Edit Data Kelas";
}else $title = "";
if(isset($_GET['do']) && $_GET['do']=='edit'){
    $result=kelas_muat_data($_GET['id'], null);
}
$key = isset ($_GET['key'])?$_GET['key']:NULL;
$id=(isset($result))?$result['id']:null;
$nama=(isset($result))?$result['nama']:null;
$margin=(isset($result))?$result['margin']:null;
$code = isset($_GET['code'])?$_GET['code']:NULL;

$sort	= isset($_GET['sort']) ? $_GET['sort'] : NULL;
$by		= isset($_GET['by']) ? $_GET['by'] : 'asc';


?>
<h1 class="judul"><a href="<?=  app_base_url('admisi/kelas/')?>">Master Data Kelas</a></h1>
<?php echo isset($pesan)?$pesan:NULL;?>
<?
    if(isset($_GET['do']) && ($_GET['do']=='edit' || $_GET['do']=='add')){
?>
            <div class="data-input">
                <form action="<?= app_base_url('/admisi/control/kelas') ?>" method="post" onsubmit="return cekForm()">
                    <fieldset>
                        <legend><?= $title?></legend>
                        <input type="hidden" name="id" value="<?=$id?>" />
                        <label for="nama-kelas">Nama</label>
                        <input type="text" id="nama-kelas" name="nama" value="<?=$nama?>"/>
                        <label for="margin-kelas">Margin Harga Jual(%)</label>
                        <input type="text" id="margin-kelas" name="margin" value="<?=$margin?>"/>
                        <fieldset class="input-process">
                            <input type="submit" value="Simpan" class="tombol" name="simpan"/>
                            <input type="button" value="Batal" class="tombol" onclick="javascript:location.href='<?=  app_base_url('admisi/kelas')?>'">
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
            <?php echo addButton('admisi/kelas/?do=add','Tambah'); ?>
        </div>
        <div class="floleft" style='width: 50%'>
            <form action="" method="GET"class="search-form" style="margin: -5px 0 0 0">
                    <span style="float:right;"><input type="text" name="key" class="search-input" id="keyword" value="<?= $key ?>"/><input type="submit" class="search-button" value=""/></span>
            </form>
        </div>
    </div>
   <br/><br/>
  <? //membuat link sorting
if($sort=='id' && $by == 'asc')
    $id = app_base_url('admisi/kelas?sort=id&by=desc');
else
    $id = app_base_url('admisi/kelas?sort=id&by=asc');

if($sort=='nama' && $by == 'desc')
    $nama = app_base_url('admisi/kelas?sort=nama&by=asc');
else
    $nama = app_base_url('admisi/kelas?sort=nama&by=desc');
	
$kelas=  kelas_muat_data2($code, $key, $sort, $by);
?>
     <table class="tabel" id="table" cellpadding="0" cellspacing="0" style="width: 50%">
            <tr>
                <th style="width: 5%;">NO</th>
                <th><a href="<?php echo $nama ?>" class="sorting">Nama</th>
                <th style="width: 12%;">Margin Harga Jual(%)</th>
                <th>Aksi</th>
            </tr>
        
            <? foreach ($kelas['list'] as $num => $row): ?>
            <tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
                <td align="center"><?= ++$num ?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['margin'] ?></td>
                <td class="aksi" style="width: 10%;">
                    <?php
                    if ($row['id'] == 1){
                    ?>
                        <a href="<?= app_base_url('/admisi/kelas/?do=edit&id='.$row['id'])."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="edit"><small>edit</small></a>
                    <?php
                        echo '-';
                    }else {
                    ?>
                    <a href="<?= app_base_url('/admisi/kelas/?do=edit&id='.$row['id'])."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="edit"><small>edit</small></a>
                    <a href="<?= app_base_url('/admisi/control/kelas/?do=delete&id='.$row['id'])."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="delete"><small>hapus</small></a>
                    <?php } ?>
                </td>
            </tr>
            <? endforeach ?>
        
    </table>
</div>
<?
           
	
      $count = count($kelas['list']);
      echo "<p>Jumlah Total Nama Kelas: ".$count."</p>";
?>