<?php
if (isset($_POST['idBarang'])) {
    if (isset($_POST['barcode']) && $_POST['barcode'] != NULL) {
        //cek barang sudah diinput belom??
        $query = _select_arr("select * from packing_barang where id_barang='$_POST[idBarang]' and barcode='$_POST[barcode]'");
        if (count($query) >= 1) {
            header('location:' . app_base_url('inventory/packing-barang') . '?msr=10');
        }
    }
    $array = array($_POST['idPackingBarang'], $_POST['barcode'], $_POST['idBarang'], $_POST['kemasan'], $_POST['konversi'], $_POST['satuan']);
    for ($i = 0; $i <= 5; $i++) {
        if (empty($array[$i])) {
            $array[$i] = "NULL";
        }
    }
    if (isset($_POST['idPackingBarang']) && $_POST['idPackingBarang'] != '') {
        //update packing barang
	$id=$array[0];
        $barcode = (isset ($_POST['barcode']) && $_POST['barcode'] != '')?$_POST['barcode']:$array[0];
        
        _update("update packing_barang
                set barcode='$barcode',id_satuan_terbesar={$array[3]},nilai_konversi='$_POST[konversi]',id_satuan_terkecil={$array[5]}
                where id={$array[0]}");       
    } else {
        //insert packing barang
        _insert("insert into packing_barang (barcode,id_barang,id_satuan_terbesar,nilai_konversi,id_satuan_terkecil)
            values ('$_POST[barcode]',{$array[2]},{$array[3]},'$_POST[konversi]',{$array[5]})");
        $id = _last_id();
        
        if($_POST['barcode'] == ''){
            $barcode=$id;
            for($i=strlen($barcode);$i<11;$i++){
                $barcode="0".$barcode;
            }
            _update("update packing_barang set barcode = '$barcode' where id='$id'");
        }
        /*$kelas = _select_arr("select * from kelas");
        foreach ($kelas as $k) {
            _insert("insert into margin_packing_barang_kelas (id_packing_barang,id_kelas,nilai_persentase) VALUES
                    ('$id','$k[id]','$k[margin]')");
        }*/
    }
    header('location:' . app_base_url('inventory/packing-barang') . '?msg=1&code=' . $id);
} else if (isset($_GET['do']) && $_GET['do'] == 'del') {
    require_once 'app/lib/common/master-data.php';
    $packing = packing_barang_muat_data($_GET['id']);
    $sediaan = " ".$packing['sediaan'];
    $kekuatan = " ".$packing['kekuatan'];
    if($packing['generik'] == "Generik"){
        $pabrik = $packing['instansi_relasi'];
    }else $pabrik = "";
    //0=>'delete from margin_packing_barang_kelas where id_packing_barang="'.$_GET['id'].'"',
    delete_list_data2($packing['nama_barang']."".$kekuatan."".$sediaan." @".$packing['nilai_konversi']." ".$packing['satuan_terkecil']." ".$pabrik, 'inventory/packing-barang/?msg=2', 'inventory/packing-barang/?msr=7',array(0=>'delete from packing_barang where id="'.$_GET['id'].'"'),generate_get_parameter($_GET, null, array('msr','msg','do','id')));
}
?>