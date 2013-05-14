<?php
require_once 'app/lib/common/master-data.php';
$idKunjungan = (isset($_GET['id'])) ? $_GET['id'] : null;
$detail = detail_kunjungan($_GET['id']);
//show_array($detail);
$asuransi=  kepesertaan_asuransi($_GET['id']);
//show_array($detail);
?>

<h1 class="judul"><a href="<?=app_base_url('admisi/kunjungan')?>">Kunjungan Rawat Jalan</a></h1>
<span id="cetak-lembar-pertama" class="cetak">Cetak Lembar Pertama</span>
<span id="cetak-antrian" class="cetak">Cetak Antrian</span>
<?php if($detail['jumlah_kunjungan']==1){
 ?>
    <span id="cetak-kartu" class="cetak">Cetak Kartu Pasien</span>
 <?php
}
?>
<style type="text/css">
	legend {
		font-size:8px;
		font-weight:bold;
		text-transform:uppercase;
		background:#f1f1f1;
		border-top:1px dotted #333;
		border-left:1px dotted #333;
		border-right:1px dotted #333;
		padding:3px;
		background:#ddd;
	}
	fieldset {
		background:#f4f4f4;
		border:1px dotted #333;
	}
	.noborder {
		border:none;
		background:none;
	}
	input[type=button] {
		font-size:11px;
	}
</style>
<fieldset style="margin-top:10px;"><legend>Kunjungan Rawat Jalan</legend>
    <table width="100%" cellpadding="3px">
        <tr>
            <td width="14%"> No. Antrian</td><td> <?="<b>" . $detail['id_layanan'] . "." . date('dmY') . "." . antri($detail['no_antrian']) . "</b>"?></td>
        </tr>
        <tr>
            <td>
                 Layanan:
            </td>
            <td> 
            <?
              $layanan = $detail['nama_layanan'];
             // $layanan .= ($detail['nama_pekerjaan'] == 'Tanpa Profesi' || $detail['nama_pekerjaan'] == 'Semua')?'':' '.$detail['nama_pekerjaan'];
              $layanan .= ($detail['spesialisasi'] == 'Tanpa Spesialisasi' || $detail['spesialisasi'] == 'Semua')?'':' '.$detail['spesialisasi'];
              $layanan .= ($detail['bobot'] == 'Tanpa Bobot' || $detail['bobot'] == 'Semua')?'':' '.$detail['bobot'];
              $layanan .= ($detail['nama_instalasi'] == 'Tanpa Instalasi' || $detail['nama_instalasi'] == 'Semua')?'':' '.$detail['nama_instalasi'];
              
              echo "$layanan";
            ?></td>
        </tr>
        <tr>
            <td>
                Nama Nakes:
            </td>
            <td> <?=$detail['nama_dokter']?></td>
        </tr>
        <tr>
            <td>
                Kamar/Bed/Klinik:
            </td>
            <td> 
              <?
                $klinik = "Klinik $detail[nama_bed]";
                $klinik .= ($detail['nama_instalasi'] == 'Tanpa Instalasi' || $detail['nama_instalasi'] == 'Semua')?'':' '.$detail['nama_instalasi'];
                
                echo "$klinik";
              ?>
            </td>
        </tr>
    </table>
</fieldset>
<fieldset style="margin-top:5px;">
        <legend>Data Pasien</legend>
        <table width=100% cellspacing=0 cellpadding=0px>
            <tr>
                <td style="width: 50%" valign="top">
                 <table style="width: 100%" cellpadding="3px">
                    <tr>
                        <td> No. Rekam Medik:</td><td> <?=$detail['norm']?></td>
                    </tr>
                    <tr>
                        <td> Nama Pasien:</td><td> <?=$detail['nama_pasien']?></td>
                    </tr>
                    <tr>
                        <td> Alamat Jalan/RT/RW:</td><td> <?=$detail['alamat_jalan']?></td>
                    </tr>
                    <tr>
                        <td> Desa/Kelurahan:</td><td> <? echo "$detail[nama_kelurahan],$detail[kecamatan],$detail[kabupaten]";?></td>
                    </tr>
                    <tr>
                        <td> Jenis Kelamin:</td><td> <?=$detail['jenis_kelamin']?></td>
                    </tr>
                    <tr>
                        <td> Golongan Darah:</td><td> <?=$detail['gol_darah']?></td>
                    </tr>
                    <tr>
                        <td> Tanggal Lahir:</td><td> <?=  datefmysql($detail['tanggal_lahir'])?></td>
                    </tr>
                    <tr>
                        <td> Umur:</td><td> <?=  createUmur($detail['tanggal_lahir'])?> tahun</td>
                    </tr>
                    <tr>
                        <td> Status Perkawinan:</td><td> <?=$detail['perkawinan']?></td>
                    </tr>
                    <tr>
                        <td> Pendidikan Terakhir:</td><td> <?=$detail['nama_pendidikan']?></td>
                    </tr>
                    <tr>
                        <td> Pekerjaan:</td><td> <?=$detail['nama_pekerjaan']?></td>
                    </tr>
                    <tr>
                        <td> Agama:</td><td> <?=$detail['nama_agama']?></td>
                    </tr>
					<tr>
                        <td width="28%"> Rencana Pembayaran:</td><td> <?=$detail['rencana_cara_bayar']?></td>
                    </tr>
                </table>
            </td>
            <td width="50%" valign="top">
                
                            <fieldset class="noborder">
                                <legend class="noborder"><strong>Kepesertaan Asuransi</strong></legend>
