
<?php
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/master-inventory.php';
require_once 'app/lib/common/functions.php';
include 'app/actions/admisi/pesan.php';
set_time_zone();

$idPegawai = isset($_GET['idPegawai']) ? $_GET['idPegawai'] : NULL;
$pegawai = isset($_GET['pegawai']) ? $_GET['pegawai'] : NULL;
$dokter=get_value('dokter');
$idDokter=get_value('idDokter');
$pembeli=get_value('pembeli');
$idPembeli=get_value('idPembeli');
$jenis = isset($_GET['jenis']) ? $_GET['jenis'] : NULL;
$startDate = (isset($_GET['startDate'])) ? get_value('startDate') : date("d/m/Y");
$endDate = (isset($_GET['endDate'])) ? get_value('endDate') : date("d/m/Y");
if(isset($_GET['startDate'])){
    $penjualan = penjualan_muat_data(date2mysql($startDate), date2mysql($endDate), $jenis, get_value('idPembeli'), $idPegawai,  $idDokter);    
}else{
    $penjualan = penjualan_muat_data(null, null, null,null,null,null);
}
$jumlahPenjualan=$penjualan['num_rows'];
$jumlahNilaiTagihan=empty($penjualan['total_tagihan'][0])?"Rp 0,-":"Rp ".rupiah($penjualan['total_tagihan'][0]).",-";
$jumlahJasaPelayanan=empty($penjualan['total_jasa_pelayanan'])?"Rp 0,-":"Rp ".rupiah($penjualan['total_jasa_pelayanan']).",-";
//show_array($penjualan);
?>
<script type="text/javascript">
    $(function() {
        $('#produkasuransi').autocomplete("<?= app_base_url('/admisi/search?opsi=asuransiProduk') ?>",
        {
            parse: function(data){
                var parsed = [];
                for (var i=0; i < data.length; i++) {
                    parsed[i] = {
                        data: data[i],
                        value: data[i].nama_asuransi// nama field yang dicari
                    };
                }
                return parsed;
            },
            formatItem: function(data,i,max){
                var str='<div class=result>'+data.nama_asuransi+' <br/><i><b>'+data.nama_pabrik+'</b> '+data.nama_kelurahan+'</i></div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $(this).attr('value',data.nama_asuransi+' - '+data.nama_pabrik);
            $('#idprodukasuransi').attr('value', data.id_asuransi);
        }
    );
        $('#pembeli').autocomplete("<?= app_base_url('/admisi/search?opsi=nama') ?>",
        {
            parse: function(data){
                var parsed = [];
                for (var i=0; i < data.length; i++) {
                    parsed[i] = {
                        data: data[i],
                        value: data[i].nama_pas // nama field yang dicari
                    };
                }
                return parsed;
            },
            formatItem: function(data,i,max){
                $('#idPembeli').attr('value','');
                if (data.id_pasien == null) {
                    var str='<div class=result>'+data.nama_pas+' <br/> <i>'+data.alamat_jalan+' '+data.nama_kelurahan+'</i></div>';
                } else {
                    var str='<div class=result><b>'+data.id_pasien+'</b> - '+data.nama_pas+' <br/> <i>'+data.alamat_jalan+' '+data.nama_kelurahan+'</i></div>';
                }
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $('#idPembeli').attr('value',data.id_penduduk);
            $(this).attr('value',data.nama_pas);
        }
    );});
    $(function() {
        $('#pegawai').autocomplete("<?= app_base_url('/inventory/search?opsi=pegawai') ?>",
        {
            parse: function(data){
                var parsed = [];
                for (var i=0; i < data.length; i++) {
                    parsed[i] = {
                        data: data[i],
                        value: data[i].nama// nama field yang dicari
                    };
                }
                return parsed;
            },
            formatItem: function(data,i,max){
                $('#idPegawai').removeAttr('value');
                var str='<div class=result>'+data.nama+' <br/><i> '+data.alamat+' , '+data.nama_kelurahan+'</i></div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
        function(event,data,formated){
            $('#pegawai').attr('value',data.nama);
            $('#idPegawai').attr('value',data.id);
        }
    );
    $('#dokter').autocomplete("<?= app_base_url('/inventory/search?opsi=caridokter') ?>",
        {
            parse: function(data){
                var parsed = [];
                for (var i=0; i < data.length; i++) {
                    parsed[i] = {
                        data: data[i],
                        value: data[i].nama// nama field yang dicari
                    };
                }
                return parsed;
            },
           formatItem: function(data,i,max){
                        var sip = data.sip!='NULL'?data.sip:'';
                        var str='<div class=result>Nama :<b>'+data.nama+'</b> <i>SIP</i>: '+sip+'<br /><i>Alamat</i>: '+data.alamat_jalan+'<i> Kecamatan</i>: '+data.kecamatan+'<i> Kabupaten</i>: '+data.kabupaten+'<i> Provinsi</i>: '+data.provinsi+'</div>';
                        return str;
                    },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
       }).result(
        function(event,data,formated){
            $(this).attr('value',data.nama);
            $('#idDokter').attr('value',data.id);
            setDisabled();

    });

});

function openCetakSalinResep(id,kelas){
    window.open('print/salin-resep?code='+id+'&kelas='+kelas, 'MyWindow', 'width=600px, height=500px, scrollbars=1');
}
function openCetakPenjualan(id){
    window.open('print/penjualan?id='+id, 'MyWindow', 'width=600px, height=500px, scrollbars=1');
}

function openCetakKitir(id){
    window.open('print/nota-penjualan?code='+id+'&kelas=', 'MyWindow', 'width=600px, height=500px, scrollbars=1');
}
</script>
<h2 class="judul">Informasi Penjualan</h2><?= isset($pesan) ? $pesan : NULL ?>
<form action="<?= app_base_url('/inventory/info-penjualan') ?>" method="GET">
    <div class="data-input">
        <fieldset>
            <fieldset class="field-group">
                <legend>Tanggal Penjualan</legend>
                <input type="text" name="startDate" class="tanggal" id="awal" value="<?= $startDate ?>"/><label class="inline-title">s . d &nbsp;</label><input type="text" name="endDate" class="tanggal" id="akhir" value="<?= $endDate ?>"/>
            </fieldset>
            <fieldset class="field-group">
                <label for="jenis">Jenis</label>
                <input type="radio" name="jenis" value="Bebas" <? if ($jenis == "Bebas")
    echo"checked" ?>/>Bebas &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="jenis" value="Resep" <? if ($jenis == "Resep")
        echo"checked" ?>/>Resep
                    </fieldset>
                    <label for="pembeli">Nama Pembeli</label><input type="text" name="pembeli" id="pembeli" value="<?= $pembeli ?>"/>
                    <input type="hidden" name="idPembeli" id="idPembeli" value="<?= $idPembeli ?>"/>
                    <label for="pegawai">Petugas</label><input type="text" name="pegawai" id="pegawai" value="<?= $pegawai ?>"/>
                    <input type="hidden" name="idPegawai" id="idPegawai" value="<?= $idPegawai ?>"/>
                    <label for="dokter">Dokter</label><input type="text" name="dokter" id="dokter" value="<?= $dokter ?>"/>
                    <input type="hidden" name="idDokter" id="idDokter" value="<?= $idDokter ?>"/>                    
                    <fieldset class="input-process">
                        <input type="submit" value="Cari" class="tombol" /> <input type="button" value="Batal" class="tombol" onclick="javasrcipt:location.href='<?= app_base_url('inventory/info-penjualan') ?>'"/>
                    </fieldset>
                </fieldset>
            </div>
        </form>
        <div class="data-list">
            <span>Penjualan Hasil Pencarian</span>
            <table width="55%" class="tabel">
                <tr>
                    <th>No Nota</th>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Nama Pembeli</th>
                    <th>Nama Pegawai</th>
                    <th>Nama Dokter</th>
                    <th>Total Tagihan (Rp)</th>
                    <th>Aksi</th>
                </tr>
          
<?php foreach ($penjualan['list'] as $key => $row): ?>
            <tr class="<?= ($key % 2) ? 'odd' : 'even' ?>">
                <td align="center"><?=$row['id']  ?></td>
                <td><?= datefmysql($row['tanggal']) ?></td>
                <td align="center"><?= $row['jenis'] ?></td>
                <td class="no-wrap"><?= $row['pembeli'] ?></td>
                <td class="no-wrap"><?= $row['pegawai'] ?></td>
                <td class="no-wrap"><?= $row['dokter'] ?></td>
                <td align="right"><?=rupiah($row['total_tagihan'])?></td>
                <td class="aksi">
                    <a href="<?= app_base_url('inventory/info-penjualan?id=' . $row['id'] . '&startDate=' . $startDate . '&endDate=' . $endDate . '&jenis=' . $row['jenis']. '&pembeli=' . get_value('pembeli') . '&idPembeli=' . get_value('idPembeli') . '&pegawai=' . $pegawai . '&idPegawai=' . $idPegawai . '&dokter=' . $dokter . '&idDokter=' . $idDokter. '') ?>" class="detail">Detail</a>
                    <!--<span class="cetak2" id="salin" onclick="openCetakSalinResep(<?//=$row['id']  ?>,1)">salinan resep</span>-->
                    <!--<span class="cetak2" id="info" onclick="openCetakPenjualan(<//?=$row['id']  ?>)">cetak</span>-->
                    <span class="cetak2" id="kitir" onclick="openCetakKitir(<?=$row['id']  ?>)">Cetak Kitir</span>
                </td>
            </tr>
<?php
     endforeach;
?>
            
        </table>
            
    </div>

<br/>    
            <table>
                <tr>
                    <td>Total Jumlah Transaksi :</td><td><?=$jumlahPenjualan?></td>
                </tr>
                <tr>
                     <td>Total Jumlah Nilai Tagihan Transaksi :</td><td><?=$jumlahNilaiTagihan?></td>
                </tr>
                <tr>
                     <td>Total Jumlah Jasa Pelayanan Farmasi :</td><td><?=$jumlahJasaPelayanan?></td>
                </tr>
            </table>
<div class="perpage" style="float:right">        
        <a href="<?= app_base_url('inventory/report/penjualan-excel/'). '?startDate=' . $startDate . '&endDate=' . $endDate . '&jenis=' . $jenis . '&pembeli=' . get_value('pembeli') . '&idPembeli=' . get_value('idPembeli') . '&pegawai=' . $pegawai . '&idPegawai=' . $idPegawai . '&dokter=' . $dokter . '&idDokter=' . $idDokter. '' ?>" class="excel">Cetak Excel</a>
    </div>
<?php
            if (isset($_GET['id']) && $_GET['id'] != "") {
                $detail = detail_nota_penjualan($_GET['id']);
				//show_array($detail);
?>
                <br><br>
                <div class="data-list">
                    Detail Penjualan:<?= $_GET['id'] ?>
                    <table class="tabel">
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                           
                            <th>Harga Jual</th>
                            <th>Jumlah Penjualan</th>
                            <th>Sub Total</th>
                            <th>No Retur</th>
                            <th>Jumlah Retur</th>
                            <th>Alasan</th>
                        </tr>
        <? $get=$_GET['jenis'];
                foreach ($detail['list'] as $key => $content) {
                   // $hargaJual = ($content['hna'] * $content['margin'] / 100) + $content['hna'];
        ?>
                    <tr class="<?= ($key % 2) ? 'odd' : 'even' ?>">
                        <td align="center"><?= ++$key ?></td>
                        <td class="no-wrap"><?= nama_packing_barang(array($content['generik'],$content['nama_obat'],$content['kekuatan'],$content['sediaan'],$content['nilai_konversi'],$content['satuan_terkecil'],$content['pabrik']));?></td>
                        <td align="right"><?= rupiah($content['hna']) ?></td>
                        <td><?= $content['jumlah_penjualan'] ?></td>
                         <td align="right"><?= rupiah($content['hna']*$content['jumlah_penjualan']) ?></td>
                <td align="center">
                <?
                    echo isset($content['id_retur_penjualan']) ? $content['id_retur_penjualan'] : ' - ';
                ?>
                </td>
                <td><?= $content['jumlah_retur'] ?></td>
                <td align="center"><?= isset($content['alasan']) ? $content['alasan'] : ' - '; ?></td>
                    </tr>
        <?
		$biaya_apt=$content['biaya_apoteker'];
		$tot=$content['total_tagihan'];
		$counter=$detail['total'];
		$hitjum=$biaya_apt/$counter;
                }
    if($_GET['jenis']=='Resep'){
	    ?>
         
  <tr class="<?= ($counter % 2) ? 'odd' : 'even' ?>">
  <td align="center"><?=$counter+1?></td>
   <td>Jasa Pelayanan Farmasi</td>
    <td align="right"><?=rupiah($hitjum)?></td>
     <td><?=$counter?></td>
      <td align="right"><?=rupiah($biaya_apt)?></td>
       <td align="center">-</td>
        <td>-</td>
        <td align="center">-</td>
  </tr>
  <?}?>
     </table>
     <table>
                <tr>
                     <td>Total Jumlah Nilai Tagihan Transaksi :</td><td>Rp. <?=rupiah($tot)?></td>
                </tr>
                
            </table>
        </div>
<?
            }
?>
