<?php
if(isset($_POST['nama'])){
    if(isset($_POST['idBarang'])&& $_POST['idBarang']!=''){
        $kategori=_select_unique_result("select id_sub_kategori_barang as kategori from barang where id=$_POST[idBarang]");
        $del=true;
        //dari barang obat ke bukan obat
        if($kategori['kategori']==1 && $_POST['idKategori']!=1){
            $del=_delete("delete from obat where id=$_POST[idBarang]");
        }else if($kategori['kategori']!=1 && $_POST['idKategori']==1){
            //dari barang bukan obat menjadi barang obat
            _insert("INSERT INTO obat (id) values ('$_POST[idBarang]')");
        }
        if($del){
            _update("update barang set nama='$_POST[nama]',id_sub_kategori_barang='$_POST[idKategori]',id_instansi_relasi_pabrik='$_POST[idPabrik]' where id='$_POST[idBarang]'");
            header('location:'.  app_base_url('inventory/barang').'?msg=1&category=1&code='.$_POST['idBarang']);
        }else
            header('location:'.  app_base_url('inventory/barang').'?msr=7');
    }else{
        _insert("insert into barang (id,nama,id_sub_kategori_barang,id_instansi_relasi_pabrik) values ('','$_POST[nama]','$_POST[idKategori]','$_POST[idPabrik]')");
		  $code= _last_id();
        if($_POST['idKategori']==1){
            _insert("INSERT INTO obat (id) values ('$code')");
        }
        header('location:'.  app_base_url('inventory/barang').'?msg=1&category=1&code='.$code);
    }

}else if(isset($_GET['do']) && $_GET['do']=='del'){
$sql = "select count(*) as jumlah from packing_barang where id_barang = '$_GET[id]'";
	$jml = _select_unique_result($sql);
	if ($jml['jumlah'] > 0) {
		header('location:'.  app_base_url('inventory/barang/').'?msr=14');
	} else {
    delete_list_data($_GET['id'], 'barang', 'inventory/barang/?msg=2','inventory/barang/?msr=7',null,null,null,generate_get_parameter($_GET, null, array('msr','msg','do','id')));
	}
}
?>