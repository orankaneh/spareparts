<?
include_once "app/lib/common/master-data.php";
$kelas = kelas_muat_data();
$barang = array_value($_GET, 'barang');
$idBarang = array_value($_GET, 'idBarang');
$idKelas = array_value($_GET, 'kelas');
$idKategori=array_value($_GET, 'idKategori');
if(isset($_GET['idKategori'])  && $_GET['idKategori']!='')
    $kategori = kategori_barang_muat_data(array_value($_GET, 'idKategori'));
$namaKelas = kelas_muat_data($idKelas);
$namaKelas = array_value($namaKelas, 'nama');
$dataBarang = barang_adm_muat_data($idBarang, $idKategori,$idKelas);
// header file excel
?>
<html>
    <head>
        <title>Administrasi Harga</title>
        <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/base.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/style.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/tabel.css') ?>">
        <script type="text/javascript">
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
        <div>
            <table border="0" align="center">
                <tr>
                    <td align="center"><font size="+1">RS. PKU MUHAMMADYAH TEMANGGUNG</font></td>
                </tr>
                <tr>
                    <td align="center"><font size="+1">Daftar Harga Jual Barang <?=($_GET['idKategori']!='')?"$kategori[nama] $kategori[kategori]":""?></font></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>

        <div class="data-list">
            <table class="table-cetak">
                <tr>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Kelas</th>
                    <th class="no-wrap">Harga Jual</th>
                </tr>
            <?php foreach ($dataBarang as $key => $row): ?>
                        <tr>
                            <td><?= $row['id_packing'] ?></td>
                            <td><?= "$row[barang] $row[nilai_konversi] $row[satuan_terkecil]" ?></td>
                            <td><?= $row['nama_kelas'] ?></td>
                            <td id="harga<?=$key?>"><?=$row['hna']*$row['margin']/100+$row['hna']?></td>
                        </tr>
                        <script type="text/javascript">
                            hitungHarga(<?=$key?>);
                        </script>
            <?php endforeach; ?>
        </table>
        </div>
        
        <div class="data-input">
            <center>
                <p><span id="SCETAK"><input type="button" class="button" value="Cetak" onClick="cetak()"/></span></p>
            </center>
        </div>
    </body>
</html>
<?php
exit;
?>