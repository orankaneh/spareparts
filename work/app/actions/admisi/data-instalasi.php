<?
require_once 'app/lib/common/master-data.php';
include 'app/actions/admisi/pesan.php';
$code = isset($_GET['code']) ? $_GET['code'] : NULL;
$key = isset($_GET['key']) ? $_GET['key'] : NULL;
$sort = isset($_GET['sort']) ? $_GET['sort'] : NULL;
$sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : NULL;
$instalasi = instalasi_muat_data($code, $sort, $sortBy, $key);
?>
<script type="text/javascript">
    function cekform() {
        if($('#instalasi').attr('value')==''){
            alert('Nama instalasi masih kosong');
            $('#instalasi').focus();
            return false;
        }
    }
    $(document).ready(function(){
        $('#instalasi').focus();
        $("#save]").click(function(event){
            event.preventDefault();
            $.ajax({
                url: "<?= app_base_url('inventory/search?opsi=cek_instalasi') ?>",
                data:'&nama='+$('#instalasi').attr('value')+'&id='+$('input[name=idInstalasi]').attr('value'),
                cache: false,
                dataType: 'json',
                success: function(msg){
                    if(!msg.status){
                        alert('Nama Instalasi sudah diinputkan ke database');
                        return false;
                    }
                    $("#save").unbind('submit').submit(); 
                }
            });
        });
    });
</script>
<div class="judul"><a href="<?= app_base_url('admisi/data-instalasi') ?>">Master Data Instalasi/Ruang</a></div><? echo isset($pesan) ? $pesan : NULL; ?>
<?
if (isset($_GET['id'])) {
    require_once 'app/actions/admisi/edit-instalasi.php';
} else if (isset($_GET['do'])) {
    require_once 'app/actions/admisi/add-instalasi.php';
}
?>
<div class="data-list w700px">
    <div class="floleft"><?php echo addButton('/admisi/data-instalasi/?do=add','Tambah'); ?></div>
	<div class="floright">
		<form action="" method="GET" class="search-form" style="margin: -5px 0 0 0">
			<span style="float:right;"><input type="text" name="key" class="search-input" id="keyword" value="<?= $key ?>"/><input type="submit" class="search-button" value=""/></span>
		</form>
	</div>
	
    <table id="table" class="tabel full">
        <tr>
            <th><!--<a href='<?//= app_base_url('admisi/data-instalasi?') . generate_sort_parameter(1, $sortBy) ?>" class="sorting"></a>-->NO</th>
            <th><a href="<?= app_base_url('admisi/data-instalasi?') . generate_sort_parameter(2, $sortBy) ?>" class="sorting">Nama Instalasi/Ruang</a></th>
            <th>Aksi</th>
        </tr>

<?php foreach ($instalasi as $num => $row): ?>
        <tr class="<?= ($num % 2) ? 'even' : 'odd' ?>">
            <td width="12%" align="center"><?= ++$num ?></td>
            <td width="78%"><?= $row['nama'] ?></td>
            <td width="10%" align=center class="aksi">
<?
        if ($row['id'] >= 1 && $row['id'] <= 4) {
            echo "-";
        } else {
?>
                <a href="<?= app_base_url('/admisi/data-instalasi/?do=edit&id=' . $row['id'] . '')."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" title="Edit" class="edit"><small>edit</small></a>
                <a href="<?= app_base_url('/admisi/control/instalasi/delete/?id=' . $row['id'])."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')) ?>" title="Delete" class="delete"><small>delete</small></a>
<?
            }
?>
            </td>
        </tr>
<?php endforeach; ?>
    </table>
</div>
<?
            $count = count($instalasi);
            echo "<p>Jumlah Total Nama Instalasi: " . $count . "</p>";
?>