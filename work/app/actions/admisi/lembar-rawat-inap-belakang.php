<?
require_once 'app/lib/common/functions.php';
set_time_zone();
$idKunjungan=(isset($_GET['idKunjungan']))?$_GET['idKunjungan']:null;
$sql="
select
ps.id as idPasien
from kunjungan k

left join pasien ps on (ps.id=k.id_pasien)

where k.id='$idKunjungan'
";

$query=mysql_query($sql);
$row=mysql_fetch_array($query);

?>
<html>
    <head>
        <title>
            Surat Pengantar
        </title>
        <link rel='stylesheet' type='text/css' href='<?=app_base_url('/assets/css/base.css')?>'>
    </head>
    <body>
        <?require_once 'app/actions/admisi/lembar-header.php';?>
        <table class="contain2"  border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="0" valign="middle" >Surat Pengantar</td>
                <td>No RM&nbsp;&nbsp;&nbsp; &nbsp;: <?=(isset($row['idPasien']))?$row['idPasien']:'......................';?>
                    <br>Tanggal&nbsp;&nbsp;&nbsp;&nbsp;: <?=indo_tgl(Date('d/m/Y'))?>
                    
                </td>
            </tr>
            <tr>
                <td colspan="2" height="500" valign="top" align="center">
                    <br><br><br><i>Tempel lembar surat pengantar</i>
                </td>
            </tr>
        </table>
    </body>
</html>
<?
exit;
?>