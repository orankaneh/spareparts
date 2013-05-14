<?php
 include_once "app/lib/common/functions.php";
 include_once "app/lib/common/master-data.php";
 $norm = $_GET['norm'];
 $id_pelayanan = $_GET['id'];
 
 $pasien = pasien_muat_data($norm);
 $rekam_medik = info_rekam_medik_muat_data($id_pelayanan);
 foreach ($rekam_medik as $row);
  include 'app/actions/admisi/pesan.php';
?><?= isset($pesan) ? $pesan : NULL ?>
<h2 class="judul"><a href="<?php echo app_base_url("rekam-medik/informasi/info-rekam-medik/?".generate_get_parameter($_GET));?>">Rekam Medik</a></h2>
<div class="data-input">
    <fieldset style="width: 100%">
        <legend>Pasien</legend>
        <label>No. RM</label><span style="font-size: 12px;padding-top: 5px;" id="norm"><?php echo $pasien['id_pas'];?></span>
        <label>Nama Lengkap</label><span style="font-size: 12px;padding-top: 5px;" id="pasien"><?php echo $pasien['nama'];?></span>
        <fieldset class="field-group">
            <label>Umur</label>
            <span style="font-size: 12px;padding-top: 5px;" id="umur"><?php echo hitungUmur(datefmysql($pasien['tanggal_lahir']));?></span>
        </fieldset>
        <label>Agama</label><span style="font-size: 12px;padding-top: 5px;" id="agama"><?php echo $pasien['agama'];?></span>
        <label>Pekerjaan</label><span style="font-size: 12px;padding-top: 5px;" id="pekerjaan"><?php echo $pasien['pekerjaan'];?></span>
        <label>Alamat</label><span style="font-size: 12px;padding-top: 5px;" id="alamat"><?php echo $pasien['alamat_jalan'];?></span>
        <label>Kelurahan</label><span style="font-size: 12px;padding-top: 5px;" id="kelurahan"><?php echo $pasien['nama_kelurahan'];?></span>
    </fieldset>
    <fieldset>
    <legend>Data Pelayanan Medik</legend>    
    <table width="100%">
        <tr>
            <td valign="top" width="50%">
                <label>Waktu</label><span style="font-size: 12px;padding-top: 5px;" ><?php echo datetime($row['waktu']);?></span>
                <label>Bed</label><span style="font-size: 12px;padding-top: 5px;" ><?php echo "Klinik ".$row['bed']." ".$row['instalasi']?></span>
                <label>Dokter</label><span style="font-size: 12px;padding-top: 5px;" ><?php echo $row['dokter'];?></span>
                <fieldset style="width: 90%">
                    <legend>Anamnesa</legend>
                    <textarea name="anamnesa" id="anamnesa" readonly="readonly"><?php echo $row['anamnesis']?></textarea>
                </fieldset>
                <fieldset style="width: 90%">
                    <legend>Pemeriksaan</legend>
                    <label>KU</label><textarea name="ku" id="ku" readonly="readonly"><?php echo $row['anamnesis']?></textarea>
                    <label>Laboratorium</label><textarea name="laboratorium" id="laboratorium" readonly="readonly"><?php echo $row['pemeriksaan_lab']?></textarea>
                    <label>Radiologi</label><textarea name="radiologi" id="radiologi" readonly="readonly"><?php echo $row['pemeriksaan_radiologi']?></textarea>
                </fieldset>
            </td>
            <td valign="top">
                <fieldset style="width: 90%">
                    <legend>Terapi</legend>
                    <textarea name="terapi" id="terapi" readonly="readonly"><?php echo $row['terapi']?></textarea>
                </fieldset>
                <label>Alasan Datang</label><span style="font-size: 12px;padding-top: 5px;" ><?php echo $row['alasan_datang'];?></span>
                <fieldset style="width: 90%">
                    <legend>Kejadian</legend>
                    <label>Nama</label><span style="font-size: 12px;padding-top: 5px;" ><?php echo $row['kejadian_sakit'];?></span>
                    <label>Waktu Tiba</label>
                      <span style="font-size: 12px;padding-top: 5px;" id="waktu_tiba">
                        <?php 
                          echo ($row['waktu_tiba']!="")?datetime($row['waktu_tiba']):"";
                        ?>
                      </span>
                    <label>Waktu Kejadian</label>
                      <span style="font-size: 12px;padding-top: 5px;" id="waktu_kejadian">
                        <?php 
                          echo ($row['waktu_kejadian']!="")?datetime($row['waktu_kejadian']):"";
                        ?>
                      </span>
                    <label>Alamat</label><span style="font-size: 12px;padding-top: 5px;" id="alamat_kejadian"><?php echo $row['alamat_kejadian'];?></span>
                    <label>Kelurahan</label><span style="font-size: 12px;padding-top: 5px;" id="kelurahan_kejadian"><?php echo $row['kelurahan_kejadian'];?></span>
                    <label>Penyebab Kejadian</label><span style="font-size: 12px;padding-top: 5px;" id="penyebab_kejadian"><?php echo $row['penyebab_cedera'];?></span>
                </fieldset>
                <fieldset style="width: 90%">
                    <legend>Keterangan</legend>
                    <textarea name="keterangan" id="keterangan" readonly="readonly"><?php echo $row['keterangan'];?></textarea>
                </fieldset>
                <label>Resusitasi</label><span style="font-size: 12px;padding-top: 5px;" ><?php echo $row['tindakan_resusitasi'];?></span>
                <label>Tindak Lanjut</label><span style="font-size: 12px;padding-top: 5px;" ><?php echo $row['tindak_lanjut'];?></span>
            </td>
        </tr>
    </table>
    </fieldset>    
    <fieldset>
        <legend>Diagnosa & Tindakan Pelayanan Medik</legend>
        <?php
          $diagnosa = diagnosa_tindakan_rekam_medik($id_pelayanan);
        ?>
        <fieldset style="width:90%">
            <legend>Detail Diagnosa</legend>
            <div class="data-list">
                <table class="tabel">
                    <tr>
                        <th>No</th>
                        <th>Nama ICD 10</th>
                        <th>Kode ICD 10</th>
                    </tr>
                    <?php
                        $i = 1;
                        foreach ($diagnosa['diagnosa'] as $rows){
                    ?>
                    <tr class="<?php echo ($i%2)?"even":"odd";?>">
                        <td align="center"><?php echo $i++;?></td>
                        <td><?php echo $rows['penyakit']?></td>
                        <td><?php echo $rows['kode_icd10']?></td>
                    </tr>
                    <?php
                        }
                    ?>
                </table>
            </div>
        </fieldset>
        <fieldset style="width:90%">
            <legend>Detail Tindakan</legend>
            <div class="data-list">
                <table class="tabel">
                    <tr>
                        <th>No</th>
                        <th>Nama ICD 9</th>
                        <th>Kode ICD 9</th>
                        <th>Informed Consent</th>
                    </tr>
                    <?php
                        $j = 1;
                        foreach ($diagnosa['tindakan'] as $rowz){
                    ?>
                    <tr class="<?php echo ($j%2)?"even":"odd";?>">
                        <td align="center"><?php echo $j++?></td>
                        <td><?php echo $rowz['penyakit']?></td>
                        <td><?php echo $rowz['kode_icd9']?></td>
                        <td><?php echo $rowz['informed_consent']?></td>
                    </tr>
                    <?php
                        }
                    ?>
                </table>
            </div>    
        </fieldset>
    </fieldset>
</div>