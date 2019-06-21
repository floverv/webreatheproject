<html>
<?php
require 'config/session.php';
require 'function/check.php';
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
    <?php require_once 'navbar.php';
    echo'<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css">';
    ?>

    <div class="container">
        
        <?php if(isset($_GET['insert'])){include 'treatmentPicture.php';} ?>

        <div class="card margintop25">
            <div class="card-header">
                <strong>Ajouter une photo pour une opération de maintenance</strong>
            </div>
            <section class="block">
                <form action="addPictureMaintenance.php?insert" method="post" novalidate enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="selectSujet">Sélectionner une opération de maintenance</label>
                        <select class="form-control" name="select_sujet" required>
                            <option value="">Choisir une opération</option>
                            <?php
                            $sql = "SELECT DISTINCT m.id,m.sujet
                            FROM maintenance m,affectermaintenance a
                            WHERE m.id = a.id_maintenance 
                            AND a.id_user = '".$id_user."'";
                            $result = $db->query($sql);
                            while ($row = $result->fetch()) {
                                echo '<option value="' . $row['id'] . '">' . $row['sujet'] . '</option>';
                            }

                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Nom de l'image</label>
                        <input type="text" name="name" class="form-control" placeholder="Nom de l'image" required>
                    </div>

                    <div class="form-group">
                        <label>Url de l'image</label>
                        <input type="text" name="url" id="url" class="form-control" onblur="SaisieUrlPicture()" placeholder="http://..." >
                    </div>

                    <label style="margin-bottom:15px;">Ou</label>

                    <div class="form-group">
                        <!--- BULMA FILE --->
                        <div class="file has-name is-fullwidth">
                            <label class="file-label">
                                <input class="file-input" type="file" name="picture" id="btn_file" onchange="setText()">
                                <span class="file-cta">
                                    <span class="file-icon">
                                        <i class="fas fa-upload"></i>
                                    </span>
                                    <span class="file-label">
                                        Choisir un fichier
                                    </span>
                                </span>
                                <span id="file_name" class="file-name">
                                    Séléctionner un fichier ...
                                </span>
                            </label>
                        </div>
                        <!--- BULMA FILE --->
                    </div>

                    <input type="submit" class="btn btn-success btn_valider" value="Valider">
                </form>
            </section>
        </div>
    </div>
</body>
<?php require 'footer.php'; ?>

</html>