<?if(sizeof($asuransi)>0){?>
                                <table width=60% class="table-input" cellpadding="3px">
                                    <tr>
                                        <th>Nama</th><th>No. Polis</th>
                                    </tr>
                                <?  
                                    foreach($asuransi as $a){
                                        ?>
                                            <tr><td><?=$a['nama_asuransi']?></td><td><?=$a['no_polis']?></td></tr>
                                        <?
                                    }
                                ?>
                                </table>
                                <?}else
                                    echo"&nbsp;-"
                                    ?>
                            </fieldset>
                       
                            <fieldset class="noborder">
                                <legend class="noborder"><strong>Penanggung Jawab</strong></legend>
<table width=100% cellpadding="3px">
                                    <tr>
                                        <td width="25%"> Nama:</td><td> <?=$detail['nama_penanggungjawab']?></td>
                                    </tr>
                                    <tr>
                                        <td width="25%"> Alamat:</td><td> <?=$detail['alamat_penanggungjawab']?></td>
                                    </tr>
                                    <tr>
                                    <?
									if(($detail['no_telp_penanggungjawab']=='NULL')or ($detail['no_telp_pengantar']=='NULL')){
									$telppjb='';
									$ntp='';
									}
									else{
									$telppjb=$detail['no_telp_penanggungjawab'];
									$ntp=$detail['no_telp_pengantar'];
									}
									?>
                                        <td width="25%"> No Telp:</td><td> <?=$telppjb?></td>
                                    </tr>
                                </table>
                            </fieldset>
                       
                            <fieldset class="noborder">
                                <legend class="noborder"><strong>Pengantar</strong></legend>
<table width=100% cellpadding="3px">
                                    <tr>
                                        <td width="25%"> Nama:</td><td> <?=$detail['nama_pengantar']?></td>
                                    </tr>
                                    <tr>
                                        <td width="25%"> Alamat:</td><td> <?=$detail['alamat_pengantar']?></td>
                                    </tr>
                                    <tr>
                                        <td width="25%"> No Telp:</td><td> <?=$ntp?></td>
                                    </tr>
                                </table>
                            </fieldset>
                       
                            <fieldset class="noborder">
                                <legend class="noborder"><strong>Rujukan</strong></legend>
<table width=100% cellpadding="3px">
                                    <tr>
                                        <td width="25%"> No. Surat Rujukan:</td><td> <?=$detail['no_surat_rujukan']?></td>
                                    </tr>
                                    <tr>
                                        <td width="25%"> Rujukan Dari:</td><td> <?=$detail['nama_rujukan']?></td>
                                    </tr>
                                    <tr>
                                        <td width="25%"> Nama Nakes:</td><td> <?=$detail['nama_nakes']?></td>
                                    </tr>
                                </table>
                            </fieldset>
                        
            </td>
        </tr>
        </table>
    </fieldset>

<br>
<?php
    $layanan=$detail['id_instalasi'];
//    if($layanan==8){
//        $preview1='lembar-ugd-depan';
//    }else if($layanan==9){
//        $preview1='lembar-poliklinik';
//    }else{
//        $preview1='preview';
//    }

    if($layanan==4){
        $preview1='lembar-ugd-depan';
    }else{
        $preview1='lembar-poliklinik';
    }
?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#cetak-lembar-pertama').click(function(){
            window.open('<?=  app_base_url("admisi/$preview1?idKunjungan=$_GET[id]")?>','mywindow','location=1,status=1,scrollbars=1,width=800px');
        });
        $('#cetak-antrian').click(function(){
            window.open('<?=  app_base_url("admisi/print/kartu-antrian?id=$_GET[id]")?>','mywindow','location=1,status=1,scrollbars=1,width=300px,height=220px');
        });
        $('#cetak-kartu').click(function(){
            window.open('<?=  app_base_url("admisi/kartu-pasien?idp=$detail[norm]")?>','mywindow','location=1,status=1,scrollbars=1,width=800px');
        });
    });
</script>