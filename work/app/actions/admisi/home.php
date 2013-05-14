
<?php
include 'app/actions/admisi/pesan.php';
echo isset($pesan)?$pesan:NULL;

if (isset($_SESSION['layout']) and $_SESSION['layout']==2) { ?>
<script type="text/javascript">
	$("#openribbon").show();
</script>
<?php
} else {
?>
<center>
<div class="splashbox"><BR>
	<h1>Selamat Datang<h1>
	<h2>SPARE PARTS ONLINE</h2><br>
	
	<div class="internal-logo">&nbsp;</div>

</div>
</center>
<?php } ?>