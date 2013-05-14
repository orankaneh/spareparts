<script type="text/javascript">
    function checkvalues(data) {
        if ($('#passwordLama').attr('value')=='') {
            alert('Password lama tidak boleh kosong');
            $('#passwordLama').focus();
            return false;
        }
        if ($('#passwordBaru').attr('value')=='') {
            alert('Password baru tidak boleh kosong');
            $('#passwordBaru').focus();
            return false;
        }
        if ($('#passwordBaru').attr('value')!= $('#konfirmasiPassword').attr('value')) {
            alert('Konfirmasi password salah');
            $('#konfirmasiPassword').focus();
            return false;
        }
        return true;
    }
</script>
<?
require_once 'app/lib/administrasi/usersystem.php';
include  'app/actions/admisi/pesan.php';
$user = usersystem_muat_data(User::$id_user);
?>
<h2 class="judul">Form Ubah Password</h2>
<span class="data-input">
    <fieldset>
        <?=isset($pesan)?$pesan:NULL;
		foreach($user as $data) {?>
        
        <form action="<?= app_base_url('administrasi/control/adm-user') ?>" method="post" onSubmit="return checkvalues(this)">
            <input type="hidden" name="id"  value="<?=$data['user_id']?>"/>
            <label for="username">Username</label><span style="font-size: 12px; padding-top: 5px; "><?=$data['username']?></span>
            <label for="username">Password Lama</label><input type="password" name="passwordLama" id="passwordLama" />
            <label for="username">Password Baru</label><input type="password" name="passwordBaru" id="passwordBaru" />
            <label for="username">Konfirmasi Password</label><input type="password" name="konfirmasiPassword" id="konfirmasiPassword" />
            <label for="username">Hak Akses Barang</label><span style="font-size: 12px; padding-top: 5px; "><?=$data['nama_kategori']?></span>
            <label for="username">Unit</label><span style="font-size: 12px; padding-top: 5px; "><?=$data['nama_unit']?></span>
            <fieldset class="input-process">
                <input type="submit" value=" Submit " name="adduser" class="tombol"/>
                <input type="button" value="Batal" class="tombol" onClick=javascript:location.href="<?= app_base_url(' ')?>" />
            </fieldset>
        </form>
    </fieldset>
</span>
<?
}
?>