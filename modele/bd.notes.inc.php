<?php

include_once "bd.inc.php";

function addAbscence($idEP){
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("INSERT INTO abscences (dateA, idE) VALUES (CURDATE(), :idEP)");
        $req->bindParam(':idEP', $idEP, PDO::PARAM_INT);
        $req->execute();
    } catch (PDOException $e) {
        // En cas d'erreur, affichez un message d'erreur
        return "Erreur !: " . $e->getMessage();
    }
    return "Absence ajoutée avec succès.";
}

function delAbscence($idA){
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("DELETE FROM abscences WHERE idA = :idA;");
        $req->bindParam(':idA', $idA, PDO::PARAM_INT);
        $req->execute();
    } catch (PDOException $e) {
        // En cas d'erreur, affichez un message d'erreur
        return "Erreur !: " . $e->getMessage();
    }
    return "Absence ajoutée avec succès.";
}

function addNote($note, $idE){
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("INSERT INTO notes (valeurN, idE) VALUES (:valeurN, :idE)");
        $req->bindParam(':valeurN', $note, PDO::PARAM_STR);
        $req->bindParam(':idE', $idE, PDO::PARAM_INT);
        $req->execute();
    } catch (PDOException $e) {
        // En cas d'erreur, affichez un message d'erreur
        return "Erreur !: " . $e->getMessage();
    }
    return "Note ajoutée avec succès.";
}

function resetNotes($nomC){
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("DELETE notes FROM notes INNER JOIN eleves ON notes.idE = eleves.idE INNER JOIN classes ON eleves.idC = classes.idC WHERE classes.nomC = :nomC ;");
        $req->bindParam(':nomC', $nomC, PDO::PARAM_INT);
        $req->execute();
    } catch (PDOException $e) {
        // En cas d'erreur, affichez un message d'erreur
        return "Erreur !: " . $e->getMessage();
    }
    return "Note ajoutée avec succès.";
}

// Fonction pour calculer la médiane
function calculerMediane($notes) {
    sort($notes);
    $count = count($notes);
    $middleval = floor(($count - 1) / 2);
    
    if ($count % 2) {
        return $notes[$middleval];
    } else {
        $low = $notes[$middleval];
        $high = $notes[$middleval + 1];
        return (($low + $high) / 2);
    }
}

// Fonction pour calculer l'écart-type
function calculerEcartType($notes) {
    $moyenne = array_sum($notes) / count($notes);
    $sommeCarreEcarts = array_sum(array_map(function($x) use ($moyenne) {
        return pow($x - $moyenne, 2);
    }, $notes));
    return sqrt($sommeCarreEcarts / count($notes));
}

// Fonction pour calculer et stocker les statistiques de notes par classe
function calculerStatistiquesClasse($nomC) {
    try {
        $cnx = connexionPDO();
        
        // Récupérer l'ID de la classe
        $reqClasse = $cnx->prepare("SELECT idC FROM classes WHERE nomC = :nomC");
        $reqClasse->bindParam(':nomC', $nomC, PDO::PARAM_STR);
        $reqClasse->execute();
        $classe = $reqClasse->fetch(PDO::FETCH_ASSOC);
        
        if (!$classe) {
            return "Classe non trouvée";
        }
        
        // Récupérer toutes les notes de la classe
        $reqNotes = $cnx->prepare("SELECT n.valeurN, e.prenomE, e.nomE 
                                   FROM notes n 
                                   JOIN eleves e ON n.idE = e.idE 
                                   JOIN classes c ON e.idC = c.idC 
                                   WHERE c.nomC = :nomC");
        $reqNotes->bindParam(':nomC', $nomC, PDO::PARAM_STR);
        $reqNotes->execute();
        $resultatsNotes = $reqNotes->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($resultatsNotes)) {
            return "Aucune note pour cette classe";
        }
        
        // Extraire les valeurs des notes
        $notes = array_column($resultatsNotes, 'valeurN');
        
        // Calculer les statistiques
        $moyenne = array_sum($notes) / count($notes);
        $mediane = calculerMediane($notes);
        $ecartType = calculerEcartType($notes);
        
        // Trouver le meilleur et le moins bon élève
        $notesParEleve = [];
        foreach ($resultatsNotes as $resultat) {
            $eleve = $resultat['prenomE'] . ' ' . $resultat['nomE'];
            if (!isset($notesParEleve[$eleve])) {
                $notesParEleve[$eleve] = [];
            }
            $notesParEleve[$eleve][] = $resultat['valeurN'];
        }
        
        $moyennesEleves = [];
        foreach ($notesParEleve as $eleve => $notesEleve) {
            $moyennesEleves[$eleve] = array_sum($notesEleve) / count($notesEleve);
        }
        
        $meilleurEleve = array_search(max($moyennesEleves), $moyennesEleves);
        $moinsBonEleve = array_search(min($moyennesEleves), $moyennesEleves);
        
        // Stocker les statistiques
        $reqStats = $cnx->prepare("INSERT INTO stats_notes (idC, moyenne, mediane, ecart_type, meilleur_eleve, moins_bon_eleve) 
                                   VALUES (:idC, :moyenne, :mediane, :ecart_type, :meilleur_eleve, :moins_bon_eleve)");
        $reqStats->bindParam(':idC', $classe['idC'], PDO::PARAM_INT);
        $reqStats->bindParam(':moyenne', $moyenne, PDO::PARAM_STR);
        $reqStats->bindParam(':mediane', $mediane, PDO::PARAM_STR);
        $reqStats->bindParam(':ecart_type', $ecartType, PDO::PARAM_STR);
        $reqStats->bindParam(':meilleur_eleve', $meilleurEleve, PDO::PARAM_STR);
        $reqStats->bindParam(':moins_bon_eleve', $moinsBonEleve, PDO::PARAM_STR);
        $reqStats->execute();
        
        return [
            'moyenne' => round($moyenne, 2),
            'mediane' => round($mediane, 2),
            'ecart_type' => round($ecartType, 2),
            'meilleur_eleve' => $meilleurEleve,
            'moins_bon_eleve' => $moinsBonEleve
        ];
        
    } catch (PDOException $e) {
        return "Erreur !: " . $e->getMessage();
    }
}

// Fonction pour récupérer les statistiques stockées pour une classe
function recupererStatistiquesClasse($nomC) {
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT sn.* FROM stats_notes sn 
                              JOIN classes c ON sn.idC = c.idC 
                              WHERE c.nomC = :nomC 
                              ORDER BY sn.date_calcul DESC 
                              LIMIT 1");
        $req->bindParam(':nomC', $nomC, PDO::PARAM_STR);
        $req->execute();
        return $req->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return "Erreur !: " . $e->getMessage();
    }
}

?>