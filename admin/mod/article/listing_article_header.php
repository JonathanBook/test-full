<?php
$html="";
// Preparation du module xGrid pour listing des article
require_once 'class/xGrid.class.php';

$sql = "SELECT lst_article.id AS id ,
lst_article.id AS supp , 
titre AS NameArt , 
nom As NameCat,is_enligne , 
articles_lang.fk_lang FROM lst_article 
LEFT JOIN articles_lang ON articles_lang.fk_article = lst_article.id 
LEFT JOIN categorie ON categorie.id = lst_article.fk_categorie 
LEFT JOIN categori_lang ON categori_lang.fk_categorie = categorie.id
 WHERE articles_lang.fk_lang =".$_SESSION[USERSESSION]['lang']." 
  AND categori_lang.fk_lang=".$_SESSION[USERSESSION]['lang'];

$x = new xGrid('listing_article', $sql);
$x->title('Listing des articles');

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

$x->th('NameArt', 'Nom de l\'article');
$x->th('NameCat', 'Catégorie');


$x->th('fk_lang', 'Lang du l\'article'); 
/* Icon Active article */
 $x->th('is_enligne', 'En ligne');
$x->disableFilter('is_enligne');
$x->cellWidth('is_enligne', 16);
$img_ok = '<div style="text-align:center" id="zone_%0%"><a href="#" onclick="change_etat_article(%0%); return false;"><img src="pic/ok.png" style="border:none;" /></a></div>';
$x_replace_ok = new xGridReplace(array('%0%'), array('id'), $img_ok);
$img_ko = '<div style="text-align:center" id="zone_%0%"><a href="#" onclick="change_etat_article(%0%); return false;"><img src="pic/cancel.png" style="border:none;" /></a></div>';
$x_replace_ko = new xGridReplace(array('%0%'), array('id'), $img_ko);
$x_case = new xGridCase();
$x_case->add('is_enligne', 1, $x_replace_ok);
$x_case->add('is_enligne', 0, $x_replace_ko);
$x->caseReplace('is_enligne', $x_case);

/* Icon lang Article */
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





$x->th('supp', ' ');
$x->disableFilter('supp');
$x->cellWidth('supp', 90);
$param = array();
$param['label'] = 'Supprimer';
$param['mypic'] = 'SUPPR';
$param['xgrid'] = true;
$param['onclick'] = 'supp_article(%0%);';
$btn_edit = ubtn($param);
$x_replace = new xGridReplace(array('%0%'), array('id'), $btn_edit);
$x->replace('supp', $x_replace);

$js = "load_page('index.php?to=article&id=%0%');";
$x_replace = new xGridReplace(array('%0%'), array('id'), $js);
$x->jsOnDblClick('dblclick', $x_replace); 





$html .= $x->build();
