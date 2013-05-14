<?php
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';
$sub_kategori = sub_kategori_barang_muat_data($_GET['kategori']);
?>
<label for="subkategori">Sub Kategori</label>
	<select id="kategori" name="sub_kategori" >
	  <option value="">Pilih kategori</option>
	  <?php foreach($sub_kategori as $rows): ?>
	  <option value="<?= $rows['id'] ?>" <?php if ($rows['id'] == (isset($_GET['sub_kategori'])?$_GET['sub_kategori']:NULL)) echo "selected"; ?>><?= $rows['nama'] ?></option>
	  <?php endforeach; ?>
	</select>
<?php
die;
?>