<?php
include_once "app/lib/common/functions.php";
include_once "app/lib/common/master-data.php";
include 'app/actions/admisi/pesan.php';

$idunit = $_SESSION['id_unit'];
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$code = isset($_GET['code']) ? $_GET['code'] : NULL;
$perPage = 15;
$gdg = 1;
$data = array();
?>
<script type="text/javascript">
    $(function() {
        $('#barang').autocomplete("<?= app_base_url('/inventory/search?opsi=namabarang3') ?>",
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
                var str=ac_nama_packing_barang([data.generik, data.nama_barang, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik], null)
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            var str=nama_packing_barang([data.generik, data.nama_barang, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik],null)
            $(this).attr('value', str);
            $('#idPacking').attr('value',data.id);
            $('#stb').html(data.satuan_terbesar);
        }
    );

        //$('input[type=text]').val('');

    });
</script>
<script type="text/javascript">
    function cekForm(){
        if($("#barang").val() == ""){
            alert('Nama barang tidak boleh kosong');
            $('#barang').focus();
            return false;
        }        
        if(($("#barang").val()!='')&&($("#idPacking").val() == "")){
            alert('Nama packing barang tidak diketahui');
            $('#barang').focus();
            return false;
        }
        if($("#idPacking").val() == ""){
            alert('Nama barang tidak boleh kosong');
            $('#barang').focus();
            return false;
        }
        if($("#jumlah").val() == ""){
            alert('Jumlah tidak boleh kosong');
            $('#jumlah').focus();
            return false;
        }/** Kata Mas Uji ga usah pake validasi Batch sama HNA
        if($("#batch").val() == ""){
            alert('No Batch tidak boleh kosong');
            $('#batch').focus();
            return false;
        }*/
        if($("#ed").val() == ""){
            alert('ED tidak boleh kosong');
            $('#ed').focus();
            return false;
        }
        if($("#hpp").val() == ""){
            alert('HPP tidak boleh kosong');
            $('#hpp').focus();
            return false;
        }/*
        if($("#hna").val() == ""){
            alert('HNA tidak boleh kosong');
            $('#hna').focus();
            return false;
        }*/
    }
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".tanggal").datepicker({
            changeYear : true,
            changeMonth : true,
            dateFormat: 'dd/mm/yy'
        })
  $('#stb').css('font-size','12px')
$('#stb').css('margin-top','5px')
    })
</script>

<?
if (isset($_GET['do']) && $_GET['do'] == "edit") {
    $data = stock_opname_muat_data($_GET['id'], $gdg);
    foreach ($data as $row);
}
$hpp = isset($row['hpp']) ? inttocur($row['hpp']) : "";
$hna = isset($row['hna']) ? inttocur($row['hna']) : "";
?>
<h2 class="judul">Stock Opname Gudang</h2><?= isset($pesan) ? $pesan : NULL ?>
<div class="data-input">
    <form action="<?= app_base_url('inventory/control/stok-opname') . '?gudang=1'?>" method="POST" onsubmit="return cekForm()">
        <fieldset>
            <legend>Form Stock Opname Gudang</legend>
            <label for="barang">Nama Packing Barang</label>
            <input type="text" id="barang" name="barang" value="<?= isset($row['barang']) ? $row['barang'] : NULL ?>" class="auto nama_barang">
            <input type="hidden" name="idPacking" id="idPacking" value="<?= isset($row['id_packing_barang']) ? $row['id_packing_barang'] : NULL ?>">
            <input type="hidden" name="idStok" value="<?= isset($row['id']) ? $row['id'] : NULL ?>">
             <fieldset class="field-group">
                <label for="jumlah">Jumlah</label><input type="text" maxlength="11" name="jumlah" id="jumlah" class="tgl" onkeyup="Desimal(this)" value="<?= isset($row['sisa']) ? $row['sisa'] : NULL ?>"> <span id='stb'><?= isset($row['besar']) ? $row['besar'] : NULL ?></span>
         </fieldset>
