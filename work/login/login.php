<html>
    <head><title>Spareparts Online Shop By Sabang Raya Motor</title>
        <link rel="shortcut icon" href="<?php echo app_base_url('/assets/favicon.ico') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo app_base_url('/assets/css/login.css') ?>" media="all" />
        <script type="text/javascript">
            function cekisian(data) {
                if (data.username.value == "") {
                    hidealert.innerHTML = '<div class=\"alert\">Username tidak boleh kosong!</div>';
                    data.username.focus();
                    return false;
                }
                if (data.password.value == "") {
                     hidealert.innerHTML = '<div class=\"alert\">Password tidak boleh kosong!</div>';
                    data.password.focus();
                    return false;
                }
            }
        </script>
    </head>
    <body>
   
        <center>
          <div class="box">
          
<div class="rectangle">
<h2></h2>
</div>

<div class="triangle-l"></div>

<div class="triangle-r"></div>
   <div id="hidealert">
                               </div>
                                <?							
                               if(isset($_POST['login_button'])){
                                   $_GET['msr']=1;
                                   include 'app/actions/admisi/pesan.php';
                               }
                               if (isset($pesan)) echo "<div class='alert' id='alert'>".$pesan."</div><br/>"; ?>
<div class="form">

     <form action="" method="post" onSubmit="return cekisian(this)"> 
<!--form Element-->
<ul>

<li>
<label for="first_name">Username</label>
<input type=text name="username" class="inputstyle user-name">
</li>
<li>
<label for="last_name">Password</label>
 <input type="password" name="password" class="inputstyle"/>
</li> 

   <div class='clear'></div>
                               <center><br>
                                   <input type="hidden" name="last_link" value="<?=$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']?>">
                                   <input type=submit name="login_button" class="buttonstyle" value="LOGIN" style="float: none; width: 120px">
                               </center>
</ul>
</div>

</form>
</div>
          
            <div class="footer">&copy; 2013. Developed By Citraweb Nusa Infomedia</div>
                <div class="footer2">Design by orankaneh</div>
        </center>
    </body>
</html>