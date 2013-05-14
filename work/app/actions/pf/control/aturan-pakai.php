<?php
	$keterangan = isset($_POST['keterangan'])?$_POST['keterangan']:NULL;
	$id = isset($_POST['id'])?$_POST['id']:NULL;
	$idDelete = isset($_GET['id'])?$_GET['id']:NULL;
	if (isset($_POST['add'])) {
			$sql = _insert("insert into aturan_pakai values ('','$keterangan')");
			  $code = _last_id();
		if ($sql) {
		   header("location: ".app_base_url('pf/aturan-pakai')."?msg=1&code=".$code);

	}
	}if (isset($_POST['edit'])) {
 $select = _select_arr("select * from aturan_pakai where nama='$keterangan' and id=$id");
        $count = count($select);
        if($count > 0){
		$sql = _update("update aturan_pakai set nama = '$keterangan' where id = '$id'");
		if ($sql) {
		   header("location: ".app_base_url('pf/aturan-pakai')."?msg=1&code=".$id);
		}
	} else{
  $selectlagi = _select_arr("select * from aturan_pakai where nama='$keterangan'");
     $countlagi = count($selectlagi);
        if($countlagi > 0){
            header('location:'.  app_base_url('pf/aturan-pakai').'?msr=12');
        }else{
		$exelagi = _update("update aturan_pakai set nama = '$keterangan' where id = '$id'");
		 if ($exelagi) {
	   header("location: ".app_base_url('pf/aturan-pakai')."?msg=1&code=".$id);
  }   }
 }
 }if ($idDelete != null) {
		echo "<h2 class='judul'>Master Data Aturan Pakai</h2>";
			$sql = "select count(*) as jumlah from detail_resep_penjualan where id_aturan_pakai = '$idDelete'";
	$jml = _select_unique_result($sql);
	if ($jml['jumlah'] > 0) {
		header('location:'.  app_base_url('pf/aturan-pakai').'?msr=14')."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id'));
	} else {
		delete_list_data($idDelete, 'aturan_pakai', 'pf/aturan-pakai?msg=2','pf/aturan-pakai?msr=7',null,null,null,generate_get_parameter($_GET, null, array('msr','msg','do','id')));
	}
	}
?>