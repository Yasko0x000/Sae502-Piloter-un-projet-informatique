<?php
// Connexion à la base de données
$connexion = mysqli_connect("localhost", "root", "guadeloupe", "hospitaldb");

// Récupération de l'ID du médecin depuis la requête GET
$medecinID = $_GET["medecin"];

// Requête SQL pour rechercher le médecin par son ID
$sql_medecin = "SELECT * FROM docteurs WHERE ID = $medecinID";
$resultat_medecin = mysqli_query($connexion, $sql_medecin);

// Requête SQL pour récupérer les patients traités par le médecin
$sql_patients = "SELECT p.Nom, p.Prenom FROM patients p WHERE p.DocteurID = $medecinID";
$resultat_patients = mysqli_query($connexion, $sql_patients);

// Requête SQL pour récupérer les opérations effectuées par le médecin
$sql_operations = "SELECT o.NomOperation, o.DateOperation, o.Etat 
                  FROM operations o
                  JOIN patients p ON o.ID = p.OperationID
                  WHERE p.DocteurID = $medecinID";
$resultat_operations = mysqli_query($connexion, $sql_operations);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Résultats de la Recherche de Médecin</title>
</head>
<body>
    <h1>Résultats de la Recherche de Médecin</h1>
    <?php
    if (mysqli_num_rows($resultat_medecin) > 0) {
        $row_medecin = mysqli_fetch_assoc($resultat_medecin);

        // Afficher les informations du médecin
        echo "Nom du Médecin : " . $row_medecin["Nom"] . "<br>";
        echo "Prénom du Médecin : " . $row_medecin["Prenom"] . "<br>";

        // Afficher les patients traités par le médecin
        echo "<h2>Patients traités par ce médecin :</h2>";
        if (mysqli_num_rows($resultat_patients) > 0) {
            while ($row_patient = mysqli_fetch_assoc($resultat_patients)) {
                echo "Patient : " . $row_patient["Nom"] . " " . $row_patient["Prenom"] . "<br>";
            }
        } else {
            echo "Aucun patient trouvé pour ce médecin.";
        }

        // Afficher les opérations effectuées par le médecin
        echo "<h2>Opérations effectuées par ce médecin :</h2>";
        if (mysqli_num_rows($resultat_operations) > 0) {
            while ($row_operation = mysqli_fetch_assoc($resultat_operations)) {
                echo "Opération : " . $row_operation["NomOperation"] . "<br>";
                echo "Date de l'Opération : " . $row_operation["DateOperation"] . "<br>";
                echo "État de l'Opération : " . $row_operation["Etat"] . "<br>";
                echo "<br>";
            }
        } else {
            echo "Aucune opération trouvée pour ce médecin.";
        }

    } else {
        echo "Aucun résultat trouvé pour ce médecin.";
    }
    ?>
</body>
</html>
