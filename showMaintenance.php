<html>
<?php
require 'config/session.php';
require 'function/check.php';
require 'header.php';
if ($role_user != "technicien") {
    echo "<script type='text/javascript'>window.location.href='home.php';</script>";
    die();
}

if (isset($_GET['id'])) {
    $id_maintenance = $_GET['id'];
} else {
    echo "<script type='text/javascript'>window.location.href='listMaintenances.php';</script>";
    die();
}
/* 
        Variables:
            $id_user : id de l'utilisateur connecté,
            $role_user : role de l'utilisateur connecté,
            $id_maintenance : id de la maintenance
        */
?>

<body>
    <?php require_once 'navbar.php'; ?>
    

    <div class="container">
    <?php if(!checkOperation($id_maintenance)){
        echo '<div class="alert alert-danger margintop25" role="alert">Opération de maintenance introuvable.</div>';
        die();}
    ?>
        <!--- OPERATION DE MAINTENANCE ----------->
        <div id="operation">


            <?php

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

                echo '<div class="alert alert-success margintop25" role="alert">L\'opération a bien été mise à jour.</div>';
            }

            ?>
            <div class="card margintop25">
                <div class="card-header">
                    <strong>Opération de maintenance</strong>
                </div>
                <section class="block">
                    <div class="table-responsive m-b-40">
                        <table class="table table-borderless table-data3">
                            <thead>
                                <tr>
                                    <th class="center">ID</th>
                                    <th class="center min-width">Date de début</th>
                                    <th class="center min-width">Date de fin</th>
                                    <th class="center min-width">Sujet</th>
                                    <th class="center" style="min-width:170px;">Description</th>
                                    <th class="center">État d'avancement</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result = $db->query('SELECT * FROM maintenance WHERE id = "' . $id_maintenance . '"');
                                while ($row = $result->fetch()) {
                                    echo '
                                    <form action="showMaintenance.php?edit&id=' . $id_maintenance . '#ligne" method="post" class="form-horizontal">
                                        <tr>
                                            <td class="center">' . $row['id'] . '</td>
                                            <td class="center"><input type="text" class="form-control" name="dateDebut" value="' . $row['dateDebut'] . '"></td>
                                            <td class="center"><input type="text" class="form-control" name="dateFin" value="' . $row['dateFin'] . '"></td>
                                            <td class="center"><input type="text" class="form-control" name="sujet" value="' . $row['sujet'] . '"></td>
                                            <td class="center"><textarea name="description" class="form-control">' . $row['description'] . '</textarea></td>
                                            <td class="center"><select class="form-control" name="etat">
                                                <option disabled>Choisir un etat</option>
                                                <option value="en attente" ';if ($row['etatAvancement'] == "en attente") {echo 'selected';}echo '>En attente</option>
                                                <option value="en cours" ';if ($row['etatAvancement'] == "en cours") {echo 'selected';}echo '>En cours</option>
                                                <option value="termine" ';if ($row['etatAvancement'] == "termine") {echo 'selected';}echo '>Terminé</option>                 
                                            </select></td>
                                            <td class="center"><input type="submit" class="btn btn-success" value="Enregistrer"></td>
                                        </tr>
                                    </form>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>

        <!-- LISTE DES PIECES NECESSAIRES ------------->
        <div id="piece">
            <?php
                if (isset($_GET['id_piece'])) {
                    $id_piece = $_GET['id_piece'];

                    $db->query('DELETE FROM listepieces WHERE id_pieces ="' . $id_piece . '" AND id_maintenance = "' . $id_maintenance . '" ');
                    echo '<div class="alert alert-success margintop25" role="alert">La pièce a bien été supprimée.</div>';
                }

                if (isset($_GET['addPiece'])) {
                    $i = 0;

                    $count = count($_POST);

                    /* tant que l'utilisateur rajoue une piece */
                    while ($i <= $count) {
                        // initialisation de la variable select_piece
                        if (isset($_POST['select_piece'][$i])) {
                            $select_piece = $_POST['select_piece'][$i];
                        } else {
                            $select_piece = "";
                        }

                        if ($select_piece != "") {
                            $sql = "INSERT INTO `listepieces`(`id_pieces`, `id_maintenance`) VALUES (?,?)";
                            $requete = $db->prepare($sql);
                            $requete->execute([$_POST['select_piece'][$i], $id_maintenance]);
                        }
                        $i++;
                    }

                    echo '
                            <div class="alert alert-success margintop25" role="alert">
                                Les pièces ont été rajoutés avec succès.
                            </div>';
                }

            ?>

            <div class="card margintop25">
                <div class="card-header">
                    <strong>Liste des pièces nécessaires</strong>
                </div>
                <section class="block">
                    <div class="table-responsive m-b-40">
                        <table class="table table-borderless table-data3">
                            <thead>
                                <tr>
                                    <th class="center" width="30%">ID</th>
                                    <th class="center" width="40%">Nom</th>
                                    <th width="30%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result = $db->query('SELECT DISTINCT l.id_pieces,p.libelle FROM maintenance m,listepieces l,pieces p WHERE m.id = "' . $id_maintenance . '" AND p.id = l.id_pieces ');
                                $i = 0;
                                while ($row = $result->fetch()) {
                                    echo '
                                        <form action="showMaintenance.php?id=' . $id_maintenance . '&id_piece=' . $row['id_pieces'] . '#piece" method="post" class="form-horizontal">
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

                    <?php echo '<form action="showMaintenance.php?id=' . $id_maintenance . '&addPiece#piece" method="post">'; ?>
                    <div class="form-group" style="margin: 20px;">
                        <label for="selectPiece">Rajouter des pièces</label>
                        <select id="select_piece" style="margin-bottom:10px;" class="form-control" name="select_piece[]">
                            <option value="">Choisir une pièce</option>
                            <?php
                            $sql = "SELECT * FROM pieces";
                            $result = $db->query($sql);
                            while ($row = $result->fetch()) {
                                echo '<option value="' . $row['id'] . '">' . $row['libelle'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <button type="button" class="btn btn-secondary btn_piece" onclick="addPiece()">Ajouter une pièce ( + )</button>
                    <input type="submit" class="btn btn-success btn_valider" value="Valider">
                    </form>
                </section>
            </div>
        </div>

        <!-- LISTE DES UTILISATEURS AFFECTÉ ------------->

        <div id="user">
            <?php
            if (isset($_GET['user'])) {
                $user = $_GET['user'];

                $db->query('DELETE FROM affectermaintenance WHERE id_user ="' . $user . '" AND id_maintenance = "' . $id_maintenance . '" ');
                echo '<div class="alert alert-success margintop25" role="alert">L\'utilisateur a bien été supprimé.</div>';
            }

            if (isset($_GET['addUser'])) {
                $i = 0;

                $count = count($_POST);

                /* tant que l'utilisateur rajoue une piece */
                while ($i <= $count) {
                    // initialisation de la variable select_user
                    if (isset($_POST['select_user'][$i])) {
                        $select_user = $_POST['select_user'][$i];
                    } else {
                        $select_user = "";
                    }

                    if ($select_user != "") {
                        $sql = "INSERT INTO `affectermaintenance`(`id_user`, `id_maintenance`) VALUES (?,?)";
                        $requete = $db->prepare($sql);
                        $requete->execute([$_POST['select_user'][$i], $id_maintenance]);
                    }
                    $i++;
                }

                echo '
                        <div class="alert alert-success margintop25" role="alert">
                            Les utilisateurs ont été rajoutés avec succès.
                        </div>';
            }
            ?>

            <div class="card margintop25">
                <div class="card-header">
                    <strong>Liste des techniciens affecté</strong>
                </div>
                <section class="block">
                    <div class="table-responsive m-b-40">
                        <table class="table table-borderless table-data3">
                            <thead>
                                <tr>
                                    <th class="center" width="30%">ID</th>
                                    <th class="center" width="40%">Nom</th>
                                    <th width="30%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result = $db->query('SELECT DISTINCT a.id_user,u.name 
                                FROM techniciens t,users u,affectermaintenance a,maintenance m
                                WHERE a.id_user = t.id_user 
                                AND a.id_user = u.id
                                AND a.id_maintenance = "' . $id_maintenance . '" ');
                                while ($row = $result->fetch()) {
                                    echo '
                                        <form action="showMaintenance.php?id=' . $id_maintenance . '&user=' . $row['id_user'] . '#user" method="post" class="form-horizontal">
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
                    <?php echo '<form action="showMaintenance.php?id=' . $id_maintenance . '&addUser#user" method="post">'; ?>
                    <div class="form-group" style="margin: 20px;">
                        <label for="selectUser">Rajouter des techniciens</label>
                        <select id="select_user" style="margin-bottom:10px;" class="form-control" name="select_user[]">
                            <option value="">Choisir un technicien</option>
                            <?php
                            $sql = "SELECT t.id_user,u.name from techniciens t,users u WHERE t.id_user = u.id ORDER BY u.name ASC ";
                            $result = $db->query($sql);
                            while ($row = $result->fetch()) {
                                echo '<option value="' . $row['id_user'] . '">' . $row['name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <button type="button" class="btn btn-secondary btn_piece" onclick="addUser()">Ajouter un technicien ( + )</button>
                    <input type="submit" class="btn btn-success btn_valider" value="Valider">
                    </form>
                </section>
            </div>

        </div>

        <!-- LISTE DES NOTES ATTRIBUÉES ------------->

        <div id="note">
            <div class="card margintop25">
                <div class="card-header">
                    <strong>Liste des notes attribués</strong>
                </div>
                <section class="block">
                    <div class="table-responsive m-b-40">
                        <table class="table table-borderless table-data3">
                            <thead>
                                <tr>
                                    <th class="center" width="30%">Nom</th>
                                    <th class="center" width="40%">Note</th>
                                    <th class="center" width="30%"></th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $result = $db->query('SELECT DISTINCT n.note,u.name
                                FROM techniciens t,users u,notemaintenance n,affectermaintenance a
                                WHERE u.id = t.id_user
                                AND t.id_user = n.id_technicien
                                AND a.id_user = n.id_technicien
                                AND n.id_maintenance = a.id_maintenance
                                AND n.id_maintenance = '.$id_maintenance.'');

                                while ($row = $result->fetch()) {
                                    echo '
                                    <tr>
                                        <td class="center">' . $row['name'] . '</td>
                                        <td class="center">' . $row['note']  . ' / 5</td>
                                        <td class="center"><a href="addNoteMaintenance.php" class="btn btn-primary">Modifier</a></td>
                                    </tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>

        <!-- LISTE DES IMAGES ------------->

        <div id="picture" style="margin-bottom : 50px;">
            <?php
                if(isset($_GET['delete']))
                {
                    $id_picture = $_GET['delete'];

                    if($id_picture != ""){
                        $db->query("DELETE FROM photomaintenance WHERE id='".$id_picture."' ");
                        echo '<div class="alert alert-success margintop25" role="alert">La photo a bien été supprimée.</div>';
                    }
                }
            ?>
            
            <div class="card margintop25">
                <div class="card-header">
                    <strong>Liste des images</strong>
                </div>
                <section class="block">
                    <div class="table-responsive m-b-40">
                        <table class="table table-borderless table-data3">
                            <thead>
                                <tr>
                                    <th class="center" width="30%">Ajouté par </th>
                                    <th class="center" width="40%">Image</th>
                                    <th class="center" width="30%"></th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $result = $db->query('SELECT DISTINCT p.path,u.name,p.id
                                FROM techniciens t,users u,photomaintenance p
                                WHERE u.id = t.id_user
                                AND p.id_technicien = t.id_user
                                AND p.id_maintenance = '.$id_maintenance.'');

                                while ($row = $result->fetch()) {
                                    echo '
                                    <tr>
                                        <td class="center">' . $row['name'] . '</td>
                                        <td class="center"><img src="' . $row['path']  . '" width="150"/></td>
                                        <td class="center"><a href="showMaintenance?id='.$id_maintenance.'&delete='.$row['id'].'#picture" class="btn btn-danger">Supprimer</a></td>
                                    </tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>

    </div>
</body>
<?php require 'footer.php'; ?>

</html>