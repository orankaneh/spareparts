<?php
if (isset($_POST['submit'])) {
	$nopenjualan = $_POST['nopenjualan'];
	$jml_bayar	 = strtoint($_POST['bayar']);
        $harus_dibayar=$_POST['harus_dibayar'];
        if($jml_bayar>=$harus_dibayar){
            $sisa=0;
            $jml_bayar=$harus_dibayar;
        }else{
            $sisa=$harus_dibayar-$jml_bayar;
        }
        _insert("insert into pembayaran values ('',now(),'$_SESSION[id_user]','$nopenjualan','$jml_bayar','$sisa')");
        
	
	header("location:".app_base_url('billing/preview-pembayaran-penjualan')."?id=$nopenjualan");
}
?>