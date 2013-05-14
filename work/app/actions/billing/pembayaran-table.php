<?php
require_once 'app/lib/common/master-data.php';
 require_once 'app/lib/common/functions.php';
 require_once 'app/lib/common/master-inventory.php';
if(isset ($_GET['id_pasien'])){
    $id_pasien=$_GET['id_pasien'];
}else{
    $id_pasien=null;
}

if(isset ($_GET['id_penjualan'])){
    $id_penjualan=$_GET['id_penjualan'];
}else{
    $id_penjualan=null;
}

$detail = cari_pembayaran_muat_data2($id_pasien,$id_penjualan);
//show_array($detail);
?>
<script type="text/javascript">
  function hitungTotal(){
      var total = currencyToNumber($("#total").html());
      var bayar = currencyToNumber($("#bayar").val());
      $('#bayar1').val(bayar);
      if(bayar > total){
           var kembali = bayar - total;
           $("#kembali2").val(kembali);
           $("#kembali1").html(numberToCurrency(kembali));
           $("#sisaTagihan1").html('-');
           $("#sisaTagihan2").val('');
      }else if(total > bayar){
           var sisaTagihan = total - bayar;
           $("#sisaTagihan1").html(numberToCurrency(sisaTagihan));
           $("#sisaTagihan2").val(sisaTagihan);
           $("#kembali2").val('');
           $("#kembali1").html('-');
      }else{
           $("#kembali2").val('');
           $("#kembali1").html('-');
           $("#sisaTagihan1").html('-');
           $("#sisaTagihan2").val('');
      }
      
  }
   $('#bayar').keyup(function() {	
		         $('#save').removeAttr('disabled','disabled');							   
			 });	 
</script>
  <div class="data-list tabelflexibel">
<table class="tabel" cellpadding="0" cellspacing="0" style="width: 100%">
    <tr>
        <th>No</th>
        <th>Nama Layanan/Packing Barang</th>
        <th>Jenis</th>     
        <th>Frekuensi</th> 
          <th>Harga</th>         
        <th>Subtotal (Rp.)</th>       
    </tr>
    <?
