<?php
// Connexion à la base de données
$connexion = mysqli_connect("localhost", "root", "", "hospitaldb");

// Récupération de la valeur de recherche depuis le formulaire (ID de l'opération sélectionnée)
$operationID = $_GET["operation"];

// Requête SQL pour rechercher l'opération par son ID
$sql_operation = "SELECT o.NomOperation, o.DateOperation, o.Etat, s.NomSalle
                  FROM operations o
                  LEFT JOIN SalleDesOperations s ON o.ID = s.OperationEnCoursID
                  WHERE o.ID = $operationID";
$resultat_operation = mysqli_query($connexion, $sql_operation);

// Requête SQL pour récupérer les patients associés à l'opération
$sql_patients = "SELECT p.Nom, p.Prenom FROM patients p WHERE p.OperationID = $operationID";
$resultat_patients = mysqli_query($connexion, $sql_patients);

// Requête SQL pour récupérer les médecins associés aux patients de l'opération
$sql_medecins = "SELECT d.Nom, d.Prenom FROM docteurs d
                JOIN patients p ON d.ID = p.DocteurID
                WHERE p.OperationID = $operationID";
$resultat_medecins = mysqli_query($connexion, $sql_medecins);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Résultats de la Recherche d'Opération</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Résultats de la Recherche d'Opération</h1>
    
    <?php
    if (mysqli_num_rows($resultat_operation) > 0) {
        $row_operation = mysqli_fetch_assoc($resultat_operation);

        echo "<div class='operation-info'>";
        echo "<h2>Nom de l'Opération :</h2>";
        echo "<p>" . $row_operation["NomOperation"] . "</p>";
        echo "<h2>Date de l'Opération :</h2>";
        echo "<p>" . $row_operation["DateOperation"] . "</p>";
        echo "<h2>État de l'Opération :</h2>";
        echo "<p>" . $row_operation["Etat"] . "</p>";
        echo "<h2>Salle de l'Opération :</h2>";
        echo "<p>" . $row_operation["NomSalle"] . "</p>";
        echo "</div>";

        // Afficher les patients associés à l'opération
        if (mysqli_num_rows($resultat_patients) > 0) {
            echo "<table class='patient-table'>";
            echo "<tr>";
            echo "<th>Patient</th>";
            echo "</tr>";

            while ($row_patient = mysqli_fetch_assoc($resultat_patients)) {
                echo "<tr>";
                echo "<td>" . $row_patient["Nom"] . " " . $row_patient["Prenom"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Aucun patient trouvé pour cette opération.";
        }

        // Afficher les médecins associés aux patients de l'opération
        if (mysqli_num_rows($resultat_medecins) > 0) {
            echo "<table class='medecin-table'>";
            echo "<tr>";
            echo "<th>Médecin</th>";
            echo "</tr>";

            while ($row_medecin = mysqli_fetch_assoc($resultat_medecins)) {
                echo "<tr>";
                echo "<td>" . $row_medecin["Nom"] . " " . $row_medecin["Prenom"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Aucun médecin trouvé pour cette opération.";
        }

    } else {
        echo "Aucun résultat trouvé pour cette opération.";
    }
    ?>
</body>
</html>

