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
</head>

<body>
    <?php
    if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
        $req = "SELECT COUNT(libelle) FROM ville";
        $res = $mysqli->query($req);
        $countVille = $res->fetch_row();

        $req = "SELECT * FROM ville ";
        $res = $mysqli->query($req);
        $ville = $res->fetch_all();
    ?>
        <div class="col-2">
            <form action="script/traitementUpload.php" method="post" enctype="multipart/form-data">
                <h2>Upload Fichier</h2>
                <label for="fileUpload">Fichier:</label>
                <input type="file" name="file" id="fileUpload">
                <br><br>
                <input class="btn" type="submit" name="submit" value="Upload">
                <p><strong>Note:</strong> Seuls les formats .csv </p>
                <select class="form-control" name="ville">
                    <?php
                    for ($i = 0; $i < $countVille[0]; $i++) {
                    ?>
                        <option value="<?php echo $ville[$i][0] ?>">
                            <?php echo $ville[$i][1] ?>
                        </option>
                    <?php } ?>
                </select>
            </form>
            </div>
        </div>
        </div>
            <!-- <h2>Insertion de données</h2> -->
        <?php
    } else if (!isset($_SESSION['role'])) {
        $debugg = " [WARNING] Accès refusé à la gestion des données, connexion manquante";
        ecrire_log($debugg);
    } else if ($_SESSION['role'] != 1) {
        $debugg = " [WARNING] Accès refusé à la gestion des données, l'utilisateur n'a pas l'autorisation";
        ecrire_log($debugg);

    }
    // $download = 'script/fichiers';
    // if ($handle = opendir($download)) {
    // while (false !== ($entry = readdir($handle))) {
    //     if ($entry != "." && $entry != "..") {
        ?>
        <!-- <form method="POST" action="script/traitementDonnees.php">
                    <input type="hidden" name="nomFichier" value="<?php
                                                                    // echo "$entry"; 
                                                                    ?>"
                    
                        <span><?php
                                // echo "$entry\n";  
                                ?></span>
                        <select name="ville">
                            <?php
                            // for ($i = 0; $i < $countVille[0]; $i++) {
                            ?>
                                <option value="<?php
                                                //  echo $ville[$i][0] 
                                                ?>" >
                                    <?php
                                    //   echo $ville[$i][1] 
                                    ?>
                                </option>
                            <?php
                            //  } 
                            ?>
                        </select>
                        <button type="submit">Sélectionner</button><br><br>
                    </form> -->
        <?php
        //         }
        //     }
        //     closedir($handle);
        // }
        ?>
        
</body>

</html>