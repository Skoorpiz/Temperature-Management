<?php
include_once '../bdd/bdd.php';
include_once '../majOffice.php';
$download = 'fichiers';
$historique = 'historique';
$ville = $_POST['ville'];
$a_total = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
$debug = false;
?>
<html lang="en">

<head>
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../amcharts4/core.js" type="text/javascript"></script>
    <script src="../amcharts4/charts.js" type="text/javascript"></script>
    <script src="../amcharts4/themes/animated.js" type="text/javascript"></script>
    <link href="../css/styles.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<style>
    #chartdiv1 {
        width: 100%;
        height: 500px;
    }

    #chartdiv2 {
        width: 100%;
        height: 500px;
    }
</style>

<body>
    <?php
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
        $allowed = array("csv" => "text/csv");
        $filename = $_FILES["file"]["name"];
        $filetype = $_FILES["file"]["type"];
        $filesize = $_FILES["file"]["size"];

        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed))
            die("Erreur : Veuillez sélectionner un format de fichier valide.");
        // if (in_array($filetype, $allowed)) {
        if (file_exists($_FILES["file"]["name"])) {
            echo $_FILES["file"]["name"] . " existe déjà.";
        } else {
            move_uploaded_file($_FILES["file"]["tmp_name"], "$download/$filename");
            if ($debug == true) {
                echo "Votre fichier a été téléchargé avec succès.";
            }
    ?>
            <?php
            if ($debug == true) {
                echo "<br>";
                echo "Nom du fichier : " . $filename;
                echo "<br>";
                echo "Taille du fichier : " . $filesize;
                echo "<br>";
                echo "Type du fichier : " . $filetype;
            }
        }
        // } else {
        //     echo "Error: Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer.";
        // }
    } else {
        echo "Error: " . $_FILES["file"]["error"];
    }

    $file = __DIR__ . DIRECTORY_SEPARATOR .  "fichiers" . DIRECTORY_SEPARATOR .   "$filename";
    if (file_exists($file)) {

        $handle = fopen($file, 'r');
        $nb = 0;

        if ($handle) {
            while (!feof($handle)) {

                $ligne = fgetcsv($handle);

                if ($nb == 0) {
                    $a_mois = $ligne;
                    // for ($i = 1; $i <= 12; $i++) {

                    // $req = "INSERT INTO mois (libelle) VALUES ('$ligne[$i]');";
                    // $res = $mysqli->query($req);

                    // }

                    $nb++;
                } else {
                    if (is_array($ligne)) {
                        for ($i = 1; $i <= 12; $i++) {
                            $a_temp[$i][] = $ligne[$i];
                            $a_total[$i] += $ligne[$i];
                        }

                        $req = "SELECT valeur FROM annee WHERE valeur = {$ligne[0]} ";
                        $res = $mysqli->query($req);
                        if ($debug == true) {
                            echo $req . "<br>";
                        }
                        $row = $res->fetch_assoc();
                        $annee = $row['valeur'];



                        if (!$annee) {

                            $req = "INSERT INTO annee (valeur) VALUES ('$ligne[0]');";
                            $res = $mysqli->query($req);
                            if ($debug == true) {
                                echo $req . "<br>";
                            }
                            // $idAnnee = mysqli_insert_id($mysqli);
                        }

                        $req = "SELECT id_annee FROM annee WHERE valeur = $ligne[0]";
                        $res = $mysqli->query($req);
                        $idAnnee = $res->fetch_row();

                        $req = "SELECT valeur FROM temperature WHERE id_ville = $ville AND id_annee = $idAnnee[0]";
                        if ($debug == true) {
                            echo $req . "<br>";
                        }
                        $res = $mysqli->query($req);
                        $verif = $res->fetch_row();

                        if ($verif[0] == null) {

                            for ($i = 1; $i <= 12; $i++) {

                                $req = "INSERT INTO temperature (valeur,id_ville,id_annee,id_mois) VALUES ('$ligne[$i]','$ville','$idAnnee[0]','$i');";
                                if ($debug == true) {
                                    echo $req . "<br>";
                                }
                                $res = $mysqli->query($req);
                            }
                        } else {
                            for ($i = 1; $i <= 12; $i++) {

                                $req = "UPDATE temperature set valeur = $ligne[$i] WHERE id_annee = $idAnnee[0] AND id_mois = $i AND id_ville = $ville;";
                                if ($debug == true) {
                                    echo $req . "<br>";
                                }
                                $res = $mysqli->query($req);
                            }
                        }

                        $nb++;
                    }
                }
            }
            for ($i = 1; $i <= 12; $i++) {
                $a_total[$i] = $a_total[$i] / ($nb - 1);
                $a_max[$i] = max($a_temp[$i]);
                $a_min[$i] = min($a_temp[$i]);
            }
            fclose($handle);
            $nb = $nb - 1;
            ?>
            <div class="col-2">
            <?php
            echo "Vous avez inséré " . $nb . " années";
            ?>

            <br><br><button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Visualiser les données intégrées</button>

            <!-- Modal -->
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Données intégrées</h4>
                        </div>
                        <div class="modal-body">
                            <H2>Moyenne des températures</H2>
                            <div id="chartdiv1"></div>
                            <H2>Maximum et Minimum des températures</H2>
                            <div id="chartdiv2"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>

                </div>
            </div>
            </div>
            </div>
            </div>
    <?php
            $fileMoved  = rename("$download/$filename", "$download/$historique/$filename");
        }
    } else {
        echo "erreur le fichier est introuvable";
    }
    ?>
