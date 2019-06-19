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
        <?php
        if (isset($_GET['tech_id'])) {
            $id = $_GET['tech_id'];
            if ($db->query('DELETE FROM techniciens WHERE id_user="' . $id . '" ')) {
                echo '
                    <div class="alert alert-success margintop25" role="alert">
                        Le technicien a bien été supprimé 
                    </div>';
            }
        }
        if (isset($_GET['gest_id'])) {
            $id = $_GET['gest_id'];
            if ($db->query('DELETE FROM gestionnaires WHERE id_user="' . $id . '" ')) {
                echo '
                    <div class="alert alert-success margintop25" role="alert">
                        Le gestionnaire a bien été supprimé 
                    </div>';
            }
        }
        ?>
        <div class="card margintop25">
            <div class="card-header">
                <strong>Modification des techniciens</strong>
            </div>
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                        <tr>
                            <th class="center">ID</th>
                            <th class="center">Nom</th>
                            <th style="width: 300px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $db->query('SELECT t.id_user,u.name from techniciens t,users u WHERE t.id_user = u.id');
                        $i = 0;
                        while ($row = $result->fetch()) {
                            $i++;
                            echo '
                                <form action="showUser.php?tech_id=' . $row['id_user'] . '" method="post" class="form-horizontal">
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

        <div class="card margintop25">
            <div class="card-header">
                <strong>Modification des gestionnaires</strong>
            </div>
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                        <tr>
                            <th class="center">ID</th>
                            <th class="center">Nom</th>
                            <th style="width: 300px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $db->query('SELECT g.id_user,u.name from gestionnaires g,users u WHERE g.id_user = u.id');
                        $i = 0;
                        while ($row = $result->fetch()) {
                            $i++;
                            echo '
                                <form action="showUser.php?gest_id=' . $row['id_user'] . '" method="post" class="form-horizontal">
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