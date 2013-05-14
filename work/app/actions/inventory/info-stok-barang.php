<?
  include_once "app/lib/common/functions.php";
  include 'app/actions/admisi/pesan.php';
  require_once 'app/lib/common/master-data.php';
  require_once 'app/lib/pf/obat.php';
  set_time_zone();
  $unite = $_SESSION['id_unit'];
  $startDate=(isset($_GET['awal']))? $_GET['awal']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
  $endDate=(isset($_GET['akhir']))? $_GET['akhir']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
  $namaUnit = isset ($_GET['unit'])?$_GET['unit']:NULL;
  $barang = isset ($_GET['barang'])?$_GET['barang']:NULL;
  $unit=isset ($_GET['idUnit'])?$_GET['idUnit']:$unite;
  $packing=isset ($_GET['idPacking'])?$_GET['idPacking']:NULL;
  $jenisTransaksi=isset ($_GET['transaksi'])?$_GET['transaksi']:NULL;
  $transaksi = jenis_transaksi_muat_data();
  $stok = stok_barang_muat_data($startDate,$endDate,$unit,$packing,$jenisTransaksi);
  
?>
<h2 class="judul"><a href="<?= app_base_url('inventory/info-stok-barang')?>">Informasi Stok Barang</a></h2>
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
                        var str='<div class=result><b>'+data.nama_barang+'</b> <i>'+data.nilai_konversi+' '+data.satuan_terkecil+'</i><br>\n\
                            <b>Pabrik :</b><i>'+data.pabrik+'</i></div>';
                        return str;
                    },
                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
               $(this).attr('value',data.nama_barang);
               $('#idPacking').attr('value',data.id);
            }
        );
});
</script>
<div class="data-input">
    <fieldset><legend>Form Laporan Stok</legend>
        <form action="" method="get">
        <fieldset class="field-group">
            <legend>Tanggal</legend>
            <input type="text" name="awal" class="tanggal" id="awal" value="<?=($startDate)?>" /><label class="inline-title">s . d &nbsp;</label><input type="text" name="akhir" class="tanggal" id="akhir" value="<?=$endDate ?>" />

        </fieldset>
            <label for="unit">Nama Unit</label><input type="text" name="unit" id="unit" value="<?= $namaUnit?>"/><input type="hidden" name="idUnit" id="idUnit">
            <label for="barang">Nama Barang</label><input type="text" name="barang" id="barang" value="<?= $barang?>"/><input type="hidden" name="idPacking" class="auto" id="idPacking">
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
            <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/info-stok-barang') ?>'"/>
        </fieldset>
        </form>
    </fieldset>
</div>


 <a class="button" href="<?= app_base_url('inventory/penerimaan') ?>">Penerimaan</a>
 <fieldset><legend>Detail Laporan Stok</legend>
     <div class="data-list">
    <table class="tabel">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama Barang</th>
            <th>Batch</th>
            <th>E.D</th>
            <th>Transaksi</th>
            <th>Unit</th>
            <th>Stok Awal</th>
            <th>Masuk</th>
            <th>Keluar</th>
            <th>Sisa</th>
            <th>Satuan</th>
            <th>HPP</th>
            <th>Nilai Stok</th>
            <th>ROP</th>
        </tr>
<?php 
foreach($stok as $key => $rows): ?>
        <?php
            $selisihHari=selisih_hari(date("Y-m-d"),$rows['ed']);
            if($selisihHari<=180){
                $style='style="background: tomato;"';
            }else{
                $style=($rows['sisa']<$rows['rop'])?'style="background: #f3fb9d;color: #000000;"':(($key%2) ? 'class="odd"': 'class="even"');
            }
        ?>
        <tr <?=$style?>>
            <td align="center"><?= ($key+1) ?></td>
            <td><?= datefmysql($rows['tanggal']) ?></td>
            <td class="no-wrap"><?= $rows['barang']." ".$rows['nilai_konversi']." ".$rows['satuan'] ?></td>
            <td class="no-wrap"><?= $rows['batch'] ?></td>
            <td class="no-wrap"><?= datefmysql($rows['ed']) ?></td>
            <td class="no-wrap"><?= $rows['jenis_transaksi'] ?></td>
            <td class="no-wrap"><?= $rows['unit'] ?></td>
            <td><?= $rows['awal']?></td>
            <td><?= $rows['masuk']?></td>
            <td><?= $rows['keluar']?></td>
            <td><?= $rows['sisa']?></td>
            <td><?= $rows['satuan'] ?></td>
            <td><?=rupiah($rows['hpp'])?></td>
            <td><?=rupiah($rows['hpp']*$rows['sisa'])?></td>
            <td align="center"><?= isset($rows['rop'])?hitung_rop($rows['rop']):0?></td>
        </tr>
       <?php endforeach; ?>
    </table>
     </div>
     <span class="cetak" >Cetak</span>
     <a href="<?= app_base_url('inventory/report/stok-barang-excel/?startDate='.$startDate.'&endDate='.$endDate.'&unit='.$unit.'&packing='.$packing.'&jenisTransaksi='.$jenisTransaksi.'')?>" class="excel">Cetak Excel</a>
 </fieldset><br/>

<a class="button" href="<?= app_base_url('inventory/pemesanan') ?>">Pemesanan</a>
<script type="text/javascript">
    $(document).ready(function(){
        $(".cetak").click(function(){
            var win = window.open('report/stok-barang?startDate=<?= $startDate?>&endDate=<?= $endDate?>&unit=<?= $unit?>&packing=<?= $packing?>&jenisTransaksi=<?= $jenisTransaksi?>', 'MyWindow', 'width=800px,height=600px,scrollbars=1');
        })
    })
</script>    
<?
//app_base_url('inventory/report/stok-barang?startDate='.$startDate.'&endDate='.$endDate.'&unit='.$unit.'&packing='.$packing.'&jenisTransaksi='.$jenisTransaksi.'')
?>