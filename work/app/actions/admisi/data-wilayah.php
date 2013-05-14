<?php
require_once 'app/lib/common/master-data.php';
include_once 'pesan.php';
$page = isset($_GET['page']) ? $_GET['page'] : NULL;
$perPage = 1;
$category = isset($_GET['category']) ? $_GET['category'] : NULL;
$key = isset($_GET['key']) ? $_GET['key'] : NULL;
$sort = isset($_GET['sort']) ? $_GET['sort'] : NULL;
$code = isset($_GET['code'])?$_GET['code']:NULL;
$idKecamatan = isset($_GET['idKecamatan'])?$_GET['idKecamatan']:NULL;
if ($sort == 1) {
    $order1 = "order by nama asc";
}
if ($sort == 2) {
    $order2 = "order by nama asc";
}
if ($sort == 3) {
    $order3 = "order by nama asc";
}
if ($sort == 4) {
    $order4 = "order by nama asc";
}
if ($category == 1) {
    $propinsi = propinsi_muat_data($code, isset($order1) ? $order1 : NULL, $key, $page, $perPage);
} else {
    $propinsi = propinsi_muat_data($code, isset($order1) ? $order1 : NULL, NULL, $page, $perPage);
}
?>
  <script type="text/javascript">
        function cekform(data) {
            if (data.provinsi.value == "") {
                alert('Nama provinsi tidak boleh kosong');
                data.provinsi.focus();
                return false;
            }
        }
function cekpropinsi(){
    $.ajax({
        url: "<?= app_base_url('inventory/search?opsi=cek_Propinsi')?>",
        data:'&nama='+$('#provinsi').attr('value'),
        cache: false,
        dataType: 'json',
        success: function(msg){
            if(!msg.status){
                alert('Nama provinsi yang sama sudah pernah diinputkan');
                return false;
             }
        }
     });
}
</script>
<div class="judul"><a href="<?= app_base_url('admisi/data-wilayah') ?>">Master Data Wilayah</a></div><? echo isset($pesan) ? $pesan : NULL; ?>
<?
if (isset($_GET['do'])) {
    if ($_GET['do'] == 'addProvince') {
        require_once 'app/actions/admisi/add-provinsi.php';
    } else if ($_GET['do'] == 'editProvince') {
        require_once 'app/actions/admisi/edit-provinsi.php';
    } else if ($_GET['do'] == 'addKabupaten') {
        require_once 'app/actions/admisi/add-kabupaten.php';
    } else if ($_GET['do'] == 'editKabupaten') {
        require_once 'app/actions/admisi/edit-kabupaten.php';
    } else if ($_GET['do'] == 'addKecamatan') {
        require_once 'app/actions/admisi/add-kecamatan.php';
    } else if ($_GET['do'] == 'editKecamatan') {
        require_once 'app/actions/admisi/edit-kecamatan.php';
    } else if ($_GET['do'] == 'addKelurahan') {
        require_once 'app/actions/admisi/add-kelurahan.php';
    } else if ($_GET['do'] == 'editKelurahan') {
        require_once 'app/actions/admisi/edit-kelurahan.php';
    }
}
?>
<div class="data-list">
    <div id="perpage" style="float: right;">
        <form action="" method="GET">
            <select name="category" id="category">
                <option value="">Pilih kategori</option>
                <option value="1" <? if ($category == 1) {
    echo "selected";
} ?>>Nama Provinsi</option>
                <option value="2" <? if ($category == 2) {
    echo "selected";
} ?>>Nama Kabupaten/Kota</option>
                <option value="3" <? if ($category == 3) {
    echo "selected";
} ?>>Nama Kecamatan</option>
                <option value="4" <? if ($category == 4) {
    echo "selected";
} ?>>Nama Kelurahan</option>
            </select>
            <input type="text" name="key" class="formKcl" id="keyword" value="<?= $key ?>"/><input type="submit" value="Cari" />
        </form>
    </div>
    <a href="<?= app_base_url('/admisi/data-wilayah/?do=addProvince') ?>" class="add">tambah provinsi</a>
    <table cellpadding="0" cellspacing="0" id="table" class="tabel">

        <tr>
            <th>ID</th>
            <th><a href="<?= app_base_url('/admisi/data-wilayah') ?>?sort=1" class="sorting" >Nama Propinsi</a></th>
            <th><a href="<?= app_base_url('/admisi/data-wilayah') ?>?sort=2" class="sorting" >Nama Kabupaten/Kota</a></th>
            <th><a href="<?= app_base_url('/admisi/data-wilayah') ?>?sort=3" class="sorting" >Nama Kecamatan</a></th>
            <th><a href="<?= app_base_url('/admisi/data-wilayah') ?>?sort=4" class="sorting" >Nama Kelurahan</a></th>
            <th style="width:15%">Aksi</th>

        </tr>
