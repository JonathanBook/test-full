<title> <?php echo TITLE_SITE ?> - Menu</title>
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
	_post_onload.URL = 'index.php?to=ajax_menu';
	var _local_ajax_php = 'index.php?to=ajax_menu';

	function change_etat_menu(id) {
		_post.id = id;
		_ajax_post('change_etat_menu');
	}

	function supp_menu(id) {
		if (window.confirm('Etes vous sur ?')) {
			_post.id = id;
			_ajax_post('supp_menu');
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
<script>
	$().ready(function() {
		$('.xgrid').xGrid();

		$.fn.jqExpand = function() {
			$(this).parent().css('cursor', 'pointer');
			$(this).parent().click(function() {
				img = $(this).find('img:first');
				img_src = $(img).attr('src');
				$(img).attr('src', $(img).attr('altsrc'));
				$(img).attr('altsrc', img_src);

				tr = $(this).parents('tr:first');
				id = $(tr).attr('id');
				colspan = $(tr).children().length;

				if ($(tr).next().hasClass('jqExpandTr')) {
					$(tr).next().remove();
				} else {
					$(tr).after('<tr class="jqExpandTr trH2" style="border-bottom:2px solid #777;"><td></td><td colspan="' + (colspan - 1) + '"><div id="jqExpandTd__' + id + '">...</div></td></tr>');
					_post.id = id;
					_ajax_post('showSsMenu');

				}
			});
		};
		$('.jqExpand').livequery(function() {
			$(this).jqExpand();
		});
	});
</script>
<link rel="stylesheet" href="jquery/xgrid/jquery.xgrid.css" type="text/css" />