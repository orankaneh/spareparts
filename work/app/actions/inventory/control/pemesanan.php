<?php
set_time_zone();
if(isset($_POST['save'])){
        $sql="INSERT INTO pemesanan
            (waktu,id_instansi_relasi_suplier,jenis_sp,id_pegawai)
        VALUES
            ('".date('Y-m-d H:i:s')."','$_POST[idsuplier]','$_POST[jenis]','".User::$id_user."')";
        
        _insert($sql);
        $idPemesanan= mysql_insert_id();
        //simpan detail
        $barangs=$_POST['barang'];
        foreach ($barangs as $id => $barang){
            if($barang['idbarang']!=NULL){
                _insert("insert into detail_pemesanan_faktur (id_pemesanan,id_packing_barang,jumlah_pesan)
                    VALUES
                        ('$idPemesanan','$barang[idbarang]','$barang[jumlah]')");
            }
        }
        if($_POST['jenis'] == "Umum"){
            echo "
            <script>
              win = window.open('../print/pemesanan?id=$idPemesanan','mywindow','location=1,status=1,scrollbars=1,width=800px');
            </script>
            ";
        }
        if(isset($_POST['save'])){
            echo "<script>window.location='../pemesanan-info?msg=4&id=".$idPemesanan."'</script>";
        }
}
?>
