<?php
  include_once "app/lib/common/functions.php";
  include_once "app/lib/common/master-inventory.php";
  include_once "app/lib/common/master-data.php";
  set_time_zone();
  $instalasi = isset ($_GET['instalasi'])?$_GET['instalasi']:"";
  $page  = isset($_GET['page'])?$_GET['page']:NULL;
  $idInstalasi = isset ($_GET['idInstalasi'])?$_GET['idInstalasi']:"";
  $idKelas = isset ($_GET['idKelas'])?$_GET['idKelas']:"";
  $kelas = isset ($_GET['kelas'])?$_GET['kelas']:"";
?>
<script type="text/javascript">
  $(function() {
            $('#instalasi').autocomplete("<?= app_base_url('/admisi/search?opsi=infobed') ?>",
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
                            var str='<div class=result>'+data.nama+'</div>';
                            return str;
                        },
                        width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                        dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
                function(event,data,formated){
                    $(this).attr('value',data.nama);
                    $('#idInstalasi').attr('value',data.id);
                }
            );
        });
$(function() {
            $('#kelas').autocomplete("<?= app_base_url('/admisi/search?opsi=kelas') ?>",
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
                            var str='<div class=result>'+data.nama+'</div>';
                            return str;
                        },
                        width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                        dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
                function(event,data,formated){
                    $(this).attr('value',data.nama);
                    $('#idKelas').attr('value',data.id);
                }
            );
        });
		
</script>
<h2 class="judul">Informasi Ketersediaan Bed Rawat Inap</h2>
<form action="" method="GET">
<div class="data-input">
    <fieldset>
        <legend>Parameter Pencarian</legend>
        <label for="instalasi">Instalasi</label>
        <input type="text" name="instalasi" id="instalasi" value="<?= $instalasi?>">
        <input type="hidden" name="idInstalasi" id="idInstalasi" value="<?= $idInstalasi?>">
        <label for="kelas">Kelas</label>
          <input type="text" name="kelas" id="kelas" value="<?= $kelas?>">
        <input type="hidden" name="idKelas" id="idKelas" value="<?= $idKelas?>">
        <fieldset class="input-process">
            <input type="submit" class="tombol" value="Cari" name="cari">
            <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('admisi/info-ketersediaan-bed-rawat-inap') ?>'"/>
        </fieldset>
    </fieldset>
</div>
</form>  

<div class="data-list">
<?php if(isset ($_GET['cari'])){ ?>
    <table class="tabel" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <th>No.bed</th>
             <th>instalasi/Ruang</th>
            <th>Kelas</th>
            <th>Status</th>
        </tr>
        <?
          $no = 1;
          $info = infobed_rawat_inap_muat_data($page, $dataPerPage = 15, $idInstalasi,$idKelas);
          foreach($info['list'] as $row){
        ?>
          <tr class="<?= ($no%2)?"even":"odd"?>">
             
              <td><?= $row['nama']?></td>
              <td><?= $row['instalasi']?></td>
               <td><?= $row['class']?></td>
              <td><?= $row['status']?></td>
          </tr>
        <?
        $no++;
          }
        ?>
    </table>
</div>

        <a href="<?= app_base_url('admisi/report/bed-excel?idinstalasi=' .  $idInstalasi. "&idkelas=".$idKelas) ?>" class="excel">Cetak Excel</a>
<p></p><p></p>
<?php
echo isset($info['paging']) ? $info['paging'] : null;
}
?>