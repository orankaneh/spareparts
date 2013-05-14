<?php
require_once 'app/lib/common/master-data.php';
$noKunjunganPasien = isset ($_GET['no_kunjungan_pasien'])?$_GET['no_kunjungan_pasien']:null;
$norm = isset($_GET['norm'])?$_GET['norm']:null;
$idBilling = isset($_GET['billing'])?$_GET['billing']:null;
$idKunjungan = isset($_GET['idKunjungan'])?$_GET['idKunjungan']:null;
$cek = cek_rawat_inap($norm, $noKunjunganPasien);
$code=isset ($code)?$code:null;
if($cek['jumlah'] != 0&&$code==null){
?>
<script type="text/javascript">
    $(document).ready(function(){
        alert('Maaf, tidak ada data pendaftaran untuk pasien tersebut');
        $('#pasien').attr('value','');
        $('#idKunjungan').attr('value','');
        $('#noRm').val('');
        $('#billing').val('');
        $('#noKunjunganPasien').val('');
    })  
</script>

<?php
}else{
    if($code!=null){
        $norm=$code;
    }
$rawatInap = rawat_inap_undischarge($norm);
if(count($rawatInap) > 0){
    $waktu = $rawatInap[0]['tanggal'].' '.$rawatInap[0]['jam'];
    $id_detail_billing = last_detail_billing($idBilling,$waktu);
}
if(count($rawatInap) > 0){
?>
<div class="data-list">
<table class="tabel">
    <tr>
        <th>No</th>
        <!--<th>Tanggal</th>-->
      <!--   <th>Nama Pasien</th>-->
        <th>Layanan</th>
        <th>Nama Dokter</th>
        <th>No. Bed</th>
        <th>Kelas</th>
        <th>Aksi</th>
    </tr>
    <?php
     $no = 1;
     foreach ($rawatInap as $row){
       if ($row['bobot'] == 'Tanpa Bobot') $bobot = "";
                else $bobot = $row['bobot'];

        if ($row['profesi'] == 'Tanpa Profesi') $profesi = "";
        else $profesi = $row['profesi'];

        $spesialisasi = "";
        if ($row['spesialisasi'] == 'Tanpa Spesialisasi') $spesialiasi= "";
        else $spesialisasi = $row['spesialisasi'];

        if ($row['instalasi'] == 'Tanpa Instalasi') $instalasi= "";
        else if ($row['instalasi'] == 'Semua') $instalasi = "";
        else $instalasi = $row['instalasi'];


        $layanan = "$row[layanan] $profesi $spesialisasi $bobot $instalasi";  
    ?>
    <tr>
        <td width="5%" align="center"><?php echo $no++?></td>
     <!--   <td width="15%" align="center"><?php //echo datefmysql($row['tanggal'])." ".$row['jam']?></td>-->
        <!-- <td width="15%"><?php// echo $row['pasien']?></td>-->
        <td width="20%"><?php echo "$layanan";?></td>
        <td width="15%"><?php echo $row['dokter']?></td>
        <td width="5%"><?php echo $row['bed']?></td>
        <td width="5%"><?php echo $row['kelas']?></td>
           
          <td width="10%">
              <?php
                if($code==null){
              ?> 
              <span class="discharge"><!--<a href="<?=app_base_url('admisi/control/discharge?idBilling=').$idBilling."&idKunjungan=".$idKunjungan."&idTarif=".$id_detail_billing['id_tarif']?>" onClick="return confirm('Apakah Anda yakin akan mendischarge pasien berikut?')">Discharge</a></span>-->
              <span class='cetak' id='cetak' style='margin-left: 10px'>Cetak Gelang</span>
                 <? 
      
                }else{
                    echo 'Discharged';
                }
            ?>
          </td>
    </tr>
       <script type="text/javascript">
    $(document).ready(function(){
        $("#cetak").click(function(){
            var win = window.open('print/wristbands?norm=<?= isset($_GET['norm'])?$_GET['norm']:null ?>', 'MyWindow', 'width=800px,height=600px,scrollbars=1');
        })
    })
</script>  
    </tr>
    <?php
     }
    ?>
</table>
</div>    
<?php
}
}
if($code==null){
    exit();
}

?>
