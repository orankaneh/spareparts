<?php
require_once 'app/lib/common/master-data.php';
include 'app/actions/admisi/pesan.php';
$sort = isset($_GET['sort'])?$_GET['sort']:null;
$sortBy = isset($_GET['sortBy'])?$_GET['sortBy']:null;
$page = isset($_GET['page'])?$_GET['page']:NULL;
$key = isset($_GET['key'])?$_GET['key']:NULL;
$code = isset($_GET['code'])?$_GET['code']:NULL;
$kategori = kategori_barang_muat_data($code, $sort,$sortBy, $page, 15, $key);
$no=nomer_paging($page,15);
?>
<script type="text/javascript">
  $(function(){
      $('#barang').focus();
  })
</script>
<h2 class="judul"><a href="<?= app_base_url('inventory/sub-kategori')?>">Master Data Subkategori Barang</a></h2><? echo isset($pesan) ? $pesan : NULL; ?>
<?
if(isset ($_GET['do']) && $_GET['do'] == "add"){
    $title = "Form Tambah Data Sub Kategori Barang";
}else if(isset ($_GET['do']) && $_GET['do'] == "edit"){
    $title = "Form Edit Data Sub Kategori Barang";
}else $title = "";

if (isset($_GET['do']) && ($_GET['do'] == 'edit' || $_GET['do'] == 'add')) {
    if ($_GET['do'] == 'edit') {
        $kat = kategori_barang_muat_data($_GET['id']);
    }else
        $kat=array();
    $idSubKategori = array_value($kat, "id");
    $namaSubKategori = array_value($kat, "nama");
    $idKategori = array_value($kat, "id_kategori_barang");
    $namaKategori = array_value($kat, "kategori");
    $permit = array_value($kat, "permit_penjualan");
?>
    <div class="data-input">
        <fieldset><legend><?= $title?></legend>
            <form action="<?= app_base_url('inventory/control/sub-kategori') ?>" method="post" onSubmit="return checkdata(this)">
                <input type="hidden" name="idSubKategori" id="idsubkategori" value="<?= $idSubKategori ?>"/>
                <label for="barang">Nama</label>
                <input type="text" name="subKategori" id="barang" onblur="cekSubKategori()"value="<?= $namaSubKategori ?>" <?= ($idSubKategori == 1 || $idSubKategori == 2) ? 'disabled' : '' ?>/>
                <label for="kemasan">Kategori Barang</label>
                <input type="text" value="<?= ($namaKategori != null) ? $namaKategori : User::$pemesanan_nama_kategori_barang_role ?>" disabled>
                <input type="hidden" name="idKategori" value="<?= ($idKategori != null) ? $idKategori : User::$pemesanan_barang_role ?>">
                <fieldset class="field-group">
                    <legend>Dapat Dijual</legend>
                    <label class="field-option"><input type="radio" name="permit_jual" value="Bisa" checked/>Bisa</label>    
                    <label class="field-option"><input type="radio" name="permit_jual" value="Tidak" <?=($permit=='Tidak')?'checked':''?>/>Tidak</label>    
                </fieldset>
                <fieldset class="input-process">
                    <input type="submit" value="Simpan" class="tombol tombol_ok" name="simpan" id="save"/>
                    <input type="button" value="Keluar" class="tombol" onclick="javascript:location.href='<?= app_base_url('inventory/sub-kategori') ?>'"/>
                </fieldset>
				
            </form>
        </fieldset>
    </div>
<?
}
?>
<div class="data-list">
    <div style="display:block;width:70%">
        <div class="floleft" style='width: 50%'>
           <?php echo addButton('inventory/sub-kategori?do=add','Tambah'); ?>
        </div>
        <div class="floleft" style='width: 50%'>
            <form action="" method="GET"class="search-form" style="margin: -5px 0 0 0">
                    <span style="float:right;"><input type="text" name="key" class="search-input" id="keyword" value="<?= $key ?>"/><input type="submit" class="search-button" value=""/></span>
            </form>
        </div>
    </div> 
    
    <table class="tabel" style="width: 70%">
        <tr>
            <th style="width: 5%"><a href="<?=  app_base_url('inventory/sub-kategori?'). generate_sort_parameter(1, $sortBy)?>" class="sorting" >ID</a></th>
            <th style="width: 50%"><a href="<?=  app_base_url('inventory/sub-kategori?'). generate_sort_parameter(2, $sortBy)?>" class="sorting" >Nama</a></th>
            <th style="width: 15%">Bisa Dijual</th>
            <th style="width: 15%">Kategori</th>
            <th style="width: 15%">Aksi</th>
        </tr>
<?php foreach ($kategori['list'] as $key => $row): ?>
            <tr class="<?= ($key % 2) ? 'even' : 'odd' ?>">
            <td align="center"><?= $no++ ?></td>
            <td><?= $row['nama'] ?></td>
            <td align="center"><?=$row['permit_penjualan']?></td>
            <td><?= $row['kategori'] ?></td>
            <td class="aksi">
                <?
                  if($row['id']==1||$row['id']==2){
                      echo "-";
                  }else{
                ?>
                <a href="<?= app_base_url('inventory/sub-kategori?do=edit&id=' . $row['id'])."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" class="edit"><small>edit</small></a>
                <a href="<?= ($row['id'] != 1 && $row['id'] != 2) ? app_base_url('inventory/control/sub-kategori?do=del&id=' . $row['id'])."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) : '' ?>" class="delete"><small>delete</small></a>
                <?
                  }
                ?>
            </td>
        </tr>
<?php endforeach; ?>
    </table>
    
</div>
<?=$kategori['paging']?>

<script type="text/javascript">
	function checkdata(data) {
		if (data.subKategori.value=="") {
			alert("Nama sub kategori tidak boleh kosong");
			data.subKategori.focus();
			return false;
		}
                if(!isNama(data.subKategori.value)){
                    alert("Nama sub kategori hanya boleh berisi alphabet dan spasi");
                    data.subKategori.focus();
                    return false;
                }
	}
        $("#save").click(function(event){
            event.preventDefault();
             if($('#barang').attr('value')==''){
                alert('Nama Zat Aktif tidak boleh kosong');
                $('#barang').focus();
                return false;
            }else{
                var id=($(this).attr("name")=="edit"?'&id='+$('#idsubkategori').attr('value'):'');
                $.ajax({
                        url: "<?= app_base_url('inventory/search?opsi=cek_SubKategori')?>",
                        data:'&nama='+$('#barang').attr('value')+id,
                        cache: false,
                        dataType: 'json',
                        success: function(msg){
                            if(!msg.status){
                                alert('Nama Sub Kategori yang sama sudah pernah diinputkan');
                                $('#barang').focus();
                                return false;
                             }
                              $("#save").unbind("click").click();
                        }
                     });
            }
        });
        function cekSubKategori(){
            
        }

</script>