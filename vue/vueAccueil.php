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
        if(isset($nomC)&&count($absents) > 0){
            echo "<table>";
            echo "<tr><th>Les élèves n'étant pas passés pour cause d'absence :</th></tr>";
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
    <table>
        <td id="listeEleves0">
            <?php
                if(isset($nomC)){
                    foreach ($eleves0 as $e) {
                        echo '<tr>'.$e['prenomE']." ".$e['nomE'].'</tr><br>';
                    }
                }
            ?>
        </td>
    </table>
</body>