<title><?php echo TITLE_SITE; ?> - Gestions Images</title>
<script type="text/javascript" src="jquery/jquery.uploadFile.js"></script>
<script type="text/javascript" src="jquery/jquery.form.js"></script>
<script type="text/javascript" src="jquery/jquery.imageZoom.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">
<script src="js/MyAjax.js"></script>

<script type="text/javascript">
	_post_onload.URL = 'index.php?to=ajax_galerie';

	function getUrlParam(paramName) {
		var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i');
		var match = window.location.search.match(reParam);
		return (match && match.length > 1) ? match[1] : '';
	}

	function add_image(name_file) {
		var funcNum = getUrlParam('CKEditorFuncNum');
		var fileUrl = name_file;
		console.log(funcNum);
		window.opener.CKEDITOR.tools.callFunction(funcNum, fileUrl);
		window.close();
	}


	//
	//
	//

	function reload_image() {
		_ajax_post_sync('reload_image');
	}

	$().ready(function() {
		$('#filedrag_photo').uploadFile({
			idZoneDropFile: 'filedrag_photo',
			idZoneProgress: 'progress_photo',
			urlAjax: 'index.php?to=ajax_galerie&_ajax_action=upload_image',
			fileType: ["image/jpeg", "image/png"],
			functionOnSuccess: 'reload_image();',

		});

	});
</script>

<style type="text/css">
	.contenaire {
		display: block;
		width: 95vw;
		height: 95vh;
		min-width: 95vw;
		min-height: 95vh;
		background-color: white;
		margin: auto;
		margin-top: 2vh;

	}

	.header_galerie {
		height: 12vh;
		width: 95vw;
		background-color: #3B3D42;
		padding: 0;

	}

	.header_galerie span {
		color: white;
		font-size: 30px;
		margin: 20px 0px 0px 15px;
		display: inline-block;



	}

	.header_galerie>span>small {
		margin-left: 15px;
		color: white;
		font-size: 15px;

	}

	/* Contenaire de la galerie d'image  */
	.zone_galerie {
		display: block;
		position: relative;
		border-bottom: solid 2px black;
		width: 95vw;
		height: 60vh;
		overflow: auto;


	}

	/* Contenaire des image  et des liens  */
	.flex_Cont_pic {
		display: flex;
		flex-wrap: wrap;

	}

	.flex_Cont_pic div {
		margin: 15px 15px 15px 15px;
		display: inline-block;


	}

	/* On fixe une taille ho image  */
	.flex_Cont_pic>div>a>img {
		height: 80px;
		width: 80px;
		margin: 0 !important;
		padding: 0 !important;
		display: inline-block;
		animation: 3s;
	}

	/* On change la taille de l'image quand on survole 
	a la sourie et on rajoute une petite ombre sur le bas de l'image */
	.flex_Cont_pic>div>a>img:hover {
		height: 100px;
		width: 100px;
		margin: 0 !important;
		padding: 0 !important;
		box-shadow: 0px 5px 5px 0 black;
	}


	/* Zone drag and drop */
	#filedrag_photo {

		margin-left: 15px;
		margin-top: 10px;
		border: 1px #555;
		border-radius: 7px;
		cursor: default;
		width: 92.8vw;
		height: 60vh;
		padding-top: 15px;
		float: left;
		margin-right: 20px;
		position: absolute;
		top: 12.8vh;
		z-index: 1;


	}

	.no_hover {
		display: none;
	}

	#filedrag_photo.hover {
		border-color: #f00;
		border-style: solid;
		box-shadow: inset 0 3px 4px #888;
	}

	.zone_descrition {
		position: absolute;
		bottom: 0;
		height: 30vh;
		width: 95vw;
		background-color: black;
	}

	.form_cont {
		width: 93vw;
		background-color: white;
		height: 28vh;
		margin-top: 1vh;
		margin-left: 1vh;

	}

	.form_cont>form>span {
		text-align: center;
		font-size: 17px;
		display: block;
		padding: 5px;
		font-family: 'Indie Flower', cursive;
	}

	.my_form_img {
		float: right;
		height: 150px;
		margin: 2px 15px 15px 15px;
		border-radius: 15px;
		border: solid 1px black;
	}

	.sub_class-btn {
		background-color: black;
		color: white;
		min-width: 80px;
		border-radius: 10px;
		display: inline;
		margin: 15px 15px 15px 15px;
		padding: 10px 10px 10px 10px;
		position: absolute;
		bottom: 5px;

	}

	.my_input_file {
		background-color: black;
		width: 30vw;
		border-radius: 15px;
		margin-left: 15px;
	}
</style>