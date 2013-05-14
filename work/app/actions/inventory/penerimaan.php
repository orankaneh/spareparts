<?
  include_once "app/lib/common/functions.php";
  include_once "app/lib/common/master-data.php";
  include_once 'app/actions/admisi/pesan.php';
  set_time_zone();
  $dp = detail_pemesanan_muat_data(isset ($_GET["nosp"])?$_GET['nosp']:0);
?>
<script type="text/javascript">
        $(function() {
        $('#nosp').autocomplete("<?= app_base_url('/inventory/search?opsi=nosp') ?>",
        {
                    parse: function(data){
                        var parsed = [];
                        for (var i=0; i < data.length; i++) {
                            parsed[i] = {
                                data: data[i],
                                value: data[i].id // nama field yang dicari
                            };
                        }
                        return parsed;
                    },
                    formatItem: function(data,i,max){
                        var str='<div class=result>No. SP: '+data.id+' <br/><i> Suplier: '+data.nama+' , Tgl: '+data.tanggal+'</i></div>';
                        return str;
                    },
                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                $('#nosp').attr('value',data.id);
                $('#suplier').attr('value',data.nama);
                $('#tanggal').attr('value',data.tanggal);
                $('#frmPenerimaan').submit();
            }
        );
        });
</script>
<script type="text/javascript">
    $(function() {
        $('.tanggal').datepicker({
                changeMonth: true,
                changeYear: true
        });
    });
</script>

<h2 class="judul">Master Penerimaan Barang</h2><?echo isset($pesan)?$pesan:NULL;?>
<div class="data-input">
    <fieldset><legend>Form Penerimaan Barang</legend>
    <form action="" method="get" name="form" id="frmPenerimaan">
        <fieldset class="field-group"><legend>Penerima</legend><span style="margin-left: 12px;font-size: 11px;"><?= $penerima = $_SESSION['nama'];?> <input type="hidden" name="idpegawai" value="<?= $idpegawai = $_SESSION['id_user']?>"></span>
        </fieldset>
        <label for="no-sp">No. SP</label><input type="text" name="nosp" id="nosp" value="<?=  isset ($_GET['nosp'])?$_GET['nosp']:""?>"/>
        <label for="suplier">Suplier</label><input type="text" name="suplier" id="suplier" value="<?=  isset ($_GET['suplier'])?$_GET['suplier']:""?>"/>
        <label for="tanggal">Tanggal Penerimaan</label><input type="text" name="tanggal" class="tanggal" value="<?= date('d/m/Y')?>"/>
    </form>
    </fieldset>
</div>

<form action="<?= app_base_url('inventory/control/penerimaan')?>" method="post">
<input type="hidden" name="waktu" value="<?=  isset ($_GET['tanggal'])?$_GET['tanggal']:""?>">   
<input type="hidden" name="idpemesanan" value="<?= isset ($_GET['nosp'])?$_GET['nosp']:""?>">
<input type="hidden" name="idpegawai" value="<?= $_SESSION['id_user']?>">
<table width="55%" style="border: 1px solid #f4f4f4; float: left">
    <tr style="background: #F4F4F4;">
        <th>No</th>
        <th>Nama Barang</th>
        <th>No. Batch</th>
        <th>Tanggal Kadaluwarsa</th>
        <th>Jumlah SP</th>
        <th>Jumlah Terima</th>
        <th>Satuan</th>
    </tr>
    <? foreach ($dp as $key => $rows) {
    ?>
       <tr>
        <td align="center"><?= ++$key ?></td>
        <td align="center"><input type="text" id="barang" class="auto" disabled value="<?= $rows['nama']?>"/>
            <input type="hidden" name="barang[]" id="barang" class="auto" value="<?= $rows['id_barang']?>"/></td>
        <td align="center"><input type="text" name="nobatch[]" id="nobatch" class="auto" /></td>
        <td align="center"><input type="text" name="kadaluarsa[]" id="tanggal<?= $key ?>" class="auto" /></td>
        <td align="center"><input type="text" name="jumlahsp[]" class="auto"/></td>
        <td align="center"><input type="text" name="jumlahterima[]" class="auto" value="<?= $rows['jumlah']?>"/></td>
        <td align="center"><input type="text" name="satuan" readonly class="auto" value="<?= $rows['satuan']?>" disabled /></td>
      </tr>
    <script type="text/javascript">
    $(function() {
        $('#tanggal<?= $key ?>').datepicker({
                changeMonth: true,
                changeYear: true
        });
    });
    </script>
    <?
    }?>
</table>
 <span style="position: relative;float: left;clear: left;padding-top: 30px;left: 150px">   
  <input type="submit" value="Simpan" name="save" class="tombol" />
  <input type="submit" name="savenew" value="Simpan & Baru" class="tombol" />
  <input type="button" value="Batal" class="tombol" />
 </span>  
</form>
