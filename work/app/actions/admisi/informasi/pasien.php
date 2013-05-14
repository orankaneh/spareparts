<?
    require_once 'app/lib/common/master-data.php';
    require_once 'app/lib/common/functions.php';

    $category = isset ($_GET['category'])?$_GET['category']:NULL;
    $sort = isset ($_GET['sort'])?$_GET['sort']:NULL;
    $sortBy = isset ($_GET['sortBy'])?$_GET['sortBy']:NULL;
    $page = isset ($_GET['page'])?$_GET['page']:NULL;
    $key = isset ($_GET['key'])?$_GET['key']:NULL;
    //$pasien = pasien_opname_muat_data(NULL,isset($_GET['key'])?$_GET['key']:NULL,$category,$sort,$sortBy, $page, $dataPerPage = 18);
    $pasien=  informasi_pasien_muat_data(null, $key, $category, $sort, $sortBy, $page, 50);
	//show_array($pasien);

?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#keyword').attr("disabled","disabled");
        if($('#category').val()!=0){
            $('#keyword').removeAttr("disabled");
        }else{
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
<div class="judul"><a href="<?= app_base_url('admisi/informasi/pasien')?>">Informasi Pasien</a></div>
<div class="data-list">  
    <div class="floright" style="margin: -5px 0 0 0">  
        <form action="" method="GET" class="search-form">
            <select name="category" id="category" class="select-style" style="width: 145px">
            <option value="">Cari Berdasarkan</option>   
            <option value="1" <?if($category == 1){echo "selected";}?>>No. RM</option>
            <option value="2" <?if($category == 2){echo "selected";}?>>Nama</option>
            <option value="3" <?if($category == 3){echo "selected";}?>>Jenis Kelamin</option>
            <option value="4" <?if($category == 4){echo "selected";}?>>Kelurahan</option>
            <option value="5" <?if($category == 5){echo "selected";}?>>Kecamatan</option>
            </select>      
            <input type="text" name="key" class="search-input" id="keyword" value="<?=$key?>"/><input type="submit" value="" class="search-button"/>
        </form>
  </div>
    <table cellpadding="0" cellspacing="0" border="0" id="table" class="tabel">
                    <tr>
                        <th style="width:5%;"><a href="<?= app_base_url('/admisi/informasi/pasien?').generate_sort_parameter(1, $sortBy) ?>" class="sorting">No.RM</a></th>
                        <th style="width:15%;"><a href="<?= app_base_url('/admisi/informasi/pasien?').generate_sort_parameter(2, $sortBy) ?>" class="sorting">Nama Lengkap</a></th>
                        <th style="width:2%;"><a href="<?= app_base_url('/admisi/informasi/pasien?').generate_sort_parameter(3, $sortBy) ?>" class="sorting">Kelamin</a></th>
                        <th style="width:5%;">Usia (Th)</th>
                        <th style="width:3%;">Gol.Darah</th>
                        <th style="width:15%;">Alamat Jalan</th>
                        <th style="width:7%;">Kelurahan</th>
                        <th style="width:8%;">Kecamatan</th>
                        <th style="width:8%;">No. Telp</th>
                        <th style="width:7%;">No. Kunjungan</th>
                        <!--<th style="width:5%;" class="nosort">Action</th>-->
                    </tr>

            <? foreach($pasien['list'] as $num => $row): ?>
                    <tr class="<?= ($num%2) ? 'even':'odd' ?>">
                            <td align="center"><a href="<?= app_base_url('admisi/detail-pas?pid='.$row['id_pas'].'&menu=info') ?>" title="detail" class="link"><?= $row['id_pas'] ?></a></td>
                            <td><a href="<?= app_base_url('admisi/detail-pas?pid='.$row['id_pas'].'&menu=info') ?>" title="detail" class="link"><?= $row['nama'] ?></a></td>
                            <td align="center"><?= $row['jenis_kelamin'] ?></td>
                            <td align="center"><?= createUmur($row['tanggal_lahir']) ?></td>
                            <td align=center><?= $row['gol_darah'] ?></td>
                            <td><?= $row['alamat_jalan'] ?></td>
                            <td><?= $row['nama_kelurahan'] ?></td>
                            <td><?= $row['nama_kecamatan'] ?></td>
                            <td><?= $row['no_telp'] ?></td>
                            <td align="center"><?= ($row['no_kunjungan'] ==null)?'0':$row['no_kunjungan'] ?></td>
                            <!--<td align="center" class="aksi">
                            <a href="<?= app_base_url('/admisi/opname-pasien/?do=edit&id='.$row['id_pas'].'') ?>" title="Edit" class="edit"><small>edit</small></a>
                            <a href="<?= app_base_url('/admisi/control/pasien/delete?id='.$row['id_pas'].'') ?>" title="Delete" class="delete"><small>delete</small></a>
                            </td>-->
                    </tr>
        <? endforeach; ?>
        </table>  
</div>
<div class="floright" style="margin: -5px 0 0 0">
    <a href="<?= app_base_url('admisi/report/pasien-excel/').'?'.generate_get_parameter($_GET)?>" class="excel">Cetak Excel</a>
</div>
<?= $pasien['paging'] ;

$count = $pasien['total'];
      echo "<p>Jumlah Total Nama Pasien: ".$count."</p>";?>
</div>