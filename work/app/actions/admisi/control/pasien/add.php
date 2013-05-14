<?php
set_time_zone();
$resident       = isset($_POST['idPenduduk'])?$_POST['idPenduduk']:null;
$medicalRecord  = isset($_POST['norm'])?$_POST['norm']:null;
$name           = isset($_POST['nama'])?$_POST['nama']:null;
$address        = isset($_POST['alamatJln'])?$_POST['alamatJln']:null;
$village        = isset($_POST['idKel'])?$_POST['idKel']:null;
$sex            = isset($_POST['kelamin'])?$_POST['kelamin']:null;
$bloodGroup     = isset($_POST['gol'])?$_POST['gol']:null;
$dateOfBirth    = isset($_POST['tglLahir'])?$_POST['tglLahir']:null;
$age            = isset($_POST['umur'])?$_POST['umur']:null;
$marriage       = isset($_POST['idPkw'])?$_POST['idPkw']:null;
$education      = isset($_POST['pendidikan'])?$_POST['pendidikan']:null;
$profesi        = isset($_POST['profesi'])?$_POST['profesi']:null;
$pekerjaan      = isset($_POST['pekerjaan'])?$_POST['pekerjaan']:null;
$religion       = isset($_POST['agama'])?$_POST['agama']:null;
$patientId      = isset($_POST['norm'])?$_POST['norm']:null;
if (isset($_POST['norm'])) {
        $count = countrow("select * from pasien p, penduduk pd where p.id_penduduk = pd.id and p.id = '$medicalRecord'");
        $countz= countrow("select * from penduduk where id = '$resident'");

            if (!empty($age)) {
                $dateOfBirth = tglLahir($age);
            } else {
				$dateOfBirth = date2mysql($dateOfBirth);
            }
			
            $array = array('',$village,$marriage,$education,$profesi,$religion,$pekerjaan); 
            for($i = 0; $i < count($array); $i++) {
                if (empty($array[$i]) || $array[$i]=='') {
                    $array[$i] = "NULL";
                }
            }
        
        if (($count == 0) and ($countz == 0)) {
            
            _insert("insert into penduduk values ('','','$name','$sex','$bloodGroup','$dateOfBirth','',null,'')");
            $residentId = mysql_insert_id();
            _insert("insert into pasien values ('$patientId','$residentId')");
            
            $ok = _insert("insert into dinamis_penduduk
                (id,tanggal,id_penduduk,alamat_jalan,no_telp,id_kelurahan,status_pernikahan,id_pendidikan_terakhir,id_profesi,id_agama,akhir,id_pekerjaan)
                values
                ('',now(),'$residentId','$address','',{$array[1]},'{$array[2]}',{$array[3]},{$array[4]},{$array[5]},'1',{$array[6]})");
        }

        if (($count == 0) and ($countz >= 1)) {
            
            _insert("insert into pasien values ('$patientId','$resident')");
            _update("update penduduk set jenis_kelamin = '$sex', gol_darah = '$bloodGroup', tanggal_lahir = '$dateOfBirth' where id = '$resident'");
            $ok = _update("update dinamis_penduduk set alamat_jalan = '$address', id_kelurahan = $array[1], status_pernikahan = '$array[2]', id_pendidikan_terakhir = $array[3], id_profesi = $array[4], id_agama = $array[5],id_pekerjaan=$array[6] where id_penduduk = '$resident' and akhir = '1'");
            
        }
        if (($count > 0) and ($countz == 0)) {
            _insert("insert into penduduk values ('','','$name','$sex','$bloodGroup','$dateOfBirth','',null,'')");
            $residentId = mysql_insert_id();
            _insert("insert into pasien values ('$patientId','$residentId')");
            $ok = _insert("insert into dinamis_penduduk
                (id,tanggal,id_penduduk,alamat_jalan,no_telp,id_kelurahan,status_pernikahan,id_pendidikan_terakhir,id_profesi,id_agama,akhir,id_pekerjaan)
                values
                ('',now(),'$residentId','$address','',{$array[1]},'{$array[2]}',{$array[3]},{$array[4]},{$array[5]},'1',{$array[6]})");
        }
	//insert kunjungan
        _insert("insert into kunjungan 
            (id_pasien,no_antrian,waktu,no_kunjungan_pasien,rencana_cara_bayar,id_layanan,id_penduduk_dpjp,id_penduduk_penanggungjawab,id_penduduk_pengantar,id_rujukan,id_bed) 
            VALUES 
            ('$patientId',0,now(),$_POST[no_kunjungan],'Bayar Sendiri',NULL,NULL,NULL,NULL,NULL,NULL)");
        echo "tes $ok";
	if ($ok) {
        header("location:".app_base_url('/admisi/opname-pasien')."?msg=1");
	}
    
}
?>
