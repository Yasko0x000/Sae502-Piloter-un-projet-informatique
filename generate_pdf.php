<?php
require('fpdf/fpdf.php'); // Inclure la bibliothèque FPDF

// Creez une classe personnalisee basee sur FPDF
class PDF extends FPDF {
    function Header() {
        // En-tête du PDF
        $this->SetFont('Arial','B',12);
        $this->Cell(0,10,'Liste des Patients, Medecins et Operations',0,1,'C');
        $this->Ln(10); // Saut de ligne
    }

    function ChapterTitle($title) {
        // Titre de section
        $this->SetFont('Arial','B',12);
        $this->Cell(0,6,$title,0,1);
        $this->Ln(6); // Saut de ligne
    }

    function ChapterBody($content) {
        // Contenu de section
        $this->SetFont('Arial','',12);
        $this->MultiCell(0,10,$content);
        $this->Ln(); // Saut de ligne
    }
}

// Connexion à la base de donnees
$connexion = mysqli_connect("localhost", "root", "", "hospitaldb");

// Creez une instance de la classe PDF
$pdf = new PDF();
$pdf->AliasNbPages();

// Ajoutez une page au PDF
$pdf->AddPage();

// Liste des Patients
$pdf->ChapterTitle('Liste des Patients');

// Recuperez les donnees des patients depuis la base de donnees
$sql_patients = "SELECT Nom, Prenom, DateNaissance FROM patients";
$resultat_patients = mysqli_query($connexion, $sql_patients);

while ($row = mysqli_fetch_assoc($resultat_patients)) {
    $content = 'Nom Patient : ' . $row['Nom'] . " " . $row['Prenom'] ."\n";
    $content .= 'Date de Naissance : ' . $row['DateNaissance'] . "\n";
    $pdf->ChapterBody($content);
}

// Liste des Medecins
$pdf->AddPage();
$pdf->ChapterTitle('Liste des Medecins');

// Recuperez les donnees des medecins depuis la base de donnees
$sql_medecins = "SELECT Nom, Prenom FROM docteurs";
$resultat_medecins = mysqli_query($connexion, $sql_medecins);

while ($row = mysqli_fetch_assoc($resultat_medecins)) {
    $content = 'Nom medecin : ' . $row['Nom'] . " " . $row['Prenom'] . "\n";
    $pdf->ChapterBody($content);
}

// Liste des Operations
$pdf->AddPage();
$pdf->ChapterTitle('Liste des Operations');


// Recuperation de la valeur de recherche depuis le formulaire (ID de l'operation selectionnee)
//$operationID = $_GET["operation"];

// Recuperez les donnees des operations depuis la base de donnees
$sql_operations = "SELECT o.NomOperation, p.Nom AS PatientNom, p.Prenom AS PatientPrenom, o.DateOperation, o.Etat, s.NomSalle, d.Nom AS DocteurNom, d.Prenom AS DocteurPrenom
FROM operations o
JOIN patients p ON o.ID = p.OperationID
JOIN docteurs d ON p.DocteurID = d.ID
LEFT JOIN SalleDesOperations s ON o.ID = s.OperationEnCoursID";
$resultat_operations = mysqli_query($connexion, $sql_operations);

while ($row = mysqli_fetch_assoc($resultat_operations)) {
    $content = 'Nom de l\'Operation : ' . $row['NomOperation'] . "\n";
    $content .= 'Date de l\'Operation : ' . $row['DateOperation'] . "\n";
    $content .= 'Etat de l\'Operation : ' . $row['Etat'] . "\n";
    $content .= 'Salle de l\'Operation : ' . $row['NomSalle'] . "\n";
    $content .= 'Patient : ' . $row['PatientNom'] . " " . $row['PatientPrenom'] .  "\n";
    $content .= 'Medecin : ' . $row['DocteurNom'] . " " . $row['DocteurPrenom'] .  "\n";
    $pdf->ChapterBody($content);
}



// Historique d'acces au salles d'operation
$pdf->AddPage();
$pdf->ChapterTitle('Historique d\'acces au salles d\'operation');


// Recuperation de la valeur de recherche depuis le formulaire (ID de l'operation selectionnee)
//$operationID = $_GET["operation"];

// Recuperez les donnees des operations depuis la base de donnees
$sql_operations = "SELECT s.NomSalle, s.DateAcces, b.IDBadgeRFID, o.NomOperation, o.DateOperation, o.Etat
                    FROM salledesoperations s
                    LEFT JOIN badgesrfid b ON s.IDBadgeRFID = b.ID
                    LEFT JOIN operations o ON s.OperationEnCoursID = o.ID";
$resultat_operations = mysqli_query($connexion, $sql_operations);

while ($row = mysqli_fetch_assoc($resultat_operations)) {
    $content = 'Nom de la Salle : ' . $row['NomSalle'] . "\n";
    $content .= 'ID du Badge RFID : ' . $row['IDBadgeRFID'] . "\n";
    $content .= 'Opération en cours : ' . $row['NomOperation'] . "\n";
    $content .= 'Dernier Acces : ' . $row['DateAcces'] . "\n";
    $content .= 'Etat de l\'Operation ' . $row['Etat'] . "\n";
    $pdf->ChapterBody($content);
}

// Generez le PDF
$pdf->Output();
?>
