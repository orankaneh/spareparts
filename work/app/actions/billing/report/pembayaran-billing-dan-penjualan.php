<style>
body {margin: 0 30px; padding: 0; font:12px "arial","Consolas","Fixedsys",arial !important;}
td { font-size: 12px !important}
.tabel-judul {border-top: 1px dashed #000; border-bottom: 1px dashed #000; width: 600px; margin: 20px 0}
.head-cetak-instansi {font-size: 22px; font-family: "Arial Narrow",tahoma; font-weight: 800}
.tabel-label td {border-bottom: 1px dashed #000; padding: 5px 0 10px 0}
</style>

<?php
  set_time_zone();
  require_once 'app/lib/common/master-data.php';
   require_once 'app/lib/common/functions.php';
 require_once 'app/lib/common/master-inventory.php';
  $billing = pembayaran_billing_muat_data($_GET['id_pembayaran']);
     $penjualan = pembayaran_billing_penjualan_muat_data($_GET['id_pembayaran']);
	
  $query = "select pb.id,pd.id,ps.id as norm,
        pd.nama as pasien,dp.alamat_jalan,kel.nama as kelurahan,kec.nama as kecamatan,kab.nama as kabupaten,pro.nama as provinsi 
        from pembayaran pb        
        left join penduduk pd on pd.id=pb.id_penduduk_customer
        left join pasien ps on ps.id_penduduk = pd.id
        left join dinamis_penduduk dp on dp.id_penduduk = pd.id
        left join kelurahan kel on dp.id_kelurahan = kel.id
        left join kecamatan kec on kel.id_kecamatan = kec.id
        left join kabupaten kab on kec.id_kabupaten = kab.id
        left join provinsi pro on kab.id_provinsi = pro.id where pb.id='$_GET[id_pembayaran]'";
  
  $data = _select_unique_result($query);
 
  $nota = $_GET['id_pembayaran'];
?>
<html>
    <head>
        <title>Nota Pembayaran Billing</title>
         <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/base.css')?>" />
         <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/style.css')?>" />
         <script language='JavaScript'>
            function cetak() {  		
                    SCETAK.innerHTML = '';
                    window.print();
                    if (confirm('Apakah menu print ini akan ditutup?')) {
                        window.close();
                    }
                    SCETAK.innerHTML = '<br /><input onClick=\'cetak()\' type=\'submit\' name=\'Submit\' value=\'Cetak\' class=\'tombol\'>';
            }
         </script>
    </head>
    <body>
        <?require_once 'app/actions/admisi/lembar-header.php';?>  
        <table class="tabel-judul">
            <tr>
              <td align="center">NOTA PEMBAYARAN PASIEN</td>
            </tr>
        </table>
        <table width=600 border=0>
          <tr>
               <td width="108">No. Nota</td>
               <td width="154">: <?= $nota?></td>
               <td width="23">&nbsp;</td>
               <td width="141">No. RM</td>
               <td width>: <?= $data['norm']?></td>
          </tr>
            <tr>
             <td>Tanggal</td>
             <td>: <?= date("d/m/Y");?></td>
           
               <td width="23">&nbsp;</td>
               <td width="141">Nama Pasien/Pembeli</td>
               <td width>: <?= $data['pasien']?></td>
            </tr>
            <tr>
                  <td width="108">&nbsp;</td>
               <td width="150">&nbsp;</td><td>&nbsp;</td><td>Alamat</td><td>: 
               <?= $data['alamat_jalan']?>
              </td>
            </tr>
             <tr>
                  <td width="108">&nbsp;</td>
               <td width="150">&nbsp;</td><td>&nbsp;</td><td>Kelurahan/Kecamatan</td><td>: 
               <?= $data['kelurahan']."/".$data['kecamatan']?>
              </td>
            </tr>
             <tr>
                <td colspan="3" height=20px>&nbsp;</td><td valign=bottom>&nbsp;</td><td valign="bottom">&nbsp;&nbsp;<?= $data['kabupaten']." - ".$data['provinsi']?></td>
            </tr>
     <tr>
                <td colspan="3" height=20px>&nbsp;</td><td valign=bottom>Paraf</td><td valign="bottom">&nbsp;</td>
            </tr>
           
              <tr>
                <td colspan="3" height=50px>&nbsp;</td><td valign=bottom>....................</td><td valign="bottom">&nbsp;</td>
            </tr>
        </table>
        <table class="tabel-judul">
            <tr class="tabel-label">
             <td width="17">No.</td>
                <td width="239">Nama Layanan/Packing Barang</td>
                <td width="37" align="center">Kelas</td>
                <td width="56" align="center">Jenis</td>
                   <td width="21" align="center">QTY</td>
                      <td width="41">Harga</td>
                <td width="157" align="right">Jumlah Tagihan (Rp.)</td>
            </tr>
            <?
			$no = 1;
			$show=0;
			$pelayanan=0;
            foreach ($billing as $data){	
				  if(!empty($data['id_penjualan_billing'])){
				  $kategori_tarif = kategori_tarif();
				  //show_array($kategori_tarif);
                  foreach ($kategori_tarif as $num=> $kat){
				  $kategori=$kat['nama'];
					
		          $detail_billing = detail_pembayaran_billing2($data['id_penjualan_billing'],$kat['id']);
				 
				  if($detail_billing['total']!=0){
				 ?>
                    <tr>
                    <td><?= $no++?></td>
                  <td colspan="5"><?=$kategori?></td>
                  </tr>
                 <?
                  foreach ($detail_billing['list'] as $rowz){
			      $item=$rowz['layanan'];
				  $harga=$rowz['harga'];
				  $frekuensi=$rowz['frekuensi'];
                  $kls=$rowz['kelas'];
				  if ($kls=='Tanpa Kelas'){
				  $transaksi='-';
				  }
				  else{
				   $transaksi=$rowz['kelas'];
				  }
				  $jenis='jasa';
                  $total_tagihan=$harga*$frekuensi;
				  ?>
                  <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;&nbsp;<?= $item?></td>
                  <td align="center"><?= $transaksi?></td>
                    <td align="center"><?= $jenis?></td>
                    <td align="center"><?= $frekuensi?></td>
                  <td align="right"><?= rupiah($harga)?></td>
                   <td align="right"><?= rupiah($total_tagihan)?></td>
              </tr>
                 <? 
				  }
				 }
				} 
			  }
			}?>
			  
<? foreach ($penjualan as $data){	
//$penjualan = nota_penjualan_muat_data($_GET['id_pembayaran'],null,null);
$detail_penjualan = nota_penjualan_muat_data($data['id_penjualan_billing'], NULL, NULL);
//show_array($detail_penjualan);
if($detail_penjualan['total']!=0){
	?>
     <tr>
                    <td><?= $no++?></td>
                  <td colspan="5">Obat</td>
                  </tr>
    <?
  }
foreach ($detail_penjualan['list'] as $rowz){
$show=1;
$item=nama_packing_barang(array($rowz['generik'],$rowz['nama_obat'],$rowz['kekuatan'],$rowz['sediaan'],$rowz['nilai_konversi'],$rowz['satuan_terkecil'],$rowz['pabrik']));
$transaksi='-';
$jenis='Penjualan';
$harga=$rowz['harga'];
$frekuensi=$rowz['jumlah_penjualan'];
$total_tagihan= $harga*$frekuensi;	
$frekpelayanan='0';
$biaya_apt = isset($rowz['biaya_apoteker'])?$rowz['biaya_apoteker']:0;
$pelayanan=$biaya_apt/$detail_penjualan['total'];
if(!empty($detail_penjualan['total'])){
$frekpelayanan=$detail_penjualan['total'];
}
$diskon=$rowz['diskon'];
$total_embalase=0;
$embalase=0;
$frekembalase='0';
if($rowz['sub_kategori_barang']=='Embalase'){
$total_embalase=$total_embalase+($rowz['hna']*$rowz['jumlah_penjualan']);
 $total_tagihan= 0;
  }
$embalase=$embalase+$total_embalase;
if(!empty($embalase)){
$frekembalase=$embalase/$total_embalase;
}
				  ?>
                  <tr>
                  <td>&nbsp;</td>
                  <td width="50%" align="left">&nbsp;&nbsp;<?= $item?></td>
                  <td align="center"><?= $transaksi?></td>
                  <td align="center"><?= $jenis?></td>
                  <td align="center"><?= $frekuensi?></td>
                  <td align="right"><?= rupiah($harga)?></td>
                    <td align="right"><?= rupiah($total_tagihan)?></td>
              </tr>
                 <? 
				} 
				 }
if (!empty($biaya_apt)){				 
				 ?>
                  <tr>
        <td><?=$no?></td>
        <td>Jasa Pelayanan</td>
        <td align="center">-</td>
           <td align="center">Penjualan</td>
        <td align="center"><?=$frekpelayanan?></td>
        
        <td align="right"><?=rupiah($pelayanan)?></td>
        <td align="right"><?=rupiah($biaya_apt)?></td>        
    </tr> 
    <?
	
    }
  if (!empty($frekembalase)){	  
    ?> 
    <tr>
        <td><?=$no+1?></td>
        <td>Jasa Sarana</td>
        <td align="center">-</td>
        <td align="center">Penjualan</td>
        <td align="center"><?=$frekembalase?></td>
        <td align="right"><?=rupiah($total_embalase)?></td>
        <td align="right"><?=rupiah($total_embalase)?></td>        
    </tr>  
                 <? 
}
              $totalAll = 0;
              $sisa_tagihan=0;
              $bayar=0;
              $no = 0;
              
         
            		
			  $detail= pembayaran_detail_billing_penjualan_muat_data($_GET['id_pembayaran']);
			  //show_array($detail);
			  foreach ($detail as $row){
                $totalAll=$row['jumlah_tagihan_total'];
                $bayar=$row['jumlah_bayar'];
                $kembalian=$row['jumlah_kembalian'];
                $sisa_tagihan=$row['jumlah_sisa_tagihan'];
                  
              }
        ?>
    </table>
                <table width=600>
              <tr>
                  <td colspan="5" align="right">Total Tagihan</td><td align="right" width="133"><?= rupiah($totalAll)?></td>
              </tr>
              <tr>
                  <td colspan="5" align="right">Total Sisa Tagihan Sebelumnya</td><td align="right" width="133"><?= rupiah($_GET['totaltagihansebelum'])?></td>
              </tr>
              <tr>
                  <td colspan="5" align="right">Total</td><td align="right" width="133"><?= rupiah($_GET['totaltagihansebelum']+$totalAll)?></td>
              </tr>
              <tr>
                  <td colspan="5" align="right">Bayar</td><td align="right"><?= rupiah($bayar)?></td>
              </tr>
              <tr>
                  <td colspan="5" align="right">Kembali</td><td align="right"><?=rupiah($kembalian)?></td>
              </tr>
                 <tr>
                     <td colspan="5" align="right">Total Sisa Tagihan:</td><td align="right"><?=  rupiah($sisa_tagihan)?></td>
              </tr>
        </table>
        <center>
          <p><span id='SCETAK'><input type='button' class='tombol' value='Cetak' onClick='cetak()'></span></p>
        </center> 
    </body>
</html>
<?
exit();
?>