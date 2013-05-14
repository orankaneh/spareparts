<?php
include_once "app/lib/common/functions.php";
include_once "app/lib/common/master-inventory.php";
include_once "app/lib/common/master-data.php";
include 'app/actions/admisi/pesan.php';
set_time_zone();
$startDate = (isset($_GET['awal'])) ? $_GET['awal'] : Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$endDate = (isset($_GET['akhir'])) ? $_GET['akhir'] : Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$idSuplier = isset($_GET['idSuplier']) ? $_GET['idSuplier'] : NULL;
$supplier = isset($_GET['suplier']) ? $_GET['suplier'] : NULL;
$nofaktur = isset($_GET['nofaktur']) ? $_GET['nofaktur'] : NULL;
$pegawai = isset($_GET['pegawai']) ? $_GET['pegawai'] : NULL;
$idPegawai = isset($_GET['idPegawai']) ? $_GET['idPegawai'] : NULL;
$nosurat=get_value('nosurat');
$reretur = reretur_muat_data($id = null, $startDate, $endDate, $idPegawai,$nosurat);
?>
<h2 class="judul">Informasi Pengembalian Retur Pembelian</h2><?= isset($pesan) ? $pesan : NULL ?>
<script type="text/javascript">
    $(function() {
        $('#pegawai').autocomplete("<?= app_base_url('/admisi/search?opsi=pegawai_info') ?>",
        {
            parse: function(data){
                var parsed = [];
                for (var i=0; i < data.length; i++) {
                    parsed[i] = {
                        data: data[i],
                        value: data[i].nama // nama field yang dicari
                    };
                }
                return parsed;
            },
            formatItem: function(data,i,max){
                $('#idPegawai').attr('value','');
                var str='<div class=result>'+data.nama+'<br />'+data.alamat_jalan+'</div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.nama);
            $('#idPegawai').attr('value',data.id_pegawai);
        }
    );
    });
</script>
<div class="data-input">
    <fieldset><legend>Parameter Pencarian</legend>
        <form action="" method="get">
            <fieldset class="field-group">
                <legend>Tanggal</legend>
                <input type="text" name="awal" class="tanggal" id="awal" value="<?= $startDate ?>" /><label class="inline-title">s . d &nbsp;</label><input type="text" name="akhir" class="tanggal" id="akhir" value="<?= $endDate ?>" />
            </fieldset>
            <label for="suplier">Id</label><input type="text" id="no_surat" name="suplier" value="<?= $nosurat ?>"/>
            <label for="pegawai">Pegawai</label><input type="text" name="pegawai" id="pegawai" value="<?= $pegawai ?>"><input type="hidden" name="idPegawai" id="idPegawai" value="<?= $idPegawai ?>">
            <fieldset class="input-process">
                <input type="submit" name="cari" value="Cari" class="tombol" /> 
                <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/info-retur-pembelian') ?>'"/>
            </fieldset>
        </form>
    </fieldset>
</div>
<? if (isset($_GET['cari'])) { ?>
    <div class="data-list">
        <table class="tabel">
            <th style="width: 10%">Id</th>
            <th>Tanggal</th>
            <th>Suplier</th>
            <th>Pegawai</th>
            <th>Aksi</th>
            <?$i=1;
            foreach ($reretur as $row) {
                ?>
                <tr class="<?= ($i++ % 2) ? 'odd' : 'even' ?>">
                    <td><?= $row['no_surat'] ?></td>
                    <td><?= showWaktuFromMysql($row['waktu']) ?></td>
                    <td><?= $row['suplier'] ?></td>
                    <td><?= $row['pegawai'] ?></td>
                    <td align="center" class="aksi"><a href="<?= app_base_url('inventory/info-reretur-pembelian') . "?id=$row[id]&" . generate_get_parameter($_GET, array(), array('id')) ?>" class="detail">detail</a></td>
                </tr>
                <?
            }
            ?>
        </table>
           <? if (count($reretur)!=0){?>
<a class=excel class=tombol href="<?=app_base_url('inventory/report/reretur--excel?').  generate_get_parameter($_GET)?>">Cetak</a>
<? } ?>
    </div>
<?
}
if (isset($_GET['id'])) {
    ?>
<br>ID: <?= $_GET['id'] ?>    
    <?
$detail = detail_reretur_muat_data($_GET['id']);
?>
<div class="data-list">
    <table class="tabel" id="tblPembelian" cellspacing="0" cellpadding="0" style="width: 100%;">
        <tr>
            <th style="width: 2%">No</th>
            <th style="width: 40%">Nama Barang</th>
            <th style="width: 10%">No Faktur</th>
            <th style="width: 10%">No Batch</th>
            <th style="width: 5%">Jumlah Retur</th>
            <th style="width: 5%">Jumlah Reretur</th>
            <th style="width: 5%">Bentuk</th>
            <th style="width: 10%">Kemasan</th>
        </tr>
        <?
        $i = 1;
        foreach ($detail as $row) {
            $nama = "$row[barang]";
            if (($row['generik'] == 'Generik') || ($row['generik'] == 'Non Generik')) {
                $nama.= ( $row['kekuatan'] != 0) ? " $row[kekuatan], $row[sediaan]" : " $row[sediaan]";
            }
            $nama .=" @$row[nilai_konversi] $row[satuan_terkecil]";
            $nama.= ( $row['generik'] == 'Generik') ? ' ' . $row['pabrik'] : '';

            $kekuatan = ($row['kekuatan'] != null) ? $row['kekuatan'] . ',' : '';
            $sediaan = ($row['sediaan'] != null) ? $row['sediaan'] : '';
            ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $nama ?></td>
                <td><?=$row['no_faktur']?></td>
                <td><?=$row['batch_reretur']?></td>
                <td><?=$row['jumlah_retur']?></td>
                <td><?=$row['jumlah_reretur']?></td>
                <td><?=$row['bentuk']?></td>
                <td><?=$row['satuan_terbesar']?></td>
            </tr>
            <?
        }
        ?>
    </table>

</div>
    <?
}
?>
