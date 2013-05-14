<script type="text/javascript" src="<?= app_base_url('/assets/js/jquery-latest.js') ?>"></script>
<style>
.print-table {font: 14px "Consolas",Fixedsys; margin: -14px 0 20px 0}
.utama {font-size: 95px !important; line-spacing: 0px}
.rekamedik {font-size: 32px !important}
.no {font-family: "Arial Narrow","Consolas"; font-weight: 900; letter-spacing: -1px}

</style>



<?php

  include_once "app/lib/common/master-data.php";
  $noAntri = $_GET['id'];
  $qry = "select pasien.id, k.id,penduduk.nama,k.id_layanan,dp.alamat_jalan,layanan.nama as nama_layanan,sp.nama as spesialisasi,
p.nama as profesi,bed.nama as bed, kelas.nama as kelas, i.nama as instalasi,kel.nama as kelurahan, kec.nama as kecamatan,
layanan.bobot,k.no_antrian,pasien.id as norm
  from kunjungan k
    JOIN pasien on pasien.id=k.id_pasien
    JOIN penduduk on penduduk.id=pasien.id_penduduk
    JOIN dinamis_penduduk dp on dp.id_penduduk=penduduk.id
    left JOIN kelurahan kel on kel.id=dp.id_kelurahan
    left join kecamatan kec on kec.id=kel.id_kecamatan
    JOIN layanan on layanan.id=k.id_layanan
    join spesialisasi sp on layanan.id_spesialisasi = sp.id
    left join profesi p on sp.id_profesi = p.id
    left join bed on k.id_bed=bed.id
    join kelas on bed.id_kelas=kelas.id
    left join instalasi i on bed.id_instalasi=i.id
    WHERE k.id='$noAntri'";
  $data = _select_unique_result($qry);
  $norm=  $data['norm'];
?>
<html>
    <head>
        <title>Kartu Antrian</title>
        <style type="text/css">
        .tombol {
            background: url(<?= app_base_url('assets/images/tile.jpg')?>) repeat;
            font-weight: normal;
            font-size: 10px;
                padding: 2px 20px;
            border: 1px solid #cccccc;
            cursor: pointer;
            color: #ffffff;
            -moz-border-radius:3px;
            -webkit-border-radius: 3px;
        }
        td{
            text-align: center;
        }
        </style>
        <script type="text/javascript">
            function cetak() {
                SCETAK.innerHTML = '';
                window.print();
                window.close();
                SCETAK.innerHTML = '<br /><input onClick=\'cetak()\' type=\'submit\' name=\'Submit\' value=\'Cetak\' class=\'tombol\'>';
            }

        </script>
    </head>
    <body>

        <table width="230px" class="print-table">
            <tr>
            <?
              if ($data['bobot'] == 'Tanpa Bobot') $bobot = "";
                else $bobot = $data['bobot'];
				?>

                <td><?= date('d/m/Y')."<br>$data[nama_layanan] $data[profesi] $data[spesialisasi] $bobot $data[instalasi]"?></td>
            </tr>
            <tr>
                <td><span class="no utama"><strong><?= antri($data['no_antrian'])?></strong></span></td>
            </tr>
            <tr>
                <td><span class="no rekamedik"><strong><?=$norm?></strong></span></td>
            </tr>
            <tr>
                <td><?= $data['nama']?></td>
            </tr>
            <tr>
                <td><?= "$data[kelurahan]-$data[kecamatan]"?></td>
            </tr>
            
        </table>
        <p align="center">
        <span id="SCETAK"><input type="button" class="tombol" value="Cetak" onClick="cetak()"/></span>
        </p>
    </body>
</html>
<?php
exit();
?>
