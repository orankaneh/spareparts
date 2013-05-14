<?php
require_once 'app/config/db.php';
require_once 'app/lib/common/master-inventory.php';
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';
include_once 'app/actions/admisi/pesan.php';
$code = isset($_GET['code'])?$_GET['code']:null;
$code = base64_decode(base64_decode($code));
$cek = cek_etiket($code);
$cek_jenis = array_value($cek, "jenis");
//$nota_penjualan1 = nota_penjualan_muat_data($code,$_GET['kelas']);
$nota_penjualan = nota_penjualan_muat_data($code,$_GET['kelas'],null);
//show_array($nota_penjualan);
$asuransi = asuransi_penjualan_muat_data2($_GET['idpenduduk']);
//show_array($asuransi);
//$biaya_apt = administrasi_apoteker_muat_data();
$biaya_apt=0;
//show_array($biaya_apt);
$jml_r=0;
?>
<h2 class="judul">Penjualan</h2><?= isset ($pesan)?$pesan:NULL?>
<div style="margin: 5px 0px;">
    <span class="cetak" id="nota">Kitir</span>
    <?php if(isset ($nota_penjualan['list'][0]['jenis'])) { 
            if($nota_penjualan['list'][0]['jenis']=='Resep'){
        ?>
    <span class="cetak" id="salin">Salinan Resep</span>
    <?php
            }
          }
    ?>
</div>
<fieldset><legend>Penjualan</legend>
	<table width=50%>
		<tr><td width="26%">Pembeli:</td><td width="74%"><?= $nota_penjualan['list'][0]['nama_pembeli'] ?></td></tr>
                <tr><td width="26%">Tanggal:</td><td><?= datefmysql($nota_penjualan['list'][0]['waktu']) ?></td></tr>
                 <? if(!empty($asuransi['total'])){?>
                   <tr><td width="26%" colspan="2">Produk Asuransi:</td></tr>
               <?
		
			   
			   foreach($asuransi['list'] as $no => $data){	?>
          <tr>  <td>&nbsp;</td>   <td><?=++$no.'. '.$data['nama_asuransi'] ?></td></tr>
            <? }
			   }?>      
	</table>
</fieldset>
<div class="data-list">
    <fieldset><legend>Detail Penjualan</legend>
	<table style="width: 100%;" class="tabel" cellspacing="0">
            <tr>
                <th style="width: 4%;">R/</th>
                <th style="width: 58%;">Nama Barang</th>
                <th>Jumlah</th>
                <th>Kemasan</th>
                <th>Harga @</th>
                <th>Sub Total</th>
                <th>Cetak Etiket</th>
            </tr>
	<?php
	$total = 0;
        $total_embalase=0;
        $temp=0;
        $jumlah=1;
        $group=array();
        $a=0;
        //show_array($nota_penjualan);
	foreach($nota_penjualan['list'] as $key => $row):
            ?>
		<tr class="<?= ($key%2)?'odd':'even' ?>">
                    <td align="center"><?= isset($row['no_r'])?$row['no_r']:'-'?></td>
                    <td><?= nama_packing_barang(array($row['generik'],$row['nama_obat'],$row['kekuatan'],$row['sediaan'],$row['nilai_konversi'],$row['satuan_terkecil'],$row['pabrik']));?></td>
                    <td><?= $row['jumlah_penjualan'] ?></td>
                    <td><?= $row['satuan_terbesar'] ?></td><td align="right"><?= rupiah($row['harga']) ?></td>
                    <td align="right"><?= rupiah($row['hna']*$row['jumlah_penjualan']) ?></td>
                    <?
                        if($temp!=$row['no_r'] && ($cek_jenis != 'Bebas')){
                            echo "<td id=resep_$row[no_r] align=center><span class=cetak onClick=cetak_etiket($row[no_r])>Cetak</cetak></td>";
                            $group[$a]['nomor']=$row['no_r'];
                            $temp=$row['no_r'];
                            if(isset($group[$a-1]))
                                $group[$a-1]['jumlah']=$jumlah;
                            $a++;
                            $jumlah=1;
                        }else{
						echo "<td align=center>-</td>";
                            $jumlah++;
                        }
                    ?>
		</tr>
	<?php
        
        if($row['sub_kategori_barang']=='Embalase'){
            $total_embalase=$total_embalase+($row['hna']*$row['jumlah_penjualan']);
        }else{
            $total = $total + ($row['hna']*$row['jumlah_penjualan']);
            $jml_r=$_GET['kelas'] != null?$row['no_r']:0;            
        }
	$biaya_apt=$row['biaya_apoteker'];
        $diskon=$row['diskon'];
        $total_tagihan=$row['total_tagihan'];
	endforeach;
        
        if(isset($group[$a-1]) && ($cek_jenis != 'Bebas'))
            $group[$a-1]['jumlah']=$jumlah;  ?>
	</table>
        <?
            foreach($group as $g){
                ?>
        <script type="text/javascript">
            $(document).ready(function(){
                $('#resep_'+<?=$g['nomor']?>).attr('rowspan', <?=$g['jumlah']?>);
                $('#resep_'+<?=$g['nomor']?>).attr('valign', 'middle');
            });
        </script>
                <?
            }
        ?>

	<table style="border: none; width: 27%; float: right; margin-right: 9%;">
		<tr>
                    <td>Total:</td><td style="text-align: right;"><b><?php echo (rupiah($total)); ?></b></td>
		</tr>
                <tr>
                    <td>Jasa Pelayanan:</td><td align="right"><?= rupiah($biaya_apt); ?></td>
		</tr>
                <tr>
                    <td>Jasa Sarana:</td><td align="right"><?= rupiah($total_embalase); ?></td>
		</tr>
                <tr>
                    <td>Diskon:</td><td align="right"><?= rupiah($diskon); ?></td>
		</tr>
                <tr>
                    <td>Total Tagihan:</td><td align="right"><b><?= rupiah($total_tagihan); ?></b></td>
		</tr>
		<tr>
                    <td>&nbsp;</td><td>&nbsp;</td>
		</tr>
		<tr>
                    <td>&nbsp;</td><td style="text-align: right;"><!--// echo ($_SESSION['nama']); <!--<br />PETUGAS--></td>
		</tr>
	</table>

        </fieldset>
</div>
<script type="text/javascript">
        function cetak_etiket(no_r){
            var win = window.open('print/cetak-etiket?code=<?=$code?>&kelas=<?=$_GET['kelas']?>&no_r='+no_r, 'MyWindow', 'width=400px, height=400px, scrollbars=1');
        }
	$(function(){
		$("#nota").click(function(){
			var win = window.open('print/nota-penjualan?code=<?=$code?>&kelas=<?=$_GET['kelas']?>', 'MyWindow', 'width=600px, height=500px, scrollbars=1');
		})
		$("#salin").click(function(){
			var win = window.open('print/salin-resep?code=<?=$code?>&kelas=<?=$_GET['kelas']?>', 'MyWindow', 'width=600px, height=500px, scrollbars=1');
		})
	})
</script>