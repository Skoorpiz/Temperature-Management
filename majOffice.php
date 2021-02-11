<?php
session_start();
include_once 'bdd/bdd.php';
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
    ?>
        <H3 class='space-text bold'>BACKOFFICE</H3>
        <div class='container-fluid'>
            <div class='row'>
                <div class="col-2">
                    <a href="/edsa-formation/utilisateurs.php"><button class="btn">UTILISATEURS</button></a><br><br>
                    <a href="/edsa-formation/donnees.php"><button class="btn">DONNEES</button></a><br><br>
                    <a href="/edsa-formation/villes.php"><button class="btn">VILLES</button></a><br><br>
                    <a href="/edsa-formation/script/traitementDeconnexion.php"><button class="btn top-navbar">DECONNEXION</button></a>
                </div>

            <?php
        } else if (!isset($_SESSION['role'])) {
            $debugg = " [WARNING] Accès refusé au backoffice, connexion manquante";
            ecrire_log($debugg);
            ?>
                <div>Erreur, vous devez vous connecter</div>
                <a href="index.php"><button>Retour à l'accueil</button></a>
            <?php
        } else if ($_SESSION['role'] != 1) {
            $debugg = " [WARNING] Accès refusé au backoffice, l'utilisateur n'a pas l'autorisation";
            ecrire_log($debugg);
            ?>
                <div>Erreur, vous n'avez pas accès à cette page !</div>
                <a href="index.php"><button>Retour à l'accueil</button></a>
            <?php

        }
            ?>

</body>

</html>