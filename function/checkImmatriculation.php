<?php
function checkImmat($immat)
{
    require 'config/dbconnect.php';

    $check = false;

    $sql = "SELECT * FROM vehicules WHERE immatriculation = ?";
    $requete = $db->prepare($sql);
    $requete->execute([$immat]);

    $result = $requete->fetch();

    if($result!=null)
    {
        $check = true;
    }

    return $check;
}


?>