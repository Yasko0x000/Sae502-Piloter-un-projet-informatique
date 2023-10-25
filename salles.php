<?php
// Connexion à la base de données
$connexion = mysqli_connect("localhost", "root", "", "hospitaldb");

// Requête SQL pour récupérer les informations de la salle d'opération
$sql_salle = "SELECT s.NomSalle, s.DateAcces, b.IDBadgeRFID, o.NomOperation, o.DateOperation, o.Etat
              FROM salledesoperations s
              LEFT JOIN badgesrfid b ON s.IDBadgeRFID = b.ID
              LEFT JOIN operations o ON s.OperationEnCoursID = o.ID";
$resultat_salle = mysqli_query($connexion, $sql_salle);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Salles des Opérations</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Salles des Opérations</h1>
    <table class="operation-table">
        <tr>
            <th>Nom de la Salle</th>
            <th>ID du Badge RFID</th>
            <th>Opération en cours</th>
            <th>Dernier Acces</th>
            <th>État de l'Opération</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($resultat_salle)) {
            echo "<tr>";
            echo "<td>" . $row["NomSalle"] . "</td>";
            echo "<td>" . $row["IDBadgeRFID"] . "</td>";
            if (!empty($row["NomOperation"])) {
                echo "<td>" . $row["NomOperation"] . "</td>";
                echo "<td>" . $row["DateAcces"] . "</td>";
                echo "<td>" . $row["Etat"] . "</td>";
            } else {
                echo "<td class='no-operation' colspan='3'>Pas d'opération en cours</td>";
                echo "<td></td>";
            }
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>


