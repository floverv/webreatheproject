<?php
function getSujetProbleme($id)
{
    require 'config/dbconnect.php';

    $sql = "SELECT * FROM problemevehicule WHERE id = ?";
    $requete = $db->prepare($sql);
    $requete->execute([$id]);

    $result = $requete->fetch();
    return $result['raison'];
}

function getIdMaintenance($id_probleme,$dateDebut,$dateFin)
{
    require 'config/dbconnect.php';

    $sql = "SELECT id FROM `maintenance` WHERE id_probleme = ".$id_probleme." and dateDebut='".$dateDebut."' AND dateFin ='".$dateFin."' ";
    $requete = $db->query($sql);

    $row = $requete->fetch();
    return $row['id'];
}





?>