<?php foreach ($propinsi['list'] as $num => $row): ?>
        <tr class="<?= ($num % 2) ? 'even' : 'odd' ?>">
        <!--<td align=center><?= ++$num + $propinsi['offset'] ?></td>-->
            <td align="center"><?= $row['id'] ?></td>
            <td><?= $row['nama'] ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="aksi" style="text-align: left">
                <a href="<?= app_base_url('/admisi/data-wilayah/?do=editProvince&id=' . $row['id'] . '&page=' . $page . '') ?>" title="Edit Propinsi" class="edit">edit</a>
                <a href="<?= app_base_url('/admisi/data-wilayah/?do=addKabupaten&idProvinsi=' . $row['id'] . '&page=' . $page . '') ?>" title="Tambah Kabupaten" class="inadd">tambah</a>
            </td>
        </tr>

        <?
        if ($category == 2) {
            $kabupaten = kabupaten_by_propinsi($row['id'], isset($order2) ? $order2 : NULL, $key);
        } else {
            $kabupaten = kabupaten_by_propinsi($row['id'], isset($order2) ? $order2 : NULL);
        }
        foreach ($kabupaten['list'] as $numb => $rowA):
        ?>
            <tr class="<?= ($numb % 2) ? 'odd' : 'even' ?>">
                <td align=center></td>
                <td></td>
                <td><?= $rowA['nama'] ?></td>
                <td></td>
                <td></td>
                <td class="aksi" style="text-align: left">
                    <a href="<?= app_base_url('/admisi/data-wilayah/?do=editKabupaten&idKabupaten=' . $rowA['id'] . '&idProvinsi=' . $row['id'] . '&page=' . $page . '') ?>" title="Edit Kabupaten" class="edit">edit</a>
                    <?
                      $cekKecamatan = kecamatan_by_kabupaten($rowA['id']);
                      if(count($cekKecamatan['list']) == 0){
                   ?>
                    <a href="<?= app_base_url('admisi/control/wilayah/delete-kabupaten/?id='.$rowA['id'].'&page='.$page.'')?>" class="delete" title="Hapus Kabupaten">delete</a>
                   <? 
                      }
                   ?>
                    <a href="<?= app_base_url('/admisi/data-wilayah/?do=addKecamatan&idKabupaten=' . $rowA['id'] . '&page=' . $page . '') ?>" title="Tambah Kecamatan" class="inadd">tambah</a>
                </td>
            </tr>


        <?php

            if ($category == 3) {
                $kecamatan = kecamatan_by_kabupaten($rowA['id'], isset($order3) ? $order3 : NULL, $key, $idKecamatan);
            } else {
                $kecamatan = kecamatan_by_kabupaten($rowA['id'], isset($order3) ? $order3 : NULL);
            }
            foreach ($kecamatan['list'] as $numb => $rowB):
        ?>
                <tr class="<?= ($numb % 2) ? 'even' : 'odd' ?>">
                    <td align=center></td>
                    <td></td>
                    <td></td>
                    <td><?= $rowB['nama'] ?></td>
                    <td></td>
                    <td class="aksi" style="text-align: left">
                        <a href="<?= app_base_url('/admisi/data-wilayah/?do=editKecamatan&idKecamatan=' . $rowB['id'] . '&idKabupaten=' . $rowA['id'] . '&page=' . $page . '') ?>" title="Edit Kecamatan" class="edit">edit</a>
                        <?
                          $cekKelurahan = kelurahan_by_kecamatan($rowB['id']);
                          if(count($cekKelurahan) == 0){
                        ?>
                         <a href="<?= app_base_url('admisi/control/wilayah/delete-kecamatan/?id='.$rowB['id'].'&page='.$page.'')?>" class="delete" title="Hapus Kecamatan">delete</a>
                        <? 
                          }
                        ?>
                        <a href="<?= app_base_url('/admisi/data-wilayah/?do=addKelurahan&idKecamatan=' . $rowB['id'] . '&page=' . $page . '') ?>" title="Tambah Kelurahan" class="inadd">tambah</a>
                    </td>
                </tr>

        <?php
                if ($category == 4) {
                    $kelurahan = kelurahan_by_kecamatan($rowB['id'], isset($order4) ? $order4 : NULL, $key);
                } else {
                    $kelurahan = kelurahan_by_kecamatan($rowB['id'], isset($order4) ? $order4 : NULL);
                }
                foreach ($kelurahan  as $numc => $rowC):
        ?>
                    <tr class="<?= ($numc % 2) ? 'odd' : 'even' ?>">
                        <td align=center></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?= $rowC['nama'] ?></td>
                        <td class="aksi" style="text-align: left">
                            <a href="<?= app_base_url('/admisi/data-wilayah/?do=editKelurahan&idKelurahan=' . $rowC['id'] . '&idKecamatan=' . $rowC['id_kecamatan'] . '&page=' . $page . '') ?>" title="Edit" class="edit">edit</a>
                            <a href="<?= app_base_url('admisi/control/wilayah/delete-kelurahan/?id='.$rowC['id'].'&page='.$page.'')?>" class="delete" title="Hapus Kelurahan">delete</a>
                        </td>
                    </tr>
        <?php endforeach; ?>
        <?php endforeach; ?>
        <?php endforeach; ?>
<?php endforeach; ?>
                </table></div>
<?
                    echo $propinsi['paging'];
					
                    $count1 = isset ($propinsi['propinsi'])?$propinsi['propinsi']:NULL;
                    $count2 = isset ($kabupaten['kabupaten'])?$kabupaten['kabupaten']:NULL;
                    $count3 = isset ($kecamatan['kecamatan'])?$kecamatan['kecamatan']:0;
					$kelurahans=kelurahan_muat_data();
					 $count4 = isset ($kelurahans['kelurahan'])?$kelurahans['kelurahan']:NULL;
      echo "<p>Jumlah Total Nama Wilayah: ".$count1." Propinsi, ".$count2." Kabupaten, ".$count3." Kecamatan , ".$count4." Kelurahan </p>";?>

<script type="text/javascript">
    $(document).ready(function(){
        $('#keyword').attr("disabled","disabled");
		 if($('#category').val()!=0){
                $('#keyword').removeAttr("disabled");
            }
			else{
        $('#category').change(function(){
            if($('#category').val()!=0){
                $('#keyword').removeAttr("disabled");
            }else{
                $('#keyword').attr("disabled","disabled");
            }
        });
		}
    });
</script>