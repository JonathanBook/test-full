<?php
$html = '';


$html .= '<div class="contenaire">';
$html .= '<div class="header_galerie">';
$html .= '<span>GALERIE D\'IMAGE <small>pour ajouter une image il est possible de la glisser dans la galerie</small></span>';
$html .= '</div >';
$html .= '	<div id="filedrag_photo" class="zone_galerie">';

$html .= '<div id="progress_photo"></div>';
$html .= listing_img();
$html .= "	</div><!--end zone_galerie-->";


$html .= '	<div class="zone_descrition">';
$html.='<div class="form_cont" >';
$form = new form("#", 'POST', 'my_form,id_my_form',null,'enctype="multipart/form-data');
$form->addhtml('<span>Cliquer sur ajouer pou rajouter vos image ou faite un gliser deposer dans la galerie</span><br>');
$form->addInput('file', 'img[]', 'my_input_file', null, null, 'id_img', 'multiple onchange="readImg(this , \'img_min-gale\' ); "');
$form->addhtml('<img id="img_min-gale" src="pic/defaultimg.jpg" alt="" class="my_form_img" accept="image/png, image/jpeg"><br>');
$form->addInput('submit', 'img_submit', 'sub_class-btn');
$html .= $form->newForm();
$html.='</div>';
$html .= "	</div><!--end zone_description-->";
$html .= "</div><!--end contenaire-->";             
