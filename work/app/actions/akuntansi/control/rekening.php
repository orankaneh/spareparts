 <?php
 // Control Rekening & Kategori Rekening
 
 
if (isset($_GET['section'])) {

switch($_GET['section']) {   
case "addKategori":
   $kode=$_POST["kode_kategori"];
   $nama=$_POST["nama_kategori"];
   $check = _num_rows("select * from kategori_rekening where kode='".$kode."' or nama='".$nama."'");
   if ($check != 0) {
      echo 2;
      
   } else {
   
   $insert = _insert("insert into kategori_rekening (kode,nama) values ('".$kode."','".$nama."')"); echo mysql_error();
   if ($insert) echo 1;

   }
   
   break;

case "editKategori":
   $kode=$_POST["kode_kategori"];
   $nama=$_POST["nama_kategori"];
   $id=$_POST["id"];
   
   $check = _num_rows("select * from kategori_rekening where (kode='".$kode."' or nama='".$nama."') and id<>'".$id."'");
   if ($check != 0) {
      echo 2;
   } else {
   
   $updating = _update("update kategori_rekening set kode='".$kode."',nama='".$nama."' where id='".$id."'");
   if ($updating) echo 3;
   }
   break;

case "addRekening":
   
   //Control Tambah Rekening
   
	  if (!empty($_POST["id"])) {
		$sql = "select * from rekening where (nama='".$_POST["nama"]."' or kode='".$_POST["prekode"].".".$_POST["kode"]."') and id<>'".$_POST["id"]."'";
			if (_num_rows($sql) > 0) {
				echo 2;
			} else {
			$idkategori=explode('.',$_POST['kategori']);
			$process = _update("update rekening set kode='".$_POST["prekode"].".".$_POST["kode"]."',nama='".$_POST["nama"]."',status='".$_POST["status"]."', id_kategori='".$idkategori[0]."'  where id='".$_POST["id"]."'");
			if ($process) echo 3;
			}
	  } else {
			$sql = "select * from rekening where (nama='".$_POST["nama"]."' or kode='".$_POST["prekode"].".".$_POST["kode"]."') and id<>'".$_POST["id"]."'";
			if (_num_rows($sql) > 0) {
				echo 2;
			} else {
				$idkategori=explode('.',$_POST['kategori']);
				$process = _insert("insert into rekening (kode,nama,status,id_kategori) values ('".$_POST["prekode"].".".$_POST["kode"]."','".$_POST["nama"]."','".$_POST["status"]."','".$idkategori[0]."')"); echo mysql_error();	
				if ($process) echo 1;
			}
	  }
 
   
   break;

case "deleteRekening":
   
	//Control Hapus Rekening;
	$check_jurnal = _num_rows("select * from detail_jurnal where id_rekening = '".$_POST['id']."'");
	if ($check_jurnal == 0) {
		$rekening=mysql_query("delete from rekening where id='".$_POST['id']."'");
		if ($rekening) echo 1;
	} else {
		echo 2;
	}
	break;

case "deleteKategoriRekening":
	// check Format Laporan Keuangan
	$check_laporan = _num_rows("select * from format_laporan_akuntansi where id_kategori_rekening = '".$_POST['id']."'");
	
	// check Rekening
	$check_rekening = _num_rows("select * from rekening where id_kategori='".$_POST['id']."'");
	
	if ($check_laporan == 0 and $check_rekening == 0) {
		$rekening=mysql_query("delete from rekening where id_kategori='".$_POST['id']."'");
		if ($rekening) {
			$kategori=mysql_query("delete from kategori_rekening where id='".$_POST['id']."'");
			if ($kategori) echo 1;
		}
	} else {
		echo 2;
	}
	break;
}

}

exit();
?>