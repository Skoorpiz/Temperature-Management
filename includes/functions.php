<?php
function moy($mysqli, $ville)
{

    $req = "SELECT COUNT(DISTINCT id_annee) FROM temperature WHERE id_ville = $ville;";
    $res = $mysqli->query($req);
    $countAnnee = $res->fetch_row();

    for ($i = 1; $i <= 12; $i++) {
        $req = "SELECT SUM(valeur) / $countAnnee[0]  FROM temperature WHERE id_mois = $i AND id_ville = $ville;";
        $res = $mysqli->query($req);
        $a_temp[$i] = $res->fetch_row();
        $a_temp[$i][0] = number_format(($a_temp[$i][0]), 0, '.', '');
    }
    return $a_temp;
}
function moyMulti($mysqli, $a_ville)
{
    for ($n = 0; $n < count($a_ville); $n++) {

        $req = "SELECT COUNT(DISTINCT id_annee) FROM temperature WHERE id_ville = $a_ville[$n];";
        // echo "<pre>";
        // echo $req;
        // echo "<pre>";
        $res = $mysqli->query($req);
        $countAnnee[] = $res->fetch_row();
        for ($i = 1; $i <= 12; $i++) {
            $nbAnnee[$n] = $countAnnee[$n][0];
            $req = "SELECT SUM(valeur) / $nbAnnee[$n]  FROM temperature WHERE id_mois = $i AND id_ville = $a_ville[$n];";
            // echo $req;
            $res = $mysqli->query($req);
            $a_temp[$n][$i] = $res->fetch_row();
            $a_temp[$n][$i][0] = number_format(($a_temp[$n][$i][0]), 0, '.', '');
        }
    }
    return $a_temp;
}
function maxim($mysqli, $ville)
{

    for ($i = 1; $i <= 12; $i++) {
        $req = "SELECT MAX(valeur) FROM temperature WHERE id_mois = $i AND id_ville = $ville;";
        $res = $mysqli->query($req);
        $a_max[$i] =  $res->fetch_row();
    }
    return $a_max;
}
function minim($mysqli, $ville)
{
    for ($i = 1; $i <= 12; $i++) {
        $req = "SELECT MIN(valeur) FROM temperature WHERE id_mois = $i AND id_ville = $ville;";
        $res = $mysqli->query($req);
        $a_min[$i] =  $res->fetch_row();
    }
    return $a_min;
}
function mois($mysqli)
{
    for ($i = 1; $i <= 12; $i++) {
        $req = "SELECT libelle FROM mois WHERE id_mois = $i;";
        $res = $mysqli->query($req);
        $a_mois[$i] =  $res->fetch_row();
    }
    return $a_mois;
}
function ecrire_log($debugg)
{
    $date = date("Y-m-d H:i:s");
    $errorMessage = $date . $debugg . "\n";
    $logFile = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR .  "logs" . DIRECTORY_SEPARATOR . "logs.log";
    error_log($errorMessage, 3, $logFile);
}
