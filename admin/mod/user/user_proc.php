<?php
if(isset($_POST) && !empty($_POST)){
	$h = array();
	$h[$g_user['nom']] = $_POST[$g_user['nom']];
	$h[$g_user['prenom']] = $_POST[$g_user['prenom']];
	$h[$g_user['login']] = $_POST[$g_user['login']];
	$h[$g_user['isAdministrateurON']] = 1;
	
	if(!empty($_POST[$g_user['password']])){
		$h[$g_user['password']] = md5($_POST[$g_user['password']]);
	}
	
	if($_POST[$g_user['id']]>0){
		// update
		sql_simple_update(T_USER,$_POST[$g_user['id']],$h);
	}else{
		// Ajout
		sql_simple_insert(T_USER,$h);
	}
	
	jump_to_url_and_exit('index.php?to=listing_user');
}
?>