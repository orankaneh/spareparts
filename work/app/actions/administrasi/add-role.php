<?
  $kategori = kategori_barang_muat_data2();
?>
<span class="data-input">
            <fieldset><legend>Form Tambah Role</legend>
            <form action="<?= app_base_url('administrasi/control/usersystem') ?>?tab=role" method="post">
            <label for="namarole">Nama</label><input type="text" name="namarole" id="namarole" />
            <label for="kategori">Kategori Barang</label>
            <select name="kategori">
                <option value="">Pilih Kategori Barang</option>
                <?
                foreach ($kategori as $value) {
                ?>
                <option value="<?= $value['id']?>"><?= $value['nama']?></option>
                <?
                }
                ?>
            </select>
            <fieldset class="input-process">
                <input type="submit" value="Simpan" name="addrole" class="tombol buttonRole"/>
                <input type="button" class="tombol" value="Batal" onClick="javascript:location.href='<?= app_base_url('administrasi/usersystem')?>'">
            </fieldset>
            </form>
            </fieldset>
</span>