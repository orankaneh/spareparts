<?php
show_array($_POST);

if (isset($_POST['saveresep'])) {
        $sukses=false;
        $penduduk = isset($_POST['idpenduduk'])?$_POST['idpenduduk']:NULL;
        $dokter = isset($_POST['iddokter'])?$_POST['iddokter']:NULL;
        $dokter=$_POST['iddokter']==NULL||$_POST['iddokter']==''?"NULL":$_POST['iddokter'];
        $array = array('', $penduduk);
        for ($i = 0; $i < count($array); $i++) {
            if (empty($array[$i])) {
                $array[$i] = "NULL";
            }
        }

        //$byy = _select_unique_result("select nilai from biaya_apoteker");
        $byy=isset($_POST['biaya_apt'])?currencyToNumber($_POST['biaya_apt']):NULL;
        if ($byy==''||$byy==NULL) {
            header('location:'.  app_base_url('inventory/penjualan').'?msr=3');
        }
        else {
            if(!isset($_POST['tebus_sisa_resep'])){
                $sql = _insert("insert into .penjualan values ('','$_POST[jenis]',now(),{$array[1]},'$_SESSION[id_user]',{$dokter},'".currencyToNumber($_POST['diskon'])."','".currencyToNumber($_POST['total_tagihan'])."','0','".$_POST['catatan']."')");
                $id_penjualan = _last_id();
            }else{
                $id_penjualan=$_POST['noresep'];
            }
        }
        
        /*if ($_POST['jenis'] == 'Resep') {
            $sqlI = "select id from resep where id = '$_POST[noresep]'";
            $rowI= _select_unique_result($sqlI);
            if ($rowI['id'] == '') {
                _insert("insert into resep values ('',now(),'$_POST[idpenduduk]','$_POST[iddokter]')");
                $id = _last_id();
            }
            else {
                $id = $_POST['noresep'];
            }
        }*/
	$cek_id = _select_unique_result("select id from penjualan where id = '$_POST[noresep]'");
        if ($cek_id['id'] == null) {
            $new_resep = _select_unique_result("select max(no_resep+1) as new from detail_resep_penjualan");
                if ($new_resep['new'] == NULL) {
                    $no_reseps = 1;
                } else {
                    $no_reseps = $new_resep['new'];
                }
        } else {
            $no_reseps = $_POST['nopenjualan'];
        }
        for ($i = 1; $i <= $_POST['jmldata']; $i++) {
            $data = isset($_POST['iddatabarang'.$i])?$_POST['iddatabarang'.$i]:NULL;
            if(!isset($_POST['tebus_sisa_resep'])){
                $jmlh = isset($_POST['jmlh'.$i])?$_POST['jmlh'.$i]:NULL;
            }else{
                $jmlh = isset($_POST['jmlh_temp'.$i])?$_POST['jmlh_temp'.$i]:NULL;
            }
            $kekuatan = isset($_POST['kekuatan'.$i])?$_POST['kekuatan'.$i]:NULL;
            $aturpakai = isset($_POST['aturpakai'.$i])?$_POST['aturpakai'.$i]:NULL;
            $idpacking = isset($_POST['idpacking'.$i])?$_POST['idpacking'.$i]:NULL;
			$batch = isset($_POST['batch'.$i])?$_POST['batch'.$i]:NULL;
            $absah = isset($_POST['absah'.$i])?$_POST['absah'.$i]:NULL;
            $noresep = isset($_POST['resep'.$i])?$_POST['resep'.$i]:NULL;            
            $jmlpakai= isset($_POST['jmlpakai'.$i])?$_POST['jmlpakai'.$i]:NULL;
            $tebus = isset($_POST['tebus'.$i])?$_POST['tebus'.$i]:NULL;
            $dosisracik = isset($_POST['dosisracik'.$i])?$_POST['dosisracik'.$i]:NULL;
            $margin = isset($_POST['margin'.$i])?$_POST['margin'.$i]:NULL;
            $kls=isset($_POST['kelas'])?$_POST['kelas']:NULL;
			
                if (empty($aturpakai)) {
                    $aturpakai = "NULL";
                } else {
                    $aturpakai = $aturpakai;
                }

                if (empty($dosisracik)) {
                    $jenis_r = "Tunggal";
                    $dosisracik = NULL;
                }
                else {
                    $jenis_r = "Racikan";
                    $dosisracik = $dosisracik;
                }
                if (empty($kls)) {
                    $klas = "1";
                } else {
                    $klas = $kls;
                }

            if (!empty($idpacking)) {
                $hna=_select_unique_result("select hna from stok_unit where id_packing_barang = '$idpacking' and batch='$batch' order by waktu desc limit 0,1");
                $persentase=_select_unique_result("(select margin as nilai_persentase from kelas where id = '$klas')");
                $sqlA="select sisa, (sisa - $tebus) as newsisa from stok_unit where id_packing_barang = '$idpacking' and batch='$batch' and id_unit = '$_SESSION[id_unit]' order by id desc limit 1";
                $rowA= _select_unique_result($sqlA);


                _insert("insert into detail_penjualan_retur_penjualan (id_penjualan, id_packing_barang, batch, jumlah_penjualan, alasan,hna,margin) values ('$id_penjualan','$idpacking','$batch','$tebus',NULL,'$hna[hna]','$persentase[nilai_persentase]')");
                $id_detail_penjualan_retur_penjualan = _last_id();
                $sqlB = "select * from stok_unit where id_packing_barang = '$idpacking' and batch='$batch' order by id desc limit 1";
                $rowB = _select_unique_result($sqlB);
                _insert("insert into stok_unit values ('',now(),'$idpacking','$batch','$_SESSION[id_unit]','$rowA[sisa]',0,'$tebus','$rowA[newsisa]',8,'$rowB[hpp]','$rowB[hna]','$margin')");
                
                
                
                
                if ($_POST['jenis'] == 'Resep') {
                            $persentase=_select_unique_result("(select margin as nilai_persentase from kelas where id = '$klas')");
                            $sql="insert into detail_resep_penjualan (no_resep, no_r, jenis_r, kekuatan_r_racik, jumlah_r_resep, jumlah_r_tebus,jumlah_pakai, id_aturan_pakai,
                            id_detail_penjualan_retur_penjualan,hna,margin,biaya_apoteker)
                            values
                            ('$no_reseps','$noresep','$jenis_r','$dosisracik','$jmlh','$tebus','$jmlpakai',{$aturpakai},'$id_detail_penjualan_retur_penjualan','$rowB[hna]','$margin','$byy')";
                            _insert($sql);                    
                }
                $sukses=true;
			
            }
        }
        if ($sukses) {
                if(isset ($_POST['temp_penjualan'])){
                    if($_POST['temp_penjualan']!=null||$_POST['temp_penjualan']!=''){
                        $sql_temp="DELETE FROM temp_penjualan WHERE id=".$_POST['temp_penjualan'];
                        _delete($sql_temp);
                    }
                }
                /*if(isset ($_POST['temp_resep'])){
                    if($_POST['temp_resep']!=null||$_POST['temp_resep']!=''){
                        $sql_temp="DELETE FROM temp_resep WHERE id=".$_POST['temp_resep'];
                        _delete($sql_temp);
                    }
                }*/
                $code = base64_encode(base64_encode($id_penjualan));
                
                header('location:'.  app_base_url('inventory/penjualan-info').'?msg=1&code='.$code.'&kelas='.$klas.'&idpenduduk='.$_POST['idpenduduk'].'');
        }
}

?>
