<?php
include_once '../bdd/bdd.php';

$id = $_GET['id'];
$req = "DELETE FROM user WHERE id_user = $id";
$res = $mysqli->query($req);
header('Location: ../utilisateurs.php');
