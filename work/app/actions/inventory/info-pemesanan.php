<?php
  include_once "app/lib/common/functions.php";
  include_once "app/lib/common/master-inventory.php";
  include_once "app/lib/common/master-data.php";
  include 'app/actions/admisi/pesan.php';
  set_time_zone();
  $startDate=(isset($_GET['awal']))? $_GET['awal']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
  $endDate=(isset($_GET['akhir']))? $_GET['akhir']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
  $idSuplier = isset ($_GET['idSuplier'])?$_GET['idSuplier']:NULL;
  $supplier=isset ($_GET['suplier'])?$_GET['suplier']:NULL;
  $nofaktur=isset ($_GET['nofaktur'])?$_GET['nofaktur']:NULL;
  $jenisSp=isset ($_GET['jenis'])?$_GET['jenis']:NULL;
  $pegawai=isset ($_GET['pegawai'])?$_GET['pegawai']:NULL;
  $idPegawai=isset ($_GET['idPegawai'])?$_GET['idPegawai']:NULL;
  $sp = sp_muat_data($startDate,$endDate,$jenisSp,$idSuplier,$idPegawai);
?>
<h2 class="judul">Informasi Pemesanan</h2><?= isset ($pesan)?$pesan:NULL?>
<script type="text/javascript">
        $(function() {
            $('#suplier').autocomplete("<?= app_base_url('/inventory/search?opsi=suplier') ?>",
            {
                        parse: function(data){
                            var parsed = [];
                            for (var i=0; i < data.length; i++) {
                                parsed[i] = {
                                    data: data[i],
                                    value: data[i].nama_kelurahan // nama field yang dicari
                                };
                            }
                            return parsed;
                        },
                        formatItem: function(data,i,max){
                            $('#idSuplier').removeAttr('value');
                            var str='<div class=result>'+data.nama+' <br/><i> '+data.alamat+' , '+data.nama_kelurahan+'</i></div>';
                            return str;
                        },
                        width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                        dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
                function(event,data,formated){
                    $('#suplier').attr('value',data.nama);
                    $('#idSuplier').attr('value',data.id);
                }
            );
            })    
            
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
</script>
<div class="data-input">
    <fieldset><legend>Parameter Pencarian</legend>
        <form action="" method="get">
        <fieldset class="field-group">
            <legend>Tanggal</legend>
            <input type="text" name="awal" class="tanggal" id="awal" value="<?= $startDate ?>" /><label class="inline-title">s . d &nbsp;</label><input type="text" name="akhir" class="tanggal" id="akhir" value="<?= $endDate ?>" />
        </fieldset>
        <label for="suplier">Suplier</label><input type="text" id="suplier" name="suplier" value="<?=$supplier?>"/><input type="hidden" name="idSuplier" id="idSuplier" value="<?=$idSuplier?>"/>
          <label for="jenis">Jenis SP</label><select name="jenis" tabindex="3"><option value="">pilih jenis Sp</option>
                <option value="Umum">Umum</option>
                <option value="Narkotik">Narkotika</option>
                <option value="Psikotropik">Psikotropika</option>
                <option value="Reguler">Reguler</option>
                <option value="Askes">Askes</option>
                <option value="Jamkesmas">Jamkesmas</option>
            </select>
        <label for="pegawai">Pegawai</label><input type="text" name="pegawai" id="pegawai" value="<?= $pegawai?>"><input type="hidden" name="idPegawai" id="idPegawai" value="<?= $idPegawai?>">
        <fieldset class="input-process">
            <input type="submit" name="cari" value="Cari" class="tombol" /> <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('inventory/info-pemesanan') ?>'"/>
        </fieldset>
        </form>
    </fieldset>
</div>
<?if(isset($_GET['cari'])){?>
<div class="data-list">
    <table class="tabel">
        <tr>
            <th>No. SP</th>
            <th>Tanggal</th>
            <th>Nama Suplier</th>
            <th>Jenis SP</th>
            <th>Aksi</th>
        </tr>
       <?php foreach ($sp as $key => $row) {
           ?>
        <tr class="<?= ($key%2) ? 'odd':'even' ?>">
            <td align="center"><?= $row['id']?></td>
            <td><?= datefmysql($row['tanggal'])?></td>
            <td class="no-wrap"><?= $row['suplier']?></td>
            <td><?= $row['jenis_sp']?></td>
            <td class="aksi" style="width: 25%">
                <?php
				// ----- Link Edit dan Delete suruh disable
				// ----- Sekarang link Edit dan Delete suruh enable lagi.. 23 Desember 2011
                ?>
                  <!--<a href="<?=app_base_url('inventory/pemesanan-edit?id='.$row['id'])?>" class="edit"><small>edit</small></a>
                  <a href="<?=app_base_url('inventory/control/pemesanan/pemesanan-delete?id='.$row['id'])?>" class="delete"><small>delete</small></a>-->
                  <a href="<?= app_base_url('inventory/info-pemesanan?').  generate_get_parameter($_GET,array('nosp'=>$row['id'])) ?>" class="detail">detail</a>
				  <!-- Enable lagi yah... ;) -->
				  <a href="<?=app_base_url('inventory/pemesanan-edit?id='.$row['id'])?>" class="edit">edit</a>
                  <a href="<?=app_base_url('inventory/control/pemesanan/pemesanan-delete?id='.$row['id'])?>" class="delete">delete</a>
                  <span class="cetakSurat cetaks<?= $row['id']?>">cetak</span>
                  <a href="<?= app_base_url('inventory/report/pemesanan-excel/?id='.$row['id'])?>" class="excel">Cetak Excel</a>
            </td>
        </tr>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.cetaks<?= $row['id']?>').click(function(){
                    var win = window.open('print/pemesanan?id=<?= $row['id']?>&jenis=<?php echo $row['jenis_sp'] ?>','mywindow','location=1,status=1,scrollbars=1,width=800px');
                })
            })
        </script>
        <?php } ?>
    </table>
