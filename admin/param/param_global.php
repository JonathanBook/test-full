<?php
	define('PICTURE_FOLDER', 'pic');	
	define('UPLOADFOLDER', 'upload');	
	define('LANG_CODE_DEFAULT', 1);
	define('DEFAULT_ERP_CURRENCY', '€');
	define('DATEFORMAT' , 'd/m/Y');	
	define('DATEFORMATFULL' , 'd/m/Y H:i');
	/* IMAGE SOURCE */
	define('BIG','pic/upload/big/');
	define('SMALL','pic/upload/small/');
	define('MIN_PIC','pic/upload/miniature/');
	/* BD TABLE */
	define('BD_GALERY','t_gallery');
	define('BD_LST_ARTICLE','lst_article');
	define('BD_LST_ARTICLE_LANG','articles_lang');
	define('BD_LST_CATEGORIES','categorie');
	define('BD_LST_CATEGORIES_LANG','categori_lang');
	define('BD_LST_MENU','t_menu');
	define('BD_LST_MENU_LANG','t_menu_lang');
	define('BD_USER','t_user');

	

	if(!defined('URLSELF')) define('URLSELF',htmlspecialchars($_SERVER["REQUEST_URI"]));
	



?>