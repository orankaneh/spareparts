<?php
$rows = bed_by_kelas_instalasi($_GET['id']);
$kelas = kelas_instalasi_muat_data();
?>
<div class="data-input">
    <form action="<?= app_base_url('admisi/control/bed')?>" method="POST" onSubmit="return checkdata(this)">
    <fieldset>
        <legend>Form Edit Data Kamar/Bed/Klinik</legend>
        <div class="field-group">
            <label for="bed">No. Kamar/Bed/Klinik *</label><input type="text" name="bed" id="bed" value="<?= $rows['nama']?>" class="tgl"></div>
        <input type="hidden" name="idBed" id="idBed" value="<?= $rows['id']?>">
        <label for="kelas">Kelas *</label>
        <select id="kelas" name="kelas">
            <option value="">Pilih...</option>
            <?
              foreach ($kelas as $row){
            ?>
            <option value="<?= $row['id']?>" <?if($row['id']==$rows['id_kelas']) echo"selected"?>><?= $row['nama']?></option>
            <?
              }
            ?>
        </select>
        <label for="kelas">Instalasi/Ruang *</label>
        <select id="instalasi" name="instalasi">
            <option value="">Pilih...</option>
            <?
                foreach ($instalasi as $f){
                    if($f['id']==$rows['id_instalasi']){
                        $selected="selected";
                    }else $selected='';
                    echo "<option value='$f[id]' $selected>$f[nama]</option>";
                }
            ?>
        </select>
        <label>Jenis</label>
        <select name="jenis" id="jenis">
            <option value="">Pilih jenis kamar/bed/klinik</option>
            <option value="Semua" <?php if($rows['jenis'] == "Semua") echo "selected";?>>Semua</option>
            <option value="Rawat Jalan" <?php if($rows['jenis'] == "Rawat Jalan") echo "selected";?>>Rawat Jalan</option>
            <option value="Rawat Inap" <?php if($rows['jenis'] == "Rawat Inap") echo "selected";?>>Rawat Inap</option>
            <option value="OK" <?php if($rows['jenis'] == "OK") echo "selected";?>>OK</option>
        </select>
        <fieldset class="input-process">
            <input type="submit" class="tombol" value="Simpan" name="edit" id="submit" />
            <input type="button" class="tombol" value="Batal" onClick="javascript:location.href='<?= app_base_url('admisi/data-bed') ?>'">
        </fieldset>
    </fieldset>
    </form>    
    
       
</div>