</div>
<div class="perpage">Total Jumlah SP : <?= count($sp)?></div>
<?
}//end if(isset($_POST['cari']))
if(isset($_GET['nosp'])&& $_GET['nosp']!=''){
    require_once'app/lib/common/master-inventory.php';
    $barangs=  detail_barang_sp_muat_data($_GET['nosp']);
?>
<br><br>
<div class="data-list">
    Detail Pemesanan:<?=$_GET['nosp']?>

    <table class="tabel">
        <tr>
            <th>Nama Packing Barang</th>
            <th>Jumlah Pesan</th>
            <th>No. Faktur</th>
            <th>Jumlah Pembelian</th>
            <th>Kemasan</th>
            <th>Leadtime</th>
        </tr>
        
        <?
            $i=1;
            foreach($barangs as $b){
                  if (($b['generik'] == 'Generik') || ($b['generik'] == 'Non Generik')) {
                    $nama = ($b['kekuatan']!=0)?"$b[barang] $b[kekuatan], $b[sediaan]":"$b[barang] $b[sediaan]";
                    $nama.=($b['generik'] == 'Generik')?' '. $b['pabrik']:'';
                  } else {
                    $nama = "$b[barang]";
                  }
                  $nama .=" @$b[nilai_konversi] $b[satuan_terkecil]";
//                  $nama.=($b['generik'] == 'Generik')?' '. $b['pabrik']:'';
                ?>
                <tr class="<?= (($i-1)%2) ? 'odd':'even' ?>">
                    <td class="no-wrap"><?=$nama?></td>
                    <td style="width: 10%" align="right"><?= rupiah($b['jumlah_pesan'])?></td>
                    <td style="width: 10%"><?=$b['no_faktur']?></td>
                    <td style="width: 10%" align="right"><?= rupiah($b['jumlah_pembelian'])?></td>
                    <td><?=$b['satuan']?></td>
                    <td style="width: 10%"><?=($b['lead_time']*24)." jam"?></td>
                </tr> 
                
                <?
            }
        ?>
    </table>
</div>
<?
}
?>

<script type="text/javascript">
    $(document).ready(function(){
        $(".cetak").click(function(){
            var win = window.open('report/pemesanan?startDate=<?= $startDate?>&endDate=<?= $endDate?>&idsuplier=<?= $idSuplier?>', 'MyWindow', 'width=800px,height=600px,scrollbars=1');
        })
    })
</script> 