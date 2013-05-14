<?php
include_once "app/lib/common/functions.php";
include_once "app/lib/common/master-data.php";
include 'app/actions/admisi/pesan.php';
$gdg=2;
$idunit = $_SESSION['id_unit'];
$code = isset($_GET['code']) ? $_GET['code'] : NULL;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$perPage = 15;
$data = array();
?>
<script type="text/javascript">
    $(function() {
        $('#barang').focus();
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
                    var str=ac_nama_packing_barang([data.generik, data.nama_barang, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik],null);
                    return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
                var str=nama_packing_barang([data.generik, data.nama_barang, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik]);

                $(this).attr('value', str);
            $('#idPacking').attr('value',data.id);
            $('#stb').html(data.satuan_terbesar);
			$('.stb').html(' / '+data.satuan_terbesar);
        }
    );
            $('#batch').autocomplete("<?= app_base_url('/inventory/search?opsi=barang_stok').'&key=batch' ?>",
            {
                extraParams:{
                    id_packing: function() { return $('#idPacking').attr('value'); 
                    },
                    batch: function(){return $('#batch').attr('value')}
                    
                }, 
                parse: function(data){
                    var parsed = [];
                    for (var i=0; i < data.length; i++) {
                        parsed[i] = {
                            data: data[i],
                            value: data[i].batch // nama field yang dicari
                        };
                    }
                    return parsed;
                },
                formatItem: function(data,i,max){
                    return '<div class=result>'+data.batch+'</div>';
                },
                width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
            function(event,data,formated){
               $(this).attr('value',data.batch);
            });
        //$('input[type=text]').val('');

    });
</script>
<script type="text/javascript">
    function cekForm(){
        if($("#barang").val() == ""){
            alert('Nama barang tidak boleh kosong');
            $('#barang').focus();
            return false;
        }else if($("#jumlah").val() == ""){
            alert('Jumlah tidak boleh kosong');
            $("#jumlah").focus();
            return false;
        }else if($("#idPacking").val() == ""){
            alert('Nama barang tidak boleh kosong');
            $('#barang').focus();
            return false;
        }else if($("#batch").val() == ""){
            alert('Batch tidak boleh kosong');
            $('#batch').focus();
            return false;
        }
    }
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".tanggal").datepicker({
            changeYear : true,
            changeMonth : true
        })
    })
</script>

<?
if (isset($_GET['do']) && $_GET['do'] == "edit") {
    $data = stock_opname_muat_data($_GET['id'], $gdg);
    foreach ($data as $row
        );
}
$hpp = isset($row['hpp']) ? inttocur($row['hpp']) : "";
$hna = isset($row['hna']) ? inttocur($row['hna']) : "";
?>
<h2 class="judul">Stock Opname Pelayanan</h2><?= isset($pesan) ? $pesan : NULL ?>
<div class="data-input">
    <form action="<?= app_base_url('inventory/control/stok-opname') ?>" method="POST" onsubmit="return cekForm()">
        <fieldset>
            <legend>Form Stock Opname Pelayanan</legend>
            <label for="barang">Nama Packing Barang*</label>
            <input type="text" id="barang" name="barang" value="<?= isset($row['barang']) ? $row['barang'] : NULL ?>" class="nama_barang">
            <input type="hidden" name="idPacking" id="idPacking" value="<?= isset($row['id_packing_barang']) ? $row['id_packing_barang'] : NULL ?>">
            <input type="hidden" name="idStok" value="<?= isset($row['id']) ? $row['id'] : NULL ?>">
            <label for="batch">Batch</label>
            <input type="text" name="batch" id="batch" value="<?= isset($row['batch']) ? $row['batch'] : NULL ?>"/>
            <fieldset class="field-group">
                <label for="jumlah">Jumlah*</label><input maxlength="12" type="text" name="jumlah" id="jumlah" class="tgl" onkeyup="Desimal(this)" value="<?= isset($row['sisa']) ? $row['sisa'] : NULL ?>"><span id='stb' style="font-size: 12px; margin-top: 5px; "><?= isset($row['besar']) ? $row['besar'] : NULL ?></span>
            </fieldset>
            <label for="hpp">Harga Jual* (Rp.)</label><input type="text" name="hpp" id="hpp" onKeyup="formatNumber(this)" class="right" value="<?= $hpp ?>" maxlength="11"><span class='stb' style="font-size: 12px; margin-top: 5px; "><?= isset($row['besar']) ? ' / '.$row['besar'] : NULL ?></span>
            <label for="hna">Harga Beli* (Rp.)</label>
            <input type="text" name="hna" id="hna" onKeyup="formatNumber(this)" class="right" value="<?= $hna ?>" maxlength="11"><span class='stb' style="font-size: 12px; margin-top: 5px; "><?= isset($row['besar']) ? ' / '.$row['besar'] : NULL ?></span>
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
            <th style="width:5%">No</th>
            <th style="width:10%">Waktu</th>
            <th style="width:35%">Nama Barang</th>
            <th style="width:10%">Batch</th>
            <th style="width:3%">Stok Akhir</th>
            <th style="width:8%">Harga Jual(Rp.)</th>
            <th style="width:8%">Harga Beli (Rp.)</th>
            <th style="width:4%">Aksi</th>
        </tr>
        <?
            $total_aset = 0;
            $stok = stock_opname_muat_data2($gdg, $page, $perPage, $code);
            foreach ($stok['list'] as $key => $row) {
                $nama=nama_packing_barang(array($row['generik'],$row['barang'],$row['kekuatan'],$row['sediaan'],$row['nilai_konversi'],$row['satuan'],$row['pabrik']));    
        ?>
        <tr class="<?= ($key % 2) ? 'even' : 'odd' ?>">
            <td align="center"><?= ++$key ?></td>
            <td class="no-wrap"><?= $row['waktu'] ?></td>
            <td class="no-wrap"><?=$nama?></td>
            <td class="no-wrap"><?=$row['batch']?></td>
            <td align="center"><?= $row['sisa'] ?></td>
            <td align="right"><?= rupiah2($row['hpp']) ?></td>
            <td align="right"><?= rupiah2($row['hna']) ?></td>
            <td class="aksi"><a class="edit" href="<?php app_base_url('inventory/stok-opname') ?>?do=edit&id=<?php echo $row['id'] ?>&<?=generate_get_parameter($_GET, null, array('msr','msg','do','id'))?>">Edit</a></td>
                </tr>
<?
            $total_aset = $total_aset + $row['hna'];
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