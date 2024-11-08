<?php
session_start();

include("../resources/connection.php");

if (!isset($_SESSION['staff_id'])) {
    header("Location: ../staff_login.php");
    exit();
}

$roll_no = isset($_GET['roll_no']) ? $_GET['roll_no'] : null;

if (!isset($_GET['roll_no']) || empty($_GET['roll_no'])) {
    echo "Student Roll No. not specified!";
    exit();
} else {
    $roll_no = $_GET['roll_no'];
}

// Fetch student details
$student_query = "SELECT * FROM students WHERE roll_no = ?";
$stmt = $conn->prepare($student_query);

if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("s", $roll_no);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "No student found with Roll No.: " . htmlspecialchars($roll_no);
    exit();
}

$student = $result->fetch_assoc();
$stmt->close();

// Load TCPDF library
require_once('../TCPDF-main/TCPDF-main/tcpdf.php');

// Create new PDF document
$pdf = new TCPDF();

// Set document information
$pdf->SetCreator('Your Company');
$pdf->SetAuthor('Staff');
$pdf->SetTitle('Student Profile');
$pdf->SetSubject('Student Information');

// Set font
$pdf->SetFont('helvetica', '', 12);

// Add a page
$pdf->AddPage();

// Set title
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Student Profile - ' . $student["name"], 0, 1, 'C');

// Set student details in the PDF
$pdf->SetFont('helvetica', '', 12);
$pdf->Ln(5);
$pdf->Cell(0, 10, 'Register Number: ' . $student["roll_no"], 0, 1);
$pdf->Cell(0, 10, 'Name: ' . $student["name"], 0, 1);
$pdf->Cell(0, 10, 'Department: ' . $student["department"], 0, 1);
$pdf->Cell(0, 10, 'Year of Study: ' . $student["year"], 0, 1);
$pdf->Cell(0, 10, 'Date of Birth: ' . $student["dob"], 0, 1);
$pdf->Cell(0, 10, 'Age: ' . $student["age"], 0, 1);
$pdf->Cell(0, 10, 'Sex: ' . $student["sex"], 0, 1);
$pdf->Cell(0, 10, 'Community: ' . $student["community"], 0, 1);
$pdf->Cell(0, 10, 'Place of Birth: ' . $student["place_of_birth"], 0, 1);
$pdf->Cell(0, 10, 'Blood Group: ' . $student["blood_group"], 0, 1);
$pdf->Cell(0, 10, 'Caste: ' . $student["caste"], 0, 1);
$pdf->Cell(0, 10, 'Religion: ' . $student["religion"], 0, 1);
$pdf->Cell(0, 10, 'Mother Tongue: ' . $student["mother_tongue"], 0, 1);

// Reference persons (handling empty fields)
$pdf->Cell(0, 10, 'Reference Persons:', 0, 1);
for ($i = 1; $i <= 3; $i++) {
    $name = "name_" . $i;
    $phone = "phone_" . $i;
    $address = "address_" . $i;
    if (!empty($student[$name]) && !empty($student[$phone]) && !empty($student[$address])) {
        $pdf->Cell(0, 10, "Ref $i: " . $student[$name] . " | " . $student[$phone] . " | " . $student[$address], 0, 1);
    }
}


// Contact Info
$pdf->Cell(0, 10, 'Email: ' . $student["email"], 0, 1);
$pdf->Cell(0, 10, 'Phone: ' . $student["phone"], 0, 1);

// Additional Info: Photos
$pdf->Cell(0, 10, 'Student Photo: ', 0, 1);
$pdf->Image('../static/img/' . $student["profile_photo"], 60, 180, 40, 40, '', '', '', true, 150, '', false, false, 1, false, false, false);

// Disciplinary Issues


// Output the PDF to the browser for download
$pdf->Output('student_profile_' . $student['roll_no'] . '.pdf', 'D');
?>
