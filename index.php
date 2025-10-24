<?php

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="style.css">

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="#">🌿 Zarlor Biodiversité</a>
    </div>
</nav>

<div class="container">
    <h1 class="text-center mb-4">Recensement des espèces de La Réunion</h1>

    <div class="card shadow-sm mb-4 p-3">
        <form action="index.php" method="get" class="d-flex flex-column flex-sm-row align-items-center gap-2">
            <label for="search" class="form-label me-2 mb-0">🔍 Rechercher :</label>
            <input type="text" name="search" id="search" class="form-control w-50" placeholder="Entrez un nom scientifique ou commun">
            <button type="submit" class="btn btn-success">Rechercher</button>
        </form>
    </div>

    <div class="card p-4 shadow-sm mb-4">
        <form action="index.php" method="post">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nom_commun" class="form-label">Nom commun</label>
                    <input type="text" name="nom_commun" id="nom_commun" class="form-control" required value="">
                </div>
                <div class="col-md-6">
                    <label for="nom_scientifique" class="form-label">Nom scientifique</label>
                    <input type="text" name="nom_scientifique" id="nom_scientifique" class="form-control" required value="">
                </div>
                <div class="col-md-4">
                    <label for="nb_individus" class="form-label">Nombre d'individus</label>
                    <input type="number" name="nb_individus" id="nb_individus" class="form-control" required value="">
                </div>
                <div class="col-md-4">
                    <label for="zone_observation" class="form-label">Zone d'observation</label>
                    <input type="text" name="zone_observation" id="zone_observation" class="form-control" required value="">
                </div>
                <div class="col-md-4">
                    <label for="milieu_naturel" class="form-label">Milieu naturel</label>
                    <input type="text" name="milieu_naturel" id="milieu_naturel" class="form-control" required value="">
                </div>
                <div class="col-md-6">
                    <label for="nom_observateur" class="form-label">Nom observateur</label>
                    <input type="text" name="nom_observateur" id="nom_observateur" class="form-control" required value="">
                </div>
                <div class="col-md-6">
                    <label for="date_observation" class="form-label">Date d'observation</label>
                    <input type="date" name="date_observation" id="date_observation" class="form-control" required value="">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-4 w-100">Envoyer</button>
        </form>
    </div>

    <div class="table-responsive">
        <table id="myTable" class="display table table-striped table-bordered align-middle text-center" style="width:100%">
            <thead>
            <tr>
                <th>Id</th>
                <th>Nom commun</th>
                <th>Nom Scientifique</th>
                <th>Nombre d'individus</th>
                <th>Zone d'observation</th>
                <th>Milieu naturel</th>
                <th>Nom observateur</th>
                <th>Date d'observation</th>
            </tr>
            </thead>

            <tbody>


    <?php
    // Chargement du fichier classe observation
    require('Observation.php');

    // Information de connexion pour la base de données
    $user="root";
    $pass="";
    $dbname="zarlor";
    $host="localhost";

    // Instanciation de la classe PDO pour la connexion avec la base de données, db devient l'objet PDO qui represente la connexion
    $db=new PDO("mysql:host=$host;dbname=$dbname",$user,$pass);

    // Lancement de la session pour recuperer les données existantes si session existe
    //session_start();

    if(isset($_SESSION['observations'])){
        $observations = $_SESSION['observations'];
    }else {
        $observations=array();
        $_SESSION['observations']=$observations;
    }


    // recupere les infos apres la requete POST du formulaire
    if (isset(
            $_POST["nom_commun"],
            $_POST["nom_scientifique"],
            $_POST["nb_individus"], $_POST["zone_observation"],
            $_POST["milieu_naturel"],$_POST["nom_observateur"],
            $_POST["date_observation"] )) {
        $nom_commun = $_POST["nom_commun"];
        $nom_scientifique = $_POST["nom_scientifique"];
        $nb_individus = $_POST["nb_individus"];
        $zone_observation = $_POST["zone_observation"];
        $milieu_naturel = $_POST["milieu_naturel"];
        $nom_observateur = $_POST["nom_observateur"];
        $date_observation = $_POST["date_observation"];

        // Instanciation de la classe observation contenant les informations de l'observation
        $observation = new Observation($nom_commun, $nom_scientifique, $nb_individus, $zone_observation, $milieu_naturel, $nom_observateur, $date_observation);

        $observation->insert($db);

        // ajoute dans le tableau de la session l'objet observation
        $_SESSION["observations"][] = $observation;
    }


     if(isset($_GET['search'])){
         $requete=$db->prepare("select * from observations
          where nom_commun like ?  or
          nom_scientifique like ?");
         $valeur="%".$_GET['search']."%";
         $requete->bindParam(1,$valeur);
         $requete->bindParam(2, $valeur);
         $requete->execute();
     }
     else $requete=$db->query("select * from observations");

    $observations=$requete->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,  "Observation");

//    echo "<pre>";
//    var_dump($observations[0]);
//    echo "</pre>";

//    //transforme chaque ligne en objet de la classe observation
//    $requete->setFetchMode(PDO::FETCH_CLASS,'Observation');
//
//    // Recuperation de toutes les lignes
//    $observations=$requete->fetchAll();

    //boucle sur toutes lignes recupérées pour recuperer chaque observation
    foreach ($observations as $observation) {

        echo "<tr>
    <td>".$observation->getIdObservation()."</td> 
    <td>".$observation->getNomCommun()."</td> 
    <td>".$observation->getNomScientifique()."</td> 
    <td>".$observation->getNbIndividus()."</td>
    <td>".$observation->getZoneObservation()."</td> 
    <td>".$observation->getMilieuNaturel()."</td>
    <td>".$observation->getNomObservateur()."</td>
    <td>".$observation->getDateObservation()."</td>
</tr>";
    }
    ?>

            </tbody>
        </table>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let table = new DataTable('#myTable', {
        language: {
            url: '//cdn.datatables.net/plug-ins/2.3.4/i18n/fr-FR.json',
        },
    });
</script>

</body>
</html>