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
    <?php require_once 'navbar.php'; ?>

    <?php

    
    if(isset($_GET['insert'])){
        $note = $_POST['select_note'];
        $id_maintenance = $_POST['select_sujet'];

        /* SI LE TECHNICIEN A DEJA MIS UNE NOTE */
        if(checkNote($id_maintenance,$id_user))
        {
            $sql = "UPDATE `notemaintenance` SET `note`=? WHERE id_maintenance = ? AND id_technicien = ?";
            $requete = $db->prepare($sql);
            $requete->execute([$note,$id_maintenance,$id_user]);
        } 
        /* SI LE TECHNICIEN N'A JAMAIS MIT DE NOTE*/
        else{
            $sql = "INSERT INTO `notemaintenance`(`note`, `id_maintenance`, `id_technicien`) VALUES (?,?,?)";
            $requete = $db->prepare($sql);
            $requete->execute([$note,$id_maintenance,$id_user]);
        }
        echo "<script type='text/javascript'>window.location.href='showMaintenance?id=".$id_maintenance."#note';</script>";        
    }
    ?>

    <div class="container">

        <div class="card margintop25">
            <div class="card-header">
                <strong>Noter une opération de maintenance</strong>
            </div>
            <section class="block">
                <form action="addNoteMaintenance.php?insert" method="post">
                    <div class="form-group">
                        <label for="selectSujet">Sélectionner une opération de maintenance à noter</label>
                        <select class="form-control" name="select_sujet" required>
                            <option value="">Choisir une opération</option>
                            <?php
                            $sql = "SELECT DISTINCT m.id,m.sujet
                            FROM maintenance m,affectermaintenance a
                            WHERE m.id = a.id_maintenance 
                            AND a.id_user = '".$id_user."'";
                            $result = $db->query($sql);
                            while ($row = $result->fetch()) {
                                echo '<option value="' . $row['id'] . '">' . $row['id'] . ' - ' . $row['sujet'] . '</option>';
                            }

                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="selectSujet">Sélectionner une note</label>
                        <select class="form-control" name="select_note" required>
                            <option value="">Choisir une opération</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <input type="submit" class="btn btn-success btn_valider" value="Valider">
                </form>
            </section>
        </div>
    </div>
</body>
<?php require 'footer.php'; ?>

</html>