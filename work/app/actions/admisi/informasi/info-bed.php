<?
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';
set_time_zone();
$instalasi=isset($_GET['instalasi'])?$_GET['instalasi']:null;
$idInstalasi=isset($_GET['idInstalasi'])?$_GET['idInstalasi']:null;
$data= ketersediaan_bed_muat_data($idInstalasi,$instalasi);
?>
<h1 class="judul">Informasi Ketersediaan Bed</h1>
            <div class="data-input pendaftaran">
            <fieldset id="master"><legend>Form pencarian </legend>
            <form action="" method="get" name="form">
            <label for="filter">Nama Instalasi</label>
            <input type="text" name="instalasi" value="<?=$instalasi?>">
            <input type="hidden" name="idInstalasi" value="<?=$idInstalasi?>">
         <fieldset class="input-process">
            <input type="submit" value="Display" class="tombol" />
            <input type="button" value="Cancel" class="tombol" onClick=javascript:location.href="<?= app_base_url('/admisi/informasi/info-bed')?>" />
         </fieldset>
            </form>
            </fieldset>
            </div>

<?php
set_time_zone();

?>
<div class="data-list">
<table cellpadding="0" cellspacing="0" border="0" id="table" class="tabel" style="width: 60%">
    <tr>
        <th style="width: 10%">No Bed</th>
        <th>Kelas</th>
        <th>Instalasi</th>
        <th>Isi/Kosong</th>
    </tr>
    <?php foreach($data as $num => $row): ?>
    <tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
        <td><?=$row['nama']?></td>
        <td><?=$row['kelas']?></td>
        <td><?=$row['instalasi']?></td>
        <td><?=($row['status_kunjungan']==0)?"Kosong":"Isi"?></td>
    </tr>
    <?php endforeach; ?>

</table>
</div>
<script type="text/javascript">
     $(document).ready(function(){
        $('input[name=instalasi]').autocomplete("<?= app_base_url('/admisi/search?opsi=instalasi') ?>",
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
                    $('input[name=idInstalasi]').attr('value','');
                    var str='<div class=result>'+data.nama+'</div>';
                    return str;
                },
                width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
            }).result(
                function(event,data,formated){
                    $(this).attr('value',data.nama);
                    $('input[name=idInstalasi]').attr('value',data.id);
                }
            );
     })
</script>    