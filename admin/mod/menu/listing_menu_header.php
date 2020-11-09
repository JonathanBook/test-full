<?php

/* Ajout d'un  nouveau bouton  */
if (isset($_POST['sub'])) {
	if (!empty($_POST['fr']) && !empty($_POST['uk'])) {
		$button['fk_menu'] = 0;
		$button['is_active_on'] = 1;
		$button['order_menu'] = 0;
		$id_btn = sql_simple_insert('t_menu', $button);
		$l_fr_btn['fk_menu'] = $id_btn;
		$l_fr_btn['label'] = $_POST['fr'];
		$l_fr_btn['fk_lang'] = 1;
		sql_simple_insert('t_menu_lang', $l_fr_btn);
		$l_en_btn['fk_menu'] = $id_btn;
		$l_en_btn['label'] = $_POST['uk'];
		$l_en_btn['fk_lang'] = 2;
		sql_simple_insert('t_menu_lang', $l_en_btn);
	}
}

// Preparation du module xGrid pour listing Menu
require_once 'class/xGrid.class.php';

$sql = "SELECT t_menu.id As jq_plus,t_menu.id As id  ,label,is_active_on,fk_lang FROM t_menu 
	LEFT JOIN t_menu_lang ON t_menu_lang.fk_menu = t_menu.id 
	 WHERE t_menu.fk_menu = 0 AND fk_lang =" . $_SESSION[USERSESSION]['lang'];

$x = new xGrid('listing_menu', $sql);
$x->title('Listing des Menu');

$x->ajaxMode();
$x->setResultPerPage(20);
$x->allowAllSort();
$x->allowAllFilter();
$x->alternateRowBgd(TRUE);
$x->fadedRowBgd(TRUE);
$x->disableExcelExport(TRUE);
$x->enableExcelExport(FALSE);
$x->rowAttrSwap('id', 'id');

$x->th('id', 'ID');

$x->th('label', 'Nom du menu');

$x->th('fk_lang', 'Lang du menu');
/* Icon Active menu */
$x->th('is_active_on', 'Actif');
$x->disableFilter('is_active_on');
$x->cellWidth('is_active_on', 16);
$img_ok = '<div style="text-align:center" id="zone_%0%"><a href="#" onclick="change_etat_menu(%0%); return false;"><img src="pic/ok.png" style="border:none;" /></a></div>';
$x_replace_ok = new xGridReplace(array('%0%'), array('id'), $img_ok);
$img_ko = '<div style="text-align:center" id="zone_%0%"><a href="#" onclick="change_etat_menu(%0%); return false;"><img src="pic/cancel.png" style="border:none;" /></a></div>';
$x_replace_ko = new xGridReplace(array('%0%'), array('id'), $img_ko);
$x_case = new xGridCase();
$x_case->add('is_active_on', 1, $x_replace_ok);
$x_case->add('is_active_on', 0, $x_replace_ko);
$x->caseReplace('is_active_on', $x_case);

/* Icon lang menu */
$x->disableFilter('fk_lang');
$x->cellWidth('fk_lang', 16);
$img_ok = '<div style="text-align:center" <a ><img src="pic/fr.png" style="border:none;" /></a></div>';
$x_replace_ok = new xGridReplace(array('%0%'), array('id'), $img_ok);
$img_ko = '<div style="text-align:center" ><a ><img src="pic/uk.png" style="border:none;" /></a></div>';
$x_replace_ko = new xGridReplace(array('%0%'), array('id'), $img_ko);
$x_case = new xGridCase();
$x_case->add('fk_lang', 1, $x_replace_ok);
$x_case->add('fk_lang', 2, $x_replace_ko);
$x->caseReplace('fk_lang', $x_case);

$x->th('jq_plus', ' ');
$x->cellWidth('jq_plus', 16);
$plus = '<img class="jqExpand" src="pic/plus.gif" altsrc="pic/minus.gif"/>';
$x_replace = new xGridReplace(array(), array(), $plus);
$x->replace('jq_plus', $x_replace);
$x->disableFilter('jq_plus');
$x->disableSort('jq_plus');



$x->th('supp', ' ');
$x->disableFilter('supp');
$x->cellWidth('supp', 90);
$param = array();
$param['label'] = 'Supprimer';
$param['mypic'] = 'SUPPR';
$param['xgrid'] = true;
$param['onclick'] = 'supp_menu(%0%);';
$btn_edit = ubtn($param);
$x_replace = new xGridReplace(array('%0%'), array('id'), $btn_edit);
$x->replace('supp', $x_replace);

$js = "load_page('index.php?to=menu&id=%0%');";
$x_replace = new xGridReplace(array('%0%'), array('id'), $js);
$x->jsOnDblClick('dblclick', $x_replace);



/* Rajout d'un bouton d'ajout de menu */
$html = '<span  style="cursor:pointer" id="btn_show"><i class="fas fa-plus-square fa-2x btn_style"></i></span>';
$html .= '<div>';

$form = new form('#', 'POST', 'myform', 'myform');
$form->addhtml('<img src="pic/fr.png" style="border:none;" />');
$form->addhtml('<br>');
$form->addInput('text', 'fr', 'input_sieze', 'le nom de votre menu en français');
$form->addhtml('<br>');
$form->addhtml('<img src="pic/uk.png" style="border:none;" />');
$form->addhtml('<br>');
$form->addInput('text', 'uk', 'input_sieze', 'le nom de votre menu en anglais');
$form->addhtml('<br>');
$form->addInput('submit', 'sub', 'mybtn', null, 'Sauvgarder Votre menu');

$html .= $form->newForm();


$html .= '</div>';

$html .= $x->build();
