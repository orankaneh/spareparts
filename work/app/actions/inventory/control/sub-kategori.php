<?php
if(isset($_POST['simpan'])){
$idSub= $_POST['idSubKategori'];
    if(isset($_POST['idSubKategori']) && $_POST['idSubKategori'] != ''){
        _update("update sub_kategori_barang set permit_penjualan='$_POST[permit_jual]',nama='$_POST[subKategori]' where id='$_POST[idSubKategori]'");
    }else{
        _insert("insert into sub_kategori_barang (nama,id_kategori_barang,permit_penjualan) 
                values ('$_POST[subKategori]','$_POST[idKategori]','$_POST[permit_jual]')");
		$idSub = _last_id();
    }
    header('location:'.  app_base_url('inventory/sub-kategori').'?msg=1&code='.$idSub);
}else if(isset($_GET['do']) && $_GET['do']=='del'){
$idapus=$_GET['id'];
$sql = "select count(*) as jumlah from barang where id_sub_kategori_barang = '$idapus'";
	$jml = _select_unique_result($sql);
	if ($jml['jumlah'] > 0) {
		header('location:'.  app_base_url('admisi/data-pendidikan').'?msr=14');
	} else {
    delete_list_data($_GET['id'], 'sub_kategori_barang', 'inventory/sub-kategori/?msg=2','inventory/sub-kategori/?msr=7',null,null,null,generate_get_parameter($_GET, null, array('msr','msg','do','id')));
}
}
?>