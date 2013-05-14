<?php
    require_once 'app/lib/common/master-inventory.php';
    require_once 'app/lib/common/master-data.php';
    
    $retur = retur_penjualan_muat_data($_GET['id']);
    $retur=$retur[0];
    $detail = detail_retur_penjualan_muat_data($_GET['id']);
?>
<link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/base.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/style.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/tabel.css') ?>" media="all" />
	<? require_once 'app/actions/admisi/lembar-header.php'; ?>
<div class="body-nota">
	<table width=100%>
                <tr>
                    <td colspan="3" align="center">SURAT RETUR</td>
                </tr>
                <tr><td width="26%">No. Retur</td><td>:</td><td><?= $retur['id']?></td></tr>
                <tr><td width="26%">Waktu</td><td>:</td><td><?= date('d/m/Y')?></td></tr>
                <tr><td width="26%">Pembeli</td><td>:</td><td><?= $retur['pembeli'] ?></td></tr>
	</table>
</div>
 <div class="head-nota">
            <table style="border:none;" width="100%">
                <tr>
                    <td>No</td>
                    <td>Barang</td>
                    <td>Jumlah</td>
                    <td>Alasan</td>
                    <td>Harga</td>
                    <td>Sub Total</td>
                </tr>
                <?  
                    $total = 0;
                    $i=1;
                foreach ($detail as $key => $row){
                    $d=$row;
                    $total+=(($d['hna']*$d['margin']/100)+$d['hna'])*$d['jumlah_retur'];
                    $nama = "$d[barang]";
                    if (($d['generik'] == 'Generik') || ($d['generik'] == 'Non Generik')) {
                        $nama.= ( $d['kekuatan'] != 0) ? " $d[kekuatan], $d[sediaan]" : " $d[sediaan]";
                    }
                    $nama .=" @$d[nilai_konversi] $d[satuan_terkecil]";
                    $nama.= ( $d['generik'] == 'Generik') ? ' ' . $d['pabrik'] : '';
                ?>
                   <tr>
                    <td><?= $i++?></td>
                    <td><?= $nama?></td>
                    <td><?= $row['jumlah_retur']?></td>
                    <td><?= $row['alasan']?></td>
                    <td><?= rupiah(($d['hna']*$d['margin']/100)+$d['hna']) ?></td>
                    <td><?=rupiah((($d['hna']*$d['margin']/100)+$d['hna'])*$d['jumlah_retur'])?></td>
                </tr>
                <?
                }
               ?>
                <tr>
                    <td colspan="5">Total</td>
                    <td><?= rupiah($total)?></td>
                </tr>
            </table>
</div>     
<div class="data-input">
            <center>
                <p><span id="SCETAK"><input type="button" class="tombol" value="Cetak" onClick="cetak()"/></span></p>
            </center>
        </div>
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
<?exit();?>