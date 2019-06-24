<html>
    <title>Création d'un utilisateur</title>
<?php
require 'config/session.php';
require 'header.php';

// VERIFICATION DU ROLE DE L'ADMINISTRATEUR


if($role_user != "administrateur")
{
    //REDIRECTION SI CEST PAS UN ADMIN
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
            $name = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['mail'];
            $password = $_POST['password'];

            // SI LES VARIABLES NE SONT PAS NULL ALORS INSERTION DANS LA BASE
            if($name != "" && $prenom!= "" & $email="" & $password!="")
            {
                $sql = "INSERT INTO `users`(`email`, `name`, `prenom`, `password`) VALUES (?,?,?,?)";
                $requete = $db->prepare($sql);
                $requete->execute([$email,$name,$prenom,$password]);

                echo '<div class="alert alert-success margintop25" role="alert">L\'utilisateur a été crée avec succés.</div>';
            }
 
        }

        ?>
        <div class="card margintop25">
            <div class="card-header">
                <strong>Créer un nouveau salarié</strong>
            </div>
            <section class="block">
                <form action="addUser.php?insert" method="post">
                    <div class="form-group">
                        <label>Nom</label>
                        <input name="nom" class="form-control" type="text" placeholder="Veuillez rentrer le nom de l'utilisateur" required>
                    </div>
                    <div class="form-group">
                        <label>Prénom</label>
                        <input name="prenom" class="form-control" type="text" placeholder="Veuillez rentrer le prénom de l'utilisateur" required>
                    </div>
                    <div class="form-group">
                        <label>E-mail</label>
                        <input name="mail" class="form-control" type="mail" placeholder="Veuillez rentrer l'e-mail de l'utilisateur" required>
                    </div>
                    <div class="form-group">
                        <label>Mot de passe provisoire</label>
                        <input name="password" class="form-control" type="password" placeholder="Veuillez rentrer le mot de passe provisoire" required>
                    </div>
                    <input type="submit" class="btn btn-success btn_valider" value="Valider">
                </form>
            </section>
        </div>
    </div>
</body>
<?php require 'footer.php'; ?>

</html>