<?php
// Connexion à la base de données
$connexion = mysqli_connect("localhost", "root", "guadeloupe", "hospitaldb");

// Récupération de la valeur de recherche depuis le formulaire
$recherche = $_GET["nom_prenom_patient"];

// Requête SQL pour rechercher le patient par nom ou prénom
$sql_patient = "SELECT * FROM patients WHERE Nom LIKE '%$recherche%' OR Prenom LIKE '%$recherche'";
$resultat_patient = mysqli_query($connexion, $sql_patient);

if (mysqli_num_rows($resultat_patient) > 0) {
    while ($row_patient = mysqli_fetch_assoc($resultat_patient)) {
        // Afficher les informations du patient
        echo "Nom : " . $row_patient["Nom"] . "<br>";
        echo "Prénom : " . $row_patient["Prenom"] . "<br>";

        // Récupérer les informations de l'opération liée
        $operationID = $row_patient["OperationID"];
        $sql_operation = "SELECT * FROM operations WHERE ID = $operationID";
        $resultat_operation = mysqli_query($connexion, $sql_operation);
        $row_operation = mysqli_fetch_assoc($resultat_operation);

        // Récupérer les informations du médecin lié
        $docteurID = $row_patient["DocteurID"];
        $sql_docteur = "SELECT * FROM docteurs WHERE ID = $docteurID";
        $resultat_docteur = mysqli_query($connexion, $sql_docteur);
        $row_docteur = mysqli_fetch_assoc($resultat_docteur);

        // Afficher les informations de l'opération et du médecin
        echo "Opération : " . $row_operation["NomOperation"] . "<br>";
        echo "Médecin : " . $row_docteur["Nom"] . " " . $row_docteur["Prenom"] . "<br>";
        // Afficher d'autres informations ici
        echo "<br>";
    }
} else {
    echo "Aucun résultat trouvé.";
}
?>
