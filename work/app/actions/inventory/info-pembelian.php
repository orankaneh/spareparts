<?
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';
include 'app/actions/admisi/pesan.php';
set_time_zone();

$startDate = (isset($_GET['startDate'])) ? get_value('startDate') : date("d/m/Y");
$endDate = (isset($_GET['endDate'])) ? get_value('endDate') : date("d/m/Y");
$awalJatuhTempo = (isset($_GET['awalJatuhTempo'])) ? get_value('awalJatuhTempo') : date("d/m/Y");
$akhirJatuhTempo = (isset($_GET['akhirJatuhTempo'])) ? get_value('akhirJatuhTempo') : date("d/m/Y");

$pembelian = pembelian_muat_data(date2mysql($startDate), date2mysql($endDate), get_value('idSuplier'), get_value('idPegawai'), NULL, NULL,get_value('idPacking'),get_value('batch'));
//show_array($pembelian);
?>
<script type="text/javascript">
    $(function() {
        $('input[name=packing]').unautocomplete().autocomplete("<?= app_base_url('/inventory/search?opsi=packing_barang') ?>",
        {
            parse: function(data){
                var parsed = [];
                for (var i=0; i < data.length; i++) {
                    parsed[i] = {
                        data: data[i],
                        value: data[i].barang // nama field yang dicari
                    };
                }

                return parsed;
            },
            formatItem: function(data,i,max){
                var str='';
            var str=ac_nama_packing_barang([data.generik, data.barang, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik], null)
return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            var str=nama_packing_barang([data.generik, data.barang, data.kekuatan, data.sediaan, data.nilai_konversi, data.satuan_terkecil, data.pabrik], null)

$(this).attr('value', str);
    $('#idPacking').attr('value',data.id);
        });
        
        $('#suplier').autocomplete("<?= app_base_url('/inventory/search?opsi=suplier') ?>",
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
                $('#idSuplier').attr('value', '');
                var str='<div class=result>'+data.nama+' <br/><i> '+data.alamat+' , '+data.nama_kelurahan+'</i></div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $('#suplier').attr('value',data.nama);
            $('#idSuplier').attr('value',data.id);
        });

        $('#pegawai').autocomplete("<?= app_base_url('/admisi/search?opsi=pegawai_info') ?>",
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
                $('#idPegawai').attr('value','');
                var str='<div class=result>'+data.nama+'<br />'+data.alamat_jalan+'</div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.nama);
            $('#idPegawai').attr('value',data.id_pegawai);
        });
        
        $('input[name=batch]').autocomplete("<?= app_base_url('/inventory/search?opsi=batch') ?>",
        {
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
                var str='<div class=result>'+data.batch+'</div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.batch);
        });
        
    });
    $(document).ready(function(){
        $("#awalJatuhTempo,#akhirJatuhTempo").datepicker({
            changeYear:true,
            changeMonth:true,
            dateFormat:'dd/mm/yy'
        })
    })
