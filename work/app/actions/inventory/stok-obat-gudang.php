
<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once "app/lib/common/functions.php";
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/pf/obat.php';
$obat = isset($_GET['obat']) ? $_GET['obat'] : NULL;
$packing = isset($_GET['idPacking']) ? $_GET['idPacking'] : NULL;
$sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : NULL;
$perundangan = get_value('perundangan');
$indikasi = get_value('indikasi');
$ven = get_value('ven');
$ssFarmakologi = get_value('ssFarmakologi');
$idSubSubFarmakologi = get_value('idSubSubFarmakologi');
$unit = get_value('nama');
$id_unit = get_value('id');
$generik = get_value('generik');
$formularium = get_value('formularium');
$zatAktif = get_value('zatAktif');
$idZatAktif = get_value('idZatAktif');
$rop1 = get_value('rop');
$perundangans = perundangan_muat_data();
?>
<script type="text/javascript">
    $(function() {
        $('#obat').autocomplete("<?= app_base_url('/inventory/search?opsi=namabarang') ?>",
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
   
    $(function() {
        $('#ssFarmakologi').autocomplete("<?= app_base_url('/pf/search?opsi=sub_sub_farmakologi') ?>",
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
                var str='<div class=result>'+data.nama+'-'+data.nama_sub_farmakologi+'-'+data.nama_farmakologi+'<br/></div>';
                $('#idSubSubFarmakologi').attr('value','');
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $('#idSubSubFarmakologi').attr('value',data.id_sub_sub_farmakologi);
            $('#ssFarmakologi').attr('value',data.nama+'-'+data.nama_sub_farmakologi+'-'+data.nama_farmakologi);
        }
    );
    });
    $(function()
    {
        $('#zatAktif').autocomplete("<?= app_base_url('/inventory/search?opsi=zatAktif') ?>",
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
                var str='<div class=result>'+data.nama+'<br/></div>';
                $('#idZatAktif').attr('value','');
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $('#idZatAktif').attr('value',data.id);
            $(this).attr('value',data.nama);
        });
        $('#unit').autocomplete("<?= app_base_url('/inventory/search?opsi=unit') ?>",
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
                var str='<div class=result>'+data.nama+'<br/></div>';
                $('#id_unit').attr('value','');
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $('#id_unit').attr('value',data.id);
            $('#unit').attr('value',data.nama);
        }
    );
    });
</script>

<h2 class="judul"><a href="<?= app_base_url('inventory/stok-obat-gudang') ?>">Stok Obat Gudang</a></h2>
<div class="data-input">
    <fieldset>
        <legend>Parameter Pencarian</legend>
        <form action="" method="get">
            <label for="obat">Nama Obat</label><input type="text" class="nama_barang" name="obat" id="obat" value="<?= $obat ?>"/><input type="hidden" name="idPacking" class="auto" id="idPacking" value="<?= $packing ?>">
            <label for="barang">Perundangan</label>
            <select name="perundangan">
                <option value="">Pilih </option>
<?php
foreach ($perundangans as $row) {
?>
                <option value="<?= $row['id'] ?>" <? if ($row['id'] == $perundangan)
                    echo "selected"; ?>><?= $row['nama'] ?></option>
                <?
            }
                ?>
            </select>
            <label for="generik">Generik</label>
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
            <label>Zat Aktif</label><input id="zatAktif" name="zatAktif" value="<?=$zatAktif?>" type="text"><input id="idZatAktif" type="hidden" name="idZatAktif" value="<?=$idZatAktif?>">
            <label for="barang">Indikasi</label><textarea name="indikasi"><?= $indikasi ?></textarea>
            <label for="ven">Ven</label>
            <select name="ven">
                <option value="">Pilih</option>
                <option value="Esensial" <?= $ven == 'Esensial' ? 'selected' : '' ?>>Esensial</option>
                <option value="Non Esensial" <?= $ven == 'Non Esensial' ? 'selected' : '' ?>>Non Esensial</option>
                <option value="Vital" <?= $ven == 'Vital' ? 'selected' : '' ?>>Vital</option>
            </select>
            <label for="ssf">Sub sub farmakologi</label><input type="text" id="ssFarmakologi" name="ssFarmakologi" value="<?= $ssFarmakologi ?>" /><input type="hidden" name="idSubSubFarmakologi" id="idSubSubFarmakologi" value="<?= $idSubSubFarmakologi ?>" />
            <fieldset class="field-group">
            <label>ROP</label><input type="checkbox" name="rop" value="1" <?= ($rop1 == 1)?"checked":"";?>/> Centang untuk menampilkan obat yang sisanya kurang dari ROP
            </fieldset>
            <fieldset class="input-process">
                <input type="submit" value="Cari" name="cari" class="tombol" />
                <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/stok-obat-gudang') ?>'"/>
            </fieldset>
        </form>
    </fieldset>
</div>

