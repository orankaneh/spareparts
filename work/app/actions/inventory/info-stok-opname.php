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
            
        $('#display').click(function () {
            var awal = $('#awal').val();
            var akhir= $('#akhir').val();
            var idBarang = $('#idBarang').val();
            $.ajax({
                url: "<?= app_base_url('inventory/info-stok-opname-table') ?>",
                cache: false,
                data:'startDate='+awal+'&endDate='+akhir+'&idBarang='+idBarang,
                success: function(msg){
                    $('#show').html(msg);
                }
            })
        })
});

        

</script>

    
<h2 class="judul">Laporan Transaksi Stock Opname Pelayanan</h2>
<?= isset($pesan) ? $pesan : NULL ?>
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
                <input type="button" value="Cari" id="display" class="tombol" />
                <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/info-stok-opname') ?>'"/>
            </fieldset>
    </form>    
</fieldset>
</div>
<div class="data-list" id="show">
    
</div>    