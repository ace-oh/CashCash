<?php
include_once "bd.inc.php";

function getInterventionsByTechnicianId($technicianId) {
    $resultat = array();

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT * FROM intervention 
                             JOIN personnels ON intervention.idTech = personnels.id 
                             WHERE intervention.idTech = :technicianId 
                             ORDER BY intervention.etat ASC");
        $req->bindParam(':technicianId', $technicianId, PDO::PARAM_STR);
        $req->execute();

        $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }

    return $resultat;
}




/* Update Intervention */

function updateIntervention() {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_button"])) {

        $commentaire = $_POST["commentaire"];
        $duree = $_POST["dateHeure"];

        if (empty($commentaire) || empty($duree)) {
            echo "Impossible d'affecter une intervention car l'un des champs n'est pas renseigné";
        } else {
            updateSql();
        }
    } else {
        echo "Le formulaire n'a pas été soumis.";
    }
}

function updateSql() {
    try {
        $cnx = connexionPDO();

        $idInter = verifierIdInter();
        $commentaire = verifierCommentaire(); 
        $duree = verifierDuree(); 
        $etat = "Terminé";

        $query = "UPDATE intervention 
                  SET commentInter = :commentaire, dateFinInter = :duree, etat = :etat 
                  WHERE idInter = :idInter";

        $stmt = $cnx->prepare($query);

        $stmt->bindParam(':idInter', $idInter, PDO::PARAM_INT);
        $stmt->bindParam(':commentaire', $commentaire, PDO::PARAM_STR);
        $stmt->bindParam(':duree', $duree, PDO::PARAM_STR);
        $stmt->bindParam(':etat', $etat, PDO::PARAM_STR);

        $stmt->execute();

        echo "Le commentaire et le temps passé ont bien été mis à jour pour l'intervention n° $idInter.";
    } catch (PDOException $e) {
        // Gérer les erreurs en affichant un message (à adapter selon vos besoins)
        print "Erreur !: " . $e->getMessage();
        die();
    }
}


/*Fonction de vérification */

function verifierIdInter() {
    // Vérifier si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Vérifier si la variable $_POST["idInter"] existe et n'est pas vide
        if (isset($_POST["idInter"]) && !empty($_POST["idInter"])) {
            // Si la condition est vraie, assigner la valeur à la variable $idInter
            $idInter = $_POST["idInter"];
            // Retourner la valeur de $idInter
            return $idInter;
        }
    }
}

function verifierCommentaire() {
    // Vérifier si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Vérifier si la variable $_POST["commentaire"] existe et n'est pas vide
        if (isset($_POST["commentaire"]) && !empty($_POST["commentaire"])) {
            // Si la condition est vraie, assigner la valeur à la variable $commentaire
            $commentaire = $_POST["commentaire"];
            // Retourner la valeur de $commentaire
            return $commentaire;
        }
    }
}

function verifierDuree() {
    // Vérifier si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Vérifier si la variable $_POST["dateHeure"] existe et n'est pas vide
        if (isset($_POST["dateHeure"]) && !empty($_POST["dateHeure"])) {
            // Si la condition est vraie, assigner la valeur à la variable $dateHeure
            $dateHeure = $_POST["dateHeure"];
            // Retourner la valeur de $dateHeure
            return $dateHeure;
        }
    }
}




?>