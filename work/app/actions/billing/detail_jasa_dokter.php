<script type="text/javascript">
    function getPersenTarif(element){
        id = element.id;
        persen = $('#'+id).val();
        total = $('#t_'+id).val();
        hasil = (persen*total)/100;
        $('#h_'+id).val(hasil);
    }

</script>
<div class="data-list">
<br/><center><h2>.:: DETAIL JASA DOKTER  <?php echo str_replace('_',' ',$_GET['nama']);?>  ::.</h2></center><br/>
 <?php
        require_once 'app/lib/common/master-data.php';
        require_once 'app/lib/common/functions.php';
        $startDate  = date2mysql($_GET['startDate']);
        $endDate    = date2mysql($_GET['endDate']);
 ?>
    <h2>.:: PENERIMAAN JASA DOKTER DENGAN SPECIALIST '<?php echo strtoupper($_GET['spesialist']) ;?>' UNTUK PASIEN UMUM ::.</h2>
    <table style="width: 100%" class="tabel" cellspacing=0>
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
                   <td><?php echo rupiah($record['pemeriksaan']) ;?></td>
                   <td><?php echo rupiah($record['visit']) ;?></td>
                   <td><?php echo rupiah($record['tindakan']) ;?></td>
                   <td><?php echo rupiah($record['konsultasi']) ;?></td>
                   <td><?php echo rupiah($record['medikasi']) ;?></td>
                   <td><?php echo rupiah($total_tindakan_umum) ;?></td>
                </tr>
        <?php
        $tot_pemeriksaan_umum += $record['pemeriksaan']; $tot_visit_umum += $record['visit'];
        $tot_tindakan_umum += $record['tindakan']; $tot_konsultasi_umum += $record['konsultasi']; $tot_medicasi_umum += $record['medikasi'];
        $no++;
        } ?>
                <tr >
                    <td colspan='6' align='center'>Total</td>
                    <td><?= rupiah($tot_pemeriksaan_umum) ;?></td>
                    <td><?= rupiah($tot_visit_umum) ;?></td>
                    <td><?= rupiah($tot_tindakan_umum) ;?></td>
                    <td><?= rupiah($tot_konsultasi_umum) ;?></td>
                    <td><?= rupiah($tot_medicasi_umum) ;?></td>
                    <td><?= rupiah($tot_jumlah_umum) ;?></td>
                </tr>
    </table><br><a class='excel' href="<?php echo app_base_url('billing/report/info-keuangan-dokter/?key=umum&idPen='.$_GET['idPen'].'&nama='.$_GET['nama'].'&startDate='.$startDate.'&endDate='.$endDate.'');?>">Cetak Excel</a><br/><br/>

    <h2>.:: PENERIMAAN JASA DOKTER DENGAN SPECIALIST '<?php echo strtoupper($_GET['spesialist']) ;?>' UNTUK PASIEN PRIBADI ::.</h2>
    <table style="width: 100%" class="tabel" cellspacing=0>
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
                   <td><?php echo rupiah($record['pemeriksaan']) ;?></td>
                   <td><?php echo rupiah($record['visit']) ;?></td>
                   <td><?php echo rupiah($record['tindakan']) ;?></td>
                   <td><?php echo rupiah($record['konsultasi']) ;?></td>
                   <td><?php echo rupiah($record['medikasi']) ;?></td>
                   <td><?php echo rupiah($total_tindakan_pribadi) ;?></td>
                </tr>
        <?php
        $tot_pemeriksaan_pribadi += $record['pemeriksaan']; $tot_visit_pribadi += $record['visit'];
        $tot_tindakan_pribadi += $record['tindakan']; $tot_konsultasi_pribadi += $record['konsultasi']; $tot_medicasi_pribadi += $record['medikasi'];
        $no++;
        } ?>
                <tr >
                    <td colspan='6' align='center'>Total</td>
                    <td><?= rupiah($tot_pemeriksaan_pribadi) ;?></td>
                    <td><?= rupiah($tot_visit_pribadi) ;?></td>
                    <td><?= rupiah($tot_tindakan_pribadi) ;?></td>
                    <td><?= rupiah($tot_konsultasi_pribadi) ;?></td>
                    <td><?= rupiah($tot_medicasi_pribadi) ;?></td>
                    <td><?= rupiah($tot_jumlah_pribadi) ;?></td>
                </tr>
    </table><br><a class=excel href="<?php echo app_base_url('billing/report/info-keuangan-dokter/?key=pribadi&idPen='.$_GET['idPen'].'&nama='.$_GET['nama'].'&startDate='.$startDate.'&endDate='.$endDate.'');?>">Cetak Excel</a><br/><br/>
    <h2>.:: PENERIMAAN JASA DOKTER DENGAN SPECIALIST '<?php echo strtoupper($_GET['spesialist']) ;?>' UNTUK PASIEN JAMKESMAS ::.</h2>
    <table style="width: 100%" class="tabel" cellspacing=0>
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
                   <td><?php echo rupiah($record['pemeriksaan']) ;?></td>
                   <td><?php echo rupiah($record['visit']) ;?></td>
                   <td><?php echo rupiah($record['tindakan']) ;?></td>
                   <td><?php echo rupiah($record['konsultasi']) ;?></td>
                   <td><?php echo rupiah($record['medikasi']) ;?></td>
                   <td><?php echo rupiah($total_tindakan_jamkesmas) ;?></td>
                </tr>
                <?php
                 $tot_pemeriksaan_jamkesmas += $record['pemeriksaan']; $tot_visit_jamkesmas += $record['visit'];
                 $tot_tindakan_jamkesmas += $record['tindakan']; $tot_konsultasi_jamkesmas += $record['konsultasi']; $tot_medicasi_jamkesmas += $record['medikasi'];
                $no++;
        } ?>
                <tr>
                    <td colspan='5' align='center'>Total</td>
                    <td><?= rupiah($tot_pemeriksaan_jamkesmas) ;?></td>
                    <td><?= rupiah($tot_visit_jamkesmas) ;?></td>
                    <td><?= rupiah($tot_tindakan_jamkesmas) ;?></td>
                    <td><?= rupiah($tot_konsultasi_jamkesmas) ;?></td>
                    <td><?= rupiah($tot_medicasi_jamkesmas) ;?></td>
                    <td><?= rupiah($tot_jumlah_jamkesmas) ;?></td>
                </tr>
    </table><br/><a class=excel href="<?php echo app_base_url('billing/report/info-keuangan-dokter/?key=jamkesmas&idPen='.$_GET['idPen'].'&nama='.$_GET['nama'].'&startDate='.$startDate.'&endDate='.$endDate.'');?>">Cetak Excel</a><br/><br/>
    <table style="width: 50%" class="tabel" cellspacing=0>
            <tr>
                <th>No</th>
                <th>Tarif</th>
                <th>Total</th>
                <th>%</th>
                <th>Hasil</th>
            </tr>
            <tr>
                <td>1</td>
                <td>Umum</td>
                <td><input type='text' name='t_umum' id='t_umum' value='<?php echo $tot_jumlah_umum;?>' width='13' readonly='true'></td>
                <td><input type='text' name='umum' id='umum' value='0' size='3' width='3' onkeyup="getPersenTarif(this,'<?php echo $tot_jumlah_umum ;?>');"/></td>
                <td><input type='text' name='h_umum' id='h_umum' value='0' width='15' readonly='true'/></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Pribadi</td>
                <td><input type='text' name='t_pribadi' id='t_pribadi' value='<?php echo $tot_jumlah_pribadi;?>' width='13' readonly='true'></td>
                <td><input type='text' name='pribadi' id='pribadi' value='0' size='4' onkeyup="getPersenTarif(this,'<?php echo $tot_jumlah_pribadi ;?>');"/></td>
                <td><input type='text' name='h_pribadi' id='h_pribadi' value='0' width='15' readonly='true'/></td>
            </tr>
            <tr>
                <td>3</td>
                <td>Jamkesmas</td>
                <td><input type='text' name='t_jamkesmas' id='t_jamkesmas' value='<?php echo $tot_jumlah_jamkesmas;?>' width='13' readonly='true'></td>
                <td><input type='text' name='jamkesmas' id='jamkesmas' value='0' size='4' onkeyup="getPersenTarif(this,'<?php echo $tot_jumlah_jamkesmas ;?>');"/></td>
                <td><input type='text' name='h_jamkesmas' id='h_jamkesmas' value='0' width='15' readonly='true'/></td>
            </tr>

    </table><br/><a class=excel class=tombol href="<?= '#'//app_base_url('#').  generate_get_parameter($_GET);?>">Cetak Excel</a>

</div>
<?php
exit;
?>