<script src="js/jquery-3.5.1.min.js"></script>
<script src="js/ckeditor/ckeditor.js"></script>
<script src="js/MyAjax.js"></script>
<?php


/* Contient toute la logique de sauvegarde  */
require_once('proc.php');
$html = "";






$html .= '<div class="cont_btn" >';
/* Onglet de sélection de la langage de l'article */
foreach ($langue_article as $key => $value) {

	$html .= '<div class="header_selection" onclick="Select_langue_article(\'' . $key . '\');"  id="' . $key . '">';
	$html .= '<img src="pic/' . $value['img'] . '"  alt=""><span>' . $value['text'] . '</span>';
	$html .= '</div>';
}
$html .= '</div>';

foreach ($data_article as $key => $article) {

	/* Création d'un formulaire  */
	$form = new form('#', 'POST', 'myform', 'id_myform' . $article['fk_lang'], 'formArticle my_text', 'enctype="multipart/form-data"');
	$form->addhtml('<div class="Header_from">');
	$form->addhtml('<div class="form-row">');
	/* Zone de titre  */
	$form->addhtml(' <div class="col">');
	$form->addLabel('Titre de l\'article', null,'my_text text_color');
	$form->addhtml('<br>');
	$form->addInput('texte', 'titre', 'input_style small_text', 'Titre de l\'article', $article['titre'],'id_title');
	$form->addhtml('</div>');
	/* Zone Sélection des Catégorie */
	$form->addhtml(' <div class="col">');
	$form->addLabel('Selectioner une Categorie',null,'my_text text_color');
	$form->addhtml('<br>');
	$form->addSelected('categorie', $categorie['fk_categorie'], $categorie['nom'], $langue_article,'my_text');
	$form->addhtml('</div>');
	$form->addhtml('</div>');
	$form->addhtml('</div>');





	/* Zone ajout de miniature  */
	$form->addhtml('<div class="Header_from">');
	$form->addhtml('<div class="form-row">');
	$form->addhtml(' <div class="col">');
	$form->addLabel('Miniatures de l\'article',null,'my_text text_color');
	$form->addhtml('<br>');
	$form->addInput('file', 'miniature', 'input_style inputFile custom-file-input', null, null, null, ' onchange="readImg(this , \'id_miniature' . $key . '\' ) "');
	$form->addhtml('<br>');
	$form->addhtml('<img class="miniature_img" id="id_miniature' . $key . '" src="' .MIN_PIC. $article['miniature'] . '" alt="">');
	$form->addhtml('</div>');
	/* Zone description de l'article  */
	$form->addhtml(' <div class="col">');
	$form->addLabel('D\'escription de l\'article',null,'my_text text_color');
	$form->addhtml('<br>');
	$form->addhtml('<textarea name="description" class="my_text zoneCom_style" id="" cols="30" rows="10">' . $article['description'] . '</textarea>');
	$form->addhtml('</div>');
	$form->addhtml('</div>');
	$form->addhtml('</div>');


	/* Zone contenue de l'article  */
	$form->addhtml('<div style="margin:30px" >');
	$form->addLabel('Contenue de l\'article',null,'my_text text_color big_texte' );
	$form->addhtml('<br>');
	$form->addInput('hidden', 'id', null, null, $article['fk_article'], 'id');
	/* Zone ou on insère notre éditeur Ckeditor  */
	$form->addhtml('<textarea name="content" id="editor' . $key . '" cols="30" rows="10">' . $article['contenue'] . '</textarea>');
	$form->addInput('hidden', 'fk_lang', null, null, $article['fk_lang']);
	$form->addhtml('</div>');
	/* Button envoyer */
	$form->addInput('submit', 'save_article', 'btn-post_article', null, 'Envoyer');
	/* Génération du formulaire  */
	$html .= $form->newForm();
}
?>
<script>
	$().ready(function() {
		/* IMAGE MANAGER */
		/* si aucune miniature présente affiche une image par default */
		$('.miniature_img').each(function() {
			if ($(this).attr('src') == "") {
				$(this).attr('src', 'pic/defaultImg.jpg');
			}

		});

		/* Replacement image  */
		// Replace the <textarea id="editor1"> with a CKEditor 4
		// instance, using default configuration.
		<?php
		foreach ($langue_article as $key => $value) {
			echo "var editor" . ($key - 1) . " = CKEDITOR.replace('editor" . ($key - 1) . "', {
				language: 'fr',
				toolbar: [{
						name: 'document',
						items: ['Print']
					},
					{
						name: 'clipboard',
						items: ['Undo', 'Redo']
					},
					{
						name: 'styles',
						items: ['Format', 'Font', 'FontSize']
					},
					{
						name: 'basicstyles',
						items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'CopyFormatting']
					},
					{
						name: 'colors',
						items: ['TextColor', 'BGColor']
					},
					{
						name: 'align',
						items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
					},
					{
						name: 'links',
						items: ['Link', 'Unlink']
					},
					{
						name: 'paragraph',
						items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']
					},
					{
						name: 'insert',
						items: ['Image', 'Table']
					},
					{
						name: 'tools',
						items: ['Maximize']
					},
					{
						name: 'editing',
						items: ['Scayt']
					}
				],
				customConfig: '',
				disallowedContent: 'img{width,height,float}',
				extraAllowedContent: 'img[width,height,align]',
				height: 800,
				bodyClass: 'document-editor',
				format_tags: 'p;h1;h2;h3;pre',
				removeDialogTabs: 'image:advanced;link:advanced',
				filebrowserBrowseUrl: 'index.php?to=galerie',
				filebrowserUploadUrl: 'index.php?to=galerie'
	
			});
			
	
			
			
			";
		}
		?>

		$('#1').toggleClass('article_active');
		$('#id_myform2').hide();
		id_active = 1;
	});

	function Select_langue_article(id_article) {

		if ($('#' + id_article).hasClass('article_active')) {

		} else {

			$('.formArticle').each(function() {
				$(this).hide();
				$('.article_active').each(function() {
					$(this).removeClass('article_active');
				});
			});

			$('#' + id_article).toggleClass('article_active');
			$('#id_myform' + id_article).show();
		}

	}
</script>