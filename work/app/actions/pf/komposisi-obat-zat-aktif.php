<?
$id=$_GET['id_obat'];
$data['selected'] = _select_arr("select zat.id,zat.nama from komposisi_obat k
            join zat_aktif zat on k.id_zat_aktif=zat.id
            where k.id_obat='$id'");
$data['notselected'] = _select_arr("select zat.id,zat.nama from zat_aktif zat
            where zat.id not in (select k.id_zat_aktif from komposisi_obat k where k.id_obat='$id')");
?>
<select name="zat_aktif[]" multiple="multiple" id="searchable">
    <? foreach ($data['selected'] as $row) { ?>
        <option value="<?= $row['id'] ?>" selected><? echo"$row[id] $row[nama]"; ?></option>
    <?php } ?>
    <? foreach ($data['notselected'] as $row) { ?>
        <option value="<?= $row['id'] ?>"><? echo"$row[id] $row[nama]"; ?></option>
    <?php } ?>
</select>
<script type="text/javascript">
    $('#searchable').multiselect2side({
        search: "Search: "
    });
</script>
<?exit;?>