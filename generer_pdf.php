<?php
require('fpdf.php'); // Inclure la bibliothèque FPDF

// Créez une classe personnalisée basée sur FPDF
class PDF extends FPDF {
    function Header() {
        // En-tête du PDF
        $this->SetFont('Arial','B',12);
        $this->Cell(0,10,'Liste des Patients, Médecins et Opérations',0,1,'C');
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
$connexion = mysqli_connect("localhost", "root", "guadeloupe", "hospitaldb");

// Créez une instance de la classe PDF
$pdf = new PDF();
$pdf->AliasNbPages();

// Ajoutez une page au PDF
$pdf->AddPage();

// Liste des Patients
$pdf->ChapterTitle('Liste des Patients');

// Récupérez les données des patients depuis la base de données
$sql_patients = "SELECT Nom, Prenom, DateNaissance FROM patients";
$resultat_patients = mysqli_query($connexion, $sql_patients);

while ($row = mysqli_fetch_assoc($resultat_patients)) {
    $content = 'Nom : ' . $row['Nom'] . "\n";
    $content .= 'Prénom : ' . $row['Prenom'] . "\n";
    $content .= 'Date de Naissance : ' . $row['DateNaissance'] . "\n";
    $pdf->ChapterBody($content);
}

// Liste des Médecins
$pdf->AddPage();
$pdf->ChapterTitle('Liste des Médecins');

// Récupérez les données des médecins depuis la base de données
$sql_medecins = "SELECT Nom, Prenom FROM docteurs";
$resultat_medecins = mysqli_query($connexion, $sql_medecins);

while ($row = mysqli_fetch_assoc($resultat_medecins)) {
    $content = 'Nom : ' . $row['Nom'] . "\n";
    $content .= 'Prénom : ' . $row['Prenom'] . "\n";
    $pdf->ChapterBody($content);
}

// Liste des Opérations
$pdf->AddPage();
$pdf->ChapterTitle('Liste des Opérations');

// Récupérez les données des opérations depuis la base de données
$sql_operations = "SELECT NomOperation, DateOperation, Etat FROM operations";
$resultat_operations = mysqli_query($connexion, $sql_operations);

while ($row = mysqli_fetch_assoc($resultat_operations)) {
    $content = 'Nom de l\'Opération : ' . $row['NomOperation'] . "\n";
    $content .= 'Date de l\'Opération : ' . $row['DateOperation'] . "\n";
    $content .= 'État de l\'Opération : ' . $row['Etat'] . "\n";
    $pdf->ChapterBody($content);
}

// Générez le PDF
$pdf->Output();
?>
