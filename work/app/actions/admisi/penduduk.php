<style type="text/css">
    #perhatian{
        background:#f4f4f4;
        text-align: justify;
    }
    #perhatian legend{
        font-size:8px;
        font-weight:bold;
        text-transform:uppercase;
        background:#f1f1f1;
        border-top:1px dotted #333;
        border-left:1px dotted #333;
        border-right:1px dotted #333;
        padding:3px;
        background:#ddd;
    }
</style>
<script type="text/javascript">
    $(document).ready(function(){
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
<?
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';
include_once 'app/actions/admisi/pesan.php';
$category = isset ($_GET['category'])?$_GET['category']:NULL;
$sort = isset($_GET['sort'])?$_GET['sort']:NULL;
$sortBy = isset($_GET['sortBy'])?$_GET['sortBy']:NULL;
$page = isset($_GET['page'])?$_GET['page']:NULL;
$perPage = 18;
$key = isset($_GET['key'])?$_GET['key']:NULL;
$id = isset ($_GET['idPenduduk'])?$_GET['idPenduduk']:NULL;
$penduduk = penduduk_muat_data($id,$key,$category,$sort,$sortBy,$page,$perPage);
//$posisi = posisi_keluarga_muat_data();
//$perkawinan = perkawinan_muat_data();

$profesi = profesi_muat_data();
$pekerjaaan = pekerjaan_muat_data();
$agama = agama_muat_data();
$pendidikan = pendidikan_muat_data();
?>

<div class="judul"><a href="<?= app_base_url('admisi/penduduk')?>">Master Data penduduk </a></div><?= isset($pesan)?$pesan:NULL;?>

<?
if (isset($_GET['do'])) {
	if ($_GET['do'] == 'add') {
		require_once 'app/actions/admisi/add-penduduk.php';
	} 
	else if ($_GET['do'] == 'edit') {
		require_once 'app/actions/admisi/edit-penduduk.php';
	}
}

?>
	
	<div class="data-list full">
            <div class="floleft" style="margin: 10px 0">
				<?php echo addButton('/admisi/penduduk/?do=add','Tambah'); ?>
			</div>  
            <div class="floright" style="margin: -5px 0 0 0">
			<form action="" method="GET" class="search-form">
               <select name="category" id="category" class="select-style" style="width: 145px">
                   <option value="0">Cari Berdasarkan</option>
                   <option value="1" <?if($category == 1){echo "selected";}?>>Nama</option>
                   <option value="2" <?if($category == 2){echo "selected";}?>>Kelurahan</option>
                   <option value="3" <?if($category == 3){echo "selected";}?>>Kecamatan</option>
                   <option value="4" <?if($category == 4){echo "selected";}?>>No. KK</option>
                   <option value="5" <?if($category == 5){echo "selected";}?>>Tgl. Lahir</option>
                   <option value="6" <?if($category == 6){echo "selected";}?>>Jenis Kelamin</option>
                   <option value="7" <?if($category == 7){echo "selected";}?>>No. Telepon</option>
               </select>    
               <input type="text" name="key" class="search-input"  style="margin-top: 5px" id="keyword" value="<?= $key?>" <?=(empty($_GET['key'])?'disabled':'')?>/><input type="submit" class="search-button" value=""/>
            </form>
			</div>
		<table cellpadding="0" cellspacing="0" border="0" id="table" class="tabel full">
			<tr>
                            <th style="width:70px"><!--<a href="<?//app_base_url('/admisi/penduduk?').generate_sort_parameter(0, $sortBy)?>" class="sorting"></a>-->NO</th>
                            <th style="width:70px"><a href="<?= app_base_url('/admisi/penduduk?').generate_sort_parameter(1, $sortBy)?>" class="sorting">Nama Lengkap</a></th>
                            <th style="width:130px">Alamat Jalan</th>
                            <th>Kelurahan</th>
                            <th>Kecamatan</th>
                            <th><a href="<?= app_base_url('/admisi/penduduk?').generate_sort_parameter(2, $sortBy)?>" class="sorting">Tgl Lahir</a></th>
                            <th><a href="<?= app_base_url('/admisi/penduduk?').generate_sort_parameter(3, $sortBy)?>" class="sorting">Kelamin</a></th>
                            <th>No. Telepon</th>
                            <th>Aksi</th>
				
			</tr>
			
			<? $no=nomer_paging($page,$perPage);
             foreach($penduduk['list'] as $num => $row): ?>
			
			<tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
				<td align=center><?= $no++ ?></td>
				<td class="no-wrap"><a href="<?= app_base_url('admisi/detail-pend')?>?id=<?= $row['id']?>" class=link title="Detail"><?= $row['nama'] ?></a></td>
				<td class="no-wrap"><?= $row['alamat_jalan']!='NULL'?$row['alamat_jalan']:'' ?></td>
				<td class="no-wrap"><?= ucwords(strtolower($row['nama_kel'])) ?></td>
                                <td class="no-wrap"><?= ucwords(strtolower($row['nama_kec'])) ?></td>
				<td align=center><?= datefmysql($row['tanggal_lahir']); ?></td>
				<td align=center><?= $row['jenis_kelamin'] ?></td>
				<td align=center><?= $row['no_telp']!='NULL'?$row['no_telp']:'' ?></td>
				<td align=center class="aksi">
					<a href="<?= app_base_url('/admisi/penduduk/?do=edit&id='.$row['id'])."&".  generate_get_parameter($_GET, null, array('do','id')) ?>" class="edit"><small>edit</small></a>
                                        <a href="<?= app_base_url('/admisi/control/penduduk/delete?id='.$row['id']."&".  generate_get_parameter($_GET, null, array('do','id'))) ?>" class="delete"><small>delete</small></a>
				</td>
			</tr>
			<? endforeach ?>
  		</table>
		
	</div>
	<?php
        echo $penduduk['paging'];
		$count = $penduduk['total'];
      echo "<p>Jumlah Total Nama Penduduk: ".$count."</p>";
		?>