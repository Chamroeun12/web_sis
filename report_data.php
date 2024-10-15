<?php
require('fpdf/fpdf.php');  // For PDF generation
require 'vendors/autoload.php'; // Make sure the autoloader for PhpSpreadsheet is correctly set up
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; // Change to Xlsx for better compatibility

include_once 'connection.php'; // For database connection

// Fetch data from the database
$data = [];
$query = "SELECT
    s.En_name AS Student_Name,
    s.Gender,
    s.DOB,
    c.Class_name,
    co.Course_name,
    c.Shift,
    t.En_name AS Teacher_Name,
    s.Phone
FROM
    tb_add_to_class ad
INNER JOIN
    tb_class c ON ad.Class_id = c.ClassID
INNER JOIN
    tb_course co ON c.course_id = co.id
INNER JOIN
    tb_teacher t ON c.Teacher_id = t.id
INNER JOIN
    tb_student s ON ad.Stu_id = s.ID;";

$stmt = $conn->prepare($query);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch the data

if (isset($_POST['export_excel'])) {
    // Generate Excel using PhpSpreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set column headers
    $headers = ['Student Name', 'Gender', 'DOB', 'Class Name', 'Course Name', 'Shift', 'Teacher Name', 'Phone'];
    $column = 'A';
    foreach ($headers as $header) {
        $sheet->setCellValue($column . '1', $header);
        $column++;
    }

    // Fill data
    $rowCount = 2; // Start from the second row
    foreach ($data as $row) {
        $sheet->setCellValue('A' . $rowCount, $row['Student_Name']);
        $sheet->setCellValue('B' . $rowCount, $row['Gender']);
        $sheet->setCellValue('C' . $rowCount, $row['DOB']);
        $sheet->setCellValue('D' . $rowCount, $row['Class_name']);
        $sheet->setCellValue('E' . $rowCount, $row['Course_name']);
        $sheet->setCellValue('F' . $rowCount, $row['Shift']);
        $sheet->setCellValue('G' . $rowCount, $row['Teacher_Name']);
        $sheet->setCellValue('H' . $rowCount, $row['Phone']);
        $rowCount++;
    }

    // Save Excel file
    $writer = new Xlsx($spreadsheet); // Use Xlsx for better compatibility
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="report.xlsx"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit; // Exit after outputting the file
} elseif (isset($_POST['export_pdf'])) {
    // Create a new PDF document
    $pdf = new TCPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle('Students In Class');
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 12);

    // Add content to PDF
    $html = '<h1 style="color: blue; text-align: center;">Students In Class</h1>';
    $html .= '<table border="1" cellspacing="0" cellpadding="4">
              <tr style="background-color: powderblue;">
                  <th style="color: blue; text-align: center;">Student Name</th>
                  <th style="color: blue; text-align: center;">Gender</th>
                  <th style="color: blue; text-align: center;">DOB</th>
                  <th style="color: blue; text-align: center;">Class Name</th>
                  <th style="color: blue; text-align: center;">Course Name</th>
                  <th style="color: blue; text-align: center;">Shift</th>
                  <th style="color: blue; text-align: center;">Teacher Name</th>
                  <th style="color: blue; text-align: center;">Phone</th>
              </tr>';

    foreach ($data as $row) {
        $html .= '<tr>
                  <td style="text-align: center;">' . htmlspecialchars($row['Student_Name']) . '</td>
                  <td style="text-align: center;">' . htmlspecialchars($row['Gender']) . '</td>
                  <td style="text-align: center;">' . htmlspecialchars($row['DOB']) . '</td>
                  <td style="text-align: center;">' . htmlspecialchars($row['Class_name']) . '</td>
                  <td style="text-align: center;">' . htmlspecialchars($row['Course_name']) . '</td>
                  <td style="text-align: center;">' . htmlspecialchars($row['Shift']) . '</td>
                  <td style="text-align: center;">' . htmlspecialchars($row['Teacher_Name']) . '</td>
                  <td style="text-align: center;">' . htmlspecialchars($row['Phone']) . '</td>
              </tr>';
    }

    $html .= '</table>';
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('users_report.pdf', 'I'); // Output PDF
    exit; // Exit after outputting the file
}
?>
