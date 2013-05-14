<?
require_once 'app/lib/common/master-data.php';
$detailBilling = detail_billing_muat_data2($_GET['id']);
if (count($detailBilling) == 0)
    exit;
?>
        <?
        $no = 1;
        $result=array();
        foreach ($detailBilling as $row) {
            $bobot=($row['bobot'] == 'Tanpa Bobot')?"":$row['bobot'];
            $profesi=($row['profesi'] == 'Tanpa Profesi')?"":$row['profesi'];
            $spesialisasi=($row['spesialisasi'] == 'Tanpa Spesialisasi')?"":$row['spesialisasi'];
            $layanans=($row['jenis'] == "Rawat Inap" && $row['id_instalasi']<>9 && $row['instalasi']!='Tanpa Instalasi')?"$row[layanan] $row[instalasi]":$row['layanan'];
            $layanan = "$layanans $bobot $profesi $spesialisasi";
            $layanan.=($row['id_kelas']!='1')?" ".$row['kelas']:'';
            $result[]=array('layanan'=>$layanan,
                            'total'=>$row['total'],
                            'nakes1'=>($row['nakes1'] != null && $row['nakes1'] != '') ? $row['nakes1'] : '-',
                            'nakes2'=>($row['nakes2'] != null && $row['nakes2'] != '') ? $row['nakes2'] : '-',
                            'nakes3'=>($row['nakes3'] != null && $row['nakes3'] != '') ? $row['nakes3'] : '-',
                            'frekuensi'=>$row['frekuensi']
                            );
        }
      die(json_encode($result));
exit;
?>