$totalAll = 0;
$no = 0;
$total_tagihan_pasien=0;
$total_tagihan_penjualan=0;
$total_tagihan_billing=0;
$pelayanan=0;	
$frekpelayanan=0;
$biaya_apt=0;	
				
      if(!empty($detail['tabel'])){
          foreach($detail['tabel'] as $rows){
              foreach($rows as $row){
              if(!empty($row['id_billing'])||!empty($row['id_penjualan'])){
              $no++;
              if(!empty($row['id_billing'])){
				  $kls=$row['kelas'];
				  if($kls=='Tanpa Kelas'){
					  $kelas='';
				  }
				  else{
					  $kelas=$row['kelas'];
				  }
                  $id_transaksi=$row['id_billing'];
				   $item=$row['layanan']." ".$kelas;
				   $harga=$row['harga'];
				   $frekuensi=$row['frekuensi'];
                   $transaksi='Jasa';
                   $total_tagihan=$harga*$frekuensi;
				   $coba_total=0;
				   $coba_total=$coba_total+($harga*$frekuensi);
				   $total_tagihan_pasien=0;	?>
                   <tr>
        <td><?=$no?></td>
        <td><?=$item?></td>
        <td><?=$transaksi?></td>
        <td><?=$frekuensi?></td>
        <td align="right"><?=rupiah($harga)?></td>
        <td align="right"><?=rupiah($total_tagihan)?></td>        
    </tr>  
				   <?	 
              }else{
                   $id_transaksi=$row['id_penjualan'];
                   $nota_penjualan = nota_penjualan_muat_data($id_transaksi,null,null);
	         // show_array($nota_penjualan);     
foreach($nota_penjualan['list'] as $key => $rowz):
$total_tagihan_penjualan=$rowz['total_tagihan'];
//show_array($nota_penjualan);
$biaya_apt = isset($rowz['biaya_apoteker'])?$rowz['biaya_apoteker']:0;
$satuan=administrasi_apoteker_muat_data(null);
$pelayanan=$biaya_apt;
$hargapelayanan='0';
if(!empty($pelayanan)){
$frekpelayanan=$pelayanan/$satuan['0']['nilai'];
$hargapelayanan=$biaya_apt/$frekpelayanan;
}
$biaya_apt;
$total_tagihan_pasien= $total_tagihan_pasien+$rowz['total_tagihan'];
$item=nama_packing_barang(array($rowz['generik'],$rowz['nama_obat'],$rowz['kekuatan'],$rowz['sediaan'],$rowz['nilai_konversi'],$rowz['satuan_terkecil'],$rowz['pabrik']));
$transaksi='Penjualan';
$harga=$rowz['harga'];
$frekuensi=$rowz['jumlah_penjualan'];
$total_tagihan= $harga*$frekuensi;
$diskon=$rowz['diskon'];
$total_embalase=0;
$embalase=0;
$frekembalase=0;
if($rowz['sub_kategori_barang']=='Embalase'){
 $total_embalase=$total_embalase+($rowz['hna']*$rowz['jumlah_penjualan']);
 $total_tagihan= 0;
}
$embalase=$embalase+$total_embalase;
if(!empty($embalase)){
$frekembalase=$embalase/$total_embalase;
}?>
<tr>
        <td><?=$no?></td>
        <td><?=$item?></td>
        <td><?=$transaksi?></td>
        <td><?=$frekuensi?></td>
        <td align="right"><?=rupiah($harga)?></td>
        <td align="right"><?=rupiah($total_tagihan)?></td>        
    </tr>  
<?
            
endforeach;

              }
			  
  $billing = informasi_billing_muat_data($id_pasien);
//show_array($htt);
$total_tagihan_billing=0;
 foreach ($billing as $num => $row):
            $total_tagihan_billing= $row['subtotal'] + $total_tagihan_billing;
	 endforeach;	   

		$totalAll= $total_tagihan_billing+$total_tagihan_penjualan; 

			
				  }
              }            
          }
      }
	  $html='';
	   if(!empty($row['id_penjualan'])){
		   if($frekpelayanan!='0'){
	  ?>
    	 <tr>
        <td><?=$no+1?></td>
        <td>Jasa Pelayanan</td>
        <td>Penjualan</td>
        <td><?=$frekpelayanan?></td>
        <td align="right"><?=$hargapelayanan?></td>
        <td align="right"><?=rupiah($pelayanan)?></td>        
    </tr>  
 <?
		   }
		    if($frekembalase!='0'){
 ?>
    
    <tr>
        <td><?=$no+2?></td>
        <td>Jasa Sarana</td>
        <td>Penjualan</td>
        <td><?=$frekembalase?></td>
        <td align="right"><?=$total_embalase?></td>
        <td align="right"><?=rupiah($total_embalase)?></td>        
    </tr>  
    <? 
			}
	$html="<tr><td>Diskon Penjualan</td><td>:</td><td align='right'><b>".rupiah($diskon)."</b><input type='hidden' id='diskon' value='".$diskon."' name='diskon'></td>
        </tr>";
	}
	 $tagihan_sebelumnya=0;
      $bayar_sebelumnya=0;
      $kembalian_sebelumnya=0;
      $sisa_tagihan_sebelumnya=0;
      if(isset($detail['pembayaran'])){
     if(!empty ($detail['pembayaran'])){
              foreach($detail['pembayaran'] as $row){
                  $tagihan_sebelumnya=$row['jumlah_tagihan'];
                  $bayar_sebelumnya=$row['jumlah_bayar'];
                  $kembalian_sebelumnya=$row['jumlah_kembalian'];
                  $sisa_tagihan_sebelumnya=$row['jumlah_sisa_tagihan'];
              }
          }
      }
    ?>
</table>
</div>
<span style="position: relative;float: right;padding-top: 10px;width: 100%">
    <table style="float:right">
  <?
  echo $html;
 if(!empty($item)){
  ?>
        <tr>
            <td>Total Tagihan</td><td>:</td><td align="right"><b><?= rupiah($totalAll)?></b><input type="hidden" id="totalAll" value="<?=$totalAll ?>" name="totalAll"></td>
        </tr>
        <tr>
            <td>Total Sisa Tagihan Sebelumnya</td><td>:</td><td id="sisaTagihanSebelum" align="right" style="font-weight:bold"><?=rupiah($sisa_tagihan_sebelumnya)?></td>
        </tr>
        <tr>
            <td>Total</td><td>:</td><td id="total" align="right" style="font-weight:bold"><?=rupiah($sisa_tagihan_sebelumnya+$totalAll)?></td>
        </tr>
        <tr>
            <td>Bayar</td><td>:</td><td><input type="text" onkeyup='formatNumber(this);hitungTotal()' class="auto right" name="bayar" id="bayar" onBlur="hitungTotal()" <?//if($bayar == 0) echo "disabled=disabled";?>>
                <input type="hidden" id="bayar1"></td>
        </tr>
        <tr>
            <td>Kembalian</td><td>:</td><td id="kembali1" style="font-weight:bold" align="right"></td>
        </tr>
        <tr>
            <td>Total Sisa Tagihan</td><td>:</td><td id="sisaTagihan1" align="right" style="font-weight:bold"></td>
        </tr>
    </table>
    <? } ?>
    <input type="hidden" id="kembali2" name="kembali">
    <input type="hidden" id="sisaTagihan2" name="sisaTagihan">
</span>    
<?php
exit();
?>