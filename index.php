<?php

require('Observation.php');
$user="root";
$pass="";
$dbname="zarlor";
$host="localhost";

$db=new PDO("mysql:host=$host;dbname=$dbname",$user,$pass);


session_start();

if(isset($_SESSION['observations'])){
    $observations = $_SESSION['observations'];
}else {
    $observations=array();
    $_SESSION['observations']=$observations;
}


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.css" />

</head>
<body>

<form action="index.php" method="get">
    <label for="search">Rechercher</label>
    <input type="text" name="search" id="search">
    <input type="submit" value="Search" >
</form>

    <form class="card p-4 shadow-sm" action="" method="post">
        <div class="mb-3">
            <label for="nom_commun" class="form-label">Nom commun</label>
            <input type="text" name="nom_commun" id="nom_commun" class="form-control" required
                   value="">
        </div>

        <div class="mb-3">
            <label for="nom_scientifique" class="form-label">Nom scientifique</label>
            <input type="text" name="nom_scientifique" id="nom_scientifique" class="form-control" required
                   value="">
        </div>

        <div class="mb-3">
            <label for="nb_individus" class="form-label">Nombre d'individus</label>
            <input type="number" name="nb_individus" id="nb_individus" class="form-control" required
                   value="">
        </div>
        <div class="mb-3">
            <label for="zone_observation" class="form-label">Zone d'observation</label>
            <input type="text" name="zone_observation" id="zone_observation" class="form-control" required
                   value="">
        </div>
        <div class="mb-3">
            <label for="milieu_naturel" class="form-label">Milieu naturel</label>
            <input type="text" name="milieu_naturel" id="milieu_naturel" class="form-control" required
                   value="">
        </div>
        <div class="mb-3">
            <label for="nom_observateur" class="form-label">Nom observateur</label>
            <input type="text" name="nom_observateur" id="nom_observateur" class="form-control" required
                   value="">
        </div>
        <div class="mb-3">
            <label for="date_observation" class="form-label">Date observation</label>
            <input type="date" name="date_observation" id="date_observation" class="form-control" required
                   value="">
        </div>

        <button type="submit" class="btn btn-primary w-100">Envoyer</button>
    </form>


<table id="myTable" class="display" style="width:100%">
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


    // recupere les infos et instanciation de la variable voiture
    if (isset($_POST["nom_commun"], $_POST["nom_scientifique"], $_POST["nb_individus"], $_POST["zone_observation"], $_POST["milieu_naturel"],$_POST["nom_observateur"],$_POST["date_observation"] )) {
        $nom_commun = $_POST["nom_commun"];
        $nom_scientifique = $_POST["nom_scientifique"];
        $nb_individus = $_POST["nb_individus"];
        $zone_observation = $_POST["zone_observation"];
        $milieu_naturel = $_POST["milieu_naturel"];
        $nom_observateur = $_POST["nom_observateur"];
        $date_observation = $_POST["date_observation"];

        $observation = new Observation($nom_commun, $nom_scientifique, $nb_individus, $zone_observation, $milieu_naturel, $nom_observateur, $date_observation);

        // ajoute dans le tableau de la session
        $_SESSION["observations"][] = $observation;
    }




    /* if(isset($_GET['search'])){
         $requete=$db->prepare("select * from client
          where nom like ?  or
          prenom like ?");
         $valeur="%".$_GET['search']."%";
         $requete->bindParam(1,$valeur);
         $requete->bindParam(2, $valeur);
         $requete->execute();

         /*  $requete=$db->prepare("select * from client
            where nom like :nom  or
            prenom like :prenom");
           $valeur="%".$_GET['search']."%";
           $requete->bindParam("nom",$valeur);
           $requete->bindParam("prenom", $valeur);
           $requete->execute();
     }
     else $requete=$db->query("select * from client"); */

    $requete=$db->query("select * from observations");

    $requete->setFetchMode(PDO::FETCH_CLASS,'Observation');

    $observations=$requete->fetchAll();


    foreach ($observations as $observation) {

        echo "<tr>
    <td>".$observation->getId()."</td> 
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



<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>

</body>
</html>
