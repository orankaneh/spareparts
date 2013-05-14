<?php
Class User{
    static  $username;
    static  $password;
    static  $id_role;
    public static  $id_user;
    static  $nama;
    static  $pemesanan_barang_role;
    static  $pemesanan_nama_kategori_barang_role;
    public function __construct($username=null,$password=null,$id_user=null,$id_role=null,$nama=null,$pemesanan_barang=null,$pemesanan_nama_kategori_barang_role=null) {
        User::$username=$username;
        User::$password=$password;
        User::$id_role=$id_role;
        User::$id_user=$id_user;
        User::$nama=$nama;
        User::$pemesanan_barang_role=$pemesanan_barang;
        User::$pemesanan_nama_kategori_barang_role=$pemesanan_nama_kategori_barang_role;
    }
    function isLogin(){
        if(User::$username !=null && User::$password !=null){
            return true;
        }else {
            return false;
        }
    }

    static  function getUsername(){
        User::$username;
    }
    static  function getPassword(){
        User::$password;
    }
    static  function getIdRole(){
        User::$id_role;
    }
    static  function getIdUser(){
        User::$id_user;
    }
    static function logout() {
        $diesess = session_destroy();
        if ($diesess) {
            header("location:".app_base_url(' '));
        }
    }
    static function login(){
        if(isset($_POST['login_button'])){
            require_once 'app/lib/common/functions.php';
            $username=$_POST['username'];
            $password=md5($_POST['password']);
            $loginQuery =_select_arr("
                    select u.*,r.nama_role,s.nama as salesname,k.nama as konsumenname
					from users u 
					left join role r on(u.id_role=r.id_role)
					left join sales s on(s.id=u.id)
					left join konsumen k on(k.id=u.id)
                    where u.username='$username' and u.password='$password' and r.status=1 and u.status=1");
					
	
            if(count($loginQuery)!=0){
                $update=_update('update users set last_access=now() where id="'.$loginQuery[0]['id'].'"');
                $_SESSION['username']=$loginQuery[0]['username'];
                $_SESSION['password']=$loginQuery[0]['password'];
                $_SESSION['id_role']=$loginQuery[0]['id_role'];
				if($loginQuery[0]['id_role']=='23'){
				 $_SESSION['nama']=$loginQuery[0]['salesname'];
				}
				else if($loginQuery[0]['id_role']=='24'){
				 $_SESSION['nama']=$loginQuery[0]['konsumenname'];
				}
				else{
				$_SESSION['nama']="Admin";
				}
                $_SESSION['status']=$loginQuery[0]['role_status'];
                $_SESSION['id_user']=$loginQuery[0]['id'];
		        $_SESSION['layout']=$loginQuery[0]['id_layout'];
                header("location:http://".$_POST['last_link']);
            }

        }
        require_once 'login/login.php';
    }
    static function cekHalaman($url=null){
        if($url==null){
            $url=app_base_url();
        }
        $baseUrl=  app_base_url();
        $uri=  app_request_get_request_uri();
        $role1=  substr($uri,  strlen($baseUrl)+1);
        $role2=  substr($uri,  strlen($baseUrl));
        $sql="
                select count(*) as jumlah from role_permission rp
                JOIN `privileges` p on p.id=rp.id_privileges
                JOIN `role` r on r.id_role=rp.id_role
                JOIN users u on u.id_role=r.id_role
                where u.id='".User::$id_user."' AND ('$role1' like concat(p.url,'%') OR '$role2' like concat(p.url,'%'))";
        $cek=_select_unique_result($sql);
        if($cek['jumlah']>0){
            return false;
        }else{
            $sql="select count(*) as jumlah from `privileges` p where '$role1' like concat(p.url,'%') OR '$role2' like concat(p.url,'%')";
            $cek=_select_unique_result($sql);
            if($cek['jumlah']>0){
                return true;
            }else
                return false;
        }
    }
}

?>
