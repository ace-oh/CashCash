<?php
if ( $_SERVER["SCRIPT_FILENAME"] == __FILE__ ){
    $racine="..";
}
include_once "$racine/modele/authentification.inc.php";
include_once "$racine/modele/bd.utilisateur.inc.php";

// creation du menu burger
$menuBurger = array();

// Récup info
$id=getMailULoggedOn();
$util = getUtilisateurByMailU($id);
$emploie = getEmploiUserById($id);
$role=$emploie["nomRôle"];

// appel des fonctions permettant de recuperer les donnees utiles a l'affichage 


if (isLoggedOn()) {

// recuperation des donnees GET, POST, et SESSION
if ($role == "Technicien") {
    $menuBurger[] = Array("url"=>"./?action=tIntervention","label"=>"Mes Interventions");
    $menuBurger[] = Array("url"=>"./?action=profil","label"=>"Mon profil");
} elseif ($role == "Assistant") {
    
    $menuBurger[] = Array("url"=>"./?action=aAffecterVisite","label"=>"Affecter Intervention");
    $menuBurger[] = Array("url"=>"./?action=aVoirIntervention","label"=>"Consulter Intervention");
    $menuBurger[] = Array("url"=>"./?action=updProfil","label"=>"Modifier Informations clients");
    $menuBurger[] = Array("url"=>"./?action=statsTech","label"=>"Statistique du mois");
    $menuBurger[] = Array("url"=>"./?action=profil","label"=>"Mon profil");
} else {
    $menuBurger[]="";
}
    $titre = "Mon profil";
    include_once "$racine/vue/entete.html.php";
    include_once "$racine/vue/vueMonProfil.php";
    include_once "$racine/vue/pied.html.php";
} else {
    $titre = "t'es pas co bouffon";
    include_once "$racine/vue/entete.html.php";
    include_once "$racine/vue/pied.html.php";
}


?>