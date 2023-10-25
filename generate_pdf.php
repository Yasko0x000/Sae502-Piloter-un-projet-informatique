<?php
require('fpdf/fpdf.php'); // Inclure la bibliothèque FPDF

// Créez une classe personnalisée basée sur FPDF
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

// Connexion à la base de données
$connexion = mysqli_connect("localhost", "root", "", "hospitaldb");

// Créez une instance de la classe PDF
$pdf = new PDF('L');
$pdf->AliasNbPages();

// Ajoutez une page au PDF
$pdf->AddPage();

// Liste des Patients
$pdf->ChapterTitle('Liste des Patients');

// Ajoutez un en-tête de tableau
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(60, 10, 'Nom', 1);
$pdf->Cell(60, 10, 'Prenom', 1);
$pdf->Cell(60, 10, 'Date de Naissance', 1);
$pdf->Ln(); // Saut de ligne

// Recuperez les donnees des patients depuis la base de donnees
$sql_patients = "SELECT Nom, Prenom, DateNaissance FROM patients";
$resultat_patients = mysqli_query($connexion, $sql_patients);

$pdf->SetFont('Arial', '', 12);
while ($row = mysqli_fetch_assoc($resultat_patients)) {
    // Remplissez les cellules du tableau avec les données
    $pdf->Cell(60, 10, $row['Nom'], 1);
    $pdf->Cell(60, 10, $row['Prenom'], 1);
    $pdf->Cell(60, 10, $row['DateNaissance'], 1);
    $pdf->Ln(); // Saut de ligne
}

// ...

$pdf->AddPage();
$pdf->ChapterTitle('Liste des Medecins');

// Ajoutez un en-tête de tableau pour les médecins
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(60, 10, 'Nom', 1);
$pdf->Cell(60, 10, 'Prenom', 1);
$pdf->Ln(); // Saut de ligne

// Recuperez les donnees des médecins depuis la base de donnees
$sql_medecins = "SELECT Nom, Prenom FROM docteurs";
$resultat_medecins = mysqli_query($connexion, $sql_medecins);

$pdf->SetFont('Arial', '', 12);
while ($row = mysqli_fetch_assoc($resultat_medecins)) {
    // Remplissez les cellules du tableau avec les données
    $pdf->Cell(60, 10, $row['Nom'], 1);
    $pdf->Cell(60, 10, $row['Prenom'], 1);
    $pdf->Ln(); // Saut de ligne
}

// ...

// Liste des Operations
$pdf->AddPage();
$pdf->ChapterTitle('Liste des Operations');

// Ajoutez un en-tête de tableau pour les opérations
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(60, 10, 'Nom de l\'Operation', 1);
$pdf->Cell(50, 10, 'Date de l\'Operation', 1);
$pdf->Cell(40, 10, 'Etat de l\'Operation', 1);
$pdf->Cell(50, 10, 'Salle de l\'Operation', 1);
$pdf->Cell(40, 10, 'Patient', 1);
$pdf->Cell(40, 10, 'Medecin', 1);
$pdf->Ln(); // Saut de ligne

// Recuperez les donnees des opérations depuis la base de donnees
$sql_operations = "SELECT o.NomOperation, p.Nom AS PatientNom, p.Prenom AS PatientPrenom, o.DateOperation, o.Etat, s.NomSalle, d.Nom AS DocteurNom, d.Prenom AS DocteurPrenom
                   FROM operations o
                   JOIN patients p ON o.ID = p.OperationID
                   JOIN docteurs d ON p.DocteurID = d.ID
                   LEFT JOIN SalleDesOperations s ON o.ID = s.OperationEnCoursID";
$resultat_operations = mysqli_query($connexion, $sql_operations);

$pdf->SetFont('Arial', '', 12);
while ($row = mysqli_fetch_assoc($resultat_operations)) {
    // Remplissez les cellules du tableau avec les données
    $pdf->Cell(60, 10, $row['NomOperation'], 1);
    $pdf->Cell(50, 10, $row['DateOperation'], 1);
    $pdf->Cell(40, 10, $row['Etat'], 1);
    $pdf->Cell(50, 10, $row['NomSalle'], 1);
    $pdf->Cell(40, 10, $row['PatientNom'] . " " . $row['PatientPrenom'], 1);
    $pdf->Cell(40, 10, $row['DocteurNom'] . " " . $row['DocteurPrenom'], 1);
    $pdf->Ln(); // Saut de ligne
}

// Historique d'accès aux salles d'opération
$pdf->AddPage();
$pdf->ChapterTitle("Historique d'acces aux salles d'operation");

// Ajoutez un en-tête de tableau pour l'historique d'accès
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 10, 'Nom de la Salle', 1);
$pdf->Cell(40, 10, 'ID du Badge RFID', 1);
$pdf->Cell(60, 10, 'Opération en cours', 1);
$pdf->Cell(60, 10, 'Dernier Accès', 1);
$pdf->Cell(60, 10, 'État de l\'Opération', 1);
$pdf->Ln(); // Saut de ligne

// Récupérez les données des accès aux salles d'opération depuis la base de données
$sql_operations = "SELECT s.NomSalle, s.DateAcces, b.IDBadgeRFID, o.NomOperation, o.DateOperation, o.Etat
                    FROM salledesoperations s
                    LEFT JOIN badgesrfid b ON s.IDBadgeRFID = b.ID
                    LEFT JOIN operations o ON s.OperationEnCoursID = o.ID";
$resultat_operations = mysqli_query($connexion, $sql_operations);

$pdf->SetFont('Arial', '', 12);
while ($row = mysqli_fetch_assoc($resultat_operations)) {
    // Remplissez les cellules du tableau avec les données
    $pdf->Cell(50, 10, $row['NomSalle'], 1);
    $pdf->Cell(40, 10, $row['IDBadgeRFID'], 1);
    $pdf->Cell(60, 10, $row['NomOperation'], 1);
    $pdf->Cell(60, 10, $row['DateAcces'], 1);
    $pdf->Cell(60, 10, $row['Etat'], 1);
    $pdf->Ln(); // Saut de ligne
}


$pdf->Output();
