
<?php 

$sub= isset($_GET['section'])?$_GET['section']:NULL;

if (isset($sub)) {

switch($sub) {
	
	// ---------------------------- Rekening Buku Besar------------------------------ //
	
	case "rekeningbukubesar":
	include 'app/lib/common/master-akuntansi.php';
	
	$dataRekening = data_rekening_list($_GET['bulan'],$_GET['tahun']);
	
	if (count($dataRekening['list'])==0 ) {  
		echo notifikasi("Data rekening belum tersedia");   
	} else { ?>

	<div class='data-list w600px'>

	<table class="tabel full">
		<tr>
			<th>Kode</th>
			<th>Nama</th>

		</tr>
		<?php
		foreach ($dataRekening['list'] as $key => $row):
		?>
		<tr class="<?= ($key % 2) ? 'even' : 'odd' ?>">
			<td><a href="" onclick="tampilLaporanBukuBesar('<?php echo $_GET['bulan']."','".$_GET['tahun']."','".$row['id'];?>'); return false"><?php echo $row['kode'] ?></a></td>
			<td><a href="" onclick="tampilLaporanBukuBesar('<?php echo $_GET['bulan']."','".$_GET['tahun']."','".$row['id'];?>'); return false"><?php echo $row['nama'] ?></a></td>
	   
			</tr>
		<?php endforeach; ?>
	</table>

	</div>
	<?php }
	break;


	//---------------------- Laporan Buku Besar ---------------------- //

	case "laporanbukubesar":
	
	$tipe = 1;
	include 'app/lib/common/master-akuntansi.php';
	set_time_zone();
	
	$bulan=isset($_GET['bulan'])?$_GET['bulan']:NULL;
	$tahun=isset($_GET['tahun'])?$_GET['tahun']:NULL;
	$idrekening=isset($_GET['rekening'])?$_GET['rekening']:NULL;
	
	$sort=isset($_GET['sort'])?isset($_GET['sort']):NULL;
	$sortBy=isset($_GET['sortBy'])?isset($_GET['sortBy']):NULL;
	
	$bukubesar = data_bukubesar($_GET['bulan'],$_GET['tahun'],$_GET['rekening'],$tipe);
	
	
	$saldoawal = data_saldobulanlalu($bulan,$tahun,$idrekening);
	$rekening = data_rekening_muat_data($idrekening);

	$jmlHari=cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
	$sebulan=date("d F Y", mktime (0,0,0,$bulan,$jmlHari,$tahun));
	$bulantahun=date("F Y", mktime (0,0,0,$bulan,1,$tahun));
	
	
	$bukubesar_disesuaikan = data_bukubesar($_GET['bulan'],$_GET['tahun'],$_GET['rekening'],2);
	
	
    ?>
    <div class='data-list'>
       <center><h2 class="judul" style="padding: 0; margin: 0">
        Buku Besar<br>
	<?php echo $rekening['nama']; ?></h2>
		Kode Rek. : <?=  $rekening['kode']; ?><br>
<!--        Per <?php //echo "1 - ".$sebulan;?><br>-->
       
        Per <?php echo "1 - ".$jmlHari." ".bulan($bulan)." ".$tahun;?><br>
       <br>
        </center>
	<?php
	
	if (count($bukubesar) !=null) { ?>
	
        <table class="tabel" cellpadding=2 cellspacing=0 style='width: 98%'>
            <tr>

                <th width="5%" rowspan=2>Tanggal</th>
                <th width="22%" rowspan=2>Transaksi</th>
                <th width="8%" rowspan=2>No. Bukti</th>
                <th width="15%" rowspan=2>Debet</th>
                <th width="15%" rowspan=2>Kredit</th>
                <th width="30%" colspan=2>Saldo</th>
	    </tr>
	    <tr>
		<th width="15%">Debet</th>
		<th width="15%">Kredit</th>
            </tr>
             <tr class="odd">
                <td align="center"></td>
                <td>Saldo Awal Per 1 <?php echo $bulantahun?></td>
                <td></td>
                <td align="right"></td>
                <td align="right"></td>
		<?php if ($rekening['status']==1) {
		    echo "<td class='right'>".rupiahplus($saldoawal)."</td><td class='right'></td>";
		} else {
		    echo "<td class='right'></td><td class='right'>".rupiahplus($saldoawal)."</td>";
		    
		}
		?>
	    </tr>
            <?php
	   
            $saldo=$saldoawal;
            foreach ($bukubesar as $key => $row):
			if ($rekening['status']==1) {
					if ($row['status_rekening']=="d") {
						$saldo+=$row['jumlah_rekening'];
					} else {
						$saldo-=$row['jumlah_rekening'];
					}
			} else {
			if ($row['status_rekening']=="d") {
						$saldo-=$row['jumlah_rekening'];
					} else {
						$saldo+=$row['jumlah_rekening'];
					}
			}
            ?>
            <tr class="<?= ($key % 2) ? 'odd':'even'?>">
                <td align="center"><?= datefmysql($row['tanggal_jurnal']) ?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['nomor_bukti'] ?></td>
                <td align="right"><?php echo ($row['status_rekening']=="d")? rupiahplus($row['jumlah_rekening']):null; ?></td>
                <td align="right"><?php echo ($row['status_rekening']=="k")? rupiahplus($row['jumlah_rekening']):null; ?></td>
               <?php if ($rekening['status']==1) {
		    echo "<td class='right'>".rupiahplus($saldo)."</td><td class='right'></td>";
		} else {
		    echo "<td class='right'></td><td class='right'>".rupiahplus($saldo)."</td>";   
		}?>
		</tr>
            <?php endforeach; ?>
		<tr>
		<td colspan=5 class="right odd"><b>SALDO</b></td>
		<?php if ($rekening['status']==1) {
		    echo "<td class='right odd'><b>".rupiahplus($saldo)."</b></td><td class='right odd'></td>";
		} else {
		    echo "<td class='right odd'></td><td class='right odd'><b>".rupiahplus($saldo)."</b></td>";   
		}
		
		//simpan_bukubesar($saldo,$bulan,$tahun,$idrekening,$tipe); 
		
		?>
		    
		</tr>
		
		
        <?php
		
		$tipe=2;
		$saldoawal_disesuaikan = $saldo;
		
		if (count($bukubesar_disesuaikan) != 0) { ?>
             <tr class="odd">
                <td align="center" colspan=7 style='font-size: 14px; font-weight: bold;'>PENYESUAIAN</td>
	    </tr>
            <?php
	   
            $saldo_penyesuaian=$saldoawal_disesuaikan['jumlah'];
            foreach ($bukubesar_disesuaikan as $key => $row):
	    if ($rekening['status']==1) {
                if ($row['status_rekening']=="d") {
                    $saldo_penyesuaian+=$row['jumlah_rekening'];
                } else {
                    $saldo_penyesuaian-=$row['jumlah_rekening'];
                }
	    } else {
		if ($row['status_rekening']=="d") {
                    $saldo_penyesuaian-=$row['jumlah_rekening'];
                } else {
                    $saldo_penyesuaian+=$row['jumlah_rekening'];
                }
	    }
		?>
		<tr class="<?= ($key % 2) ? 'odd':'even'?>">
			<td align="center"><?= datefmysql($row['tanggal_jurnal']) ?></td>
			<td><?= $row['nama'] ?></td>
			<td><?= $row['nomor_bukti'] ?></td><?php
			if ($row['status_rekening']=="d") {
				echo ($row['jumlah_rekening'] > 0) ? "<td align='right'>".rupiahplus(abs($row['jumlah_rekening']))."</td><td></td>": "<td></td><td align='right'>".rupiahplus(abs($row['jumlah_rekening']))."</td>";
			} else {
				echo ($row['jumlah_rekening'] > 0) ? "<td></td><td align='right'>".rupiahplus(abs($row['jumlah_rekening']))."</td>": "<td align='right'>".rupiahplus(abs($row['jumlah_rekening']))."</td><td></td>"; 
			}
			
			if ($rekening['status']==1) {
				/*if ($saldo_penyesuaian<0) {
					echo "<td></td><td align=right>".rupiahplus(abs($saldo_penyesuaian))."</td>";	
				} else {*/
					echo "<td align='right'>".rupiahplus($saldo_penyesuaian)."</td><td></td>";
				/*}*/
			} else {
				/*if ($saldo_penyesuaian<0) {
					echo "<td class='right'>".rupiahplus(abs($saldo_penyesuaian))."</td><td></td>";   
				} else {*/
					echo "<td class='right'></td><td class='right'>".rupiahplus($saldo_penyesuaian)."</td>";   
				/*}*/
			}?>
		</tr>
            <?php endforeach; ?>
		<tr>
		<td colspan=5 class="right odd"><b>SALDO SETELAH PENYESUAIAN</b></td><?php
		$saldoakhir = $saldo+$saldo_penyesuaian;
		
		if ($rekening['status']==1) {
			echo "<td class='right odd'><b>".rupiahplus($saldoakhir)."</b></td><td></td>";
			/*
		    if ($saldoakhir < 0) {
				echo "<td></td><td class='right odd'><b>".rupiahplus(abs($saldoakhir))."</b></td>";
		    } else {
				echo "<td class='right odd'><b>".rupiahplus($saldoakhir)."</b></td><td class='right odd'></td>";
		    }*/
		} else {
			echo "<td></td><td class='right odd'><b>".rupiahplus($saldoakhir)."</b></td>"; 
		    /*if ($saldoakhir < 0) {
		    echo "<td class='right odd'><b>".rupiahplus(abs($saldoakhir))."</b></td><td></td>";
		    } else {
		    echo "<td></td><td class='right odd'><b>".rupiahplus($saldoakhir)."</b></td>";   
		    }*/
		}
		
		//simpan_bukubesar($saldo_penyesuaian,$bulan,$tahun,$idrekening,$tipe); 
		
		
		echo "</tr></table>";
		} else {
		    
		    echo "</table>";
		    
		}
		
		echo "<br><br>".excelButton('akuntansi/report/buku-besar?'.generate_get_parameter($_GET),'Ekspor ke Excel');
	} else if (count($bukubesar) == 0 and count($bukubesar_disesuaikan) > 0) { ?>
	
	  <table class="tabel" cellpadding=2 cellspacing=0 style='width: 98%'>
            <tr>

                <th style="width: 5%" rowspan=2><a href='<?=app_base_url('akuntansi/buku-besar?').  generate_sort_parameter('tanggal', get_value('sortBy'))?>' class='sorting'>Tanggal</a></th>
                <th style="width: 22%" rowspan=2>Transaksi</th>
                <th style="width: 8%" rowspan=2><a href='<?=app_base_url('akuntansi/buku-besar?').  generate_sort_parameter('no_bukti', get_value('sortBy'))?>' class='sorting'>No. Bukti</a></th>
                <th style="width: 15%" rowspan=2>Debet</th>
                <th style="width: 15%" rowspan=2>Kredit</th>
                <th style="width: 30%" colspan=2>Saldo</th>
	    </tr>
	    <tr>
				<th width="15%">Debet</th>
				<th width="15%">Kredit</th>
				</tr>
		<tr class="odd">
                <td align="center" colspan=7 style='font-size: 14px; font-weight: bold;'>PENYESUAIAN</td>
	    </tr><?php $saldo_penyesuaian=data_saldobulanlalu($bulan,$tahun,$idrekening); ?>
		  <tr class="odd">
                <td align="center"></td>
                <td>Saldo Awal Per 1 <?php echo $bulantahun?></td>
                <td></td>
                <td align="right"></td>
                <td align="right"></td><?php 
				if ($rekening['status']==1) echo "<td class='right'>".rupiahplus($saldo_penyesuaian)."</td><td class='right'></td>";
				else echo "<td class='right'></td><td class='right'>".rupiahplus($saldo_penyesuaian)."</td>";
		?></tr> 
		<?php
            foreach ($bukubesar_disesuaikan as $key => $row):
	    if ($rekening['status']==1) {
                if ($row['status_rekening']=="d") {
                    $saldo_penyesuaian+=$row['jumlah_rekening'];
                } else {
                    $saldo_penyesuaian-=$row['jumlah_rekening'];
                }
	    } else {
		if ($row['status_rekening']=="d") {
                    $saldo_penyesuaian-=$row['jumlah_rekening'];
                } else {
                    $saldo_penyesuaian+=$row['jumlah_rekening'];
                }
	    }
            ?>
            <tr class="<?= ($key % 2) ? 'odd':'even'?>">
                <td align="center"><?= datefmysql($row['tanggal_jurnal']) ?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['nomor_bukti'] ?></td>
                <td align="right"><?php echo ($row['status_rekening']=="d")? rupiahplus($row['jumlah_rekening']):null; ?></td>
                <td align="right"><?php echo ($row['status_rekening']=="k")? rupiahplus($row['jumlah_rekening']):null; ?></td>
               <?php if ($rekening['status']==1) {
		    /*if ($saldo_penyesuaian<0) {
		    echo "<td></td><td align=right>".rupiahplus(abs($saldo_penyesuaian))."</td>";	
		    } else {*/
		    echo "<td align='right'>".rupiahplus($saldo_penyesuaian)."</td><td></td>";
		    /*}*/
		} else {
		    /*if ($saldo_penyesuaian<0) {
		    echo "<td class='right'>".rupiahplus(abs($saldo_penyesuaian))."</td><td></td>";   
		    /*} else {*/
		    echo "<td class='right'></td><td class='right'>".rupiahplus($saldo_penyesuaian)."</td>";   
		    /*}*/
		}?>
		</tr>
            <?php endforeach; ?>
		<tr>
		<td colspan=5 class="right odd"><b>SALDO PENYESUAIAN</b></td><?php
		$saldoakhir = $saldo_penyesuaian;
		
		
		if ($rekening['status']==1) {
		    
			echo "<td class='right odd'><b>".rupiahplus($saldoakhir)."</b></td><td></td>";
			/* if ($saldoakhir < 0) {
			echo "<td></td><td class='right odd'><b>".rupiahplus(abs($saldoakhir))."</b></td>";
		    } else {
			echo "<td class='right odd'><b>".rupiahplus($saldoakhir)."</b></td><td class='right odd'></td>";
		    }*/
		} else {
		    echo "<td></td><td class='right odd'><b>".rupiahplus($saldoakhir)."</b></td>"; 
			
			/*if ($saldoakhir < 0) {
		    echo "<td class='right odd'><b>".rupiahplus(abs($saldoakhir))."</b></td><td></td>";
		    } else {
		    echo "<td></td><td class='right odd'><b>".rupiahplus($saldoakhir)."</b></td>";   
		    }*/
		}
		
		//simpan_bukubesar($saldoakhir,$bulan,$tahun,$idrekening,2); 
		echo  "</table>";
		echo "<br><br>".excelButton('akuntansi/report/buku-besar?'.generate_get_parameter($_GET),'Ekspor ke Excel')."<br><br>";
	} else {
		echo notifikasi("Transaksi belum tersedia <br> pada <b>Rekening ".$rekening['nama']."</b> ini",1);
	}
		?>
    </div>
	
	<?php

	break;



}


exit();

} else {

set_time_zone();
	
	$id_rek=null;
	$bulanArr=array(''=>'Pilih Bulan','1'=>'Januari','2'=>'Februari','3'=>'Maret','4'=>'April','5'=>'Mei','6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember',);
	$bulanCb="<select name=bulan id=bulan class='search-input' style='margin-right: 5px; width: 120px'>";
	if(empty($_GET['bulan'])) $bulan=date('m'); else $bulan=$_GET['bulan'];
	if(empty($_GET['tahun'])) $tahun=date('Y'); else $tahun=$_GET['tahun'];

	foreach($bulanArr as $key=>$b){
	   if($key==$bulan){
		   $selected='selected';
	   }else{
		   $selected='';
	   }
	   $bulanCb.="<option value=$key $selected>$b</option>";
	}
	$bulanCb.="</select>";
	
	
	?>

	<script type="text/javascript">

	contentloader('<?= app_base_url('akuntansi/buku-besar?section=rekeningbukubesar') ?>&bulan=<?php echo $bulan; ?>&tahun=<?php echo $tahun; ?>','#content');
		function tampilRekeningBukuBesar(bulan,tahun) {
			contentloader('<?= app_base_url('akuntansi/buku-besar?section=rekeningbukubesar') ?>&bulan='+bulan+'&tahun='+tahun,'#content');
		}
		
		function tampilLaporanBukuBesar(bulan,tahun,rekening) {
			contentloader('<?= app_base_url('akuntansi/buku-besar?section=laporanbukubesar') ?>&bulan='+bulan+'&tahun='+tahun+'&rekening='+rekening,'#content');
		}
	</script>

	<h1 class="judul">Buku Besar</h1>
	<fieldset>
		<legend>Pilih Bulan & Tahun</legend>
		<form method="POST" class="search-form" style="float: none" onsubmit="tampilRekeningBukuBesar($('#bulan').val(),$('#tahun').val());return false;" id="pilihbulan">
		<?= $bulanCb ?><input type="text" onkeyup="Angka(this)" name="tahun" id="tahun" maxlength="4" value="<?=$tahun?>" class="search-input" style="width: 30px !important">
		<input type="submit" value="" class="search-button">
		</form>
	</fieldset>

	<div id="content"></div>
	<?php

}
?>
