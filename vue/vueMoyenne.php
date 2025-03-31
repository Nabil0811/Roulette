<div id="moyenne">
    <form action="./?action=moyenne" method="POST">
        <input type="submit" name="resetN" value="RESET">
    </form> 
    <?php
    echo "<table>";
    echo "<td id='listeEleves'>";
    if(isset($nomC)){
        foreach ($listeEleves as $e) {
            echo "<tr>".$e['prenomE']." ".$e['nomE']." ".$e['moyenne_notes']."</tr><br>";
        }
    }
    echo "</td>";
    echo "</table>";
    ?>