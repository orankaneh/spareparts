<?

  include_once "app/lib/common/functions.php";
  include_once "app/lib/common/master-inventory.php";
  include_once "app/lib/common/master-data.php";
  include 'app/actions/admisi/pesan.php';
  set_time_zone();
  $startDate=(isset($_GET['awal']))? $_GET['awal']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
  $endDate=(isset($_GET['akhir']))? $_GET['akhir']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
  $idPegawai=isset ($_GET['idPegawai'])?$_GET['idPegawai']:NULL;
  $pegawai=isset ($_GET['pegawai']) && ($idPegawai!=null)?$_GET['pegawai']:NULL;
  $idUnit=get_value('unit');
  $distribusi=distribusi_muat_data($startDate,$endDate,$idPegawai,$idUnit);
  $unit = unit_muat_data();
?>
<h2 class="judul">Distribusi</h2><?= isset ($pesan)?$pesan:NULL?>
<script type="text/javascript">
        $(function() {
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
                }
            );
        });

    $(document).ready(function(){
        $("#cetak").click(function(){
          var win = window.open('report/distribusi?<?= generate_get_parameter($_GET)?>', 'MyWindow', 'width=800px,height=600px,scrollbars=1');
        })
		 $("#detail").click(function(){
          var win = window.open('report/distribusi-detail?<?= generate_get_parameter($_GET)?>', 'MyWindow', 'width=800px,height=600px,scrollbars=1');
        })
    })
</script>
<div class="data-input">
    <fieldset><legend>Parameter Pencarian</legend>
        <form action="" method="get">
        <fieldset class="field-group">
            <legend>Tanggal Distribusi</legend>
            <input type="text" name="awal" class="tanggal" id="awal" value="<?= $startDate ?>" /><label class="inline-title">s . d &nbsp;</label><input type="text" name="akhir" class="tanggal" id="akhir" value="<?= $endDate ?>" />
        </fieldset>
        <label for="unit">Unit</label>
            <select name="unit">
                <option value="">Semua unit...</option>
                <?
                foreach ($unit['list'] as $row) {
                ?>
                <option value="<?= $row['id'] ?>" <?=($row['id']==$idUnit)?'selected':''?>><?= $row['nama'] ?></option>
                <?
                }
                ?>
            </select>
        <label for="pegawai">Pegawai</label><input type="text" name="pegawai" id="pegawai" value="<?= $pegawai?>"><input type="hidden" name="idPegawai" id="idPegawai" value="<?= $idPegawai?>">
        <fieldset class="input-process">
            <input type="submit" value="Cari" class="tombol" name="cari"/> <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/info-distribusi') ?>'"/>
        </fieldset>
        </form>
    </fieldset>
</div>
<?php
  if(isset ($_GET['cari']) && $_GET['cari'] == "Cari"){
?>
<div class="data-list">
    <table class="tabel">
        <tr>
            <th style="width: 5%">No</th>
            <th style="width: 10%">No. Distribusi</th>
            <th style="width: 15%">Tanggal</th>
            <th style="width: 25%">Unit Tujuan</th>
            <th style="width: 30%">Pegawai</th>
            <th style="width: 15%">Aksi</th>
        </tr>
       <?php foreach ($distribusi as $key => $row) {
           ?>
        <tr class="<?= ($key%2) ? 'odd':'even' ?>">
            <td align="center"><?= ++$key ?></td>
            <td><?= $row['id_distribusi']?></td>
            <td><?= datefmysql($row['tanggal'])?></td>
            <td class="no-wrap"><?= $row['unit_tujuan']?></td>
            <td><?= $row['nama_pegawai']?></td>
            <td class="aksi">
            <a href="<?= app_base_url('inventory/info-distribusi')."?do=detail&cari=Cari&id=$row[id_distribusi]&awal=$startDate&akhir=$endDate&unit=$idUnit&pegawai=$pegawai&idPegawai=$idPegawai&unittujuan=$row[unit_tujuan]" ?>" class="detail">detail</a>
            </td>
        </tr>
        <?php } ?>
    </table>
      <? if (count($distribusi)!=0){?>
      <span class="cetak" id="cetak">Cetak</span>
<a class="excel" class="tombol" href="<?=app_base_url('inventory/report/distribusi-excel?').  generate_get_parameter($_GET)?>">Cetak</a>
<? } ?>
</div>

<?
}
if(isset ($_GET['do']) && $_GET['do'] == "detail"){
    $detail = detail_distribusi_muat_data($_GET['id']);

?>


<br><br>
<div class="data-list">
    Detail Distribusi:
    <table class="tabel">
        <tr>
            <th style="width: 5%">No</th>
            <th>Nama Barang</th>
            <th style="width: 10%">Jumlah Distribusi</th>
            <th style="width: 10%">No Penerimaan Unit</th>
            <th style="width: 10%">Jumlah Terima</th>
            <th style="width: 10%">Satuan</th>
            <th style="width: 10%">Selisih</th>
        </tr>
        <?
            $i=1;
          foreach ($detail as $key => $row) {
              $nama=nama_packing_barang(array($row['generik'],$row['barang'],$row['kekuatan'],$row['sediaan'],$row['nilai_konversi'],$row['satuan'],$row['pabrik']));
                ?>
                <tr class="<?= (($i-1)%2) ? 'odd':'even' ?>">
                    <td align="center"><?=$i++?></td>
                    <td class="no-wrap" style="width: 30%"><?=$nama?></td>
                    <td><?=($row['jumlah_distribusi'])?></td>
                    <td><?=$row['id_penerimaan_unit']?></td>
                    <td><?=$row['jumlah_penerimaan_unit']?></td>
                    <td><?=$row['satuan']?></td>
                    <td><?=($row['jumlah_distribusi']-$row['jumlah_penerimaan_unit'])?></td>
                </tr>
                <?
            }
        ?>
    </table>
    <span class="cetak" id="detail">Cetak Detail</span>
</div>
<?
}
?>
