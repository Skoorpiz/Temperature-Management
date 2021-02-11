<?php
include_once '../bdd/bdd.php';

$id = $_GET['id'];
$req = "DELETE FROM ville WHERE id_ville = $id";
$res = $mysqli->query($req);
header('Location: ../villes.php');
