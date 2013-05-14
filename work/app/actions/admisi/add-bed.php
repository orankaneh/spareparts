<?php
$kelas = kelas_instalasi_muat_data();
?>

<div class="data-input">
    <form action="<?= app_base_url('admisi/control/bed')?>" method="POST" onSubmit="return checkdata(this)">
    <fieldset class="data-input">
        <legend>Form Tambah Data Kamar/Bed/Klinik</legend>
        <div class="field-group"><label for="bed">No. Kamar/Bed/Klinik *</label><input type="text" name="bed" id="bed" class="tgl" /></div>
        <label for="kelas">Kelas *</label>
        <select id="kelas" name="kelas">
            <option value="">Pilih...</option>
            <?
              foreach ($kelas as $row) :
            ?>
            <option value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
            <?
              endforeach;
            ?>
        </select>
        <label for="kelas">Instalasi/Ruang *</label>
        <select id="instalasi" name="instalasi">
            <option value="">Pilih...</option>
            <?
                foreach ($instalasi as $f){
                    echo "<option value='$f[id]'>$f[nama]</option>";
                }
            ?>
        </select>
        <label>Jenis</label>
        <select name="jenis" id="jenis">
            <option value="">Pilih jenis kamar/bed/klinik</option>
            <option value="Semua">Semua</option>
            <option value="Rawat Jalan">Rawat Jalan</option>
            <option value="Rawat Inap">Rawat Inap</option>
            <option value="OK">OK</option>
        </select>
        <fieldset class="input-process">
            <input type="submit" class="tombol" value="Simpan" name="add" id="save">
            <input type="button" class="tombol" value="Batal" onClick="javascript:location.href='<?= app_base_url('admisi/data-bed') ?>'">
        </fieldset>
    </fieldset>
    </form>    
      
</div>