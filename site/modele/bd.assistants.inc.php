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
            echo "<div> <center>Le formulaire n'a pas été soumis.";
        }
    } else {
         echo "<div> <center> Le client et le technicien n'appartiennent pas à la même agence. </center> </div>";
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

function infosClient() {
    try {
        $idClient = verifierIdClient();
        $cnx = connexionPDO();
        $query = "SELECT SIREN FROM client WHERE idClient = :idClient";
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
?>