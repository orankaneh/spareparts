<?
include_once "app/lib/common/functions.php";
include_once "app/lib/common/master-data.php";
set_time_zone();
$startDate = (isset($_GET['awal'])) ? $_GET['awal'] : Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$endDate = (isset($_GET['akhir'])) ? $_GET['akhir'] : Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$barang = isset($_GET['barang']) ? $_GET['barang'] : NULL;
$idBarang = isset($_GET['idBarang']) ? $_GET['idBarang'] : NULL;
$idPegawai = isset($_GET['idPegawai']) ? $_GET['idPegawai'] : NULL;
$pegawai = isset($_GET['pegawai']) ? $_GET['pegawai'] : NULL;
$saksi = isset($_GET['saksi']) ? $_GET['saksi'] : NULL;
$idSaksi = isset($_GET['idSaksi']) ? $_GET['idSaksi'] : NULL;
$pemusnahan = pemusnahan_muat_data($startDate, $endDate, $idPegawai, $idSaksi, NULL);
?>

<script type="text/javascript">
    $(function() {
        $('#saksi').autocomplete("<?= app_base_url('/inventory/search?opsi=saksi') ?>",
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
                $('#idSaksi').removeAttr('value');
                var str='<div class=result>'+data.nama+' <br/><i> Profesi: '+data.pekerjaan+'</i></div>';
                return str;
            },
            width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
            dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                $('#saksi').attr('value',data.nama);
                $('#idSaksi').attr('value',data.id);
            }
        );
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
                var str='<div class=result>'+data.nama+' <br/><i> '+data.sip+'</i></div>';
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
    });
</script>
<h2 class="judul">Pemusnahan</h2>
<div class="data-input">
    <fieldset><legend>Parameter Pencarian</legend>
        <form action="" method="get">
            <fieldset class="field-group">
                <legend>Tanggal Pemusnahan</legend>
                <input type="text" name="awal" class="tanggal" id="awal" value="<?= $startDate ?>" /><label class="inline-title">s . d &nbsp;</label><input type="text" name="akhir" class="tanggal" id="akhir" value="<?= $endDate ?>" />
            </fieldset>
            <label for="pegawai">Pegawai</label><input type="text" name="pegawai" id="pegawai" value="<?= $pegawai ?>"/><input type="hidden" name="idPegawai" id="idPegawai" value="<?= $idPegawai ?>"/>
            <label for="saksi">Saksi</label><input type="text" name="saksi" id="saksi" value="<?= $saksi ?>"/><input type="hidden" name="idSaksi" id="idSaksi" value="<?= $idSaksi ?>"/>

            <fieldset class="input-process">
                <input type="submit" value="Cari" class="tombol" /> <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/info-pemusnahan') ?>'"/>
            </fieldset>
        </form>
    </fieldset>
</div>
<div class="data-list">
    <table class="tabel">
        <tr>
            <th>No</th> 
            <th>No Pemusnahan</th>
            <th>Tanggal</th>
            <th>Pegawai</th>
            <th>Saksi</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($pemusnahan as $key => $row) {
        ?>
            <tr class="<?= ($key % 2) ? 'odd' : 'even' ?>">
                <td align="center"><?= ++$key ?></td>
                <td><?= $row['id'] ?></td>
                <td><?= datefmysql($row['tanggal']) ?></td>
                <td class="no-wrap"><?= $row['namaPegawai'] ?></td>
                <td class="no-wrap"><?= $row['namaSaksi'] ?></td>
                <td class="aksi">
                    <a href="<?= app_base_url('inventory/info-pemusnahan?no=' . $row['id'] . "&awal=" . $startDate . "&akhir=" . $endDate . "&barang=" . get_value('barang') . "&suplier=" . get_value('suplier') . "&idSuplier=" . get_value('idSuplier') . "&nofaktur=" . get_value('nofaktur') . "&status=" . get_value('status') . "") ?>" class="detail">detail</a>
                </td>
            </tr>
        <?php } ?>
    </table>
      <? if (count($pemusnahan)!=0){?>
<a class=excel class=tombol href="<?=app_base_url('inventory/report/musnahkan-excel?').  generate_get_parameter($_GET)?>">Cetak</a>
<? } ?>
</div>
<?
        if (isset($_GET['no']) && $_GET['no'] != '') {
            require_once'app/lib/common/master-data.php';
            $barangs = detail_pemusnahan_muat_data($_GET['no']);
            $kekuatan = isset($b['kekuatan']) ? $b['kekuatan'] : "";
            $sediaan = isset($b['sediaan']) ? $b['sediaan'] : "";
            if (isset($b['generik']) && $b['generik'] == "Generik") {
                $pabrik = $b['pabrik'];
            }else
                $pabrik = "";
?>
            <br><br>
            <div class="data-list">
                Detail Pemusnahan:<?= $_GET['no'] ?>
                <table class="tabel">
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>No. Batch</th>
                        <th>Jumlah</th>
                        <th>Alasan</th>
                    </tr>
        <?
            foreach ($barangs as $num => $b) {
                if (($b['generik'] == 'Generik') || ($b['generik'] == 'Non Generik')) {
                    $nama = ($b['kekuatan'] != 0) ? "$b[barang] $b[kekuatan], $b[sediaan]" : "$b[barang] $b[sediaan]";
                } else {
                    $nama = "$b[barang]";
                }
                $nama .=" @$b[nilai_konversi] $b[satuan_terkecil]";
                $nama.= ( $b['generik'] == 'Generik') ? ' ' . $b['pabrik'] : '';
        ?>
                <tr class="<?= ($num % 2) ? 'odd' : 'even' ?>">
                    <td align="center"><?= ++$num ?></td>
                    <td class="no-wrap" style="width: 30%"><?= $nama ?></td>
                    <td><?= $b['batch'] ?></td>
                    <td><?= $b['jumlah'] ?></td>
                    <td><?= $b['alasan'] ?></td>
                </tr>
        <?
            }
        ?>
        </table>
    </div>
     
<?
  }
?>
