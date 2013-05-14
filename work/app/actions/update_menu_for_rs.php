<?php

$exce=_update("update privileges set icon='-468px 0' where url='admisi/penduduk'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='admisi/penduduk' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-468px 0','1','1','Penduduk','admisi/penduduk')");

}$exce=_update("update privileges set icon='-180px -180px' where url='admisi/opname-pasien'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='admisi/opname-pasien' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-180px -180px','3','1','Opname Pasien','admisi/opname-pasien')");

}$exce=_update("update privileges set icon='-396px 0' where url='admisi/pegawai'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='admisi/pegawai' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-396px 0','1','1','Pegawai','admisi/pegawai')");

}$exce=_update("update privileges set icon='-864px 0' where url='admisi/data-wilayah2'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='admisi/data-wilayah2' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-864px 0','1','1','Wilayah','admisi/data-wilayah2')");

}$exce=_update("update privileges set icon='-180px 0' where url='admisi/data-instalasi'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='admisi/data-instalasi' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-180px 0','1','1','Instalasi','admisi/data-instalasi')");

}$exce=_update("update privileges set icon='-216px 0' where url='pf/inventory/instansi-relasi'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='pf/inventory/instansi-relasi' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-216px 0','1','1','Instansi Relasi','pf/inventory/instansi-relasi')");

}$exce=_update("update privileges set icon='-540px 0' where url='admisi/data-profesi'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='admisi/data-profesi' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-540px 0','1','1','Profesi','admisi/data-profesi')");

}$exce=_update("update privileges set icon='-792px 0' where url='admisi/data-pendidikan'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='admisi/data-pendidikan' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-792px 0','1','1','Tingkat Pendidikan','admisi/data-pendidikan')");

}$exce=_update("update privileges set icon='-360px 0' where url='admisi/data-agama'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='admisi/data-agama' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-360px 0','1','1','Agama','admisi/data-agama')");

}$exce=_update("update privileges set icon='-504px 0' where url='admisi/asuransi-produk'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='admisi/asuransi-produk' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-504px 0','1','1','Produk Asuransi','admisi/asuransi-produk')");

}$exce=_update("update privileges set icon='0 -108px' where url='administrasi/usersystem'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='administrasi/usersystem' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('0 -108px','2','1','User System','administrasi/usersystem')");

}$exce=_update("update privileges set icon='-216px -108px' where url='admisi/data-tarif'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='admisi/data-tarif' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-216px -108px','2','1','Tarif','admisi/data-tarif')");

}$exce=_update("update privileges set icon='-108px -180px' where url='admisi/kunjungan'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='admisi/kunjungan' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-108px -180px','3','1','Kunjungan Rawat Jalan','admisi/kunjungan')");

}$exce=_update("update privileges set icon='-360px -252px' where url='admisi/informasi/data-kunjungan'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='admisi/informasi/data-kunjungan' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-360px -252px','4','1','Kunjungan Rawat Jalan','admisi/informasi/data-kunjungan')");

}$exce=_update("update privileges set icon='-288px -252px' where url='admisi/informasi/flat-report'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='admisi/informasi/flat-report' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-288px -252px','4','1','Kunjungan Flat','admisi/informasi/flat-report')");

}$exce=_update("update privileges set icon='-324px -252px' where url='admisi/informasi/per-pivot-report'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='admisi/informasi/per-pivot-report' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-324px -252px','4','1','Kunjungan Pivot','admisi/informasi/per-pivot-report')");

}$exce=_update("update privileges set icon='-540px -252px' where url='admisi/informasi/flat-income'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='admisi/informasi/flat-income' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-540px -252px','4','1','Pendapatan Flat','admisi/informasi/flat-income')");

}$exce=_update("update privileges set icon='-576px -252px' where url='admisi/informasi/pivot-income'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='admisi/informasi/pivot-income' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-576px -252px','4','1','Pendapatan Pivot','admisi/informasi/pivot-income')");

}$exce=_update("update privileges set icon='-468px -252px' where url='inventory/info-pemesanan'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/info-pemesanan' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-468px -252px','4','1','Pemesanan','inventory/info-pemesanan')");

}$exce=_update("update privileges set icon='-360px -180px' where url='inventory/pemesanan'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/pemesanan' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-360px -180px','3','1','Pemesanan','inventory/pemesanan')");

}$exce=_update("update privileges set icon='-36px 0' where url='inventory/barang'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/barang' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-36px 0','1','1','Barang','inventory/barang')");

}$exce=_update("update privileges set icon='0 0' where url='inventory/penerimaan'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/penerimaan' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('0 0','8','1','Penerimaan Barang','inventory/penerimaan')");

}$exce=_update("update privileges set icon='-324px -180px' where url='inventory/pembelian'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/pembelian' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-324px -180px','3','1','Pembelian','inventory/pembelian')");

}$exce=_update("update privileges set icon='0 0' where url='inventory/info-penerimaan'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/info-penerimaan' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('0 0','8','1','Informasi Penerimaan','inventory/info-penerimaan')");

}$exce=_update("update privileges set icon='-432px -252px' where url='inventory/info-pembelian'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/info-pembelian' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-432px -252px','4','1','Pembelian','inventory/info-pembelian')");

}$exce=_update("update privileges set icon='-108px 0' where url='pf/kamus-obat/farmakologi'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='pf/kamus-obat/farmakologi' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-108px 0','1','1','Farmakologi','pf/kamus-obat/farmakologi')");

}$exce=_update("update privileges set icon='-648px 0' where url='pf/sediaan'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='pf/sediaan' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-648px 0','1','1','Sediaan','pf/sediaan')");

}$exce=_update("update privileges set icon='-144px 0' where url='pf/perundangan'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='pf/perundangan' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-144px 0','1','1','Golongan Perundangan','pf/perundangan')");

}$exce=_update("update privileges set icon='-324px 0' where url='pf/obat'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='pf/obat' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-324px 0','1','1','Obat','pf/obat')");

}$exce=_update("update privileges set icon='-612px -180px' where url='inventory/surat-retur-pembelian'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/surat-retur-pembelian' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-612px -180px','3','1','Retur Pembelian','inventory/surat-retur-pembelian')");

}$exce=_update("update privileges set icon='0 0' where url='inventory/simulasi-penerimaan-1'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/simulasi-penerimaan-1' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('0 0','8','1','Simulasi Penerimaan 1','inventory/simulasi-penerimaan-1')");

}$exce=_update("update privileges set icon='-36px -36px' where url='admisi/jenis-instansi-relasi'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='admisi/jenis-instansi-relasi' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-36px -36px','1','1','Jenis Instansi','admisi/jenis-instansi-relasi')");

}$exce=_update("update privileges set icon='-720px 0' where url='inventory/sub-kategori'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/sub-kategori' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-720px 0','1','1','Sub Kategori Barang','inventory/sub-kategori')");

}$exce=_update("update privileges set icon='-72px -180px' where url='inventory/distribusi'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/distribusi' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-72px -180px','3','1','Distribusi','inventory/distribusi')");

}$exce=_update("update privileges set icon='-504px -180px' where url='inventory/penjualan'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/penjualan' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-504px -180px','3','1','Penjualan','inventory/penjualan')");

}$exce=_update("update privileges set icon='-468px -180px' where url='inventory/penerimaan-unit'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/penerimaan-unit' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-468px -180px','3','1','Penerimaan Unit','inventory/penerimaan-unit')");

}$exce=_update("update privileges set icon='-396px -180px' where url='inventory/pemusnahan'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/pemusnahan' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-396px -180px','3','1','Pemusnahan','inventory/pemusnahan')");

}$exce=_update("update privileges set icon='-504px -252px' where url='inventory/info-pemusnahan'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/info-pemusnahan' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-504px -252px','4','1','Pemusnahan','inventory/info-pemusnahan')");

}$exce=_update("update privileges set icon='-288px -108px' where url='inventory/administrasi-apoteker'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/administrasi-apoteker' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-288px -108px','2','1','Biaya Apoteker','inventory/administrasi-apoteker')");

}$exce=_update("update privileges set icon='-612px -252px' where url='inventory/info-penjualan'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/info-penjualan' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-612px -252px','4','1','Penjualan','inventory/info-penjualan')");

}$exce=_update("update privileges set icon='-144px -108px' where url='inventory/packing-barang'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/packing-barang' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-144px -108px','2','1','Packing Barang','inventory/packing-barang')");

}$exce=_update("update privileges set icon='-612px 0' where url='pf/satuan'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='pf/satuan' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-612px 0','1','1','Satuan','pf/satuan')");

}$exce=_update("update privileges set icon='-144px -180px' where url='admisi/rawat-inap'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='admisi/rawat-inap' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-144px -180px','3','1','Mutasi Rawat Inap','admisi/rawat-inap')");

}$exce=_update("update privileges set icon='-72px -108px' where url='admisi/data-bed'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='admisi/data-bed' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-72px -108px','2','1','Kamar (Klinik)','admisi/data-bed')");

}$exce=_update("update privileges set icon='-36px -108px' where url='inventory/formularium'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/formularium' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-36px -108px','2','1','Formularium','inventory/formularium')");

}$exce=_update("update privileges set icon='-828px 0' where url='admisi/unit'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='admisi/unit' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-828px 0','1','1','Unit','admisi/unit')");

}$exce=_update("update privileges set icon='-720px -252px' where url='inventory/info-resep'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/info-resep' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-720px -252px','4','1','Resep','inventory/info-resep')");

}$exce=_update("update privileges set icon='-72px -252px' where url='admisi/print-barcode'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='admisi/print-barcode' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-72px -252px','4','1','Barcode','admisi/print-barcode')");

}$exce=_update("update privileges set icon='-252px -36px' where url='inventory/stok-opname'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/stok-opname' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-252px -36px','3','1','Opname Pelayanan','inventory/stok-opname')");

}$exce=_update("update privileges set icon='-864px -252px' where url='inventory/info-stok-opname'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/info-stok-opname' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-864px -252px','4','1','Stok Opname Pelayanan','inventory/info-stok-opname')");

}$exce=_update("update privileges set icon='-576px -180px' where url='inventory/surat-retur-penjualan'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/surat-retur-penjualan' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-576px -180px','3','1','Retur Penjualan','inventory/surat-retur-penjualan')");

}$exce=_update("update privileges set icon='-252px 0' where url='admisi/kelas'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='admisi/kelas' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-252px 0','1','1','Kelas','admisi/kelas')");

}$exce=_update("update privileges set icon='-288px 0' where url='admisi/data-layanan'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='admisi/data-layanan' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-288px 0','1','1','Layanan','admisi/data-layanan')");

}$exce=_update("update privileges set icon='-36px -252px' where url='inventory/info-abc'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/info-abc' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-36px -252px','4','1','ABC','inventory/info-abc')");

}$exce=_update("update privileges set icon='-36px -180px' where url='billing/billing'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='billing/billing' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-36px -180px','3','1','Billing','billing/billing')");

}$exce=_update("update privileges set icon='-72px 0' where url='pf/aturan-pakai'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='pf/aturan-pakai' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-72px 0','1','1','Aturan Pakai','pf/aturan-pakai')");

}$exce=_update("update privileges set icon='-108px -252px' where url='billing/info-billing'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='billing/info-billing' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-108px -252px','4','1','Billing','billing/info-billing')");

}$exce=_update("update privileges set icon='-144px -252px' where url='admisi/cetak-kartu-pasien'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='admisi/cetak-kartu-pasien' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-144px -252px','4','1','Cetak Kartu Pasien','admisi/cetak-kartu-pasien')");

}$exce=_update("update privileges set icon='-180px -252px' where url='inventory/info-distribusi'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/info-distribusi' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-180px -252px','4','1','Distribusi','inventory/info-distribusi')");

}$exce=_update("update privileges set icon='-254px -180px' where url='billing/pembayaran-billing'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='billing/pembayaran-billing' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-254px -180px','3','1','Pembayaran','billing/pembayaran-billing')");

}$exce=_update("update privileges set icon='-396px -252px' where url='billing/pembayaran-billing-jasa'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='billing/pembayaran-billing-jasa' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-396px -252px','4','1','Pembayaran Billing Jasa','billing/pembayaran-billing-jasa')");

}$exce=_update("update privileges set icon='-648px -252px' where url='admisi/info-rawat-inap'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='admisi/info-rawat-inap' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-648px -252px','4','1','Rawat Inap','admisi/info-rawat-inap')");

}$exce=_update("update privileges set icon='-756px -252px' where url='admisi/informasi/riwayat-kunjungan-pasien'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='admisi/informasi/riwayat-kunjungan-pasien' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-756px -252px','4','1','Riwayat Kunjungan','admisi/informasi/riwayat-kunjungan-pasien')");

}$exce=_update("update privileges set icon='-792px -252px' where url='inventory/stok-barang-gudang-2'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/stok-barang-gudang-2' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-792px -252px','4','1','Riwayat Stok Barang Gudang','inventory/stok-barang-gudang-2')");

}$exce=_update("update privileges set icon='-72px -288px' where url='inventory/riwayat-obat-gudang'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/riwayat-obat-gudang' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-72px -288px','4','1','Riwayat Stok Obat Gudang','inventory/riwayat-obat-gudang')");

}$exce=_update("update privileges set icon='-828px -252px' where url='inventory/stok-obat-pelayanan-2'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/stok-obat-pelayanan-2' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-828px -252px','4','1','Riwayat Obat Pelayanan','inventory/stok-obat-pelayanan-2')");

}$exce=_update("update privileges set icon='-252px -252px' where url='inventory/info-harga-jual'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/info-harga-jual' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-252px -252px','4','1','Harga Jual','inventory/info-harga-jual')");

}$exce=_update("update privileges set icon='-576px 0' where url='admisi/data-spesialisasi'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='admisi/data-spesialisasi' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-576px 0','1','1','Profesi Spesialisasi','admisi/data-spesialisasi')");

}$exce=_update("update privileges set icon='-432px 0' where url='admisi/data-pekerjaan'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='admisi/data-pekerjaan' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-432px 0','1','1','Pekerjaan','admisi/data-pekerjaan')");

}$exce=_update("update privileges set icon='-684px -252px' where url='admisi/rekap-data-master'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='admisi/rekap-data-master' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-684px -252px','4','1','Rekap Data Master','admisi/rekap-data-master')");

}$exce=_update("update privileges set icon='-432px -180px' where url='inventory/penerimaan-retur-unit'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/penerimaan-retur-unit' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-432px -180px','3','1','Penerimaan Retur Unit','inventory/penerimaan-retur-unit')");

}$exce=_update("update privileges set icon='-180px -108px' where url='administrasi/profile-rs'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='administrasi/profile-rs' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-180px -108px','2','1','Profile RS','administrasi/profile-rs')");

}$exce=_update("update privileges set icon='-72px -288px' where url='inventory/stok-obat-gudang'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/stok-obat-gudang' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-72px -288px','4','1','Stok Obat Gudang','inventory/stok-obat-gudang')");

}$exce=_update("update privileges set icon='-108px -252px' where url='inventory/stok-obat-pelayanan'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/stok-obat-pelayanan' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-108px -252px','4','1','Stok Obat Pelayanan','inventory/stok-obat-pelayanan')");

}$exce=_update("update privileges set icon='-216px -180px' where url='billing/pasien-discharge'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='billing/pasien-discharge' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-216px -180px','3','1','Pasien Discharge','billing/pasien-discharge')");

}$exce=_update("update privileges set icon='-288px -180px' where url='billing/pembayaran-penjualan'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='billing/pembayaran-penjualan' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-288px -180px','3','1','Pembayaran Penjualan','billing/pembayaran-penjualan')");

}$exce=_update("update privileges set icon='-36px -288px ' where url='inventory/info-stok-barang-pelayanan'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/info-stok-barang-pelayanan' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-36px -288px ','4','1','Stok Barang Pelayanan','inventory/info-stok-barang-pelayanan')");

}$exce=_update("update privileges set icon='0 -288px' where url='inventory/info-stok-barang-gudang'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/info-stok-barang-gudang' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('0 -288px','4','1','Stok Barang Gudang','inventory/info-stok-barang-gudang')");

}$exce=_update("update privileges set icon='-612px -180px' where url='inventory/surat-retur-unit'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/surat-retur-unit' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-612px -180px','3','1','Retur Unit','inventory/surat-retur-unit')");

}$exce=_update("update privileges set icon='-216px -252px' where url='admisi/informasi/grafik-report'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='admisi/informasi/grafik-report' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-216px -252px','4','1','Grafik Demografi','admisi/informasi/grafik-report')");

}$exce=_update("update privileges set icon='-108px -108px' where url='pf/komposisi-obat'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='pf/komposisi-obat' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-108px -108px','2','1','Komposisi Obat','pf/komposisi-obat')");

}$exce=_update("update privileges set icon='0 -32px' where url='pf/zat-aktif'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='pf/zat-aktif' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('0 -32px','1','1','Zat Aktif','pf/zat-aktif')");

}$exce=_update("update privileges set icon='-108px -36px' where url='inventory/pemakaian'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/pemakaian' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-108px -36px','3','1','Pemakaian','inventory/pemakaian')");

}$exce=_update("update privileges set icon='-72px -36px' where url='inventory/produksi'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/produksi' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-72px -36px','3','1','Produksi','inventory/produksi')");

}$exce=_update("update privileges set icon='-180px -36px' where url='administrasi/kategori-tarif'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='administrasi/kategori-tarif' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-180px -36px','2','1','Kategori tarif','administrasi/kategori-tarif')");

}$exce=_update("update privileges set icon='-144px -36px' where url='inventory/surat-reretur-pembelian'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/surat-reretur-pembelian' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-144px -36px','3','1','Re-retur Pembelian','inventory/surat-reretur-pembelian')");

}$exce=_update("update privileges set icon='-216px -36px' where url='inventory/repackage'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/repackage' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-216px -36px','3','1','Repackage','inventory/repackage')");

}$exce=_update("update privileges set icon='-288px -36px' where url='inventory/info-retur-pembelian'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/info-retur-pembelian' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-288px -36px','4','1','Retur Pembelian','inventory/info-retur-pembelian')");

}$exce=_update("update privileges set icon='-324px -36px' where url='inventory/info-reretur-pembelian'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/info-reretur-pembelian' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-324px -36px','4','1','Reretur Pembelian','inventory/info-reretur-pembelian')");

}$exce=_update("update privileges set icon='-648px -180px' where url='inventory/stok-opname-gudang'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/stok-opname-gudang' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-648px -180px','3','1','Opname Gudang','inventory/stok-opname-gudang')");

}$exce=_update("update privileges set icon='-396px -252px' where url='billing/info-keuangan'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='billing/info-keuangan' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-396px -252px','4','1','Keuangan','billing/info-keuangan')");

}$exce=_update("update privileges set icon='-648px -180px' where url='inventory/info-stok-opname-gudang'");
$count=_select_unique_result("select count(*) as jumlah from privileges where url='inventory/info-stok-opname-gudang' ");
if($count['jumlah']==0){
_insert("insert into privileges (icon,id_module,status_module,nama,url) values 
('-648px -180px','4','1','Stok Opname Gudang','inventory/info-stok-opname-gudang')");
}
?>
