<?php 
// Code to handle the export functionality

require_once 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$server = "localhost";
$username = "root";
$password = "";
$dbname = "products";

$conn = new mysqli($server, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$format = $_POST['format'];


$sql = "SELECT * FROM products";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    // Generate the export file based on the selected format
    if ($format === 'json') {
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="products.json"');
        echo json_encode($products);
    } elseif ($format === 'excel') {
        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        // Set the active sheet
        $sheet = $spreadsheet->getActiveSheet();

        // Set the column headers
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Description');
        $sheet->setCellValue('D1', 'Price');
        $sheet->setCellValue('E1', 'Image');

        // Loop through the products and populate the sheet
        $row = 2;
        foreach ($products as $product) {
            $sheet->setCellValue('A' . $row, $product['id']);
            $sheet->setCellValue('B' . $row, $product['name']);
            $sheet->setCellValue('C' . $row, $product['description']);
            $sheet->setCellValue('D' . $row, $product['price']);
            $sheet->setCellValue('E' . $row, $product['image']);
            $row++;
        }

        // Create a new Xlsx Writer object
        $writer = new Xlsx($spreadsheet);

        // Set the headers to force download the file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="products.xlsx"');
        header('Cache-Control: max-age=0');

        // Save the spreadsheet to a file
        $writer->save('php://output');
    } elseif ($format === 'csv') {
        // Generate CSV file
        $csvData = "ID,Name,Description,Price,Image\n";
        foreach ($products as $product) {
            $csvData .= '"' . $product['id'] . '","' . $product['name'] . '","' . $product['description'] . '","' . $product['price'] . '","' . $product['image'] . "\"\n";
        }

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="products.csv"');
        echo $csvData;
    } else {
        echo 'Invalid format selected.';
    }
} else {
    echo 'No products found.';
}

$conn->close();

exit;
?>
