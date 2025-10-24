<?php

class Observation
{
    private $id;

    private $nom_commun;

    private $nom_scientifique;

    private $nb_individus;

    private $zone_observation;

    private $milieu_naturel;

    private $nom_observateur;

    private $date_observation;

    public function __construct( $nom_commun, $nom_scientifique, $nb_individus, $zone_observation, $milieu_naturel, $nom_observateur, $date_observation){
    $this->nom_commun = $nom_commun;
    $this->nom_scientifique = $nom_scientifique;
    $this->nb_individus = $nb_individus;
    $this->zone_observation = $zone_observation;
    $this->milieu_naturel = $milieu_naturel;
    $this->nom_observateur = $nom_observateur;
    $this->date_observation = $date_observation;

    }
    public function insert($db) {
        $sql= "INSERT INTO observations (nom_commun, nom_scientifique, nb_individus, zone_observation, milieu_naturel, nom_observateur, date_observation ) 
              VALUES (:nom_commun, nom_scientifique, nb_individus, zone_observation, :milieu_naturel, :nom_observateur, :date_observation)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':nom_commun', $this->nom_commun);
        $stmt->bindParam(':nom_scientifique', $this->nom_scientifique);
        $stmt->bindParam(':nb_individus', $this->nb_individus);
        $stmt->bindParam(':zone_observation', $this->zone_observation);
        $stmt->bindParam(':milieu_naturel', $this->milieu_naturel);
        $stmt->bindParam(':nom_observateur', $this->nom_observateur);
        $stmt->bindParam(':date_observation', $this->date_observation);

        $stmt->execute();

    }



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNomCommun()
    {
        return $this->nom_commun;
    }

    /**
     * @param mixed $nom_commun
     */
    public function setNomCommun($nom_commun)
    {
        $this->nom_commun = $nom_commun;
    }

    /**
     * @return mixed
     */
    public function getNomScientifique()
    {
        return $this->nom_scientifique;
    }

    /**
     * @param mixed $nom_scientifique
     */
    public function setNomScientifique($nom_scientifique)
    {
        $this->nom_scientifique = $nom_scientifique;
    }

    /**
     * @return mixed
     */
    public function getNbIndividus()
    {
        return $this->nb_individus;
    }

    /**
     * @param mixed $nb_individus
     */
    public function setNbIndividus($nb_individus)
    {
        $this->nb_individus = $nb_individus;
    }

    /**
     * @return mixed
     */
    public function getZoneObservation()
    {
        return $this->zone_observation;
    }

    /**
     * @param mixed $zone_observation
     */
    public function setZoneObservation($zone_observation)
    {
        $this->zone_observation = $zone_observation;
    }

    /**
     * @return mixed
     */
    public function getMilieuNaturel()
    {
        return $this->milieu_naturel;
    }

    /**
     * @param mixed $milieu_naturel
     */
    public function setMilieuNaturel($milieu_naturel)
    {
        $this->milieu_naturel = $milieu_naturel;
    }

    /**
     * @return mixed
     */
    public function getNomObservateur()
    {
        return $this->nom_observateur;
    }

    /**
     * @param mixed $nom_observateur
     */
    public function setNomObservateur($nom_observateur)
    {
        $this->nom_observateur = $nom_observateur;
    }

    /**
     * @return mixed
     */
    public function getDateObservation()
    {
        return $this->date_observation;
    }

    /**
     * @param mixed $date_observation
     */
    public function setDateObservation($date_observation)
    {
        $this->date_observation = $date_observation;
    }



    public function __toString(){
    // TODO: Implement __toString() method.
    }


}