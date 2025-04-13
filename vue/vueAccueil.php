<div class="container">
        <div id="tirage">
            <form action="./?action=defaut" method="POST">
                <input type="submit" name="spin" value="TIRER">
            </form>
            <form action="./?action=defaut" method="POST">
                <input type="submit" name="reset" value="RESET">
            </form>

            
            <?php  
            if(isset($randomEleve)){   
                echo "<form action='./?action=defaut' method='POST'>";
                    echo "<p> Élève tiré au hasard : </p>";
                    echo "<p id='elu'>";
                    if(isset($randomEleve)){
                        echo $randomEleve[0]['prenomE']." ".$randomEleve[0]['nomE'];
                        echo " (Tiré ".$randomEleve[0]['nb_tirages']." fois)";
                    }
                    echo "</p>";
                    echo "<select name='note'>";
                    echo "<option value='Absent'>Absent</option>";
                    for ($i = 0; $i <= 20; $i++) {
                        echo "<option value='" . $i . "'>" . $i . "</option>";
                    }
                    echo "</select>";
                    echo "<input type='submit' id='validerNote' value='valider'>";
                echo "</form>";
                }
            ?>

        </div>  
        <br>
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

        <br>
        <?php
            if(isset($nomC)&&count($absents) > 0){
                echo "<table>";
                echo "<tr><th colspan='3'>Les élèves n'étant pas passés pour cause d'absence :</th></tr>";
                foreach ($absents as $a) {
                    echo "<form action='./?action=defaut' method='POST'>";
                    echo "<tr>";
                    echo "<td>".$a['prenomE']." ".$a['nomE']."</td>";
                    echo "<input style='display:None' name='idEA' value='".$a['idE']."'>";
                    echo "<input style='display:None' name='idAA' value='".$a['idA']."''>";
                    echo "<td><select name='noteA'>";
                    for ($i = 0; $i <= 20; $i++) {
                        echo "<option value='" . $i . "'>" . $i . "</option>";
                    }
                    echo "</select></td>";
                    echo "<td><input type='submit' id='validerNote' value='valider'></td>";
                    echo "</tr>";
                    echo "</form>";
                }
                echo "</table>";
            }
        ?>

        <br>
        <?php
            if(isset($nomC) && isset($eleves0) && count($eleves0) > 0){
                echo "<table>";
                echo "<tr><th>Élèves restants</th><th>Nombre de tirages précédents</th></tr>";
                foreach ($eleves0 as $e) {
                    echo '<tr><td>'.$e['prenomE']." ".$e['nomE'].'</td><td>'.$e['nb_tirages'].'</td></tr>';
                }
                echo "</table>";
            }
        ?>
    </div> <!-- Fin du container -->
</body>