<?php
// Connexion à la base de données
$connexion = mysqli_connect("localhost", "root", "guadeloupe", "hospitaldb");

// Récupération de la valeur de recherche depuis le formulaire (ID de l'opération sélectionnée)
$operationID = $_GET["operation"];

// Requête SQL pour rechercher l'opération par son ID
$sql_operation = "SELECT * FROM operations WHERE ID = $operationID";
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
</head>
<body>
    <h1>Résultats de la Recherche d'Opération</h1>
    <?php
    if (mysqli_num_rows($resultat_operation) > 0) {
        $row_operation = mysqli_fetch_assoc($resultat_operation);

        // Afficher les informations de l'opération
        echo "Nom de l'Opération : " . $row_operation["NomOperation"] . "<br>";
        echo "Date de l'Opération : " . $row_operation["DateOperation"] . "<br>";
        echo "État de l'Opération : " . $row_operation["Etat"] . "<br>";

        // Afficher les patients associés à l'opération
        echo "<h2>Patients associés à cette opération :</h2>";
        if (mysqli_num_rows($resultat_patients) > 0) {
            while ($row_patient = mysqli_fetch_assoc($resultat_patients)) {
                echo "Patient : " . $row_patient["Nom"] . " " . $row_patient["Prenom"] . "<br>";
            }
        } else {
            echo "Aucun patient trouvé pour cette opération.";
        }

        // Afficher les médecins associés aux patients de l'opération
        echo "<h2>Médecins associés à cette opération :</h2>";
        if (mysqli_num_rows($resultat_medecins) > 0) {
            while ($row_medecin = mysqli_fetch_assoc($resultat_medecins)) {
                echo "Médecin : " . $row_medecin["Nom"] . " " . $row_medecin["Prenom"] . "<br>";
            }
        } else {
            echo "Aucun médecin trouvé pour cette opération.";
        }

    } else {
        echo "Aucun résultat trouvé pour cette opération.";
    }
    ?>
</body>
</html>
