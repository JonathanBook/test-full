
<?php
$html = "";

/* Récupération du bouton que on a cliquer dessue */
$sql = "SELECT t_menu.id ,GROUP_CONCAT(label) AS label,is_active_on,fk_lang FROM t_menu 
LEFT JOIN t_menu_lang ON t_menu_lang.fk_menu = t_menu.id 
 WHERE t_menu.id=" . $_GET['id'] . "   GROUP BY `id`";

$current_button = mysqli_fetch_assoc(query($sql));
$result = query($sql);

$labels = explode(',', $current_button['label']);
$html .= '<form>';
$html .= '	<label>Titre<br></label>';
$html .= '	<img src="pic/fr.png" style="border:none;" />';
$html .= '	<input class="input_sieze" type="text" id="fr" value="' . $labels[0] . '" /><br>';
$html.='<div class="spaceH"></div>';
$html .= '	<label>Titel<br></label>';
$html .= '	<img src="pic/uk.png" style="border:none;" />';
$html .= '	<input class="input_sieze" type="text" id="en" value="' . $labels[1] . '" /><br>';
$html.='<div class="spaceH"></div>';
$html .= '	<label>Active</label>';
$html .= '	<input  id="active" type="checkbox"';
if ($current_button['is_active_on'] == 1) $html .= 'checked';
$html .= ' /><br>';
$html.='</form>';


$html .= '<div class="d-flex spacing">';
$html .= '<div >';
$html .= '<h6  >sous menu <span >' . $labels[0] . '</span></h6>';
$html .= '<ul id="sortable" data_id_button ="' . $_GET['id'] . '" class="box_drop">';

$sql = "SELECT t_menu.id ,label  FROM t_menu 
LEFT JOIN t_menu_lang ON t_menu_lang.fk_menu = t_menu.id 
 WHERE t_menu.fk_menu=" . $_GET['id'] . "  AND fk_lang =" . $_SESSION[USERSESSION]['lang'];
$result = query($sql);
while ($data = mysqli_fetch_assoc($result)) {

	$html .= '<li class="btn btn-dark" data_order="2" data_id="' . $data['id'] . '">' . $data['label'] . '</li>';
}

$html .= '</ul>';
$html .= '</div >';
$html .= '<div class="" >';
$html .= '<h6>Buton disponible</h6>';
$html .= '<ul id="shopping-cart" class="box_drop" data_id_button ="0">';

/* Récupération des bouton disponible  */
$sql = "SELECT t_menu.id ,label,is_active_on,fk_lang FROM t_menu 
LEFT JOIN t_menu_lang ON t_menu_lang.fk_menu = t_menu.id 
 WHERE  t_menu.fk_menu = 0 AND t_menu.id!=" . $_GET['id'] . " AND fk_lang =" . $_SESSION[USERSESSION]['lang'];
$result = query($sql);
while ($data = mysqli_fetch_assoc($result)) {

	$html .= '<li class="btn btn-dark" data_order="2" data_id="' . $data['id'] . '">' . $data['label'] . '</li>';
}
$html .= '</ul>';
$html .= '</div >';
$html .= '</div>';
$html .= '<button  class="btn btn-dark" onclick="saveMenu();"  >ENVOYER</button>';
$html.='<div class="message" id="message" ></div>';

?>
