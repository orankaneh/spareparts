<?php
require_once 'app/lib/common/functions.php';
 set_time_zone();
if(isset ($_POST['submit']))
{
    $idKunjungan = $_POST['idKunjungan'];
    $asuransi=isset($_POST['asuransi'])?$_POST['asuransi']:'';
    $bayar=isset($_POST['bayar'])?$_POST['bayar']:'';
    $bed = isset($_POST['idBed'])?$_POST['idBed']:NULL;
    $layanan = isset ($_POST['idLayanan'])?$_POST['idLayanan']:NULL;
    $idBilling = isset ($_POST['billing'])?$_POST['billing']:NULL;
    $idTarif = isset ($_POST['idTarif'])?$_POST['idTarif']:NULL;
    $idDokter = isset($_POST['idDokter']) ? $_POST['idDokter'] : NULL;
    $sql = "select * from kunjungan where id='$idKunjungan'";
    $data = _select_unique_result($sql);
    $sql1 = "select id_bed from kunjungan where no_kunjungan_pasien = '$data[no_kunjungan_pasien]' and id='$idKunjungan'";
    $data1 = _select_arr($sql1);
	  
    foreach ($data1 as $row1){
        $sql1 = "update bed set status = 'Kosong' where id = '$row1[id_bed]'";
        _update($sql1);
    }        
    $array = array('', $data['no_antrian'], $data['id_pasien'], $data['no_kunjungan_pasien'],
                    $idDokter, $data['id_penduduk_penanggungjawab'], $data['id_penduduk_pengantar'],
                    $data['id_rujukan'], $data['rencana_cara_bayar'], $data['id_bed']);
    for($i = 0; $i <= 9; $i++)
	{
        if (empty($array[$i]))
		{
            $array[$i] = "NULL";
        }
    }
    $sql = "select db.id,db.waktu,time(db.waktu) as jam,t.id as idTarip from detail_billing db 
	join billing b on db.id_billing = b.id 
	join tarif t on db.id_tarif = t.id 
	join layanan l on t.id_layanan = l.id
    where l.jenis = 'Rawat Inap' and b.status_pembayaran = '0' and b.id_pasien = $data[id_pasien] and b.id=(select max(id) from billing where id_pasien = $data[id_pasien]) order by waktu desc limit 0,1";
    $rows = _select_unique_result($sql);
    if(countrow($sql) == 0){
        $updateBed = _update("update bed set status = 'Isi' where id='$bed'");
        $sql = "insert into kunjungan (no_antrian,waktu,id_pasien,no_kunjungan_pasien,id_layanan,id_penduduk_dpjp,id_penduduk_penanggungjawab,id_penduduk_pengantar,id_rujukan,rencana_cara_bayar,id_bed,status)
                 values ($array[1],now(),$array[2],$array[3],$layanan,$array[4],$array[5],$array[6],$array[7],'$array[8]',$bed,'Mutasi')";
        _insert($sql);
        $id = _last_id();
 $query = "insert into detail_billing (id_billing,id_tarif,waktu,id_penduduk_nakes1,frekuensi) values 
            ('$idBilling','$idTarif',now(),$array[4],'1')";
        $exe = _insert($query);
        if($exe){
//        // echo "<script>win = window.open('".app_base_url('admisi/print/rawat-inap')."?idKunjungan=$id', 'mywindow', 'location=1, status=1, scrollbars=1, width=800px'); 
 echo "<script>window.location='".app_base_url('admisi/rawat-inap')."?msg=1&norm=$array[2]&idKunjungan=$id&idBilling=$idBilling&idTarif=$idTarif&asuransi=$asuransi&bayar=$bayar'</script>";
        }
    }
	else{
		
          $masuk=pecahwaktu($rows['waktu']);
        $keluar=pecahwaktu(date("Y-m-d"));
        $selisih=$keluar-$masuk;
        $saiki=date("h:i:s");
		$jam=$rows['jam'];
		//show_array($rows);;
        _insert("insert into kunjungan(no_antrian, waktu, id_pasien, no_kunjungan_pasien, id_layanan,id_penduduk_dpjp, id_penduduk_penanggungjawab, id_penduduk_pengantar,id_rujukan, rencana_cara_bayar, id_bed, status)
		values ($array[1], now(), $array[2], $array[3], $layanan, $array[4], $array[5],$idDokter, $array[7], '$array[8]', $bed, 'Mutasi')");
	$id = _last_id();
	$updateBedKosong = _update("UPDATE bed set status = 'Kosong' WHERE id = $data[id_bed]");
	$updateBed = _update("update bed set status = 'Isi' where id='$bed'");
	$tarif = _select_unique_result("select jasa_sarana, bhp, total_utama, total_pendamping, total_pendukung, persen_profit, total
					from tarif where id = '$idTarif'");
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
			 $tarif_kunjungan=_select_unique_result("select total from tarif where id='$rows[idTarip]' order by id desc limit 1");
 $billing=_select_unique_result("select total_tagihan from billing where id='$idBilling' order by id desc limit 1");
 $total=$tarif_kunjungan['total']*$frekuensi+$billing['total_tagihan'];
            _update("update detail_billing set frekuensi = '$frekuensi' where id = '$rows[id]'");
			 _update("update billing set total_tagihan='$total' where id='$idBilling'");
        }
        $query = "insert into detail_billing (id_billing, id_tarif, waktu, id_penduduk_nakes1, frekuensi) 
                  values ('$idBilling', '$idTarif', now(), {$array[4]}, '1')";
	$exe = _insert($query);
        if($exe){
//         echo "<script>win = window.open('".app_base_url('admisi/print/rawat-inap')."?idKunjungan=$id', 'mywindow', 'location=1, status=1, scrollbars=1, width=800px'); </script>";
         echo "<script>window.location='".app_base_url('admisi/rawat-inap')."?msg=1&norm=$array[2]&idKunjungan=$id&idBilling=$idBilling&idTarif=$idTarif&asuransi=$asuransi&bayar=$bayar'</script>";
        }
    }
/*************************************
  * -> Harusnya melakukan sekali insert
  * -> Kalo memang aslinya dua kali insert, mangga di-uncomment.. :)
  *
  _insert("insert into kunjungan (no_antrian,waktu,id_pasien,no_kunjungan_pasien,id_layanan,id_penduduk_dpjp,id_penduduk_penanggungjawab,id_penduduk_pengantar,id_rujukan,rencana_cara_bayar,id_bed)

           values ($array[1],now(),$array[2],$array[3],$layanan,$array[4],$array[5],$idDokter,$array[7],'$array[8]',$bed)")or die(mysql_error());
  $id = _last_id();
  
  
  
  $tarif = _select_unique_result("select jasa_sarana,bhp,total_utama,total_pendamping,total_pendukung,persen_profit,total from tarif where id='$idTarif'");
  
  $query = "insert into detail_billing (id_billing,id_tarif,id_penduduk_nakes,jasa_sarana,bhp,utama,pendamping,pendukung,profit,total_tarif,frekuensi) values 
            ('$idBilling','$idTarif',{$array[4]},$tarif[jasa_sarana],$tarif[bhp],$tarif[total_utama],$tarif[total_pendamping],$tarif[total_pendukung],$tarif[persen_profit],$tarif[total],'1')";
  $exe = _insert($query);
  
  if($exe){
     echo "<script>win = window.open('".app_base_url('admisi/print/rawat-inap')."?idKunjungan=$id', 'mywindow', 'location=1, status=1, scrollbars=1, width=800px'); </script>";
     echo "<script>window.location='".app_base_url('admisi/rawat-inap')."?msg=1&norm=$array[2]&idKunjungan=$id'</script>";
  }
  */
  /*************************************
	_insert("insert into kunjungan(no_antrian, waktu, id_pasien, no_kunjungan_pasien, id_layanan,id_penduduk_dpjp, id_penduduk_penanggungjawab, id_penduduk_pengantar,id_rujukan, rencana_cara_bayar, id_bed)
		values ($array[1], now(), $array[2], $array[3], $layanan, $array[4], $array[5],$idDokter, $array[7], '$array[8]', $bed)");
	$id = _last_id();
	$updateBedKosong = _update("UPDATE bed set status = 'Kosong' WHERE id = $data[id_bed]");
	$updateBed = _update("update bed set status = 'Isi' where id='$bed'");
	$tarif = _select_unique_result("select jasa_sarana, bhp, total_utama, total_pendamping, total_pendukung, persen_profit, total
					from tarif where id = '$idTarif'");
	$cekRawatInap = "select min(db.id) as id, db.waktu from detail_billing db join billing b on (db.id_billing = b.id) 
                        join tarif t on (db.id_tarif = t.id) join layanan l on (t.id_layanan = l.id) where l.jenis = 'Rawat Inap' and db.id > 
                        (select db.id from detail_billing db 
                        join billing b on (db.id_billing = b.id) 
                        join tarif t on (db.id_tarif = t.id)
                        join layanan l on (t.id_layanan = l.id)
                        where l.id in (1,2) and b.id_pasien = '$data[id_pasien]' and b.status_pembayaran = '0')
                        and b.id_pasien = '$data[id_pasien]' 
                        and b.status_pembayaran = '0'";
	$rows = _select_unique_result($cekRawatInap);
	if ($rows['id'] != NULL and $rows['waktu'] != NULL) {
		$exe = _update("update detail_billing set frekuensi = (select datediff(now(),'$rows[waktu]') as selisih) where id = '$rows[id]'");
	}
	
	$query = "insert into detail_billing (id_billing, id_tarif, waktu, id_penduduk_nakes, jasa_sarana,bhp, utama, pendamping, pendukung, profit, total_tarif, frekuensi) 
                  values ('$idBilling', '$idTarif', now(), {$array[4]}, $tarif[jasa_sarana], $tarif[bhp], $tarif[total_utama],$tarif[total_pendamping], $tarif[total_pendukung], $tarif[persen_profit], $tarif[total], '1')";
	$exe = _insert($query);
	if ($exe)
	{
            //echo "<script type=\"text/javascript\">win = window.open('".app_base_url('admisi/print/rawat-inap')."?idKunjungan=$id', 'mywindow', 'location=1, status=1, scrollbars=1, width=800px'); </script>";
            echo "<script type=\"text/javascript\">window.location='".app_base_url('admisi/rawat-inap')."?msg=1&norm=$array[2]&idKunjungan=$id'</script>";
	}
   * 
   */
}
?>
