<html>
<?php
require 'config/session.php';
require 'function/check.php';
require 'function/getRequete.php';
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
        if(isset($_GET['insert']))
        {     
            /* Initialisations des variables et récupération des données*/
            $dateDebut = $_POST['date_debut'];
            $dateFin = $_POST['date_fin'];
            $id_probleme = $_POST['select_sujet'];
            $description = $_POST['description'];
            $etat = null;
            $sujet = getSujetProbleme($id_probleme);

            /* s'il y a une injection */
            if($dateDebut == null || $dateFin == null || $sujet == null)
            {
                die();
            }
            else{
                /* INSERTION DANS LA TABLE MAINTENANCE */
                $sql = "INSERT INTO `maintenance`(`dateDebut`, `dateFin`, `sujet`, `description`, `etatAvancement`, `id_probleme`) VALUES (?,?,?,?,?,?)";
                $requete = $db->prepare($sql);
                if($dateDebut>$today)
                {
                    $etat = "en attente";
                }
                else{
                    $etat = "en cours";
                }
                if($dateFin < $today){
                    $etat = "termine";
                }
                $requete->execute([$dateDebut,$dateFin,$sujet,$description,$etat,$id_probleme]);

                /* RECUPERATION DE L'ID MAINTENANCE */

                $id_maintenance = getIdMaintenance($id_probleme,$dateDebut,$dateFin);

                $i = 0;

                $count = count($_POST);

                /* tant que l'utilisateur rajoue une piece */
                while($i<$count)
                {
                    // initialisation de la variable select_piece
                    if(isset($_POST['select_piece'][$i])){
                        $select_piece = $_POST['select_piece'][$i];
                    }
                    else{
                        $select_piece = "";
                    }

                    if($select_piece != "")
                    {
                        $sql = "INSERT INTO `listepieces`(`id_pieces`, `id_maintenance`) VALUES (?,?)";
                        $requete = $db->prepare($sql);
                        $requete->execute([$_POST['select_piece'][$i],$id_maintenance]);
                    } 
                    $i++;
                }

                $sql = 'INSERT INTO `affectermaintenance`(`id_user`, `id_maintenance`) VALUES (?,?)';
                $requete = $db->prepare($sql);
                $requete->execute([$id_user,$id_maintenance]);


                echo '
                    <div class="alert alert-success margintop25" role="alert">
                        L\'operation de maintenance a été crée avec succès
                    </div>';
            }

        }
    ?>
        <div class="card margintop25">
            <div class="card-header">
                <strong>Ajout d'une opération de maintenance</strong>
            </div>
            <section class="block">
                <form action="addMaintenance.php?insert" method="post">
                    <div class="form-group">
                        <label for="selectUser">Date de début</label>
                        <input type="text" class="form-control" name="date_debut" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" placeholder="Veuillez rentrer la date de début" required>
                        <small class="form-text text-muted">Respecter ce format : AAAA-MM-DD</small>
                    </div>
                    <div class="form-group">
                        <label for="selectDate">Date de fin</label>
                        <input type="text" class="form-control" name="date_fin" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" placeholder="Veuillez rentrer la date de fin" required>
                        <small class="form-text text-muted">Respecter ce format : AAAA-MM-DD</small>
                    </div>
                    <div class="form-group">
                        <label for="selectUser">Sélectionner un sujet</label>
                        <select class="form-control" name="select_sujet" required>
                            <option value="">Choisir un sujet</option>
                            <?php
                            $sql = "SELECT * FROM problemevehicule";
                            $result = $db->query($sql);
                            while ($row = $result->fetch()) {
                                echo '<option value="' . $row['id'] . '">' . $row['raison'] .' -  '. $row['immatriculation'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" placeholder="Veuillez rentrer la date de début" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="selectPiece">Sélectionner une pièce</label>
                        <select id="select_piece" style ="margin-bottom:10px;" class="form-control" name="select_piece[]">
                            <option value="">Choisir une pièce</option>
                            <?php
                            $sql = "SELECT * FROM pieces";
                            $result = $db->query($sql);
                            while ($row = $result->fetch()) {
                                echo '<option value="' . $row['id'] . '">' . $row['libelle'] .'</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <button type="button" class="btn btn-secondary" style="margin-bottom:10px;"  onclick="addPiece()">Ajouter une pièce ( + )</button>

                    <input type="submit" class="btn btn-success btn_valider" value="Valider">
                </form>
                
            </section>
            
        </div>
    </div>
</body>
<?php require 'footer.php'; ?>

</html>