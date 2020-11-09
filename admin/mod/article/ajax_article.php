<?php

$ajax_action_post = '';
$ajax_action_get = '';
if (isset($_POST['_ajax_action'])) $ajax_action_post = $_POST['_ajax_action'];
if (isset($_GET['_ajax_action'])) $ajax_action_get = $_GET['_ajax_action'];

$ajax_action = $ajax_action_get;
if ($ajax_action_post != "") $ajax_action = $ajax_action_post;



if ($ajax_action) {
	switch ($ajax_action) {
		case 'supp_article':
			$idarticle = $_POST['id'];
			$sql = "SELECT miniature FROM articles_lang WHERE fk_article =" . $idarticle;
			$url_img = mysqli_fetch_assoc(query($sql))['miniature'];
			if ($url_img) {

				squery("DELETE FROM t_gallery WHERE url =" . $url_img);
				unlink($url_img);
				if (is_file($url_img)) {
					to_ajax_eval('$(\'body\').append(\'' . build_erreur_msg('Suppression impossible !<br/>de l\'image.') . '\')');
				}
			}
			squery("DELETE FROM articles_lang WHERE fk_article =" . $idarticle);
			squery("DELETE FROM lst_article WHERE id=" . $idarticle);

			to_ajax_location('index.php?to=listing_article');
			break;

		case 'change_etat_article':

			$idarticle = $_POST['id'];
			$etat = squery("SELECT is_enligne FROM lst_article WHERE id=" . $idarticle);


			if ($etat == 1) {
				$sql = "UPDATE lst_article SET is_enligne = 0 WHERE id =" . $idarticle;
				squery($sql);
				$html = '<a href="#" onclick="change_etat_article(' . $idarticle . '); return false;"><img src="pic/cancel.png" style="border:none;" /></a>';
			} else {
				$sql = "UPDATE lst_article SET is_enligne=1 WHERE id=" . $idarticle;
				squery($sql);
				$html = '<a href="#" onclick="change_etat_article(' . $idarticle . '); return false;"><img src="pic/ok.png" style="border:none;" /></a>';
			}
			to_ajax('set', 'zone_' . $idarticle, $html);
			break;
	}
}