</script>
<h2 class="judul">Informasi Pembelian</h2><?= isset($pesan) ? $pesan : NULL ?>
<form action="<?= app_base_url('/inventory/info-pembelian') ?>" method="GET">
    <div class="data-input">
        <fieldset>
            <fieldset class="field-group">
                <label>Tanggal Faktur</label>
                <input type="text" name="startDate" class="tanggal" id="awal" value="<?= $startDate ?>"/><label class="inline-title">s . d &nbsp;</label><input type="text" name="endDate" class="tanggal" id="akhir" value="<?= $endDate ?>"/>
            </fieldset>
            <label for="suplier">Nama Suplier</label><input type="text" name="suplier" id="suplier" value="<?= get_value('suplier') ?>"/>
            <input type="hidden" name="idSuplier" id="idSuplier" value="<?= get_value('idSuplier') ?>"/>
            <fieldset class="field-group">
               <!-- <label>Tanggal Jatuh Tempo</label>
                <input type="text" name="awalJatuhTempo" class="tanggal" id="awalJatuhTempo" value="<?//$awalJatuhTempo ?>"/><label class="inline-title">s . d &nbsp;</label><input type="text" name="akhirJatuhTempo" class="tanggal" id="akhirJatuhTempo" value="<?//$akhirJatuhTempo ?>"/>-->
            </fieldset>
            <label for="barang">Nama Pegawai</label>
            <input type="text" name="pegawai" id="pegawai" value="<?= get_value('pegawai') ?>">
            <input type="hidden" name="idPegawai" id="idPegawai" value="<?= get_value('idPegawai') ?>"/>
            <label>Packing Barang</label><input type="text" name="packing" value="<?=get_value('packing')?>">
            <input type="hidden" name="idPacking" id="idPacking" value="<?=get_value('idPacking')?>">
            <label>No. Batch</label><input type="text" name="batch" value="<?=get_value('batch')?>">
            <fieldset class="input-process">
                <input type="submit" value="Cari" class="tombol" name="cari"/>
                <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/info-pembelian') ?>'"/>
            </fieldset>
        </fieldset>
    </div>
    <fieldset><legend>Hasil Pencarian</legend>
    <?php if(isset ($_GET['cari'])){ 
	?>    
    <div class="data-list">
        <table width="55%" class="tabel full">
            <tr>
                <th style="width: 10%">Tanggal Faktur</th>
                <th style="width: 10%">No. Surat</th>
                <th>Suplier</th>
                <th style="width: 10%">Tgl. Jatuh Tempo</th>
                <th style="width: 10%">Harga</th>
                <th style="width: 10%">PPN (%)</th>
                <th style="width: 10%">Materai (Rp.)</th>
                <th style="width: 10%">Diskon (Rp.)</th>
                  <th style="width: 10%">jumlah (Rp.)</th>
                <th>Aksi</th>
            </tr>
            <?php
            $totalBeli = 0;
            $totalMaterai = 0;
            $totalPPN = 0;
            $totalAll=0;
            $totalDiskon=0;
            foreach ($pembelian as $key => $row):
                $subDiskon = 0;
                $total = 0;
                $jumlah = _select_arr("select dpr.harga_pembelian,dpr.diskon,dpr.jumlah_pembelian,
                        pb.nilai_konversi 
                    from detail_pembelian dpr 
                        join packing_barang pb on dpr.id_packing_barang = pb.id 
                    where dpr.id_pembelian = '$row[id]'");
                foreach ($jumlah as $rows) {
                    $harga = $rows['harga_pembelian'] * $rows['jumlah_pembelian'];
                    $diskon = $harga * ($rows['diskon'] / 100);
                    $subDiskon = $subDiskon + $diskon;
                    $selisih = $harga - $diskon;
                    $total = $total + $selisih;
                    $totalAll = $totalAll + $total;
                    $totalDiskon = $totalDiskon + $diskon;
                    $ppnn=$total * ($row['ppn'] / 100);
                    $jum=$total+$ppnn+$row['materai'];
                }
                ?>
                <tr class="<?= ($key % 2) ? 'even' : 'odd' ?>">
                    <td align="center"><?= datefmysql($row['waktu']) ?></td>
                    <td align="center"><?= $row['no_faktur'] ?></td>
                    <td class="no-wrap"><?= $row['suplier'] ?></td>
                    <td align="center"><?= datefmysql($row['tanggal_jatuh_tempo']) ?></td>
                    <td align="right"><?= rupiah($total) ?></td>
                    <td align="right"><?= rupiah(($total * ($row['ppn'] / 100))) ?></td>
                    <td align="right"><?= rupiah($row['materai']) ?></td>
                    <td align="right"><?= rupiah($subDiskon) ?></td>
                    <td align="right"><?= rupiah($jum) ?></td>
                    <td class="aksi">
                        <a href="<?= app_base_url('inventory/info-pembelian?no='.$row['no_faktur'].'&id=' . $row['id']).'&'.generate_get_parameter($_GET,array(),array('id','no')) ?>" class="detail">detail</a>
						<a href="<?=app_base_url('inventory/pembelian-edit?id='.$row['id'])?>" class="edit">edit</a>
                    </td>
                </tr>
                <?php
                $totalBeli = $totalBeli + $jum;
                $totalMaterai = $totalMaterai + $row['materai'];
                $totalPPN = $totalPPN + $ppnn;
            endforeach;
            ?>
        </table>
    </div>
    <div class="perpage" style="float:right">
        <span class="cetak" id="cetak">Cetak</span>
        <a href="<?= app_base_url('inventory/report/pembelian-excel/?startDate=' . $startDate . '&endDate=' . $endDate . '&idSuplier=' . get_value('idsuplier') . '&idPegawai=' . get_value('idPegawai') . '&awalJatuhTempo=' . get_value('awalJatuhTempo') . '&akhirJatuhTempo=' . get_value('akhirJatuhTempo') . '') ?>" class="excel">Cetak Excel</a>
    </div>
    <div class="perpage">
        <ul style="padding-left:25px">
            <li style="list-style:lower-roman">Total Pembelian: <?= isset($totalBeli) ? rupiah($totalBeli) : ""; ?></li>
            <li style="list-style:lower-roman">Total PPN: <?= isset($totalPPN) ? rupiah($totalPPN) : ""; ?></li>
            <li style="list-style:lower-roman">Total Materai: <?= isset($totalMaterai) ? rupiah($totalMaterai) : ""; ?></li>
            <li style="list-style:lower-roman">Total Diskon: <?= isset($totalDiskon) ? rupiah($totalDiskon) : ""; ?></li>
        </ul>
    </div>
    <?php
    if (isset($_GET['id']) && $_GET['id'] != "") {
        $detail = detail_pembelian_muat_data($_GET['id']);
        ?>
        <br /><br />
        Detail Pembelian:<?= $_GET['id'] ?>
        <div class="data-list">
            <table class="tabel full">
                <tr>
                    <th>No</th>
                    <th>Nama Packing Barang</th>
                    <th>No Batch</th>
                    <th>Jumlah Pembelian</th>
                    <th>Harga@</th>
                    <th>Sub Total</th>
                    <th>Diskon (%)</th>
                    <th>Nilai Diskon (Rp.)</th>
                </tr>
                <?php
                foreach ($detail as $num => $rows) {
                    $class = ($num % 2) ? 'even' : 'odd';
                    $style = "class='$class'";
                 $nama=nama_packing_barang(array($rows['generik'],$rows['nama'],$rows['kekuatan'],$rows['sediaan'],$rows['nilai_konversi'],$rows['satuan_terkecil'],$rows['pabrik']));
                    $subtotal=$rows['jumlah_pembelian']*$rows['harga_pembelian'];
                    ?>
                    <tr <?= $style ?>>
                        <td align="center"><?= ++$num ?></td>
                        <td class="no-wrap"><?= $nama ?></td>
                        <td align="center"><?= $rows['batch'] ?></td>
                        <td align="center"><?= ($rows['jumlah_pembelian']) ?></td>
                        <td class="no-wrap" align="right"><?= rupiah($rows['harga_pembelian']) ?></td>
                        <td align="right"><?= rupiah($subtotal) ?></td>
                        <td align="center"><?= $rows['diskon'] ?></td>
                        <td align="right"><?= rupiah(($subtotal*$rows['diskon'])/100) ?></td>
                    </tr>                
                    <?php
                }
                ?>
            </table>
        </div>
           <div class="perpage" style="float:right">
        <span class="cetak" id="detail">Cetak</span>
        <a href="<?= app_base_url('inventory/report/pembelian-detail-excel/?id=' . get_value('id') . '&no=' . get_value('no') . '') ?>" class="excel">Cetak Excel</a>
    </div>
        <?php
    }
    }else { echo "<span class='tips'>Silahkan menggunakan opsi pencarian di atas</span>"; }?>
</fieldset>
<script type="text/javascript">
    $(document).ready(function(){
        $("#cetak").click(function(){
            var win = window.open('report/pembelian?startDate=<?= $startDate ?>&endDate=<?= $endDate ?>&idsuplier=<?= get_value('idsuplier') ?>&idPegawai=<?= get_value('idPegawai') ?>&awalJatuhTempo=<?= get_value('awalJatuhTempo') ?>&akhirJatuhTempo=<?= get_value('akhirJatuhTempo') ?>', 'MyWindow', 'width=800px,height=600px,scrollbars=1');
        })
    
	 $("#detail").click(function(){
            var win = window.open('report/pembelian-detail?id=<?= get_value('id') ?>&no=<?= get_value('no') ?>', 'MyWindow', 'width=1024px,height=600px,scrollbars=1');
        })
    })
</script>