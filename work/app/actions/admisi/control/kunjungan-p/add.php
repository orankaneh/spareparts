<?php
set_time_zone();
foreach ($_POST as $key=>$value){
    if($value=='')
        $_POST[$key]=NULL;
}
$destination = isset($_POST['layanan']) ? $_POST['layanan'] : null;
$resident = isset($_POST['idPenduduk']) ? $_POST['idPenduduk'] : null;
$medicalRecord = isset($_POST['noRm']) ? $_POST['noRm'] : null;
$name = isset($_POST['nama']) ? $_POST['nama'] : null;
$address = isset($_POST['alamatJln']) ? $_POST['alamatJln'] : null;
$village = isset($_POST['idKel']) ? $_POST['idKel'] : 'NULL';
$kec = isset($_POST['idKec']) ? $_POST['idKec'] : 'NULL';
$kab = isset($_POST['idKab']) ? $_POST['idKab'] : 'NULL';
$sex = isset($_POST['kelamin']) ? $_POST['kelamin'] : null;
$bloodGroup = isset($_POST['gol']) ? $_POST['gol'] : null;
$dateOfBirth = isset($_POST['tglLahir']) ? $_POST['tglLahir'] : null;
$age = isset($_POST['umur']) ? $_POST['umur'] : null;
$marriage = isset($_POST['idPkw']) ? $_POST['idPkw'] : 'NULL';
$education = isset($_POST['pendidikan']) ? $_POST['pendidikan'] : "NULL";
$profesi = isset($_POST['profesi']) ? $_POST['profesi'] : 'NULL';
$pekerjaan = isset($_POST['pekerjaan']) ? $_POST['pekerjaan'] : 'NULL';
$religion = isset($_POST['agama']) ? $_POST['agama'] : 'NULL';
$payWay1 = isset($_POST['bayar1']) ? $_POST['bayar1'] : null;
$insurance = isset($_POST['dynid']) ? $_POST['dynid'] : null;
$insuranceMethod = isset($_POST['dynval']) ? $_POST['dynval'] : null;
$charity = isset($_POST['dynaid']) ? $_POST['dynaid'] : null;
$familyId = isset($_POST['idNmKeluarga']) ? $_POST['idNmKeluarga'] : null;
$familyName = isset($_POST['nmKeluarga']) ? $_POST['nmKeluarga'] : null;
$familyRelation = isset($_POST['hubKeluarga']) ? $_POST['hubKeluarga'] : null;
$familyAddress = isset($_POST['alamatK']) ? $_POST['alamatK'] : null;
$familyPhoneNumb = isset($_POST['ntK']) ? $_POST['ntK'] : null;
$responsibleName = isset($_POST['nmPjw']) ? $_POST['nmPjw'] : null;
$responsibleId = isset($_POST['idNmPjw']) ? $_POST['idNmPjw'] : null;
$responsibleAddr = isset($_POST['alamatPjw']) ? $_POST['alamatPjw'] : null;

$responsiblePhon = isset($_POST['telpPjw']) ? $_POST['telpPjw'] : null;
$guideName = isset($_POST['namaP']) ? $_POST['namaP'] : null;
$guideId = isset($_POST['idNamaP']) ? $_POST['idNamaP'] : null;
$guideAddr = isset($_POST['alamatP']) ? $_POST['alamatP'] : null;
$guidePhoneNumb = isset($_POST['telpP']) ? $_POST['telpP'] : null;
$referenceNumb = isset($_POST['no_rujukan']) ? $_POST['no_rujukan'] : null;
$referenceName = isset($_POST['rujukan']) ? $_POST['rujukan'] : null;
$referenceId = isset($_POST['idRujukan']) ? $_POST['idRujukan'] : null;
$medicalPerson = isset($_POST['nakes']) ? $_POST['nakes'] : null;
$medicalPersonId = isset($_POST['idNakes']) ? $_POST['idNakes'] : null;
$dokter = isset($_POST['idDokter']) ? $_POST['idDokter'] : null;
$bed = isset($_POST['idBed']) ? $_POST['idBed'] : NULL;

