<?php
// Connexion à la base de données
$connexion = mysqli_connect("localhost", "root", "", "hospitaldb");

// Récupération de la valeur de recherche depuis le formulaire (ID du patient sélectionné)
$patientID = $_GET["patient"];

// Requête SQL pour rechercher le patient par son ID
$sql_patient = "SELECT * FROM Patients WHERE ID = $patientID";
$resultat_patient = mysqli_query($connexion, $sql_patient);

// Requête SQL pour récupérer les opérations effectuées par le patient, les médecins associés et, le cas échéant, les détails de la salle d'opération
$sql_operations = "SELECT o.NomOperation, o.DateOperation, o.Etat, d.Nom AS NomDocteur, d.Prenom AS PrenomDocteur, s.NomSalle, s.OperationEnCoursID
                  FROM Operations o
                  JOIN Patients p ON o.ID = p.OperationID
                  JOIN Docteurs d ON p.DocteurID = d.ID
                  LEFT JOIN SalleDesOperations s ON o.ID = s.OperationEnCoursID
                  WHERE p.ID = $patientID";

$resultat_operations = mysqli_query($connexion, $sql_operations);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Résultats de la Recherche</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Résultats de la Recherche</h1>
    <?php
    if (mysqli_num_rows($resultat_patient) > 0) {
        $row_patient = mysqli_fetch_assoc($resultat_patient);

        echo "<div class='patient-info'>";
        echo "<h2>Patient :</h2>";
        echo "<p>" . $row_patient["Nom"] . " " . $row_patient["Prenom"] ."</p>";
        echo "</div>";

        // Afficher les opérations effectuées par le patient et les médecins associés
        echo "<h2>Opérations effectuées par ce patient :</h2>";
        if (mysqli_num_rows($resultat_operations) > 0) {
            echo "<table class='operation-table'>";
            echo "<tr>";
            echo "<th>Opération</th>";
            echo "<th>Date de l'opération</th>";
            echo "<th>État</th>";
            echo "<th>Médecin</th>";
            echo "<th>Salle d'opération</th>";
            echo "</tr>";

            while ($row_operation = mysqli_fetch_assoc($resultat_operations)) {
                echo "<tr>";
                echo "<td>" . $row_operation["NomOperation"] . "</td>";
                echo "<td>" . $row_operation["DateOperation"] . "</td>";
                echo "<td>" . $row_operation["Etat"] . "</td>";
                echo "<td>" . $row_operation["NomDocteur"] . " " . $row_operation["PrenomDocteur"] . "</td>";
                echo "<td>";
                if ($row_operation["OperationEnCoursID"]) {
                    echo $row_operation["NomSalle"];
                }
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Aucune opération trouvée pour ce patient.";
        }

    } else {
        echo "Aucun résultat trouvé.";
    }
    ?>
</body>
</html>

