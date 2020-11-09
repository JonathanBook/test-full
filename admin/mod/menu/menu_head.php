<title> <?php echo TITLE_SITE; ?> - Utilisateurs</title>

<script type="text/javascript" src="jquery/jquery.form.js"></script>

<style>
	.box_drop {
		display: block;
		min-height: 200px;
		width: 150px;
		border: black 1px !important;
		background-color: black;
		border-radius: 15px;

	}

	ul {
		margin: 0;
		padding: 0;
	}

	ul li {
		width: 100%;
		border-top: black 2px;

	}

	.spacing {
		width: 20vw;
		justify-content: space-between;
		margin: auto;
	}

	.input_sieze {
		width: 75vw;
	}

	.spaceH {
		height: 10px;
	}
</style>

<script>
	$(document).ready(function() {
		$("#tabs").tabs();
		$(function() {

			$("#sortable").sortable({
				connectWith: "#shopping-cart",

				stop: function(event, ui) {
					$("#sortable").find("li").each(function() {
						// On actualise sa position
						index = parseInt($(this).index() + 1);
						// On la met à jour dans la page
						$(this).attr('data_order', index);

					});
				}

			});
			$("#sortable").disableSelection();

			$("#shopping-cart").sortable({
				connectWith: "#sortable",

				stop: function(event, ui) {
					$("#shopping-cart").find("li").each(function() {
						// On actualise sa position
						index = parseInt($(this).index() + 1);
						// On la met à jour dans la page
						$(this).attr('data_order', index);


					});
				}


			});
			$("#shopping-cart").disableSelection();
		});
	});

	function saveMenu() {

		var list_sous_button = []
		id_main_buton = $('#sortable').attr('data_id_button');
		var data = new FormData();
		$("#sortable").find("li").each(function() {

			// On actualise sa position
			index = parseInt($(this).index() + 1);

			// On la met à jour dans la page
			$(this).attr('data_order', index);
			/* récupération de l'id du bouton que on édit  */

			d = [$(this).attr('data_id'), $(this).attr('data_order')];
			console.log(d);
			list_sous_button.push(d);


		});
		for (let index = 0; index < list_sous_button.length; index++) {
			data.append(index, list_sous_button[index]);

		}
		console.log(id_main_buton);
		data.append('id_main_buton', id_main_buton);
		data.append('fr', $('#fr').val());
		data.append('en', $('#en').val());
		data.append('active', $('#active').val());


		my_post("index.php?to=ajax_menu&updateMenu", data, '#message', true);
	}

	function my_post(my_url, my_data, id_target, is_clear) {

		if (is_clear == null) {
			is_clear = false;
		}

		$.ajax({
			type: "POST",
			url: my_url,
			data: my_data,
			processData: false,
			contentType: false,

			success: function(data) {
				if (id_target != null) {
					if (is_clear) {
						$(id_target).html(data);

					} else {
						$(id_target).append(data);
					}
				} else {
					console.log(data);
					return data;
				}


			}
		});
	}
</script>