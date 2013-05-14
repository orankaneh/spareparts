<script type="text/javascript">
    function checkAllRole(className,modulSelect){
        var val=$(modulSelect).children('input').val();
        if(val==1){
            $('.'+className).attr('checked','checked');
            $(modulSelect).children('input').val('0');
            $(modulSelect).children('font').html('uncheck');
        }else{
            $('.'+className).removeAttr('checked');
            $(modulSelect).children('input').val('1');
            $(modulSelect).children('font').html('check');
        }
    }
	
	
</script>
<?php
    require_once 'app/lib/administrasi/usersystem.php';
    require_once 'app/actions/admisi/pesan.php';
    require_once 'app/lib/common/functions.php';
    require_once 'app/lib/common/master-data.php';
    $key = isset ($_GET['key'])?$_GET['key']:NULL;
    $sort = isset($_GET['sort'])?$_GET['sort']:NULL;  
    $page = isset($_GET['page'])?$_GET['page']:NULL;
    $idUser = isset ($_GET['idUser'])?$_GET['idUser']:NULL;
    $role = role_muat_data();
    if($_SESSION['id_role']=='1'){
    $usersystem = usersystem_muat_data($idUser,$sort, $page, $dataPerPage = 15, $key);
    }
	else{
	 $usersystem = konsumen_muat_data($_SESSION['id_user'],$sort, $page, $dataPerPage = 15, $key);
	}
	$module = module_muat_data(NULL);

    $unit = unit_muat_data(NULL,2,'asc');
    $tab=(isset($_GET['tab']))?$_GET['tab']:'tab0';
    ?>
<h2 class="judul"><a href="<?= app_base_url('administrasi/usersystem')."?tab=$tab"?>">Administrasi User System</a></h2><?= $pesan = isset($pesan)?$pesan:null; ?>
<script type="text/javascript">
$(document).ready(function() {
	//When page loads...
	//On Click Event
	$("ul.tabs li").click(function() {
		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
//                $.cookie('tab',activeTab,{ expires: 7 });
		$(activeTab).fadeIn(); //Fade in the active ID content
		return false;
	});
});
</script>
<br/>
<ul class="tabs">
    <li class="<?=($tab=='tab0')?'active':''?>"><a href="#tab0">User Account</a></li>
    <li class="<?=($tab=='role')?'active':''?>"><a href="#role">Role</a></li>
<!--    <li class="<?=($tab=='privilege')?'active':''?>"><a href="#privilege">Privilege</a></li>-->
<!--    <li class=""><a href="#tab3">Privileges Role</a></li>-->
</ul>

<div class="tab_container">
    <?
    echo "<div id='tab0' class='tab_content ".(($tab==null)?'active':'')."'>";
        require_once 'app/actions/administrasi/usersystem-list-user.php';
    echo '</div>';

    echo "<div id='role' class='tab_content ".(($tab=='role')?'active':'')."'>";
        require_once 'app/actions/administrasi/usersystem-role.php';
    echo '</div>';

    echo "<div id='privilege' class='tab_content ".(($tab=='privilege')?'active':'')."'>";
        require_once 'app/actions/administrasi/usersystem-privilege.php';
    echo '</div>';

//    echo '<div id="tab3" class='tab_content'>';
//        require_once 'app/actions/administrasi/usersystem-permission.php';
//    echo '</div>';
    ?>
</div>
<script type="text/javascript">
function cekTab(){
            $(".tab_content").hide();
            $('#<?=$tab?>').fadeIn();
    }
    $(document).ready(function(){
        $('.active').fadeIn();
        cekTab();
        
    })
</script>



<?
/**
 * fungsi ini dugunakan untuk manampilkan table priviledge
 * @param <type> $privilege
 * @param <type> $role
 * @param <type> $classRole
 */
function showPrivilege($privilege,$role,$classRole){
        foreach($privilege as $key => $data): ?>
            <tr class="<?= ($key%2) ? 'even':'odd' ?>">
                <td align="center"></td>
                <td></td>
                <td class="no-wrap"><?= $data['nama'] ?></td>
                <?php
                $i=0;
                     foreach($role as $user) {

                        $row=_select_arr("select * from role_permission where id_privileges=$data[id] and id_role like '$user[id_role]'");
						if(isset($row[0]['id_role']))
                           $checked="checked";
                        else
                            $checked="";
                        ?>
                           <td align="center">
                               <input type="checkbox" class="<?=$classRole[$i++]?>" name="data[user<?=$user['id_role']?>][permision][]" value="<?= $data['id']?>"<?=$checked?>/>
                               <input type="hidden" name="data[user<?=$user['id_role']?>][id]" value="<?= $user['id_role'] ?>" />
                           </td>
                        <?php
                     }
                ?>
             </tr>
        <?php endforeach;
    }
    /**
     *
     * @param array $module modul yang akan ditampilkan
     * @param integer $at
     */
     function showModul($module,$role,$at=0){
         $nbsp='';
         for($i=0;$i<=($at*5);$i++){
             $nbsp.='&nbsp;';
         }
         foreach($module as $nums=>$row){
            echo"<tr>"; ?>
            <td align="center"><?= ($at==0)?++$nums:'' ?></td>
            <td class="bolder"><?= $nbsp.$row['module'] ?></td>
            <td>&nbsp;</td>
             <?php
                 $classRole=array();
                 foreach($role as $user) {
                       $role_="module_$row[id]_$user[id_role]";
                       $classRole[]=$role_;
                       if(empty($row['subModul']))
                            echo'<td align="center" style="width:20%"><font class="font_'.$role_.'">Check All</font><br /><input type="checkbox" onclick="checkAllRole(\''.$role_.'\',this)"/><input class="val_'.$role_.'" type="hidden" value="1"></td>';
                       else
                           echo"<td>&nbsp</td>";
                 }
             echo"</tr>";
             if(isset($row['subModul']) && count($row['subModul'])){
                 showModul($row['subModul'], $role,$at+1);
             }
             if(isset($row['privilege']) && count($row['privilege'])){
                 showPrivilege($row['privilege'], $role,$classRole);
             }
        }

    }
?>