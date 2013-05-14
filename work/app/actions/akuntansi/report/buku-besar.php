<?php
require_once 'app/lib/common/functions.php';
require_once 'app/config/db.php';
require_once 'app/lib/common/master-akuntansi.php';
set_time_zone();

$profil = profile_rumah_sakit_muat_data();
$namaFile = "buku-besar.xls";

// header file excel

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0,
        pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");

// header untuk nama file
header("Content-Disposition: attachment;
        filename=".$namaFile."");

header("Content-Transfer-Encoding: binary ");

$tipe = 1;

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
Per <?php echo "1 - ".$jmlHari." ".bulan($bulan)." ".$tahun;?><br>
</center><br>
<?php
if (count($bukubesar) !=null) { ?>
	
        <table border=1>
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
		    echo "<td align='right'>".rupiah($saldoawal)."</td><td align='right'></td>";
		} else {
		    echo "<td align='right'></td><td align='right'>".rupiah($saldoawal)."</td>";
		    
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
                <td align="right"><?php echo ($row['status_rekening']=="d")? rupiah($row['jumlah_rekening']):null; ?></td>
                <td align="right"><?php echo ($row['status_rekening']=="k")? rupiah($row['jumlah_rekening']):null; ?></td>
               <?php if ($rekening['status']==1) {
		    echo "<td align='right'>".rupiah($saldo)."</td><td align='right'></td>";
		} else {
		    echo "<td align='right'></td><td align='right'>".rupiah($saldo)."</td>";   
		}?>
		</tr>
            <?php endforeach; ?>
		<tr>
		<td colspan=5 class="right odd"><b>SALDO</b></td>
		<?php if ($rekening['status']==1) {
		    echo "<td align='right'><b>".rupiah($saldo)."</b></td><td align='right'></td>";
		} else {
		    echo "<td align='right'></td><td align='right'><b>".rupiah($saldo)."</b></td>";   
		}

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
				echo ($row['jumlah_rekening'] > 0) ? "<td align='right'>".rupiah(abs($row['jumlah_rekening']))."</td><td></td>": "<td></td><td align='right'>".rupiah(abs($row['jumlah_rekening']))."</td>";
			} else {
				echo ($row['jumlah_rekening'] > 0) ? "<td></td><td align='right'>".rupiah(abs($row['jumlah_rekening']))."</td>": "<td align='right'>".rupiah(abs($row['jumlah_rekening']))."</td><td></td>"; 
			}
			
			if ($rekening['status']==1) {
				/*if ($saldo_penyesuaian<0) {
					echo "<td></td><td align=right>".rupiah(abs($saldo_penyesuaian))."</td>";	
				} else {*/
					echo "<td align='right'>".rupiah($saldo_penyesuaian)."</td><td></td>";
				/*}*/
			} else {
				/*if ($saldo_penyesuaian<0) {
					echo "<td align='right'>".rupiah(abs($saldo_penyesuaian))."</td><td></td>";   
				} else {*/
					echo "<td align='right'></td><td align='right'>".rupiah($saldo_penyesuaian)."</td>";   
				/*}*/
			}?>
		</tr>
            <?php endforeach; ?>
		<tr>
		<td colspan=5 class="right odd"><b>SALDO SETELAH PENYESUAIAN</b></td><?php
		$saldoakhir = $saldo+$saldo_penyesuaian;
		
		if ($rekening['status']==1) {
			echo "<td align='right'><b>".rupiah($saldoakhir)."</b></td><td></td>";
			/*
		    if ($saldoakhir < 0) {
				echo "<td></td><td align='right'><b>".rupiah(abs($saldoakhir))."</b></td>";
		    } else {
				echo "<td align='right'><b>".rupiah($saldoakhir)."</b></td><td align='right'></td>";
		    }*/
		} else {
			echo "<td></td><td align='right'><b>".rupiah($saldoakhir)."</b></td>"; 
		    /*if ($saldoakhir < 0) {
		    echo "<td align='right'><b>".rupiah(abs($saldoakhir))."</b></td><td></td>";
		    } else {
		    echo "<td></td><td align='right'><b>".rupiah($saldoakhir)."</b></td>";   
		    }*/
		}
		echo "</tr></table>";
		} else {
		    
		    echo "</table>";
		    
		}
	
	} else if (count($bukubesar) == 0 and count($bukubesar_disesuaikan) > 0) { ?>
	
	  <table border=1>
            <tr>

                <th style="width: 5%" rowspan=2>Tanggal</a></th>
                <th style="width: 22%" rowspan=2>Transaksi</th>
                <th style="width: 8%" rowspan=2>No. Bukti</a></th>
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
				if ($rekening['status']==1) echo "<td align='right'>".rupiah($saldo_penyesuaian)."</td><td></td>";
				else echo "<td></td><td align='right'>".rupiah($saldo_penyesuaian)."</td>";
		?></tr> 
            <?php
			$saldoawal_disesuaikan = data_saldobulanlalu($bulan,$tahun,$idrekening);
            $saldo_penyesuaian=$saldoawal_disesuaikan;
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
                <td align="right"><?php echo ($row['status_rekening']=="d")? rupiah($row['jumlah_rekening']):null; ?></td>
                <td align="right"><?php echo ($row['status_rekening']=="k")? rupiah($row['jumlah_rekening']):null; ?></td>
               <?php if ($rekening['status']==1) {
		    /*if ($saldo_penyesuaian<0) {
		    echo "<td></td><td align=right>".rupiah(abs($saldo_penyesuaian))."</td>";	
		    } else {*/
		    echo "<td align='right'>".rupiah($saldo_penyesuaian)."</td><td></td>";
		    /*}*/
		} else {
		    /*if ($saldo_penyesuaian<0) {
		    echo "<td align='right'>".rupiah(abs($saldo_penyesuaian))."</td><td></td>";   
		    /*} else {*/
		    echo "<td align='right'></td><td align='right'>".rupiah($saldo_penyesuaian)."</td>";   
		    /*}*/
		}?>
		</tr>
            <?php endforeach; ?>
		<tr>
		<td colspan=5 class="right odd"><b>SALDO PENYESUAIAN</b></td><?php
		$saldoakhir = $saldo_penyesuaian;
		
		
		if ($rekening['status']==1) {
		    
			echo "<td align='right'><b>".rupiah($saldoakhir)."</b></td><td></td>";
			/* if ($saldoakhir < 0) {
			echo "<td></td><td align='right'><b>".rupiah(abs($saldoakhir))."</b></td>";
		    } else {
			echo "<td align='right'><b>".rupiah($saldoakhir)."</b></td><td align='right'></td>";
		    }*/
		} else {
		    echo "<td></td><td align='right'><b>".rupiah($saldoakhir)."</b></td>"; 
			
			/*if ($saldoakhir < 0) {
		    echo "<td align='right'><b>".rupiah(abs($saldoakhir))."</b></td><td></td>";
		    } else {
		    echo "<td></td><td align='right'><b>".rupiah($saldoakhir)."</b></td>";   
		    }*/
		}
		
		
	
	} 

exit();
?>
