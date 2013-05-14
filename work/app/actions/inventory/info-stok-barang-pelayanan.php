<?
include_once "app/lib/common/functions.php";
include 'app/actions/admisi/pesan.php';
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/pf/obat.php';
set_time_zone();
$barang=(isset($_GET['barang']))?$_GET['barang']:null;
$idPacking=(isset($_GET['idPacking']))?$_GET['idPacking']:null;
$pabrik=(isset($_GET['pabrik']))?$_GET['pabrik']:null;
$idPabrik=(isset($_GET['idPabrik']))?$_GET['idPabrik']:null;
$subKategori=(isset($_GET['subKategori']))?$_GET['subKategori']:null;
$idSubKategori=(isset($_GET['idSubKategori']))?$_GET['idSubKategori']:null;
$unit = unit_muat_data();
$getUnit = get_value('unit');
//echo $_SESSION['id_unit'];
$stok= stok_barang_pelayanan_muat_data($idPacking, $idPabrik, $idSubKategori, $getUnit);
//show_array($stok);
?>
<h2 class="judul"><a href="<?= app_base_url('inventory/info-stok-barang-pelayanan') ?>">Informasi Stok Barang Pelayanan</a></h2>
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
<div class="data-input">
    <fieldset><legend>Parameter Pencarian</legend>
        <form action="" method="get">
            <label for="unit">Unit</label>
            <select name="unit">
                <option value="">Pilih </option>
                <?
                foreach ($unit['list'] as $unit){
                ?>
                  <option value="<?= $unit['id']?>" <? if($unit['id'] == $getUnit) echo "selected";?>><?= $unit['nama']?></option>
                <?
                }
                ?>
            </select>
            <label for="barang">Nama Barang</label><input type="text" name="barang" id="barang" value="<?= $barang ?>"/><input type="hidden" name="idPacking" class="auto" id="idPacking" value="<?=$idPacking?>">
            <label for="barang">Nama Pabrik</label><input type="text" name="pabrik" id="pabrik" value="<?= $pabrik ?>"/><input type="hidden" name="idPabrik" class="auto" id="idPabrik" value="<?=$idPabrik?>">
            <label for="barang">Nama Sub Kategori</label><input type="text" name="subKategori" id="subKategori" value="<?= $subKategori ?>"/><input type="hidden" name="idSubKategori" class="auto" id="idSubKategori" value="<?=$idSubKategori?>">
            <fieldset class="input-process">
                <input type="submit" value="Cari" name="cari" class="tombol" />
                <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/info-stok-barang-pelayanan') ?>'"/>
            </fieldset>
        </form>
    </fieldset>
</div>


<fieldset><legend>Hasil Pencarian</legend>
    <div class="data-list">
    <?
	if (isset($_GET['cari']))
			{
	?>
	
        <table class="tabel">
            <tr>
                <th>Nama Barang</th>
                  <th>No Batch</th>
                <th>Stok Sisa</th>
                <th>Harga Beli</th>
                <th>ROP</th>
                <th>Nilai</th>
            </tr>
            <?php
			
			$nilai=0;
            foreach ($stok as $key => $rows):
                if($rows['sisa'] == 0){
                    echo "";
                }else{
                 $nama=nama_packing_barang2(array($rows['nama_barang'],$rows['nilai_konversi'],$rows['satuan'],$rows['pabrik']));
                ?>
                <tr <?=(($key%2) ? 'class="odd"': 'class="even"')?>>
                   <td style="width: 40%"><?=$nama ?></td>
                   <td><?=$rows['batch']?></td>
                    <td><?=$rows['sisa']?></td>
                    <td align="right"><?=rupiah($rows['hpp'])?></td>
                    <td align="center"><?=  hitung_rop($rows['id_packing_barang'])?></td>
                    <td align="right"><?=rupiah($rows['nilai'])?></td>
                    <?$nilai+=$rows['nilai']?>
                </tr>
            <?php
            } endforeach; ?>
            </table>
            <p>Total Asset Barang : <?=rupiah($nilai)?></p>
			<?php }else { echo "<span class='tips'>Silahkan menggunakan opsi pencarian di atas</span>";} ?>
        </div>
    </fieldset><br/>

    <script type="text/javascript">
        $(document).ready(function(){
            $(".cetak").click(function(){
                var win = window.open('report/stok-barang?startDate=<?= $startDate ?>&endDate=<?= $endDate ?>&unit=<?= $unit ?>&packing=<?= $packing ?>&jenisTransaksi=<?= $jenisTransaksi ?>', 'MyWindow', 'width=800px,height=600px,scrollbars=1');
            })
        })
    </script>
