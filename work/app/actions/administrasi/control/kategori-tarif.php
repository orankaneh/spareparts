<?php
if(isset($_POST["simpan"])){
	if($_POST["idtarif"]!=''){
		$id = $_POST["idtarif"];
		$update = _update("update kategori_tarif set nama='".$_POST["nama"]."',keterangan='".$_POST["keterangan"]."' where id='".$id."'");
		if($update){
			header("location: ".app_base_url('administrasi/kategori-tarif')."?msg=1&code=$id");
		}
	}else{
	   $insert = _insert("insert into kategori_tarif (nama,keterangan)values ('".$_POST["nama"]."','".$_POST["keterangan"]."')"); echo mysql_error();
		$id=_last_id();
		if($insert){
			header("location: ".app_base_url('administrasi/kategori-tarif')."?msg=1&code=$id");
		}
	}
}else if(isset($_GET["do"]) && $_GET["do"]!=NULL && isset($_GET["iddel"]) && $_GET["iddel"]!=NULL){
	?>
	  <h2 class="judul">Master Data Kategori Tarif</h2>
	<?
	delete_list_data($_GET['iddel'], 'kategori_tarif', 'administrasi/kategori-tarif?msg=2',null);
}

?>