<?php
$message = new message();
$data_article = [];
/* Sauvegarde d'un  article */
if (isset($_POST['save_article'])) {

    /* récupération de l'id de l'article si il en possède une  */
    if (isset($_GET['id'])) $id_article = $_GET['id'];

    /* Récupération des donnée a sauvegarder  */
    $data = $_POST;

    unset($data['save_article']);




    /* Vérification de base des donnée qui entrantes  */
    $data['titre'] = htmlspecialchars($data['titre']);
    $data['description'] = htmlspecialchars($data['description']);
    if (!is_numeric($data['categorie'])) $message->setMessage('Catégorie incorrecte');
    if (!is_numeric($data['fk_lang'])) $message->setMessage('langue incorrecte');


    /* Sauvegarde de la miniature dans la galerie  */
    if (!isset($id_article) && empty($_FILES['miniature'])) {

        $message->setMessage('vous devez spécifier une miniature');
    } else {

        if ($message->getMessage() == "" && !empty($_FILES['miniature']['name'])) {
            $img = saveMiniature($_FILES['miniature']);

            if ($img->error == null) {
                $data['miniature'] = $img->url;
            } else {
                $message->setMessage($img->error[100]);
            }
        }
    }
   
    /* Sauvegarde des modification d'un article existant */
    if (isset($id_article) && $message->getMessage() == "") {

        /* on fait une requête sql pour vérifier si le contenue existe */
        $sql="SELECT id FROM articles_lang WHERE fk_lang=" . $data['fk_lang'] . " AND fk_article =".$id_article;
        $id = mysqli_fetch_assoc(query($sql));

        if(!empty($id) ){/* si il existe on le mais ajoure  */

            $sql = "UPDATE `articles_lang` SET `contenue`='" . $data['content'] . "',`titre`='" . $data['titre'] . "',`description`='" . $data['description'] . "'";

            if (isset($data['miniature'])) $sql .= ',`miniature`="' . $data['miniature'] . '"';
    
            $sql .= ' WHERE fk_lang=' . $data['fk_lang'] . ' AND fk_article=' . $id_article;

            query($sql);
            
        }else{/* si il existe pas on le rajoute  */

            $article['fk_article'] = $id_article;
            $article['contenue']=$data['content'];
            $article['fk_lang'] =$data['fk_lang'];
            $article['titre']=$data['titre'];
            $article['description']=$data['description'];
            $article['miniature']=$data['miniature'];
            sql_simple_insert('articles_lang', $article);
    
        }
   
    } elseif (!isset($id_article) && $message->getMessage() == "") {/* sauvegarde d'une nouvelle article  */

        $lst_article["autheur"] = $_SESSION[USERSESSION]['name'];
        $lst_article['date_post'] = date('Y-m-d');
        $lst_article['fk_categorie'] = $data['categorie'];

        $id_article = sql_simple_insert('lst_article', $lst_article);


        $article['fk_article'] = $id_article;
        $article['contenue']=$data['content'];
        $article['fk_lang'] =$data['fk_lang'];
        $article['titre']=$data['titre'];
        $article['description']=$data['description'];
        $article['miniature']=$data['miniature'];

        sql_simple_insert('articles_lang', $article);

    }
    /* On redirige verre notre article quand ces terminer */
    if ($message->getMessage() =="" && isset($id_article)){
        redirect('index.php?to=article&id='.$id_article); 
    }else{
        $html .= $message->getMessage();
    }
     
}
/* Langue Disponible sur le site  */
$langue_article = [
	1 => ['img' => 'fr.png', 'text' => 'Version FR'],
	2 => ['img' => 'uk.png', 'text' => 'Version EN']

];


/* Préparation de la page  */
/*Récupération des Contenue qui correspond a l'article  demander pour Edition   */
if (isset($_GET['id'])) {

	$sql = "SELECT * FROM ".BD_LST_ARTICLE_LANG." WHERE fk_article =" . $_GET['id'];
	$article_m =  query($sql);


	while ($data = mysqli_fetch_assoc($article_m)) {
		array_push($data_article, $data);
	}


	for ($i = count($data_article); $i < count($langue_article); $i++) {

		$data_article[$i] = [
			'titre' => '',
			'miniature' => '',
			'description' => '',
			'categorie' => '',
			'contenue' => '',
			'fk_article' => '',
			'fk_lang' => $i + 1
		];
	}
} else {

	/* Création de variable vide dans le cas d'une création d'un nouvelle article  */
	for ($i = 0; $i < count($langue_article); $i++) {

		$data_article[$i] = [
			'titre' => '',
			'miniature' => '',
			'description' => '',
			'categorie' => '',
			'contenue' => '',
			'fk_article' => '',
			'fk_lang' => $i + 1
		];
	}
}

/* récupération des catégorie */
$sql = "SELECT * FROM  ".BD_LST_CATEGORIES_LANG." WHERE fk_lang = 1  ";
$result = query($sql);

$categorie = array(
	'fk_categorie' => array(),
	'nom' => array()
);

while ($data = mysqli_fetch_assoc($result)) {

	array_push($categorie['fk_categorie'], $data['fk_categorie']);

	array_push($categorie['nom'], $data['nom']);
}
