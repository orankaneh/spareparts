<?php
  include_once "app/lib/common/functions.php";
  include_once "app/lib/common/master-inventory.php";
  include_once "app/lib/common/master-data.php";
  set_time_zone();
  $startDate=(isset($_GET['awal']))? $_GET['awal']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
  $endDate=(isset($_GET['akhir']))? $_GET['akhir']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
  $instalasi = isset ($_GET['instalasi'])?$_GET['instalasi']:"";
  $idInstalasi = isset ($_GET['idInstalasi'])?$_GET['idInstalasi']:"";
  $idKelas = isset ($_GET['kelas'])?$_GET['kelas']:"";
  $sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : NULL;
  $sort = isset($_GET['sort']) ? $_GET['sort'] : NULL;
  $kelas = kelas_muat_data();
?>
<script type="text/javascript">
  $(function() {
            $('#instalasi').autocomplete("<?= app_base_url('/admisi/search?opsi=instalasi') ?>",
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
</script>
<h2 class="judul">Informasi Rawat Inap</h2>
<form action="" method="GET">
<div class="data-input">
    <fieldset>
        <legend>Parameter Pencarian</legend>
        <fieldset class="field-group">
            <legend>Tanggal Rawat Inap</legend>
            <input type="text" name="awal" class="tanggal" id="awal" value="<?= $startDate ?>" /><label class="inline-title">s . d &nbsp;</label><input type="text" name="akhir" class="tanggal" id="akhir" value="<?= $endDate ?>" />
        </fieldset>
        <label for="instalasi">Instalasi</label>
        <input type="text" name="instalasi" id="instalasi" value="<?= $instalasi?>">
        <input type="hidden" name="idInstalasi" id="idInstalasi" value="<?= $idInstalasi?>">
        <label for="kelas">Kelas</label>
        <select name="kelas" style="width: 23.5em;">
            <option value="all">Pilih Kelas</option>
            <?
            foreach ($kelas as $row){
			if($row['nama']!='Semua'){
            ?>
            <option value="<?= $row['id']?>" <?if($row['id'] == $idKelas) echo "selected";?>><?= $row['nama']?></option>
            <?
			}
            }
            ?>
        </select>
        <fieldset class="input-process">
            <input type="submit" class="tombol" value="Cari" value="Cari" name="cari">
            <input type="button" value="Batal" class="tombol" onClick="javascript:location.href='<?= app_base_url('admisi/info-rawat-inap') ?>'"/>
        </fieldset>
    </fieldset>
</div>
</form>  
<div class="data-list" style="overflow:auto;">
<?php if(isset ($_GET['cari'])){ ?>
    <table class="tabel" width="115%">
        <tr>
            <th width="1%">No</th>
             <th><a href="<?php echo app_base_url('admisi/info-rawat-inap?').generate_sort_parameter(1, $sortBy) ?>" class="sorting">Waktu</a></th>
            <th><a href="<?php echo app_base_url('admisi/info-rawat-inap?').generate_sort_parameter(2, $sortBy) ?>" class="sorting">Nama Lengkap Pasien</a></th>
            <th><a href="<?php echo app_base_url('admisi/info-rawat-inap?').generate_sort_parameter(3, $sortBy) ?>" class="sorting">No. RM</a></th>
            <th><a href="<?php echo app_base_url('admisi/info-rawat-inap?').generate_sort_parameter(4, $sortBy) ?>" class="sorting">Kelurahan</a></th>
             <th><a href="<?php echo app_base_url('admisi/info-rawat-inap?').generate_sort_parameter(5, $sortBy) ?>" class="sorting">Nama Lengkap Dokter</a></th>
            <th><a href="<?php echo app_base_url('admisi/info-rawat-inap?').generate_sort_parameter(6, $sortBy) ?>" class="sorting">Bed</a></th>
            <th width="19%">Aksi</th>
        </tr>
        <?
          $no = 1;
          $info = rawat_inap_muat_data($startDate,$endDate,$idInstalasi,$idKelas,$sort,$sortBy);
          foreach($info as $row){
          if($row['tanggal'] == ""){
            echo "";
          }else{    
        ?>
          <tr class="<?= ($no%2)?"even":"odd"?>">
              <td align="center"><?= $no++?></td>
                <td align='center'><?= datetime($row['tanggal'])?></td>
              <td class="no-wrap"><?= $row['pasien']?></td>
              <td><?= $row['norm']?></td>              
              <td class="no-wrap"><?= $row['kelurahan'].', '.$row['kecamatan'].', '.$row['kabupaten']?></td>
                 <td><?= $row['nama_dokter']?></td>
              <td><?=$row['bed'].', '.$row['kelas'].', '.$row['instalasi']?></td>              
                 <td width="12%"><?php 
				  $id = $row['idKunjungan'];
        echo "<span class=\"cetak\" onclick=\"win = window.open('".app_base_url('admisi/print/rawat-inap')."?idKunjungan=$id', 'mywindow', 'location=1, status=1, scrollbars=1, width=800px');\">Lembar Mutasi</span>";
	$norm2=$row['norm'];
                   echo "<span class=\"cetak\" onclick=\"win = window.open('".app_base_url('admisi/print/wristbands')."?norm=$norm2', 'mywindow', 'location=1, status=1, scrollbars=1, width=800px');\">Gelang</span>";
				   ?>
                </td>
          </tr>
    
        <?
          }
          }
        ?>
    </table>
	<?php //echo $info['sql']; ?>
</div>
<?php
   echo "<span class='cetak' id='cetak'>Cetak</span>"; 
?>

<a href="<?= app_base_url('admisi/report/info-rawat-inap-excel/?startDate='.$startDate.'&endDate='.$endDate.'&instalasi='.$idInstalasi.'&kelas='.$idKelas.'')?>" class="excel">Cetak Excel</a>
<?
}
?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#cetak").click(function(){
            var win = window.open('report/info-rawat-inap?startDate=<?= $startDate?>&endDate=<?= $endDate?>&instalasi=<?= $idInstalasi?>&kelas=<?= $idKelas?>', 'MyWindow', 'width=800px,height=600px,scrollbars=1');
        })
    })
</script> 
