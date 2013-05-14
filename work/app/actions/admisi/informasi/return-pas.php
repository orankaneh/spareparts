<?
echo "<link rel='stylesheet' href='public/scripts/sorter/style.css' />";
echo "<div class='dasar'>";
if (!empty($_GET['idTmpLahir'])) { ?>
	<h2 align="center">DAFTAR PASIEN BERDASARKAN TEMPAT LAHIR<br>
            PERIODE: <?php echo indoTgl($_GET['awal']) ?> s.d <?php echo indoTgl($_GET['akhir']) ?></h2>
    <? 
	if ($_GET['idTmpLahir'] != 'all') { $aksi = "where id = '$_GET[idTmpLahir]'"; $axsi = "and dp.id_kelurahan = '$_GET[idTmpLahir]'"; }
	echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='sortable'>
		<thead>
			<tr>
				<th><h3>No</th>
				<th><h3>Tempat Lahir</th>
				<th><h3>Jumlah</th>
			</tr>
		</thead>";
		$sql = mysql_query("select * from kelurahan $aksi");
		$no = 1;
		while ($row = mysql_fetch_array($sql)) {
			$jml = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, dinamis_penduduk dp, kunjungan k where pd.id = dp.id_penduduk and pd.id = p.id_penduduk and p.id = k.id_pasien and dp.id_kelurahan = '$row[id]' and k.waktu between '$awal' and '$akhir'"));
			
			echo "<tr bgcolor='"; if ($no % 2 == 0) echo "#F4F4F4"; else echo "#FFFFFF"; echo "'>
			<td align=center>$no</td>
			<td>".ucwords(strtolower($row[nama]))."</td>
			<td align=center>$jml</td>
			</tr>
			";	
		$no += 1;
		}
		$total = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, dinamis_penduduk dp, kunjungan k where pd.id = dp.id_penduduk and pd.id = p.id_penduduk and p.id = k.id_pasien and k.waktu between '$awal' and '$akhir' $axsi"));
		echo "
		<tr><td></td><td>Total</td><td align=center>$total</td></tr>
		</table>
		";
		echo "<br><center><input type=button name=cetak value=' Cetak ' class=tombol onclick=\"window.open('./print/RP/?awal=$_GET[awal]&akhir=$_GET[akhir]&idLap=$_GET[idLap]&idTmpLahir=$_GET[idTmpLahir]','popup','width=860,height=650,scrollbars=yes, resizable=no');\"></center>";
		
} 
else if (!empty($_GET['jeKel'])) {
	echo "<h2 align=center>LAPORAN $period UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN JENIS KELAMIN<br>
	PERIODE ".indoTgl($_GET[awal])." s . d ".indoTgl($_GET[akhir])."</h2 align=center>";
	echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='sortable'>
		<thead>
			<tr>
				<th><h3>No</th>
				<th><h3>Jenis</th>
				<th><h3>Jumlah</th>
			</tr>
		</thead><tbody>";
	if ($_GET['jeKel'] == 'LP') {
	$jmlL = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, kunjungan k where pd.id=p.id_penduduk and p.id=k.id_pasien and pd.jenis_kelamin = 'L' and k.waktu between '$awal' and '$akhir'"));
	$jmlP = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, kunjungan k where pd.id=p.id_penduduk and p.id=k.id_pasien and pd.jenis_kelamin = 'P' and k.waktu between '$awal' and '$akhir'"));
	echo "
			<tr>
				<td align=center> 1</td>
				<td>Laki-laki</td>
				<td align=center>$jmlL</td>
			</tr>
			<tr bgcolor='#F4F4F4'>
				<td align=center> 2</td>
				<td>Perempuan</td>
				<td align=center>$jmlP</td>
			</tr>				
	";
		
	}
	if ($_GET['jeKel'] == 'L') {
	$jmlL = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, kunjungan k where pd.id=p.id_penduduk and p.id=k.id_pasien and pd.jenis_kelamin = 'L' and k.waktu between '$awal' and '$akhir'"));
	echo "
			<tr>
				<td align=center> 1</td>
				<td>Laki-laki</td>
				<td align=center>$jmlL</td>
			</tr>
	";
	}
	
	if ($_GET['jeKel'] == 'P') {
	$jmlP = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, kunjungan k where pd.id=p.id_penduduk and p.id=k.id_pasien and pd.jenis_kelamin = 'P' and k.waktu between '$awal' and '$akhir'"));
	echo "
			<tr>
				<td align=center> 1</td>
				<td>Perempuan</td>
				<td align=center>$jmlP</td>
			</tr>
	";
	}
	if ($_GET['jeKel'] != 'LP') $aksi = "and jenis_kelamin = '$_GET[jeKel]'";
	$total = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, kunjungan k where pd.id=p.id_penduduk and p.id=k.id_pasien and k.waktu between '$awal' and '$akhir' $aksi"));
	echo "</tbody>
	<tbody>
	<tr><td></td><td>Total</td><td align=center>$total</td></tr></tbody>
	</table>	
	
	";
	echo "<br><center><input type=button name=cetak value=' Cetak ' class=tombol onclick=\"window.open('./print/RP/?awal=$_GET[awal]&akhir=$_GET[akhir]&idLap=$_GET[idLap]&jeKel=$_GET[jeKel]','popup','width=860,height=650,scrollbars=yes, resizable=no');\"></center>";
	
}
else if (!empty($_GET['idPkw'])) {
	echo "<h2 align=center align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN STATUS PERKAWINAN<br>
	PERIODE ".indoTgl($_GET[awal])." s . d ".indoTgl($_GET[akhir])."";
	if ($_GET['idPkw'] != 'ss') { $aksi = "where id_perkawinan = '$_GET[idPkw]'"; $axsi = "and dp.status_pernikahan = '$_GET[idPkw]'"; }
	echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='sortable'>
		<thead>
			<tr>
				<th><h3>No</th>
				<th><h3>Jenis</th>
				<th><h3>Jumlah</th>
			</tr>
		</thead>
		<tbody>";
		$sql = mysql_query("select * from perkawinan $aksi");
		$no = 1;
		while ($row = mysql_fetch_array($sql)) {
			$jml = mysql_num_rows(mysql_query("select * from penduduk pd, perkawinan p, dinamis_penduduk dp, pasien ps, kunjungan k where ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id_perkawinan = dp.status_pernikahan and pd.id = dp.id_penduduk and dp.status_pernikahan = '$row[id_perkawinan]' and k.waktu between '$awal' and '$akhir'"));
			echo "<tr bgcolor='"; if ($no % 2 == 0) echo "#F4F4F4"; else echo "#FFFFFF"; echo "'>
			<td align=center>$no</td>
			<td>$row[perkawinan]</td>
			<td align=center>$jml</td>
			</tr>
			";	
		$no += 1;
		}
		$total = mysql_num_rows(mysql_query("select * from penduduk pd, perkawinan p, dinamis_penduduk dp, pasien ps, kunjungan k where ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id_perkawinan = dp.status_pernikahan and pd.id = dp.id_penduduk and k.waktu between '$awal' and '$akhir' $axsi"));
		echo "</tbody>
		<tr><td></td><td>Total</td><td align=center>$total</td></tr>
		</table>";
		echo "<br><center><input type=button name=cetak value=' Cetak ' class=tombol onclick=\"window.open('./print/RP/?awal=$_GET[awal]&akhir=$_GET[akhir]&idLap=$_GET[idLap]&idPkw=$_GET[idPkw]','popup','width=860,height=650,scrollbars=yes, resizable=no');\"></center>";
		
}
else if (!empty($_GET['tipePas'])) {
	echo "<h2 align=center align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN TIPE PASIEN<br>
	PERIODE ".indoTgl($_GET[awal])." s . d ".indoTgl($_GET[akhir])."";
	//if ($_GET['idPkw'] != 'ss') { $aksi = "where id_perkawinan = '$_GET[idPkw]'"; $axsi = "and dp.status_pernikahan = '$_GET[idPkw]'"; }
	echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='sortable'>
		<thead>
			<tr>
				<th><h3>No</th>
				<th><h3>Tipe Pasien</th>
				<th><h3>Jumlah</th>
			</tr></thead><tbody>";
		if (!empty($_GET['tipePas'])) {	
			if ($_GET['tipePas'] == 2) $having = "having count(k.id_pasien) = 1";
			if ($_GET['tipePas'] == 1) $having = "having count(k.id_pasien) > 1";
		}
		
		$no = 1;
		
		if ($_GET['tipePas'] == 2) {
			$sql = mysql_query("select k.id_pasien, p.nama, count(k.id_pasien) as jml_kunjungan from kunjungan k,pasien ps ,penduduk p where k.id_pasien=ps.id and
							ps.id_penduduk=p.id and	k.waktu between '$awal' and '$akhir' group by k.id_pasien having count(k.id_pasien) = 1
							");
			
			while ($row = mysql_fetch_array($sql)) {
				$jml[] = $row[jml_kunjungan];	
			}
			$jml = count($jml);
			echo "<tr>
			<td align=center>1</td>
			<td>Pasien Baru</td>
			<td align=center>$jml</td>
			</tr>";
		}
		else if ($_GET['tipePas'] == 1) {
			$sql = mysql_query("select k.id_pasien, p.nama, count(k.id_pasien) as jml_kunjungan from kunjungan k,pasien ps ,penduduk p where k.id_pasien=ps.id and
							ps.id_penduduk=p.id and	k.waktu between '$awal' and '$akhir' group by k.id_pasien having count(k.id_pasien) > 1
							");
			while ($row = mysql_fetch_array($sql)) {
				$jml[] = $row[jml_kunjungan];	
			}
			$jml = count($jml);
			echo "<tr>
			<td align=center>1</td>
			<td>Pasien Lama</td>
			<td align=center>$jml</td>
			</tr>";
		}
		else {
			$sql = mysql_query("select k.id_pasien, p.nama, count(k.id_pasien) as jml_kunjungan from kunjungan k,pasien ps ,penduduk p where k.id_pasien=ps.id and
							ps.id_penduduk=p.id and	k.waktu between '$awal' and '$akhir' group by k.id_pasien having 
							count(k.id_pasien) = 1
							");
			while ($row = mysql_fetch_array($sql)) {
				$jml[] = $row[jml_kunjungan];	
			}
			$jml = count($jml);
			echo "<tr>
			<td align=center>1</td>
			<td>Pasien Baru</td>
			<td align=center>$jml</td>
			</tr>";
			
			$sql = mysql_query("select k.id_pasien, p.nama, count(k.id_pasien) as jml_kunjungan from kunjungan k,pasien ps ,penduduk p where k.id_pasien=ps.id and
							ps.id_penduduk=p.id and	k.waktu between '$awal' and '$akhir' group by k.id_pasien having 
							count(k.id_pasien) > 1
							");
			while ($row = mysql_fetch_array($sql)) {
				$jmlh[] = $row[jml_kunjungan];	
			}
			$jml = count($jmlh);
			echo "<tr bgcolor='#F4F4F4'>
			<td align=center>2</td>
			<td>Pasien Lama</td>
			<td align=center>$jml</td>
			</tr>";
		}
		
		$no += 1;
		
		$total = mysql_num_rows(
							mysql_query("select k.id_pasien, p.nama, count(k.id_pasien) as jml_kunjungan 
							from 
							kunjungan k,pasien ps ,penduduk p
							where 
							k.id_pasien=ps.id and
							ps.id_penduduk=p.id and
							k.waktu between '$awal' and '$akhir' 
							group by k.id_pasien $having"));
		echo "</tbody>
		<tr><td></td><td>Total</td><td align=center>$total</td></tr>
		</table>";
		echo "<br><center><input type=button name=cetak value=' Cetak ' class=tombol onclick=\"window.open('./print/RP/?awal=$_GET[awal]&akhir=$_GET[akhir]&idLap=$_GET[idLap]&tipePas=$_GET[tipePas]','popup','width=860,height=650,scrollbars=yes, resizable=no');\"></center>";
		
}

else if (!empty($_GET['idPdd'])) {
	echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN PENDIDIKAN<br>
	PERIODE ".indoTgl($_GET[awal])." s . d ".indoTgl($_GET[akhir])."";
	if ($_GET['idPdd'] != 'sp') { $aksi = "where id = '$_GET[idPdd]'"; $axsi = "and dp.id_pendidikan_terakhir = '$_GET[idPdd]'"; }
	echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='sortable'>
		<thead>
			<tr>
				<th><h3>No</th>
				<th><h3>Jenis</th>
				<th><h3>Jumlah</th>
			</tr></thead><tbody>";
		$sql = mysql_query("select * from pendidikan $aksi");
		$no = 1;
		while ($row = mysql_fetch_array($sql)) {
			$jml = mysql_num_rows(mysql_query("select * from penduduk pd, pendidikan p, dinamis_penduduk dp, pasien ps, kunjungan k  where ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_pendidikan_terakhir and pd.id = dp.id_penduduk and dp.id_pendidikan_terakhir = '$row[id]' and k.waktu between '$awal' and '$akhir'"));
			echo "<tr bgcolor='"; if ($no % 2 == 0) echo "#F4F4F4"; else echo "#FFFFFF"; echo "'>
			<td align=center>$no</td>
			<td>$row[nama]</td>
			<td align=center>$jml</td>
			</tr>
			";	
		$no += 1;
		}
		$total = mysql_num_rows(mysql_query("select * from penduduk pd, pendidikan p, dinamis_penduduk dp, pasien ps, kunjungan k  where ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_pendidikan_terakhir and pd.id = dp.id_penduduk and k.waktu between '$awal' and '$akhir' $axsi"));
		echo "</tbody>
		<tr><td></td><td>Total</td><td align=center>$total</td></tr>
		</table>";
		echo "<br><center><input type=button name=cetak value=' Cetak ' class=tombol onclick=\"window.open('./print/RP/?awal=$_GET[awal]&akhir=$_GET[akhir]&idLap=$_GET[idLap]&idPdd=$_GET[idPdd]','popup','width=860,height=650,scrollbars=yes, resizable=no');\"></center>";
		
}
else if (!empty($_GET['idPkj'])) {
	echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN PEKERJAAN<br>
	PERIODE ".indoTgl($_GET[awal])." s . d ".indoTgl($_GET[akhir])."";
	if ($_GET['idPkj'] != 'spk') { $aksi = "where id = '$_GET[idPkj]'"; $axsi = "and dp.id_profesi = '$_GET[idPkj]'"; }
	echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='sortable'>
		<thead>
			<tr>
				<th><h3>No</th>
				<th><h3>Jenis</th>
				<th><h3>Jumlah</th>
			</tr></thead><tbody>";
		$sql = mysql_query("select * from profesi $aksi");
		$no = 1;
		while ($row = mysql_fetch_array($sql)) {
			$jml = mysql_num_rows(mysql_query("select * from penduduk pd, profesi p, dinamis_penduduk dp, pasien ps, kunjungan k where ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_profesi and pd.id = dp.id_penduduk and dp.id_profesi = '$row[id]' and k.waktu between '$awal' and '$akhir'"));
			echo "<tr bgcolor='"; if ($no % 2 == 0) echo "#F4F4F4"; else echo "#FFFFFF"; echo "'>
			<td align=center>$no</td>
			<td>$row[nama]</td>
			<td align=center>$jml</td>
			</tr>
			";	
		$no += 1;
		}
		$total = mysql_num_rows(mysql_query("select * from penduduk pd, profesi p, dinamis_penduduk dp, pasien ps, kunjungan k where ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_profesi and pd.id = dp.id_penduduk and k.waktu between '$awal' and '$akhir' $axsi"));
		echo "</tbody>
		<tr><td></td><td>Total</td><td align=center>$total</td></tr>
		</table>";
		echo "<br><center><input type=button name=cetak value=' Cetak ' class=tombol onclick=\"window.open('./print/RP/?awal=$_GET[awal]&akhir=$_GET[akhir]&idLap=$_GET[idLap]&idPkj=$_GET[idPkj]','popup','width=860,height=650,scrollbars=yes, resizable=no');\"></center>";
		
}
else if (!empty($_GET['idAgm'])) {
echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN AGAMA<br>
	PERIODE ".indoTgl($_GET[awal])." s . d ".indoTgl($_GET[akhir])."";
	if ($_GET['idAgm'] != 'sa') { $aksi = "where id = '$_GET[idAgm]'"; $axsi = "and dp.id_agama = '$_GET[idAgm]'"; }
	echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='sortable'>
		<thead>
			<tr>
				<th><h3>No</th>
				<th><h3>Jenis</th>
				<th><h3>Jumlah</th>
			</tr></thead><tbody>";
		$sql = mysql_query("select * from agama $aksi");
		$no = 1;
		while ($row = mysql_fetch_array($sql)) {
			$jml = mysql_num_rows(mysql_query("select * from penduduk pd, agama p, dinamis_penduduk dp, pasien ps, kunjungan k where ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_agama and pd.id = dp.id_penduduk and dp.id_agama = '$row[id]' and k.waktu between '$awal' and '$akhir'"));
			echo "<tr bgcolor='"; if ($no % 2 == 0) echo "#F4F4F4"; else echo "#FFFFFF"; echo "'>
			<td align=center>$no</td>
			<td>$row[nama]</td>
			<td align=center>$jml</td>
			</tr>
			";	
		$no += 1;
		}
		$total = mysql_num_rows(mysql_query("select * from penduduk pd, agama p, dinamis_penduduk dp, pasien ps, kunjungan k where ps.id = k.id_pasien and pd.id = ps.id_penduduk and p.id = dp.id_agama and pd.id = dp.id_penduduk and k.waktu between '$awal' and '$akhir' $axsi"));
		echo "</tbody>
		<tr><td></td><td>Total</td><td align=center>$total</td></tr>
		</table>";
		
		echo "<br><center><input type=button name=cetak value=' Cetak ' class=tombol onclick=\"window.open('./print/RP/?awal=$_GET[awal]&akhir=$_GET[akhir]&idLap=$_GET[idLap]&idAgm=$_GET[idAgm]','popup','width=860,height=650,scrollbars=yes, resizable=no');\"></center>";
		
}

else if (!empty($_GET['idKel'])) {
	echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN ALAMAT KELURAHAN<br>
	PERIODE ".indoTgl($_GET[awal])." s . d ".indoTgl($_GET[akhir])."</h2>";
	if ($_GET['idKel'] != 'all') { $aksi = "where id = '$_GET[idKel]'"; $axsi = "and dp.id_kelurahan = '$_GET[idKel]'"; }
	echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='sortable'>
		<thead>
			<tr>
				<th><h3>No</th>
				<th><h3>Alamat Kelurahan</th>
				<th><h3>Jumlah</th>
			</tr></thead></tbody>";
		$sql = mysql_query("select * from kelurahan $aksi");
		$no = 1;
		while ($row = mysql_fetch_array($sql)) {
			$jml = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, dinamis_penduduk dp, kunjungan k where pd.id = dp.id_penduduk and pd.id = p.id_penduduk and p.id = k.id_pasien and dp.id_kelurahan = '$row[id]' and k.waktu between '$awal' and '$akhir'"));
			echo "<tr bgcolor='"; if ($no % 2 == 0) echo "#F4F4F4"; else echo "#FFFFFF"; echo "'>
			<td align=center>$no</td>
			<td>".ucwords(strtolower($row[nama]))."</td>
			<td align=center>$jml</td>
			</tr>
			";	
		$no += 1;
		}
		$total = mysql_num_rows(mysql_query("select * from penduduk pd, pasien p, dinamis_penduduk dp, kunjungan k where pd.id = dp.id_penduduk and pd.id = p.id_penduduk and p.id = k.id_pasien and k.waktu between '$awal' and '$akhir' $axsi"));
		echo "</tbody>
		<tr><td></td><td>Total</td><td align=center>$total</td></tr>
		</table>
		";
		echo "<br><center><input type=button name=cetak value=' Cetak ' class=tombol onclick=\"window.open('./print/RP/?awal=$_GET[awal]&akhir=$_GET[akhir]&idLap=$_GET[idLap]&idKel=$_GET[idKel]','popup','width=860,height=650,scrollbars=yes, resizable=no');\"></center>";
		
}
else if (!empty($_GET['idKec'])) {
echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN ALAMAT KECAMATAN<br>
	PERIODE ".indoTgl($_GET[awal])." s . d ".indoTgl($_GET[akhir])."";
	if ($_GET['idKec'] != 'all') { $aksi = "where id = '$_GET[idKec]'"; $axsi = "and dp.id_kelurahan in (select id from kelurahan where id_kecamatan = '$_GET[idKec]')"; }
	echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='sortable'>
		<thead>
			<tr>
				<th><h3>No</th>
				<th><h3>Kecamatan</th>
				<th><h3>Jumlah</th>
			</tr></thead><tbody>";
		$sql = mysql_query("select * from kecamatan $aksi");
		$no = 1;
		while ($row = mysql_fetch_array($sql)) {
			$jml = mysql_num_rows(mysql_query("select * from penduduk p, dinamis_penduduk dp, pasien ps, kunjungan k where k.id_pasien = ps.id and ps.id_penduduk = p.id and p.id = dp.id_penduduk and dp.id_kelurahan in (select id from kelurahan where id_kecamatan = '$row[id]') and k.waktu between '$awal' and '$akhir'"));
			echo "<tr bgcolor='"; if ($no % 2 == 0) echo "#F4F4F4"; else echo "#FFFFFF"; echo "'>
			<td align=center>$no</td>
			<td>$row[nama]</td>
			<td align=center>$jml</td>
			</tr>
			";	
		$no += 1;
		}
		$total = mysql_num_rows(mysql_query("select * from penduduk p, dinamis_penduduk dp, pasien ps, kunjungan k where k.id_pasien = ps.id and ps.id_penduduk = p.id and p.id = dp.id_penduduk and k.waktu between '$awal' and '$akhir' $axsi"));
		echo "</tbody>
		<tr><td></td><td>Total</td><td align=center>$total</td></tr>
		</table>";
		echo "<br><center><input type=button name=cetak value=' Cetak ' class=tombol onclick=\"window.open('./print/RP/?awal=$_GET[awal]&akhir=$_GET[akhir]&idLap=$_GET[idLap]&idKec=$_GET[idKec]','popup','width=860,height=650,scrollbars=yes, resizable=no');\"></center>";
		
}

else if (!empty($_GET['idKab'])) {
	echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN ALAMAT KABUPATEN<br>
	PERIODE ".indoTgl($_GET[awal])." s . d ".indoTgl($_GET[akhir])."";
	if ($_GET['idKab'] != 'all') { $aksi = "where id = '$_GET[idKab]'"; $axsi = " and dp.id_kelurahan in (select id from kelurahan where id_kecamatan in (select id from kecamatan where id_kabupaten = '$_GET[idKab]'))"; }
	echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='sortable'>
		<thead>
			<tr>
				<th><h3>No</th>
				<th><h3>Kabupaten</th>
				<th><h3>Jumlah</th>
			</tr></thead><tbody>";
		$sql = mysql_query("select * from kabupaten $aksi");
		$no = 1;
		while ($row = mysql_fetch_array($sql)) {
			$jml = mysql_num_rows(mysql_query("select * from penduduk p, dinamis_penduduk dp, pasien ps, kunjungan k where k.id_pasien = ps.id and ps.id_penduduk = p.id and p.id = dp.id_penduduk and dp.id_kelurahan in (select id from kelurahan where id_kecamatan in (select id from kecamatan where id_kabupaten = '$row[id]')) and k.waktu between '$awal' and '$akhir'"));
			echo "<tr bgcolor='"; if ($no % 2 == 0) echo "#F4F4F4"; else echo "#FFFFFF"; echo "'>
			<td align=center>$no</td>
			<td>$row[nama]</td>
			<td align=center>$jml</td>
			</tr>
			";	
		$no += 1;
		}
		$total = mysql_num_rows(mysql_query("select * from penduduk p, dinamis_penduduk dp, pasien ps, kunjungan k where k.id_pasien = ps.id and ps.id_penduduk = p.id and p.id = dp.id_penduduk and k.waktu between '$awal' and '$akhir' $axsi"));
		echo "</tbody>
		<tr><td></td><td>Total</td><td align=center>$total</td></tr>
		</table>";
		echo "<br><center><input type=button name=cetak value=' Cetak ' class=tombol onclick=\"window.open('./print/RP/?awal=$_GET[awal]&akhir=$_GET[akhir]&idLap=$_GET[idLap]&idKab=$_GET[idKab]','popup','width=860,height=650,scrollbars=yes, resizable=no');\"></center>";
		
}

else if (!empty($_GET['idProp'])) {
	echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN PROVINSI<br>
	PERIODE ".indoTgl($_GET[awal])." s . d ".indoTgl($_GET[akhir])."";
	if ($_GET['idProp'] != 'all') { $aksi = "where id = '$_GET[idProp]'"; $axsi = "and dp.id_kelurahan in (select id from kelurahan where id_kecamatan in (select id from kecamatan where id_kabupaten in (select id from kabupaten where id_provinsi = '$_GET[idProp]')))"; }
	echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='sortable'>
		<thead>
			<tr>
				<th><h3>No</th>
				<th><h3>Provinsi</th>
				<th><h3>Jumlah</th>
			</tr></thead></tbody>";
		$sql = mysql_query("select * from provinsi $aksi");
	
		$no = 1;
		while ($row = mysql_fetch_array($sql)) {
			$jml = mysql_num_rows(mysql_query("select * from penduduk p, dinamis_penduduk dp, kunjungan k, pasien ps where k.id_pasien = ps.id and ps.id_penduduk = p.id and p.id = dp.id_penduduk and dp.id_kelurahan in (select id from kelurahan where id_kecamatan in (select id from kecamatan where id_kabupaten in (select id from kabupaten where id_provinsi = '$row[id]'))) and k.waktu between '$awal' and '$akhir'"));
			echo "<tr bgcolor='"; if ($no % 2 == 0) echo "#F4F4F4"; else echo "#FFFFFF"; echo "'>
			<td align=center>$no</td>
			<td>$row[nama]</td>
			<td align=center>$jml</td>
			</tr>
			";	
		$no += 1;
		}
		$total = mysql_num_rows(mysql_query("select * from penduduk p, dinamis_penduduk dp, kunjungan k, pasien ps where k.id_pasien = ps.id and ps.id_penduduk = p.id and p.id = dp.id_penduduk and k.waktu between '$awal' and '$akhir' $axsi"));
		echo "</tbody>
		<tr><td></td><td>Total</td><td align=center>$total</td></tr>
		</table>";
		echo "<br><center><input type=button name=cetak value=' Cetak ' class=tombol onclick=\"window.open('./print/RP/?awal=$_GET[awal]&akhir=$_GET[akhir]&idLap=$_GET[idLap]&idProp=$_GET[idProp]','popup','width=860,height=650,scrollbars=yes, resizable=no');\"></center>";
		
}

else if (!empty($_GET['idKun'])) {
	echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN TUJUAN KUNJUNGAN<br>
	PERIODE ".indoTgl($_GET[awal])." s . d ".indoTgl($_GET[akhir])."";
	if ($_GET['idKun'] != 'st') { $aksi = "where id = '$_GET[idKun]'"; $axsi = "and id_instalasi_tujuan = '$_GET[idKun]'"; }
	echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='sortable'>
		<thead>
			<tr>
				<th><h3>No</th>
				<th><h3>Tujuan Kunjungan</th>
				<th><h3>Jumlah</th>
			</tr></thead><tbody>";
		$sql = mysql_query("select * from instalasi $aksi");
		$no = 1;
		while ($row = mysql_fetch_array($sql)) {
		$jml = mysql_num_rows(mysql_query("select * from kunjungan where id_instalasi_tujuan = '$row[id]' and waktu between '$awal' and '$akhir'"));
		
		echo "<tr bgcolor='"; if ($no % 2 == 0) echo "#F4F4F4"; else echo "#FFFFFF"; echo "'>
			<td align=center>$no</td>
			<td>$row[nama]</td>
			<td align=center>$jml</td>
			</tr>
			";	
		$no += 1;
		}
		$total = mysql_num_rows(mysql_query("select * from kunjungan where waktu between '$awal' and '$akhir' $axsi"));
		echo "</tbody>
		<tr><td></td><td>Total</td><td align=center>$total</td></tr>
		</table>
		";
		echo "<br><center><input type=button name=cetak value=' Cetak ' class=tombol onclick=\"window.open('./print/RP/?awal=$_GET[awal]&akhir=$_GET[akhir]&idLap=$_GET[idLap]&idKun=$_GET[idKun]','popup','width=860,height=650,scrollbars=yes, resizable=no');\"></center>";
		
}

else if (!empty($_GET['idPem'])) {
	
	if ($_GET['idPem'] == 'charity') {
		echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN CARA PEMBAYARAN CHARITY<br>
		PERIODE ".indoTgl($_GET[awal])." s . d ".indoTgl($_GET[akhir])."";	
		if ($_GET['idPem'] != 'spm') { $aksi = ""; }
		echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='sortable'>
		<thead>
			<tr>
				<th><h3>No</th>
				<th><h3>Cara Pembayaran</th>
				<th><h3>Jumlah</th>
			</tr></thead><tbody>";
		$sql = mysql_query("select * from jenis_charity");
		
		$no = 1;
		while ($row = mysql_fetch_array($sql)) {
		$jml = mysql_num_rows(mysql_query("select * from kunjungan k, charity c, jenis_charity j where k.id = c.id_kunjungan and c.id_jenis_charity = j.id_jenis_charity and k.waktu between '$awal' and '$akhir' and j.id_jenis_charity = '$row[id_jenis_charity]'"));
		
		echo "<tr bgcolor='"; if ($no % 2 == 0) echo "#F4F4F4"; else echo "#FFFFFF"; echo "'>
			<td align=center>$no</td>
			<td>$row[jenis_charity]</td>
			<td align=center>$jml</td>
			</tr>
			";	
		$no += 1;
		}
		$total = mysql_num_rows(mysql_query("select k.id from kunjungan k, charity c, jenis_charity j where k.id = c.id_kunjungan and c.id_jenis_charity = j.id_jenis_charity and k.waktu between '$awal' and '$akhir'"));
		echo "</tbody>
		<tr><td></td><td>Total</td><td align=center>$total</td></tr>
		</table>
		
		";	
		
	}
	else if ($_GET['idPem'] == 'asuransi') {
		echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN CARA PEMBAYARAN ASURANSI<br>
		PERIODE ".indoTgl($_GET[awal])." s . d ".indoTgl($_GET[akhir])."";	
		if ($_GET['idPem'] != 'spm') { $aksi = ""; }
		echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='sortable'>
		<thead>
			<tr>
				<th><h3>No</th>
				<th><h3>Cara Pembayaran</th>
				<th><h3>Jumlah</th>
			</tr></thead><tbody>";
		$sql = mysql_query("select * from jenis_asuransi");
		
		$no = 1;
		while ($row = mysql_fetch_array($sql)) {
		$jml = mysql_num_rows(mysql_query("select * from kunjungan k, asuransi a, jenis_asuransi j where k.id = a.id_kunjungan and a.id_jenis_asuransi = j.id_jenis_asuransi and k.waktu between '$awal' and '$akhir' and j.id_jenis_asuransi = '$row[id_jenis_asuransi]'"));
		
		echo "<tr bgcolor='"; if ($no % 2 == 0) echo "#F4F4F4"; else echo "#FFFFFF"; echo "'>
			<td align=center>$no</td>
			<td>$row[jenis_asuransi]</td>
			<td align=center>$jml</td>
			</tr>
			";	
		$no += 1;
		}
		$total = mysql_num_rows(mysql_query("select * from kunjungan k, asuransi a, jenis_asuransi j where k.id = a.id_kunjungan and a.id_jenis_asuransi = j.id_jenis_asuransi and k.waktu between '$awal' and '$akhir'"));
		echo "</tbody>
		<tr><td></td><td>Total</td><td align=center>$total</td></tr>
		</table>
		
		";	
		
	}
	else {
		echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN CARA PEMBAYARAN BIAYA SENDIRI<br>
		PERIODE ".indoTgl($_GET[awal])." s . d ".indoTgl($_GET[akhir])."";	
		if ($_GET['idPem'] != 'spm') { $aksi = ""; }
		echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='sortable'>
		<thead>
			<tr>
				<th><h3>No</th>
				<th><h3>Cara Pembayaran</th>
				<th><h3>Jumlah</th>
			</tr></thead><tbody>";
		$sql = mysql_query("select id_kunjungan from asuransi");
		while ($data = mysql_fetch_array($sql)) {
			$asuransi[] = $data[id_kunjungan];
		}
		$id_asuransi = implode(",",$asuransi);
		
		$sql2= mysql_query("select id_kunjungan from charity");
		while ($data2 = mysql_fetch_array($sql2)) {
			$charity[] = $data2[id_kunjungan];
		}
		$id_charity = implode(",",$charity);
		
		$jml = mysql_num_rows(mysql_query("select * from kunjungan where waktu between '$awal' and '$akhir' and id not in($id_asuransi,$id_charity)"));
		$no = 1;
		echo "<tr bgcolor='"; if ($no % 2 == 0) echo "#F4F4F4"; else echo "#FFFFFF"; echo "'>
			<td align=center>$no</td>
			<td>Biaya Sendiri</td>
			<td align=center>$jml</td>
			</tr>
			";	
		
		$total = mysql_num_rows(mysql_query("select * from kunjungan where waktu between '$awal' and '$akhir' and id not in($id_asuransi,$id_charity)"));
		echo "</tbody>
		<tr><td></td><td>Total</td><td align=center>$total</td></tr>
		</table>
		
		";	
	}	
	echo "<br><center><input type=button name=cetak value=' Cetak ' class=tombol onclick=\"window.open('./print/RP/?awal=$_GET[awal]&akhir=$_GET[akhir]&idLap=$_GET[idLap]&idPem=$_GET[idPem]','popup','width=860,height=650,scrollbars=yes, resizable=no');\"></center>";
}
else if (!empty($_GET['idPerujuk'])) {
	
	echo "<h2 align=center>LAPORAN UNIT ADMISI REKAP BANYAKNYA PASIEN BERDASARKAN ASAL RUJUKAN<br>
	PERIODE ".indoTgl($_GET[awal])." s . d ".indoTgl($_GET[akhir])."";
	//if ($_GET['perujuk'] == '') {
		//if ($_GET['idPerujuk'] != 'all') { $aksi = "where id = '$_GET[idPerujuk]'"; $axsi = ""; }
	//}
	echo "
		<table cellpadding='0' cellspacing='0' border='0' id='table' class='sortable'>
		<thead>
			<tr>
				<th><h3>No</th>
				<th><h3>Asal Rujukan</th>
				<th><h3>Nama Nakes</th>
				<th><h3>Jumlah</th>
			</tr></thead><tbody>";
		$sql = mysql_query("select i.nama as nama_ins, i.id as id_ins, p.nama from instansi_relasi i, rujukan r, penduduk p, kunjungan k 
		where i.id = r.id_instansi_relasi and r.id_penduduk_nakes = p.id and k.id_rujukan = r.id and k.waktu between '$awal' and '$akhir' $aksi");
		
		$no = 1;
		while ($row = mysql_fetch_array($sql)) {
		
		echo "<tr bgcolor='"; if ($no % 2 == 0) echo "#F4F4F4"; else echo "#FFFFFF"; echo "'>
			<td align=center>$no</td>
			<td>$row[nama_ins]</td>
			<td>$row[nama]</td>
			<td align=center>1</td>
			</tr>
			";	
		$no += 1;
		}
		$total = mysql_num_rows(mysql_query("select i.nama as nama_ins, i.id as id_ins, p.nama from instansi_relasi i, rujukan r, penduduk p, kunjungan k 
		where i.id = r.id_instansi_relasi and r.id_penduduk_nakes = p.id and k.id_rujukan = r.id and k.waktu between '$awal' and '$akhir' $axsi"));
		echo "</tbody>
		<tr><td></td><td>Total</td><td></td><td align=center>$total</td></tr>
		</table>
		";
		echo "<br><center><input type=button name=cetak value=' Cetak ' class=tombol onclick=\"window.open('./print/RP/?awal=$_GET[awal]&akhir=$_GET[akhir]&idLap=$_GET[idLap]&idKun=$_GET[idKun]','popup','width=860,height=650,scrollbars=yes, resizable=no');\"></center>"; 
		
}
echo "
<script type='text/javascript' src='public/scripts/sorter/script.js'></script>
	<script type='text/javascript'>
  var sorter = new TINY.table.sorter('sorter');
	sorter.head = 'head';
	sorter.asc = 'asc';
	sorter.desc = 'desc';
	sorter.even = 'evenrow';
	sorter.odd = 'oddrow';
	sorter.evensel = 'evenselected';
	sorter.oddsel = 'oddselected';
	sorter.paginate = true;
	sorter.currentid = 'currentpage';
	sorter.limitid = 'pagelimit';
	sorter.init('table',0);
  </script>
</div>";
?>