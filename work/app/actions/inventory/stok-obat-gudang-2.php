<?
include_once "app/lib/common/functions.php";
include 'app/actions/admisi/pesan.php';
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/pf/obat.php';
require_once 'app/lib/pf/farmakologi.php';
set_time_zone();
$startDate = (isset($_GET['awal'])) ? $_GET['awal'] : Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$endDate = (isset($_GET['akhir'])) ? $_GET['akhir'] : Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$endDate = (isset($_GET['akhir'])) ? $_GET['akhir'] : Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$namaUnit = isset($_GET['unit']) ? $_GET['unit'] : NULL;
$barang = isset($_GET['barang']) ? $_GET['barang'] : NULL;
$unit = isset($_GET['idUnit']) ? $_GET['idUnit'] : NULL;
$packing = isset($_GET['idPacking']) ? $_GET['idPacking'] : NULL;
$indikasi = get_value('indikasi');
$ven = get_value('ven');
$perundangan = get_value('perundangan');
$generik = get_value('generik');
$formularium = get_value('formularium');
$ssf = get_value('ssf');
$perundangans = perundangan_muat_data();
$ssFarmakologi = get_value('ssFarmakologi');
$idSubSubFarmakologi = get_value('idSubSubFarmakologi');
?>
<h2 class="judul"><a href="<?= app_base_url('inventory/stok-obat-gudang-2') ?>">Informasi Riwayat Stok Obat Gudang</a></h2>
<?php
$pesan;
?>
<script type="text/javascript">
    $(function() {
        $('#unit').autocomplete("<?= app_base_url('/inventory/search?opsi=unit') ?>",
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
                var str='<div class=result>'+data.nama+' <br/></div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.nama);
            $('#idUnit').attr('value',data.id);
        }
    );
    });
		
    $(function()
    {
        $('#ssFarmakologi').autocomplete("<?= app_base_url('/pf/search?opsi=sub_sub_farmakologi') ?>",
        {
            parse: function(data)
            {
                var parsed = [];
                for (var i=0; i < data.length; i++)
                {
                    parsed[i] =
                        {
                        data: data[i],
                        value: data[i].nama // nama field yang dicari
                    };
                }
                return parsed;
            },
            formatItem: function(data,i,max)
            {
                var str='<div class=result>'+data.nama+'-'+data.nama_sub_farmakologi+'-'+data.nama_farmakologi+'<br/></div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result
        (
        function(event,data,formated)
        {
            $('#idSubSubFarmakologi').attr('value',data.id_sub_sub_farmakologi);
            $('#ssFarmakologi').attr('value',data.nama+'-'+data.nama_sub_farmakologi+'-'+data.nama_farmakologi);
        }
    );
    });   
    $(function() {
        $('#barang').autocomplete("<?= app_base_url('/inventory/search?opsi=namabarang') ?>",
        {
            parse: function(data){
                var parsed = [];
                for (var i=0; i < data.length; i++) {
                    parsed[i] = {
                        data: data[i],
                        value: data[i].nama_barang // nama field yang dicari
                    };
                }
                return parsed;
            },
            formatItem: function(data,i,max){
                var kekuatan=(data.kekuatan!=null && data.kekuatan!=0)?' '+data.kekuatan+',':'';
                var sediaan=(data.sediaan!=null)?' '+data.sediaan:'';
                var pabrik='';
                if(data.generik=='Generik'){
                    pabrik='<br>\n\<b>Pabrik :</b><i>'+data.pabrik+'</i>';
                }
                var str='<div class=result><b>'+data.nama_barang+'</b> <i>'+kekuatan+''+sediaan+'@'+data.nilai_konversi+' '+data.satuan_terkecil+'</i>'+pabrik+'</div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            var kekuatan=(data.kekuatan!=null && data.kekuatan!=0)?' '+data.kekuatan+',':'';
            var sediaan=(data.sediaan!=null)?' '+data.sediaan:'';
            var pabrik='';
            if(data.generik=='Generik'){
                pabrik=' '+data.pabrik;
            }
            $(this).attr('value', data.nama_barang+kekuatan+sediaan+' @'+data.nilai_konversi+' '+data.satuan_terkecil+pabrik);
            $('#idPacking').attr('value',data.id);
        }
    );
    });
</script>
<div class="data-input">
    <fieldset><legend>Parameter Pencarian</legend>
        <form action="" method="get">
            <fieldset class="field-group">
                <legend>Tanggal</legend>
                <input type="text" name="awal" class="tanggal" id="awal" value="<?= $startDate ?>" />
                <label class="inline-title" style="margin-right: 6px">s . d</label>
                <input type="text" name="akhir" class="tanggal" id="akhir" value="<?= $endDate ?>" />
            </fieldset>
            <label for="barang">Nama Obat</label><input type="text" class="nama_barang" name="barang" id="barang" value="<?= $barang ?>"/><input type="hidden" name="idPacking" class="auto" id="idPacking" value="<?= $packing ?>">
            <label for="barang">Perundangan</label>
            <select name="perundangan">
                <option value="">Pilih </option>
                <?
                foreach ($perundangans as $row) {
                    ?>
                    <option value="<?= $row['id'] ?>" <? if ($row['id'] == $perundangan)
                    echo "selected"; ?>><?= $row['nama'] ?></option>
                    <?
                }
                ?>
            </select>
            <fieldset class="field-group">
                <label for="Generik">Generik</label>
                <select name="generik">
                    <option value="all" <? if ($generik == "all")
                    echo "selected"; ?>>Pilih</option>
                    <option value="Generik" <? if ($generik == "Generik")
                    echo "selected"; ?>>Generik</option>
                    <option value="Non Generik" <? if ($generik == "Non Generik")
                    echo "selected"; ?>>Non Generik</option>
                </select>    
                <label for="formularium">Formularium</label>
                <select name="formularium">
                    <option value="all" <? if ($formularium == "all")
                    echo "selected"; ?>>Pilih</option>
                    <option value="Formularium" <? if ($formularium == "Formularium")
                    echo "selected"; ?>>Formularium</option>
                    <option value="Non Formularium" <? if ($formularium == "Non Formularium")
                    echo "selected"; ?>>Non Formularium</option>
                </select>    
            </fieldset>
            <label for="barang">Indikasi</label><textarea name="indikasi"><?= $indikasi ?></textarea>
            <label for="ven">Ven</label>
            <select name="ven">
                <option value="">Pilih</option>
                <option value="Esensial" <?= $ven == 'Esensial' ? 'selected' : '' ?>>Esensial</option>
                <option value="Non Esensial" <?= $ven == 'Non Esensial' ? 'selected' : '' ?>>Non Esensial</option>
                <option value="Vital" <?= $ven == 'Vital' ? 'selected' : '' ?>>Vital</option>
            </select>
            <label for="ssf">Sub sub farmakologi</label><input type="text" id="ssFarmakologi" name="ssFarmakologi" value="<?= $ssFarmakologi ?>" /><input type="hidden" name="idSubSubFarmakologi" id="idSubSubFarmakologi" value="<?= $idSubSubFarmakologi ?>" />
            <fieldset class="input-process">
                <input type="submit" value="Cari" class="tombol" name="cari"/> 
                <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/stok-obat-gudang-2') ?>'"/>
            </fieldset>
        </form>
    </fieldset>
</div>
<fieldset><legend>Hasil Pencarian</legend>
    <div class="data-list">
        <table class="tabel">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th style="width: 50%">Nama Obat</th>
                <th>Batch</th>
                <th>E.D</th>
                <th>Stok Awal</th>
                <th>Masuk</th>
                <th>Keluar</th>
                <th>Sisa</th>
                <th>Satuan</th>
                <th>Jenis Transaksi</th>
            </tr>
            <?php
            if(isset ($_GET['cari'])){
            $stok = stok_obat_muat_data2($startDate, $unit, $packing, null, $perundangan, $generik, $indikasi, $ven, $ssf, $formularium, $endDate);
            $totalAset = 0;
            $no = 1;
            foreach ($stok as $key => $rows):
                if ($rows['pabrik'] == 'None' || $rows['pabrik'] == 'NULL') {
                    $pabrik = "";
                } else
                    $pabrik = $rows['pabrik'];

                $nama = "$rows[barang]";
                if (($rows['generik'] == 'Generik') || ($rows['generik'] == 'Non Generik')) {
                    $nama.= ( $rows['kekuatan'] != 0) ? " $rows[kekuatan], $rows[sediaan]" : " $rows[sediaan]";
                }
                $nama .=" @$rows[nilai_konversi] $rows[satuan]";
                $nama.= ( $rows['generik'] == 'Generik') ? ' ' . $pabrik : '';

                $selisihHari = selisih_hari(date("Y-m-d"), $rows['ed']);
                if ($selisihHari <= 0) {
                    $style = 'style="background-color: #FF6600; color: #880000;"';
                } else if ($selisihHari > 0 && $selisihHari <= 180) {
                    $style = 'style="background-color: yellow; color: black;"';
                } else {
                    $style = ($rows['sisa'] < hitung_rop($rows['id_packing_barang'])) ? 'style="background-color: blue;color: white;"' : (($no % 2) ? 'class="odd"' : 'class="even"');
                }
                ?>
                <tr <?= $style ?>>
                    <td><?= $no++; ?></td>
                    <td><?= datefmysql($rows['tanggal']) ?></td>
                    <td class="no-wrap"><?= $nama ?></td>
                    <td><?= $rows['batch'] ?></td>
                    <td><?= datefmysql($rows['ed']) ?></td>
                    <td><?= $rows['awal'] ?></td>
                    <td><?= $rows['masuk'] ?></td>
                    <td><?= $rows['keluar'] ?></td>
                    <td><?= $rows['sisa'] ?></td>
                    <td><?= $rows['satuan_terbesar'] ?></td>
                     <td class="no-wrap"><?= $rows['jenis_transaksi'] ?></td>
                </tr>
    <?php
      endforeach;
      }
    ?>
        </table>
    </div>
</fieldset>

