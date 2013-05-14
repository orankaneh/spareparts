<?
include_once "app/lib/common/functions.php";
include 'app/actions/admisi/pesan.php';
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/pf/obat.php';
require_once 'app/lib/pf/farmakologi.php';
set_time_zone();
$startDate = (isset($_GET['awal'])) ? $_GET['awal'] : Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$endDate = (isset($_GET['akhir'])) ? $_GET['akhir'] : Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$barang = isset($_GET['barang']) ? $_GET['barang'] : NULL;
$packing = isset($_GET['idPacking']) ? $_GET['idPacking'] : NULL;
$indikasi = get_value('indikasi');
$ven = get_value('ven');
$perundangan = get_value('perundangan');
$generik = get_value('generik');
$formularium = get_value('formularium');
$ssf = get_value('ssf');
$perundangans = perundangan_muat_data();
$subSubFarmakologi = sub_sub_farmakologi_muat_data();
?>
<h2 class="judul"><a href="<?= app_base_url('inventory/stok-obat-pelayanan-2') ?>">Riwayat Stok Obat Pelayanan</a></h2>
<?php
$pesan;
?>
<script type="text/javascript">
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
              var str='';
              var str=ac_nama_packing_barang([data.generik, data.nama_barang, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik], null)
return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
                  var str=nama_packing_barang([data.generik, data.nama_barang, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik], null)

$(this).attr('value', str);
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
            <label for="barang">Sub sub farmakologi</label>
            <select name="ssf">
                <option value="">Pilih </option>
                <?
                            foreach ($subSubFarmakologi['list'] as $row) {
                ?>
                                <option value="<?= $row['id'] ?>" <? if ($row['id'] == $ssf)
                                    echo "selected"; ?>><?= $row['nama'] . '-' . $row['nama_sub_farmakologi'] ?></option>
                        <?
                            }
                        ?>
                </select>
                <fieldset class="input-process">
                    <input type="submit" value="Cari" class="tombol" />
                    <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/stok-obat-pelayanan-2') ?>'"/>
                </fieldset>
            </form>
        </fieldset>
    </div>
    <fieldset><legend>Detail Laporan Stok</legend>
        <div class="data-list">
            <table class="tabel">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th style="width: 50%">Nama Obat</th>
                      <th>No Batch</th>
                    <th>Stok Awal</th>
                    <th>Masuk</th>
                    <th>Keluar</th>
                    <th>Sisa</th>
                    <th>Kemasan</th>
                    <th>Transaksi</th>
                </tr>
            <?php           
                            if(!isset ($_GET['awal'])){
                                $stok=null;
                            }else{
                                $stok = stok_obat_unit_muat_data2($startDate, $packing, null, $perundangan, $generik, $indikasi, $ven, $ssf, $formularium, $endDate);                            
                            foreach ($stok as $key => $rows):
            $nama=nama_packing_barang(array($rows['generik'],$rows['barang'],$rows['kekuatan'],$rows['sediaan'],$rows['nilai_konversi'],$rows['satuan'],$rows['pabrik']));
            ?>
                                <tr <?= (($rows['sisa'] < hitung_rop($rows['id_packing_barang'])) ? 'style="background: #f3fb9d;"' : (($key % 2) ? 'class="odd"' : 'class="even"')) ?>>
                                    <td align="center"><?= ++$key ?></td>
                                    <td><?= datefmysql($rows['tanggal']) ?></td>
                                    <td class="no-wrap"><?= $nama ?></td>
                                     <td><?= $rows['batch'] ?></td>
                                    <td><?= $rows['awal'] ?></td>
                                    <td><?= $rows['masuk'] ?></td>
                                    <td><?= $rows['keluar'] ?></td>
                                    <td><?= $rows['sisa'] ?></td>
                                    <td><?= $rows['satuan_terbesar'] ?></td>
                                    <td class="no-wrap"><?= $rows['jenis_transaksi'] ?></td>
                                </tr>
<?php endforeach;} ?>
        </table>
    </div>
</fieldset>