if (isset($_POST['save'])) {
	$query_village = mysql_query("select kl.id from kelurahan kl 
		left join kecamatan kc on(kl.id_kecamatan = kc.id)
		left join kabupaten kb on(kc.id_kabupaten = kb.id)
		where kl.kode='".$village."' and kc.kode='".$kec."' and kb.kode='".$kab."' ");
	$id_village = '1';
	echo mysql_num_rows($query_village);
	if(mysql_num_rows($query_village)>0){
		$row_village = mysql_fetch_assoc($query_village);
		$id_village = $row_village['id']; 
	}
    if (empty($medicalRecord) or empty($destination) or empty($name) or empty($address)) {
        //echo "$destination - $name - $sex - $address - $dateOfBirth - $age - $village - $responsibleName";
        header("location:" . app_base_url() . "?layanan=$destination&msr=3");
    } else {

        $count = countrow("select * from pasien p, penduduk pd where p.id_penduduk = pd.id and p.id = '$medicalRecord'");
        $countz = countrow("select * from penduduk where id= '$resident'");
        if (!empty($age)) {
            $dateOfBirth = tglLahir($age);
        } else {
            $dateOfBirth = date2mysql($dateOfBirth);
        }
        if ($pekerjaan == '') {
            $pekerjaan == "NULL";
        }
        $array = array('', $village, $marriage, $education, $profesi, $religion, $pekerjaan);
        for ($i = 0; $i < count($array); $i++) {
            if (empty($array[$i]) || $array[$i]=='' || $array[$i]==null ) {
                $array[$i] = "NULL";
            }
        }
//        show_array($array);

        if (($count == 0) and ($countz == 0)) {

            _insert("insert into penduduk values ('','','$name','$sex','$bloodGroup','$dateOfBirth','',null,'')");
            $residentId = mysql_insert_id();
            _insert("insert into pasien values ('','$residentId')");
            $patientId = mysql_insert_id();
		
            _insert("insert into dinamis_penduduk
                (id,tanggal,id_penduduk,alamat_jalan,no_telp,id_kelurahan,status_pernikahan,id_pendidikan_terakhir,id_profesi,id_agama,akhir,id_pekerjaan)
                values
                ('',now(),'$residentId','$address','','$id_village','{$array[2]}',{$array[3]},{$array[4]},{$array[5]},'1',{$array[6]})");
        }

        if (($count == 0) and ($countz >= 1)) {

            _insert("insert into pasien values ('','$resident')");
            $patientId = mysql_insert_id();
            _update("update dinamis_penduduk set alamat_jalan = '$address', id_kelurahan = '$id_village', status_pernikahan = '$array[2]', id_pendidikan_terakhir = $array[3], id_profesi = $array[4], id_agama = $array[5],id_pekerjaan=$array[6] where id_penduduk = '$resident' and akhir = '1'");
        }
            _update("update penduduk set nama='$name', jenis_kelamin = '$sex', gol_darah = '$bloodGroup', tanggal_lahir = '$dateOfBirth' where id = '$resident'");
        if (($count > 0) and ($countz == 0)) {
            _insert("insert into penduduk values ('','','$name','$sex','$bloodGroup','$dateOfBirth','',null,'')");
            $residentId = mysql_insert_id();
            _insert("insert into pasien values ('','$residentId')");
            $patientId = mysql_insert_id();
            _insert("insert into dinamis_penduduk
                (id,tanggal,id_penduduk,alamat_jalan,no_telp,id_kelurahan,status_pernikahan,id_pendidikan_terakhir,id_profesi,id_agama,akhir,id_pekerjaan)
                values
                ('',now(),'$residentId','$address','','$id_village',{$array[2]},{$array[3]},{$array[4]},{$array[5]},'1',{$array[6]})");
        }
        if (($count > 0) and ($countz > 0)) {
            $patientId = $medicalRecord;
        }
        if (empty($familyId) and !empty($familyName)) {

            _insert("insert into penduduk (nama) values ('$familyName')");
            $familyId = _last_id();
            _insert("insert into dinamis_penduduk (tanggal,id_penduduk,alamat_jalan,no_telp) values (now(),'$familyId','$familyAddress','$familyPhoneNumb')");
        }

        if (empty($responsibleId) and !empty($responsibleName)) {

            _insert("insert into penduduk (nama) values ('$responsibleName')");
            $responsibleId = _last_id();
            _insert("insert into dinamis_penduduk(tanggal,id_penduduk,alamat_jalan,no_telp) values (now(),'$responsibleId','$responsibleAddr','$responsiblePhon')");
        }

        if (empty($guideId) and !empty($guideName)) {
            _insert("insert into penduduk (nama) values ('$guideName')");
            $guideId = mysql_insert_id();
            _insert("insert into dinamis_penduduk(tanggal,id_penduduk,alamat_jalan,no_telp) values (now(),'$guideId','$guideAddr','$guidePhoneNumb')");
        }

        if (empty($medicalPersonId) and !empty($medicalPerson)) {
            _insert("insert into penduduk (nama) values ('$referenceName')");
            $medicalPersonId = mysql_insert_id();
        }

        if (!empty($referenceId)) {
            _insert("insert into rujukan values ('','$referenceNumb',now(),'','$referenceId','$medicalPersonId')");
            $referenceId = mysql_insert_id();
        }

        if (empty($referenceId)) {
            if (!empty($medicalPersonId)) {
                _insert("insert into rujukan (no_surat_rujukan, waktu, id_penduduk_nakes) values ('$referenceNumb',now(),'$medicalPersonId')");
                $referenceId = mysql_insert_id();
            }
        }

        $array = array('', $responsibleId, $guideId, $referenceId);
        for ($i = 0; $i <= 4; $i++) {
            if (empty($array[$i])) {
                $array[$i] = "NULL";
            }
        }
        $sequence = _select_arr("(select max(no_antrian) + 1 as new_squence from kunjungan where id_layanan = '$destination' and waktu like ('" . date("Y-m-d") . "%'))"); //id_layanan = '$destination' and
        foreach ($sequence as $data
            );
        $new_sequence = $data['new_squence'];
        if ($data['new_squence'] == null) {
            $new_sequence = 1;
        }
        _update("update dinamis_penduduk set alamat_jalan = '$address', id_kelurahan = '$id_village', status_pernikahan = '$marriage', id_pendidikan_terakhir = $education, id_profesi = $profesi, id_agama = $religion,id_pekerjaan=$pekerjaan where id_penduduk = '$resident' and akhir = '1'");
//        _update("update dinamis_penduduk set alamat_jalan = '$responsibleAddr', no_telp = '$responsiblePhon' where id_penduduk = '$responsibleId' and akhir = '1'");
        $number = mysql_query("select max(no_kunjungan_pasien) + 1 as no_kunjungan from kunjungan where id_pasien = '$medicalRecord'");
        $data_number = mysql_fetch_array($number);
        if(empty($data_number['no_kunjungan']))
            $hasil=1;
        else
            $hasil = $data_number['no_kunjungan'];

        $success = _insert("insert into kunjungan values ('',$new_sequence,now(),'$patientId',$hasil,'$destination','$dokter',$array[1],$array[2],$array[3],'$_POST[caraPembayaran]','$bed','Masuk','')") or die(mysql_error());
        $admisionId = mysql_insert_id();
        $biling = _insert("insert into billing (waktu,id_pasien,id_pegawai_petugas,status_pembayaran)
values (now(),' $patientId','" . User::$id_user . "','0')");
        $idBilling = _last_id();

        //set bed = isi {sedang dipake}
        _update("update bed set status='Isi' where id='$bed'");
        // pengecekan dia baru daftar atau kunjungan
        $sql_count = countrow("select id from kunjungan where id_pasien = '$medicalRecord'");
        if ($sql_count == 1) {
            //pasien baru
            _insert("insert into detail_billing (id_billing,id_tarif,waktu,frekuensi) values
                ('$idBilling',(select max(id) from tarif where id_layanan=1 and id_kelas=1 and status='Berlaku'),now(),1)");
            $bayar_cetak_kartu=_insert("insert into detail_billing (id_billing,id_tarif,waktu,frekuensi) values
                ('$idBilling',(select max(id) from tarif where id_layanan=2 and id_kelas=1 and status='Berlaku'),now(),1)");
        } else if ($sql_count > 1) {
            //kunjungan pasien lama
            _insert("insert into detail_billing (id_billing,id_tarif,waktu,frekuensi) values
                ('$idBilling',(select max(id) from tarif where id_layanan=1 and id_kelas=1 and status='Berlaku'),now(),1)");
        }

        $jml1 = count($insurance);
        $jml2 = count($charity);
        if (isset($_POST['asuransi']) && count($_POST['asuransi']) > 0) {
            if (($count == 0) and ($countz == 0)) {
                $pendudukID = $residentId;
            }else{
                $pendudukID = $resident;
            }

            foreach ($_POST['asuransi'] as $as) {
                if ($as['no_polis'] != '' || $as['no_polis'] != null) {
                    _insert("insert into asuransi_kepesertaan_kunjungan (id_kunjungan,id_asuransi_produk,no_polis)
                        VALUES
                        ('$admisionId','$as[id_asuransi]','$as[no_polis]')");
                }
            }
        }
        if ($jml1 > 0) {
            foreach ($insurance as $key => $value):
                $payMethod = $_POST['byr'][$key];
                _insert("insert into asuransi values ('','$admisionId','$payMethod','$value')");
            endforeach;
        }

        if ($jml2 > 0) {
            $no = 0;
            foreach ($charity as $value):
                if ($value <> '') {
                    _insert("insert into charity values ('','$admisionId','$value')");
                }
                $no += 1;
            endforeach;
        }
        if ($success) {
            header('location:' . app_base_url('admisi/kunjungan-info-p?id=' . $admisionId));
        }
    }
}
?>
