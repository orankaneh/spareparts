<?
include_once "app/lib/common/master-data.php";
$kelas = kelas_muat_data();
$barang = array_value($_GET, 'barang');
$idBarang = array_value($_GET, 'idBarang');
$idKelas = array_value($_GET, 'kelas');
$idKategori=array_value($_GET, 'idKategori');
if(isset($_GET['idKategori'])  && $_GET['idKategori']!='')
    $kategori = kategori_barang_muat_data(array_value($_GET, 'idKategori'));
$namaKelas = kelas_muat_data($idKelas);
$namaKelas = array_value($namaKelas, 'nama');
$dataBarang = barang_adm_muat_data($idBarang, $idKategori,$idKelas);
$namaFile = "distribusi-report.xls";
// header file excel
header_excel($namaFile);
?>
<table border="0">
    <tr bgcolor="#cccccc">
        <td colspan="9" align="center"><strong><font size="+1">RS. PKU MUHAMMADYAH TEMANGGUNG</font></strong></td>
    </tr>
    <tr bgcolor="#cccccc">
        <td colspan="9" align="center"><strong><font size="+1">Daftar Harga Jual Barang <?=($_GET['idKategori']!='')?"$kategori[nama] $kategori[kategori]":""?></font></strong></td>
    </tr>
    <tr>
        <td colspan="9">&nbsp;</td>
    </tr>
</table>
            <table>
                <tr>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Kelas</th>
                    <th>Harga Jual</th>
                </tr>
            <?php foreach ($dataBarang as $key => $row): ?>
                        <tr>
                            <td><?= $row['id_packing'] ?></td>
                            <td><?= "$row[barang] $row[nilai_konversi] $row[satuan_terkecil]" ?></td>
                            <td><?= $row['nama_kelas'] ?></td>
                            <td id="harga<?=$key?>"><?=$row['hna']*$row['margin']/100+$row['hna']?></td>
                        </tr>
                        <script type="text/javascript">
                            hitungHarga(<?=$key?>);
                        </script>
            <?php endforeach; ?>
        </table>
<?exit;?>