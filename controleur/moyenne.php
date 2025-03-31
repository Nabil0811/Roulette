<?php
session_start();

if ( $_SERVER["SCRIPT_FILENAME"] == __FILE__ ){
    $racine="..";
}

include_once "$racine/modele/bd.classes.inc.php";
include_once "$racine/modele/bd.eleves.inc.php";
include_once "$racine/modele/bd.notes.inc.php";

$redirection="./?action=moyenne";

// recuperation des donnees GET, POST, et SESSION

#Prise en compte de la classe
if(isset($_POST['listeClasses'])){
    $_SESSION['nomC'] = $_POST['listeClasses'];
}

#Sélection des élèves par apport à la classe sélectionné
if(isset($_SESSION['nomC'])&&$_SESSION['nomC']!==""){
    $nomC=$_SESSION['nomC'];
    $listeEleves = getMoyenneElevesByClasse($nomC);
    
    // Calcul et récupération des statistiques
    $statsClasse = calculerStatistiquesClasse($nomC);
    $statsHistorique = recupererStatistiquesClasse($nomC);
}

// appel des fonctions permettant de recuperer les donnees utiles a l'affichage 

#Sélection de toutes les classes
$classes = getClasses();

#Selection des élèves par rapport à la classe
if(isset($nomC)){
    $listeEleves = getMoyenneElevesByClasse($nomC);
}
// traitement si necessaire des donnees recuperees

if(isset($_POST['resetN'])){
    $resetNotes=resetNotes($nomC);
    $listeEleves = getMoyenneElevesByClasse($nomC);
}

// appel du script de vue qui permet de gerer l'affichage des donnees
$titre = "GaecSellier.fr";
include "$racine/vue/vueEntete.php";
include "$racine/vue/vueMoyenne.php";

?>