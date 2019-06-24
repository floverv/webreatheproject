<html>
    <title>Liste des maintenances</title>
<?php
require 'config/session.php';
require 'header.php';
if($role_user != "technicien")
{
    echo "<script type='text/javascript'>window.location.href='home.php';</script>";
    die();
}
/* 
        Variables:
            $id_user : id de l'utilisateur connecté,
            $role_user : role de l'utilisateur connecté
        */
?>

<body>
    <?php require_once 'navbar.php'; ?>

    <div class="container">
    <?php

    // MODIFICATION DE LETAT DE LOPERATION SI UN ID EST RECU
    if(isset($_GET['id']))
    {
        $etat = $_POST['etat'];
        $id_maintenance = $_GET['id'];

        $sql = "UPDATE `maintenance` SET `etatAvancement`=? WHERE id =?";
        $requete = $db->prepare($sql);
        $requete->execute([$etat,$id_maintenance]);

        echo '<div class="alert alert-success margintop25" role="alert">La liste a bien été mise à jour.</div>';
    }

    ?>
        <div class="card margintop25">
            <div class="card-header">
                <strong>Liste des opérations de maintenances</strong>
            </div>
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                        <tr>
                            <th class="center">ID</th>
                            <th class="center">Date de début</th>
                            <th class="center">Date de fin</th>
                            <th class="center">Sujet</th>
                            <th class="center">Description</th>
                            <th class="center">État d'avancement</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $db->query('SELECT * FROM maintenance ORDER BY dateFin desc');
                        while ($row = $result->fetch()) {
                            // RETOURNE TOUS LES MAINTENANCES DE LA BDD
                            echo '
                                <form action="listMaintenances.php?id='.$row['id'].'" method="post" class="form-horizontal">
                                    <tr>
                                        <td class="center">' . $row['id'] . '</td>
                                        <td class="center">'.$row['dateDebut'].'</td>
                                        <td class="center">'.$row['dateFin'].'</td>
                                        <td class="center">'.$row['sujet'].'</td>
                                        <td class="center">'.$row['description'].'</td>
                                        <td class="center"><select class="form-control" name="etat">
                                            <option disabled>Choisir un etat</option>
                                            <option value="en attente" '; if($row['etatAvancement'] == "en attente"){echo'selected';} echo'>En attente</option>
                                            <option value="en cours" '; if($row['etatAvancement'] == "en cours"){echo'selected';} echo'>En cours</option>
                                            <option value="termine" '; if($row['etatAvancement'] == "termine"){echo'selected';} echo'>Terminé</option>                 
                                        </select></td>
                                        <td class="center"><a href="showMaintenance.php?id='.$row['id'].'" class="btn btn-primary">Voir plus</a></td>
                                        <td class="center"><input type="submit" class="btn btn-success" value="Enregistrer"></td>
                                    </tr>
                                </form>';
                                // REDIRECTION AVEC VOIR PLUS VERS LOPERATION ASSOCIÉE
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card margintop25">
            <div class="card-header">
                <strong>Ma liste d'opérations de maintenances</strong>
            </div>
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                        <tr>
                            <th class="center">ID</th>
                            <th class="center">Date de début</th>
                            <th class="center">Date de fin</th>
                            <th class="center">Sujet</th>
                            <th class="center">Description</th>
                            <th class="center">État d'avancement</th>
                            <th style=""></th>
                            <th style=""></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $db->query('SELECT DISTINCTROW * FROM maintenance m,affectermaintenance a WHERE a.id_user = "'.$id_user.'" AND m.id = a.id_maintenance ORDER BY m.dateFin desc ');
                        while ($row = $result->fetch()) {
                            // RETOURNE TOUTES LES OPERATIONS ASSOCIE A LUTILISATEUR EN SESSION
                            echo '
                                <form action="listMaintenances.php?id='.$row['id'].'" method="post" class="form-horizontal">
                                    <tr>
                                        <td class="center">' . $row['id'] . '</td>
                                        <td class="center">'.$row['dateDebut'].'</td>
                                        <td class="center">'.$row['dateFin'].'</td>
                                        <td class="center">'.$row['sujet'].'</td>
                                        <td class="center">'.$row['description'].'</td>
                                        <td class="center"><select class="form-control" name="etat">
                                            <option disabled>Choisir un etat</option>
                                            <option value="en attente" '; if($row['etatAvancement'] == "en attente"){echo'selected';} echo'>En attente</option>
                                            <option value="en cours" '; if($row['etatAvancement'] == "en cours"){echo'selected';} echo'>En cours</option>
                                            <option value="termine" '; if($row['etatAvancement'] == "termine"){echo'selected';} echo'>Terminé</option>                 
                                        </select></td>
                                        <td class="center"><a href="showMaintenance.php?id='.$row['id'].'" class="btn btn-primary">Voir plus</a></td>
                                        <td class="center"><input type="submit" class="btn btn-success" value="Enregistrer"></td>
                                    </tr>
                                </form>';
                                // REDIRECTION AVEC VOIR PLUS VERS LOPERATION ASSOCIÉE
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
<?php require 'footer.php'; ?>

</html>