<?
            if ($gdg == 1) {
?>
                <label for="nobatch">No. Batch</label><input type="text" name="batch" id="batch" value="<?= isset($row['batch']) ? $row['batch'] : NULL ?>">
                <fieldset class="field-group">
                    <label for="ed">E.D</label><input type="text" name="ed" id="ed" class="tanggal tgl" value="<?= isset($row['ed']) ? datefmysql($row['ed']) : NULL ?>">
                </fieldset>
<? } ?>
            <label for="hpp"><span class="field-group">Harga  Beli</span> (Rp.)</label><input type="text" name="hpp" id="hpp" onKeyup="formatNumber(this)" class="right" value="<?= $hpp ?>" maxlength="14">
            <label for="hna">Harga Jual(Rp.)</label><input type="text" name="hna" id="hna" onKeyup="formatNumber(this)" class="right" value="<?= $hna ?>" maxlength="14">
            <fieldset class="input-process">
                <input type="submit" class="tombol" value="Simpan" name="simpan">
                <input type="button" class="tombol" value="Batal" onClick="javascript:location.href='<?= app_base_url('inventory/stok-opname') ?>'">
            </fieldset>
        </fieldset>
    </form>
</div>
<div class="floright" style="margin: -5px 0 0 0">
                            <form action="" method="GET" class="search-form">
                                 <span style="float:right;">Nama: <input type="text" name="code" class="search-input" id="keyword" value="<?= $code?>"/><input type="submit" value="" class="search-button"/></span>
                            </form>
                        </div>    
<div class="data-list tabelflexibel">
    <table cellpadding="0" cellspacing="0" border="0" id="table" class="tabel" style="width: 100%">
        <tr>
            <th style="width:15%">Waktu</th>
            <th style="width:40%">Nama Packing Barang</th>
<?
            if ($gdg == 1) {
?>
                <th style="width:5%">No. Batch</th>
                <th style="width:10%">E.D</th>
<? } ?>
            <th style="width:3%">Jummlah Sisa</th>
            <th style="width:3%">Kemasan</th>
            <th style="width:4%">Harga  Beli(Rp.)</th>
            <th style="width:4%">Harga Jual (Rp.)</th>
            <th style="width: 4%">Aksi</th>
        </tr>
        <?
            $total_aset = 0;
            $stok = stock_opname_muat_data2($gdg, $page, $perPage, $code);
			//show_array($stok);
            foreach ($stok['list'] as $key => $row) {
			if($row['waktu']  !=''){
                $nama = "$row[barang]";   
                $nama=nama_packing_barang(array($row['generik'],$row['barang'],$row['kekuatan'],$row['sediaan'],$row['nilai_konversi'],$row['satuan'],$row['pabrik']));
        ?>
        <tr class="<?= ($key % 2) ? 'even' : 'odd' ?>">
            <td class="no-wrap"><?= $row['waktu'] ?></td>
            <td class="no-wrap"><?=$nama?></td>
            <?
                if ($gdg == 1) {
            ?>
                    <td align="center"><?= $row['batch'] ?></td>
                    <td align="center"><?= datefmysql($row['ed']) ?></td>
        <? } ?>
                    <td align="center"><?= $row['sisa'] ?></td>
                    <td align="center"><?= $row['kemasan'] ?></td>
                    <td align="right"><?= rupiah2($row['hpp']) ?></td>
                    <td align="right"><?= rupiah2($row['hna']) ?></td>
                    <td class="aksi"><a class="edit" href="<?php app_base_url('inventory/stok-opname-gudang') ?>?do=edit&id=<?php echo $row['id'] ?>&<?=generate_get_parameter($_GET, null, array('msr','msg','do','id'))?>">Edit</a></td>
                </tr>
<?
            $total_aset = $total_aset + $row['hna'];
			}
            }
?>
                </table>
            </div>
<?php
            echo $stok['paging'];
            $count = $stok['total'];
            // echo "<p>Jumlah Total: " . $count . "</p>"; // -> Suruh ganti jumlah total aset pake HNA seperti di bawah..
            echo "<p>Jumlah Total Aset: Rp ".rupiah($total_aset)."</p>"
?>