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
$retur = retur_muat_data($id = null, $startDate, $endDate, $idSuplier, $idPegawai);
?>
<h2 class="judul">Informasi Retur Pembelian</h2><?= isset($pesan) ? $pesan : NULL ?>
<script type="text/javascript">
    $(function() {
        $('#suplier').autocomplete("<?= app_base_url('/inventory/search?opsi=suplier') ?>",
        {
            parse: function(data){
                var parsed = [];
                for (var i=0; i < data.length; i++) {
                    parsed[i] = {
                        data: data[i],
                        value: data[i].nama_kelurahan // nama field yang dicari
                    };
                }
                return parsed;
            },
            formatItem: function(data,i,max){
                $('#idSuplier').removeAttr('value');
                var str='<div class=result>'+data.nama+' <br/><i> '+data.alamat+' , '+data.nama_kelurahan+'</i></div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $('#suplier').attr('value',data.nama);
            $('#idSuplier').attr('value',data.id);
        }
    );
    })    
            
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
            <label for="suplier">Suplier</label><input type="text" id="suplier" name="suplier" value="<?= $supplier ?>"/><input type="hidden" name="idSuplier" id="idSuplier" value="<?= $idSuplier ?>"/>
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
            <th style="width: 10%">No. Surat</th>
            <th>Tanggal</th>
            <th>Suplier</th>
            <th>Pegawai</th>
            <th>Aksi</th>
            <?$i=1;
            foreach ($retur as $row) {
                ?>
                <tr class="<?= ($i++ % 2) ? 'odd' : 'even' ?>">
                    <td><?= $row['nosurat'] ?></td>
                    <td><?= showWaktuFromMysql($row['waktu']) ?></td>
                    <td><?= $row['suplier'] ?></td>
                    <td><?= $row['pegawai'] ?></td>
                    <td align="center" class="aksi"><a href="<?= app_base_url('inventory/info-retur-pembelian') . "?nosurat=$row[nosurat]&" . generate_get_parameter($_GET, array(), array('nosurat')) ?>" class="detail">detail</a></td>
                </tr>
                <?
            }
            ?>
        </table>
            <? if (count($retur)!=0){?>
<a class=excel class=tombol href="<?=app_base_url('inventory/report/retur-excel?').  generate_get_parameter($_GET)?>">Cetak</a>
<? } ?>
    </div>
<?
}
if (isset($_GET['nosurat'])) {
    ?>
<br>No Surat: <?= $_GET['nosurat'] ?>    
    <div class="data-list">
        <table class="tabel" style="width: 60%">
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Batch</th>
                <th>No Faktur</th>
                <th>Jumlah Retur</th>
                <th>Jumlah Reretur</th>
                <th>Alasan</th>
            </tr>
            <?
            $list = detail_retur_muat_data($_GET['nosurat']);
            $i = 0;
            foreach ($list as $row) {
                $nama = "$row[barang]";
                if (($row['generik'] == 'Generik') || ($row['generik'] == 'Non Generik')) {
                    $nama.= ( $row['kekuatan'] != 0) ? " $row[kekuatan], $row[sediaan]" : " $row[sediaan]";
                }
                $nama .=" @$row[nilai_konversi] $row[satuan_terkecil]";
                $nama.= ( $row['generik'] == 'Generik') ? ' ' . $row['pabrik'] : '';

                $kekuatan = ($row['kekuatan'] != null) ? $row['kekuatan'] . ',' : '';
                $sediaan = ($row['sediaan'] != null) ? $row['sediaan'] : '';
                $i++;
                ?>    <tr class="<?= ($i % 2) ? 'odd' : 'even' ?>">
                    <td align="center"><?= $i ?></td>
                    <td class="no-wrap"><?= $nama ?></td>
                    <td align="center"><?= $row['batch_retur'] ?></td>
                    <td align="center"><?= $row['no_faktur'] ?></td>
                    <td align="center"><?= $row['jumlah_retur'] ?></td>
                    <td align="center"><?= $row['jumlah_reretur'] ?></td>
                    <td align="left"><?= $row['alasan'] ?></td>
                </tr>
                <?
            }
            ?>
        </table><br>
    </div>
    <?
}
?>
