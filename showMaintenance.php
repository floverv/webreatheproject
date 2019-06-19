<html>
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

    if(isset($_GET['id']))
    {
        $id_maintenance = $_GET['id'];
        $dateDebut = $_POST['dateDebut'];
        $dateFin = $_POST['dateFin'];
        $sujet = $_POST['sujet'];
        $description = $_POST['description'];
        $etat = $_POST['etat'];

        $sql = "UPDATE `maintenance` SET `dateDebut`=?,`dateFin`=?,`sujet`=?,`description`=?,`etatAvancement`=? WHERE id =?";
        $requete = $db->prepare($sql);
        $requete->execute([$dateDebut,$dateFin,$sujet,$description,$etat,$id_maintenance]);

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
                        $result = $db->query('SELECT * FROM maintenance');
                        $i = 0;
                        while ($row = $result->fetch()) {
                            $i++;
                            echo '
                                <form id="ligne'.$i.'" action="showMaintenance.php?id='.$row['id'].'#ligne'.$i.'" method="post" class="form-horizontal">
                                    <tr>
                                        <td class="center">' . $row['id'] . '</td>
                                        <td class="center"><input type="text" class="form-control" name="dateDebut" value="'.$row['dateDebut'].'"></td>
                                        <td class="center"><input type="text" class="form-control" name="dateFin" value="'.$row['dateFin'].'"></td>
                                        <td class="center"><input type="text" class="form-control" name="sujet" value="'.$row['sujet'].'"></td>
                                        <td class="center"><textarea name="description" class="form-control">'.$row['description'].'</textarea></td>
                                        <td class="center"><select class="form-control" name="etat">
                                            <option disabled>Choisir un etat</option>
                                            <option value="pas commence" '; if($row['etatAvancement'] == "pas commence"){echo'selected';} echo'>Pas commencé</option>
                                            <option value="en cours" '; if($row['etatAvancement'] == "en cours"){echo'selected';} echo'>En cours</option>
                                            <option value="termine" '; if($row['etatAvancement'] == "termine"){echo'selected';} echo'>Terminé</option>                 
                                        </select></td>
                                        <td class="center"><a href="showMoremaintenance.php?id='.$row['id'].'" class="btn btn-primary">Voir plus</a></td>
                                        <td class="center"><input type="submit" class="btn btn-success" value="Enregistrer"></td>
                                    </tr>
                                </form>';
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
                        $result = $db->query('SELECT * FROM maintenance m,affectermaintenance a WHERE a.id_user = "'.$id_user.'" ');
                        $i = 0;
                        while ($row = $result->fetch()) {
                            $i++;
                            echo '
                                <form id="ligne'.$i.'" action="showMaintenance.php?id='.$row['id'].'#ligne'.$i.'" method="post" class="form-horizontal">
                                    <tr>
                                        <td class="center">' . $row['id'] . '</td>
                                        <td class="center"><input type="text" class="form-control" name="dateDebut" value="'.$row['dateDebut'].'"></td>
                                        <td class="center"><input type="text" class="form-control" name="dateFin" value="'.$row['dateFin'].'"></td>
                                        <td class="center"><input type="text" class="form-control" name="sujet" value="'.$row['sujet'].'"></td>
                                        <td class="center"><textarea name="description" class="form-control">'.$row['description'].'</textarea></td>
                                        <td class="center"><select class="form-control" name="etat">
                                            <option disabled>Choisir un etat</option>
                                            <option value="pas commence" '; if($row['etatAvancement'] == "pas commence"){echo'selected';} echo'>Pas commencé</option>
                                            <option value="en cours" '; if($row['etatAvancement'] == "en cours"){echo'selected';} echo'>En cours</option>
                                            <option value="termine" '; if($row['etatAvancement'] == "termine"){echo'selected';} echo'>Terminé</option>                 
                                        </select></td>
                                        <td class="center"><a href="showMoremaintenance.php?id='.$row['id'].'" class="btn btn-primary">Voir plus</a></td>
                                        <td class="center"><input type="submit" class="btn btn-success" value="Enregistrer"></td>
                                    </tr>
                                </form>';
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