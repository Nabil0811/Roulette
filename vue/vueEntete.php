<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Roulette-Éducative</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    </head>

    <body>
        <h1> 🎯 Roulette Éducative </h1>
        <div class="nav-menu">
            <a href="./?action=defaut">Tirage Aléatoire</a>
            <a href="./?action=moyenne">Résultats & Statistiques</a>
        </div>
        <div class="container class-selection">
            <?php if (isset($_SESSION['nomC']) && $_SESSION['nomC'] !== "") {
                echo "<p>Vous avez choisi la classe <strong>" . htmlspecialchars($nomC) . "</strong></p>";
            } else {
                echo "<p>Veuillez choisir une classe :</p>";
            }
            ?>


            <form action=<?php echo $redirection ?> method="POST">
                <select id="listeClasses" name="listeClasses">
                    <option value=""></option>
                    <?php foreach ($classes as $c) : ?>
                        <option value="<?= htmlspecialchars($c['nomC']); ?>" <?= (isset($_SESSION['nomC']) && $_SESSION['nomC'] === $c['nomC']) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($c['nomC']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="submit" id=validerClasse value="valider">
            </form>
        </div>