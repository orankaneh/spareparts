<?php
require_once 'app/lib/common/functions.php';
set_time_zone();
echo"
<html>
<head>
  <title>Lembar UGD 2</title>
  <link rel='stylesheet' type='text/css' href='".app_base_url('/assets/css/base.css')."'>
</head>
<body>";
require_once 'app/actions/admisi/lembar-header.php';
?>
<table class=contain cellpadding=0 cellspacing=1 align="center">
    <tr>
        <td>
            Laboratorium:
            <br>
            <br>
            Radiologi
            <ol type="A" start="3">
                <li>
                    DIAGNOSIS MASUK<br><br><br><br>
                </li>
                <li>
                    TERAPI / TINDAKAN<br><br><br><br><br><br><br><br>
                    Tindakan yang dilakukan diperlukan informed Constant secara tertulis<br>
                    <input type="checkbox"> Ya<br>
                    <input type="checkbox"> Tidak, Persetujuan dilakukan secara lisan/tidak tertulis
                </li>
                <li>
                    RENCANA PELAYANAN / TINDAKAN LANJUTAN :<br><br><br><br>
                </li>
                <li>
                    TINDAK LANJUTAN :<br>
                    <input type="checkbox"> Dipulangkan &nbsp;&nbsp; Dirawat inap ke Bangsal................................................... Kelas................<br>
                    <input type="checkbox"> Dirujuk Ke...............................................................................<br>
                    Atas Dasar <input type="checkbox"> Tempat Penuh <input type="checkbox"> Permintaan Pasien <input type="checkbox"> Keterbatasan Fasislitas / Dokter Ahli
                    <input type="checkbox"> Menolak Dirawat<br>
                    <input type="checkbox"> Meninggal Pukul..........................<br>
                    <br><br><br><br><br>

                    <center>
                        Tanggal, <?=  indo_tgl(Date('d/m/Y'))?>, Jam.........
                        <br>Dokter yang memeriksa,
                        <br><br><br>
                        <u>..............................</u>
                    </center>
                </li>
            </ol>
        </td>
    </tr>
</table>

<?
echo"
    </body>
</html>";
?>
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
<?
exit;
?>