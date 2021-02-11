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
        if (isset($_POST['login'])) {
            $login = $_POST['login'];
            $mdp = $_POST['mdp'];
            $role = $_POST['role'];
            $req = "INSERT INTO user (login,password,id_role) VALUES ('$login','$mdp','$role')";
            $res = $mysqli->query($req);
        }
        $req = "SELECT * FROM role";
        $res = $mysqli->query($req);
        $role = $res->fetch_all();
        $req = "SELECT * FROM user";
        $res = $mysqli->query($req);
        $user = $res->fetch_all();
    ?>
        <div class="col-8">
            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th>Identifiant</th>
                        <th>Login</th>
                        <th>Mot de passe</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < count($user); $i++) {
                    ?>
                        <tr>
                            <td>
                                <?php
                                echo $user[$i][0]
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $user[$i][1]
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $user[$i][2]
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $user[$i][3]
                                ?>
                            </td>
                            <td>
                                <a href="script/traitementUpdateUser.php?id=<?php echo $user[$i][0] ?>"><button class="btn">Modifier</button></a>
                                <a href="script/traitementDeleteUser.php?id=<?php echo $user[$i][0] ?>"><button class="btn">Supprimer</button></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <form method="POST" action="">
                <div class="row">
                    <div class="col-4"></div>
                    <div class="col-4">
                        Login<input name="login" type="text" class="form-control" required>
                        Mot de passe<input name="mdp" type="password" class="form-control" required><br>
                        <select class="form-control" name="role">
                            <?php
                            for ($i = 0; $i < count($role); $i++) {
                            ?>
                                <option value="<?php echo $role[$i][0] ?>"><?php echo $role[$i][1] ?></option>
                            <?php } ?>
                        </select>
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
        $debugg = " [WARNING] Accès refusé à la gestion des utilisateurs, connexion manquante";
        ecrire_log($debugg);
    } else if ($_SESSION['role'] != 1) {
        $debugg = " [WARNING] Accès refusé à la gestion des utilisateurs, l'utilisateur n'a pas l'autorisation";
        ecrire_log($debugg);
    }
    ?>

</body>

</html>