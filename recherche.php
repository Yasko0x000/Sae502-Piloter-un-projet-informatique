<?php
// Connexion à la base de données
$connexion = mysqli_connect("localhost", "root", "guadeloupe", "hospitaldb");

// Récupération de la valeur de recherche depuis le formulaire (ID du patient sélectionné)
$patientID = $_GET["patient"];

// Requête SQL pour rechercher le patient par son ID
$sql_patient = "SELECT * FROM patients WHERE ID = $patientID";
$resultat_patient = mysqli_query($connexion, $sql_patient);

// Requête SQL pour récupérer les opérations effectuées par le patient et les médecins associés
$sql_operations = "SELECT o.NomOperation, o.DateOperation, o.Etat, d.Nom AS NomDocteur, d.Prenom AS PrenomDocteur
                  FROM operations o
                  JOIN patients p ON o.ID = p.OperationID
                  JOIN docteurs d ON p.DocteurID = d.ID
                  WHERE p.ID = $patientID";

$resultat_operations = mysqli_query($connexion, $sql_operations);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Résultats de la Recherche</title>
</head>
<body>
    <h1>Résultats de la Recherche</h1>
    <?php
    if (mysqli_num_rows($resultat_patient) > 0) {
        $row_patient = mysqli_fetch_assoc($resultat_patient);

        // Afficher les informations du patient
        echo "Nom : " . $row_patient["Nom"] . "<br>";
        echo "Prénom : " . $row_patient["Prenom"] . "<br>";

        // Afficher les opérations effectuées par le patient et les médecins associés
        echo "<h2>Opérations effectuées par ce patient :</h2>";
        if (mysqli_num_rows($resultat_operations) > 0) {
            while ($row_operation = mysqli_fetch_assoc($resultat_operations)) {
                echo "Opération : " . $row_operation["NomOperation"] . "<br>";
                echo "Date de l'opération : " . $row_operation["DateOperation"] . "<br>";
                echo "État : " . $row_operation["Etat"] . "<br>";
                echo "Médecin : " . $row_operation["NomDocteur"] . " " . $row_operation["PrenomDocteur"] . "<br>";
                echo "<br>";
            }
        } else {
            echo "Aucune opération trouvée pour ce patient.";
        }

    } else {
        echo "Aucun résultat trouvé.";
    }
    ?>
</body>
</html>
