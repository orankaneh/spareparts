<?php
require_once 'app/lib/common/master-data.php';
include 'app/actions/admisi/pesan.php';
$id = isset($_GET['id']) ? $_GET['id'] : NULL;
$key = isset($_GET['key']) ? $_GET['key'] : NULL;
$page = isset($_GET['page']) ? $_GET['page'] : NULL;
$dataPerPage=15;

$sort = isset ($_GET['sort'])?$_GET['sort']:NULL;
$sortBy = isset ($_GET['sortBy'])?$_GET['sortBy']:NULL;
$tarif = tarif_muat_data($id, $page, $dataPerPage, $key, $sort, $sortBy);
$no=nomer_paging($page, $dataPerPage);
//show_array($tarif['list']);
$kelas = kelas_muat_data();
$searcing='';
if (get_value('key')!=''){
if($searcing=''){
$searcing="key=".get_value('key');
}
else{
$searcing='';
}
}
?>
<div class="judul"><a href="<?= app_base_url('admisi/data-tarif') ?>">Administrasi Tarif</a></div><? echo isset($pesan) ? $pesan : NULL; 
if (isset($_GET['do'])) {
    if ($_GET['do'] == 'add') {
            require_once 'app/actions/admisi/add-tarif.php';
    }
    else if ($_GET['do'] == 'edit') {
            require_once 'app/actions/admisi/edit-tarif.php';
    }
}
?>
<br/>
<script type="text/javascript">
    function cekform(data) {
        if (data.tarif.value == "") {
            alert('Data tarif masih kosong');
            data.tarif.focus();
            return false;
        }
        if (data.harga.value == "") {
            alert('Data harga masih kosong');
            data.harga.focus();
            return false;
        }
        if (data.kelas.value == "") {
            alert('Data kelas masih kosong');
            data.kelas.focus();
            return false;
        }
    }
    
    $(document).ready(function(){
    
        $(".block").mouseout(function(event){
            var index=$(".block").index($(this));
            $("span.tooltip").eq(index).mouseout();
            
        });
    
        
   });
</script>
<div class="data-list" style="overflow: auto">
    <div class="floleft" style="margin: 10px 0">
        <a href="<?= app_base_url('admisi/data-tarif/?do=add')?>" class="add"><div class="icon button-add"></div>Tambah</a>
    </div>
    <div class="floright">
        <form action="" method="GET" class="search-form">
            <span style="float: right">Nama Layanan: <input type="text" name="key" class="search-input" id="keyword" value="<?= $key ?>"/><input type="submit" value="" class="search-button"/></span>
        </form> 
    </div>
    <div>
        <table cellpadding="0" cellspacing="0" id="table" class="tabel" style="width:100%">
            <tr>
                <th rowspan="4" style="vertical-align:middle">NO</th>
                <th rowspan="4" style="vertical-align:middle">Nama</th>
                <th colspan="11">Biaya</th>
                <th rowspan="4" style="vertical-align:middle">Total Biaya</th>
                <th rowspan="1" colspan="2">Profit</th>

                <th rowspan="4" style="vertical-align:middle">Total Tarif</th>
                <th rowspan="4" style="vertical-align:middle">Status</th>
                <th rowspan="4" style="width: 10%;vertical-align: middle">Aksi</td>    
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
            <?php
            foreach ($tarif['list'] as $num => $row):
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
                    <td align=center><?= $no++?></td>
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
                          echo ($row['status']=="Tidak")?"<a href='#' class='nonaktif' style='cursor:default'><small>Tidak Berlaku</small></a>":"<a href='#' class='aktif' style='cursor:default'><small>Berlaku</small></a>";
                        ?>
                    </td>
                    <td align=center class="aksi">
                        <a href="<?= app_base_url('/admisi/data-tarif?do=edit&code=' . $row['id'] . '') ?>" class="edit"><small>edit</small></a>
                        <a href="<?= app_base_url('/admisi/control/tarif/delete?id=' . $row['id'] . '') ?>" class="delete"><small>delete</small></a>
                        <a href="<?= app_base_url('/admisi/detail-tarif/?id=' . $row['id'] . '') ?>" class="detail"><small>detail</small></a>
                    </td>
                </tr>
            <?php endforeach; ?>

        </table>
    </div>
</div>
<a class=excel class=tombol href="<?=app_base_url('admisi/informasi/excel/tarif?').  generate_get_parameter($_GET)?>">Cetak</a><p></p>
<?= $tarif['paging'] ?>