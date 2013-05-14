
<form action="<?= app_base_url('admisi/control/spesialisasi/add') ?>" method="post" onSubmit="return form_valid(this)">
	<div class="data-input">
		 <fieldset><legend>Form Master Data Dokter</legend>
            <fieldset style="border: none">
                <table width="100%">
					<tr>
                        <td valign="top">
                            <label for="Identitas">No Identitas*</label><input name="no_identitas" type="text" id="no_identitas" >
                            <label for="Identitas">Nama Lengkap*</label><input name="nama_dokter" type="text" id="nama_dokter" >
							<input type="hidden" name="id_penduduk" id="id_penduduk">
							<div >
								<fieldset class="field-group">
									<label for="alamatJln">Alamat / RT / RW*</label>
									<input type="text" name="alamatJln" id="alamatJln" <?php echo  $input ?> size='50'>
									<!--<span><input type="text" name="rt" size='2' id="rt" <?php echo $input ?>></span>
									<span><input type="text" name="rw" size='2' id="rw" <?php echo $input ?>></span>-->
								</fieldset>
								<label for="kelurahan">Desa / Kelurahan*</label>
								<input type="text" name="kelurahan" id="kelurahan" <?php echo $input ?>>
								<input type="hidden" name="idKel" id="idKel" <?php echo $input ?>>
								<fieldset class="field-group">
                                <label>Jenis Kelamin </label>&nbsp;
                                <label for="laki-laki" class="field-option"><input type="radio" name="kelamin" id="laki-laki" value="L" <?php echo $input ?>> Laki-laki</label>
                                <label for="perempuan" class="field-option"><input type="radio" name="kelamin" id="perempuan" value="P" <?php echo $input ?>> Perempuan</label>
								</fieldset>
								<label for="idAgama">Agama</label>
                                <select name="agama" id="agama" <?= $input ?>>
                                    <option value="">Pilih agama</option>
                                <?php foreach ($agama['list'] as $row): ?>
                                                    <option value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
                                <?php endforeach; ?>
                                </select>
								<label for="no_sip">Nomor SIP</label><input type="text" name="no_sip" id="no_sip">
								<label for="Identitas">Spesialisasi*</label><input name="spesialisasi" type="text" id="spesialisasi" >
								<input name="id_spesialisasi" type="hidden" id="id_spesialisasi" value=''>
							</div>
						</td>
					</tr>
				</table>
			</fieldset >
		</fieldset >
	</div>
	 <fieldset class="input-process">
                            <input type="submit" value="Simpan" class="tombol" name="save"  />
			    <input type="button" value="Batal" class="tombol" name="cancel" onclick="javascript:location.href='<?=  app_base_url('/admisi/spesialisasi_dokter')?>'"/>
                        </fieldset>
</form>