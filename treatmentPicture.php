<?php
/* VARIABLE RECU */

$name_file = $_POST['name'];
$id_maintenance = $_POST['select_sujet'];

/* SI CEST UN LIEN */

$url = $_POST['url'];

/* SI CEST UN FICHIER */

$file = $_FILES['picture'];
$fileName = $_FILES['picture']['name'];
$fileTmpName = $_FILES['picture']['tmp_name'];
$fileSize = $_FILES['picture']['size'];
$fileError = $_FILES['picture']['error'];

// SI AUCUNE DES 2 METHODES N'EST SELECTIONNÉES
if ($url == "" && $fileName == "") {
    echo '<div class="alert alert-danger margintop25" role="alert">Problème du choix de l\'image.</div>';
} 
else {
    // SI LA METHODE CHOISIT EST LE FICHIER LOCAL
    if ($url == "") {

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt)); // RECUPERATION DE LEXTENSION DE L'IMAGE

        $allowed = array('jpg', 'jpeg', 'png', 'pdf'); // LISTE DES EXTENSION VALIDE

        // SI LEXTENSION EST DANS LA LISTE
        if (in_array($fileActualExt, $allowed)) {
            // S'IL N'Y A AUCUNE ERREUR
            if ($fileError === 0) {
                // SI LE FICHIER EST AVEC LE BON POID
                if ($fileSize < 10000000) {
                    /*
                        $host : Changer le fichier dans 'config/dbconnect.php';

                    */
                    $nomfichier = $host . $img_path . $name_file . "." . $fileActualExt;

                    $picture = $nomfichier; // le nom de l'image sera le champ recu 

                    $nomChemin = $img_path . $name_file . "." . $fileActualExt; // Nouveau chemin du fichier avec lextension récuperé

                    $fileNameNew = uniqid('', true) . "." . $fileActualExt; // Nouveau nom de fichier

                    $fileNameNew = $nomChemin;

                    // DESTINATION = NOM DU NOUVEAU CHEMIN
                    $fileDestination = $fileNameNew;

                    // DEPLACEMENT DE LIMAGE RECU $filetmpName DANS LE DOSSIER //$fileDestination
                    move_uploaded_file($fileTmpName, $fileDestination);

                } else {
                    //echo "Your file is too big";
                }
            } else {
                //echo "error in upload";
            }
        } else {
            //echo"You cannot upload files of this type";
        }
    } 
    //SI LA METHODE CHOISIT EST LE INPUT TEXT AVEC UNE URL
    else {
        $picture = $url;
    }

    // INSERTION DANS LA BDD
    $sql = "INSERT INTO `photomaintenance`(`path`, `id_maintenance`,`id_technicien`) VALUES (?,?,?)";
    $requete = $db->prepare($sql);
    $requete->execute([$picture, $id_maintenance, $id_user]);

    echo '<div class="alert alert-success margintop25" role="alert">L\'image a bien été importée. <a href="showMaintenance.php?id='.$id_maintenance.'#picture">Voir les images</a></div>';
}
