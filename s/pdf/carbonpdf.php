<?php
require('../fpdf186/fpdf.php');

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Set background color (light gray)
        $this->SetFillColor(211, 211, 211);
        // Draw background rectangle
        $this->Rect(0, 0, 210, 297, 'F');

        // Navbar
        $this->SetFillColor(0, 0, 0); // Black color for navbar
        $this->Rect(0, 0, 210, 20, 'F');

        // Title
        $this->SetFont('Arial', 'B', 15);
        $this->SetTextColor(255, 255, 255); // White text color
        $this->Cell(30, 10, 'Back', 0, 0, 'C');
        $this->SetFillColor(255, 255, 255); // White fill color
        $this->Rect(10, 25, 30, 10, 'F'); // Rectangle for the button
        $this->SetTextColor(0, 0, 0); // Black text color
$this->SetFont('Arial', 'U', 10);
$this->SetXY(10, 25);
$this->Cell(30, 10, 'Back', 0, 0, 'C');
$this->Link(10, 25, 30, 10, 'index.php');
        $this->Cell(30, 10, 'Carbon Data', 0, 0, 'C');

        // Reset text color
        $this->SetTextColor(255, 255, 255);
        $this->Ln(20); // Move below the navbar

        // Add clickable area (back button)
        $this->SetFillColor(255, 255, 255); // White fill color
        $this->Rect(10, 25, 30, 10, 'F'); // Rectangle for the button

        // Set the link appearance
        $this->SetTextColor(0, 0, 255); // Blue text color
        $this->SetFont('Arial', 'U', 10);

        // Add the link text
    
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from the bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    // Override the default onclick method to check for the link click
    function _dochecks()
    {
        parent::_dochecks();
        if ($this->currentLink) {
            $this->Link($this->lMargin, $this->tMargin, $this->getPageWidth() - $this->rMargin - $this->lMargin, $this->FontSize, '');
        }
    }
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', '', 12);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "s1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from the 'carbon' table
$query = "SELECT * FROM carbon";
$result = $conn->query($query);

// Display data in a tabular form
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 10, 'ID', 1);
$pdf->Cell(60, 10, 'Carbon Data', 1);
$pdf->Cell(40, 10, 'Date', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);

while ($row = $result->fetch_assoc()) {
    $pdf->Cell(20, 10, $row['id'], 1);
    $pdf->Cell(60, 10, $row['carbon'], 1);
    $pdf->Cell(40, 10, $row['date'], 1);
    $pdf->Ln();
}

// Output the PDF
$pdf->Output();

// Close the database connection
$conn->close();
?>
