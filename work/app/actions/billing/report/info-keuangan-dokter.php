<?php
require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-data.php';
set_time_zone();

$startDate=(isset($_GET['startDate']))? $_GET['startDate']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
$endDate=(isset($_GET['endDate']))? $_GET['endDate']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
$namaFile = "info-keuangan-jasa-dokter.xls";

// header file excel

header_excel($namaFile);
?>
<table border="0">
    <tr bgcolor="#cccccc">
        <td colspan="10" align="center"><strong><font size="+1">RS. PKU MUHAMMADYAH</font></strong></td>
    </tr>
    <tr bgcolor="#cccccc">
        <td colspan="10" align="center"><strong><font size="+1">PENERIMAAN JASA DOKTER </font></strong></td>
    </tr>
	<tr bgcolor="#cccccc">
        <td colspan="10" align="center"><strong><font size="+1">PERIODE: <?php echo $startDate; ?> s . d <?php echo $endDate; ?></font></strong></td>
    </tr>
    <tr>
        <td colspan="10">&nbsp;</td>
    </tr>
</table>
<?
if($_GET['key']=='umum'){
?>
<table>
	<tr bgcolor="#cccccc">
        <td colspan="10" align="center"><strong><font size="+1">.:: PENERIMAAN JASA DOKTER <?php echo str_replace('_',' ',$_GET['nama']);?> UNTUK PASIEN UMUM ::.</font></strong></td>
    </tr>
</table>
 <table style="width: 100%" border="1" class="tabel" cellspacing=0>
        <tr>
            <th>No</th>
            <th>Nama Asuransi</th>
            <th>Tanggal Bayar</th>
            <th>Bulan Bayar</th>
            <th>No RM</th>
            <th>Nama Pasien</th>
            <th>Pemeriksaan (Nilai Uang)</th>
            <th>Visit</th>
            <th>Tindakan (Nilai Uang)</th>
            <th>Konsultasi Dokter</th>
            <th>Medicasi Dokter</th>
            <th>Jumlah Nilai</th>
        </tr>
     <?php
        $data_jasa_umum = detail_jasa_dokter_umum_muat_data($_GET['idPen'],$startDate,$endDate);
        $no=1;
        $tot_jumlah_umum = '0';$tot_pemeriksaan_umum = '0'; $tot_visit_umum = '0'; $tot_tindakan_umum = '0'; $tot_konsultasi_umum = '0'; $tot_medicasi_umum = '0';
        foreach ($data_jasa_umum as $record) {
            $tgl_bayarr_umum = explode('-',$record['tgl_pembayaran']);
            $bulan_bayar_umum = (isset($tgl_bayarr_umum[1]))?$tgl_bayarr_umum[1]:'-';
            $tgl_bayar_umum = (isset($tgl_bayarr_umum[2]))?$tgl_bayarr_umum[2]:'-';
            $total_tindakan_umum = $record['pemeriksaan']+$record['visit']+$record['tindakan']+$record['konsultasi']+$record['medikasi'];
            $tot_jumlah_umum += $total_tindakan_umum;
               ?>
                <tr class='<?php echo ($no%2)?'even':'odd'?>'>
                   <td><?php echo $no ;?></td>
                   <td><?php echo $record['nama_asuransi'] ;?></td>
                   <td><?php echo $tgl_bayar_umum ;?></td>
                   <td><?php echo $bulan_bayar_umum ;?></td>
                   <td><?php echo $record['no_rm'] ;?></td>
                   <td><?php echo $record['nama_pasien'] ;?></td>
                   <td><?php echo ($record['pemeriksaan']) ;?></td>
                   <td><?php echo ($record['visit']) ;?></td>
                   <td><?php echo ($record['tindakan']) ;?></td>
                   <td><?php echo ($record['konsultasi']) ;?></td>
                   <td><?php echo ($record['medikasi']) ;?></td>
                   <td><?php echo ($total_tindakan_umum) ;?></td>
                </tr>
        <?php
        $tot_pemeriksaan_umum += $record['pemeriksaan']; $tot_visit_umum += $record['visit'];
        $tot_tindakan_umum += $record['tindakan']; $tot_konsultasi_umum += $record['konsultasi']; $tot_medicasi_umum += $record['medikasi'];
        $no++;
        } ?>
                <tr >
                    <td colspan='6' align='center'>Total</td>
                    <td><?= ($tot_pemeriksaan_umum) ;?></td>
                    <td><?= ($tot_visit_umum) ;?></td>
                    <td><?= ($tot_tindakan_umum) ;?></td>
                    <td><?= ($tot_konsultasi_umum) ;?></td>
                    <td><?= ($tot_medicasi_umum) ;?></td>
                    <td><?= ($tot_jumlah_umum) ;?></td>
                </tr>
    </table>
<?php	
}else if($_GET['key']=='pribadi'){
?>
<table>
	<tr bgcolor="#cccccc">
        <td colspan="10" align="center"><strong><font size="+1">.:: PENERIMAAN JASA DOKTER <?php echo str_replace('_',' ',$_GET['nama']);?> UNTUK PASIEN PRIBADI ::.</font></strong></td>
    </tr>
</table>
<table style="width: 100%" border="1" class="tabel" cellspacing=0>
        <tr>
            <th>No</th>
            <th>Nama Asuransi</th>
            <th>Tanggal Bayar</th>
            <th>Bulan Bayar</th>
            <th>No RM</th>
            <th>Nama Pasien</th>
            <th>Pemeriksaan (Nilai Uang)</th>
            <th>Visit</th>
            <th>Tindakan (Nilai Uang)</th>
            <th>Konsultasi Dokter</th>
            <th>Medicasi Dokter</th>
            <th>Jumlah Nilai</th>
        </tr>
     <?php
        $data_jasa_pribadi = detail_jasa_dokter_pribadi_muat_data($_GET['idPen'],$startDate,$endDate);
        $no=1;
        $tot_jumlah_pribadi = '0';$tot_pemeriksaan_pribadi = '0'; $tot_visit_pribadi = '0'; $tot_tindakan_pribadi = '0'; $tot_konsultasi_pribadi = '0'; $tot_medicasi_pribadi = '0';
        foreach ($data_jasa_pribadi as $record) {
            $tgl_bayarr_pribadi = explode('-',$record['tgl_pembayaran']);
            $bulan_bayar_pribadi = (isset($tgl_bayarr_pribadi[1]))?$tgl_bayarr_pribadi[1]:'-';
            $tgl_bayar_pribadi = (isset($tgl_bayarr_pribadi[2]))?$tgl_bayarr_pribadi[2]:'-';
            $total_tindakan_pribadi = $record['pemeriksaan']+$record['visit']+$record['tindakan']+$record['konsultasi']+$record['medikasi'];
            $tot_jumlah_pribadi += $total_tindakan_pribadi;
               ?>
                <tr class='<?php echo ($no%2)?'even':'odd'?>'>
                   <td><?php echo $no ;?></td>
                   <td><?php echo $record['nama_asuransi'] ;?></td>
                   <td><?php echo $tgl_bayar_pribadi ;?></td>
                   <td><?php echo $bulan_bayar_pribadi ;?></td>
                   <td><?php echo $record['no_rm'] ;?></td>
                   <td><?php echo $record['nama_pasien'] ;?></td>
                   <td><?php echo ($record['pemeriksaan']) ;?></td>
                   <td><?php echo ($record['visit']) ;?></td>
                   <td><?php echo ($record['tindakan']) ;?></td>
                   <td><?php echo ($record['konsultasi']) ;?></td>
                   <td><?php echo ($record['medikasi']) ;?></td>
                   <td><?php echo ($total_tindakan_pribadi) ;?></td>
                </tr>
        <?php
        $tot_pemeriksaan_pribadi += $record['pemeriksaan']; $tot_visit_pribadi += $record['visit'];
        $tot_tindakan_pribadi += $record['tindakan']; $tot_konsultasi_pribadi += $record['konsultasi']; $tot_medicasi_pribadi += $record['medikasi'];
        $no++;
        } ?>
                <tr >
                    <td colspan='6' align='center'>Total</td>
                    <td><?= ($tot_pemeriksaan_pribadi) ;?></td>
                    <td><?= ($tot_visit_pribadi) ;?></td>
                    <td><?= ($tot_tindakan_pribadi) ;?></td>
                    <td><?= ($tot_konsultasi_pribadi) ;?></td>
                    <td><?= ($tot_medicasi_pribadi) ;?></td>
                    <td><?= ($tot_jumlah_pribadi) ;?></td>
                </tr>
    </table>
<?php
}else if($_GET['key']=='jamkesmas'){
?>
<table>
	<tr bgcolor="#cccccc">
        <td colspan="10" align="center"><strong><font size="+1">.:: PENERIMAAN JASA DOKTER <?php echo str_replace('_',' ',$_GET['nama']);?> UNTUK PASIEN JAMKESMAS ::.</font></strong></td>
    </tr>
</table>
<table style="width: 100%" border="1" class="tabel" cellspacing=0>
            <tr>
                <th>No</th>
                <th>Tanggal Bayar</th>
                <th>Bulan Bayar</th>
                <th>No RM</th>
                <th>Nama Pasien</th>
                <th>Pemeriksaan (Nilai Uang)</th>
                <th>Visit</th>
                <th>Tindakan (Nilai Uang)</th>
                <th>Konsultasi Dokter</th>
                <th>Medicasi Dokter</th>
                <th>Jumlah Nilai</th>
            </tr>
        <?php
        $data_jasa_jamkesmas = detail_jasa_dokter_jamkesmas_muat_data($_GET['idPen'],$startDate,$endDate);
        $tot_pemeriksaan_jamkesmas = '0'; $tot_visit_jamkesmas = '0'; $tot_tindakan_jamkesmas= '0'; $tot_konsultasi_jamkesmas = '0'; $tot_medicasi_jamkesmas = '0';$tot_jumlah_jamkesmas='0';
        $no = 1;
        foreach ($data_jasa_jamkesmas as $record) {
            $tgl_bayarr_jamkesmas = explode('-',$record['tgl_pembayaran']);
            $bulan_bayar_jamkesmas = (isset($tgl_bayarr_jamkesmas[1]))?$tgl_bayarr_jamkesmas[1]:'-';
            $tgl_bayar_jamkesmas = (isset($tgl_bayarr_jamkesmas[2]))?$tgl_bayarr_jamkesmas[2]:'-';
            $total_tindakan_jamkesmas = $record['pemeriksaan']+$record['visit']+$record['tindakan']+$record['konsultasi']+$record['medikasi'];
            $tot_jumlah_jamkesmas += $total_tindakan_jamkesmas;
                 ?>
                <tr class='<?php echo ($no%2)?'even':'odd'?>'>
                   <td><?= $no ;?></td>
                   <td><?php echo $tgl_bayar_jamkesmas ;?></td>
                   <td><?php echo $bulan_bayar_jamkesmas ;?></td>
                   <td><?php echo $record['no_rm'] ;?></td>
                   <td><?php echo $record['nama_pasien'] ;?></td>
                   <td><?php echo ($record['pemeriksaan']) ;?></td>
                   <td><?php echo ($record['visit']) ;?></td>
                   <td><?php echo ($record['tindakan']) ;?></td>
                   <td><?php echo ($record['konsultasi']) ;?></td>
                   <td><?php echo ($record['medikasi']) ;?></td>
                   <td><?php echo ($total_tindakan_jamkesmas) ;?></td>
                </tr>
                <?php
                 $tot_pemeriksaan_jamkesmas += $record['pemeriksaan']; $tot_visit_jamkesmas += $record['visit'];
                 $tot_tindakan_jamkesmas += $record['tindakan']; $tot_konsultasi_jamkesmas += $record['konsultasi']; $tot_medicasi_jamkesmas += $record['medikasi'];
                $no++;
        } ?>
                <tr>
                    <td colspan='5' align='center'>Total</td>
                    <td><?= ($tot_pemeriksaan_jamkesmas) ;?></td>
                    <td><?= ($tot_visit_jamkesmas) ;?></td>
                    <td><?= ($tot_tindakan_jamkesmas) ;?></td>
                    <td><?= ($tot_konsultasi_jamkesmas) ;?></td>
                    <td><?= ($tot_medicasi_jamkesmas) ;?></td>
                    <td><?= ($tot_jumlah_jamkesmas) ;?></td>
                </tr>
    </table>
<?php
}
exit();
?>