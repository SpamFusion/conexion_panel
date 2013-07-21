<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Archivo : conexion_panel.php
| Autor : SpaM
+--------------------------------------------------------*
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Acceso Denegado"); }

if (file_exists(INFUSIONS."conexion_panel/locale/".$settings['locale'].".php")) {
    include INFUSIONS."conexion_panel/locale/".$settings['locale'].".php";
} else {
    include INFUSIONS."conexion_panel/locale/Spanish.php";
}

echo "<script type='text/javascript'>
<!--
function toggle_df() {
  var smu = document.getElementById('info_users');
	var smutxt = document.getElementById('info_users_text');
	if (smu.style.display == 'none') {
		smu.style.display = 'block';
		smutxt.innerHTML = '".$locale['df_conexion_i2']."';
	} else {
		smu.style.display = 'none';
		smutxt.innerHTML = '".$locale['df_conexion_i1']."';
	}
}
//-->
</script>";


	if (iMEMBER) {
	$msg_count = dbcount("(message_id)", DB_MESSAGES, "message_to='".$userdata['user_id']."' AND message_read='0' AND message_folder='0'");

	openside($userdata['user_name']);
	
	if ($msg_count) {

add_to_head("<style type='text/css'>
a.color { color: #000; 
}
#apDiv1 {
   position:absolute;
   width:120px;
   height:50px;
   z-index:1;
   left: 230px;
   top: 250px;
}

#apDiv2 {
   position:absolute;
   width:150px;
   height:50px;
   z-index:1;
   left: 200px;
   top: 330px;
}
</style>");

	echo "<div style='text-align:left;margin-bottom:15px;'>\n";

	echo "<body>
     <img src='".BASEDIR."images/Mensaje.png' alt='".$locale['df_conexion_mensaje']."' syle='border; 0px; ' />  
     <div id='apDiv1'><strong>
<a href='".BASEDIR."edit_profile.php' class='color'>".$userdata['user_name']."</a></div>
    <div id='apDiv2'> <a href='".BASEDIR."messages.php' class='color'>".sprintf($locale['df_conexion_msg'], $msg_count);
	echo ($msg_count == 1 ? $locale['df_conexion_msg1'] : $locale['df_conexion_msg2'])."
</a></div></body></strong>\n";

	echo"<div style='border-top: 0px solid #ccc; border-bottom: 1px solid #ccc; padding-top: 4px;  padding-bottom: 4px; margin-top: 0px; margin-bottom: 5px;'></div>";
	echo "</div>\n";
	}

      if ($userdata['user_avatar'] != "") {
	echo " <div class=\"avataras\" >
	<a href=\"edit_profile.php\"><img border='0'  src='".BASEDIR."images/avatars/".$userdata['user_avatar']."'></p></a>
</div>\n";
} else {
echo "<div class=\"avataras\" >
	<a href=\"edit_profile.php\"><img border='0'  src='".INFUSIONS."conexion_panel/images/noav.gif'></div></a>\n";
}

	echo THEME_BULLET." <a href='".BASEDIR."edit_profile.php' class='side'>".$locale['global_120']."</a><br />\n";
	echo THEME_BULLET." <a href='".BASEDIR."messages.php' class='side'>".$locale['global_121']."</a><br />\n";
	echo THEME_BULLET." <a href='".BASEDIR."members.php' class='side'>".$locale['global_122']."</a>\n";
	if (iADMIN && (iUSER_RIGHTS != "" || iUSER_RIGHTS != "C")) {
		echo "<br />".THEME_BULLET." <a href='".ADMIN."index.php".$aidlink."' class='side'>".$locale['global_123']."</a>\n";
	}

      echo "</br>";
	echo THEME_BULLET." <a href='".BASEDIR."index.php?logout=yes' class='side'>".$locale['global_124']."</a><br />\n";

	echo"<div style='border-top: 0px solid #ccc; border-bottom: 1px solid #ccc; padding-top: 4px;  padding-bottom: 4px; margin-top: 5px; margin-bottom: 5px;'></div>";

echo "
<div align='leaft'>
<a href=\"javascript:void(0)\" onclick=\"toggle_df();\"><span id='info_users_text'> ".$locale['df_conexion_i1']." </span></a>&nbsp;
</div>

