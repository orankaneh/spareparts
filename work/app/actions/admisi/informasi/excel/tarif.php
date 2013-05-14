<?
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';
require_once 'app/config/db.php';
set_time_zone();
include_css_excel_report();
header_excel("Tarif.xls");
$id = isset($_GET['id']) ? $_GET['id'] : NULL;
$key = isset($_GET['key']) ? $_GET['key'] : NULL;
$page = isset($_GET['page']) ? $_GET['page'] : NULL;
$dataPerPage=15000000;
$sort = isset ($_GET['sort'])?$_GET['sort']:NULL;
$sortBy = isset ($_GET['sortBy'])?$_GET['sortBy']:NULL;
$tarif = tarif_muat_data($id, $page, $dataPerPage, $key, $sort, $sortBy);
$kelas = kelas_muat_data();
set_time_zone();

?>
  
  <?require_once 'app/actions/admisi/lembar-header-excel.php';?> 
  <center>Administrasi Tarif</center>
<div class="data-list">
 <table cellpadding="0" cellspacing="0" id="table" class="tabel" style="width:100%">
            <tr>
                <th rowspan="4" style="vertical-align:middle"><a href="<?= app_base_url('admisi/data-tarif/?'.$searcing.generate_sort_parameter(1, $sortBy))?>" class="sorting">NO</a></th>
                <th rowspan="4" style="vertical-align:middle">Nama</th>
                <th colspan="11">Biaya</th>
                <th rowspan="4" style="vertical-align:middle">Total Biaya</th>
                <th rowspan="1" colspan="2">Profit</th>

                <th rowspan="4" style="vertical-align:middle">Total Tarif</th>
                <th rowspan="4" style="vertical-align:middle">Status</th>
   
            </tr>    
            <tr>
                <th rowspan="3" style="vertical-align:middle">J.S (Rp.)</th>
                <th rowspan="3" style="vertical-align:middle">B.H.P (Rp.)</th>
                <th colspan="9">Nakes (Rp.)</th>
                <th rowspan="3" style="vertical-align:middle"  style="width: 50px">(%)</th>
                <th rowspan="3" style="vertical-align:middle"  style="width: 50px">(Rp.)</th>
            </tr>
            <tr>
                <th colspan="3">Utama</th>
                <th colspan="3">Pendukung</th>
                <th colspan="3">Pendamping</th>
            </tr>
            <tr>
                <th style="width: 50px">Nakes</th>
                <th style="width: 50px">RS</th>
                <th style="width: 50px">Total</th>
                <th style="width: 50px">Nakes</th>
                <th style="width: 50px">RS</th>
                <th style="width: 50px">Total</th>
                <th style="width: 50px">Nakes</th>
                <th style="width: 50px">RS</th>
                <th style="width: 50px">Total</th>
            </tr>
   <? foreach ($tarif['list'] as $num => $row):
                $layanan = "";
                $layanan.= $row['layanan'];

                if ($row['profesi'] == 'Tanpa Profesi')
                    $layanan.= "";
                else
                    $layanan.=" $row[profesi]";

                if ($row['spesialisasi'] == 'Tanpa Spesialisasi')
                    $layanan.= "";
                else
                    $layanan.=" $row[spesialisasi]";

                if ($row['bobot'] == 'Tanpa Bobot')
                    $layanan.= "";
                else
                    $layanan.=" $row[bobot]";

                if ($row['jenis'] == "Rawat Inap")
                    $layanan.=" $row[instalasi]";
                else if ($row['instalasi'] == 'Rekam Medik' || $row['instalasi'] == 'Semua' || $row['instalasi'] == 'Tanpa Instalasi')
                    $layanan.= "";
                else
                    $layanan.=" $row[instalasi]";

                if ($row['kelas'] == 'Tanpa Kelas')
                    $layanan.= "";
                else
                    $layanan.=" $row[kelas]";
                ?>
       <tr class="<?= ($num % 2) ? 'even' : 'odd' ?>">
                    <td align=center><?= ++$num ?></td>
                    <td class="no-wrap"><?= $layanan ?></td>
                    <td class="no-wrap" align="right"><?= rupiah($row['jasa_sarana']) ?></td>
                    <td class="no-wrap" align="right"><?= rupiah($row['bhp']) ?></td>
                    <td class="no-wrap" align="right">
                        <?php
                        $nakesUtama = ($row['total_utama'] * $row['persen_nakes_utama']) / 100;
                        echo rupiah($nakesUtama);
                        ?>
                    </td>
                    <td class="no-wrap" align="right">
                        <?php
                        $rsUtama = ($row['total_utama'] * $row['persen_rs_utama']) / 100;
                        echo rupiah($rsUtama);
                        ?>
                    </td>
                    <td class="no-wrap" align="right"><?= rupiah($row['total_utama']) ?></td>
                    <td class="no-wrap" align="right">
                        <?php
                        $nakesPendukung = ($row['total_pendukung'] * $row['persen_nakes_pendukung']) / 100;
                        echo rupiah($nakesPendukung);
                        ?>
                    </td>
                    <td class="no-wrap" align="right">
                        <?php
                        $rsPendukung = ($row['total_pendukung'] * $row['persen_rs_pendukung']) / 100;
                        echo rupiah($rsPendukung);
                        ?>
                    </td>
                    <td class="no-wrap" align="right"><?= rupiah($row['total_pendukung']) ?></td>
                    <td class="no-wrap" align="right">
                        <?php
                        $nakesPendamping = ($row['total_pendamping'] * $row['persen_nakes_pendamping']) / 100;
                        echo rupiah($nakesPendamping);
                        ?>
                    </td>
                    <td class="no-wrap" align="right">
                        <?php
                        $rsPendamping = ($row['total_pendamping'] * $row['persen_rs_pendamping']) / 100;
                        echo rupiah($rsPendamping);
                        ?>
                    </td>
                    <td class="no-wrap" align="right"><?= rupiah($row['total_pendamping']) ?></td>
                    <td class="no-wrap" align="right">  
                        <?php
                        $total = ($row['jasa_sarana'] + $row['bhp'] + $row['total_utama'] + $row['total_pendukung'] + $row['total_pendamping']);
                        echo rupiah($total);
                        ?>
                    </td>
                    <td class="no-wrap"><?= $row['persen_profit'] ?></td>
                    <td class="no-wrap" align="right"><?= rupiah($total * $row['persen_profit'] / 100) ?></td>
                    <td class="no-wrap" align="right">
                        <?= rupiah($row['total']) ?>
                    </td>
                    <td class="aksi">
                        <?
                          echo ($row['status']=="Tidak")?"Tidak Berlaku":"Berlaku";
                        ?>
                    </td>
                  
                </tr>
            <?php endforeach; ?>
</table>

</div>
<?exit;?>