<fieldset><legend>Hasil Percarian</legend>
     <?php if (isset($_GET['cari'])) { ?>

    <div class="data-list">
        <table class="tabel">
            <tr>

                <th style="width: 40%">Nama Packing Obat</th>
                <th>No. Batch</th>
                <th><a href="<?= app_base_url('inventory/stok-obat-gudang?') . generate_sort_parameter(2, $sortBy) ?>" class='sorting'>E.D</a></th>
                <th>Jumlah Sisa</th>
                <th>ROP</th>
                <th>Kemasan</th>
                <th>Harga Beli (Rp.)</th>
                  <th>Harga Jual (Rp.)</th>
                <th>Nilai (Rp.)</th>
            </tr>
            <?php if (isset($_GET['cari'])) { 
                $totalAset = 0;
                $no = 1;
                $stokObat = stok_obat_muat_data3($packing, $perundangan, $generik, $formularium, $indikasi, $ven, $idSubSubFarmakologi,$idZatAktif,$sortBy);
                foreach ($stokObat as $row) {
                    $rop = hitung_rop($row['id_packing_barang']);
                    if ($row['sisa'] == 0) {
                        echo "";
                    } else {
                        if($rop1 == 1){
                        if($row['sisa'] < $rop){
                            $kadaluarsa = selisih_hari($row['ed'], date("Y-m-d"));
                            $nama=nama_packing_barang(array($row['generik'],$row['barang'],$row['kekuatan'],$row['sediaan'],$row['nilai_konversi'],$row['satuan_terkecil'],$row['pabrik']));
                            $selisihHari = selisih_hari(date("Y-m-d"), $row['ed']);
                            if ($selisihHari <= 0) {
                                $style = 'style="background-color: #DE5252; color: white;"';
                            } else if ($selisihHari > 0 && $selisihHari <= 180) {
                                $style = 'style="background-color: tomato; color: black;"';
                            } else {
                                $style = ($no % 2) ? 'class="odd"' : 'class="even"';
                            }
            ?>
                            <tr <?= $style ?>>
                                <td class="no-wrap"><?=$nama ?></td>
                                <td><?= $row['batch'] ?></td>
                                <td align="center"><?= datefmysql($row['ed']) ?></td>
                                <td align="right"><?= $row['sisa'] ?></td>
                                <td align="right"><?= $rop ?></td>
                                <td align="right"><?= $row['satuan_terbesar'] ?></td>
                                <td align="right"><?= rupiah($row['hpp']) ?></td>
                                <td align="right"><?= rupiah($row['hna']) ?></td>
                                <td align="right">
                    <?php
                            $nilai = $row['sisa'] * $row['hpp'];
                            echo (rupiah($nilai));
                            $totalAset += $nilai;
                    ?>
                                </td>
                            </tr>
<?php
                            $no++;
                        }else echo "";       
                    }else{
                        
                        $kadaluarsa = selisih_hari($row['ed'], date("Y-m-d"));
                                $nama=nama_packing_barang(array($row['generik'],$row['barang'],$row['kekuatan'],$row['sediaan'],$row['nilai_konversi'],$row['satuan_terkecil'],$row['pabrik']));
                            $selisihHari = selisih_hari(date("Y-m-d"), $row['ed']);
                            if ($selisihHari <= 0) {
                                $style = 'style="background-color: #DE5252; color: white;"';
                            } else if ($selisihHari > 0 && $selisihHari <= 180) {
                                $style = 'style="background-color: tomato; color: black;"';
                            } else {
                                $style = ($no % 2) ? 'class="odd"' : 'class="even"';
                            }
            ?>
                            <tr <?= $style ?>>
                                <td class="no-wrap"><?=$nama ?></td>
                                <td><?= $row['batch'] ?></td>
                                <td align="center"><?= datefmysql($row['ed']) ?></td>
                                <td align="right"><?= $row['sisa'] ?></td>
                                <td align="right"><?= $rop ?></td>
                                <td align="right"><?= $row['satuan_terbesar'] ?></td>
                                <td align="right"><?= rupiah($row['hpp']) ?></td>
                                <td align="right"><?= rupiah($row['hna']) ?></td>
                                <td align="right">
                    <?php
                            $nilai = $row['sisa'] * $row['hpp'];
                            echo (rupiah($nilai));
                            $totalAset += $nilai;
                    ?>
                                </td>
                            </tr>
<?php                        
                    }
                    }
                }
			
?>
            </table>
        </div>
         <div style="float: right">
        <span class="cetak" >Cetak ED</span>
    </div>
        <div class="perpage" style="margin-top: 5px">
            Total Nilai Obat : <? echo "Rp. " . rupiah($totalAset) . ",00"; ?>
    </div> <?php } ?>
</fieldset>

   <script type="text/javascript">
                $(document).ready(function(){
                    $(".cetak").click(function(){
                        var win = window.open('report/stok-obat-gudang?obat=<?= $obat ?>&idPacking=<?= $packing ?>&perundangan=<?= $perundangan ?>&generik=<?= $generik ?>&formularium=<?= $formularium ?>&idPacking=<?= $packing ?>&perundangan=<?= $perundangan ?>&zatAktif=<?= $zatAktif ?>&idZatAktif=<?= $idZatAktif ?>&indikasi=<?= $indikasi ?>&ven=<?= $ven ?>&ssFarmakologi=<?= $ssFarmakologi ?>&idSubSubFarmakologi=<?= $idSubSubFarmakologi ?>', 'MyWindow', 'width=800px,height=600px,scrollbars=1');
        })
    })
</script>
   
<?php } else { echo "<span class='tips'>Silahkan menggunakan opsi pencarian di atas</span>"; }?>