<?php 

//Code to handle the adding of new product

$server = "localhost";
$username = "root";
$password = "";
$dbname ="products";

$conn = new mysqli($server, $username, $password, $dbname);

if($conn->connect_error){
    die("Connection failed: " . $connect_error);
}

//Unique id for products

function generateUniqueID(){
    $timestamp = time();
    $randomNumber = mt_rand(100000, 999999);
    $uniqueID = $timestamp . $randomNumber;
    return $uniqueID;


}

//Handle file upload and move the uploaded image to a specific directory

$targetDir = 'images/';
$targetFile = $targetDir . basename($_FILES['image']['name']);
move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);

//Insert the product data intro database
$productID = generateUniqueID();
$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];
$image = basename($_FILES['image']['name']);

$sql = "INSERT INTO products (id, name, description, price,image) VALUES ( '$productID', '$name', '$description', '$price', '$image')";

if($conn->query($sql) === TRUE ){
    //PRODUCT added successfully
}else{
    //Error adding product
}

$conn->close();

//Redirect back to the index page
header('Location: index.php');

exit;
?>