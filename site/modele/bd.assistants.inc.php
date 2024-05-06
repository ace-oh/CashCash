<?php

include_once "bd.inc.php";

// Fonction pour récupérer les IDs de tous les clients

function getAllClientIds() {
    $resultat = array();

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT idClient FROM client");
        $req->execute();

        $resultat = $req->fetchAll(PDO::FETCH_COLUMN);
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }

    return $resultat;
}

// Fonction pour récupérer les IDs de tous les techniciens
function getAllTechnicianIds() {
    $resultat = array();

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("select id from personnels join role on personnels.emploi = role.idRôle where personnels.emploi=2");
        $req->execute();

        $resultat = $req->fetchAll(PDO::FETCH_COLUMN);
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }

    return $resultat;
}


/* Fonction pour affecter intervetion */


function formulaireIntervention(){
    if(verifAgences()==true) {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_button"])) {

            $idClient = $_POST["idClient"];
            $dateDebut = $_POST["dateDebut"];
            $dateFin = $_POST["dateFin"];
            $idTechnicien = $_POST["idTechnicien"];
        
            if (empty($idClient) || empty($dateDebut) || empty($dateFin) || empty($idTechnicien)) {
                echo "Impossible d'affecter une intervention car l'un des champs n'est pas renseigné";
            } else {
                // Vérifier si dateFin est avant dateDebut
                if (strtotime($dateFin) < strtotime($dateDebut)) {
                    echo "La date de fin ne peut pas être avant la date de début.";
                } else {
                    executionFormulaire();
                }
            }
        } else {
            echo "Le formulaire n'a pas été soumis.";
        }
    } else {
        echo "Le client et le technicien n'appartiennent pas à la même agence.";
    }
}


function executionFormulaire(){
    try {
        $cnx = connexionPDO();
        $idInter = genererIdInterventionUnique();
        $idTechnicien = verifierIdTechnicien();
        $idClient = verifierIdClient();
        $dateDebut = verifierDateDebut();
        $dateFin = verifierDateFin();
        $commentInter = "";
        
        // Condition pour déterminer la valeur de $etat
        if (strtotime($dateDebut) == strtotime(date('Y-m-d'))) {
            $etat = "En cours";
        } else {
            $etat = "Non débuté";
        }

        $query = "INSERT INTO intervention (idInter, clientInter, dateInter, dateFinInter, commentInter, idTech, etat) 
                  VALUES (:idInter, :idClient, :dateDebut, :dateFin, :commentInter, :idTechnicien, :etat)";
        
        $stmt = $cnx->prepare($query);

        // Liens entre les paramètres et les valeurs
        $stmt->bindParam(':idInter', $idInter, PDO::PARAM_STR);
        $stmt->bindParam(':idClient', $idClient, PDO::PARAM_INT);
        $stmt->bindParam(':dateDebut', $dateDebut);
        $stmt->bindParam(':dateFin', $dateFin);
        $stmt->bindParam(':commentInter', $commentInter, PDO::PARAM_STR);
        $stmt->bindParam(':idTechnicien', $idTechnicien, PDO::PARAM_STR);
        $stmt->bindParam(':etat', $etat, PDO::PARAM_STR); // Correction ici

        // Exécution de la requête
        $stmt->execute();
        echo "Insertion réussie";

    } catch (PDOException $e) {
        // Gérer les erreurs en affichant un message (à adapter selon vos besoins)
        print "Erreur !: " . $e->getMessage();
        die();
    }
}


function verifAgences(){
    $idAgencesClient=recupererIdAgenceClient();
    $idAgencesTechnicien=recupererIdAgenceTechnicien();

    if($idAgencesClient==$idAgencesTechnicien){
        return true;
    } else{
        return false;
    }
}


function verifierIdClient() {
    // Vérifier si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Vérifier si la variable $_POST["idClient"] existe et n'est pas vide
        if (isset($_POST["idClient"]) && !empty($_POST["idClient"])) {
            // Si la condition est vraie, assigner la valeur à la variable $idClient
            $idClient = $_POST["idClient"];
            // Retourner la valeur de $idClient
            return $idClient;
        }
    }
}

function verifierIdTechnicien() {
    // Vérifier si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Vérifier si la variable $_POST["idTechnicien"] existe et n'est pas vide
        if (isset($_POST["idTechnicien"]) && !empty($_POST["idTechnicien"])) {
            // Si la condition est vraie, assigner la valeur à la variable $idTechnicien
            $idTechnicien = $_POST["idTechnicien"];
            // Retourner la valeur de $idTechnicien
            return $idTechnicien;
        }
    }
}


