<?php
require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-data.php';
require_once 'app/config/db.php';
$id = isset ($_GET['id'])?$_GET['id']:NULL;
$jenis = isset ($_GET['jenis'])?$_GET['jenis']:NULL;
//$jenis = $_GET['jenis'];
$sp = sp_muat_data_by_id($id);
$master = $sp['master'];
//show_array($master);
$detail = $sp['barang'];
$bulan = date('m');
$tahun = date('Y');
$head = head_laporan_muat_data();
$rs=  profile_rumah_sakit_muat_data();
$tanggal = explode("-", $master['tanggal']);
?>
 <html>
   <head>
      <title>Surat Pesanan <?=$master['jenis_sp']?></title>
      <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/base.css')?>">
      <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/tabel.css')?>">
     <style type="text/css">
         .table{
            margin-top: 10px;
            border-top: 1px solid #000000;
            border-left: 1px solid #000000;
        }
        .table th{
            background: #eeeeee;
        } 
       .table td,th{
            padding: 2px;       
            border-bottom: 1px solid #000000;
            border-right: 1px solid #000000;
        }
		.tengah { text-align: center; }
		.tebal { font-weight: bold; }
		.isinya
		{
			width: 580px;
		}
		.foo
		{
			display: block;
			height: 20px;
			width: 20px;
			float: left;
		}
		.bar
		{
			width: 560px;
			float: right;
		}
		.menjorok
		{
			display: block
			height: 20px;
			width: 100px;
			float: left;
		}
		.menjorokz
		{
			display: block
			height: 20px;
			width: 15px;
			float: left;
		}
		.menjorok_jorok
		{
			display: block;
			height: 20px;
			width: 460px;
			float: left;
		}
		.menjorok_jorokz
		{
			display: block;
			height: 40px;
			width: 460px;
			float: left;
		}
     </style>
     <script type="text/javascript">
   	function cetak() {  		
  		SCETAK.innerHTML = '';
		window.print();
		if (confirm('Apakah menu print ini akan ditutup?')) {
                    window.close();
		}
		SCETAK.innerHTML = '<br /><input onClick=\'cetak()\' type=\'submit\' name=\'Submit\' value=\'Cetak\' class=\'tombol\'>';
  	}
     </script>           
     <?php
	 require_once 'app/actions/admisi/lembar-header.php';
	 
	 if ($jenis != 'Psikotropika')
	 {
	 ?>
     <table class="head-laporan">
         <tr>
            <td align="center">
                SURAT PEMESANAN <br />
                Nomor: <?php echo $master['id']."/".$tanggal[1]."/".$tanggal[0]?>
            </td>
         </tr>
     </table> 
   
     <table class="contain">
      <tr>  
           <td align="right"><?=$rs['kabupaten'].", ".  indo_tgl(Date('d/m/Y'), '/')?></td>
      </tr>
      <tr>
           <td style="padding-left: 5px">
               Kepada:<br />
               Yth. <b><?=$master['suplier']?></b><br />
               Di. <b><?=$master['kabupaten']?></b>
           </td>
      </tr>
      <tr>
          <td height="70px" valign="bottom" style="padding-left: 5px">Dengan Hormat, <br />Mohon dikirim barang sbb :</td>
      </tr>
      <tr>
           <td>
              <div class="data-list">
              <table width="100%" class="table">
                  <tr>
                      <th style="width: 5%">No</th>
                      <th style="width: 40%">Nama</th>
                      <th style="width: 12%">Jumlah</th>
                      <th>Keterangan</th>
                  </tr>
                  <?php
                      $no = 1;
                       foreach ($detail as $row){
                  ?>
                  <tr>
                      <td align="center"><?= $no?></td>
                      <td><?= $row['nama_barang']." ".$row['kekuatan']." $row[sediaan] @$row[nilai_konversi] $row[satuan_terkecil]" ?></td>
                      <td><?= rupiah($row['jumlah_pesan'])." ".$row["satuan_terbesar"]?></td>
                      <td>&nbsp;</td>
                  </tr>
                  <?php
				  $no++;
                       }
					   
                   ?>
              </ul>    
              </table>
              </div>    
           </td>
       </tr>
       <tr>
          <td align="left">
               <table>
                  <tr><td valign="top">Atas perhatiannya kami mengucapkan terima kasih.</td></tr>
                  <tr><td valign="top">Hormat kami,</td></tr>
                  <tr><td valign="top" height="70">Penanggung Jawab,</td></tr>
                  <tr><td><?= $master['pegawai']?><br />________________________</td></tr>
                  <tr><td>SIP. <?= ($master['sip']!="NULL"&&$master['sip']!="")?$master['sip']:""?></td></tr>
               </table>
           </td>
       </tr>
    </table>
	<?php
	} else
	{
	?>
	<table class="head-laporan">
		<tr>
			<td align="center">
				SURAT PESANAN <?=strtoupper('psikotropika')?> <br />
				Nomor: <?php echo $master['id']."/".$tanggal[1]."/".$tanggal[0]?>
			</td>
		</tr>
	</table>
	<table class="contain">
		<tr>
			<td class="tebal">Yang bertandatangan di bawah ini:</td>
		</tr>
		<tr>
			<td>
				<div class="isinya">
					<div class="foo"></div>
					<div class="bar">
						<div class="menjorok">Nama</div>
						<div class="menjorok_jorok">: <?php echo $master['pegawai']; ?></div>
					</div>
				</div>
				<div class="isinya">
					<div class="foo"></div>
					<div class="bar">
						<div class="menjorok">Jabatan</div>
						<div class="menjorok_jorok">: <?php echo $master['level'].', '.$master['unit'] ?></div>
					</div>
				</div>
				<div class="isinya">
					<div class="foo"></div>
					<div class="bar">
						<div class="menjorok">Alamat</div>
						<div class="menjorok_jorokz">: <?php echo $master['alamat_jalan']; ?></div>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td class="tebal">Mengajukan pesanan psikotropika kepada:</td>
		</tr>
		<tr>
			<td>
				<div class="isinya">
					<div class="foo"></div>
					<div class="bar">
						<div class="menjorok">Nama</div>
						<div class="menjorok_jorok">: <?=$master['suplier']?></div>
					</div>
				</div>
				<div class="isinya">
					<div class="foo"></div>
					<div class="bar">
						<div class="menjorok">Alamat</div>
						<div class="menjorok_jorokz">
							: <?=$master['alamat']?>						</div>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td class="tebal">Jenis Psikotropika:</td>
		</tr>
		<tr>
			<td>
				<div class="isinya">
					<?php
					$no = 1;
					foreach ($detail as $row)
					{
					?>
					<div class="foo"></div>
					<div class="bar">
						<div class="menjorokz"><?php echo $no; ?>.</div>
						<div class="menjorok_jorok"><?php echo $row['nama_barang']." ".$row['kekuatan']." $row[sediaan] @$row[nilai_konversi] $row[satuan_terkecil]"; ?></div>
					</div>
					<?php
					}
					?>
				</div>
			</td>
		</tr>
		<tr>
			<td class="tebal">Untuk keperluan: </td>
		</tr>
		<tr>
			<td>
				<div class="isinya">
					<div class="foo"></div>
					<div class="bar">
						<div class="menjorok">Nama</div>
						<div class="menjorok_jorok">: <?php echo $rs['nama']; ?></div>
					</div>
				</div>
				<div class="isinya">
					<div class="foo"></div>
					<div class="bar">
						<div class="menjorok">Alamat</div>
						<div class="menjorok_jorokz">: <?php echo $rs['alamat']; ?></div>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td class="tengah tebal">
				<br />Pemesan<br /><br /><br />_<u><?php echo $master['pegawai']; ?></u>_<br /><?php echo ($master['sip'] != "NULL" && $master['sip'] != "") ? $master['sip'] : ""; ?>
			</td>
		</tr>
	</table>
	<?php
	}
	?>
    <center>
          <p><span id='SCETAK'><input type='button' class='tombol' value='Cetak' onClick='cetak()'></span></p>
    </center>  
    </body>
</html>    
<?php
exit();
?>