<div id='info_users' style='display: none;'>";

	echo"<div style='border-top: 0px solid #ccc; border-bottom: 1px solid #ccc; padding-top: 4px;  padding-bottom: 4px; margin-top: 5px; margin-bottom: 5px;'> <span class='side normal'><strong>".$locale['df_conexion_st']."</strong></span><br />";
	echo THEME_BULLET.$locale['df_conexion_ip'].": <strong>".$userdata['user_ip']."</strong></br>";

	echo THEME_BULLET.$locale['df_conexion_id'].": <strong>".number_format($userdata['user_id'])."</strong></br>";

	echo THEME_BULLET.$locale['df_conexion_foro'].": <strong>".number_format($userdata['user_posts'])."</strong></div>";

			echo "</div>\n";      
           echo "</td></tr></table>";

	echo"<div style='border-top: 0px solid #ccc; border-bottom: 1px solid #ccc; padding-top: 4px;  padding-bottom: 4px; margin-top: 5px; margin-bottom: 5px;'></div>";
	if (iADMIN && checkrights("SU")) {
		$subm_count = dbcount("(submit_id)", DB_SUBMISSIONS);

		if ($subm_count) {
			echo "<div style='text-align:left;margin-top:15px;'>\n";
			echo "<strong><a href='".ADMIN."submissions.php".$aidlink."' class='side'>".sprintf($locale['global_125'], $subm_count);
			echo ($subm_count == 1 ? $locale['global_128'] : $locale['global_129'])."</a></strong>\n";
			echo "</div>\n";
           echo "</td></tr></table>";
		}
	}
	closeside();
} else {
	if (!preg_match('/login.php/i',FUSION_SELF)) {
		$action_url = FUSION_SELF.(FUSION_QUERY ? "?".FUSION_QUERY : "");
		if (isset($_GET['redirect']) && strstr($_GET['redirect'], "/")) {
			$action_url = cleanurl(urldecode($_GET['redirect']));
		}


echo "<script type='text/javascript'>
<!--
function toggle_df() {
	var smu = document.getElementById('login_users');
	var smutxt = document.getElementById('login_users_text');
	if (smu.style.display == 'none') {
		smu.style.display = 'block';
		smutxt.innerHTML = '".$locale['df_conexion_m2']."';
	} else {
		smu.style.display = 'none';
		smutxt.innerHTML = '".$locale['df_conexion_m1']."';
	}
}
//-->
</script>";

	openside($locale['df_conexion_login']); 
	echo "<center><img src='".INFUSIONS."conexion_panel/images/noav.gif' alt='".$locale['df_conexion_avatar']."' style='border: 0px;' title='".$locale['df_conexion_invitado']."' /></td></br></br>";

	echo"<div style='border-top: 1px solid #ccc; border-bottom: 0px solid #ccc; padding-top: 4px;  padding-bottom: 4px; margin-top: 15px; margin-bottom: 5px;'></div>";


echo "
<div align='center'>
<a href=\"javascript:void(0)\" onclick=\"toggle_df();\"><span id='login_users_text'> ".$locale['df_conexion_m1']." </span></a>&nbsp;
</div>

<div id='login_users' style='display: none;'>";

echo "<table cellpadding='0' cellspacing='0' width='100%'  class='' style='border:1px solid #ddd;margin:0 0 2px 0;' ><tr><td class='small2' style='padding:4px;'>";

		echo "<div style='text-align:center'>\n";
		echo "<form name='loginform' method='post' action='".$action_url."'>\n";
		echo $locale['global_101']."<br />\n<input type='text' name='user_name' class='textbox' style='width:100px' /><br />\n";
		echo $locale['global_102']."<br />\n<input type='password' name='user_pass' class='textbox' style='width:100px' /><br />\n";
		echo "<label><input type='checkbox' name='remember_me' value='y' title='".$locale['global_103']."' style='vertical-align:middle;' /></label>\n";
		echo "<input type='submit' name='login' value='".$locale['global_104']."' class='button' /><br />\n";
		echo "</form>\n<br />\n";
           echo "</td></tr></table>";
		if ($settings['enable_registration']) {
			echo $locale['global_105']."<br /><br />\n";
		}
		echo $locale['global_106']."\n</div>\n";
          
		closeside();
	}
}
?>
