 <?php
	$ajax_action_post = '';
	$ajax_action_get = '';
	if (isset($_POST['_ajax_action'])) $ajax_action_post = $_POST['_ajax_action'];
	if (isset($_GET['_ajax_action'])) $ajax_action_get = $_GET['_ajax_action'];

	$ajax_action = $ajax_action_get;
	if ($ajax_action_post != "") $ajax_action = $ajax_action_post;

	if ($ajax_action) {
		switch ($ajax_action) {
			case 'upload_image':
				save_upload();

				break;
			case 'reload_image':

				$html = '<div id="progress_photo"></div>';
				$html .= listing_img();
				to_ajax('set', 'filedrag_photo', $html);
				break;
		}
	}

	?>