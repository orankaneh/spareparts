<?php
include_once "app/lib/common/functions.php";
require_once "app/lib/common/master-data.php";

include_once "assets/graph/jpgraph.php";
include_once "assets/graph/jpgraph_bar.php";
include_once "assets/graph/jpgraph_line.php";

$startDate      = (isset($_GET['awal'])) ? $_GET['awal'] : null;
$endDate        = (isset($_GET['akhir'])) ? $_GET['akhir'] : null;
$startDateMysql = ($startDate != NULL) ? date2mysql($startDate) : null;
$endDateMysql   = ($endDate != NULL) ? date2mysql($endDate) : null;
$thawal         = isset($_GET['awal']) ? $_GET['awal'] : null;
$thakhir        = isset($_GET['akhir']) ? $_GET['akhir'] : null;
$jumlah = isset ($_GET['jumlah_baris'])?$_GET['jumlah_baris']:10;
$jenis = isset ($_GET['jenis'])?$_GET['jenis']:"";
$blnAwal = isset ($_GET['bln1'])?blnAngka($_GET['bln1']):NULL;
$blnAkhir = isset ($_GET['bln2'])?blnAngka($_GET['bln2']):NULL;

echo "<div class='data-list'>";
if($_GET['period'] == 1){
?>
<fieldset>
    <img src="<?= app_base_url('assets/images/10-besar-penyakit-harian.png');?>" /> <br />
    <table id="grafik" class="tabel" cellspacing="0" cellpadding="0" border="0">
         <tr>
            <th>No</th> 
            <th>Kode ICD 10</th>
            <th>Nama Penyakit</th>
            <th>Jumlah Kasus</th>
         </tr>       
        <?php 
          $penyakit = array();
          $jumlah = array();

          $no = 1;
          $top10penyakit = top10_muat_data($startDate,$endDate,$jumlah,$jenis);
          foreach($top10penyakit['master'] as $rows):
          array_unshift($penyakit, $rows['kode_icd_10']);
          array_unshift($jumlah, $rows['jumlah']);
        ?>
            <tr class="<?php echo ($no%2)?"even":"odd";?>">
                <td><?= $no?></td>
                <td><?= $rows['kode_icd_10']?></td>
                <td><?= $rows['penyakit']?></td>
                <td><?= $rows['jumlah']?></td>
            </tr>
        <?php
          $no++;
        endforeach; 
        ?>
    </table>
    <?php
        $count = count($top10penyakit);
        if($count > 0){
            grafik($top10penyakit['max'],$penyakit, $jumlah, "Grafik 10 Besar Penyakit Harian", "Kode ICD 10", "Jumlah Kasus", "10-besar-penyakit-harian");
        }
    ?>
</fieldset>
<?php
}else if($_GET['period'] == 2){
?>
<fieldset>
    <img src="<?= app_base_url('assets/images/10-besar-penyakit-mingguan.png');?>" /> <br />
    <table id="grafik" class="tabel" cellspacing="0" cellpadding="0" border="0">
         <tr>
            <th>No</th> 
            <th>Kode ICD 10</th>
            <th>Nama Penyakit</th>
            <th>Jumlah Kasus</th>
         </tr>       
        <?php 
          $penyakit = array();
          $jumlah = array();

          $no = 1;
          $top10penyakit = top10_muat_data($startDate,$endDate,$jumlah,$jenis);
          foreach($top10penyakit['master'] as $rows):
          array_unshift($penyakit, $rows['kode_icd_10']);
          array_unshift($jumlah, $rows['jumlah']);
        ?>
            <tr class="<?php echo ($no%2)?"even":"odd";?>">
                <td><?= $no?></td>
                <td><?= $rows['kode_icd_10']?></td>
                <td><?= $rows['penyakit']?></td>
                <td><?= $rows['jumlah']?></td>
            </tr>
        <?php
          $no++;
        endforeach; 
        ?>
    </table>
    <?php
        $count = count($top10penyakit);
        if($count > 0){
            grafik($top10penyakit['max'],$penyakit, $jumlah, "Grafik 10 Besar Penyakit Mingguan", "Kode ICD 10", "Jumlah Kasus", "10-besar-penyakit-mingguan");
        }
    ?>
</fieldset>
<?php
}else if($_GET['period'] == 3){
?>
<fieldset>
    <img src="<?= app_base_url('assets/images/10-besar-penyakit-bulanan.png');?>" /> <br />
    <table id="grafik" class="tabel" cellspacing="0" cellpadding="0" border="0">
         <tr>
            <th>No</th> 
            <th>Kode ICD 10</th>
            <th>Nama Penyakit</th>
            <th>Jumlah Kasus</th>
         </tr>       
        <?php 
          $penyakit = array();
          $jumlah = array();

          $no = 1;
          $tanggalAwal = "01/".$blnAwal."/".$thawal;
          if($blnAkhir == 2){
              if($thakhir%4 == 0){
                  $tglAkhir = 29;
              }else $tglAkhir = 28;
          }else if($blnAkhir == 1 || $blnAkhir == 3 || $blnAkhir == 5 || $blnAkhir == 6 || $blnAkhir == 8 || $blnAkhir == 10 || $blnAkhir == 12){
              $tglAkhir = 31;
          }else $tglAkhir = 30;
          $tanggalAkhir = $tglAkhir."/".$blnAkhir."/".$thakhir;
          
          $top10penyakit = top10_muat_data($tanggalAwal,$tanggalAkhir,$jumlah,$jenis);
          foreach($top10penyakit['master'] as $rows):
          array_unshift($penyakit, $rows['kode_icd_10']);
          array_unshift($jumlah, $rows['jumlah']);
        ?>
            <tr class="<?php echo ($no%2)?"even":"odd";?>">
                <td><?= $no?></td>
                <td><?= $rows['kode_icd_10']?></td>
                <td><?= $rows['penyakit']?></td>
                <td><?= $rows['jumlah']?></td>
            </tr>
        <?php
          $no++;
        endforeach; 
        ?>
    </table>
    <?php
        $count = count($top10penyakit);
        if($count > 0){
            grafik($top10penyakit['max'],$penyakit, $jumlah, "Grafik 10 Besar Penyakit Bulanan", "Kode ICD 10", "Jumlah Kasus", "10-besar-penyakit-bulanan");
        }
    ?>
</fieldset>
<?
}else if($_GET['period'] == 4){
?>
<fieldset>
    <img src="<?= app_base_url('assets/images/10-besar-penyakit-tahunan.png');?>" /> <br />
    <table id="grafik" class="tabel" cellspacing="0" cellpadding="0" border="0">
         <tr>
            <th>No</th> 
            <th>Kode ICD 10</th>
            <th>Nama Penyakit</th>
            <th>Jumlah Kasus</th>
         </tr>       
        <?php 
          $penyakit = array();
          $jumlah = array();

          $no = 1;
          $tanggalAwal = "01/01/".$thawal;
          $tanggalAkhir = "31/12/".$thakhir;
          $top10penyakit = top10_muat_data($tanggalAwal,$tanggalAkhir,$jumlah,$jenis);
          foreach($top10penyakit['master'] as $rows):
          array_unshift($penyakit, $rows['kode_icd_10']);
          array_unshift($jumlah, $rows['jumlah']);
        ?>
            <tr class="<?php echo ($no%2)?"even":"odd";?>">
                <td><?= $no?></td>
                <td><?= $rows['kode_icd_10']?></td>
                <td><?= $rows['penyakit']?></td>
                <td><?= $rows['jumlah']?></td>
            </tr>
        <?php
          $no++;
        endforeach; 
        ?>
    </table>
    <?php
        $count = count($top10penyakit);
        if($count > 0){
            grafik($top10penyakit['max'],$penyakit, $jumlah, "Grafik 10 Besar Penyakit Tahunan", "Kode ICD 10", "Jumlah Kasus", "10-besar-penyakit-tahunan");
        }
    ?>
</fieldset>
<?php
if (empty($_GET['cetak'])) {
?>
<br />
<span class=cetak onclick="window.open('<?= app_base_url('rekam-medik/informasi/info-10-besar-penyakit-popup?cetak=1') . "&" . generate_get_parameter($_GET) ?>','popup','width=1000','height=650')">Cetak</span>
<a class="excel" href="<?= app_base_url('rekam-medik/informasi/excel/info-10-besar-penyakit?cetak=1') . "&" . generate_get_parameter($_GET) ?>">Cetak</a>
<?php
}    
}
echo "</div>";
?>
