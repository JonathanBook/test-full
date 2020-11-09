<?php
function saveMiniature($file): stdClass
{
    require_once 'class/img.php';
    $result = new stdClass();
    $result->ulr = "";
    $result->error = null;
    // Chargement de la class de gestion des images

    $uploaddir = MIN_PIC;
    $uploadfile = $uploaddir . basename($file['name']);
    if (move_uploaded_file($file['tmp_name'], $uploadfile)) {

        // Upload ok, traitement des images...

        // Génération d'un nom unique
        $tab_name = explode('.', $file['name']);
        $unique_name = uniqid('img_') . '.' . $tab_name[1];

        // Gestion de la taille des images et génération de aperçu (petite image...)
        $myImg = new img($uploadfile);

        // Modification de la taille de l'image (800 pixels sur le coté le plus grand...
        $myImg->resize(800, 800);

        // Enregistrement de l'image
        $myImg->store(BIG . $unique_name);
        $myImg->resize(500, 500);
        $myImg->store($uploaddir . $unique_name);
        // On force l'image en carrée
        $myImg->cropSquare();
        // On modifie sa taille (64px)
        $myImg->resize(100);
        // On enregistre l'image dans le répertoire small
        $myImg->store(SMALL . $unique_name);

        /* Sauvegarde de 'limage dans la base de donner  */
        $h['name'] = $_POST['titre'];
        $h['url'] = $unique_name;

        sql_simple_insert(BD_GALERY, $h);

        // On libère la mémoire du serveur.
        unset($myImg);

        // Nettoyage de l'ancien fichier
        @unlink($uploadfile);

        $result->url = $h['url'];
    } else {

        $result->error[100] = 'erreur de sauvgarde de l\'image ';
    }
    return $result;
}

function listing_img(): string
{

    $html = "";

    $result = query("SELECT * FROM ".BD_GALERY);

    $html .= '<div class="flex_Cont_pic">';

    while ($data = mysqli_fetch_assoc($result)) {

        $html .= '<div >';
        $html .= '<a  onclick="add_image(\''.BIG.$data['url'].'\');"  ><img   class="" src="' . SMALL . $data['url'] . '" alt=""></a>';

        $html .= '</div>';
    }
    $html .= '</div>';




    return $html;
}


function save_upload(): stdClass
{

    $filename = $_GET['filename'];
    $uniqueId = uniqid('img_') ;
    $name_file = $uniqueId."_".$filename;
    file_put_contents(
        BIG . $name_file,
        file_get_contents('php://input')
    );


    require_once 'class/img.php';
    $result = new stdClass();
    $result->ulr = "";
    $result->error = null;
    // Chargement de la class de gestion des images
    
   
        // Gestion de la taille des images et génération de aperçu (petite image...)
        $myImg = new img(BIG.$name_file);

        // Modification de la taille de l'image (800 pixels sur le coté le plus grand...
        $myImg->resize(800, 800);

        // Enregistrement de l'image
        $myImg->store( $uploaddir . $name_file);
       
        // On force l'image en carrée
        $myImg->cropSquare();
        // On modifie sa taille (100px)
        $myImg->resize(100);
        // On enregistre l'image dans le répertoire small
        $myImg->store(SMALL . $name_file);

        /* Sauvegarde de 'limage dans la base de donner  */
        $h['name'] = $name_file;
        $h['url'] = $name_file;

        sql_simple_insert(BD_GALERY, $h);

        unset($myImg);

        $result->url = $h['url'];
 
    return $result;
}