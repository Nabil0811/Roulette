<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Roulette-Luka</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>

    <body>
        <h1> It's Roulette Time </h1>
        <a href="./?action=defaut">Accueil</a>
        <a href="./?action=moyenne">moyenne</a>
        <div>
            <?php if (isset($_SESSION['nomC']) && $_SESSION['nomC'] !== "") {
                echo "<p>Vous avez choisi la classe " . htmlspecialchars($nomC) . "</p>";
            } else {
                echo "<p>Veuillez choisir une classe :</p>";
            }
            ?>


            <form action=<?php echo $redirection ?> method="POST">
                <select id="listeClasses" name="listeClasses">
                    <option value=""></option>
                    <?php foreach ($classes as $c) : ?>
                        <option valuer="<?= htmlspecialchars($c['nomC']); ?>"><?= htmlspecialchars($c['nomC']); ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="submit" id=validerClasse value="valider">
            </form>
        </div>  

