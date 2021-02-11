<?php
include_once 'bdd/bdd.php';
include_once 'majOffice.php';
include_once 'includes/functions.php';
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <?php
    if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
        if (isset($_POST['libelle'])) {
            $libelle = $_POST['libelle'];
            $req = "INSERT INTO ville (libelle) VALUES ('$libelle')";
            $res = $mysqli->query($req);
        } else {
            $libelle = "";
        }
        $req = "SELECT * FROM ville";
        $res = $mysqli->query($req);
        $ville = $res->fetch_all();

    ?>
        <div class="col-8">
            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th>Identifiant</th>
                        <th>Libelle</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < count($ville); $i++) {
                    ?>
                        <tr>
                            <td>
                                <?php
                                echo $ville[$i][0]
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $ville[$i][1]
                                ?>
                            </td>
                            <td>
                                <a href="script/traitementUpdateVille.php?id=<?php echo $ville[$i][0] ?>"><button class="btn">Modifier</button></a>
                                <a href="script/traitementDeleteVille.php?id=<?php echo $ville[$i][0] ?>"><button class="btn">Supprimer</button></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <form method="POST" action="">
                <div class="row">
                    <div class="col-4"></div>
                    <div class="col-4">
                        Libelle<input name="libelle" type="text" class="form-control" required>
                        <button class="btn" type="submit">Valider</button>
                    </div>
                </div>
        </div>
        </form>
        </div>
        </div>
        </div>
    <?php
    } else if (!isset($_SESSION['role'])) {
        $debugg = " [WARNING] Accès refusé à la gestion des villes, connexion manquante";
        ecrire_log($debugg);
    } else if ($_SESSION['role'] != 1) {
        $debugg = " [WARNING] Accès refusé à la gestion des villes, l'utilisateur n'a pas l'autorisation";
        ecrire_log($debugg);
    }
    ?>
</body>

</html>