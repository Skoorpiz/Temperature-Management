<?php
include_once '../bdd/bdd.php';

$id = $_GET['id'];

if (isset($_POST['login'])) {
    $login = $_POST['login'];
    $mdp = $_POST['mdp'];
    $role = $_POST['role'];
    $req = "UPDATE user set login = '$login', password = '$mdp', id_role = $role WHERE id_user = $id";
    $res = $mysqli->query($req);
    header('Location: ../utilisateurs.php');
}
$req = "SELECT * FROM user where id_user = $id";
$res = $mysqli->query($req);
$user = $res->fetch_all();
?>
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <form method="POST" action="">
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4">
                Login<input value="<?php echo $user[0][1] ?>" name="login" type="text" class="form-control" required>
                Mot de passe<input value="<?php echo $user[0][2] ?>" name="mdp" type="password" class="form-control" required>
                Role<input value="<?php echo $user[0][3] ?>" name="role" type="number" class="form-control" required>
                <button class="btn" type="submit">Modifier</button>
            </div>
        </div>
        </div>
    </form>
    <a href="../utilisateurs.php"><button class="btn">Retour</button></a>
</body>

</html>
<?php

// header('Location: ../Utilisateurs.php');
