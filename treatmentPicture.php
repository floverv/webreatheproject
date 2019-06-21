<?php
/* SI CEST UN LIEN */

$url = $_POST['url'];
$name_file = $_POST['name'];
$id_maintenance = $_POST['select_sujet'];

/* SI CEST UN FICHIER */

$file = $_FILES['picture'];
$fileName = $_FILES['picture']['name'];
$fileTmpName = $_FILES['picture']['tmp_name'];
$fileSize = $_FILES['picture']['size'];
$fileError = $_FILES['picture']['error'];


if ($url == "" && $fileName == "") {
    echo '<div class="alert alert-danger margintop25" role="alert">Problème du choix de l\'image.</div>';
} 
else {
    if ($url == "") {
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png', 'pdf');

        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 10000000) {
                    $nomfichier = $host . $img_path . $name_file . "." . $fileActualExt;

                    $picture = $nomfichier;

                    $nomChemin = $img_path . $name_file . "." . $fileActualExt;

                    $fileNameNew = uniqid('', true) . "." . $fileActualExt;

                    $fileNameNew = $nomChemin;

                    $fileDestination = $fileNameNew;

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
    } else {
        $picture = $url;
    }

    $sql = "INSERT INTO `photomaintenance`(`path`, `id_maintenance`,`id_technicien`) VALUES (?,?,?)";
    $requete = $db->prepare($sql);
    $requete->execute([$picture, $id_maintenance, $id_user]);

    echo '<div class="alert alert-success margintop25" role="alert">L\'image a bien été importée. <a href="showMaintenance.php?id='.$id_maintenance.'#picture">Voir les images</a></div>';
}
