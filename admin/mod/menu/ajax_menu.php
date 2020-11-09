<?php

$ajax_action_post = '';
$ajax_action_get = '';
if (isset($_POST['_ajax_action'])) $ajax_action_post = $_POST['_ajax_action'];
if (isset($_GET['_ajax_action'])) $ajax_action_get = $_GET['_ajax_action'];

$ajax_action = $ajax_action_get;
if ($ajax_action_post != "") $ajax_action = $ajax_action_post;



if ($ajax_action) {
	switch ($ajax_action) {
		case 'supp_menu':
			$idMenu = $_POST['id'];
			squery("DELETE FROM t_menu WHERE id=" . $idMenu);
			to_ajax_location('index.php?to=listing_menu');
			break;
		case 'change_etat_menu':
			$idMenu = $_POST['id'];
			$etat = squery("SELECT is_active_on FROM t_menu WHERE id=" . $idMenu);
			if ($etat == 1) {
				$sql = "UPDATE t_menu SET is_active_on = 0 WHERE id =" . $idMenu;
				squery($sql);
				$html = '<a href="#" onclick="change_etat_menu(' . $idMenu . '); return false;"><img src="pic/ok.png" style="border:none;" /></a>';
			} else {
				$sql = "UPDATE t_menu SET is_active_on=1 WHERE id=" . $idMenu;
				squery($sql);
				$html = '<a href="#" onclick="change_etat_menu(' . $idMenu . '); return false;"><img src="pic/cancel.png" style="border:none;" /></a>';
			}
			to_ajax('set', 'zone_' . $idMenu, $html);
			break;
		case 'showSsMenu':
			require_once 'class/xGrid.class.php';

			$idMenu = $_POST['id'];

			$sql = "SELECT  t_menu.id As id ,label AS titre ,is_active_on AS isActifON , order_menu AS ordre FROM t_menu LEFT JOIN t_menu_lang 
			 ON t_menu_lang.fk_menu = t_menu.id  WHERE t_menu.fk_menu=" . $idMenu . "  
			 AND fk_lang =" . $_SESSION[USERSESSION]['lang'];



			$x = new xGrid('listing_ss_menu', $sql);
			$x->countMode(FALSE);
			$x->setClass('void');
			$x->addClass('noBorder');
			$x->setWideMode(FALSE);

			$param = array();
			$param['label'] = 'Ajouter un sous menu';
			$param['mypic'] = 'ADD';
			$param['xgrid'] = true;
			$param['onclick'] = 'load_page(\'index.php?to=menu&id=' . $idMenu . '\');';
			$btn = ubtn($param);
			$x->title('Gestion des sous menus&nbsp;&nbsp;-&nbsp;&nbsp;' . $btn);

			$x->defaultSort('ordre', 'ASC');
			$x->setResultPerPage(200);

			# id
			$x->hide('id');

			# Titre
			$infoTitre = 'Titre : <b>%0%</b>';
			$x_replace = new xGridReplace(array('%0%'), array('titre'), $infoTitre);
			$x->replace('titre', $x_replace);



			# Ordre
			$infoOrdre = 'Ordre : <b>%0%</b>';
			$x_replace = new xGridReplace(array('%0%'), array('ordre'), $infoOrdre);
			$x->replace('ordre', $x_replace);

			# Actif ?
			$x->cellWidth('isActifON', 16);
			$img_ok = '<div style="text-align:center" id="zone_menu_sub_%0%">Actif : <a href="#" onclick="change_etat_submenu(%0%); return false;"><img src="pic/ok.png" style="border:none;" /></a></div>';
			$x_replace_ok = new xGridReplace(array('%0%'), array('id'), $img_ok);
			$img_ko = '<div style="text-align:center" id="zone_menu_sub_%0%">Actif : <a href="#" onclick="change_etat_submenu(%0%); return false;"><img src="pic/cancel.png" style="border:none;" /></a></div>';
			$x_replace_ko = new xGridReplace(array('%0%'), array('id'), $img_ko);
			$x_case = new xGridCase();
			$x_case->add('isActifON', 1, $x_replace_ok);
			$x_case->add('isActifON', 0, $x_replace_ko);
			$x->caseReplace('isActifON', $x_case);




			# Edition
			$param = array();
			$param['label'] = 'Edition';
			$param['mypic'] = 'EDIT';
			$param['xgrid'] = true;
			$param['onclick'] = 'load_page(\'index.php?to=menu&idMenu=' . $idMenu . ');';
			$btn_edit = ubtn($param);
			$x_replace = new xGridReplace(array('%0%'), array('id'), $btn_edit);
			$x->replace('edit', $x_replace);

	

			$html = $x->buildMini();

			to_ajax('set', 'jqExpandTd__' . $idMenu, $html);
			break;
	}
}
if (isset($_GET['updateMenu'])) {


	$lang['fr'] = $_POST['fr'];
	$lang['uk'] = $_POST['en'];
	$id['id'] = $_POST['id_main_buton'];
	$main_button['is_active_on'] = $_POST['active'];
	unset($_POST['fr']);
	unset($_POST['en']);
	unset($_POST['id_main_buton']);
	unset($_POST['active']);

	/* partie save lang button */
	sql_simple_update('t_menu_lang', $id['id'], $lang, false, false, 'fk_menu');
	/* mise ajour du  button principale */
	sql_simple_update('t_menu', $id['id'], $main_button);

	query("UPDATE `t_menu` SET `fk_menu`=0 WHERE fk_menu=" . $id['id']);
	/* mise ajour des button  */
	foreach ($_POST as $key => $value) {
		$v = explode(',', $value);

		$d['order_menu'] = $v[1];
		$d['fk_menu'] = $id['id'];

		sql_simple_update('t_menu', $v[0], $d);
	}
	$message = new message();
	$message->setMessage('Votre Menu est sauvgarder', 'f');

	echo $message->getMessage();
}
