<?php
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';
require_once 'app/actions/admisi/pesan.php';
set_time_zone();

$startDate = (isset($_GET['startDate'])) ? get_value('startDate') : date("d/m/Y");
$endDate = (isset($_GET['endDate'])) ? get_value('endDate') : date("d/m/Y");
$barang = isset ($_GET['barang'])?$_GET['barang']:NULL;
$idBarang = isset ($_GET['idBarang'])?$_GET['idBarang']:NULL;
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
$('#idBarang').attr('value',data.id);
            }
        );
            
//        $('#display').click(function () {
//            var awal = $('#awal').val();
//            var akhir= $('#akhir').val();
//            var idBarang = $('#idBarang').val();
//            $.ajax({
//                url: "<?= app_base_url('inventory/info-stok-opname-table') . '?gudang=1'?>",
//                cache: false,
//                data:'startDate='+awal+'&endDate='+akhir+'&idBarang='+idBarang,
//                success: function(msg){
//                    $('#show').html(msg);
//                }
//            })
//        })
});

        

</script>

    
<h2 class="judul">Informasi Transaksi Stock Opname Gudang</h2><?= isset($pesan) ? $pesan : NULL ?>
<div class="data-input">
    <fieldset><legend>Form Pencarian</legend>
    <form action="" method="GET">
            <fieldset class="field-group">
            <label for="tanggal">Range Tanggal</label>
            <input type="text" name="startDate" class="tanggal" id="awal" value="<?= $startDate ?>"/><label class="inline-title">s . d &nbsp;</label><input type="text" name="endDate" class="tanggal" id="akhir" value="<?= $endDate ?>"/>
            </fieldset>
            <label for="barang">Nama Barang</label>
            <input type="text" name="barang" id="barang" value="<?= $barang?>" class="nama_barang">
            <input type="hidden" name="idBarang" id="idBarang" value="<?= $idBarang?>">
            <fieldset class="input-process">
                <input type="hidden" name="gudang" value="1">
                <input type="submit" value="Cari" name="search" id="display" class="tombol" />
                <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/info-stok-opname-gudang') ?>'"/>
            </fieldset>
    </form>    
</fieldset>
</div>
<fieldset>
    <legend>Hasil Pencarian</legend>
<div class="data-list" id="show">
    <?php
    if(isset ($_GET['search']) && $_GET['search'] == 'Cari'){
    $startDate = (isset($_GET['startDate'])) ? get_value('startDate') : date("d/m/Y");
    $endDate = (isset($_GET['endDate'])) ? get_value('endDate') : date("d/m/Y");
    $barang = isset ($_GET['barang'])?$_GET['barang']:NULL;
    $idBarang = isset ($_GET['idBarang'])?$_GET['idBarang']:NULL;
    $gudang = (isset($_GET['gudang']))?$_GET['gudang']:null;
    ?>
    <table cellpadding="0" cellspacing="0" border="0" id="table" class="tabel" style="width: 80%">
        <tr>
<!--            <th style="width:5%">No</th>-->
            <th style="width:20%">Waktu</th>
            <th>Nama Barang</th>
               <? if ($gudang == 1) {
			   ?>
                <th>No. Batch</th>
                 <th>E.D</th>
                 <?
				 }
				 ?>

            <th>Harga Beli(RP.)</th>
            <th>Harga Jual(RP.)</th>
            <th style="width:10%">Stok Akhir</th>
        </tr>
        <?
            if ($gudang == 1) {
                $stok = info_stock_opname_gudang_muat_data($idBarang, $startDate, $endDate);
            }
            else{
                $stok = info_stock_opname_muat_data($idBarang, $startDate, $endDate);
            }
			//show_array($stok);
           foreach ($stok as $key => $row){
           
           $nama=nama_packing_barang(array($row['generik'],$row['barang'],$row['kekuatan'],$row['sediaan'],$row['nilai_konversi'],$row['satuan'],$row['pabrik']));
        ?>
          <tr class="<?= ($key % 2) ? 'even' : 'odd' ?>">
<!--              <td align="center"><?= ++$key?></td>-->
              <td align="center" class="no-wrap"><?= $row['waktu']?></td>
              <td class="no-wrap"><?=$nama?></td>
               <? if ($gudang == 1) {
			  echo "<td align='center'>".$row['batch']."</td>";
              echo "<td align='center'>".datefmysql($row['ed'])."</td>";
             
              
				 }
				 ?>
              <td align="right"><?= rupiah($row['hpp'])?></td>
              <td align="right"><?= rupiah($row['hna'])?></td>
              <td align="right"><?= $row['sisa']?></td>
          </tr>
    
        <?
           }
		   ?>
            
           <?
    }else{
        echo "<span class='tips'>Silahkan menggunakan opsi pencarian di atas</span>";
    }
        ?>
    </table>
</div>  
  

<a class=excel class=tombol href="<?=app_base_url('inventory/report/stok-opname-barang-gudang-excel?').generate_get_parameter($_GET)?>">Cetak</a>  
</fieldset>    