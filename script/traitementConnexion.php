<?php
session_start();
// error_reporting(E_ALL);
// ini_set("display_errors", 1);
include_once '../bdd/bdd.php';
include_once '../includes/functions.php';
$id = $_POST['id'];
$password = $_POST['password'];
$req = "SELECT login,password,id_role FROM user WHERE login = '$id'  AND password = '$password'";
$res = $mysqli->query($req);
$user = $res->fetch_row();
if ($user) {
    $_SESSION['id'] = $id;
    $_SESSION['role'] = $user[2];
    header('Location: ../majOffice.php');
} else {
    $debugg = " [INFO] Identifiant ou mot de passe invalide lors de la connexion.";
    ecrire_log($debugg);
?>
     <div>Erreur, identifiant ou mot de passe invalide</div>
    <a href="../maj.php"><button>Retour à la connexion</button></a>
<?php
}
