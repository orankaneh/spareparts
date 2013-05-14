<h2 class="judul"><a href="<?= app_base_url('inventory/stok-barang-pelayanan-2')?>">Riwayat Stok Barang Pelayanan</a></h2>
<?
  include_once "app/lib/common/functions.php";
  include 'app/actions/admisi/pesan.php';
  require_once 'app/lib/common/master-data.php';
  require_once 'app/lib/pf/obat.php';
  set_time_zone();
  $unit = $_SESSION['id_unit'];
  $startDate=(isset($_GET['awal']))? $_GET['awal']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
  $endDate=(isset($_GET['akhir']))? $_GET['akhir']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
  $barang = isset ($_GET['barang'])?$_GET['barang']:NULL;
  $subKategori = isset ($_GET['subKategori'])?$_GET['subKategori']:NULL;
  $idSubKategori = isset ($_GET['idSubKategori'])?$_GET['idSubKategori']:NULL;
  $packing=isset ($_GET['idPacking'])?$_GET['idPacking']:NULL;
  $jenisTransaksi=isset ($_GET['transaksi'])?$_GET['transaksi']:NULL;
  $transaksi = jenis_transaksi_muat_data();
  $stok = stok_barang_pelayanan_muat_data2($startDate,$endDate,$unit,$packing,$jenisTransaksi,$idSubKategori);
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
                                value: data[i].nama // nama field yang dicari
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
    <fieldset><legend>Form Laporan Stok</legend>
        <form action="" method="get">
        <fieldset class="field-group">
            <legend>Tanggal</legend>
            <input type="text" name="awal" class="tanggal" id="awal" value="<?=($startDate)?>" />
            <label class="inline-title">s. d</label>
            <input type="text" name="akhir" class="tanggal" id="akhir" value="<?=($endDate)?>" />
        </fieldset>
            <label for="barang">Nama Barang</label><input type="text" name="barang" id="barang" value="<?= $barang?>"/><input type="hidden" name="idPacking" class="auto" id="idPacking" />
            <label for="subKategori">Sub Kategori Barang</label><input type="text" name="subKategori" id="subKategori" value="<?= $subKategori?>"><input type="hidden" name="idSubKategori" class="auto" id="idSubKategori" />
            <label for="barang">Jenis Transaksi</label>
            <select name="transaksi">
                <option value="">Pilih </option>
                <?
                   foreach ($transaksi as $row){
                ?>
                <option value="<?= $row['id']?>" <?if($row['id'] == $jenisTransaksi) echo "selected";?>><?= $row['nama']?></option>
                <?
                   }
                ?>
            </select>
        <fieldset class="input-process">
            <input type="submit" value="Tampil" class="tombol" /> 
            <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/stok-barang-pelayanan-2') ?>'"/>
        </fieldset>
        </form>
    </fieldset>
</div>


  <div class="data-list">
  <b>Detail Laporan Stok</b>
    <table class="tabel">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th style="width: 50%">Nama Barang</th>
            <th>Transaksi</th>
            <th>Unit</th>
            <th>Stok Awal</th>
            <th>Masuk</th>
            <th>Keluar</th>
            <th>Sisa</th>
            <th>Kemasan</th>
        </tr>
<?php 
foreach($stok as $key => $rows): ?>
        <?php
   $nama=nama_packing_barang(array($rows['generik'],$rows['barang'],$rows['kekuatan'],$rows['sediaan'],$rows['nilai_konversi'],$rows['satuan'],$rows['pabrik']));
           $style=($rows['sisa']<hitung_rop($rows['id_packing_barang']))?'style="background: #f3fb9d;color: #000000;"':(($key%2) ? 'class="odd"': 'class="even"');
        ?>
        <tr <?=$style?>>
            <td align="center"><?= ($key+1) ?></td>
            <td><?= datefmysql($rows['tanggal']) ?></td>
            <td style="width: 40%"><?=$nama?></td>
            <td class="no-wrap"><?= $rows['jenis_transaksi'] ?></td>
            <td class="no-wrap"><?= $rows['unit'] ?></td>
            <td><?= $rows['awal']?></td>
            <td><?= $rows['masuk']?></td>
            <td><?= $rows['keluar']?></td>
            <td><?= $rows['sisa']?></td>
            <td><?= $rows['satuan_terbesar'] ?></td>
        </tr>
       <?php endforeach; ?>
    </table>
     </div>
