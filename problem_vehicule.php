<html>
<?php
require 'config/session.php';
require 'function/checkImmatriculation.php';
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
            if(isset($_GET['unknow']))
            {
                echo '<div class="alert alert-danger margintop25" role="alert">
                        Le véhicule est introuvable
                     </div>';
            }

            if(isset($_GET['insert'])){
                $pattern_immat = "#[A-HJ-NP-TVX-Z]{2}-[0-9]{3}-[A-HJ-NP-TVX-Z]{2}#";
                
                $immat = $_POST['immatriculation'];

                if(!checkImmat($immat))
                {
                    echo "<script type='text/javascript'>window.location.href='problem_vehicule.php?unknow';</script>";
                    die();  
                }

                $raison = $_POST['raison'];

                if($immat=="" || $raison=="" || !preg_match($pattern_immat,$immat) )
                {
                    echo "<script type='text/javascript'>window.location.href='problem_vehicule.php';</script>";
                    die();
                }
                else{
                    $requete = $db->query("INSERT INTO `problemevehicule` ( `raison`, `immatriculation`) VALUES ('".$raison."', '".$immat."');");

                    echo '
                        <div class="alert alert-success margintop25" role="alert">
                            Le problème du véhicule a bien été crée.
                        </div>';
                }
            }
        ?>
        <div class="card margintop25">
            <div class="card-header">
                <strong>Ajout d'un problème pour un véhicule</strong>
            </div>
            <section class="block">
                <form action="problem_vehicule.php?insert" method="post">
                    <div class="form-group">
                        <label for="selectUser">immatriculation</label>
                        <input type="text" class="form-control" name="immatriculation" pattern="[A-HJ-NP-TVX-Z]{2}-[0-9]{3}-[A-HJ-NP-TVX-Z]{2}" placeholder="Veuillez rentrer l'immatriculation" required>
                        <small class="form-text text-muted">Respecter ce format : XX-XXX-XX</small>
                    </div>
                    <div class="form-group">
                        <label for="selectUser">Raison du problème</label>
                        <input type="text" class="form-control" name="raison" placeholder="Veuillez rentrer la raison" required>
                    </div>
                    <input type="submit" class="btn btn-success btn_valider" value="Valider">
                </form>
            </section>
        </div>
    </div>
</body>
<?php require 'footer.php'; ?>

</html>