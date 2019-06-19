<?php

function getRole($id_user){
    require 'config/dbconnect.php';

    $role = null;

    /* TEST DU ROLE ADMINISTRATEUR DANS LA BDD */

    $sql = "SELECT id_user FROM administrateur WHERE id_user = ?";
    $requete = $db->prepare($sql);
    $requete->execute([$id_user]);

    $result = $requete->fetch();

    if($result != null){
        $role = "administrateur";
    }

    /* TEST DU ROLE TECHNICIEN DANS LA BDD */

    $sql2 = "SELECT id_user FROM techniciens WHERE id_user = ?";
    $requete2 = $db->prepare($sql2);
    $requete2->execute([$id_user]);

    $result2 = $requete2->fetch();

    if($result2 != null){
        $role = "technicien";
    }

    /* TEST DU ROLE GESTIONNAIRE DANS LA BDD */

    $sql3 = "SELECT id_user FROM gestionnaires WHERE id_user = ?";
    $requete3 = $db->prepare($sql3);
    $requete3->execute([$id_user]);

    $result3 = $requete3->fetch();

    if($result3 != null){
        $role = "gestionnaire";
    }

    return $role;
}

?>