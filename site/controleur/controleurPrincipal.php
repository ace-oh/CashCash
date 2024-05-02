<?php

function controleurPrincipal($action){
    $lesActions = array();
    $lesActions["defaut"] = "connexion.php";
    $lesActions["connexion"] = "connexion.php";
    $lesActions["deconnexion"] = "deconnexion.php";
    $lesActions["profil"] = "monProfil.php";
    $lesActions["aAffecterVisite"] = "aVisite.php";
    $lesActions["tIntervention"] = "tIntervention.php";
    $lesActions["aVoirIntervention"] = "voirInterventionA.php";
    $lesActions["updProfil"] = "updtProfil.php";
    $lesActions["statsTech"] = "statsTech.php";

    
    if (array_key_exists ( $action , $lesActions )){
        return $lesActions[$action];
    }
    else{
        return $lesActions["defaut"];
    }

}

?>