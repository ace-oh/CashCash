<?php
if ( $_SERVER["SCRIPT_FILENAME"] == __FILE__ ){
    $racine="..";
}

include_once "$racine/modele/authentification.inc.php";
include_once "$racine/modele/bd.utilisateur.inc.php";
include_once "$racine/modele/bd.assistants.inc.php";
$id=getMailULoggedOn();
$util = getUtilisateurByMailU($id);
$emploie = getEmploiUserById($id);
$role=$emploie["nomRôle"];


if (isLoggedOn()) {
    $menuBurger[] = Array("url"=>"./?action=aVisite","label"=>"Affecter Intervention");
    $menuBurger[] = Array("url"=>"./?action=profil","label"=>"Mon profil");

    $titre = "ccc";
    include_once "$racine/vue/entete.html.php";
    include_once "$racine/vue/vueMonProfil.php";
    include_once "$racine/vue/vueAVisite.php";
    include_once "$racine/vue/pied.html.php";
} else {
    $titre = "Mon profil";
    include_once "$racine/vue/entete.html.php";
    include_once "$racine/vue/pied.html.php";
}
?>