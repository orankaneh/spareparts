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
$perundangan = get_value('perundangan');
$indikasi = get_value('indikasi');
$ven = get_value('ven');
$ssFarmakologi = get_value('ssFarmakologi');
$idSubSubFarmakologi = get_value('idSubSubFarmakologi');
$generik = get_value('generik');
$formularium = get_value('formularium');
$perundangans = perundangan_muat_data();
$zatAktif = get_value('zatAktif');
$idZatAktif = get_value('idZatAktif');
?>
<script type="text/javascript">
    $(function() {
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
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $('#idZatAktif').attr('value',data.id);
            $(this).attr('value',data.nama);
        });
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
</script>
<h2 class="judul"><a href="<?= app_base_url('inventory/stok-obat-pelayanan') ?>">Stok Obat Pelayanan</a></h2>
<div class="data-input">
    <fieldset>
        <legend>Parameter Pencarian</legend>
        <form action="" method="get">
            <label for="obat">Nama Obat</label><input type="text" class="nama_barang" name="obat" id="obat" value="<?= $obat ?>"/><input type="hidden" name="idPacking" class="auto" id="idPacking" value="<?= $packing ?>">
            <label for="barang">Perundangan</label>
            <select name="perundangan">
                <option value="">Pilih </option>
                <?foreach ($perundangans as $row) {?>
                <option value="<?= $row['id'] ?>" <? if ($row['id'] == $perundangan)
                    echo "selected"; ?>><?= $row['nama'] ?></option>
                <?}?>
            </select>
            <label for="generik">Generik</label>
            <select name="generik">
                <option value="All" <? if ($generik == "All")
                    echo "selected"; ?>>Pilih</option>
                <option value="Generik" <? if ($generik == "Generik")
                    echo "selected"; ?>>Generik</option>
                <option value="Non Generik" <? if ($generik == "Non Generik")
                    echo "selected"; ?>>Non Generik</option>
            </select> 
            <label for="formularium">Formularium</label>
            <select name="formularium">
                <option value="All" <? if ($formularium == "All")
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
            <fieldset class="input-process">
                <input type="submit" value="Cari" name="cari" class="tombol" />
                <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/stok-obat-pelayanan') ?>'"/>
            </fieldset>
        </form>
    </fieldset>
</div>

<fieldset><legend>Hasil Pencarian</legend>
    <div class="data-list">
        <?php if (isset($_GET['cari']))
			{
                            ?>
        <table class="tabel">
            <tr>
                <th style="width: 25%">Nama Packing Obat</th>
                 <th>No Batch</th>
                <th style="width: 10%">Jumlah Sisa</th>
                <th>Kemasan</th>
                <th>Harga Beli(Rp.)</th>
                <th>Nilai (Rp.)</th>
            </tr>
            <?php
			
                $totalAset = 0;
                $no = 1;
                $stokObat = stok_obat_pelayanan_muat_data($packing, $perundangan, $generik, $formularium, $indikasi, $ven, $idSubSubFarmakologi,$idZatAktif);
                foreach ($stokObat as $row) {
				   if($row['sisa'] == 0){
                    echo "";
                }else{
             
                 $nama=nama_packing_barang(array($row['generik'],$row['barang'],$row['kekuatan'],$row['sediaan'],$row['nilai_konversi'],$row['satuan_terkecil'],$row['pabrik']));
            ?>
                <tr class="<?= ($no % 2) ? 'even' : 'odd' ?>">
                    <td class="no-wrap"><?=$nama ?></td>
                    <td><?= $row['batch'] ?></td>
                    <td><?= $row['sisa'] ?></td>
                    <td><?= $row['satuan_terbesar'] ?></td>
                    <td style="text-align: right;"><?= rupiah($row['hpp']) ?></td>
                    <td style="text-align: right;">
            <?
                        $nilai = $row['sisa'] * $row['hpp'];
                        echo rupiah($nilai);
                        $totalAset += $nilai;
            ?>
                            </td>
                        </tr>
<?
                        $no++;
						}
                    }
?>
            </table>
            <div class="perpage">
                Total Asset Obat : Rp. <?= rupiah($totalAset) ?>
        </div>
		<?php } else { echo "<span class='tips'>Silahkan menggunakan opsi pencarian di atas</span>";}?>
                    
        
                
    </div>
</fieldset>    
