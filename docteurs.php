<?php
// Connexion à la base de données
$connexion = mysqli_connect("localhost", "root", "", "hospitaldb");

// Récupération de l'ID du médecin depuis la requête GET
$medecinID = $_GET["medecin"];

// Requête SQL pour rechercher le médecin par son ID
$sql_medecin = "SELECT * FROM docteurs WHERE ID = $medecinID";
$resultat_medecin = mysqli_query($connexion, $sql_medecin);

// Requête SQL pour récupérer les patients traités par le médecin, y compris le nom de l'opération
$sql_patients = "SELECT p.Nom, p.Prenom, o.NomOperation, o.Etat
                FROM patients p
                LEFT JOIN operations o ON p.OperationID = o.ID
                WHERE p.DocteurID = $medecinID";
$resultat_patients = mysqli_query($connexion, $sql_patients);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Résultats de la Recherche de Médecin</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Résultats de la Recherche de Médecin</h1>
    <?php
    if (mysqli_num_rows($resultat_medecin) > 0) {
        $row_medecin = mysqli_fetch_assoc($resultat_medecin);

        echo "<div class='medecin-info'>";
        echo "<h2>Médecin :</h2>";
        echo "<p>" . $row_medecin["Nom"] . " " .  $row_medecin["Prenom"] . "</p>";
        echo "</div>";

        // Afficher les patients sous la responsabilité du médecin
        echo "<h2>Patients sous la responsabilité de ce médecin :</h2>";
        if (mysqli_num_rows($resultat_patients) > 0) {
            echo "<table class='patient-table'>";
            echo "<tr>";
            echo "<th>Patient</th>";
            echo "<th>Opération en cours</th>";
            echo "<th>État de l'Opération</th>";
            echo "</tr>";

            while ($row_patient = mysqli_fetch_assoc($resultat_patients)) {
                echo "<tr>";
                echo "<td>" . $row_patient["Nom"] . " " . $row_patient["Prenom"] . "</td>";
                echo "<td>";
                if ($row_patient["NomOperation"] !== null) {
                    echo $row_patient["NomOperation"];
                } else {
                    echo "Aucune opération en cours";
                }
                echo "</td>";
                echo "<td>";
                if ($row_patient["Etat"] === "En cours") {
                    echo "(En cours)";
                } else {
                    echo "(Terminée)";
                }
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Aucun patient trouvé pour ce médecin.";
        }
    } else {
        echo "Aucun résultat trouvé pour ce médecin.";
    }
    ?>
</body>
</html>
