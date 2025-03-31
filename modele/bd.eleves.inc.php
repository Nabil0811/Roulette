<?php

include_once "bd.inc.php";

function getMoyenneElevesByClasse($nomC){
    $resultat = array();

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT e.prenomE, e.nomE, AVG(n.valeurN) AS moyenne_notes, e.nb_tirages FROM eleves AS e INNER JOIN notes AS n ON e.idE = n.idE INNER JOIN classes AS c ON e.idC = c.idC WHERE c.nomC = :nomC GROUP BY e.idE;");
        $req->bindParam(':nomC', $nomC, PDO::PARAM_INT);
        $req->execute();

        $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function getElevesByStatut0($nomC){
    $resultat = array();

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT * FROM eleves e JOIN classes c ON e.idC = c.idC WHERE e.statutE = FALSE AND c.nomC = :nomC");
        $req->bindParam(':nomC', $nomC, PDO::PARAM_INT);
        $req->execute();

        $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function getRandomEleve($nomC){
    $resultat = array();

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT * FROM eleves e JOIN classes c ON e.idC = c.idC WHERE statutE = FALSE AND c.nomC = :nomC ORDER BY RAND() LIMIT 1");
        $req->bindParam(':nomC', $nomC, PDO::PARAM_INT);
        $req->execute();

        $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function elevePassed($idE){
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("UPDATE eleves SET statutE = 1 WHERE idE = :idE");
        $req->bindParam(':idE', $idE, PDO::PARAM_INT);
        $req->execute();

        // La mise à jour a réussi
        return true;
    } catch (PDOException $e) {
        // Une erreur s'est produite lors de la mise à jour
        return false;
    }
}

function resetPassage(){
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("UPDATE eleves SET statutE = 0");
        $req->execute();

        // La mise à jour a réussi
        return true;
    } catch (PDOException $e) {
        // Une erreur s'est produite lors de la mise à jour
        return false;
    }
}

function getElevesAbsents($nomC){
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT e.prenomE, e.nomE, e.idE, a.idA FROM eleves AS e INNER JOIN abscences AS a ON e.idE = a.idE INNER JOIN classes AS c ON e.idC = c.idC WHERE c.nomC = :nomC;");
        $req->bindParam(':nomC', $nomC, PDO::PARAM_INT);
        $req->execute();

        $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

// Fonction pour incrémenter le nombre de tirages d'un élève
function incrementerNbTirages($idE) {
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("UPDATE eleves SET nb_tirages = nb_tirages + 1 WHERE idE = :idE");
        $req->bindParam(':idE', $idE, PDO::PARAM_INT);
        $req->execute();
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

?>