<?php

function squence_number($tujuan) {
    //$tujuan = isset($tujuan);
    $sql = mysql_query("select max(no_antrian) as no_antrian, id_layanan from kunjungan where id_layanan = '$tujuan' and date(waktu) = '" . date("Y-m-d") . "'") or die(mysql_error());

    $row = mysql_fetch_array($sql);
    $cek = mysql_num_rows(mysql_query("select * from layanan where id = '$tujuan'"));
    if ($cek > 0) {

        return array('no_antrian'=>"<label>No. Urut</label>
            <b>" . $tujuan . "." . date('dmY') . "." . antri($row['no_antrian']) . "</b><input type='hidden' id='noAntrian' value='" . $tujuan . "." . date('dmY') . "." . antri($row['no_antrian']) . "'><input type='hidden' name='no_antri' value='" . antri($row['no_antrian']) . "' />",
            'cetak'=>"<a class='cetak'>Cetak Kartu Antrian</span></a>");
    } else {
        //return $input = 1;
    }
}

function create_medical_record_number() {
    $sql = "select max(id) + 1 as new_number from pasien";
    return _select_unique_result($sql);
}

?>
