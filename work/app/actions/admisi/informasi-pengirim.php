<script type="text/javascript">
  $(function() {
        $('#nama').autocomplete("<?= app_base_url('/admisi/search?opsi=pengirim') ?>",
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
                        //if (data.id_pasien == null) {
                        //var str='<div class=result>'+data.nama_pas+' <br/> <i>'+data.alamat_jalan+' '+data.nama_kelurahan+'</i></div>';
                        //} else {
                        //var str='<div class=result><b>'+data.id_pasien+'</b> - '+data.nama_pas+' <br/> <i>'+data.alamat_jalan+' '+data.nama_kelurahan+'</i></div>';
                        var str='<div class=result><b>'+data.nama+' </b><br/> <i>';
                            str+=data.alamat_jalan==null?'-':data.alamat_jalan;
                            str+=' ';
                            str+=data.kelurahan==null?'-':data.kelurahan;
                            str+='</i></div>';
                        //}
                        return str;
                    },
                    width: 300, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
                    dataType: 'json' // tipe data yang diterima oleh library ini disetup sebagai JSON
        }).result(
            function(event,data,formated){
                    $('#nama').attr('value',data.nama);
					   $('#id').attr('value',data.idPen);
                    
            }
        );
});
</script>
<?
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';

set_time_zone();

$sort=(isset($_GET['sort']))?$_GET['sort']:null;
$by=(isset($_GET['by']))?$_GET['by']:'asc';
$category = (isset($_GET['kategori']))?$_GET['kategori']:NULL;
$key = (isset($_GET['key']))?$_GET['key']:NULL;
$id= (isset($_GET['id']))?$_GET['id']:NULL;
$startDate=(isset($_GET['startDate']))? $_GET['startDate']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
$endDate=(isset($_GET['endDate']))? $_GET['endDate']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));

?>
<h1 class="judul">Informasi Pengirim Kunjungan</h1>

            <div class="data-input pendaftaran">
            <fieldset id="master"><legend>Form pencarian </legend>    

            <form action="<?= app_base_url('admisi/informasi-pengirim')?>" method="get" name="form">

            <fieldset class="field-group">    
                <legend>Awal - akhir periode</legend>
                <input type="text" id="awal" name="startDate" value="<?= $startDate ?>" class="tanggal"/>

                <label for="akhir" class="inline-title"> s . d </label>
                <input type="text" id="akhir" name="endDate" value="<?= $endDate ?>" class="tanggal"/>
            </fieldset>
             <label for="nama">Nama</label>
  <input type='text' name='key' id="nama" value="<?=$key?>"/>
<input type="hidden" name="id" id="id" value="<?=$id?>"/>
            <div id="field-dinamis">

            </div>
         <fieldset class="input-process">
            <input type="submit" value="Display" class="tombol" name="tampil"/>
            <input type="button" value="Cancel" class="tombol" onClick=javascript:location.href="<?= app_base_url('/admisi/informasi-pengirim')?>" />
         </fieldset>
            </form>
            </fieldset>    
            </div>

<?php
if(isset ($_GET['tampil']) && $_GET['tampil'] == "Display"){
set_time_zone();

//membuat link sorting
if($sort=='k.waktu' && $by=='DESC')
    $waktu=app_base_url('admisi/informasi-pengirim?startDate='.$startDate.'&endDate='.$endDate.'&sort=k.waktu&by=ASC&tampil=Display');
else
    $waktu=app_base_url('admisi/informasi-pengirim?startDate='.$startDate.'&endDate='.$endDate.'&sort=k.waktu&by=DESC&tampil=Display');

if($sort=='pg.nama' && $by=='DESC')
    $nama=app_base_url('admisi/informasi-pengirim?startDate='.$startDate.'&endDate='.$endDate.'&sort=pg.nama&by=ASC&tampil=Display');
else
    $nama=app_base_url('admisi/informasi-pengirim?startDate='.$startDate.'&endDate='.$endDate.'&sort=pg.nama&by=DESC&tampil=Display');



$startDate=date2mysql($startDate);
$endDate=date2mysql($endDate);
if($sort==null){

    $kunjungan = pengirim_muat_data($startDate,$endDate,$id);
	//show_array($kunjungan);
}
else{

    $kunjungan = pengirim_muat_data($startDate,$endDate,$id,$sort,$by);

}
?>
<div class="data-list">
<table cellpadding="0" cellspacing="0" border="0" id="table" class="tabel">
		
    <tr>
 <th>No</th>
        <th><a href="<?=$nama?>" class="sorting">Nama pengirim</a></th>
        <th>Total</th>
    </tr>
    <?php foreach($kunjungan as $num => $row):
	?>
    <tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
        <td align="center" style="width:10%"><?= ++$num;?></td>
	<td align="center"><?= $row['pengantar']?></td>
       <td align="center"><?= $row['total']?></td>
    </tr>
    <?php  endforeach; ?>
            
</table>
</div>    
<span class="error"></span>
<div class='table-report-admisi'></div>
<span class="cetak" onclick="window.open('<?=  app_base_url('admisi/informasi/informasi-pengirim?').  generate_get_parameter($_GET)?>','popup','width=1000','height=850')">Cetak</span>
<a class=excel class=tombol href="<?=app_base_url('admisi/informasi/excel/informasi-pengirim?').  generate_get_parameter($_GET)?>">Cetak</a>

<?php
}
?>
