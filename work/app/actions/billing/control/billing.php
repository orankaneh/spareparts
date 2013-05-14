<?php
set_time_zone();
//show_array($_POST);
if(isset ($_POST['save'])){
    $user = User::$id_user;
    $noRm = $_POST['noRm'];
    $bayar = $_POST['bayar'];
    $idBilling = $_POST['noBilling'];
    $idKunjungan = $_POST['idKunjungan'];
    $total_tagihan=$_POST['total_tagihan'];
    $sql="UPDATE billing SET total_tagihan='$total_tagihan' WHERE id='$idBilling'";
    $i=0;
    if(_update($sql)){
        if(isset ($_POST['billing'])){
            $detail = $_POST['billing'];
            foreach ($detail as $key => $row){
                $nakes1 = isset($row['nakes1'])&&$row['nakes1']!=''?$row['nakes1']:'NULL';
                $nakes2 = isset($row['nakes2'])&&$row['nakes2']!=''?$row['nakes2']:'NULL';
                $nakes3 = isset($row['nakes3'])&&$row['nakes3']!=''?$row['nakes3']:'NULL';
                if(!empty($row['tarif']) && $row['tarif']!='') {
                    $tarif = _select_unique_result("select jasa_sarana,bhp,total_utama,total,total_pendamping,total_pendukung,persen_profit from tarif where id='$row[tarif]'");
                    if(isset($tarif)){
                        $query = "insert into detail_billing 
                        (id_billing,id_tarif,waktu,id_penduduk_nakes1,id_penduduk_nakes2,id_penduduk_nakes3,frekuensi) values
                                  ('$idBilling','$row[tarif]',now(),$nakes1,$nakes2,$nakes3,'$row[frekuensi]')";
                        $exe = _insert($query);
                        if(isset($exe)){                            
                            $i++;
                        }
                    }           
                }
            }
            if($i==count($detail)){
                echo json_encode(array('status'=>1));
            }else{
                echo json_encode(array('status'=>0));
            }
        }else{
            echo json_encode(array('status'=>0));
        }        
    }else{
        echo json_encode(array('status'=>0));
    }
}

exit();
?>