<?php
// Code to handle the import functionality


$server = "localhost";
$username = "root";
$password = "";
$dbname = "products";

$conn = new mysqli($server, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$format = $_POST['format'];


$importedFile = $_FILES['import_file']['tmp_name'];

// Code to read the imported file based on the selected format
if ($format === 'json') {
    $jsonData = file_get_contents($importedFile);
    $products = json_decode($jsonData, true);

    if (is_array($products)) {
        foreach ($products as $product) {
            $id = $product['id'];

            $existingQuery = "SELECT id FROM products WHERE id='$id'";
            $existingResults = $conn->query($existingQuery);

            if ($existingResults->num_rows === 0) {
                $name = $product['name'];
                $description = $product['description'];
                $price = $product['price'];
                $image = $product['image'];

                $sql = "INSERT INTO products (id, name, description, price, image) VALUES ('$id', '$name','$description','$price', '$image')";

                $conn->query($sql);
            }
        }
    }
} elseif ($format === 'excel') {

    require_once 'vendor/autoload.php';
    require_once 'vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/IOFactory.php';

    // Load the Excel file
    $spreadsheet = PhpOffice\PhpSpreadsheet\IOFactory::load($importedFile);
    $sheet = $spreadsheet->getActiveSheet();

    // Get the highest row number
    $highestRow = $sheet->getHighestRow();

    // Loop through each row starting from the second row
    for ($row = 2; $row <= $highestRow; $row++) {
        $id = $sheet->getCell('A' . $row)->getValue();

        // Check if the ID already exists in the database
        $existingQuery = "SELECT id FROM products WHERE id='$id'";
        $existingResult = $conn->query($existingQuery);

        if ($existingResult->num_rows === 0) {
            // Import the product data if the ID is not found in the database
            $name = $sheet->getCell('B' . $row)->getValue();
            $description = $sheet->getCell('C' . $row)->getValue();
            $price = $sheet->getCell('D' . $row)->getValue();
            $image = $sheet->getCell('E' . $row)->getValue();

            $sql = "INSERT INTO products (id, name, description, price, image) VALUES ('$id', '$name', '$description', '$price', '$image')";
            $conn->query($sql);
        }
    }
} elseif ($format === 'csv') {
    if (($handle = fopen($importedFile, 'r')) !== false) {
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            $id = $data[0];

            // Check if the ID already exists in the database
            $existingQuery = "SELECT id FROM products WHERE id='$id'";
            $existingResult = $conn->query($existingQuery);
            if ($existingResult->num_rows === 0) {
                // Import the product data if the ID is not found in the database
                $name = $data[1];
                $description = $data[2];
                $price = $data[3];
                $image = $data[4];

                $sql = "INSERT INTO products (id, name, description, price, image) VALUES ('$id', '$name', '$description', '$price', '$image')";
                $conn->query($sql);
            }
        }
        fclose($handle);
    }
} else {
    echo 'Invalid format selected';
}

$conn->close();

header('Location: index.php');
exit;
?>
