<?php
session_start();

ini_set('display_startup_errors', true);
ini_set('display_errors', true);
error_reporting(E_ALL | E_STRICT);

$rootPath = dirname(__FILE__);
$applicationDir = 'app';
$defaultAction = 'index';
$idforrole=(isset($_SESSION['layout'])?$_SESSION['layout']:null);
if (isset($idforrole)) {
	switch($idforrole) {
		case "1": $layoutScript = 'views/layout'; $layoutbreak=1;break;
		case "2": $layoutScript = 'views/lite'; $layoutbreak=2; break;
                
	}
} 
require_once $rootPath . '/core/core.php';
require_once $rootPath . '/app/config/db.php';

/** GO..GO..GO!!! **/
require_once 'app/lib/user/user.php';
require_once 'app/lib/common/functions.php';

$username=(isset($_SESSION['username'])?$_SESSION['username']:null);
$password=(isset($_SESSION['password'])?$_SESSION['password']:null);
$id_role=(isset($_SESSION['id_role'])?$_SESSION['id_role']:null);
$id_user=(isset($_SESSION['id_user'])?$_SESSION['id_user']:null);
$nama=(isset($_SESSION['nama'])?$_SESSION['nama']:null);
$pemesanan_barang=(isset($_SESSION['kategori_barang_role'])?$_SESSION['kategori_barang_role']:null);
$pemesanan_nama_kategori_barang=(isset($_SESSION['nama_kategori_role'])?$_SESSION['nama_kategori_role']:null);

$user=new User($username, $password, $id_user,$id_role,$nama,$pemesanan_barang,$pemesanan_nama_kategori_barang);
if(!$user->isLogin()){
    User::login();
}else if(isset($_GET['logout'])){
    User::logout();
}else if(User::cekHalaman()){
    header("location:".  app_base_url('')."?msr=9");
}else{
    app_core_run();
}