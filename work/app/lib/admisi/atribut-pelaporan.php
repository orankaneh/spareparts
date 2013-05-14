<?php

function reporting_data_attribute() {
    return array(
        array(
            'value' => 'p.id', 'nama' => 'No. rekam medik', 'atribut' => 'selected'),
        array(
                'value' => 'pd.nama', 'nama' => 'Nama pasien', 'atribut' => 'selected'),
        array(
                'value' => 'pd.tanggal_lahir', 'nama' => 'Tgl lahir'),
        array(
                'value' => 'pd.jenis_kelamin', 'nama' => 'Kelamin', 'atribut' => 'selected'),
        array(
                'value' => 'kw.perkawinan', 'nama' => 'Perkawinan'),
        array(
                'value' => 'pdd.nama', 'nama' => 'Pendidikan', 'atribut' => 'selected'),
        array(
                'value' => 'pr.nama', 'nama' => 'Pekerjaan'),
        array(
                'value' => 'a.nama', 'nama' => 'Agama'),
        array(
                'value' => 'dp.alamat_jalan', 'nama' => 'Alamat'),
        array(
                'value' => 'pnj.nama', 'nama' => 'Penanggung jawab'),
        array(
                'value' => 'pg.id', 'nama' => 'SIP')
    );
}

function data_tipe_pasien($tipe = 'all') {
    $macam = array(
            array('nama' => 'Pasien lama', 'tipe' => 1),
            array('nama' => 'Pasien baru', 'tipe' => 2));

    //echo $macam['nama']; die;
    //return $macam;
    switch ($tipe) {
        case '1':
            $ret = array();
            foreach ($macam as $m) {
                if ($m['tipe'] != 1) continue;
                $ret[] = $m;
            }
            return $ret;

        case '2' :
            $ret = array();
            foreach ($macam as $m) {
                if ($m['tipe'] != 2) continue;
                $ret[] = $m;
            }
            return $ret;

        default:
            return $macam;
    }
}

function data_gender($value = 'L') {
    $macam = array(
        array('nama' => 'Laki-laki', 'value' => 'L'),
        array('nama' => 'Perempuan', 'value' => 'P'));

    switch ($value) {
        case 'L':
            $ret = array();
            foreach ($macam as $m) {
                if ($m['value'] != 'L') continue;
                $ret[] = $m;
            }
            return $ret;

        case 'P' :
            $ret = array();
            foreach ($macam as $m) {
                if ($m['value'] != 'P') continue;
                $ret[] = $m;
            }
            return $ret;

        default:
            return $macam;
    }
}

function data_payment($value = 'all') {
    $macam = array(
        array('nama' => 'biaya sendiri', 'value' => '1'),
        array('nama' => 'asuransi', 'value' => '2'),
        array('nama' => 'charity', 'value' => '3')
    );

    switch ($value) {
        case '1':
            $ret = array();
            foreach ($macam as $m) {
                if ($m['value'] != '1') continue;
                $ret[] = $m;
            }
            return $ret;

        case '2' :
            $ret = array();
            foreach ($macam as $m) {
                if ($m['value'] != '2') continue;
                $ret[] = $m;
            }
            return $ret;

        case '3':
            $ret = array();
            foreach ($macam as $m) {
                if ($m['value'] != '3') continue;
                $ret[] = $m;
            }
            return $ret;

        default:
            return $macam;
    }
    
}

function data_instalasi_group_year() {
    $macam = array(
      1 => array('instalasi' => 'id_instalasi_tujuan')
    );
}