function verifierDateDebut() {
    // Vérifier si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Vérifier si la variable $_POST["dateDebut"] existe et n'est pas vide
        if (isset($_POST["dateDebut"]) && !empty($_POST["dateDebut"])) {
            // Si la condition est vraie, assigner la valeur à la variable $dateDebut
            $dateDebut = $_POST["dateDebut"];
            // Retourner la valeur de $dateDebut
            return $dateDebut;
        }
    }
}

function verifierDateFin() {
    // Vérifier si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Vérifier si la variable $_POST["dateFin"] existe et n'est pas vide
        if (isset($_POST["dateFin"]) && !empty($_POST["dateFin"])) {
            // Si la condition est vraie, assigner la valeur à la variable $dateFin
            $dateFin = $_POST["dateFin"];
            // Retourner la valeur de $dateFin
            return $dateFin;
        }
    }
}


// Fonction pour récupérer l'ID d'agence du technicien depuis la base de données
function recupererIdAgenceTechnicien() {
    try {
        $idTechnicien=verifierIdTechnicien();
        $cnx = connexionPDO();
        $query = "SELECT idAgences FROM personnels WHERE id = :idTechnicien";
        $stmt = $cnx->prepare($query);
        $stmt->bindParam(':idTechnicien', $idTechnicien, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['idAgences'];
    } catch (PDOException $e) {
        // Gérer les erreurs en affichant un message (à adapter selon vos besoins)
        print "Erreur !: " . $e->getMessage();
        die();
    }
}
// Fonction pour récupérer l'ID d'agence du client depuis la base de données
function recupererIdAgenceClient() {
    try {
        $idClient=verifierIdClient();
        $cnx = connexionPDO();
        $query = "SELECT idAgences FROM client WHERE idClient = :idClient";
        $stmt = $cnx->prepare($query);
        $stmt->bindParam(':idClient', $idClient, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['idAgences'];
    } catch (PDOException $e) {
        // Gérer les erreurs en affichant un message (à adapter selon vos besoins)
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

//IdIntervention
function genererIdInterventionUnique() {
    // Générer la partie de la date au format dMY
    $datePart = date('dmY');

    // Générer une partie aléatoire (XXX)
    $randomPart = str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);

    // Concaténer les parties pour former l'ID intervention unique
    $idInterventionUnique = $datePart . '_' . $randomPart;

    return $idInterventionUnique;
}


function infosClient($idClient) {
    try {
        // Pas besoin de réaffecter $idClient à partir de verifierIdClient()
        $cnx = connexionPDO();
        $query = "SELECT * FROM client WHERE idClient = :idClient";
        $stmt = $cnx->prepare($query);
        $stmt->bindParam(':idClient', $idClient, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result; // Retourne un tableau associatif avec les informations du client
    } catch (PDOException $e) {
        // Gérer les erreurs en affichant un message (à adapter selon vos besoins)
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function infosIntervention($idTech, $selectedDate = null) {
    try {
        $cnx = connexionPDO();
        $query = "SELECT * FROM intervention WHERE idTech = :idTech";

        // Si une date est spécifiée, ajouter la condition pour la date de début de l'intervention
        if ($selectedDate !== null) {
            $query .= " AND dateInter = :selectedDate"; // Utilisation de "AND" au lieu de "OR"
        }

        $stmt = $cnx->prepare($query);
        $stmt->bindParam(':idTech', $idTech, PDO::PARAM_STR);
        
        // Lier le paramètre de la date de début de l'intervention s'il est spécifié
        if ($selectedDate !== null) {
            $stmt->bindParam(':selectedDate', $selectedDate, PDO::PARAM_STR);
        }

        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results; // Retourne un tableau associatif avec les informations des interventions correspondantes
    } catch (PDOException $e) {
        // Gérer les erreurs en affichant un message (à adapter selon vos besoins)
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

/*
// Nom prénom du technicien
function infosTechnicien() {
    try {
        $idTechnicien = verifierIdClient();
        $cnx = connexionPDO();
        $query = "SELECT nom, prenom FROM personnels WHERE id = :idTechnicien";
        $stmt = $cnx->prepare($query);
        $stmt->bindParam(':idTechnicien', $idTechnicien, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result; // Retourne un tableau associatif avec les informations du technicien
    } catch (PDOException $e) {
        // Gérer les erreurs en affichant un message (à adapter selon vos besoins)
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

// Nom prénom du client



// ville agences du technicien

function nomAgencesTechnicien() {
    try {
        $idTechnicien = verifierIdClient();
        $cnx = connexionPDO();
        $query = "SELECT agences.villeAgence FROM agences JOIN personnels ON agences.idAgences = personnels.idAgences WHERE id =:idTechnicien";
        $stmt = $cnx->prepare($query);
        $stmt->bindParam(':idTechnicien', $idTechnicien, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result; // Retourne un tableau associatif avec les informations du technicien
    } catch (PDOException $e) {
        // Gérer les erreurs en affichant un message (à adapter selon vos besoins)
        print "Erreur !: " . $e->getMessage();
        die();
    }
}
//ville Agences du client


function nomAgencesClient() {
    try {
        $idTechnicien = verifierIdClient();
        $cnx = connexionPDO();
        $query = "SELECT agences.villeAgence FROM agences JOIN client ON agences.idAgences = client.idAgences WHERE idClient=:idClient";
        $stmt = $cnx->prepare($query);
        $stmt->bindParam(':idClient', $idClient, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result; // Retourne un tableau associatif avec les informations du technicien
    } catch (PDOException $e) {
        // Gérer les erreurs en affichant un message (à adapter selon vos besoins)
        print "Erreur !: " . $e->getMessage();
        die();
    }
}
*/


function updateClientInfo($idClient, $nouvelleRue, $nouveauNumRue, $nouveauCpVille, $nouvelleVille, $nouveauPays, $nouveauNumTel, $nouveauMail) {
    try {
        // Vérifier si l'ID du client est valide
        if (!is_numeric($idClient) || $idClient <= 0) {
            throw new Exception("L'ID du client est invalide.");
        }

        $cnx = connexionPDO();

        // Préparer la requête SQL pour mettre à jour les informations du client
        $query = "UPDATE client SET ";
        $params = [];

        if (!empty($nouvelleRue)) {
            $query .= "rue = :nouvelleRue, ";
            $params[':nouvelleRue'] = $nouvelleRue;
        }
        if (!empty($nouveauNumRue)) {
            $query .= "numRue = :nouveauNumRue, ";
            $params[':nouveauNumRue'] = $nouveauNumRue;
        }
        if (!empty($nouveauCpVille)) {
            $query .= "cpVille = :nouveauCpVille, ";
            $params[':nouveauCpVille'] = $nouveauCpVille;
        }
        if (!empty($nouvelleVille)) {
            $query .= "ville = :nouvelleVille, ";
            $params[':nouvelleVille'] = $nouvelleVille;
        }
        if (!empty($nouveauPays)) {
            $query .= "pays = :nouveauPays, ";
            $params[':nouveauPays'] = $nouveauPays;
        }
        if (!empty($nouveauNumTel)) {
            $query .= "numTel = :nouveauNumTel, ";
            $params[':nouveauNumTel'] = $nouveauNumTel;
        }
        if (!empty($nouveauMail)) {
            $query .= "mail = :nouveauMail, ";
            $params[':nouveauMail'] = $nouveauMail;
        }

        // Supprimer la virgule en trop et compléter la requête
        $query = rtrim($query, ', ');
        $query .= " WHERE idClient = :idClient";

        // Préparer la requête
        $stmt = $cnx->prepare($query);

        // Liaison des paramètres
        foreach ($params as $key => &$value) {
            $stmt->bindParam($key, $value);
        }
        $stmt->bindParam(':idClient', $idClient, PDO::PARAM_INT);

        // Exécution de la requête
        $stmt->execute();

        // Retourner true si la mise à jour a réussi
        return true;
    } catch (PDOException $e) {
        // Gérer les erreurs de base de données
        return "Erreur de base de données: " . $e->getMessage();
    } catch (Exception $e) {
        // Gérer les autres erreurs
        return "Erreur: " . $e->getMessage();
    }
}


// Fonction pour récupérer le nombre d'interventions par jour pour un technicien spécifique
function nbInterventionTech($mois, $annee, $idTechnicien) {
    try {
        $cnx = connexionPDO();
        $query = "SELECT idTech, jours.jour, COUNT(intervention.idInter) AS nbInterventions 
                  FROM (
                      SELECT 1 AS jour UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10 UNION
                      SELECT 11 UNION SELECT 12 UNION SELECT 13 UNION SELECT 14 UNION SELECT 15 UNION SELECT 16 UNION SELECT 17 UNION SELECT 18 UNION SELECT 19 UNION SELECT 20 UNION
                      SELECT 21 UNION SELECT 22 UNION SELECT 23 UNION SELECT 24 UNION SELECT 25 UNION SELECT 26 UNION SELECT 27 UNION SELECT 28 UNION SELECT 29 UNION SELECT 30 UNION
                      SELECT 31
                  ) AS jours
                  LEFT JOIN intervention ON jours.jour = DAY(intervention.dateInter) AND MONTH(intervention.dateInter) = :mois AND YEAR(intervention.dateInter) = :annee 
                  AND intervention.idTech = :idTechnicien
                  GROUP BY idTech, jours.jour";
        $stmt = $cnx->prepare($query);
        $stmt->bindParam(':mois', $mois, PDO::PARAM_INT);
        $stmt->bindParam(':annee', $annee, PDO::PARAM_INT);
        $stmt->bindParam(':idTechnicien', $idTechnicien, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results; // Retourne un tableau associatif avec le nombre d'interventions par jour pour le technicien spécifique
    } catch (PDOException $e) {
        // Gérer les erreurs en affichant un message (à adapter selon vos besoins)
        print "Erreur !: " . $e->getMessage();
        die();
    }
}
function tempsInterventionTech($mois, $annee, $idTechnicien) {
    try {
        $cnx = connexionPDO();
        $query = "SELECT jours.jour, SUM(TIME_TO_SEC(TIMEDIFF(intervention.dateFinInter, intervention.dateInter)) / 3600) AS totalHeures
                FROM (
                    SELECT 1 AS jour UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10 UNION
                    SELECT 11 UNION SELECT 12 UNION SELECT 13 UNION SELECT 14 UNION SELECT 15 UNION SELECT 16 UNION SELECT 17 UNION SELECT 18 UNION SELECT 19 UNION SELECT 20 UNION
                    SELECT 21 UNION SELECT 22 UNION SELECT 23 UNION SELECT 24 UNION SELECT 25 UNION SELECT 26 UNION SELECT 27 UNION SELECT 28 UNION SELECT 29 UNION SELECT 30 UNION
                    SELECT 31
                ) AS jours
                LEFT JOIN intervention ON jours.jour = DAY(intervention.dateInter) AND MONTH(intervention.dateInter) = :mois AND YEAR(intervention.dateInter) = :annee 
                AND intervention.idTech = :idTechnicien
                GROUP BY jours.jour, intervention.idTech;  -- Ajout de l'ID du technicien dans le GROUP BY";
        $stmt = $cnx->prepare($query);
        $stmt->bindParam(':mois', $mois, PDO::PARAM_INT);
        $stmt->bindParam(':annee', $annee, PDO::PARAM_INT);
        $stmt->bindParam(':idTechnicien', $idTechnicien, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results; // Retourne un tableau associatif avec la durée des interventions en heures par jour pour le technicien spécifique
    } catch (PDOException $e) {
        // Gérer les erreurs en affichant un message (à adapter selon vos besoins)
        print "Erreur !: " . $e->getMessage();
        die();
    }
}
function distanceKmIntervention($mois, $annee, $idTechnicien) {
    try {
        $cnx = connexionPDO();
        $query = "SELECT DAY(intervention.dateInter) AS jour, SUM(client.distanceKm) AS totalDistance
                FROM intervention
                INNER JOIN client ON intervention.clientInter = client.idClient
                WHERE MONTH(intervention.dateInter) = :mois
                AND YEAR(intervention.dateInter) = :annee
                AND intervention.idTech = :idTechnicien
                GROUP BY jour, intervention.idTech;"; // Ajout de l'ID du technicien dans le GROUP BY
        $stmt = $cnx->prepare($query);
        $stmt->bindParam(':mois', $mois, PDO::PARAM_INT);
        $stmt->bindParam(':annee', $annee, PDO::PARAM_INT);
        $stmt->bindParam(':idTechnicien', $idTechnicien, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results; // Retourne un tableau associatif avec la distance parcourue en km par jour pour le technicien spécifique
    } catch (PDOException $e) {
        // Gérer les erreurs en affichant un message (à adapter selon vos besoins)
        print "Erreur !: " . $e->getMessage();
        die();
    }
}


?>
