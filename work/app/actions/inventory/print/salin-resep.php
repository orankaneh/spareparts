<?php
require_once 'app/config/db.php';
require_once 'app/lib/common/master-inventory.php';
set_time_zone();
$resep = array();
$resep = nota_penjualan_muat_data($_GET['code'], $_GET['kelas'],null);
$resep_info=info_salin_resep($_GET['code']);
//show_array($resep);
$master=isset($cetak_salin_resep['master'])?$cetak_salin_resep['master']:NULL;
$detail=isset($cetak_salin_resep['detail'])?$cetak_salin_resep['detail']:NULL;
$sip_user=get_sip(User::$id_user);
echo "";
?>
<html>
    <head>
        <title>Salinan Resep</title>
        <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/base.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/style.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/tabel.css') ?>">
        <script language='JavaScript'>
            function cetak() {
                SCETAK.innerHTML = '';
                window.print();
                if (confirm('Apakah menu print ini akan ditutup?')) {
                    window.close();
                }
                SCETAK.innerHTML = '<br /><input onClick=\'cetak()\' type=\'submit\' name=\'Submit\' value=\'Cetak\' class=\'tombol\'>';
            }

        </script>
        <style type="text/css">
            body{
                font-family: arial;
                font-size: 11px;
                color: #000000;
            }
        </style>
    </head>
    <body>

	<? require_once 'app/actions/admisi/lembar-header.php'; ?>
	<center><span style="font-family: courier new;">SALINAN RESEP</span></center>
        <div class="head-nota">
            <table width="500">
                <tr>
                    <td width="150">Penanggung Jawab</td>
                    <td><?=User::$nama?></td>
                </tr>
                <tr>
                    <td width="150">SIP</td>
                    <td><?=$sip_user['sip']=='NULL'?'-':$sip_user['sip']?></td>
                </tr>
                <tr>
                    <td width="150">No. Resep</td>
                    <td>........................
                    <?//= $resep[0][0] ?></td>
                </tr>
                <tr>
                    <td>Tanggal Resep</td>
                    <td>........................
                    <?//= datefmysql($resep[0]['tanggal']) ?></td>
                </tr>
                <tr>
                    <td>Tanggal Salinan Resep</td>
                    <td><?=date('d/m/Y');//datefmysql($resep_info[0]['waktu']) ?></td>
                </tr>
                <tr>
                    <td>Nama Dokter</td>
                    <td><?= $resep_info[0]['nama_dokter'] ?></td>
                </tr>
                <tr>
                    <td>SIP</td>
                    <td><?= $resep_info[0]['sip']=='NULL'?'-':$resep_info[0]['sip'] ?></td>
                </tr>
                <tr>
                    <td>Pro</td>
                    <td><?= $resep_info[0]['nama_pembeli']  ?></td>
                </tr>
                <tr>
                    <td>Catatan</td>
                    <td><?= $resep_info[0]['catatan']  ?></td>
                </tr>
            </table>
        </div>

        <div class="head-nota">
            <table style="border:none;" width="100%">
                
<?
    foreach ($resep['list'] as $key => $rows): 
	if ($rows['kekurangan_tebus'] == '0') $detur = "Detur";
	else if ($rows['kekurangan_tebus'] == $rows['jumlah_r_resep']) $detur = "Nedet";
	else $detur = "Det $rows[kekurangan_tebus]";
        if($rows['sub_kategori_barang']!='Embalase'){
	?>
                <tr>
                    <td valign="top" width="5%" align="center"><?= isset($rows['no_r'])?'R/':'-' ?></td>
                    <?php
                        if($rows['jenis_r']=='Racikan'){
                    ?>
                    <td valign="top" width="70%"><?= $rows['nama_obat']." ".$rows['sediaan']." ".$rows['kekuatan_r_racik']." ".$rows['jumlah_r_resep']." "//$rows['nama_barang']." ".$rows['pabrik']." @".$rows['nilai_konversi']." ".$rows['satuan'] ?><?= isset($detur)?$detur:null ?></td>
                    <?php
                        }else{
                    ?>
                    <td valign="top" width="70%"><?= $rows['nama_obat']." ".$rows['kekuatan']." ".$rows['sediaan']." "//$rows['nama_barang']." ".$rows['pabrik']." @".$rows['nilai_konversi']." ".$rows['satuan'] ?><?= isset($detur)?$detur:null ?></td>
                    <?php
                        }
                    ?>
                    
                </tr>
                <tr>
                    <td></td> <td>(<?=$rows['aturan_pakai']?>)</td>
                </tr>
<?php
        }
        endforeach; ?>
            </table>
        </div>
        <div  class="display-blok">
            <table width="500" align="right">
                <tr>
                    <td align="right">Pcc</td>
                </tr>
                <tr>
                    <td height="30"></td>
                </tr>
                <tr>
                    <td align="right"><b><?php echo "$_SESSION[nama]";?></b></td>
                </tr>
            </table>
        </div>
        <div class="data-input">
            <center>
                <p><span id="SCETAK"><input type="button" class="tombol" value="Cetak" onClick="cetak()"/></span></p>
            </center>
        </div>
    </body>
</html>
<?php
                exit();
?>
