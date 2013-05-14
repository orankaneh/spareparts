<?
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';

set_time_zone();

$sort=(isset($_GET['sort']))?$_GET['sort']:null;
$by=(isset($_GET['by']))?$_GET['by']:'asc';
$category = (isset($_GET['kategori']))?$_GET['kategori']:NULL;
$key = (isset($_GET['key']))?$_GET['key']:NULL;

$startDate=(isset($_GET['startDate']))? $_GET['startDate']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
$endDate=(isset($_GET['endDate']))? $_GET['endDate']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
?>
<h1 class="judul">Informasi Kunjungan</h1>

            <div class="data-input pendaftaran">
            <fieldset id="master"><legend>Form pencarian </legend>    

            <form action="<?= app_base_url('admisi/informasi/data-kunjungan')?>" method="get" name="form">

            <fieldset class="field-group">    
                <legend>Awal - akhir periode</legend>
                <input type="text" id="awal" name="startDate" value="<?= $startDate ?>" class="tanggal"/>

                <label for="akhir" class="inline-title"> s . d </label>
                <input type="text" id="akhir" name="endDate" value="<?= $endDate ?>" class="tanggal"/>
            </fieldset>
            <label for="filter">Pilih Kategori</label>
            <select id="kategori" name="kategori">
              <option value="">Pilih kategori</option>
              <option value="1" <?=($category==1)?' selected':'';?>>Nama</option>
              <option value="2" <?=($category==2)?' selected':'';?>>No. RM</option>
            </select>  
            <div id="field-dinamis">

            </div>
         <fieldset class="input-process">
            <input type="submit" value="Display" class="tombol" name="tampil"/>
            <input type="button" value="Cancel" class="tombol" onClick=javascript:location.href="<?= app_base_url('/admisi/informasi/data-kunjungan')?>" />
         </fieldset>
            </form>
            </fieldset>    
            </div>

<?php
if(isset ($_GET['tampil']) && $_GET['tampil'] == "Display"){
set_time_zone();

//membuat link sorting
if($sort=='no_rm' && $by=='asc')
    $no_rm=app_base_url('admisi/informasi/data-kunjungan?startDate='.$startDate.'&endDate='.$endDate.'&sort=no_rm&by=desc');
else
    $no_rm=app_base_url('admisi/informasi/data-kunjungan?startDate='.$startDate.'&endDate='.$endDate.'&sort=no_rm&by=asc');

if($sort=='waktu' && $by=='desc')
    $waktu=app_base_url('admisi/informasi/data-kunjungan?startDate='.$startDate.'&endDate='.$endDate.'&sort=waktu&by=asc');
else
    $waktu=app_base_url('admisi/informasi/data-kunjungan?startDate='.$startDate.'&endDate='.$endDate.'&sort=waktu&by=desc');

if($sort=='nama' && $by=='asc')
    $nama=app_base_url('admisi/informasi/data-kunjungan?startDate='.$startDate.'&endDate='.$endDate.'&sort=nama&by=desc');
else
    $nama=app_base_url('admisi/informasi/data-kunjungan?startDate='.$startDate.'&endDate='.$endDate.'&sort=nama&by=asc');

$startDate=date2mysql($startDate);
$endDate=date2mysql($endDate);

if($sort==null)
    $kunjungan = kunjungan_rj_muat_data(null,$startDate,$endDate,$category,$key);
else
    $kunjungan = kunjungan_rj_muat_data(null,$startDate,$endDate,$category,$key,$sort,$by);
?>
<div class="data-list">
<table cellpadding="0" cellspacing="0" border="0" id="table" class="tabel">
		
    <tr>
        <th><a href="<?= $waktu?>" class="sorting">Tanggal</a></th>
        <th>Layanan</th>
        <th>Nakes</th>
        <th><a href="<?=$no_rm?>" class="sorting">No. RM</a></th>
        <th><a href="<?=$nama?>" class="sorting">Nama</a></th>
        <th>Sex</th>
        <th>Umur (Thn)</th>
        <th>Pernikahan</th>
        <th>No. Kunjungan</th>
        <th>Aksi</th>
    </tr>
    <?php foreach($kunjungan as $num => $row):
        if($row['tanggal'] == ""){
            echo "";
        }else{
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


        $layanan = "".$row['layanan']." $profesi $spesialisasi $bobot $instalasi";
                
	if($row['aidi'] == 4)
        $preview	= 'lembar-ugd-depan';
    else
		$preview	= 'lembar-poliklinik';
	?>
    <tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
        <td align="center" style="width:10%"><?= datefmysql($row['waktu'])." ".$row['jam'] ?></td>
     
	<td align="center"><?= $layanan ?></td>
       <td align="center"><?= $row['dokter'] ?></td>
        <td align="center"><a href="<?= app_base_url('admisi/detail-kunjungan')?>?id=<?= $row['id_kunjungan']?>" class=link title="Detail"><?= $row['no_rm'] ?></a></td>
        <td class="no-wrap" style="width:20%"><a href="<?= app_base_url('admisi/detail-kunjungan')?>?id=<?= $row['id_kunjungan']?>" class=link title="Detail"><?= $row['nama'] ?></a></td>
        <td align="center"><?= $row['jenis_kelamin'] ?></td>
        <td align="center" style="width:5%"><?= hitungUmur2($row['tanggal_lahir']) ?></td>
        <td class="no-wrap" style="width:5%"><?= $row['perkawinan'] ?></td>
        <td align="center" style="width:8%"><?= $row['no_kunjungan_pasien'] ?></td>
        <td class="aksi" align="center" style="width:20%">
            <span class="cetak" onclick="window.open('<?=  app_base_url("admisi/$preview?idKunjungan=".$row['id_kunjungan']."") ?>','mywindow','location=1,status=1,scrollbars=1,width=800px')">Lembar Pertama RM</span>
            <span class="cetak" onclick="window.open('<?=  app_base_url("admisi/print/kartu-antrian?id=".$row['id_kunjungan']."") ?>','mywindow','location=1,status=1,scrollbars=1,width=260px,height=380px')">Kartu Antrian</span>
        </td>
    </tr>
    <?php } endforeach; ?>
            
</table>
</div>    
<span class="error"></span>
<div class='table-report-admisi'></div>
<span class="cetak" onclick="window.open('<?=  app_base_url('admisi/informasi/data-kunjungan-rep?').  generate_get_parameter($_GET)?>','popup','width=1000','height=850')">Cetak</span>
<a class=excel class=tombol href="<?=app_base_url('admisi/informasi/excel/data-kunjungan-rep?').  generate_get_parameter($_GET)?>">Cetak</a>

<?php
}
?>
<script type="text/javascript">
    var counter=0;
     $(document).ready(function(){
      $('#kategori').change(function(){
            counter++;
            var tipe = $(this).val();
            $.get('<?=app_base_url('/admisi/informasi/komponen')?>',{kategori:tipe,key:'<?=$key?>'},function(data){
                $('#field-dinamis').html(data);
                if (counter<2){
                <?php
                  if($category==1){
                      echo "$('#nama').attr('value','$key');";
                  }else{
                      echo "$('#noRm').attr('value','$key');";
                  }  
                  
                ?>
                }                    
            });
     })
     
     <?php
        if(isset($_GET['kategori'])){
            echo '$("#kategori").change();
                ';
        }    
     ?>
 }) 
</script>    