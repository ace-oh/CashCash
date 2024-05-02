<?php
if ( $_SERVER["SCRIPT_FILENAME"] == __FILE__ ){
    $racine="..";
}

include_once "$racine/modele/authentification.inc.php";
include_once "$racine/modele/bd.utilisateur.inc.php";
include_once "$racine/modele/bd.techniciens.inc.php";
$id=getMailULoggedOn();
$util = getUtilisateurByMailU($id);
$emploie = getEmploiUserById($id);
$role=$emploie["nomRôle"];


if (isLoggedOn()) {
    $menuBurger[] = Array("url"=>"./?action=tIntervention","label"=>"Mes interventions");
    $menuBurger[] = Array("url"=>"./?action=profil","label"=>"Mon profil");

    $titre = "Mes interventins";
    include_once "$racine/vue/entete.html.php";
    include_once "$racine/vue/vueMonProfil.php";
    include_once "$racine/vue/vueIIntervention.php";
    include_once "$racine/vue/pied.html.php";
} else {
    $titre = "T'es pas co bouffon";
    include_once "$racine/vue/entete.html.php";
    include_once "$racine/vue/pied.html.php";
}
?>