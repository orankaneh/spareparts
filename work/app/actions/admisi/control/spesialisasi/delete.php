<?php
/*
if(isset($_GET['do']) and isset($_GET["id"])){
	if($_GET['do']=="delete"){
		$delete = mysql_query("delete from dokter where id='".$_GET["id"]."' ");
		if($delete){
			header('location:' . app_base_url('admisi/spesialisasi_dokter?msg=2'));
			}
	}
}*/
?>
<?php
if (isset($_GET['id']) && $_GET['do'] == "delete")
{
?>
    <h1 class="judul">Master Data Dokter</h1>
    <?php
    delete_list_data($_GET['id'], 'dokter', 'admisi/spesialisasi_dokter?msg=2',null);
}
?>