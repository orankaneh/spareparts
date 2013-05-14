<? 
  include_once "app/lib/common/functions.php";
  include_once "app/lib/common/master-data.php";
  set_time_zone();
    $bilnya = isset($_GET['idBilling'])?$_GET['idBilling']:NULL;
    $info = detail_rawat_inap($_GET['idKunjungan']);
    $idKunjungan = $_GET['idKunjungan'];
    $idTarif = $_GET['idTarif'];
    $bed = isset($_GET['idBed'])?$_GET['idBed']:NULL;
    $idBilling = isset ($_GET['idBilling'])?$_GET['idBilling']:NULL;
    $asuransi=isset($_POST['asuransi'])?$_POST['asuransi']:'';
    $bayar=isset($_POST['bayar'])?$_POST['bayar']:'';
    //show_array($info);
   
	
   foreach($info as $row){
	 for($i = 0; $i <= 25; $i++)
	{
        if (empty($row[$i]))
		{
            $row[$i] = "NULL";
        }
    }
    $sql = "select db.id,db.waktu,time(db.waktu) as jam from detail_billing db 
	join billing b on db.id_billing = b.id 
	join tarif t on db.id_tarif = t.id 
	join layanan l on t.id_layanan = l.id
    where l.jenis = 'Rawat Inap' and b.status_pembayaran = '0' and b.id_pasien = $row[id_pasien]  and b.id=(select max(id) from billing where id_pasien = $row[id_pasien]) and db.id=(select max(id) from detail_billing where id_billing = b.id) order by waktu desc limit 0,1";
    $rows = _select_unique_result($sql);
    $sql1 = "update bed set status = 'Kosong' where id = '$row[idBed]'";
        _update($sql1);
     
	 
	    $sql = "insert into kunjungan (no_antrian,waktu,id_pasien,no_kunjungan_pasien,id_layanan,id_penduduk_dpjp,id_penduduk_penanggungjawab,id_penduduk_pengantar,id_rujukan,rencana_cara_bayar,id_bed,status)
                 values ($row[no_antrian],now(),$row[id_pasien],$row[no_kunjungan_pasien],$row[9],$row[10],$row[11],$row[12],$row[13],'$row[paying]',$row[15],'Keluar')";
        _insert($sql);
        $id = _last_id();
		
}
$masuk=pecahwaktu($rows['waktu']);
$keluar=pecahwaktu(date("Y-m-d"));
$selisih=$keluar-$masuk;
$saiki=date("h:i:s");
$jam=$rows['jam'];
if ($selisih == 0){
$frekuensi=1;
}
else if($selisih=='1'){
if($saiki>$jam){
$frekuensi='2';
}
else{
$frekuensi='1';
}
}
else{
if($saiki>$jam){
$frekuensi=$selisih+1;
}
else{
$frekuensi=$selisih;
}
}
  
		 if($frekuensi != '1'){
			 $exekusi=_select_unique_result("select max(id) as id from detail_billing  where id_billing = '$bilnya'");
			 show_array($exekusi);
  $exe = _update("update detail_billing set frekuensi = '$frekuensi ' where id_billing = '$bilnya' and id='$exekusi[id]'");
		 }
		   $tarif_kunjungan=_select_unique_result("select total from tarif where id='$idTarif' order by id desc limit 1");
 $billing=_select_unique_result("select total_tagihan from billing where id='$bilnya' order by id desc limit 1");
 $total=$tarif_kunjungan['total']*$frekuensi+$billing['total_tagihan'];
 _update("update billing set total_tagihan='$total' where id='$bilnya'");

          echo $total;
		  
		  header("location: " . app_base_url('admisi/rawat-inap') . "?msg=5&norm=".$row['id_pasien']."&idKunjungan=".$idKunjungan."&action=preview&asuransi=$asuransi&bayar=$bayar");
       
		
 ?>