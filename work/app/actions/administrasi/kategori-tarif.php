<script type="text/javascript">
$(function(){
    $('#nama').focus();
})
function cekForm(){
    if($('#nama').attr('value')==''){
        alert('Nama tarif masih kosong');
        $('#nama').focus();
        return false;
    }
}

function cekNama(){
    if($('#nama').attr('value')!==''){
        $.ajax({
            url: "<?= app_base_url('/inventory/search?opsi=kategori_tarif')?>",
            data:'&nama='+$('#nama').attr('value')+'&id='+$('#idtarif').attr('value'),
            cache: false,
            dataType: 'json',
            success: function(msg){
            if (!msg.status){
                alert("Nama tarif '"+$('#nama').attr('value')+"' sudah ada");
				$('#nama').focus();
                return false;
                }
            }
      });
      return false;
    }
}
</script>
<?php
require_once 'app/lib/common/master-data.php';
include 'app/actions/admisi/pesan.php';
$category = isset($_GET['category']) ? $_GET['category'] : NULL;
$code = isset($_GET['code']) ? $_GET['code'] : NULL;
$page = isset($_GET['page']) ? $_GET['page'] : NULL;
$key = isset($_GET['key']) ? $_GET['key'] : NULL;
$sort = isset ($_GET['sort'])?$_GET['sort']:NULL;
$sortBy = isset ($_GET['sortBy'])?$_GET['sortBy']:NULL;
$searcing='';
if (get_value('key')!=''){
if($searcing=''){
$searcing="key=".get_value('key');
}
else{
$searcing='';
}
}

$dataTarif = data_tarif($code, $page, $dataPerPage = 10, $key, $sort, $sortBy);
$barangTotal = data_tarif(NULL,NULL,NULL,NULL);
?>
<h2 class="judul"><a href="<?= app_base_url('administrasi/kategori-tarif') ?>">Kategori Tarif</a></h2>
<? echo isset($pesan) ? $pesan : NULL; ?>
<?
if (isset($_GET['do']) && ($_GET['do'] == 'edit' || $_GET['do'] == 'add')) {
    if ($_GET['do'] == 'edit') {
        $title = "Form Edit Data Kategori Tarif";
    } else if ($_GET['do'] == 'add') {
        $title = "Form Tambah Data Kategori Tarif";
    }else
        $title = "";
    if ($_GET['do'] == 'edit') {
        $barang = data_tarif($code = $_GET['id'], $page = NULL, $dataPerPage = NULL, $key = NULL);
    }else
    $barang=array();
    $id = array_value($barang, "id");
    $nama = array_value($barang, "nama");
    $keterangan = array_value($barang, "keterangan");
?>
    <div class="data-input">
        <fieldset><legend><?= $title ?></legend>
            <form action="<?= app_base_url('administrasi/control/kategori-tarif') ?>" method="post" name="tarifForm" onsubmit="return cekForm()" id="f_tambah">
                <input type="hidden" name="idtarif" id="idtarif" value="<?= $id ?>" readonly="readonly"/>
                <label for="barang">Nama Kategori *</label><input type="text" name="nama" id="nama" value="<?= $nama ?>" onblur="cekNama()"/>
                <label for="barang">Keterangan</label><textarea type="text" name='keterangan' id="keterangan"><?= $keterangan ?></textarea><input type="hidden" name="idketerangan" id="idketerangan" value="<?= $idPabrik ?>"/>
                <fieldset class="input-process">
                    <input type="submit" value="Simpan" class="tombol tombol_ok" name="simpan" id='t_simpan'/>
                    <input type="button" value="Batal" name="batal" class="tombol" onclick="javascript:location.href='<?= app_base_url('administrasi/kategori-tarif') ?>'"/>
                </fieldset>
            </form>
        </fieldset>
    </div>
<?
                }
?>

                <div class="data-list w700px">
                    <div class="floleft">
                      <a href="<?= app_base_url('administrasi/kategori-tarif?do=add') ?>" class="add"><div class="icon button-add"></div>tambah</a>
                    </div>
                    <div class="floright" style="margin: -5px 0 0 0">
                        <form action="" method="GET" class="search-form">
                        <span style="float:right">    
                        <input type="text" name="key" class="search-input" id="keyword" value="<?= $key ?>"/>
                        <input type="submit" value="" class="search-button"/>
                        </span>
                        </form>
                    </div>    
                    
    <table class="tabel full">
        <tr>
            <th style="width: 10%;"><a href="<?= app_base_url('administrasi/kategori-tarif/?'.$searcing.generate_sort_parameter(1, $sortBy))?>" class="sorting">ID</a></th>
            <th style="width: 25%;">Nama</th>
            <th>Keterangan</th>
            <th style="width: 10%;">Aksi</th>
        </tr>
        <?php
                        foreach ($dataTarif['list'] as $key => $row):

        ?>
                            <tr class="<?= ($key % 2) ? 'even' : 'odd' ?>">
                                <td align="center"><?= ($row['id']) ?></td>
                                <td class="no-wrap"><?= $row['nama'] ?></td>
                                <td class="no-wrap"><?= $row['keterangan'] ?></td>
                                <td class="aksi">
                                    <?php
                                        if($row['id']<=17){
                                            echo "-  -";
                                        }else{ ?>
                                            <a href="<?= app_base_url('administrasi/kategori-tarif?do=edit&id=' . $row['id']) ?>" class="edit">edit</a>
                                            <a href="<?= app_base_url('administrasi/control/kategori-tarif?do=del&iddel='.$row['id']) ?>" class="delete">delete</a>
                                    <?php }
                                    ?>
                                </td>
                            </tr>
        <?php endforeach; ?>
                        </table>

                    </div>
<?= $dataTarif['paging'] ?>
<?
                            $count = count($barangTotal['list']);
                            echo "<p>Jumlah Total Kategori Tarif: " . $count . "</p>";
?>