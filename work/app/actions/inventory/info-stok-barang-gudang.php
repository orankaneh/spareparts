<?
include_once "app/lib/common/functions.php";
include 'app/actions/admisi/pesan.php';
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/pf/obat.php';
set_time_zone();
$barang = (isset($_GET['barang'])) ? $_GET['barang'] : null;
$idPacking = (isset($_GET['idPacking'])) ? $_GET['idPacking'] : null;
$pabrik = (isset($_GET['pabrik'])) ? $_GET['pabrik'] : null;
$idPabrik = (isset($_GET['idPabrik'])) ? $_GET['idPabrik'] : null;
$subKategori = (isset($_GET['subKategori'])) ? $_GET['subKategori'] : null;
$idSubKategori = (isset($_GET['idSubKategori'])) ? $_GET['idSubKategori'] : null;
$stok = stok_barang_gudang_muat_data($idPacking, $idPabrik, $idSubKategori);
//show_array($stok);
?>

<script type="text/javascript">
    $(function() {
        $('#pabrik').autocomplete("<?= app_base_url('/inventory/search?opsi=suplier') ?>&jenis_instansi=5",
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
                $('#idPabrik').attr('value','');
                var str='<div class=result>'+data.nama+' <br/><i> '+data.alamat+' , '+data.nama_kelurahan+'</i></div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $('#pabrik').attr('value',data.nama);
            $('#idPabrik').attr('value',data.id);
        });

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

        $('#subKategori').autocomplete("<?= app_base_url('/inventory/search?opsi=sub_kategori') ?>",
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
                $('#idSubKategori').attr('value','');
                var str='<div class=result><b>'+data.nama+'</b></div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.nama);
            $('#idSubKategori').attr('value',data.id);
        }
    );

    });
</script>
<h2 class="judul"><a href="<?= app_base_url('inventory/info-stok-barang-gudang') ?>">Informasi Stok Barang Gudang</a></h2>
<div class="data-input">
    <fieldset><legend>Parameter Pencarian</legend>
        <form action="" method="get">
            <label for="barang">Nama Barang</label><input type="text" name="barang" id="barang" value="<?= $barang ?>"/><input type="hidden" name="idPacking" class="auto" id="idPacking" value="<?= $idPacking ?>">
            <label for="barang">Nama Pabrik</label><input type="text" name="pabrik" id="pabrik" value="<?= $pabrik ?>"/><input type="hidden" name="idPabrik" class="auto" id="idPabrik" value="<?= $idPabrik ?>">
            <label for="barang">Nama Sub Kategori</label><input type="text" name="subKategori" id="subKategori" value="<?= $subKategori ?>"/><input type="hidden" name="idSubKategori" class="auto" id="idSubKategori" value="<?= $idSubKategori ?>">
            <fieldset class="input-process">
                <input type="submit" value="Cari" name="cari" class="tombol" />
                <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/info-stok-barang-gudang') ?>'"/>
            </fieldset>
        </form>
    </fieldset>
</div>


<fieldset><legend>Hasil Pencarian</legend>
    <div class="data-list">
        <?
        if (isset($_GET['cari'])) {
            ?>
            <table class="tabel">
                <tr>
                    <th>Nama Packing Barang</th>
                    <th>No. Batch</th>
                    <th>E.D</th>
                    <th>Jumlah Sisa</th>
                    <th>ROP</th>
                    <th>Kemasan</th>
                       <th>Harga Jual</th>
                    <th>Harga Beli</th>
                    <th>Nilai</th>
                </tr>
                <?php
                $nilaiAll = 0;
                $nilai = 0;
                foreach ($stok as $key => $rows):
                    if ($rows['sisa'] == 0) {
                        echo "";
                    } else {
                            $nama=nama_packing_barang(array($rows['generik'],$rows['nama_barang'],$rows['kekuatan'],$rows['sediaan'],$rows['nilai_konversi'],$rows['satuan'],$rows['pabrik']));
                        $kadaluarsa = selisih_hari($rows['ed'], date("Y-m-d"));
//                        if ($kadaluarsa >= 180) {
//                            
//                        } else {
                            $selisihHari = selisih_hari(date("Y-m-d"), $rows['ed']);
                            if ($selisihHari <= 180 && $rows['batch'] != '') {
                                $style = 'class=warning';
                            } else {
                                $style = (($key % 2) ? 'class="odd"' : 'class="even"');
                            }
                            ?>
                            <tr <?= $style ?>>
                                <td style="width: 40%"><?=$nama?></td>
                                <td><?= $rows['batch'] ?></td>
                                <td><?= datefmysql($rows['ed']) ?></td>
                                <td><?= $rows['sisa'] ?></td>
                                <td align="center" class="no-wrap"><?= hitung_rop($rows['id_packing_barang']) ?></td>
                                <td><?= $rows['kemasan'] ?></td>
                                <td align="right"><?= rupiah($rows['13']) ?></td>
                                <td align="right"><?= rupiah($rows['hpp']) ?></td>
                                <td align="right">
                                   <?
                                     $nilai = $rows['sisa'] * $rows['hna'];
                                     echo rupiah($nilai);
                                   ?>
                                </td>
                                   <? $nilaiAll = $nilaiAll + $nilai ?>
                            </tr>
                            <?php //}
                        } endforeach; ?>
            </table>
            <p>Total Asset Barang : <?= rupiah($nilaiAll) ?></p>
            <? if (count($stok)!=0){?>
<a class=excel class=tombol href="<?=app_base_url('inventory/report/stok-barang-gudang-excel?').  generate_get_parameter($_GET)?>">Cetak</a>
<? } ?>
<?php } else {
    echo "<span class='tips'>Silahkan menggunakan opsi pencarian di atas</span>";
} ?>

    </div>
</fieldset><br/>

