<h2 class="judul"><a href="<?= app_base_url('inventory/stok-barang-gudang-2') ?>">Riwayat Stok Barang Gudang</a></h2>
<?
include_once "app/lib/common/functions.php";
include 'app/actions/admisi/pesan.php';
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/pf/obat.php';
set_time_zone();
$unite = $_SESSION['id_unit'];
$startDate = (isset($_GET['awal'])) ? $_GET['awal'] : Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$endDate = (isset($_GET['akhir'])) ? $_GET['akhir'] : Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$barang = isset($_GET['barang']) ? $_GET['barang'] : NULL;
$subKategori = isset($_GET['subKategori']) ? $_GET['subKategori'] : NULL;
$idSubKategori = isset($_GET['idSubKategori']) ? $_GET['idSubKategori'] : NULL;
$packing = isset($_GET['idPacking']) ? $_GET['idPacking'] : NULL;
$jenisTransaksi = isset($_GET['transaksi']) ? $_GET['transaksi'] : NULL;
$transaksi = jenis_transaksi_muat_data();
$stok = stok_barang_muat_data2($startDate, $endDate, $_SESSION['id_unit'], $packing, $jenisTransaksi, $idSubKategori);
?>

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
                $('#idUnit').attr('value','');
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
    $(function() {
        $('#subKategori').autocomplete("<?= app_base_url('/inventory/search?opsi=sub_kategori_barang') ?>",
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
                var str='<div class=result>'+data.nama+'</div>';
                $('#idSubKategori').attr('value','');
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
            <fieldset class="field-group">
                <legend>Tanggal</legend>
                <input type="text" name="awal" class="tanggal" id="awal" value="<?= ($startDate) ?>" />
                <label class="inline-title" style="margin-right: 6px">s . d</label>
                <input type="text" name="akhir" class="tanggal" id="akhir" value="<?= $endDate ?>" />
            </fieldset>
            <label for="barang">Nama Barang</label><input class="nama_barang" type="text" name="barang" id="barang" value="<?= $barang ?>"/><input type="hidden" name="idPacking" class="auto" id="idPacking">
            <label for="subKategori">Sub Kategori Barang</label><input type="text" name="subKategori" id="subKategori" value="<?= $subKategori ?>"><input type="hidden" name="idSubKategori" class="auto" id="idSubKategori">
            <label for="barang">Jenis Transaksi</label>
            <select name="transaksi">
                <option value="">Pilih </option>
<?
foreach ($transaksi as $row) {
?>
                <option value="<?= $row['id'] ?>" <? if ($row['id'] == $jenisTransaksi)
                    echo "selected"; ?>><?= $row['nama'] ?></option>
                <?
            }
                ?>
            </select>
            <fieldset class="input-process">
                <input type="submit" value="Cari" class="tombol" name="cari"/>
                <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/stok-barang-gudang-2') ?>'"/>
            </fieldset>
        </form>
    </fieldset>
</div>
<fieldset><legend>Hasil Pencarian</legend>
    <?php if(isset ($_GET['cari'])){ ?>
    <div class="data-list" style=" overflow:auto;">
         <table class="tabel" style="width:101%">
            <tr>
                <th rowspan='2' style="vertical-align: middle">Waktu</th>
                <th rowspan='2' style="width: 30%;vertical-align: middle">Nama Packing Barang</th>
                <th rowspan='2' style="vertical-align: middle">No. Batch</th>
                <th rowspan='2' style="vertical-align: middle">E.D</th>

            
                <th rowspan='1' colspan="4"> Jumlah</th>
                <th rowspan='2'>Kemasan</th>
                     <th rowspan='2'>Harga</th>
                 <th rowspan='2'>Nilai</th>
                <th rowspan='2'>No Pembelian</th>
                <th rowspan='2'>Jenis Transaksi</th>                
            </tr>
                <tr>
                <th rowspan='1'> Awal</th>
                <th rowspan='1'>Masuk</th>
                <th rowspan='1'>Keluar</th>
                <th rowspan='1'>Sisa</th>
                
             
            </tr>
<?php 
$no = 1;
foreach($stok as $key => $rows): ?>
        <?php
		 if ($rows['generik'] == 'Generik') {
                            $nama = ($rows['kekuatan']!=0)?"$rows[barang] $rows[kekuatan], $rows[sediaan]":"$rows[barang] $rows[sediaan]";
                        }
						 else if ($rows['generik'] == 'Non Generik') {
                            $nama = ($rows['kekuatan']!=0)?"$rows[barang] $rows[kekuatan]":"$rows[barang] ";
                        }
                        else {
                $nama = "$rows[barang]";
              }
              $nama .=" @$rows[nilai_konversi] $rows[satuan]";
              $nama.=($rows['generik'] == 'Generik')?' '. $rows['pabrik']:'';
			  
            $selisihHari=selisih_hari(date("Y-m-d"),$rows['ed']);
            if ($selisihHari <= 0) {
                $style = 'style="background-color: #DE5252; color: white;"';
            } else if ($selisihHari > 0 && $selisihHari <= 180) {
                $style = 'style="background-color: #FAF0AC; color: black;"';
            } else{
                    $style = ($rows['sisa'] < hitung_rop($rows['id_packing_barang'])) ? 'style="background-color: blue ;color: white;"' : (($no%2) ? 'class="odd"' : 'class="even"');
            }
        ?>
        <tr <?=$style?>>

            <td><?= datefmysql($rows['tanggal']) ?></td>
            <td><?=$nama?></td>
            <td class="no-wrap" align="center"><?= ($rows['batch']=='')?'-':$rows['batch'] ?></td>
            <td class="no-wrap" align="center"><?= ($rows['batch']=='')?'-':datefmysql($rows['ed']) ?></td>
            <td><?= $rows['awal']?></td>
            <td><?= $rows['masuk']?></td>
            <td><?= $rows['keluar']?></td>
            <td><?= $rows['sisa']?></td>
            <td><?= $rows['kemasan'] ?></td>
             <td><?= rupiah($rows['hna']) ?></td>
                     <td><?= rupiah($rows['hargax']) ?></td>
            <td><?= $rows['id_transaksi'] ?></td>
            <td class="no-wrap"><?= $rows['jenis_transaksi'] ?></td>
        </tr>
       <?php
        $no++;
        endforeach; 
	
       ?>
    </table>
</div>
<? if (count($stok)!=0){?>
<a class=excel class=tombol href="<?=app_base_url('inventory/report/riwayat-stok-barang-gudang?').  generate_get_parameter($_GET)?>">Cetak</a>
<? } ?>
</fieldset>    
<?
}
?>