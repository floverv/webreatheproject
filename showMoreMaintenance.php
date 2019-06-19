<html>
<?php
require 'config/session.php';
require 'header.php';
if ($role_user != "technicien") {
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

        if (isset($_GET['id'])) {
            $id_maintenance = $_GET['id'];
        } else {
            die();
        }

        if (isset($_GET['edit'])) {
            $id_maintenance = $_GET['id'];
            $dateDebut = $_POST['dateDebut'];
            $dateFin = $_POST['dateFin'];
            $sujet = $_POST['sujet'];
            $description = $_POST['description'];
            $etat = $_POST['etat'];

            $sql = "UPDATE `maintenance` SET `dateDebut`=?,`dateFin`=?,`sujet`=?,`description`=?,`etatAvancement`=? WHERE id =?";
            $requete = $db->prepare($sql);
            $requete->execute([$dateDebut, $dateFin, $sujet, $description, $etat, $id_maintenance]);

            echo '<div class="alert alert-success margintop25" role="alert">La liste a bien été mise à jour.</div>';
        }

        ?>
        <div class="card margintop25">
            <div class="card-header">
                <strong>Opération de maintenance</strong>
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
                        $result = $db->query('SELECT * FROM maintenance WHERE id = "' . $id_maintenance . '"');
                        $i = 0;
                        while ($row = $result->fetch()) {
                            $i++;
                            echo '
                                <form id="ligne' . $i . '" action="showMoreMaintenance.php?edit&id=' . $id_maintenance . '#ligne' . $i . '" method="post" class="form-horizontal">
                                    <tr>
                                        <td class="center">' . $row['id'] . '</td>
                                        <td class="center"><input type="text" class="form-control" name="dateDebut" value="' . $row['dateDebut'] . '"></td>
                                        <td class="center"><input type="text" class="form-control" name="dateFin" value="' . $row['dateFin'] . '"></td>
                                        <td class="center"><input type="text" class="form-control" name="sujet" value="' . $row['sujet'] . '"></td>
                                        <td class="center"><textarea name="description" class="form-control">' . $row['description'] . '</textarea></td>
                                        <td class="center"><select class="form-control" name="etat">
                                            <option disabled>Choisir un etat</option>
                                            <option value="pas commence" ';
                            if ($row['etatAvancement'] == "pas commence") {
                                echo 'selected';
                            }
                            echo '>Pas commencé</option>
                                            <option value="en cours" ';
                            if ($row['etatAvancement'] == "en cours") {
                                echo 'selected';
                            }
                            echo '>En cours</option>
                                            <option value="termine" ';
                            if ($row['etatAvancement'] == "termine") {
                                echo 'selected';
                            }
                            echo '>Terminé</option>                 
                                        </select></td>
                                        <td class="center"><input type="submit" class="btn btn-success" value="Enregistrer"></td>
                                    </tr>
                                </form>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php
        if (isset($_GET['id_piece'])) {
            $id_piece = $_GET['id_piece'];

            $db->query('DELETE FROM listepieces WHERE id_pieces ="' . $id_piece . '" AND id_maintenance = "' . $id_maintenance . '" ');
            echo '<div class="alert alert-success margintop25" role="alert">La pièce a bien été supprimée.</div>';
        }
        ?>

        <div class="card margintop25">
            <div class="card-header">
                <strong>Liste des pièces nécessaires</strong>
            </div>
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                        <tr>
                            <th class="center">ID</th>
                            <th class="center">Nom</th>
                            <th class="center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $db->query('SELECT DISTINCT l.id_pieces,p.libelle FROM maintenance m,listepieces l,pieces p WHERE m.id = "' . $id_maintenance . '" AND p.id = l.id_pieces ');
                        $i = 0;
                        while ($row = $result->fetch()) {
                            $i++;
                            echo '
                                <form id="ligne' . $i . '" action="showMoreMaintenance.php?id=' . $id_maintenance . '&id_piece=' . $row['id_pieces'] . '" method="post" class="form-horizontal">
                                    <tr>
                                        <td class="center">' . $row['id_pieces'] . '</td>
                                        <td class="center">' . $row['libelle'] . '</td>
                                        <td class="center"><input type="submit" class="btn btn-danger" value="Supprimer"></td>
                                    </tr>
                                </form>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php
        if (isset($_GET['user'])) {
            $user = $_GET['user'];

            $db->query('DELETE FROM affectermaintenance WHERE id_user ="' . $user . '" AND id_maintenance = "' . $id_maintenance . '" ');
            echo '<div class="alert alert-success margintop25" role="alert">L\'utilisateur a bien été supprimé.</div>';
        }
        ?>

        <div class="card margintop25">
            <div class="card-header">
                <strong>Liste des techniciens affecté</strong>
            </div>
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                        <tr>
                            <th class="center">ID</th>
                            <th class="center">Nom</th>
                            <th class="center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $db->query('SELECT DISTINCT t.id_user,u.name 
                        FROM techniciens t,users u,affectermaintenance a,maintenance m
                        WHERE t.id_user = u.id AND a.id_maintenance = m.id AND a.id_maintenance = "' . $id_maintenance . '" ');
                        $i = 0;
                        while ($row = $result->fetch()) {
                            $i++;
                            echo '
                                <form id="ligne' . $i . '" action="showMoreMaintenance.php?id=' . $id_maintenance . '&user=' . $row['id_user'] . '" method="post" class="form-horizontal">
                                    <tr>
                                        <td class="center">' . $row['id_user'] . '</td>
                                        <td class="center">' . $row['name'] . '</td>
                                        <td class="center"><input type="submit" class="btn btn-danger" value="Supprimer"></td>
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