<?php

function connexionPDO() {
    $login = "root";
    $mdp = "root";
    $bd = "bdd_roulette";
    $serveur = "localhost";

    try {
        $conn = new PDO("mysql:host=$serveur;dbname=$bd;charset=UTF8", $login, $mdp); 
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        print "Erreur de connexion PDO ";
        die();
    }
}

if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    // prog de test
    header('Content-Type:text/plain');

    echo "connexionPDO() : \n";
    print_r(connexionPDO());
}
?>