</body>

</html>
<script>
    am4core.ready(function() {
        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end
        var chart = am4core.create("chartdiv1", am4charts.XYChart);
        var value;
        var date;
        var data = [];
        <?php
        $compteur = 0;
        for ($i = 1; $i <= 12; $i++) {
        ?>
            value = <?php echo $a_total[$i] ?>;
            date = new Date();
            date.setFullYear(0, <?php echo $compteur ?>);
            data.push({
                date: date,
                value: value
            });
        <?php
            $compteur++;
        }
        //                var data = [
        //<?php
        //for ($i = 1; $i <= 12; $i++) {
        //    echo "[" . $i . "," . $a_total[$i] . "],";
        //}
        //
        ?>
        //                ];
        chart.data = data;
        console.log(data);
        // Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        dateAxis.renderer.minGridDistance = 60;

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

        // Create series
        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "value";
        series.dataFields.dateX = "date";
        series.tooltipText = "{value}"

        series.tooltip.pointerOrientation = "vertical";

        chart.cursor = new am4charts.XYCursor();
        chart.cursor.snapToSeries = series;
        chart.cursor.xAxis = dateAxis;

        //chart.scrollbarY = new am4core.Scrollbar();
        chart.scrollbarX = new am4core.Scrollbar();

    }); // end am4core.ready()
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        var chart = am4core.create("chartdiv2", am4charts.XYChart);

        var data = [];
        var names = [
            <?php
            for ($i = 1; $i <= 12; $i++) {
                echo "'" . $a_mois[$i] . "'" . ",";
            }
            ?>
        ];
        <?php
        $nb = -1;
        for ($i = 1; $i <= 12; $i++) {
            $nb++;
        ?>
            open = <?php echo $a_max[$i] ?>;
            close = <?php echo $a_min[$i] ?>;
            data.push({
                category: names[<?php echo $nb ?>],
                open: open,
                close: close
            });

        <?php
        }
        ?>
        chart.data = data;
        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.renderer.grid.template.location = 0;
        categoryAxis.dataFields.category = "category";
        categoryAxis.renderer.minGridDistance = 15;
        categoryAxis.renderer.grid.template.location = 0.5;
        categoryAxis.renderer.grid.template.strokeDasharray = "1,3";
        categoryAxis.renderer.labels.template.rotation = -90;
        categoryAxis.renderer.labels.template.horizontalCenter = "left";
        categoryAxis.renderer.labels.template.location = 0.5;
        categoryAxis.renderer.inside = true;

        categoryAxis.renderer.labels.template.adapter.add("dx", function(dx, target) {
            return -target.maxRight / 2;
        })

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.tooltip.disabled = true;
        valueAxis.renderer.ticks.template.disabled = true;
        valueAxis.renderer.axisFills.template.disabled = true;

        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.categoryX = "category";
        series.dataFields.openValueY = "open";
        series.dataFields.valueY = "close";
        series.tooltipText = "open: {openValueY.value} close: {valueY.value}";
        series.sequencedInterpolation = true;
        series.fillOpacity = 0;
        series.strokeOpacity = 1;
        series.columns.template.width = 0.01;
        series.tooltip.pointerOrientation = "horizontal";

        var openBullet = series.bullets.create(am4charts.CircleBullet);
        openBullet.locationY = 1;

        var closeBullet = series.bullets.create(am4charts.CircleBullet);

        closeBullet.fill = chart.colors.getIndex(4);
        closeBullet.stroke = closeBullet.fill;

        chart.cursor = new am4charts.XYCursor();

        chart.scrollbarX = new am4core.Scrollbar();
        chart.scrollbarY = new am4core.Scrollbar();


    }); // end am4core.ready()
</script>