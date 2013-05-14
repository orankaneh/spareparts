<script language="javascript">
$(document).ready(function()
{
    $("#form_instansi_relasi").submit(function(event)
        {
            event.preventDefault();
            $("#form_instansi_relasi input[type=submit]").click();
        });
    $("#form_instansi_relasi input[type=submit]").click(function(event)
    {
        event.preventDefault();
        if($('#relasi-instansi').attr('value')=='')
        {
            alert('Jenis instansi relasi masih kosong');
            $('#relasi-instansi').focus();
            return false;
        }
        if($('#nama').attr('value')=='')
        {
            alert('Nama instansi relasi masih kosong');
            $('#nama').focus();
            return false;
        }
        if($('#alamat').attr('value')=='')
        {
            alert('alamat instansi relasi masih kosong');
            $('#alamat').focus();
            return false;
        }		
        if($('#kelurahan').attr('value')=='')
        {
            alert('kelurahan instansi relasi masih kosong');
            $('#kelurahan').focus();
            return false;
        }
        if($('#id-kelurahan').attr('value') == '')
        {
            alert('Nama kelurahan harus dipilih dari list');
            $('#kelurahan').focus();
            return false;
        }
        if($('#jenis').attr('value')=='')
        {
            alert('jenis instansi relasi masih kosong');
            $('#jenis').focus();
            return false;
        }
        if($('#email').val() != '')
		{
            var RegExp = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
		    var email    = $('#email').val();
		    if (RegExp.test(email))
            {}
            else {
                alert('E-mail tidak valid. Pastikan berpola example@destination.com');
                $('#email').focus();
                return false;
            }
		}
		if($('#website').val() != '')
		{
            var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
		    var URL    = $('#website').val();
		    if (RegExp.test(URL))
            {}
            else {
                alert('URL tidak valid. Pastikan berpola http://example.com');
                $('#website').focus();
                return false;
            }
		}
        $.ajax(
		{
            url: "<?= app_base_url('inventory/search?opsi=cek_instansiR')?>",
            data:'&nama='+$('#nama').attr('value'),
            cache: false,
            dataType: 'json',
            success: function(msg)
			{
                if(!msg.status)
                {
                    alert('Nama instansi relasi sudah diinputkan ke database');
                    $('#nama').focus();
                    return false;
                }  else
                {
                    $("#form_instansi_relasi input[type=submit]").unbind("click").click();
                }
            }
        });
    })
});
</script>
<div class="data-input">
 <fieldset id="input-data">
            <legend>Form Tambah Data Instansi Relasi</legend>
 <form action="<?= app_base_url('/pf/control/instansi-relasi/add') ?>" id="form_instansi_relasi" method="post">
            <label for="relasi-instansi">Jenis Instansi Relasi *</label>
            <select name="relasiInstansi" id="relasi-instansi">
                <option value="">Pilih instansi..</option>
                <? foreach($jenis_instansi['list'] as $row): ?>
                <option value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
                <? endforeach; ?>
            </select>

            <label for="nama">Nama *</label>
            <input type="text" id="nama" name="nama" onkeyup="AlpaNumerik(this)" />
            <label for="alamat">Alamat *</label>
            <textarea name="alamat" id="alamat" cols="50" rows="5"></textarea>
            <label for="kelurahan">Kelurahan *</label>
            <input type="text" name="kelurahan" id="kelurahan" />
            <input type="hidden" name="id-kelurahan" id="id-kelurahan" />
            <label for="telp">No. Telepon</label><input type="text" id="telpon" name="telpon" onkeyup="Angka(this)" maxlength="15">
	    <label for="fax">No. Fax</label><input type="text" id="fax" name="fax" onkeyup="Angka(this)" />
            <label for="email">Email</label><input type="text" id="email" name="email">
            <label for="web">URL Website</label><input type="text" id="website" name="website">
			
            
            <fieldset class="input-process">
                <input type="submit" value="Simpan" class="tombol">
                <input type="button" value="Batal" class="tombol" onclick="javascript:location.href='<?=  app_base_url('/pf/inventory/instansi-relasi')?>'">
            </fieldset>
    </form>
 </fieldset>
</div>
