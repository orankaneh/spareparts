<?php
require_once 'app/lib/administrasi/usersystem.php';
require_once 'app/lib/common/functions.php';
require_once 'app/config/db.php';
set_time_zone();

$key = isset ($_GET['key'])?$_GET['key']:NULL;
$usersystem = usersystem_muat_data(NULL,NULL, NULL, NULL, $key);
?>
<html>
  <head>
     <title>Stok Barang</title> 
     <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/base.css')?>">
     <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/style.css')?>">
     <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/tabel.css')?>">
     <script type="text/javascript">
  	function cetak() {  		
  		SCETAK.innerHTML = '';
		window.print();
		if (confirm('Apakah menu print ini akan ditutup?')) {
			window.close();
		}
		SCETAK.innerHTML = '<br /><input onClick=\'cetak()\' type=\'submit\' name=\'Submit\' value=\'Cetak\' class=\'tombol\'>';
  	}
  
   </script>
  </head>  
  <body>
    <?require_once 'app/actions/admisi/lembar-header.php';?> 
  <center>INFORMASI USER ACCOUNT</center>
  <div class="data-list">
      <table class="table-cetak">
        <tr>
            <th>No</th>
            <th>Username/NIP</th>
            <th>Pegawai</th>
            <th>Role</th>
            <th>Nama Unit</th>
            <th>Akses Barang</th>
            <th>Akses Terakhir</th>
        </tr>
        <?php
		
        foreach($usersystem as $numb => $row):
        ?>
        <tr class="<?= ($numb%2) ? 'even' : 'odd' ?>">
            <td align="center"><?= ++$numb ?></td>
            <td><?= $row['username'] ?></td>
            <td class="no-wrap"><?= $row['nama'] ?></td>
            <td class="no-wrap"><?= $row['nama_role']?></td>
            <td class="no-wrap"><?=$row['nama_unit'] ?></td>
            <td class="no-wrap"><?= $row['nama_kategori'] ?></td>
            <td align="center" class="no-wrap"><?= $row['last_access'] ?></td>
        </tr>
        <?php endforeach; ?>
      </table>
   </div>
   <center>
      <p><span id="SCETAK"><input type="button" class="button" value="Cetak" onClick="cetak()"/></span></p>
   </center>
  </body>
</html>  
<?php
exit();
?>