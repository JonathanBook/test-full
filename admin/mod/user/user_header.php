<?php
	$page_name = 'user';
	
	//---< BOF $_POST[] >---\\
	$error_msg = "";
	require $page_name.'_proc.php';
	//---< EOF $_POST[] >---\\	


	if(isset($_GET['idUser'])){
		$id_user = $_GET['idUser'];
		$info_user = build_r_from_id(T_USER,$id_user);
	}else{
		$id_user = 0;
		$info_user = array(
			$g_user['id'] => 0,
			$g_user['prenom'] => '',
			$g_user['nom'] => '',
			$g_user['login'] => '',
			$g_user['password'] => '',
			$g_user['enable_menu'] => '',
			$g_user['enable_article'] => '',
			$g_user['enable_actu'] => '',
			$g_user['enable_photo'] => '',
			$g_user['enable_event'] => '',
			$g_user['enable_param'] => '',
			$g_user['enable_user'] => ''
		);		
	}

			
	// Creation du formulaire
	$param_input = ' size="100%" style="width:98%;" ';
	$param_input_o = ' size="100%" style="width:98%;" ';
	
	$param_textarea = ' ';
		
	$tmp_labels[]=label("Prénom : ");
	$tmp_fields[]=build_input($g_user['prenom'],$info_user[$g_user['prenom']],'text',$param_input_o);
	
	$tmp_labels[]=label("Nom : ");
	$tmp_fields[]=build_input($g_user['nom'],$info_user[$g_user['nom']],'text',$param_input_o);
	
	$tmp_labels[]=label("Login : ");
	$tmp_fields[]=build_input($g_user['login'],$info_user[$g_user['login']],'text',$param_input_o);	
	
	$tmp_labels[]=label("Mot de passe : ");
	$tmp_fields[]=build_input($g_user['password'],'','password',$param_input_o);

	$general = build_formTable($tmp_labels,$tmp_fields,'',false);
	unset($tmp_labels);
	unset($tmp_fields);

	$html_general = '<div id="tabs-general">';
	$html_general.= '	'.$general;
	$html_general.= '</div>';
	
	// Lien onglets;
	$html_link = '<ul>';
	$html_link.= '	<li><a href="#tabs-general">Informations Générales <img src="../pic/options.png" style="vertical-align:middle;"/></a></li> ';
	$html_link.= '</ul>';
	
	// Mise en forme onglets
	$html_onglet = '<div id="tabs">';
	$html_onglet.= '	'.$html_link.$html_general;
	$html_onglet.= '</div>';
		
	// Valid
	$param = array();
	$param['mypic'] = 'OK';
	$param['submit'] = true;
	$param['label'] = 'Sauvegarder';
	$btn_valid = '<div style="text-align:center;margin-top:15px;">'.ubtn($param).'</div>';
	
	$html = $html_onglet.$btn_valid;

	// Hidden Field
	$html.= build_input('id',$id_user,'hidden');
	$html = wrap_form($html,'form','',URLSELF,true);
?>