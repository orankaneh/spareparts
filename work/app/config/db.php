<?php
$conf = include_once APP_APP_PATH . '/config/dbGrid.php';
mysql_connect($conf['host'],$conf['username'] , $conf['password']) or die ('can\'t connect mysql');
mysql_select_db($conf['dbname']);
