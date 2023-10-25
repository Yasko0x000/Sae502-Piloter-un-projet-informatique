<!DOCTYPE html>
<html>
<head>
    <title>Gestion des Patients, Médecins et Opérations</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Gestion des Patients, Médecins et Opérations</h1>
    
    <div class="search-section">
    <h2>Rechercher un Patient</h2>
    <form action="patient.php" method="GET">
        <label for="patient">Sélectionnez un patient :</label>
        <select name="patient" id="patient">
            <?php
            // Connectez-vous à la base de données et récupérez la liste des patients
            $connexion = mysqli_connect("localhost", "root", "", "HospitalDB");
            $sql_patients = "SELECT ID, Nom, Prenom FROM Patients";
            $resultat_patients = mysqli_query($connexion, $sql_patients);

            // Parcourez les résultats pour afficher les options
            while ($row = mysqli_fetch_assoc($resultat_patients)) {
                echo "<option value='" . $row['ID'] . "'>" . $row['Nom'] . " " . $row['Prenom'] . "</option>";
            }
            ?>
        </select>
        <input type="submit" value="Rechercher Patient">
    </form>
</div>

<div class="search-section">
    <h2>Rechercher un Médecin</h2>
    <form action="docteurs.php" method="GET">
        <label for="medecin">Sélectionnez un médecin :</label>
        <select name="medecin" id="medecin">
            <?php
            // Connectez-vous à la base de données et récupérez la liste des médecins
            $connexion = mysqli_connect("localhost", "root", "", "hospitaldb");
            $sql_medecins = "SELECT ID, Nom, Prenom FROM docteurs";
            $resultat_medecins = mysqli_query($connexion, $sql_medecins);

            // Parcourez les résultats pour afficher les options
            while ($row = mysqli_fetch_assoc($resultat_medecins)) {
                echo "<option value='" . $row['ID'] . "'>" . $row['Nom'] . " " . $row['Prenom'] . "</option>";
            }
            ?>
        </select>
        <input type="submit" value="Rechercher Médecin">
    </form>
</div>

<div class="search-section">
    <h2>Rechercher une Opération</h2>
    <form action="operations.php" method="GET">
        <label for="operation">Sélectionnez une opération :</label>
        <select name="operation" id="operation">
            <?php
            // Connectez-vous à la base de données et récupérez la liste des opérations
            $connexion = mysqli_connect("localhost", "root", "", "hospitaldb");
            $sql_operations = "SELECT ID, NomOperation FROM operations";
            $resultat_operations = mysqli_query($connexion, $sql_operations);

            // Parcourez les résultats pour afficher les options
            while ($row = mysqli_fetch_assoc($resultat_operations)) {
                echo "<option value='" . $row['ID'] . "'>" . $row['NomOperation'] . "</option>";
            }
            ?>
        </select>
        <input type="submit" value="Rechercher Opération">
    </form>
</div>


<div class="search-section">
    <h2>Rechercher une Opération</h2>
    <form action="salles.php" method="GET">
        <input type="submit" value="Voir Historique des salles d'operations">
    </form>
</div>




<a href="generate_pdf.php" class="btn-download">Télécharger en PDF</a>


    <div class="footer">
        <p>© 2023 Hospital Management System</p>
    </div>
</body>
</html>
