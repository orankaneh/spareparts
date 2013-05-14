<?php

require_once 'app/lib/common/master-data.php';
//show_array($_POST);
$error=0;
if(isset ($_POST['save'])){
    $noRm=$_POST['noRm']!=''?$_POST['noRm']:'null';
    $id_penduduk=$_POST['id_penduduk']!=''?$_POST['id_penduduk']:'null';
    $id_penjualan=isset($_POST['no_penjualan'])?$_POST['no_penjualan']:null;    
    $total_tagihan=$_POST['totalAll'];
    $kembali=$_POST['kembali']!=''?$_POST['kembali']:0;
    $sisa_tagihan=$_POST['sisaTagihan']!=''?$_POST['sisaTagihan']:0;  
    $bayar=currencyToNumber($_POST['bayar']);    
    
    $id_asuransi_kunjungan=  post_value('id_asuransi_kunjungan');
    $id_asuransi=post_value('id_asuransi');
    $no_polis=post_value('no_polis');
    
    $sql_pembayaran="INSERT INTO pembayaran VALUES (null,now(),'".User::$id_user."',".$id_penduduk.",$total_tagihan,$kembali,$bayar,$sisa_tagihan)";
    $noRm=$noRm!='null'?$noRm:null;    
    
    $sql_asuransi="UPDATE asuransi_kepesertaan_kunjungan SET no_polis='$no_polis', id_asuransi_produk='$id_asuransi' WHERE id='$id_asuransi_kunjungan'";
    
    if($id_asuransi_kunjungan!=null&&$id_asuransi_kunjungan!=''){
        _update($sql_asuransi);
    }
    
    if(_insert($sql_pembayaran)){
        $id_pembayaran=_last_id();
        $detail = cari_pembayaran_muat_data($noRm,$id_penjualan);
        if(!empty($detail['tabel'])){
          foreach($detail['tabel'] as $rows){
              foreach($rows as $row){
                  if(!empty($row['id_billing'])||!empty($row['id_penjualan'])){
                      if(!empty($row['id_billing'])){
                          $id_transaksi=$row['id_billing'];
                          $transaksi='Jasa';
                          $total_tagihan=$row['total_tagihan_billing'];
                      }else{
                          $id_transaksi=$row['id_penjualan'];
                          $transaksi='Penjualan';
                          $total_tagihan=$row['total_tagihan_penjualan'];
                      }                                                        
                      if($bayar>0){
                          if($transaksi=="Penjualan"){
                              $sql_update_penjualan="UPDATE penjualan SET status_pembayaran='1' WHERE id='$id_transaksi'";
                              _update($sql_update_penjualan);
                          }else{
                              $sql_update_billing="UPDATE billing SET status_pembayaran='1' WHERE id='$id_transaksi'";
                              _update($sql_update_billing);
                          }
                      }
                      $sql_detail_pembayaran="INSERT INTO detail_pembayaran VALUES (null,'$id_pembayaran','$transaksi','$id_transaksi','$total_tagihan')";              
                      if(_insert($sql_detail_pembayaran)){

                      }else{
                          $error++;
                      }
                  }
            }
          }
        }
    }else{
        $error++;
    }
    
}else{
    $error++;
}

    if($error<=0){
        die(json_encode(array('status'=>1,'id_pembayaran'=>$id_pembayaran)));
    }else{
        die(json_encode(array('status'=>0)));
    }


?>
