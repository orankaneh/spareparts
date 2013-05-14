<script type="text/javascript">
    function initAutocompleteBarang(index){
        $('#barang'+index).autocomplete("<?= app_base_url('/inventory/search?opsi=namabarang') ?>",
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
                if(data.generik!=null && data.generik!=''){
                    var pabrik='';
                    if(data.generik=='Generik'){
                        pabrik='<br>\n\<b>Pabrik :</b><i>'+data.pabrik+'</i>';
                    }
                    if(data.kekuatan!=null && data.kekuatan!=0){
                        var str='<div class=result><b>'+data.nama_barang+'</b> <i>'+data.kekuatan+', '+data.sediaan+' @'+data.nilai_konversi+' '+data.satuan_terkecil+'</i>'+pabrik+'</div>';
                    }else{
                        var str='<div class=result><b>'+data.nama_barang+'</b> <i>' +data.sediaan+' @'+data.nilai_konversi+' '+data.satuan_terkecil+'</i>'+pabrik+'</div>';
                    }
                }else{
                    if(data.kekuatan!=null && data.kekuatan!=0){
                        var str='<div class=result><b>'+data.nama_barang+'</b> <i>'+data.kekuatan+', '+data.sediaan+' @'+data.nilai_konversi+' '+data.satuan_terkecil+'</i></div>';
                    }else{
                        var str='<div class=result><b>'+data.nama_barang+'</b> <i>'+' @'+data.nilai_konversi+' '+data.satuan_terkecil+'</i></div>';
                    }
                }
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            var kekuatan=(data.kekuatan!=null && data.kekuatan!=0)?' '+data.kekuatan+',':'';
            var sediaan=(data.sediaan!=null)?' '+data.sediaan:'';
            var pabrik='';
            if(data.generik=='Generik'){
                pabrik=' '+data.pabrik;
            }
            $(this).attr('value', data.nama_barang+kekuatan+sediaan+' @'+data.nilai_konversi+' '+data.satuan_terkecil+pabrik);
            $('#satuan'+index).attr('value',data.satuan_terbesar);
        }
    );
        $('#tanggal'+index).datepicker({
            changeMonth: true,
            changeYear: true
        });
    }
    function cekJumlahTerima(index){
        if($('#jumlah_terima'+index).html()*1<$('#jumlah'+index).attr('value')*1){
            $('#jumlah'+index).attr('value','0');
        }
    }
</script>
<?
require 'app/lib/common/master-data.php';
$data = _select_arr("select id,DATE(waktu) as waktu from retur_pembelian where id=$_GET[noretur]");
$data = $data[0];
$idReretur = _select_unique_result("select max(id) as id from reretur_pembelian");
?>
<h2 class="judul">Pengembalian Retur Pembelian</h2>
<form action="<?= app_base_url('inventory/control/pengembalian-retur-barang-control') ?>" method="post">
    <div class="data-input">
        <fieldset><legend>Form Pengembalian Retur Barang</legend>
            <label for="petugas">Petugas</label><span><?= User::$nama ?></span>
            <label for="no-transaksi">No Transaksi</label><span><?= $idReretur['id'] ?></span>
            <label for="no-transaksi">No Surat</label><input type="text" name="nosurat"/>
            <label for="no-surat-retur">No Surat Retur</label><input type="text" name="noretur" id="no-surat-retur" value="<?= $data['id'] ?>"/>
            <label for="awal">Tanggal</label><input type="text" name="tanggal" id="awal" value="<?= datefmysql($data['waktu']) ?>"/>
        </fieldset>
    </div>
    <div class="data-list">
        <table class="table-input">
            <tr>
                <th>No</th>
                <th>Barang</th>
                <th>No.Faktur</th>
                <th>No Batch</th>
                <th>Tgl Kadaluarsa</th>
                <th>Jml Retur</th>
                <th>Jml Terima</th>
                <th>Harga</th>
            </tr>
            <?php
            $data = detail_retur_muat_data($_GET['noretur']);
            $i = 0;
            foreach ($data as $d) {
 ?>
                <tr>
                    <td align="center"><?= ++$i ?></td>
                    <td align="center">
                        <input type="text" id="barang<?= $i ?>" value="<?= "$d[barang] $d[kekuatan] $d[sediaan] @$d[nilai_konversi] $d[satuan_terkecil] $d[pabrik]"; ?>" size="50"/>
                        <input type="hidden" name="barang[<?= $i ?>][iddetail]" id="barang<?= $i ?>" value="<?= $d['iddetail'] ?>"/>
                        <input type="hidden" name="barang[<?= $i ?>][idpacking]" id="packing<?= $i ?>" value="<?= $d['id_packing'] ?>"/>
                    </td>
                    <td align="center"><?= $d['no_faktur'] ?></td>
                    <td align="center"><input type="text" name="barang[<?= $i ?>][nobatch]" value="<?= $d['batch'] ?>" size="10"/></td>
                    <td align="center"><input type="text" name="barang[<?= $i ?>][tgl]" id="tanggal<?= $i ?>" class="tanggal" size="10"/></td>
                    <td align="center" id="jumlah_terima<?= $i ?>" width="50px"><?= $d['jumlah_retur'] ?></td>
                    <td align="center"><input type="text" name="barang[<?= $i ?>][jumlah]" id="jumlah<?= $i ?>" onkeyup="Angka(this)" onblur="cekJumlahTerima(<?= $i ?>)" size="10"/></td>
                    <td align="center"><input type="text" class="right" name="barang[<?= $i ?>][harga]" size="10" onkeyup="formatNumber(this)"/></td>
                </tr>
                <script type="text/javascript">initAutocompleteBarang(<?= $i ?>);</script>
<?php } ?>
        </table>
        <br/>
        <input class="tombol" type="submit" value="Simpan" name="save"/>
        <input onClick="javascript:location.href='<?= app_base_url('inventory/surat-retur') ?>'" class="tombol" type="button" value="Batal" />
    </div>
</form>