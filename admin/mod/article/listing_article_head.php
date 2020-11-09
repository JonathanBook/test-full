<title> <?php echo TITLE_SITE ?> - Article</title>
<script type="text/javascript" src="jquery/xgrid/jquery.xgrid.js"></script>
<script type="text/javascript" src="jquery/jquery.form.js"></script>
<style>
	.input_sieze {
		width: 75vw;
		margin-left: 15px;
	}

	.mybtn {
		margin-top: 20px;
		margin-left: 15px;
		background-color: gray !important;


	}

	.mybtn:hover {
		background-color: #4782D3;
	}

	.btn_style:hover {

		color: red;
	}
</style>

<script type="text/javascript">
	_post_onload.URL = 'index.php?to=ajax_article';
	var _local_ajax_php = 'index.php?to=ajax_article';

	function change_etat_article(id) {
		_post.id = id;
		_ajax_post('change_etat_article');
	}

	function supp_article(id) {
		if (window.confirm('Etes vous sur ?')) {
			_post.id = id;
			_ajax_post('supp_article');
		}
	}



	$().ready(function() {
		$('.xgrid').xGrid();



		/* Masque le formulaire pour ajouter un bouton  */
		$('#myform').hide();

		$('#btn_show').click(function() {

			if ($("#myform").is(":visible")) {

				$('#myform').hide(500);

			} else {
				$('#myform').show(1500);
			}

		})

	});
</script>
<!-- Array Traitement   -->

<link rel="stylesheet" href="jquery/xgrid/jquery.xgrid.css" type="text/css" />