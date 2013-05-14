<?php
set_time_zone();
/*
echo '<pre>';
print_r($_POST);
echo '</pre>';
exit;
*/
if(isset ($_POST['save']))
{
	$pegawai	= User::$id_user;
	$distribusi	= $_POST['id_distribusi'];
	$id_packing = $_POST['id_packing'];
	$batch		= $_POST['batch'];
	$jumlah		= $_POST['jumlah'];
	$idUnit		= $_SESSION['id_unit'];
    _insert("insert into penerimaan_unit values ('',now(),'$pegawai')");
    $id = _last_id();
    
    foreach ($id_packing as $key => $content)
	{
		$jumlahs	= $jumlah[$key];
		$cek		= _select_unique_result("select id_penerimaan_unit,id_distribusi,id_packing_barang,batch,jumlah_distribusi from detail_distribusi_penerimaan_unit where id_distribusi = '$distribusi' and id_packing_barang = '$content' and batch = '$batch[$key]'");
		if($cek['id_penerimaan_unit'] != NULL)
		{
			$sql = "insert into detail_distribusi_penerimaan_unit (id_distribusi,id_packing_barang,batch,jumlah_distribusi,id_penerimaan_unit,jumlah_penerimaan_unit)
					values ('$cek[id_distribusi]','$cek[id_packing_barang]','$cek[batch]','$cek[jumlah_distribusi]','$id','$jumlahs')";
			_insert($sql);
		} else
		{
			_update("update detail_distribusi_penerimaan_unit set id_penerimaan_unit='$id',jumlah_penerimaan_unit='$jumlah[$key]' where id_distribusi='$distribusi' and id_packing_barang='$content' and batch='$batch[$key]'");
		}
		
		_insert("insert into detail_penerimaan_unit_retur_unit 
				(id_penerimaan_unit,id_packing_barang,batch,jumlah_penerimaan_unit) 
				VALUES ($id,$content,'$batch[$key]',$jumlahs)");
		
		$query	= "select * from stok_unit where id_packing_barang = '$id_packing[$key]' and batch = '$batch[$key]' and id_unit = '$idUnit' and id = (select max(id) from stok_unit where id_packing_barang = '$id_packing[$key]' and batch = '$batch[$key]' and id_unit = '$idUnit')";
		$query2	= "select hpp,hna from stok where id_packing_barang='$id_packing[$key]' and batch = '$batch[$key]' and id = (select max(id) from stok where id_packing_barang='$id_packing[$key]' and batch = '$batch[$key]')";
		
		$data	= _select_unique_result($query);
		$data2	= _select_unique_result($query2);
		$sisa	= ($data['sisa']+$jumlahs);
		$count	= countrow($query);
//        $konversi=_select_unique_result("select nilai_konversi from packing_barang where id='$cek[id_packing_barang]'"); ($jumlahs*$konversi['nilai_konversi'])
		if($count == 0)
		{
			$insertStok = _insert("insert into stok_unit (waktu,id_packing_barang,batch,id_unit,awal,masuk,keluar,sisa,id_jenis_transaksi,hpp,hna,margin) 
								values (now(),'$id_packing[$key]','$batch[$key]','$idUnit','0','$jumlahs','0','$jumlahs',7,'$data2[hpp]','$data2[hna]',0)");
		} else if($count >= 1)
		{
			$insertStok = _insert("insert into stok_unit (waktu,id_packing_barang,batch,id_unit,awal,masuk,keluar,sisa,id_jenis_transaksi,hpp,hna,margin) 
								values (now(),'$id_packing[$key]','$batch[$key]','$idUnit','$data[sisa]','$jumlahs','0','$sisa',7,'$data2[hpp]','$data2[hna]',0)");
		}
	}
	
	if($insertStok)
	{
		header('location:'.  app_base_url('inventory/penerimaan-unit-info').'?msg=4&id='.$id.'');
	} else
	{
		header('location:'.  app_base_url('inventory/penerimaan-unit').'?msr=3');
	}
}
?>