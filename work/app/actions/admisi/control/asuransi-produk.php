<?php
if(isset($_POST['simpan'])){
    if(isset($_POST['idAsuransi'])&& $_POST['idAsuransi']!=''){
        _update("update asuransi_produk set nama='$_POST[nama]',id_instansi_relasi='$_POST[idPerusahaan]' where id='$_POST[idAsuransi]'");
        $id = $_POST['idAsuransi'];
    }else{
        _insert("insert into asuransi_produk (nama,id_instansi_relasi) values ('$_POST[nama]','$_POST[idPerusahaan]')");
        $id = _last_id();
    }
    header('location:'.  app_base_url('admisi/asuransi-produk').'?idProduk='.$id.'&msg=1');
}else if(isset($_GET['do']) && $_GET['do']=='del'){
    delete_list_data($_GET['id'], 'asuransi_produk', 'admisi/asuransi-produk/?msg=2','admisi/asuransi-produk/?msr=7',null,null,null,generate_get_parameter($_GET, null, array('msr','msg','do','id')));
}
?>