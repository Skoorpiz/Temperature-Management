<?php
include_once '../bdd/bdd.php';

$id = $_GET['id'];

if (isset($_POST['libelle'])) {
    $libelle = $_POST['libelle'];
    $req = "UPDATE ville set libelle = '$libelle' WHERE id_ville = $id";
    $res = $mysqli->query($req);
    header('Location: ../villes.php');
}
$req = "SELECT * FROM ville where id_ville = $id";
$res = $mysqli->query($req);
$ville = $res->fetch_all();
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
                Libelle<input value="<?php echo $ville[0][1] ?>" name="libelle" type="text" class="form-control" required>
                <button class="btn" type="submit">Modifier</button>
            </div>
        </div>
        </div>
    </form>
    <a href="../villes.php"><button class="btn">Retour</button></a>
</body>

</html>
<?php

// header('Location: ../Utilisateurs.php');
