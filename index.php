<?php
include_once 'bdd/bdd.php';
include_once 'includes/functions.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
if (isset($_POST['ville'])) {
    if ($id == 1) {
        $ville = $_POST['ville'];
        $a_temp = moy($mysqli, $ville);
        $a_min = minim($mysqli, $ville);
        $a_max = maxim($mysqli, $ville);
    } else if ($id == 2) {
        $a_ville = $_POST['ville'];
        $a_temp = moyMulti($mysqli, $a_ville);
        for ($n = 0; $n < count($a_ville); $n++) {
            $req = "SELECT libelle FROM ville WHERE id_ville = $a_ville[$n];";
            $res = $mysqli->query($req);
            $nomVille[] = $res->fetch_row();
        }
        $color = array('#ff0000', '#00ff00', '#002BFF', '#F0E71E', '#E01EF0');
    }
}
$a_mois = mois($mysqli);
$req = "SELECT libelle,ville.id_ville,count(*) FROM ville,temperature WHERE ville.id_ville = temperature.id_ville
GROUP BY temperature.id_ville";
$res = $mysqli->query($req);
$infoVille = $res->fetch_all();
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
    <script src="amcharts4/core.js" type="text/javascript"></script>
    <script src="amcharts4/charts.js" type="text/javascript"></script>
    <script src="amcharts4/themes/animated.js" type="text/javascript"></script>
    <link href="css/styles.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <script type="text/javascript" src="//code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>


</head>
<script>
var form1 = '<form action="index.php?id=1" method="POST">\
    <p>* Ville (nombre de températures)</p>\
    <select class="form-control" name="ville">\
    <option value="">Choisissez une ville</option>\
        <?php for ($i = 0; $i < count($infoVille); $i++): ?>
            <option value="<?php echo $infoVille[$i][1]  ?>">\
                <?php echo $infoVille[$i][0] . " (" . $infoVille[$i][2] . ")"  ?>\
            </option>\
        <?php endfor; ?>
    </select>\
    <br>\
    <button class="btn btn-primary" type="submit">Valider</button>\
</form>';

var form2 = '<form action="index.php?id=2" method="POST">\
    <span id="printVerif"></span>\
    <p>* Ville (nombre de températures)</p>\
    <select id="multipleSelect" data-max-options="4" multiple data-style="bg-white rounded-pill px-4 py-3 shadow-sm " name="ville[]" class="selectpicker w-100">\
        <?php
        for ($i = 0; $i < count($infoVille); $i++) {
        ?>
            <option value="<?php echo $infoVille[$i][1]  ?>">\
                <?php echo $infoVille[$i][0] . " (" . $infoVille[$i][2] . ")"  ?>\
            </option>\
        <?php } ?>
    </select>\
    <br>\
    <br>\
    <button id="btSubmit" class="btn btn-primary" type="submit">Valider</button>\
</form>';
</script>
<body>
    <H2>Températures</H2>
    <div class="row">
        <div class="col-md-2">
                <p>Type d'affichages</p>
                <select  onChange="change(this.value)" class="form-control" >
                    <option value="">Choisissez un type d'affichage</option>
                    <option <?php if (isset($id) && $id == 1){ ?> selected <?php } ?> value="1">Moyenne + Min + Max</option>
                    <option <?php if (isset($id) && $id == 2){ ?> selected <?php } ?> value="2">Multi villes</option>
                </select>
                <br>
                <!-- <button class="btn btn-primary" type="submit">Selectionner</button> -->
            <span id="afficherFormulaire"></span>
        </div>
    </div>
    <?php
    if (!empty($_POST['ville'])) {
    ?>
        <H2>Températures</H2>
        <div id="chartdiv3"></div>
    <?php
    }
    ?>


</body>
<script>

// function loadMaxVille(max){
//     console.log(max);
//     var bt = document.getElementById('btSubmit');
//         if ($("#multipleSelect option:selected").length > max) {
//             $("#printVerif").text('Le maximum de villes est de 5');
//             bt.disabled = true;
//         } else {
//             bt.disabled = false;
//         }
// }
    function change(val) {
        val = parseInt(val);
        switch (val) {
            case 1:
                console.log(form1);
                $("#afficherFormulaire").html(form1);
                break;
            case 2:
                $("#afficherFormulaire").html(form2);
                $('.selectpicker').selectpicker();
                // loadMaxVille(5);
                console.log(form2);
                break;
        }
    }
</script>

</html>
<?php
if (isset($id)){
include_once 'script/traitementAmcharts.php';
}