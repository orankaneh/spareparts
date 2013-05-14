<?php

    if (isset($_POST['kitir'])) {
        
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

        $byy=isset($_POST['biaya_apt'])?currencyToNumber($_POST['biaya_apt']):NULL;
        if ($byy==''||$byy==NULL) {

            //header('location:'.  app_base_url('inventory/penjualan').'?msr=3');
            die(json_encode($sukses));
        }
        else {
            $sql = _insert("insert into temp_penjualan values ('',now(),{$array[1]},{$dokter},'$_POST[jenis]','".currencyToNumber($_POST['diskon'])."','".currencyToNumber($_POST['total_tagihan'])."','".$_POST['catatan']."')");
            //echo $sql;
        }
        $id_penjualan = _last_id();
        $new_resep = _select_unique_result("select max(no_resep+1) as new from temp_detail_resep");
            if ($new_resep['new'] == NULL) {
                $no_reseps = 1;
            } else {
                $no_reseps = $new_resep['new'];
            }
        for ($i = 1; $i <= $_POST['jmldata']; $i++) {
            $data = isset($_POST['iddatabarang'.$i])?$_POST['iddatabarang'.$i]:NULL;
            $jmlh = isset($_POST['jmlh'.$i])?$_POST['jmlh'.$i]:NULL;
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
                
            if (!empty($idpacking)) {
                $persentase=_select_unique_result("(select margin as nilai_persentase from kelas where id = 1)");
                $hna=_select_unique_result("select hna from stok_unit where id_packing_barang = '$idpacking' and batch='$batch' order by waktu desc limit 0,1");                
                _insert("insert into temp_detail_penjualan_retur (id_temp_penjualan, id_packing_barang, batch, jumlah_penjualan,hna,margin) values ('$id_penjualan','$idpacking','$batch',$tebus','$hna[hna]]','$persentase[nilai_persentase]')");
                $id_detail_penjualan_retur = _last_id();
                
                if ($_POST['jenis'] == 'Resep') {
                            
                            $persentase=_select_unique_result("(select margin as nilai_persentase from kelas where id = '$_POST[kelas]')");
                            
                            $sql="insert into temp_detail_resep (no_resep, no_r, jenis_r, kekuatan_r_racik, jumlah_r_resep, jumlah_r_tebus,jumlah_pakai, id_aturan_pakai,
                            id_temp_detail_penjualan_retur,biaya_apoteker)
                            values
                            ('$no_reseps','$noresep','$jenis_r','$dosisracik','$jmlh','$tebus','$jmlpakai',{$aturpakai},'$id_detail_penjualan_retur','$byy')";
                            _insert($sql);
                }
                
                $sukses=true;
			
            }
        }
        if ($sukses) {
            $hasil=array();
            $hasil['id']=$id_penjualan;
            $hasil['kelas']=isset ($_POST['kelas'])?$_POST['kelas']:null;
            die(json_encode($hasil));
                //$code = base64_encode(base64_encode($id_penjualan));
                
                //header('location:'.  app_base_url('inventory/penjualan-info').'?msg=1&code='.$code.'&kelas='.$_POST[kelas].'');
        }else{
            die(json_encode($sukses));
        }
        
    }
 

?>
