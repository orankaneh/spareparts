<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'app/lib/common/functions.php';

delete_list_data($_GET['id'], 'instalasi', 'admisi/data-instalasi?msg=2','admisi/data-instalasi?msr=7',null,null,null,generate_get_parameter($_GET, null, array('msr','msg','do','id')));
