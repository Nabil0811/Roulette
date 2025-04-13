<div class="container">
    <div id="moyenne">
        <form action="./?action=moyenne" method="POST">
            <input type="submit" name="resetN" value="RÉINITIALISER LES NOTES">
        </form> 
        
        <?php
        if(isset($nomC) && isset($statsClasse) && is_array($statsClasse)) {
            echo "<div class='stats-container'>";
            echo "<h2 class='stats-title'>Statistiques de la classe ".$nomC."</h2>";
            echo "<div class='stats-grid'>";
            
            // Carte pour la moyenne
            echo "<div class='stat-card'>";
            echo "<div class='stat-label'>Moyenne de la classe</div>";
            echo "<div class='stat-value'>".(isset($statsClasse['moyenne']) ? $statsClasse['moyenne'] : 'N/A')."</div>";
            echo "</div>";
            
            // Carte pour la médiane
            echo "<div class='stat-card'>";
            echo "<div class='stat-label'>Médiane</div>";
            echo "<div class='stat-value'>".(isset($statsClasse['mediane']) ? $statsClasse['mediane'] : 'N/A')."</div>";
            echo "</div>";
            
            // Carte pour l'écart-type
            echo "<div class='stat-card'>";
            echo "<div class='stat-label'>Écart-type</div>";
            echo "<div class='stat-value'>".(isset($statsClasse['ecart_type']) ? $statsClasse['ecart_type'] : 'N/A')."</div>";
            echo "</div>";
            
            // Carte pour le meilleur élève
            echo "<div class='stat-card best'>";
            echo "<div class='stat-label'>Meilleur élève</div>";
            echo "<div class='stat-value'>".(isset($statsClasse['meilleur_eleve']) ? $statsClasse['meilleur_eleve'] : 'N/A')."</div>";
            echo "</div>";
            
            // Carte pour le moins bon élève
            echo "<div class='stat-card worst'>";
            echo "<div class='stat-label'>Élève en difficulté</div>";
            echo "<div class='stat-value'>".(isset($statsClasse['moins_bon_eleve']) ? $statsClasse['moins_bon_eleve'] : 'N/A')."</div>";
            echo "</div>";
            
            echo "</div>"; // Fin de stats-grid
            echo "</div>"; // Fin de stats-container
        }
        ?>

        <?php
        if(isset($nomC) && isset($listeEleves) && count($listeEleves) > 0){
            echo "<h2>Résultats des élèves</h2>";
            echo "<table>";
            echo "<tr><th>Élève</th><th>Moyenne</th><th>Nombre de tirages</th></tr>";
            foreach ($listeEleves as $e) {
                echo "<tr>";
                echo "<td>".$e['prenomE']." ".$e['nomE']."</td>";
                echo "<td>".round($e['moyenne_notes'], 2)."</td>";
                echo "<td>".$e['nb_tirages']."</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else if(isset($nomC)) {
            echo "<p>Aucune note n'a été attribuée pour cette classe.</p>";
        }
        ?>
    </div>
</div>