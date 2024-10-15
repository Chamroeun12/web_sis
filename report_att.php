<?php
require('fpdf/fpdf.php');  // For PDF generation
require 'vendors/autoload.php'; // Autoloader for PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; // Xlsx for better compatibility

include_once 'connection.php'; // Database connection

// Function to fetch student data
function fetchStudentData($conn) {
    if (isset($_POST['classname'])) {
        // Sanitize input to prevent SQL injection
        $classname = filter_input(INPUT_POST, 'classname', FILTER_SANITIZE_STRING);

        $query = "SELECT
            s.En_name AS Student_Name,
            s.Gender,
            s.DOB,
            co.Course_name,
            c.Class_name,
            att.Date AS Attendance_Date,
            att.Attendance
        FROM
            tb_attendance att
        INNER JOIN
            tb_class c ON att.Class_id = c.ClassID
        INNER JOIN
            tb_course co ON c.course_id = co.id
        INNER JOIN
            tb_teacher t ON c.Teacher_id = t.id
        INNER JOIN
            tb_student s ON att.Stu_id = s.ID
        WHERE
            c.Class_name = :classname;"; // Use a parameterized query

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':classname', $classname, PDO::PARAM_STR); // Bind parameter
        $stmt->execute();
        return [$classname, $stmt->fetchAll(PDO::FETCH_ASSOC)]; // Return classname and data
    }
    return [null, []]; // Return null and empty array if classname is not set
}

// Fetch data from the database
list($classname, $data) = fetchStudentData($conn);

if (empty($data)) {
    echo "No records found for the specified class.";
    exit; // Exit if no data is available
}

if (isset($_POST['export_excel'])) {
    // Generate Excel using PhpSpreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set column headers
    $headers = ['Student Name', 'Gender', 'DOB', 'Course Name', 'Class Name', 'Attendance Date', 'Attendance'];
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
        $sheet->setCellValue('D' . $rowCount, $row['Course_name']);
        $sheet->setCellValue('E' . $rowCount, $row['Class_name']);
        $sheet->setCellValue('F' . $rowCount, $row['Attendance_Date']);
        $sheet->setCellValue('G' . $rowCount, $row['Attendance']);
        $rowCount++;
    }

    // Save Excel file with dynamic filename
    $filename = "attendance_report_{$classname}_" . date('Y-m-d') . ".xlsx";
    $writer = new Xlsx($spreadsheet); // Use Xlsx for better compatibility
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment;filename=\"$filename\"");
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit; // Exit after outputting the file
} elseif (isset($_POST['export_pdf'])) {
    // Create a new PDF document using TCPDF
    $pdf = new TCPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle('Students Report Attendance');
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
                  <th style="color: blue; text-align: center;">Attendance Date</th>
                  <th style="color: blue; text-align: center;">Attendance</th>
              </tr>';

    foreach ($data as $row) {
        $html .= '<tr>
                  <td style="text-align: center;">' . htmlspecialchars($row['Student_Name']) . '</td>
                  <td style="text-align: center;">' . htmlspecialchars($row['Gender']) . '</td>
                  <td style="text-align: center;">' . htmlspecialchars($row['DOB']) . '</td>
                  <td style="text-align: center;">' . htmlspecialchars($row['Class_name']) . '</td>
                  <td style="text-align: center;">' . htmlspecialchars($row['Course_name']) . '</td>
                  <td style="text-align: center;">' . htmlspecialchars($row['Attendance_Date']) . '</td>
                  <td style="text-align: center;">' . htmlspecialchars($row['Attendance']) . '</td>
              </tr>';
    }

    $html .= '</table>';
    $pdf->writeHTML($html, true, false, true, false, '');

    // Output PDF with dynamic filename
    $pdfFilename = "students_report_attendance_{$classname}_" . date('Y-m-d') . ".pdf";
    $pdf->Output($pdfFilename, 'I'); // Output PDF inline
    exit; // Exit after outputting the file
}
?>
