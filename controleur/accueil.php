<?php
session_start();

if ( $_SERVER["SCRIPT_FILENAME"] == __FILE__ ){
    $racine="..";
}

include_once "$racine/modele/bd.classes.inc.php";
include_once "$racine/modele/bd.eleves.inc.php";
include_once "$racine/modele/bd.notes.inc.php";

$redirection="./?action=defaut";

// recuperation des donnees GET, POST, et SESSION

#Prise en compte de la classe
if(isset($_POST['listeClasses'])){
    $_SESSION['nomC'] = $_POST['listeClasses'];
}

#Sélection des élèves par apport à la classe qui reste à passer
if(isset($_SESSION['nomC'])&&$_SESSION['nomC']!==""){
    $nomC=$_SESSION['nomC'];
    $eleves0=getElevesByStatut0($nomC);
    $absents=getElevesAbsents($nomC);
    
    // Calcul et récupération des statistiques
    $statsClasse = calculerStatistiquesClasse($nomC);
    $statsHistorique = recupererStatistiquesClasse($nomC);
}

#Envoie de la note donnée à l'élève tiré
if(isset($_POST['note'])){
    $note=$_POST['note'];
    if($note == "Absent"){
        $addAbscence=addAbscence($_SESSION['idEP']);
    }else{
        $addNote=addNote(intval($note),$_SESSION['idEP']);
    }
    $absents=getElevesAbsents($nomC);
}

if(isset($_POST['noteA'])){
    $note=$_POST['noteA'];
    $addNote=addNote(intval($note),$_POST['idEA']);
    $delAbscence=delAbscence($_POST['idAA']);
    $eleves0=getElevesByStatut0($nomC);
    $absents=getElevesAbsents($nomC);
}

// appel des fonctions permettant de recuperer les donnees utiles a l'affichage 

#Tirage au sort d'un élève
if(isset($_POST['spin'])){
    if(isset($nomC) && $nomC!==""){
        $randomEleve=getRandomEleve($nomC);
        $idEP=$randomEleve[0]['idE'];
        $_SESSION['idEP'] = $idEP;
        
        // Incrémenter le nombre de tirages
        $incrementTirages = incrementerNbTirages($idEP);
        
        $eP=elevePassed($idEP);
        $eleves0=getElevesByStatut0($nomC);
    }else{
        echo "Aucune classe n'a été sélectionné !";
    }
}

#Sélection de toutes les classes
$classes = getClasses();


// traitement si necessaire des donnees recuperees

#Reset si tout les élèves sont passés
if(isset($eleves0)){
    if (count($eleves0) < 1) {
        $resetPassage=resetPassage();
        $eleves0=getElevesByStatut0($nomC);
        $absents=getElevesAbsents($nomC);
    }
}

#Reset si on appuye sur le bouton
if(isset($_POST['reset'])){
    if(isset($nomC) && $nomC!==""){
        $resetPassage=resetPassage();
        $eleves0=getElevesByStatut0($nomC);
        $absents=getElevesAbsents($nomC);
    }else{
        echo "Aucune classe n'a été sélectionné !";
    }
}


// appel du script de vue qui permet de gerer l'affichage des donnees

include "$racine/vue/vueEntete.php";
include "$racine/vue/vueAccueil.php";

?>