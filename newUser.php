<html>
<?php
require 'config/session.php';
require 'header.php';
if($role_user != "administrateur")
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
        <h2 class="title_form">Ajouter un nouveau salarié</h2>
        <section class="block">
            <form action="newUser.php?insert" method="post">
                <div class="form-group">
                    <label for="selectUser">Sélectionner l'utilisateur</label>
                    <select class="form-control" name="select_new_user" required>
                        <option value="">Choisir un utilisateur</option>
                        <?php
                        $sql = "SELECT * FROM users";
                        $result = $db->query($sql);
                        while ($row = $result->fetch()) {
                            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                        }

                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="selectCategory">Sélectionner la catégorie souhaité</label>
                    <select class="form-control" name="select_new_category" required>
                        <option value="">Choisir une catégorie</option>
                        <option value="1">Technnicien</option>
                        <option value="2">Gestionnaire</option>
                    </select>
                </div>
                <input type="submit" class="btn btn-success btn_valider" value="Valider">
            </form>
            <?php

            if (isset($_GET['insert'])) {
                $category = $_POST['select_new_category'];
                $user = $_POST['select_new_user'];

                if ($user != "" && $category != "") {
                    switch ($category) {
                        case 1:
                            $sql = "INSERT INTO `techniciens`(`id_user`) VALUES (?)";
                            $requete = $db->prepare($sql);
                            $requete->execute([$user]);
                            echo '<p>L\'utilisateur a bien été ajouté aux techniciens.</p>';
                            break;
                        case 2:
                            $sql = "INSERT INTO `gestionnaires`(`id_user`) VALUES (?)";
                            $requete = $db->prepare($sql);
                            $requete->execute([$user]);

                            echo '<p>L\'utilisateur a bien été ajouté aux gestionnaires.</p>';
                            break;
                    }
                }
            }
            ?>
        </section>
    </div>
</body>
<?php require 'footer.php'; ?>

</html>